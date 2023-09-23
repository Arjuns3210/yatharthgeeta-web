<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AudioEpisodeTranslation extends Model
{

    public $timestamps = false;

    public $fillable = [
        'audio_episode_id',
        'locale',
        'chapter_name',
        'verses_name',
        'chapter_number',
        'verses_number',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'audio_id' => 'integer',
        'locale' => 'string',
        'title' => 'string',
        'verses' => 'string',
        'chapters' => 'string',
    ];

    public function audioEpisode()
    {
        return $this->belongsTo(AudioEpisode::class);
    }
}
