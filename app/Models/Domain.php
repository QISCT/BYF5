<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Castable;
use App\Casts\Domains as DomainsCast;
use Illuminate\Contracts\Support\Htmlable;

class Domain implements Castable, Htmlable
{
    public $name;
    public $cat;

    /**
     * The View Factory to create the Html string
     *
     * @var \Illuminate\Contracts\View\Factory
     */
    protected static $viewFactory;

    /**
     * Domain constructor.
     * @param array $arguments
     */
    public function __construct(array $arguments)
    {
        ['cat' => $this->cat, 'name' => $this->name] = $arguments;
    }


    /**
     * Get the name of the caster class to use when casting from / to this cast target.
     * @param  array  $arguments
     * @return string
     */
    public static function castUsing(array $arguments) : string
    {
        return DomainsCast::class;
    }

    /**
     * Get content as a string of HTML.
     *
     * @return string
     */
    public function toHtml()
    {
        if (!static::$viewFactory) {
            static::$viewFactory = view();
        }

        return static::$viewFactory->make('inc.render.domain')->with('domain', $this)->render();
    }

    /**
     * Convert the model to its string representation.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toHtml();
    }
}
