<?php

namespace PasswordPolicy\Models;

use Illuminate\Database\Eloquent\Model;

class UserPasswordPolicy extends Model
{
    protected $guarded = [
        'id'
    ];

    protected $fillable = [
        'user_id', 'password_changed_date', 'is_active', 'remember_token'
    ];

}