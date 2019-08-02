<?php // callback.php

require "vendor/autoload.php";
require_once('vendor/linecorp/line-bot-sdk/line-bot-sdk-tiny/LINEBotTiny.php');

$access_token = '5Rw6I6Ip9YG+87B7hYVe4ncdteFtMf2j7GfCw5+pipGt+p1eMgmPmDym0y3oF+lOmIg9eGbdDHExD5F83cZ6i2u84zlcqqvr9fXmK0o9OpE9XkrazepIx1xUCB99vANBKnbVz73KEwJKoyO4S7T13gdB04t89/1O/w1cDnyilFU=';

if($_GET['token']){
   $access_token = $_GET['token'];
}

// Get POST body content
$content = file_get_contents('php://input');

error_log($content);
echo $content;

// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data
if (!is_null($events['events'])) {
	// Loop through each event
	foreach ($events['events'] as $event) {
		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			// Get text sent
			$text = 'userId : '.$event['source']['userId']." groupId : ".$event['source']['groupId'];
			// Get replyToken
			$replyToken = $event['replyToken'];

			// Build message to reply back
			$messages = [
				'type' => 'text',
				'text' => $text
			];

			// Make a POST Request to Messaging API to reply to sender
			$url = 'https://api.line.me/v2/bot/message/reply';
			$data = [
				'replyToken' => $replyToken,
				'messages' => [$messages],
			];
			$post = json_encode($data);
			/*$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			$result = curl_exec($ch);
			curl_close($ch);
			echo $result . "\r\n";
			*/
						
			error_log($post);
			echo $post;
			print_r($post);
		}
	}
}
echo "OK";
