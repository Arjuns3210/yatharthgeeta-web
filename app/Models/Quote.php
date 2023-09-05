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
        'image',
        'sequence',
		'status',
		'share_allowance',
		'shlok'
		
    ];
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'image'=>'string',
		'sequence'=>'integer',
		'shlok' => 'array',

    ];

    public static $rules = [
        'text.*' => 'string|required',
        'description.*' => 'string|required',
        'image.*' => 'longText|required',
        'sequence' => 'integer|required'
    ];

    const IMAGE= 'image';


}
