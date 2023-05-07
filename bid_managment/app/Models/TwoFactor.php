<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TwoFactor extends Model
{
    use HasFactory;

    protected $table = 'two_factor_codes';

    protected $fillable = [
        'user_id',
        'code',
        'expire_at',
        'is_actual',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
