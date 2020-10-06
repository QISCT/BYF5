<?php

namespace App\Models;

use App\Traits\HasSchema;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Page
 * @package App
 */
class Page extends Model
{
    use HasSchema;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
    protected $table = 'pages';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];


    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    /**
     * Get the site this page belongs to.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function site()
    {
        return $this->belongsTo('App\Models\Site');
    }

    /**
     * Get the page that appears above this page if it exists
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo('App\Models\Page', $this->primaryKey, 'parent_id');
    }

    /**
     * Get the pages that appear under this page
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany('App\Models\Page', 'parent_id');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /**
     * Get the url to design this page
     * @return string|null
     */
    public function getDesignRouteAttribute()
    {
        if($this->getKey())
            return route('app.page.design', $this->getKey());
        else
            return null;
    }

    /**
     * Does this page have children pages
     *
     * @return bool
     */
    public function getHasChildrenAttribute()
    {
        return ($this->children->count() > 0);
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
