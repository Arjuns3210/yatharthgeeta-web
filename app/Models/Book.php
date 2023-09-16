<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model implements HasMedia

{
    use SoftDeletes;
    use HasFactory;
    use Translatable;
    use InteractsWithMedia;

    public $fillable = [
        'book_category_id',
        'cover_image',
        'pdf_file_name',
        'epub_file_name',
        'artist_id',
        'pages',
        'language_id',
        'audio_id',
        'video_id',
        'related_id',
        'link',
        'status',
        'sequence'

    ];

    public $translatedAttributes = ['name', 'short_description', 'description'];

    public const TRANSLATED_BLOCK = [
	    'name' => 'input',
        'short_description'=>'textarea',
	    'description' => 'textarea'

	];


    const COVER_IMAGE= 'cover_image';
    const PDF_FILE = 'pdf_file';
    const EPUB_FILE = 'epub_file';

    protected $attributes = [
        'book_category_id' => 1
    ];

    public function bookTranslations()
    {
        return $this->hasMany(\App\Models\BookTranslation::class);
    }

    public function category()
    {
        return $this->belongsTo(BookCategory::class);
    }

    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
    public function audio()
    {
        return $this->belongsTo(Audio::class);
    }
    public function video()
    {
        return $this->belongsTo(Video::class);
    }

}
