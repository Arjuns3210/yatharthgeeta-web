<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Audio extends Model implements HasMedia
{
    use SoftDeletes;
    use HasFactory;
    use Translatable,InteractsWithMedia;

    public $table = 'audios';
    
    public $fillable = [
        'audio_category_id',
        'cover_image',
        'file_name',
        'srt_file_name',
        'has_episodes',
        'people_also_read_ids',
        'duration',
        'language_id',
        'author_id',
        'sequence',
        'narrator_id',
        'views',
        'status',
        'created_by',
        'updated_by',
    ];

    protected $dates = ['deleted_at'];

    protected $hidden = [
        'deleted_at'
    ];

    const AUDIO_FILE = 'audio_file';
    const AUDIO_COVER_IMAGE = 'audio_cover_image';
    const AUDIO_SRT_FILE = 'audio_srt_file';
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'status' => 'boolean'
    ];
    

    public $translatedAttributes = ['title', 'description'];

    public const TRANSLATED_BLOCK = [
        'title' => 'input',
        'description' => 'textarea'
    ];

    public function audioTranslations()
    {
        return $this->hasMany(AudioTranslation::class);
    }
    
    public function episodes()
    {
     
        return $this->hasMany(AudioEpisode::class);
    }

    function audioCategory()
    {
        return $this->belongsTo(AudioCategory::class);
    }
}
