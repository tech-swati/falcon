<?php

require_once 'config.php';
use \FalconSDK\Utility\Functions;
use \FalconSDK\FalconException;
use \FalconSDK\Clients\IHttpClientInterface;
use \FalconSDK\Clients\DefaultHttpClient;

use \FalconSDK\CustomerRegistration\Authentication\AuthenticationAPI;


function loginByEmail(array $request) {
    $email = isset($request['email']) ? trim($request['email']) : '';
    $password = isset($request['password']) ? trim($request['password']) : '';
    $response = array('status' => 'error', 'message' => 'An error occurred.');
    if (empty($email) || empty($password)) {
        $response['message'] = 'Email Id and Password are required fields.';
    } else {
        $authenticationObj = new AuthenticationAPI();
        try {
            $loginByEmailAuthenticationModel = array('email' => $email, 'password' => $password);
            $result = $authenticationObj->loginByEmail($loginByEmailAuthenticationModel);
            if (isset($result->access_token) && $result->access_token != '') {
                $response['data'] = $result;
                $response['message'] = "Logged in successfully";
                $response['status'] = 'success';
            }
        }
        catch (FalconException $e) { 
            $response['message'] = $e->error_response->Description;
        }
    }
    return json_encode($response);
}

function getProfile(array $request) {
    $token = isset($request['token']) ? trim($request['token']) : '';
    $response = array('status' => 'error', 'message' => 'An error occurred.');
    if (empty($token)) {
        $response['message'] = 'Access Token is a required field.';
    }
    else {
        $authenticationObj = new AuthenticationAPI();
        try {
            $result = $authenticationObj->getProfileByAccessToken($token);
            if ((isset($result->EmailVerified) && $result->EmailVerified) || AUTH_FLOW == 'optional' || AUTH_FLOW == 'disabled') {
                $response['data'] = $result;
                $response['message'] = "Profile successfully retrieved.";
                $response['status'] = 'success';
            }
            else {
                $response['message'] = "Email is not verified.";
                $response['status'] = 'error';
            }
        }
        catch (FalconException $e) {
            $response['message'] = $e->error_response->Description;
            $response['status'] = "error";
        }
    }
    return json_encode($response);
}

function registration(array $request) {
    $email = isset($request['email']) ? trim($request['email']) : '';
    $password = isset($request['password']) ? trim($request['password']) : '';
    $response = array('status' => 'error', 'message' => 'An error occurred.');
    if (empty($email) || empty($password)) {
        $response['message'] = 'Email Id and Password are required fields.';
    } else {
        $authenticationObj = new AuthenticationAPI();
        try {
            $userprofileModel = array('Email' => array(array('Type' => 'Primary', 'Value' => $email)), 'password' => $password);
            $sottObj = new SottAPI();
            $sott = $sottObj->generateSott(10);

            if(!is_object($sott)) {
                $sott = json_decode($sott);
            }
            $emailTemplate = '';
            $fields = "";
            $verificationUrl = $request['verificationurl'];
            $welcomeEmailTemplate = '';

            $result = $authenticationObj->userRegistrationByEmail($userprofileModel, $sott->Sott, $emailTemplate, $fields, $verificationUrl, $welcomeEmailTemplate);
            if ((isset($result->EmailVerified) && $result->EmailVerified) || AUTH_FLOW == 'optional' || AUTH_FLOW == 'disabled') {
                $response['result'] = $result;
                $response['message'] = "Successfully registered.";
                $response['status'] = 'success';
            } else {
                $response['message'] = "Successfully registered, please check your email to verify your account.";
                $response['status'] = 'registered';
            }
        }
        catch (FalconException $e) { 
            $response['message'] = $e->error_response->Description;
            $response['status'] = "error";
        }
    }
    return json_encode($response);
}
