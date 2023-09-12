<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'login_allowed',
        'admin_remark',
        'is_verified',
        'approval_status'
    ];

    protected $casts = [
        'id' => 'integer',
        'status'=>'boolean'
    ];
}
