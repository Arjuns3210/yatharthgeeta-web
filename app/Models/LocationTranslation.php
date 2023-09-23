<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocationTranslation extends Model
{
    use HasFactory;

    public $timestamps = false;

    public $fillable = [
        'name',
        'location_id',
        'locale',
        'title',
        'description',
        'do',
        'dont'
    ];


    public function location()
    {
        return $this->belongsTo(App\Models\Location::class);
    }
}
