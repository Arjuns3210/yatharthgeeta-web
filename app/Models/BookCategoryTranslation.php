<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookCategoryTranslation extends Model
{
    use HasFactory;

    public $timestamps = false;

    public $fillable = [
        'book_category_id',
        'locale',
        'name',
        'subtitle',
        'description'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'book_category_id' => 'integer',
        'locale' => 'string',
        'name' => 'string',
        'title' => 'string',
        'subtitle' => 'string',
        'description' => 'string'
    ];

    public function bookCategory()
    {
        return $this->belongsTo(\PlanetPortal\Models\BookCategory::class);
    }
}
