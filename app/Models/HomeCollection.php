<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeCollection extends Model
{
    use HasFactory;
    
    const SINGLE = 'single';
    const MULTIPLE = 'multiple';
    const BOOKS = 'books';
    const AUDIOS = 'audios';
    const VIDEOS = 'videos';
    const SHLOKS = 'shloks';

    const COLLECTION_TYPES = [
        self::SINGLE   => 'Single',
        self::MULTIPLE => 'Multiple',
        self::BOOKS    => 'Books',
        self::AUDIOS   => 'Audios',
        self::VIDEOS   => 'Videos',
        self::SHLOKS   => 'Shloks',
    ];
    
    const HORIZONTAL = 'horizontal';
    const VERTICAL = 'vertical';

    const ORIENTATION_TYPE = [
        self::HORIZONTAL => 'horizontal',
        self::VERTICAL   => 'vertical',
    ];
}
