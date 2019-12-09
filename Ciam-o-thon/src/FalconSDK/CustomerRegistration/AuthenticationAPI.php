<?php
 /**
 * @category            : CustomerRegistration
 * @link                : http://www.loginradius.com
 * @package             : AuthenticationAPI
 * @author              : LoginRadius Team
 * @license             : https://opensource.org/licenses/MIT
 */

namespace FalconSDK\CustomerRegistration\Authentication;

use FalconSDK\Utility\Functions;
use FalconSDK\FalconException;

class AuthenticationAPI extends Functions
{

    public function __construct($options = [])
    {
        parent::__construct($options);
    }

     /**
     * This API retrieves a copy of the user data based on the access_token.
     * @param accessToken Uniquely generated identifier key by Falcon that is activated after successful authentication.
     * @param fields The fields parameter filters the API response so that the response only includes a specific set of fields
     * @return Response containing Definition for Complete profile data
    */

    public function getProfileByAccessToken($accessToken, $fields = "")
    {
        $resourcePath = "/v1/profile";
        $queryParam = [];
        if ($accessToken === '' || ctype_space($accessToken)) {
            throw new FalconException(Functions::paramValidationMsg('accessToken'));
        }
        $queryParam['apiKey'] = Functions::getApiKey();
        if ($fields != '') {
            $queryParam['fields'] = $fields;
        }
        $queryParam['access_token'] = $accessToken;
        return Functions::_apiClientHandler('GET', $resourcePath, $queryParam);
    }
       


    /**
     * This API is used to update the user's profile by passing the access_token.
     * @param accessToken Uniquely generated identifier key by Falcon that is activated after successful authentication.
     * @param userProfileUpdateModel Model Class containing Definition of payload for User Profile update API
     * @return Response containing Definition of Complete Validation and UserProfile data
    */

    public function updateProfileByAccessToken($accessToken, $userProfileUpdateModel,
        $emailTemplate = null, $fields = "", $nullSupport = false,
        $smsTemplate = null, $verificationUrl = null)
    {
        $resourcePath = "/v1/profile";
        $queryParam = [];
        if ($accessToken === '' || ctype_space($accessToken)) {
            throw new FalconException(Functions::paramValidationMsg('accessToken'));
        }
        $queryParam['apiKey'] = Functions::getApiKey();
        $queryParam['access_token'] = $accessToken;
        return Functions::_apiClientHandler('PUT', $resourcePath, $queryParam, $userProfileUpdateModel);
    }
       


    /**
     * This API is used to check the email exists or not on your site.
     * @param email Email of the user
     * @return Response containing Definition Complete ExistResponse data
     * 8.1
    */

    public function checkEmailAvailability($email)
    {
        $resourcePath = "/v1/email/check";
        $queryParam = [];
        $queryParam['apiKey'] = Functions::getApiKey();
        if ($email === '' || ctype_space($email)) {
            throw new FalconException(Functions::paramValidationMsg('email'));
        }
        $queryParam['email'] = $email;
        return Functions::_apiClientHandler('POST', $resourcePath, $queryParam);
    }
       


    /**
     * This API is used to verify the email of user. Note: This API will only return the full profile if you have 'Enable auto login after email verification' set in your Falcon Admin Console's Email Workflow settings under 'Verification Email'.
     * @param verificationToken Verification token received in the email
     * @return Response containing Definition of Complete Validation, UserProfile data and Access Token
     * 8.2
    */

    public function verifyEmail($verificationToken)
    {
        $resourcePath = "/v1/email/verify";
        $queryParam = [];
        $queryParam['apiKey'] = Functions::getApiKey();
        if ($verificationToken === '' || ctype_space($verificationToken)) {
            throw new FalconException(Functions::paramValidationMsg('verificationToken'));
        }
        $queryParam['verificationToken'] = $verificationToken;
        return Functions::_apiClientHandler('PUT', $resourcePath, $queryParam);
    }
       
 
 /**
     * This API resends the verification email to the user.
     * @param email user's email
     * @return Response containing Definition of Complete Validation data
     * 17.3
    */
    public function authResendEmailVerification($email)
    {
        $resourcePath = "/v1/email/resendverify";
        $bodyParam = [];
        $bodyParam['email'] = $email;
        $queryParam = [];
        $queryParam['apiKey'] = Functions::getApiKey();
        return Functions::_apiClientHandler('PUT', $resourcePath, $queryParam, json_encode($bodyParam));
    }


