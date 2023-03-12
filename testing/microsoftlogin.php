<?php
session_start();
require_once('config.php'); // Contains MySQL database configuration

// Set the application parameters
define('CLIENT_ID', 'YOUR_CLIENT_ID_HERE');
define('CLIENT_SECRET', 'YOUR_CLIENT_SECRET_HERE');
define('REDIRECT_URI', 'http://localhost/microsoft-login.php');

// If the code parameter is present in the URL, exchange it for an access token
if(isset($_GET['code'])) {
    $url = 'https://login.microsoftonline.com/common/oauth2/v2.0/token';

    $data = array(
        'client_id' => CLIENT_ID,
        'client_secret' => CLIENT_SECRET,
        'redirect_uri' => REDIRECT_URI,
        'code' => $_GET['code'],
        'grant_type' => 'authorization_code'
    );

    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
        )
    );

    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    $response = json_decode($result);

    // Store the access token in a session variable
    $_SESSION['access_token'] = $response->access_token;

    // Retrieve user information from the Microsoft Graph API
    $user_data = getUserData($_SESSION['access_token']);

    // Check if the user already exists in the database
    $user_exists = checkUserExists($user_data->id);

    if(!$user_exists) {
        // If the user does not exist, insert their information into the database
        $insert_data = array(
            'id' => $user_data->id,
            'name' => $user_data->displayName,
            'email' => $user_data->mail,
            'xuid' => getXUID($_SESSION['access_token'])
        );

        insertUser($insert_data);
    }

    // Redirect to the homepage or any other page
    header('Location: index.php');
    exit;
}

// If the access token is present in the session, use it to get the username, XUID, and skin
if(isset($_SESSION['access_token'])) {
    // Retrieve user information from the Microsoft Graph API
    $user_data = getUserData($_SESSION['access_token']);

    // Retrieve the user's XUID from the Xbox Live API
    $xuid = getXUID($_SESSION['access_token']);

    // Retrieve the user's Minecraft skin from the Mojang API
    $skin_url = getSkinURL($user_data->mail);

    // Display the username, XUID, and skin
    echo "Welcome, ".$user_data->displayName."!<br>";
    echo "Your XUID is ".$xuid.".<br>";
    echo "Your skin URL is ".$skin_url.".";
} else {
    // If the access token is not present in the session, redirect to the login page
    $url = 'https://login.microsoftonline.com/common/oauth2/v2.0/authorize';
    $params = array(
        'client_id' => CLIENT_ID,
        'response_type' => 'code',
        'redirect_uri' => REDIRECT_URI,
        'scope' => 'openid email profile User.Read'
    );

    $login_url = $url.'?'.http_build_query($params);
    header('Location: '.$login_url);
    exit;
}

// Function to retrieve user information from the Microsoft Graph API
function getUserData($access_token) {
    // Set the API endpoint and headers
    $url = 'https://graph.microsoft.com/v1.0/me';
    $headers = array(
        'Authorization: Bearer '.$access_token,
        'Accept: application/json'
    );

    // Set the HTTP options
    $options = array(
        'http' => array(
            'header' => $headers,
            'method' => 'GET'
        )
    );

    // Create a stream context
    $context = stream_context_create($options);

    // Make the API request and get the response
    $response = file_get_contents($url, false, $context);

    // Parse the response JSON
    $data = json_decode($response);

    // Return the user data object
    return $data;
}

// Set the API endpoint and headers for retrieving the Minecraft skin URL
function getSkinURL($email) {
    $url = "https://api.mojang.com/users/profiles/minecraft/" . $email;
    $headers = array(
        'Content-Type: application/json'
    );

    // Set the HTTP options
    $options = array(
        'http' => array(
            'header' => $headers,
            'method' => 'GET'
        )
    );

    // Create a stream context
    $context = stream_context_create($options);

    // Make the API request and get the response
    $response = file_get_contents($url, false, $context);

    // Parse the response JSON
    $data = json_decode($response);

    // Get the skin URL
    $skin_url = "https://crafatar.com/skins/" . $data->id;

    // Return the skin URL
    return $skin_url;
}

// Function to retrieve the XUID of the user from the Xbox Live API
function getXUID($access_token) {
    // Set the API endpoint and headers
    $url = 'https://xsts.auth.xboxlive.com/xsts/authorize';
    $headers = array(
        'Content-Type: application/json',
        'Accept: application/json',
        'x-xbl-contract-version: 1'
    );

    // Set the request body
    $body = array(
        'Properties' => array(
            'UserTokens' => array($_SESSION['access_token'])
        ),
        'RelyingParty' => 'rp://api.minecraftservices.com/',
        'TokenType' => 'JWT'
    );

    // Set the HTTP options
    $options = array(
        'http' => array(
            'header' => $headers,
            'method' => 'POST',
            'content' => json_encode($body)
        )
    );

    // Create a stream context
    $context = stream_context_create($options);

    // Make the API request and get the response
    $response = file_get_contents($url, false, $context);

    // Parse the response JSON
    $data = json_decode($response);

    // Get the user's XUID
    $xuid = $data->DisplayClaims->xui[0]->xid;

    // Return the XUID
    return $xuid;
}

