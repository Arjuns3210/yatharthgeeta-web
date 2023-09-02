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
        'views',
        'duration',
        'status',
        'sequence'

    ];

    public $translatedAttributes = ['title', 'link', 'description'];

    public const TRANSLATED_BLOCK = [
	    'title' => 'input',
        'link'=>'input',
	    'description' => 'textarea'
        
	];

    const COVER_IMAGE= 'cover_image';

    public function VideoTranslations()
    {
        return $this->hasMany(\App\Models\VideoTranslation::class);
    }
}
