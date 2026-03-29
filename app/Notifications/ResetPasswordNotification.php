<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotificationCore;
use Illuminate\Support\Facades\Lang;

/**
 * Notificación de restablecimiento de contraseña personalizada.
 * Usa una vista Blade premium en español en lugar de la por defecto.
 */
class ResetPasswordNotification extends ResetPasswordNotificationCore implements ShouldQueue
{
    use Queueable;

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        return (new MailMessage)
            ->subject(Lang::get('Restablecer Contraseña - Feria Francofonía'))
            ->view('emails.password_reset', [
                'url' => $url,
                'name' => $notifiable->name,
            ]);
    }
}
