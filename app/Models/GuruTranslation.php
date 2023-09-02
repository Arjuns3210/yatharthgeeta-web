<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuruTranslation extends Model
{
    use HasFactory;

    public $fillable = [
        'name',
        'guru_id',
        'locale',
        'title',
        'description',
    ];


    public function guru()
    {
        return $this->belongsTo(App\Models\Guru::class);
    }
}
