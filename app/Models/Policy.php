<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Astrotomic\Translatable\Translatable;

class Policy extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Translatable;

    protected $fillable = [
        'type'
    ];

    public $translatedAttributes = ['content'];

    public const TRANSLATED_BLOCK = [
        'content' => 'input',
    ];
    public function policyTranslations()
    {
        return $this->hasMany(\App\Models\PolicyTranslation::class);
    }

}
