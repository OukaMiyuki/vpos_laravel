<?php

namespace App\Notifications\Marketing;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\URL;
use Ichtrojan\Otp\Otp;

class EmailVerificationNotification extends Notification {
    use Queueable;
    // private $otp;

    public static $createUrlCallback;
    public static $toMailCallback;

    public function __construct(){
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable) {
        $otp = (new Otp)->generate($notifiable->email, 'numeric', 6, 30);
        $verificationUrl = $this->verificationUrl($notifiable);

        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $verificationUrl);
        }

        return $this->buildMailMessage($verificationUrl, $otp);
    }

    protected function buildMailMessage($url, $otp) {
        return (new MailMessage)
            ->subject(Lang::get('Verify Email Addres Mitra Aplikasi'))
            ->line(Lang::get('Terima Kasih Sudah mendaftar! Harap masukkan kode OTP Berikut untuk memverifikasi akun anda!'))
            ->line('Kode OTP Akun : '.$otp->token)
            // ->action(Lang::get('Verify Email Address'), $url)
            ->line(Lang::get('Kode OTP ini hanya valid selama 30 menit!'));
    }

    protected function verificationUrl($notifiable) {
        if (static::$createUrlCallback) {
            return call_user_func(static::$createUrlCallback, $notifiable);
        }

        return URL::temporarySignedRoute(
            'marketing.verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
    }

    public static function createUrlUsing($callback) {
        static::$createUrlCallback = $callback;
    }

    public static function toMailUsing($callback) {
        static::$toMailCallback = $callback;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array {
        return [
            //
        ];
    }
}
