<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Video extends Model
{
    use SoftDeletes;
    use HasFactory;
    use Translatable;

    public $fillable = [
        'cover_image',
        'views',
        'status',
        'sequence'

    ];

    public $translatedAttributes = ['title', 'description'];

    public const TRANSLATED_BLOCK = [
	    'title' => 'input',
	    'description' => 'textarea'
	];

    const COVER_IMAGE= 'cover_image';

    public function VideoTranslation()
    {
        return $this->hasMany(\App\Models\VideoTranslation::class);
    }
}
