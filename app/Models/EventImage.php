<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventImage extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, SoftDeletes;
    protected $fillable = [
        'title',
        'event_id',
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
        'sequence'=>'integer',
        'status' => 'boolean'
    ];

    public static $rules = [
        'title.*' => 'string|required',
        'images.*' => 'required',
        'sequence.*' => 'integer|required',
        'status' => 'boolean'
    ];

    const IMAGE = 'image';
}
