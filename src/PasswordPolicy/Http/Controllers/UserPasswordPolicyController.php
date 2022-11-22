<?php

namespace PasswordPolicy\Http\Controllers;

use App\Models\User;
use PasswordPolicy\Policy;
use Illuminate\Http\Request;
use PasswordPolicy\Validator;
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
        $token_expired = UserPasswordPolicy::where('remember_token', $token)->value('token_expired');
        if($token_expired == 's'){
            return ['token_expired' => true];
        }

        return ['token_expired' => false];
    }

    public function change(Request $request)
    {
        $data = $request->all();
        DB::beginTransaction();
        try {
            $validate = Policy::validate($data['password']);

            $page = 'recovery';
            $token = $data['token'];
            $token_expired = false;
            $passwordRules = Policy::defaultRules();

            //Validando a senha
            if($validate != "success"){
                return view('passwordpolicy::recovery', compact('page', 'validate', 'token', 'token_expired', 'passwordRules'));
            } else if ($data['password'] != $data['password_confirmation']){
                $validate = "As senhas não conferem";
                return view('passwordpolicy::recovery', compact('page', 'validate', 'token', 'token_expired', 'passwordRules'));
            }

            if($userPasswordPolicy = UserPasswordPolicy::where('remember_token', $data['token'])->first()){
                $user = User::find($userPasswordPolicy->user_id);

                if ($user->update(['password' => $data['password']])) {
                    $userPasswordPolicy->password_changed_date = date("Y-m-d");
                    $userPasswordPolicy->token_expired = 's';
                    $userPasswordPolicy->save();

                    DB::commit();
                    $page = "success";
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
