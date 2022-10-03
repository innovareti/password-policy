<?php

namespace PasswordPolicy\Tests\Unit;

use Models\UserPasswordPolicy;
use PasswordPolicy\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserPasswordPolicyTest extends TestCase
{
   use RefreshDatabase;
  /** @test */
  function a_UserPasswordPolicy_is_active()
  {
    $userPasswordPolicy = UserPasswordPolicy::factory()->create([
        'user_id' => 1
    ]);
    $this->assertEquals(0, $userPasswordPolicy->is_active);
  }
}