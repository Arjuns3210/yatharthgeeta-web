<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quote extends Model implements HasMedia
{
    use HasFactory,InteractsWithMedia,SoftDeletes;
    protected $fillable = [
        'title',
        'image',
        'sequence',
		'status',
		'quote_category_id',
        'image',
        'language_id'

    ];
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'image'=>'string',
        'sequence'=>'integer',
        'status' => 'boolean'

    ];

    public static $rules = [
        'image.*' => 'longText|required',
        'sequence' => 'integer|required',
        'status' => 'boolean'
    ];

    const IMAGE= 'image';
    
}
