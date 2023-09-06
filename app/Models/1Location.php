<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\InteractsWithMedia;
use Astrotomic\Translatable\Translatable;


class Location extends Model implements HasMedia
{
    use SoftDeletes;
    use HasFactory;
    use Translatable;
    use InteractsWithMedia;

    public $fillable = [
        'type',
        'phone',
        'email',
        'image',
        'days',
        'location',
        'latitude',
        'longitude',
        'google_address',
        'visible_on_app',
    ];

    protected $dates = ['deleted_at'];

    protected $hidden = [
        'deleted_at'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'status' => 'boolean',
        'phone' => 'json'

    ];

    public $translatedAttributes = ['name', 'title', 'description', 'do','dont'];

    const IMAGE= 'image';

    public const TRANSLATED_BLOCK = [
        'name' => 'input',
        'title' => 'input',
        'description' => 'textarea',
        'do' => 'textarea',
        'dont' => 'textarea',
    ];
    public function locationTranslations()
    {
        return $this->hasMany(\App\Models\LocationTranslation::class);
    }
}
