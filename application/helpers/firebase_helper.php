<?php

if(!function_exists('send_notification')) {
    
    function send_notification($deviceTokens = [])
    {
        if(count($deviceTokens) > 0)
        {
            $serverKey = "";
            $projectId = "inspiredecor-9168f";
            $url = "https://fcm.googleapis.com/v1/projects/".$projectId."/messages:send";
            
            $payload = [
              "message" => [
                "token" => "",
                "notification" => [
                  "title" => "Breaking News",
                  "body" => "New news story available."
                ],
                "data" => [
                  "story_id" => "story_12345"
                ]
              ]
            ];
            
            
            //curl to sent the request
            
        }
    }
    
}

?>