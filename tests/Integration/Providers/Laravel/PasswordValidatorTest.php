<?php

namespace PasswordPolicy\Tests\Integration\Providers\Laravel;

use PasswordPolicy\Policy;
use PasswordPolicy\Validator;
use PasswordPolicy\PolicyBuilder;
use PasswordPolicy\Tests\TestCase;

class PasswordValidatorTest extends TestCase
{
    protected $policy;

    /** @test */
    public function special_characters_are_required()
    {
        $this->policy()
            ->specialCharacters();

        $this->assertFails('foo');
        $this->assertPasses('foo@');
    }

    /** @test */
    public function a_given_number_of_special_characters_are_required()
    {
        $this->policy()
            ->specialCharacters(3);

        $this->assertFails('foo@@');
        $this->assertPasses('foo@@@');
    }

    protected function policy()
    {
        return $this->policy ?: $this->policy = new PolicyBuilder(new Policy);
    }

    protected function attempt($subject)
    {
        return (new Validator($this->policy->getPolicy()))->attempt($subject);
    }

    protected function assertPasses($subject)
    {
        return $this->assertTrue($this->attempt($subject));
    }

    protected function assertFails($subject)
    {
        return $this->assertFalse($this->attempt($subject));
    }
}