<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LanguageTranslation extends Model
{
    use HasFactory;

    public $fillable = [
        'name'
    ];

    public $timestamps = false;
    protected $dates = ['deleted_at'];

    protected $hidden = [
        'deleted_at'
    ];

    public function language()
    {
        return $this->belongsTo(App\Models\Language::class);
    }
}
