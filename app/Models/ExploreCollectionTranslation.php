<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExploreCollectionTranslation extends Model
{

    public $timestamps = false;

    public $fillable = [
        'explore_collection_id',
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
        'explore_collection_id' => 'integer',
        'locale' => 'string',
        'title' => 'string',
        'description' => 'string'
    ];
    

}
