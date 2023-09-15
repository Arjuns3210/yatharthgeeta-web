<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeCollectionTranslation extends Model
{

    public $timestamps = false;

    public $fillable = [
        'home_collection_id',
        'locale',
        'title',
        'description',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'home_collection_id' => 'integer',
        'locale' => 'string',
        'title' => 'string',
        'description' => 'string'
    ];
    
}
