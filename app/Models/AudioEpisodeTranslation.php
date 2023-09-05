<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AudioEpisodeTranslation extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    public $fillable = [
        'audio_episode_id',
        'locale',
        'title',
        'chapters',
        'verses',
        'status',
        'created_by',
        'updated_by',
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
