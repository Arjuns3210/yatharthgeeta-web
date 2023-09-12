<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArtistTranslation extends Model
{
    use HasFactory;

    public $fillable = [
        'name',
        'artist_id',
        'locale',
        'title',
        'description',
    ];
    public function guru()
    {
        return $this->belongsTo(App\Models\Artist::class);
    }
}
