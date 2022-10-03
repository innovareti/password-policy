<?php namespace PasswordPolicy\Tests\Unit\Providers\Laravel;

use Mockery as m;
use PasswordPolicy\Policy;
use PasswordPolicy\Validator;
use PasswordPolicy\PolicyBuilder;
use PasswordPolicy\PolicyManager;
use PasswordPolicy\Tests\TestCase;
use PasswordPolicy\Providers\Laravel\PasswordValidator;

class PasswordValidatorTest extends TestCase
{
    /** @test */
    public function it_calls_the_validator_using_the_default_policy()
    {
//        $managerMock = m::mock(PolicyManager::class)
//            ->shouldReceive('getDefaultName')
//            ->shouldReceive('validator')
//            ->once()
//            ->andReturn('default');
//
//        $manager = $managerMock->getMock();
//        $manager->define('default', new Policy);
//
//        $validatorMock = m::mock(PasswordValidator::class, [$manager])
//            ->shouldReceive('validate')
//            ->once()
//            ->with('password', 'password', [], null)
//            ->andReturn(true);
//
//        $validator = $validatorMock->getMock();
//        $this->assertTrue(($validator->validate('password', 'password', [], null)));
    }
}