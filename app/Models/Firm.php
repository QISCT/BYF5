<?php

namespace App\Models;

use App\Traits\HasSchema;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Firm
 * @package App
 */
class Firm extends Model
{
    use HasSchema;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'firms';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['edit_route'];


    static $TYPES = ['Professional', 'Platinum', 'Email', 'File Sharing', 'BizPayO', 'Test'];

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
     * Get the sites owned by this firm.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sites()
    {
        return $this->hasMany('App\Models\Site');
    }

    /**
     * Get the offices owned by this firm.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function offices()
    {
        return $this->hasMany('App\Models\Office');
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
     * Get the route to view this firm.
     * @return string
     */
    public function getViewRouteAttribute() : string
    {
        return route('firms.show', $this);
    }

    /**
     * Get the route to edit this firm.
     * @return string
     */
    public function getEditRouteAttribute() : string
    {
        return route('firms.edit', $this);
    }

    /**
     * Get the route to see the firm's sites.
     * @return string
     */
    public function getSitesRouteAttribute() : string
    {
        return route('firms.sites.index', $this);
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
