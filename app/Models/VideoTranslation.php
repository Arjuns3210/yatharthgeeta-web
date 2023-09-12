<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoTranslation extends Model
{
    use HasFactory;
    public $timestamps = false;

    public $fillable = [
        'video_id',
        'title',
        'description',
        'narrator_id',
        'status'

    ];
    public function video()
    {
        return $this->belongsTo(\App\Models\Video::class);
    }
}

