<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class HomeCollection extends Model implements HasMedia
{
    use SoftDeletes;
    use HasFactory;
    use InteractsWithMedia;

    public $table = 'home_collections';

    public $fillable = [
        'title',
        'description',
        'type',
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

    function language()
    {

        return $this->belongsTo(Language::class);
    }

    function homeCollectionDetails()
    {

        return $this->hasMany(HomeCollectionMapping::class, 'home_collection_id');
    }
}
