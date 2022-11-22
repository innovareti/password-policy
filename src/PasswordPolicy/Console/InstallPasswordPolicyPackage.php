<?php

namespace PasswordPolicy\Console;

use App\Models\User;
use PasswordPolicy\Policy;
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
        $this->info('Instalando pacote de política de senha...');

        $this->info('Criando tabela password policy...');

        Artisan::call('migrate');
        $this->info(Artisan::output());

        $this->info('Populando tabela e trocando senhas inseguras...');

        $unsafePasswords = 0;

        foreach(User::all() as $user){
            if(!UserPasswordPolicy::where('user_id', $user->id)->exists()){
                UserPasswordPolicy::create([
                    'user_id' => $user->id
                ]);
            }
            if(Hash::check("password", $user->password)){
                $unsafePasswords++;

                $user->password = Policy::randomPassword();

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
            $this->info('Encontrado ' . $unsafePasswords . ' senha(s) insegura(s). A senha foi resetada e um e-mail foi enviado para os usuários trocarem.');

        $this->info('Pacote PasswordPolicy instalado com sucesso');
    }
}