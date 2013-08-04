<?php
// http://vimeo.com/api/v2/brooklynfoundry/videos.json
// Who's videos are we getting?
$username     = "brooklynfoundry";
$api_endpoint = "http://vimeo.com/api/v2";
$path         = "/%s/videos.json";

// Now let's build up the URL we're going to call to get the videos
$url          = $api_endpoint . sprintf($path, $username);

// Cool! file_get_contents works over HTTP too!
$json         = file_get_contents($url);
$videos       = json_decode($json);

// $videos now contains an array of $username's videos
