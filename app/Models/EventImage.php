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
        'event_id',
        'status'
    ];
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'status' => 'boolean'
    ];

    public static $rules = [
        'images.*' => 'required',
        'status' => 'boolean'
    ];

    const IMAGE = 'image';
}
