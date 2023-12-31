<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookTranslation extends Model
{
    use HasFactory;

    public $timestamps = false;

    public $fillable = [
        'book_id',
        'name',
        'short_description',
        'description',
        'status'

    ];
    public function books()
    {
        return $this->belongsTo(\App\Models\Book::class);
    }
}
