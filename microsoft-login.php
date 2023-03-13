<?php

// Replace with your app credentials
$client_id = 'cd242a38-0fbf-49fc-aa0b-d2a311ea109b';
$client_secret = 'a0dd183c-96aa-4dd8-b051-cc12359d439c';
$redirect_uri = 'https://localhost/microsoft-login.php';

// Start the authorization flow if we don't have an access token
if (!isset($_GET['code'])) {
  // Redirect the user to the Microsoft login page
  $auth_url = 'https://login.microsoftonline.com/common/oauth2/v2.0/authorize'
    . '?client_id=' . urlencode($client_id)
    . '&response_type=code'
    . '&redirect_uri=' . urlencode($redirect_uri)
    . '&scope=XboxLive.signin%20XboxLive.profile';
  header('Location: ' . $auth_url);
  exit;
}

// Exchange the authorization code for an access token
$code = $_GET['code'];
$token_url = 'https://login.microsoftonline.com/common/oauth2/v2.0/token';
$post_data = array(
  'grant_type' => 'authorization_code',
  'client_id' => $client_id,
  'client_secret' => $client_secret,
  'redirect_uri' => $redirect_uri,
  'code' => $code,
);
$options = array(
  'http' => array(
    'method' => 'POST',
    'header' => 'Content-Type: application/x-www-form-urlencoded',
    'content' => http_build_query($post_data),
  ),
);
$context = stream_context_create($options);
$response = file_get_contents($token_url, false, $context);
$token_data = json_decode($response, true);
$access_token = $token_data['access_token'];

// Fetch the user's XUID and gamertag using the access token
$user_url = 'https://xsts.auth.xboxlive.com/xsts/authorize';
$post_data = array(
  'Properties' => array(
    'AuthMethod' => 'RPS',
    'SiteName' => 'user.auth.xboxlive.com',
    'RpsTicket' => 'd=' . $access_token,
  ),
  'RelyingParty' => 'http://xboxlive.com',
  'TokenType' => 'JWT',
);
$options = array(
  'http' => array(
    'method' => 'POST',
    'header' => 'Content-Type: application/json',
    'content' => json_encode($post_data),
  ),
);
$context = stream_context_create($options);
$response = file_get_contents($user_url, false, $context);
$user_data = json_decode($response, true);
$xuid = $user_data['DisplayClaims']['xui'][0]['xid'];
$gamertag = $user_data['DisplayClaims']['xui'][0]['gtg'];

function getXuid(){
   return $xuid;
}

function getGamerTag(){
    return $gamertag;
}

// Output the user's XUID and gamertag
echo 'XUID: ' . $xuid . '<br>';
echo 'Gamertag: ' . $gamertag;
