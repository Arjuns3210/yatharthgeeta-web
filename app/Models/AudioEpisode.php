<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class AudioEpisode extends Model implements HasMedia
{
    use SoftDeletes;
    use HasFactory;
    use Translatable,InteractsWithMedia;

    public $fillable = [
        'audio_id',
        'duration',
        'sequence',
        'file_name',
        'srt_file_name',
        'status',
        'created_by',
        'updated_by',
    ];

    protected $dates = ['deleted_at'];

    protected $hidden = [
        'deleted_at'
    ];

    const EPISODE_AUDIO_FILE = 'audio_file';
    const EPISODE_AUDIO_SRT_FILE = 'audio_srt_file';

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'status' => 'boolean'
    ];

    public $translatedAttributes = ['title', 'chapters', 'verses'];

    public const TRANSLATED_BLOCK = [
        'title'    => 'input',
        'chapter_name' => 'input',
        'chapter_number'   => 'input',
        'verses_name'   => 'input',
        'verses_number'   => 'input',
    ];

    public function audioEpisodeTranslations()
    {
        return $this->hasMany(AudioEpisodeTranslation::class);
    }
}
