<?php


namespace App\Channels;

use Twilio\Rest\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Notifications\Notification;

class TwilioChannel
{
    protected $twilio;

    public function __construct()
    {
        $this->twilio = new Client(config('services.twilio.sid'), config('services.twilio.token'));
    }

    public function send($notifiable, Notification $notification)
    {
        if (! $to = $notifiable->routeNotificationFor('twilio', $notification)) {
            return;
        }

        $message = $notification->toTwilio($notifiable);

        try {
            $this->twilio->messages->create($to, [
                'from' => config('services.twilio.from'),
                'body' => $message->content,
            ]);
        } catch (\Twilio\Exceptions\TwilioException $e) {
            Log::error('Twilio error: ' . $e->getMessage());
        }
    }
}
