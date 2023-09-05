<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookTranslation extends Model
{
    use HasFactory;
    public $fillable = [
        'books_id',
        'Name',
        'description',
        'status'

    ];
    public function Book()
    {
        return $this->belongsTo(\App\Models\Book::class);
    }
}
