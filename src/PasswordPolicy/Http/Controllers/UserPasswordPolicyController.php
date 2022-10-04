<?php

namespace PasswordPolicy\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UserPasswordPolicyController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function recoveryForm($token)
    {
        return view('passwordpolicy.recovery', compact('token'));
    }
}
