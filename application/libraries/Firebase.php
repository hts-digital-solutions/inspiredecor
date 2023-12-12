<?php

defined("BASEPATH") OR exit("No direct access allowed!");

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\AndroidConfig;
use Kreait\Firebase\Messaging\ApnsConfig;

class Firebase {
    
    private $factory;
    
    function __construct() {
        
        $this->factory = (new Factory)->withServiceAccount(APPPATH.'libraries/inspiredecor-9168f-firebase-adminsdk-gqe1l-4c8416ff84.json');
    
    }
    
    //sent notification
    function sendNotification($deviceToken = '', $data = [])
    {
        if(!empty($deviceToken)) {
            
            try {
                
                $notification = Notification::fromArray($data);
                
                $messaging = $this->factory->createMessaging();
                
                $config = AndroidConfig::fromArray([
                    'ttl' => '3600s',
                    'priority' => 'high',
                    'notification' => [
                        'title' => $data['title'] ?? '',
                        'body' => $data['body'] ?? '',
                        'color' => '#2196F3',
                    ],
                ]);
                
                $configApn = ApnsConfig::fromArray([
                    'headers' => [
                        'apns-priority' => '10',
                    ],
                    'payload' => [
                        'aps' => [
                            'alert' => [
                                'title' => $data['title'] ?? '',
                                'body' => $data['body'] ?? '',
                            ],
                        ],
                    ],
                ]);
                
                $message = CloudMessage::withTarget('token', $deviceToken)
                    ->withNotification($notification)
                    ->withAndroidConfig($config)
                    ->withApnsConfig($configApn)
                    ->withDefaultSounds()
                    ->withData([
                       'link'   => 'https://www.inspiredecor.in'
                    ]);
                
                $messaging->send($message);
                
                return true;
                
            }catch(\Exception $e){
                die($e->getMessage());
                return false;
            }
            
        }
    }
    
}

?>