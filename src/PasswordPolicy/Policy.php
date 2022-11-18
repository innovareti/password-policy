<?php namespace PasswordPolicy;

use DateTime;

Use PasswordPolicy\Models\UserPasswordPolicy;

class Policy
{
    private $rules = [];

    public function addRule(Rule $rule)
    {
        $this->rules[] = $rule;
    }

    /**
     * @return Rule[]
     */
    public function rules()
    {
        return $this->rules;
    }

    public static function defaultRules()
    {
        return [
            'minLength' => 8,
            'upperCase' => 1,
            'lowerCase' => 1,
            'digits' => 1,
            'specialCharacters' => 1
        ];
    }

    public static function isPasswordExpired($id){
        $is_active = env('PASSWORD_POLICY_ACTIVE') ? env('PASSWORD_POLICY_ACTIVE') : false; 
        $days = env('PASSWORD_POLICY_DAYS') ? env('PASSWORD_POLICY_DAYS') : 90;
        if($is_active){
            $userPolicy = UserPasswordPolicy::where('user_id', $id)->first();
            $today = date("Y-m-d") . " -" . $days . " days";
            $expiredDate = date("Y-m-d", strtotime($today));
            $teste = $userPolicy->password_changed_date;
            if($userPolicy->password_changed_date < $expiredDate){
                //troca senha para aleatoria - mantém expirado para o usuario poder re-enviar e ter a msg ainda
                //manda email
                return true;
            }
        }
        
        return false;
    }

    public static function validationMessage()
    {
        $defaultRules = Policy::defaultRules();
        $validationMessage = "A senha deve conter:";
        if(isset($defaultRules['minLength'])){
            $validationMessage .= " No mínimo ". $defaultRules['minLength'] . " caracteres.";
        }
        if(isset($defaultRules['upperCase'])){
            $validationMessage .= " Caracteres maiúsculos.";
        }

        if(isset($defaultRules['lowerCase'])){
            $validationMessage .= " Caracteres minúsculos.";
        }

        if(isset($defaultRules['digits'])){
            $validationMessage .= " Numeros.";
        }

        if(isset($defaultRules['specialCharacters'])){
            $validationMessage .= " Caracteres especiais";
        }

        return $validationMessage;
    }

    public static function validate($password){
        $defaultRules= Policy::defaultRules();

        if(isset($defaultRules['minLength'])){
            if(strlen($password) < $defaultRules['minLength'])
                return "A senha inserida não possui ". $defaultRules['minLength'] . " caracteres";
        }
        if(isset($defaultRules['upperCase'])){
            if(!preg_match('/[A-Z]/', $password))
                return "A senha inserida não possui caracteres maiúsculos";
        }

        if(isset($defaultRules['lowerCase'])){
            if(!preg_match('/[a-z]/', $password))
                return "A senha inserida não possui caracteres minúsculos";
        }

        if(isset($defaultRules['digits'])){
            if(!preg_match('/\d/', $password))
                return "A senha inserida não possui números";
        }

        if(isset($defaultRules['specialCharacters'])){
            if(!preg_match('/[^a-zA-Z\d]/', $password))
                return "A senha inserida não possui símbolos";
        }

        return "success";

    }

}
