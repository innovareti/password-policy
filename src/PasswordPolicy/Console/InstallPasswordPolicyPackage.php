<?php

namespace PasswordPolicy\Console;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
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

        $unsafePasswords = 0;

        foreach(User::all() as $user){
            if(!UserPasswordPolicy::where('user_id', $user->id)->exists()){
                UserPasswordPolicy::create([
                    'user_id' => $user->id
                ]);
            }
            if(Hash::check("password", $user->password)){
                $unsafePasswords++;

                //$user->password = $this->randomPassword();

                $userPasswordPolicy = UserPasswordPolicy::where('user_id', $user->id)->first();
                $userPasswordPolicy->token_expired = null;
                $userPasswordPolicy->update([
                    'remember_token' => md5(uniqid(rand(), true)),
                ]);

                $mail = [
                    'name' => $user->name,
                    'link' => route('user.passwordPolicy.recovery.form', ['token' => $userPasswordPolicy->remember_token])
                ];
        
                Mail::to($user->email)->queue(new ChangePasswordMail($mail));

                $user->save();
            }
        }

        if($unsafePasswords > 0)
            $this->info('Found ' . $unsafePasswords . ' unsafe password(s). Password(s) were reset and email(s) were sent to the users for them to reset it');

        $this->info('Installed PasswordPolicyPackage');
    }

    public function randomPassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }
}