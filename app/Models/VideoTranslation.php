<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoTranslation extends Model
{
    use HasFactory;
    public $fillable = [
        'video_id',
        'title',
        'duration',
        'link',
        'description',
        'narrator_id',
        'status'

    ];
    public function Video()
    {
        return $this->belongsTo(\App\Models\Video::class);
    }
}

