<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventTranslation extends Model
{
    use HasFactory;
    public $fillable = [
        'event_id',
        'title',
        'short_description',
        'long_description'

    ];
    public function event()
    {
        return $this->belongsTo(\App\Models\Event::class);
    }
}
