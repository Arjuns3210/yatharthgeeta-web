<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AudioCategoryTranslation extends Model
{
    public $timestamps = false;

    public $fillable = [
        'audio_category_id',
        'locale',
        'name',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'audio_category_id' => 'integer',
        'locale' => 'string',
        'name' => 'string',
    ];
    
}
