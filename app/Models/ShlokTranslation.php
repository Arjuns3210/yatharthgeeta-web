<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShlokTranslation extends Model
{
    use HasFactory;
    public $fillable = [
        'shlok_id',
        'title',
        'description',
        'status',
        'chapter',
    ];

    public function shloks()
    {
        return $this->hasMany(\App\Models\Shlok::class);
    }
}
