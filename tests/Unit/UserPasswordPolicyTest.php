<?php

namespace PasswordPolicy\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Models\UserPasswordPolicy;

class UserPasswordPolicyTest extends \PHPUnit_Framework_TestCase
{
  /** @test */
  function a_UserPasswordPolicy_is_active()
  {
    $userPasswordPolicy = UserPasswordPolicy::factory()->create([
        'user_id' => 1
    ]);
    $this->assertEquals(0, $userPasswordPolicy->is_active);
  }
}