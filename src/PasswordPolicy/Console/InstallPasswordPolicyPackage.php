<?php

namespace PasswordPolicy\Console;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Artisan;
use PasswordPolicy\Mail\ChangePasswordMail;
use PasswordPolicy\Models\UserPasswordPolicy;

class InstallPasswordPolicyPackage extends Command
{
    protected $signature = 'passwordpolicy:install';

    protected $description = 'Install the Password Policy Package';

    public function handle()
    {
        $this->info('Installing Password Policy Package...');

        $this->info('Creating password policy table...');

        Artisan::call('migrate');
        $this->info(Artisan::output());

        $this->info('Seeding password policy table accordingly...');

        // foreach(User::all() as $user){
            // if(!UserPasswordPolicy::where('user_id', $user->id)->exists()){
                // UserPasswordPolicy::create([
                    // 'user_id' => $user->id
                // ]);
            // }
        // }

        $emailUser = User::find(1);

        $this->info('Sending emails to users with a simple password...');

        Mail::to('lucas.lima.c@outlook.com')->send(new ChangePasswordMail($emailUser));

        $this->info('Installed PasswordPolicyPackage');
    }
}