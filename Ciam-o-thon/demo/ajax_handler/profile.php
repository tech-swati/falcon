<?php

require_once 'config.php';

use \LoginRadiusSDK\Utility\Functions;
use \LoginRadiusSDK\FalconException;
use \LoginRadiusSDK\Clients\IHttpClientInterface;
use \LoginRadiusSDK\Clients\DefaultHttpClient;

use \LoginRadiusSDK\CustomerRegistration\Authentication\AuthenticationAPI;

function getProfileByToken(array $request) {
    $token = isset($request['token']) ? trim($request['token']) : '';
    $response = array('status' => 'error', 'message' => 'An error occurred.');
    if (empty($token)) {
        $response['message'] = 'Access Token is a required field.';
    }
    else {
        $authObj = new AuthenticationAPI();
        $fields = '';
        try {
            $fields = '';
            $result = $authObj->getProfileByAccessToken($token, $fields);
            if ((isset($result->Uid) && $result->Uid != '')) {
                $response['data'] = $result;
                $response['message'] = "Profile successfully retrieved.";
                $response['status'] = 'success';
            }
        }
        catch (FalconException $e) {

            $response['message'] = $e->getMessage();
            $response['status'] = "error";
        }
    }
    return json_encode($response);
}
