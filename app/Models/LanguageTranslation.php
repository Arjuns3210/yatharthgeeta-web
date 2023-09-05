<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LanguageTranslation extends Model
{
    use HasFactory, SoftDeletes;

    public $fillable = [
        'name'
    ];


    public function language()
    {
        return $this->belongsTo(App\Models\Language::class);
    }
}
