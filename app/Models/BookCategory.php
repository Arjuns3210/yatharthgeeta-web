<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Astrotomic\Translatable\Translatable;

class BookCategory extends Model
{
    use SoftDeletes;
    use HasFactory;
    use Translatable;

    public $fillable = [
        'status'
    ];

    protected $dates = ['deleted_at'];

    protected $hidden = [
        'deleted_at'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'status' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name.*' => 'string|required',
        'title.*' => 'string|required',
        'subtitle.*' => 'string|required',
        'description.*' => 'string|required',
        'status' => 'boolean'
    ];

    public $translatedAttributes = ['name'];

    public const TRANSLATED_BLOCK = [
    	'name' => 'input'
	];

    public function bookCategoryTranslations()
    {
        return $this->hasMany(\App\Models\BookCategoryTranslation::class);
    }
}
