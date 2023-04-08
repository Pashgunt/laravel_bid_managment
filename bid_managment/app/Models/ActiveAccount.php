<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActiveAccount extends Model
{
    use HasFactory;

    protected $table = 'active_account_for_user';

    protected $fillable = [
        'user_id',
        'direct_id',
    ];
}
