<?php

namespace App\Models;

use App\Casts\Contacts;
use App\Casts\Domains;
use App\Traits\HasSchema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Class Site
 * @package App
 */
class Site extends Model
{
    use HasSchema;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'sites';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'domains' => Domains::class,
        'contacts' => Contacts::class,
    ];

    static $STATUS_CODES = ['10' => 'Wizard', '20' => 'In Development', '38' => 'Client Hold', '50' => 'Site Live', '60' => 'Site Complete', '70' => 'Site Copied', '90' => 'Test Site Only', '91' => 'Non-Billable', '92' => 'FTP Only', '94' => 'Email Only', '95' => 'Archive (remove from WHM only)', '96' => 'Hosted elsewhere', '97' => 'Suspended', '98' => 'Make inactive', '99' => 'Dead Site (Remove completely)',];


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
     * Get the firm that owns this site.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function firm()
    {
        return $this->belongsTo('App\Models\Firm');
    }

    /**
     * Get the pages owned by this site.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pages()
    {
        return $this->hasMany('App\Models\Page')->orderBy('index');
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
        return route('sites.show', $this);
    }

    /**
     * Get the route to edit this firm.
     * @return string
     */
    public function getEditRouteAttribute() : string
    {
        return route('sites.edit', $this);
    }

    /**
     * Get the Primary Domain.
     * @return Collection|null
     */
    public function getPrimaryDomainAttribute()
    {
        return collect($this->domains)->where('cat', 'primary')->first()->name ?? null;
    }

    /**
     * Get the pages owned by this site which have no parents.
     * @return Collection|null
     */
    public function getParentPagesAttribute()
    {
        return $this->pages->whereNull('parent_id');
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
