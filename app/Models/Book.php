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
        'cover_image',
        'number_of_pages',
        'link',
        'status',
        'sequence'

    ];

    public $translatedAttributes = ['name', 'description'];

    public const TRANSLATED_BLOCK = [
	    'name' => 'input',
	    'description' => 'textarea'

	];

    const COVER_IMAGE= 'cover_image';

    public function BookTranslations()
    {
        return $this->hasMany(\App\Models\BookTranslation::class);
    }
}
