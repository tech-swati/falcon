<?php

/**
 * @link : http://www.example.com
 * @category : FalconSDK
 * @package : FalconException
 * @author : Falcon Team
 * @version : 1.0.0
 * @license : https://opensource.org/licenses/MIT
 */
namespace FalconSDK;

/**
 * Class For SDK Exception
 * This is the Exception class to handle exception when you access APIs.
 *
 */
class FalconException extends \Exception
{

    public $error_response;

    /**
     * Get error message and set error response.
     *
     * @param string $message
     * @param array $error_response
     */
    public function __construct($message, $error_response = false)
    {
        parent::__construct($message);
        $this->error_response = $error_response;
    }

    /**
     * Get error Response from API.
     *
     * @return array
     */
    public function getErrorResponse()
    {
        return $this->error_response;
    }
}