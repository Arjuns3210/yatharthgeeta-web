<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class HomeCollectionMapping extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    public $table = 'home_collection_mappings';
    public $fillable = [
        'title',
        'home_collection_id',
        'mapped_ids',
        'sequence',
        'is_clickable',
        'mapped_to',
    ];
    
    const MULTIPLE_COLLECTION_IMAGE = 'multiple_collection_image';
    
    const BOOK = 'Book';
    const AUDIO = 'Audio';
    const VIDEO = 'Video';
    const SHLOK = 'Shlok';
    const ARTIST = 'Artist';

    const MAPPING_COLLECTION_TYPES = [
        self::BOOK     => 'Book',
        self::AUDIO    => 'Audio',
        self::VIDEO    => 'Video',
        self::SHLOK    => 'Shlok',
        self::ARTIST   => 'Artist',
    ];
}
