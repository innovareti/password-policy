<?php

namespace Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPasswordPolicy extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    protected $fillable = [
        'user_id', 'password_changed_date', 'is_active'
    ];

    protected static function newFactory()
    {
        return PasswordPolicy\Database\Factories\UserPasswordPolicyFactory::new();
    }

}