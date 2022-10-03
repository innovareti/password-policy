<?php

namespace PasswordPolicy\Tests;

use PasswordPolicy\Providers\Laravel\PasswordPolicyServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
  public function setUp(): void
  {
    parent::setUp();
    $this->withFactories(__DIR__.'/../database/factories');  
}

  protected function getPackageProviders($app)
  {
    return [
        PasswordPolicyServiceProvider::class,
    ];
  }

  protected function getEnvironmentSetUp($app)
  {
    // import the CreatePostsTable class from the migration
    //include_once __DIR__ . '/../database/migrations/2022_10_03_132807_create__user_password_policies_table.php';

    // run the up() method of that migration class
    //(new \CreateUserPasswordPoliciesTable)->up();
  }
}