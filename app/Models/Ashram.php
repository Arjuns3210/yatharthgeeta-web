<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\InteractsWithMedia;

class Ashram extends Model implements HasMedia
{
    use HasFactory,SoftDeletes,InteractsWithMedia;
    protected $fillable = [
        'name',
        'title',
        'image',
        'description',
        'phone',
        'email',
        'location',
    ];
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    // protected $casts = [
    //     'id' => 'integer',
    //     'name'=>'string',
    //     'title'=>'string',
    //     'description'=>'string',
    //     'image'=>'string',
    //     'phone'=>'string',
    //     'email'=>'string',
    //     'location' => 'string'
    // ];

    // public static $rules = [
    //     'name.*' => 'string|required',
    //     'title.*' => 'string|required',
    //     'description' => 'required',
    //     'phone.*' => 'string|required',
    //     'email.*' => 'string|required',
    //     'location.*' => 'string|required',
    //     'image.*' => 'longText|required',
    // ];

    const IMAGE= 'image';
    
    public const TRANSLATED_BLOCK = [
        'name' => 'input',
        'short description' => 'input',
        'long description' => 'textarea',
        'allowed in location' => 'textarea',
        'not allowed in location' => 'textarea',
    ];

}
