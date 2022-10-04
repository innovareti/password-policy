<?php

namespace PasswordPolicy\Tests\Unit;

use PasswordPolicy\Models\UserPasswordPolicy;
use PasswordPolicy\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserPasswordPolicyTest extends TestCase
{
   use RefreshDatabase;
  /** @test */
  function a_UserPasswordPolicy_is_active()
  {
    $userPasswordPolicy = factory(UserPasswordPolicy::class)->create(['user_id' => 1]);
    $this->assertEquals(0, $userPasswordPolicy->is_active);
  }
}