<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Video extends Model implements HasMedia

{
    use SoftDeletes;
    use HasFactory;
    use Translatable;
    use InteractsWithMedia;

    public $fillable = [
        'cover_image',
        'language_id',
        'artist_id',
        'video_category_id',
        'views',
        'duration',
        'link',
        'status',
        'sequence'

    ];

    public $translatedAttributes = ['title', 'description'];

    public const TRANSLATED_BLOCK = [
	    'title' => 'input',
	    'description' => 'textarea'

	];
    protected $attributes = [
        'video_category_id' => 1
    ];

    const COVER_IMAGE= 'cover_image';

    public function videoTranslations()
    {
        return $this->hasMany(\App\Models\VideoTranslation::class);
    }
    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
