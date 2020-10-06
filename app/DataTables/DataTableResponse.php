<?php

namespace App\DataTables;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Date;
use stdClass;

class DataTableResponse implements Arrayable, Jsonable
{
    protected Collection $columns;
    protected Collection $order;
    protected int $page;
    protected int $pageLength;
    protected $items;
    protected int $total;
    protected int $filtered;
    protected Collection $rows;
    private array $options;

    public function __construct($query, $_settings)
    {
        $this->columns = collect($_settings["columns"]);
        $this->order = collect($_settings["order"]);
        $this->page = $_settings['start'] / $_settings['length'] + 1;
        $this->pageLength = $_settings['length'];
        $this->items = $this->query($query);
        $this->total = $this->items->count();
        $this->options = [];
        $this->rows = collect([]);
        $this->run();
    }

//	protected function assign($items)
//	{
//		DB::connection()->enableQueryLog();
//		$this->rows = $items->map(function ($item) {
//			return new DataTableRow($item, collect($this->columns));
//		});
//		dd(DB::getQueryLog());
//	}

    protected function query($query)
    {
        if(!is_string($query))
            return $query;

        $with = collect([]);
        $with_trashed = false;
        foreach($this->columns as $column){
            if($column['data'] == 'deleted_at' && $column['search']['value']) {
                $with_trashed = true;
            }
            if(strpos($column['data'], '-') !== false) {
                $parts = collect(explode('-', $column['data']));
                $parts->pop();
                $with->push($parts->join('.'));
            }
            if(array_key_exists('href', $column) && strpos($column['data'], '-') !== false) {
                $parts = collect(explode('-', $column['data']));
                $parts->pop();
                $with->push($parts->join('.'));
            }
        }

        $query = $query::with($with->unique()->values()->all());
        if($with_trashed)
            $query = $query->withTrashed();
        return $query->get();
    }

    protected function run()
    {
        ini_set('memory_limit', '512M');
        $this->selectable();
        $this->search();
        $this->sort();
        $this->paginate();
        $this->build();
    }

    /**
     * Foreach column with a select, get all possible unique values
     */
    protected function selectable()
    {
        for ($i = 0; $i < $this->columns->count(); $i++) {
            $col = $this->columns[$i];
            if ($col['selectable'] === "false")
                continue;
            $this->options[$i] = [
                'options' => $this->items->map(fn ($value) => $this->getThroughModel($col['data'], $value))->unique()->sort()->values()->all(),
                'value' => $col['search']['value'],
            ];
        }
    }

    /**
     * Foreach model create a table row and foreach column create a cell in that row
     * @throws \Throwable
     */
    protected function build()
    {
        foreach ($this->items as $index => $item) {
            $row = collect(['id' => $item->id]);
            foreach ($this->columns as $col) {
                // If no type for this column is specified, assume it is a string.
                if (!array_key_exists('type', $col)) {
                    $col['type'] = "string";
                }
                switch (strtolower($col['type'])) {
                    case "string":
                    case "number":
                        $row[$col['data']] = $this->getThroughModel($col['data'], $item);
                        break;
                    case "datetime":
                        $row[$col['data']] = $this->getThroughModel($col['data'], $item)->format('Y-m-d');
                        break;
                    case "btn":
                        $value = "<a href=\"{$this->getThroughModel($col['data'], $item)}\" ";
                        $value .= "class=\"{$col['classes']}\">";
                        $value .= $col['icon'] . " " . $col['text'];
                        $value .= "</a>";
                        $row[$col['data']] = $value;
                        break;
                    case "link":
                        $value = "<a href=\"{$this->getThroughModel($col['href'], $item)}\">";
                        $value .= $this->getThroughModel($col['data'], $item);
                        $value .= "</a>";
                        $row[$col['data']] = $value;
                        break;
                    case "count":
                        $value = '<span class="badge badge-mw badge-dark">';
                        $value .= $this->getThroughModel($col['data'], $item)->count();
                        $value .= '</span>';
                        $row[$col['data']] = $value;
                        break;
                    case "badge":
                        $value = '<span class="badge badge-mw badge-' . $this->getThroughModel($col['badge'], $item) . '">';
                        $value .= $this->getThroughModel($col['data'], $item);
                        $value .= '</span>';
                        $row[$col['data']] = $value;
                        break;
                    case "list":
                        $value = '';
                        foreach ($this->getThroughModel($col['data'], $item) as $li)
                            $value .= trim($li->{$col['key']} ?? null) . '<br />';
                        $row[$col['data']] = $value;
                        break;
                    case "bool":
                        $row[$col['data']] = $this->getThroughModel($col['data'], $item) ? 'Yes' : 'No';
                        break;
                }
                // add active or inactive badges
                if ($col['data'] === 'active' || $col['data'] === 'deleted_at') {
                    $value = $this->getThroughModel($col['data'], $item) == '1' ? '<span class="badge badge-success">Active' : '<span class="badge badge-danger">Inactive';
                    $value .= '</span>';
                    $row[$col['data']] = $value;
                }
                // displays view / download buttons if passed a file
                if ($col['data'] === 'template') {
                    if ($item->file) { // check file exist
                        $row[$col['data']] = view('include.portal.file-btns', ['id' => $item->file->id])->render();
                    }
                }
            }
            $this->addRow($row);
        }
    }


