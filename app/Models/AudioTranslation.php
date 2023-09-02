<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AudioTranslation extends Model
{
    use HasFactory;

    public $timestamps = false;

    public $fillable = [
        'audio_id',
        'locale',
        'title',
        'description',
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
        'description' => 'string'
    ];

    public function audio()
    {
        return $this->belongsTo(AudioTranslation::class);
    }
}
