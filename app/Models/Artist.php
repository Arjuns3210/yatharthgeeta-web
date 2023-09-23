<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\InteractsWithMedia;
use Astrotomic\Translatable\Translatable;


class Artist extends Model implements HasMedia
{
    use SoftDeletes;
    use HasFactory;
    use Translatable;
    use InteractsWithMedia;

    public $fillable = [
        'image',
        'status',
        'sequence',
        'visible_on_app'
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

    ];

    public $translatedAttributes = ['name', 'title', 'description'];

    const IMAGE= 'image';

    public const TRANSLATED_BLOCK = [
        'name' => 'input',
        'title' => 'input',
        'description' => 'textarea',
    ];
    public function artistTranslations()
    {
        return $this->hasMany(\App\Models\ArtistTranslation::class);
    }
}
