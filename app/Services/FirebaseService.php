<?php
namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class FirebaseService
{
    protected $messaging;

    public function __construct()
    {
        $firebase = (new Factory)->withServiceAccount(storage_path('my-babe-f249b-firebase-adminsdk-fbsvc-3818335305.json'));
        $this->messaging = $firebase->createMessaging();
    }

    public function sendNotification($fcmToken, $title, $body, $data = [])
{
    try {
        $message = CloudMessage::withTarget('token', $fcmToken)
            ->withNotification(Notification::create($title, $body))
            ->withData($data); // Add custom payload data

        $this->messaging->send($message);
        return true;
    } catch (\Exception $e) {
        \Log::error('Firebase Notification Error: ' . $e->getMessage());
        return false;
    }
}

}
