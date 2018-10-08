<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Baum\Node;
use Illuminate\Database\Eloquent\Model;
use Stevebauman\Inventory\Traits\CategoryTrait;

class Category extends Node
{
    use CrudTrait;

     /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'categories';
    //protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = [
        'id',
        'name',
        'parent_id',
        'lft',
        'rgt',
        'depth',
        'created_at',
        'updated_at',
    ];
    // protected $hidden = [];
    // protected $dates = [];
    
    protected $scoped = ['belongs_to'];

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
    public function inventories()
    {
        return $this->hasMany('Inventory', 'category_id');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
