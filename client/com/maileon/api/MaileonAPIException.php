<?php

/**
 * An exception that is thrown when a technical error has occurred either in the communication
 * with Maileon's REST API or in the API itself.
 */
class com_maileon_api_MaileonAPIException extends RuntimeException
{
    private $response;

    public function __construct($message = "", $response = false, $code = 0,
                                Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->response = $response;
    }

    /**
     *
     * @return \em false|string
     *  the HTTP response body if there was one, false otherwise
     */
    public function getResponse()
    {
        return $this->response;
    }
}

?>