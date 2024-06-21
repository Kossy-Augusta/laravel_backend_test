<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    public $token;
    /**
     * Create a new notification instance.
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $url = url(config('app.url').route('password.reset', ['token' => $this->token]));
        return (new MailMessage)
                    ->greeting('Hello')
                    ->line('You are receiving this email because we received a password reset request for your account.')
                    ->action('Reset Password', $url)
                    ->line('If you did not initiate this mail, please ignore')
                    ->line('Thank you for using our application!');
    }

}
