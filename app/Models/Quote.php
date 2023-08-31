<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Quote extends Model implements HasMedia
{
    use HasFactory,InteractsWithMedia;
    protected $fillable = [
        'text',
        'description',
        'image',
        'sequence'
    ];
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'text'=>'string',
        'description'=>'string',
        'image'=>'string',
		'sequence'=>'integer'

    ];

    public static $rules = [
        'text.*' => 'string|required',
        'description.*' => 'string|required',
        'image.*' => 'longText|required',
        'sequence' => 'integer|required'
    ];

    const IMAGE= 'image';


}
