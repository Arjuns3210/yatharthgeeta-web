<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Astrotomic\Translatable\Translatable;


class location extends Model
{
    use SoftDeletes;
    use HasFactory;
    use Translatable;

    public $fillable = [
        'type',
        'contact_numbers',
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
        'status' => 'boolean'
    ];

    public $translatedAttributes = ['name', 'short_description', 'long_description', 'allowed_in_location','not_allowed_in_location'];

    const IMAGE= 'image';
    
    public const TRANSLATED_BLOCK = [
        'name' => 'input',
        'short-description' => 'input',
        'long-description' => 'textarea',
        'allowed-in-location' => 'textarea',
        'not-allowed-in-location' => 'textarea',
    ];
    public function locationTranslations()
    {
        return $this->hasMany(\App\Models\LocationTranslation::class);
    }
}