    /**
     * This API retrieves a copy of the user data based on the Email
     * @param emailAuthenticationModel Model Class containing Definition of payload for Email Authentication API
     * @param emailTemplate Email template name
     * @param verificationUrl Email verification url
     * @return Response containing User Profile Data and access token
     * 9.2.1
    */

    public function loginByEmail($emailAuthenticationModel, $emailTemplate = null, $verificationUrl = null)
    {
        $resourcePath = "/v1/login";
        $queryParam = [];
        $queryParam['apiKey'] = Functions::getApiKey();
        if ($emailTemplate != '') {
            $queryParam['emailTemplate'] = $emailTemplate;
        }
        if ($verificationUrl != '') {
            $queryParam['verificationUrl'] = $verificationUrl;
        }
        return Functions::_apiClientHandler('POST', $resourcePath, $queryParam, $emailAuthenticationModel);
    }
       


       


    /**
     * This API is used to send the reset password url to a specified account. Note: If you have the UserName workflow enabled, you may replace the 'email' parameter with 'username'
     * @param email user's email
     * @param resetPasswordUrl Url to which user should get re-directed to for resetting the password
     * @param emailTemplate Email template name
     * @return Response containing Definition of Complete Validation data
     * 10.1
    */

    public function forgotPassword($email, $resetPasswordUrl,$emailTemplate = null)
    {
        $resourcePath = "/v1/password/forgot";
        $bodyParam = [];
        $bodyParam['email'] = $email;
        $queryParam = [];
        $queryParam['apiKey'] = Functions::getApiKey();
        if ($resetPasswordUrl === '' || ctype_space($resetPasswordUrl)) {
            throw new FalconException(Functions::paramValidationMsg('resetPasswordUrl'));
        }
        if ($emailTemplate != '') {
            $queryParam['emailTemplate'] = $emailTemplate;
        }
        $queryParam['resetPasswordUrl'] = $resetPasswordUrl;
        return Functions::_apiClientHandler('POST', $resourcePath, $queryParam, json_encode($bodyParam));
    }
       



    /**
     * This API is used to change the accounts password based on the previous password
     * @param accessToken Uniquely generated identifier key by Falcon that is activated after successful authentication.
     * @param newPassword New password
     * @param oldPassword User's current password
     * @return Response containing Definition of Complete Validation data
     * 10.8
    */

    public function changePassword($accessToken, $newPassword,$oldPassword)
    {
        $resourcePath = "/v1/password/change";
        $bodyParam = [];
        $bodyParam['newPassword'] = $newPassword;
        $bodyParam['oldPassword'] = $oldPassword;
        $queryParam = [];
        if ($accessToken === '' || ctype_space($accessToken)) {
            throw new FalconException(Functions::paramValidationMsg('accessToken'));
        }
        $queryParam['apiKey'] = Functions::getApiKey();
        $queryParam['access_token'] = $accessToken;
        return Functions::_apiClientHandler('PUT', $resourcePath, $queryParam, json_encode($bodyParam));
    }
       


    /**
     * This API creates a user in the database as well as sends a verification email to the user.
     * @param authUserRegistrationModel Model Class containing Definition of payload for Auth User Registration API
     * @param emailTemplate Email template name
     * @param verificationUrl Email verification url
     * @return Response containing Definition of Complete Validation, UserProfile data and Access Token
    */
    public function userRegistrationByEmail($authUserRegistrationModel,$emailTemplate = null,$verificationUrl = null)
    {
        $resourcePath = "/v1/register";
        $queryParam = [];
        $queryParam['apiKey'] = Functions::getApiKey();
        if ($emailTemplate != '') {
            $queryParam['emailTemplate'] = $emailTemplate;
        }
        if ($verificationUrl != '') {
            $queryParam['verificationUrl'] = $verificationUrl;
        }
        return Functions::_apiClientHandler('POST', $resourcePath, $queryParam, $authUserRegistrationModel);
    }
    
       /**
     * This API is used to set a new password for the specified account.
     * @param resetPasswordByResetTokenModel Model Class containing Definition of payload for ResetToken API
     * @return Response containing Definition of Validation data and access token
     * 10.7.1
    */
    public function resetPasswordByResetToken($resetPasswordByResetTokenModel)
    {
        $resourcePath = "/v1/password/reset";
        $queryParam = [];
        $queryParam['apiKey'] = Functions::getApiKey();
        return Functions::_apiClientHandler('PUT', $resourcePath, $queryParam, $resetPasswordByResetTokenModel);
    }
       
}