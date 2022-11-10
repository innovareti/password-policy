<?php namespace PasswordPolicy;

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

}
