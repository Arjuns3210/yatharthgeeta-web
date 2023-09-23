<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AudioCategory extends Model
{
    use SoftDeletes,Translatable;

    public $fillable = [
        'status'
    ];

    protected $dates = ['deleted_at'];

    protected $hidden = [
        'deleted_at'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'status' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'status' => 'boolean'
    ];

    public $translatedAttributes = ['name'];

    public const TRANSLATED_BLOCK = [
        'name' => 'input',
    ];
    
}
