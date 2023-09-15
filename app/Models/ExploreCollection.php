<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class ExploreCollection extends Model implements HasMedia
{
    use SoftDeletes;
    use HasFactory;
    use InteractsWithMedia,Translatable;

    public $table = 'explore_collections';

    public $fillable = [
        'type',
        'mapped_ids',
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


    const BOOK = 'Book';
    const AUDIO = 'Audio';
    const QUOTES = 'Quote';
    const MANTRA = 'Mantra';

    const EXPLORE_COLLECTION_TYPES = [
        self::BOOK     => 'Book',
        self::AUDIO    => 'Pravachan',
        self::QUOTES    => 'Quote',
        self::MANTRA    => 'Mantra',
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
}
