<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Astrotomic\Translatable\Translatable;

class QuoteCategory extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Translatable;

    protected $fillable = [
        'status',
        'sequence'
    ];

    protected $casts = [
        'status'=>'boolean'
    ];

    public $translatedAttributes = ['name'];

    public const TRANSLATED_BLOCK = [
        'name' => 'input',
    ];
    public function quoteCategoryTranslations()
    {
        return $this->hasMany(\App\Models\QuoteCategoryTranslation::class);
    }
}
