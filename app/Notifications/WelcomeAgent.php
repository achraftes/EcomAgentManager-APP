<?php
namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class WelcomeAgent extends Notification
{
    public $password;

    /**
     * Create a new notification instance.
     *
     * @param string $password
     * @return void
     */
    public function __construct($password)
    {
        $this->password = $password;
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
                    ->subject('Welcome to the team!')
                    ->greeting('Hello ' . $notifiable->name . ',')
                    ->line('Welcome to the team! We are excited to have you with us.')
                    ->line('Your account has been successfully created.')
                    ->line('Here are your login details:')
                    ->line('**Email:** ' . $notifiable->email)
                    ->line('**Password:** ' . $this->password)
                    ->action('Login', url('/login'))
                    ->line('Please make sure to change your password after your first login.')
                    ->line('Thank you for using our application!');
    }
}
