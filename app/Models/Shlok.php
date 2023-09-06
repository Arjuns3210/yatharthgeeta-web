<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shlok extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, SoftDeletes, Translatable;

    protected $fillable = [
        'background_image',
        'sequence',
		'share_allowance',
		'shlok',
		'status',
    ];

    public $translatedAttributes = ['title', 'description'];
    public const TRANSLATED_BLOCK = [
	    'title' => 'input',
	    'description' => 'textarea'

	];
    
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'background_image'=>'string',
		'sequence'=>'integer'

    ];

    public function shlokTranslations()
    {
        return $this->hasMany(\App\Models\ShlokTranslation::class);
    }

}
