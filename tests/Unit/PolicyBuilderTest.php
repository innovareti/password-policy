<?php namespace PasswordPolicy\Tests\Unit;

use Mockery\Mock;
use PasswordPolicy\Rule;
use PasswordPolicy\Policy;
use PasswordPolicy\PolicyBuilder;
use PasswordPolicy\Tests\TestCase;
use PasswordPolicy\Rules\LengthRule;

class PolicyBuilderTest extends TestCase
{
    /** @test */
    function it_tests_min_length_can_be_added_to_a_policy()
    {
        $mock = \Mockery::mock(Policy::class)
            ->shouldReceive('addRule')
            ->with(\Mockery::type(LengthRule::class))
            ->once();

        $builder = new PolicyBuilder($mock->getMock());
        $builder->minLength(2);

        $this->assertTrue(true);
    }

    // protected function tearDown()
    // {
        // \Mockery::close();
    // }
}
