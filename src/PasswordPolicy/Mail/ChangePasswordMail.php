<?php

namespace PasswordPolicy\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ChangePasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $mail;

    public function __construct(array $mail)
    {
        $this->mail = $mail;
    }

    public function build()
    {
        return $this->view('passwordpolicy::emails.change_password_mail')->subject('Recuperação de Senha');
    }
}