<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookTranslation extends Model
{
    use HasFactory;
    public $fillable = [
        'book_id',
        'name',
        'highlight_descrption',
        'description',
        'status'

    ];
    public function books()
    {
        return $this->belongsTo(\App\Models\Book::class);
    }
}