    /**
     * Safely access an attribute (possibly embed attribute) of a model.
     *
     * @param $accessors
     * @param $model
     * @return mixed
     */
    protected function getThroughModel($accessors, $model)
    {
        if ($accessors == 'ignore')
            return null;
        foreach (explode('-', $accessors) as $accessor) {
            $model = $model->{$accessor} ?? null;
        }
        return $model;
    }

    /**
     * Append a row to the end of the rows collection.
     *
     * @param Collection $row
     * @return Collection
     */
    public function addRow(Collection $row)
    {
        return $this->rows->push($row);
    }

    /**
     * Converts this DataTableResponse to json {@see Jsonable}.
     *
     * @param  int  $options
     * @return string
     */
    public function toJSON($options = 0)
    {
        $response = new stdClass();
        $response->data = [];
        foreach ($this->rows as $row) {
            $json = new stdClass();
            $i = -1;// Starts at -1 to include the id column
            foreach ($row as $key => $cell) {
                $col = $this->columns[$i] ?? [];
                if(array_key_exists('format', $col))
                    $cell = $cell->format;
                $json->{$key} = $cell;
                $i++;
            }
            array_push($response->data, $json);
        }
        $response->recordsFiltered = $this->filtered;
        $response->recordsTotal = $this->total;
        $response->options = $this->options;
        return json_encode($response);
    }

    static function emptyJSON()
    {
        $response = new stdClass();
        $response->data = [];
        $response->recordsFiltered = 0;
        $response->recordsTotal = 0;
        $response->options = [];
        return json_encode($response);
    }

    /**
     * Converts this DataTableResponse to array {@see Arrayable}.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'data' => $this->rows->toArray(),
            'recordsFiltered' => $this->filtered,
            'recordsTotal' => $this->total,
            'options' => $this->options,
        ];
    }

    /**
     * Paginate models as requested (after they are sorted)
     */
    protected function paginate()
    {
        $this->filtered = $this->items->count();
        $this->items = $this->items->forPage($this->page, $this->pageLength)->values();
    }

    /**
     * Sort models by order requested (uses cell values before being rendered)
     * @TODO add support for more than one column sorting
     */
    protected function sort()
    {
        $sorted = $this->items;
        switch ($this->order->count()) {
            case 0:
                break;
            default:
                $column = $this->columns[$this->order[0]['column']];
                if ($column['type'] == "count" || $column['type'] == "number") {
                    $sorted = collect($sorted->sortBy(fn ($item) => $this->getThroughModel($column['data'], $item))->values());
                } else {
                    $sorted = collect($sorted->sortBy(fn ($item) => $this->getThroughModel($column['data'], $item), SORT_NATURAL | SORT_FLAG_CASE)->values());
                }
                if ($this->order[0]['dir'] == "desc")
                    $sorted = collect($sorted->reverse()->values());
                break;
        }
        $this->items = $sorted;
    }

    /**
     * Filter Models by requested filters
     */
    protected function search()
    {
        $filters = collect([]);
        foreach ($this->columns as $column) {
            if ($column['search']['value'] === null)
                continue;
            if ($column['searchable'] === "false")
                continue;
            if ($column['name'] === "deleted_at")
                continue;
            $filters->push(["data" => $column['data'], "value" => $column['search']['value'], "type" => $column['type']]);
        }

        $this->items = $this->items->filter(function ($model) use ($filters) {
            $passed = true;

            foreach ($filters as $filter) {
                $value = $this->getThroughModel($filter['data'], $model);

                if (strpos($filter['value'], '|') !== false) {
                    if (!$this->substr_in_array($value, explode('|', $filter['value'])))
                        $passed = false;
                } elseif (in_array($filter['type'], ['datetime', 'count']) && strpos($filter['value'], '-') !== false) {
                    $dates = explode('-', $filter['value']);
                    $date_start = Date::parse($dates[0]);
                    $date_val = Date::parse($value);
                    $date_end = Date::parse($dates[1])->addDay();
                    if ($date_start > $date_val || $date_end < $date_val)
                        $passed = false;
                } else {
                    if (strpos($filter['value'], '!nn!') !== false) {
                        if ($value == null)
                            $passed = false;
                    }
                    elseif (strpos($filter['value'], '!n!') !== false) {
                        if ($value !== null)
                            $passed = false;
                    }
                    elseif (strpos($filter['value'], '*') !== false) {
                    }
                    else {
                        if (strpos(strtolower($value), strtolower($filter['value'])) === false && strtolower(trim($value)) != strtolower(trim($filter['value'])))
                            $passed = false;
                    }
                }
            }

            return $passed;
        });
    }

    /**
     * Is there a substring in any string of an array
     *
     * @param string $needle
     * @param array $haystack
     * @return bool
     */
    function substr_in_array(string $needle, array $haystack)
    {
        foreach ($haystack as $key => $item) {
            if (strpos(strtolower($needle), strtolower($item)) !== false)
                return true;

            if (strtolower(trim($item)) == strtolower(trim($needle)))
                return true;
        }
        return false;
    }
}
