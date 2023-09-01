<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class locationTranslation extends Model
{
    use HasFactory;

    public $fillable = [
        'name',
        'location_id',
        'locale',
        'short_description',
        'long_description',
        'allowed_in_location',
        'not_allowed_in_location'
    ];


    public function location()
    {
        return $this->belongsTo(App\Models\Location::class);
    }
}
