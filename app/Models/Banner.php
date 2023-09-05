<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model implements HasMedia
{
    use HasFactory,InteractsWithMedia, SoftDeletes;
    protected $fillable = [
        'title',
        'cover',
        'sequence',
        'status'
    ];
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'title'=>'string',
        'cover'=>'string',
        'sequence'=>'integer',
        'status' => 'boolean'
    ];

    public static $rules = [
        'title.*' => 'string|required',
        'cover.*' => 'longText|required',
        'sequence.*' => 'integer|required',
        'status' => 'boolean'
    ];

    const COVER= 'cover';
}
