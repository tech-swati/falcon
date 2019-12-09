<?php
define('FC_API_KEY', '<API-KEY>');

//If you have Custom API Domain then define 'API_DOMAIN' then replaced it with your custom API domain,
//otherwise no need to define these option in configuration.


require_once "../../src/FalconSDK/Utility/Functions.php";
require_once "../../src/FalconSDK/LoginRadiusException.php";
require_once "../../src/FalconSDK/Clients/IHttpClientInterface.php";
require_once "../../src/FalconSDK/Clients/DefaultHttpClient.php";


require_once "../../src/FalconSDK/CustomerRegistration/Authentication/AuthenticationAPI.php";