<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model implements HasMedia
{
    use SoftDeletes;
    use HasFactory;
    use Translatable;
    use InteractsWithMedia;
    public $fillable = [
        'cover',
        'event_start_date',
        'event_end_date',
        'event_start_time',
        'event_end_time',
        'location_id',
        'artist_id',
        'event_visible_date',
        'sequence',
        'status'

    ];

    public $translatedAttributes = ['title', 'short_description', 'long_description'];

    public const TRANSLATED_BLOCK = [
	    'title' => 'input',
	    'short_description' => 'textarea',
	    'long_description' => 'textarea'

	];

    const COVER= 'cover';

    public function eventTranslations()
    {
        return $this->hasMany(\App\Models\EventTranslation::class);
    }
}
