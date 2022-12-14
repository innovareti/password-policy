<?php namespace PasswordPolicy;

use Closure;
use PasswordPolicy\Policy;
use PasswordPolicy\Rules\CaseRule;
use PasswordPolicy\Rules\ContainRule;
use PasswordPolicy\Rules\DigitRule;
use PasswordPolicy\Rules\LengthRule;
use PasswordPolicy\Rules\MinPassingRulesRule;
use PasswordPolicy\Rules\SpecialCharacterRule;

/**
 * Class PolicyBuilder
 *
 * @package PasswordPolicy
 */
class PolicyBuilder
{
    /**
     * Policy instance
     *
     * @var Policy
     */
    private $policy;


    /**
     * PolicyBuilder constructor.
     *
     * @param Policy $policy
     */
    public function __construct(Policy $policy)
    {
        $this->policy = $policy;
    }

    /**
     * Add default rules
     *
     * @param $length int
     *
     * @return $this
     */
    public function defaultRules()
    {
        $defaultRules = Policy::defaultRules();

        if(isset($defaultRules['minLength']))
            $this->policy->addRule(
                (new LengthRule)->min($defaultRules['minLength']) //minLength
            );

        if(isset($defaultRules['upperCase']))
            $this->policy->addRule(
            (new CaseRule)->upper($defaultRules['upperCase']) //minUpperCase
            );

        if(isset($defaultRules['lowerCase']))
            $this->policy->addRule(
                (new CaseRule)->lower($defaultRules['lowerCase']) //minLowerCase
            );

        if(isset($defaultRules['digits']))
            $this->policy->addRule(
                (new DigitRule)->min($defaultRules['digits']) //minDigits
            );
            
        if(isset($defaultRules['specialCharacters']))
            $this->policy->addRule(
                (new SpecialCharacterRule)->min($defaultRules['specialCharacters']) //minSpecialCharacters
            );

        return $this;
    }

    /**
     * Add a min length rule
     *
     * @param $length int
     *
     * @return $this
     */
    public function minLength($length)
    {
        $this->policy->addRule(
            (new LengthRule)->min($length)
        );

        return $this;
    }

    /**
     * Add a max length rule
     *
     * @param $length int
     *
     * @return $this
     */
    public function maxLength($length)
    {
        $this->policy->addRule(
            (new LengthRule)->max($length)
        );

        return $this;
    }

    /**
     * Add an upper case rule
     *
     * @param int $min min number of upper case characters
     *
     * @return $this
     */
    public function upperCase($min = 1)
    {
        $this->policy->addRule(
            (new CaseRule)->upper($min)
        );

        return $this;
    }

    /**
     * Add an lower case rule
     *
     * @param int $min min number of lower case characters
     *
     * @return $this
     */
    public function lowerCase($min = 1)
    {
        $this->policy->addRule(
            (new CaseRule)->lower($min)
        );

        return $this;
    }

    /**
     * Add a digit rule
     *
     * @param int $min min number of digits
     *
     * @return $this
     */
    public function digits($min = 1)
    {
        $this->policy->addRule(
            (new DigitRule)->min($min)
        );

        return $this;
    }

    /**
     * Add a does not complain rule based on the given phrases
     *
     * @param      $phrases string|array
     * @param      $caseSensitive bool
     *
     * @return $this
     */
    public function doesNotContain($phrases, $caseSensitive = true)
    {
        $phrases = is_array($phrases) ? $phrases : func_get_args();

        $this->policy->addRule(
            (new ContainRule($caseSensitive))->phrase($phrases)->doesnt()
        );

        return $this;
    }

    /**
     * Add a contains rule based on the given phrases
     *
     * @param $phrases string|array
     * @param $caseSensitive bool
     *
     * @return $this
     */
    public function contains($phrases, $caseSensitive = true)
    {
        $phrases = is_array($phrases) ? $phrases : func_get_args();

        $this->policy->addRule(
            (new ContainRule($caseSensitive))->phrase($phrases)
        );

        return $this;
    }

    /**
     * Add a nested set of minimum passing rules
     *
     * @param         $passesRequired
     * @param Closure $ruleSet
     *
     * @return $this
     */
    public function minPassingRules($passesRequired, Closure $ruleSet)
    {
        $this->policy->addRule(
            (new MinPassingRulesRule($passesRequired))->using($ruleSet)
        );

        return $this;
    }

    /**
     * Special characters
     *
     * @param int $min
     * @return $this
     */
    public function specialCharacters($min = 1)
    {
        $this->policy->addRule(
            (new SpecialCharacterRule)->min($min)
        );

        return $this;
    }


    /**
     * Get the policy instance
     *
     * @return Policy
     */
    public function getPolicy()
    {
        return $this->policy;
    }
}
