<?php

namespace App\Notifications;

use App\Models\ConfirmationToken;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class EmailVerificationNotification extends Notification
{
    use Queueable;

    public $user;
    public $confirmationToken;

    public function __construct(User $user, ConfirmationToken $confirmationToken)
    {
        $this->user = $user;
        $this->confirmationToken = $confirmationToken;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Confirm your account')
            ->line('Please confirm your account by clicking the button below:')
            ->action('Confirm email', route('user.confirm.email', ['token' => $this->confirmationToken->token]))
            ->line('Once confirmed, you\'ll be able to log in with your new account.')
            ->line('If you did not make this request please contact support');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
