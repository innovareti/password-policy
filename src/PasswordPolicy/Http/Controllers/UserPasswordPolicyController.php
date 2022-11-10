<?php

namespace PasswordPolicy\Http\Controllers;

use App\Models\User;
use PasswordPolicy\Policy;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Bus\DispatchesJobs;
use PasswordPolicy\Models\UserPasswordPolicy;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UserPasswordPolicyController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function recoveryForm($token)
    {
        $condition = $this->checkToken($token);
        $token_expired = $condition['token_expired'];
        $page = 'recovery';
        $passwordRules = Policy::defaultRules();
        
        return view('passwordpolicy::recovery', compact('token_expired', 'token', 'page', 'passwordRules'));
    }

    public function checkToken($token)
    {
        if (UserPasswordPolicy::where('remember_token', $token)->value('token_expired') == 's') {
            return ['token_expired' => true];
        }

        return ['token_expired' => false];
    }

    public function change(UserRequest $request)
    {
        $data = $request->all();
        DB::beginTransaction();
        try {
            if($userPasswordPolicy = UserPasswordPolicy::where('remember_token', $data['token'])->first()){
                $user = User::find($userPasswordPolicy->user_id);

                if ($data['password'] == $data['password_confirmation']) {
                    if ($user->update(['password' => $data['password']])) {
                        $userPasswordPolicy->update(['token_expired' => 's']);
    
                        DB::commit();
                        $page = "success";
                        return view('passwordpolicy::recovery', compact('page'));
                    }
                } else {
                    $page = "failed";
                    return view('passwordpolicy::recovery', compact('page'));
                }
            } else {
                $page = "recovery";
                $token_expired = "s";
                return view('passwordpolicy::recovery', compact('page', 'token_expired'));
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return ['status' => '01', 'message' => $e->getMessage()];
        }
    }

}
