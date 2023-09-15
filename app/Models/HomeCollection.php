<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class HomeCollection extends Model implements HasMedia
{
    use SoftDeletes;
    use HasFactory;
    use InteractsWithMedia,Translatable;

    public $table = 'home_collections';

    public $fillable = [
        'type',
        'sequence',
        'is_scrollable',
        'display_in_column',
        'status',
        'created_by',
        'updated_by',
    ];

    protected $dates = ['deleted_at'];

    protected $hidden = [
        'deleted_at'
    ];

    const SINGLE_COLLECTION_IMAGE = 'single_collection_image';
    
    const SINGLE = 'Single';
    const MULTIPLE = 'Multiple';
    const BOOK = 'Book';
    const AUDIO = 'Audio';
    const VIDEO = 'Video';
    const SHLOK = 'Shlok';
    const ARTIST = 'Artist';

    const COLLECTION_TYPES = [
        self::SINGLE   => 'Single',
        self::MULTIPLE => 'Multiple',
        self::BOOK     => 'Book',
        self::AUDIO    => 'Audio',
        self::VIDEO    => 'Video',
        self::SHLOK    => 'Shlok',
        self::ARTIST   => 'Guru',
    ];

    const DISPLAY_IN_COLUMN = [
        1,
        2,
        3,
        4,
    ];
    public $translatedAttributes = ['title', 'description'];
    public const TRANSLATED_BLOCK = [
        'title' => 'input',
        'description' => 'textarea'
    ];
    
    function language()
    {

        return $this->belongsTo(Language::class);
    }

    function homeCollectionDetails()
    {

        return $this->hasMany(HomeCollectionMapping::class, 'home_collection_id');
    }
}
