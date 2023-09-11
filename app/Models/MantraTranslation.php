<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MantraTranslation extends Model
{
    use HasFactory;
    public $fillable = [
        'mantra_id',
        'title',
        'description'

    ];
    public $timestamps = false;
    public function mantra()
    {
        return $this->belongsTo(\App\Models\Mantra::class);
    }
}
