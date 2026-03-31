<?php

namespace App\Models;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordResetCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $code;

    public function __construct($code)
    {
        $this->code = $code;
    }

    public function build()
    {
        return $this
            ->subject('Mã đặt lại mật khẩu của bạn')
            ->view('emails.password_reset_code')
            ->with([
                'code' => $this->code,
            ]);
    }
}
