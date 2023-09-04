<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Language extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'language_name',
        'language_code',
    ];
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'language_name' => 'string',
        'language_code'=>'string'
    ];

    public static $rules = [
        'language_name' => 'string|required',
        'language_code' => 'string|required'
    ];


}
