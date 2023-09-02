<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AudioEpisode extends Model
{
    use SoftDeletes;
    use HasFactory;
    use Translatable;

    public $fillable = [
        'audio_id',
        'duration',
        'sequence',
        'status',
        'created_by',
        'updated_by',
    ];

    protected $dates = ['deleted_at'];

    protected $hidden = [
        'deleted_at'
    ];

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
        'chapters' => 'input',
        'verses'   => 'input',
    ];

    public function audioEpisodeTranslations()
    {
        return $this->hasMany(AudioEpisodeTranslation::class);
    }
}
