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
        'status',
        'sequence'

    ];

    public $translatedAttributes = ['name', 'highlight_descrption', 'description'];

    public const TRANSLATED_BLOCK = [
	    'name' => 'input',
        'highlight_descrption' => 'textarea',
	    'description' => 'textarea'

	];

    const COVER_IMAGE= 'cover_image';

    public function bookTranslations()
    {
        return $this->hasMany(\App\Models\BookTranslation::class);
    }
}
