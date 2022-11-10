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

    public function defaultRules()
    {
        return [
            'minLength' => 8,
            'upperCase' => 1,
            'lowerCase' => 1,
            'specialCharacters' => 1
        ];
    }

}
