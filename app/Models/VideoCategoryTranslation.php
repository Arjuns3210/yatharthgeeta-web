<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoCategoryTranslation extends Model
{
    use HasFactory;

    public $timestamps = false;

    public $fillable = [
        'name'
    ];


    public function quoteCategory()
    {
        return $this->belongsTo(App\Models\VideoCategory::class);
    }
}
