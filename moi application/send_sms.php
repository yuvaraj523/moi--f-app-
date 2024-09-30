<?php
require 'vendor/autoload.php'; // Include the Composer autoload file

use Twilio\Rest\Client;

$account_sid = 'AC72f6e81454ac477d67694649327d5874'; // Replace with your Twilio Account SID
$auth_token = '762c2bb92dea10317f735e222ae7d126'; // Replace with your Twilio Auth Token
$twilio_number = '+19289854097'; // Replace with your Twilio phone number

// Initialize Twilio client
$client = new Client($account_sid, $auth_token);

// Check if phone and message are provided
if (isset($_POST['phone']) && isset($_POST['message'])) {
    $phone = trim($_POST['phone']);
    $message = trim($_POST['message']);

    // Validate phone number format
    if (!preg_match('/^\+\d{1,15}$/', $phone)) {
        echo "Invalid phone number format. Please use E.164 format (e.g., +1234567890).";
        exit;
    }

    try {
        // Send SMS
        $sentMessage = $client->messages->create(
            $phone,
            [
                'from' => $twilio_number,
                'body' => $message
            ]
        );
        echo "SMS sent successfully. Message SID: " . $sentMessage->sid;
    } catch (\Twilio\Exceptions\RestException $e) {
        echo "Twilio Error: " . $e->getMessage();
    } catch (Exception $e) {
        echo "General Error: " . $e->getMessage();
    }
} else {
    echo "Phone number and message are required.";
}
?>
