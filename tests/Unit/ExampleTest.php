<?php namespace PasswordPolicy\Tests\Unit;

use PasswordPolicy\Policy;
use PasswordPolicy\Validator;
use PasswordPolicy\PolicyBuilder;
use PasswordPolicy\Tests\TestCase;

class ExampleTest extends TestCase
{
    function testExampleOne()
    {
        $builder = new PolicyBuilder(new Policy);
        $builder->minLength(8)
            ->upperCase(3)
            ->lowerCase(3)
            ->digits(3)
            ->doesNotContain('BAZ');

        $validator = new Validator($builder->getPolicy());

        $this->assertFalse($validator->attempt(''));
        $this->assertFalse($validator->attempt('foobar'));
        $this->assertFalse($validator->attempt('fooBAR'));
        $this->assertFalse($validator->attempt('fooBAZ123'));
    }
}
