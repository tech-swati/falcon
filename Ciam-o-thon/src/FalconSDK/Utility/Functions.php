<?php

/**
 * @link : http://www.loginradius.com
 * @category : Utility
 * @package : Functions
 * @author : LoginRadius Team
 * @version : 10.0.0
 * @license : https://opensource.org/licenses/MIT
 */

namespace FalconSDK\Utility;

use FalconSDK\Clients\IHttpClientInterface;
use FalconSDK\Clients\DefaultHttpClient;
use FalconSDK\FalconException;

/**
 * Class For LoginRadius
 * This is the Loginradius class to handle response of LoginRadius APIs.
 *
 */
class Functions
{

    const VERSION = '1.0.0';

    private static $_apikey;
    private static $_options = array();

    /**
     * Validate and set API credentials and set options.
     *
     * @param string $apikey
     * @param array $customizeOptions
     */
    public function __construct($customizeOptions = array())
    {
		if (empty(self::$_apikey) || empty(self::$_apisecret)) {
		  
			if (defined('LR_API_KEY') && null !== LR_API_KEY) {
				self::setDefaultApplication(LR_API_KEY);
			} else {
				throw new FalconException('Required API Key .');
			}
		}
		if (!defined('API_DOMAIN')) {
			define('API_DOMAIN', 'https://api.loginradius.com');
		}
        self::$_options = array_merge(self::$_options, $customizeOptions);
    }

    /**
     * Set API key and API secret.
     *
     * @param type $apikey
     */
    public static function setDefaultApplication($apikey)
    {
        self::_checkAPIValidation($apikey, $apisecret);
        self::$_apikey = $apikey;

    }

    /**
     * Check API Key and Secret in valid GUID format.
     *
     * @param type $apikey
     * @param type $apisecret
     * @throws LoginRadiusException
     */
    private static function _checkAPIValidation($apikey, $apisecret)
    {
        if (empty($apikey) || !self::isValidGuid($apikey)) {
            throw new LoginRadiusException('Required "LoginRadius" API key in valid guid format.');
        }
    }

    /**
     * Get API Key that you set.
     *
     * @return string
     */
    public static function getApiKey()
    {
        if (empty(self::$_apikey) && defined('LR_API_KEY')) {
            self::$_apikey = LR_API_KEY;
        }
        return self::$_apikey;
    }

    /**
     * Get options that you set.
     *
     * @return string
     */
    public static function getCustomizeOptions()
    {
        return self::$_options;
    }

    /**
     * Set options that you set.
     *
     * @return string
     */
    public static function setCustomizeOptions($options = array())
    {
        self::$_options = $options;
    }

    /**
     * _apiClientHandler
     */
    public static function _apiClientHandler($type, $path, $queryParameters= array(), $payload = "")
    {
        $options = array('method' => $type, 'content_type' => 'json');
        if (!empty($payload)) {
            $options['post_data'] = $payload;
        }
        return self::apiClient($path, $queryParameters, $options);
    }

    /**
     * Access LoginRadius API server by External library
     *
     * @global type $apiClientClass
     * @param type $path
     * @param type $queryArray
     * @param type $options
     * @return type
     */
    public static function apiClient($path, $queryArray = array(), $options = array())
    {
        global $apiClientClass;  
        $mergeOptions = array_merge($options, self::$_options);
        if (isset($apiClientClass) && class_exists($apiClientClass)) {
            $client = new $apiClientClass();
        } else {
            $client = new DefaultHttpClient();
        }
        try{
            $response = $client->request($path, $queryArray, $mergeOptions);
        }
        catch(LoginRadiusException $e){
           return $e;
        }
        
        return json_decode($response);
    }

    
    /**
     * URL replacement
     *
     * @param type $decodedUrl
     * @return type
     */
    public static function urlReplacement($decodedUrl)
    {
        $replacementArray = array('%2A' => '*','%28' => '(','%29' => ')');
        return str_replace(array_keys($replacementArray), array_values($replacementArray), $decodedUrl);
    }

    /**
     * Build Query string
     *
     * @param type $data
     * @return type
     */
    public static function queryBuild($data = array())
    {
        if (is_array($data) && sizeof($data) > 0) {
            return http_build_query($data);
        }
        return '';
    }

    /**
     * API validation message
     */
    public static function paramValidationMsg($parameter)
    {
        return "The $parameter method parameter is not formatted or null"; 
    }
}
