<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DirectToken extends Model
{
    use HasFactory;

    protected $table = "direct_auth_tokens";

    protected $fillable = [
        'code',
        'client_id',
        'client_secret',
        'acess_token'
    ];
}
