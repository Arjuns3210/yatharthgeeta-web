<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shlok extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, SoftDeletes;

    protected $fillable = [
        'background_image',
        'sequence',
		'share_allowance',
		'shlok',
		'status',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'background_image'=>'string',
		'sequence'=>'integer'

    ];

    public static $rules = [
        'text.*' => 'string|required',
        'description.*' => 'string|required',
        'image.*' => 'string|required',
        'sequence' => 'integer|required'
    ];
}
