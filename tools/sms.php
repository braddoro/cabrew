<?php
// Require the bundled autoload file - the path may need to change
// based on where you downloaded and unzipped the SDK
require __DIR__ . '../twilio-php-master/Twilio/autoload.php';

// Use the REST API Client to make requests to the Twilio REST API
use Twilio\Rest\Client;

// Your Account SID and Auth Token from twilio.com/console
$sid = 'ACd4dc62d3c489e864973b60d47f1935fc';
$token = '61744cb2364a0b3999e46f9e331c142e';
$client = new Client($sid, $token);

// Use the client to do fun stuff like send text messages!
$client->messages->create(
    // the number you'd like to send the message to
    // +13154917192 Jay
    // +19805210162 Brad
    '+13154917192',
    array(
        // A Twilio phone number you purchased at twilio.com/console
        // +13154917192
        //
        'from' => '+17042154190',
        // the body of the text message you'd like to send
        'body' => "This is a Beer..."
    )
);
