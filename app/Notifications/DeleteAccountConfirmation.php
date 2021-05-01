<?php

namespace App\Notifications;

use App\Models\ConfirmationToken;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class DeleteAccountConfirmation extends Notification
{
    use Queueable;

    public $user;
    public $confirmationToken;

    /**
     * Create a new notification instance.
     *
     * @param User $user
     * @param ConfirmationToken $confirmationToken
     */
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
            ->subject('Confirm deletion of your account')
            ->line('You have requested an account deletion')
            ->action('Confirm deletion', route('user.confirm.delete', ['token' => $this->confirmationToken->token]))
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
