<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

ini_set('display_errors', 1);
require_once('twiiter.php');

/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
$settings = array(
    'oauth_access_token' => "199252208-OjgCAYfRWDmi9HWNm7W7s4PXJYUBiYAaQYkFhQmn",
    'oauth_access_token_secret' => "iDTBxZeemQfalgrrqX6klDLsfsiuIASPa1tmc5biV2RaA",
    'consumer_key' => "NT4maJ0vF3Ly3cGQ0oPoA",
    'consumer_secret' => "4DhV73NV0asfeUpblXRnizYgFvC4FP9hOtJyWMTnI"
);

/** URL for REST request, see: https://dev.twitter.com/docs/api/1.1/ **/
$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
$getfield = '?screen_name=j7mbo';
$requestMethod = 'GET';

/** POST fields required by the URL above. See relevant docs as above **/
$twitter = new TwitterAPIExchange($settings);
$response = $twitter->setGetfield($getfield)
    ->buildOauth($url, $requestMethod)
    ->performRequest();

var_dump(json_decode($response));