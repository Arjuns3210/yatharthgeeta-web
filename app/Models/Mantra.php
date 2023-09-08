<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mantra extends Model
{
    use HasFactory;
    use Translatable;
    public $fillable = [
        'sanskrit_title',
        'sequence',
        'status'
    ];

    public $translatedAttributes = ['title', 'description'];

    public const TRANSLATED_BLOCK = [
	    'title' => 'input',
	    'description' => 'textarea'

	];

    public function mantraTranslations()
    {
        return $this->hasMany(\App\Models\MantraTranslation::class);
    }
}
