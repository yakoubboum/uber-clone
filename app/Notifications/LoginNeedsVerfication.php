<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Channels\TwilioChannel;

use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class LoginNeedsVerification extends Notification
{
    use Queueable;

    protected $verificationCode;

    /**
     * Create a new notification instance.
     */
    public function __construct($verificationCode)
    {
        $this->verificationCode = $verificationCode;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', TwilioChannel::class];
    }

    /**
     * Get the Twilio / SMS representation of the notification.
     */
    public function toTwilio(object $notifiable)
    {
        return (object) [
            'content' => 'Your verification code is: ' . $this->verificationCode,
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
