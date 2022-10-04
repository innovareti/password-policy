<?php

namespace PasswordPolicy\Console;

use Illuminate\Console\Command;

class InstallPasswordPolicyPackage extends Command
{
    protected $signature = 'passwordpolicy:install';

    protected $description = 'Install the Password Policy Package';

    public function handle()
    {
        $this->info('Installing Password Policy Package...');

        $this->info('Publishing configuration...');

        $this->call('vendor:publish', [
            '--provider' => "PasswordPolicy\Providers\Laravel\PasswordPolicyServiceProvider",
            '--tag' => "config"
        ]);

        $this->info('Installed BlogPackage');
    }
}