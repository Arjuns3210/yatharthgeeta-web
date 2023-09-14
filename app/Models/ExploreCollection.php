<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class ExploreCollection extends Model implements HasMedia
{
    use SoftDeletes;
    use HasFactory;
    use InteractsWithMedia;

    public $table = 'explore_collections';

    public $fillable = [
        'title',
        'description',
        'type',
        'mapped_ids',
        'sequence',
        'is_scrollable',
        'display_in_column',
        'language_id',
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

    function language()
    {

        return $this->belongsTo(Language::class);
    }
}
