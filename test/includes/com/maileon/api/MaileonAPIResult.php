<?php 

/**
 * The result of making a call to the Maileon REST API.
 * 
 * This class encapsulates the technical details of the REST API's HTTP response. In order
 * to retrieve the payload result in deserialized form, just call
 * com_maileon_api_MaileonAPIResult::getResult().
 * 
 * However, this class also allows the underlying HTTP response information to be queried,
 * including the returned status code (com_maileon_api_MaileonAPIResult::getStatusCode())
 * and content type (com_maileon_api_MaileonAPIResult::getContentType()) as well as the raw
 * HTTP response body data (com_maileon_api_MaileonAPIResult::getBodyData()).
 */
class com_maileon_api_MaileonAPIResult {
	private $curlSession;
	
	private $statusCode;
	private $contentType;
	
	private $bodyData = null;
	private $resultXML = null;
	private $result = null;
        
        private $deserializationType = null;
	
	/**
	 * Creates a new result object from the curl response and session data.
	 * 
	 * @param string $bodyData
	 *  the HTTP body data, null if there was none
	 * @param mixed $curlSession
	 *  the cURL session that was used
	 * @param bool $throwException
	 *  if true, an exception will be thrown in case of a connection or server error
         * @param mixed $deserializationType
         *  The name of the class this result should be deserialized as. Use
         *      array( 'array', 'typename' ) to deserialize arrays of a type.
	 * @throws com_maileon_api_MaileonAPIException
	 *  if $throwException == true and there was a connection problem or a server error occurred
	 */
	public function __construct($bodyData, $curlSession, $throwException = true, $deserializationType = null)
	{
		$this->bodyData = $bodyData;
		$this->curlSession = $curlSession;
                $this->deserializationType = $deserializationType;
		$this->checkResult($throwException);
	}
	
	private function checkResult($throwException) {
		$this->statusCode = curl_getinfo($this->curlSession, CURLINFO_HTTP_CODE);
		$this->contentType = curl_getinfo($this->curlSession, CURLINFO_CONTENT_TYPE);
		$this->setResultFields();
		if ($throwException === true) {
			$this->checkForCURLError();
			$this->checkForServerError();
		}
	}
	
	private function checkForCURLError() {
		if (curl_errno($this->curlSession)) {
			$curlErrorMessage = curl_error($this->curlSession);
			$curlErrorCode = curl_errno($this->curlSession);
			throw new com_maileon_api_MaileonAPIException("An error occurred in the connection to the REST API. Original cURL error message: ${curlErrorMessage}", $curlErrorCode);
		}
	}
	
	private function checkForServerError() {
		$statusCode = $this->statusCode;
		if ($statusCode >= 500 && $statusCode <= 599) {
			throw new com_maileon_api_MaileonAPIException("A server error occurred in the REST API (HTTP status code ${statusCode}).",
					$this->bodyData);
		}
	}
	      
	private function setResultFields() {
            if ($this->bodyData) {
                // AddressCheck uses application/xml;charset=utf-8 content type
                if ($this->contentType == 'application/vnd.maileon.api+xml' || $this->contentType == 'application/xml;charset=utf-8') {
                    if ($this->startsWith(trim($this->bodyData), "<")) {
                            $this->resultXML = new SimpleXMLElement($this->bodyData);
                            $this->result = com_maileon_api_xml_XMLDeserializer::deserialize($this->resultXML);
                    }
                    if (!isset($this->result) && !is_array($this->result)) {
                            $this->result = $this->bodyData;
                    }

                } else if ($this->contentType == "application/json" || $this->contentType == 'application/vnd.maileon.api+json') {
                    $this->result = com_maileon_api_json_JSONDeserializer::json_decode($this->bodyData, $this->deserializationType);
                } else {
                    $this->result = $this->bodyData;
                }
            }
	}
	
	/**
	 * @return \em mixed
	 *  the deserialized result object as a subclass of com_maileon_api_xml_AbstractXMLWrapper,
	 *  or the free-form string result if the response body data was not a deserializable object,
	 *  or null if there was no response body data
	 */
	public function getResult() {
		return $this->result;
	}
	
	/**
	 * @return \em number
	 *  the HTTP status code that was returned by the HTTP request
	 */
	public function getStatusCode() {
		return $this->statusCode;
	}
	
	/**
	 * @return \em bool
	 *  true iff a 2xx status code (success) was returned by the HTTP request
	 */
	public function isSuccess() {
		return $this->statusCode >= 200 and $this->statusCode <= 299;
	}
	
	/**
	 * @return \em bool
	 *  true iff a 4xx status code (client error) was returned by the HTTP request
	 */
	public function isClientError() {
		return $this->statusCode >= 400 and $this->statusCode <= 499;
	}
	
	/**
	 * @return \em string
	 *  the content type returned by the HTTP request
	 */
	public function getContentType() {
		return $this->getContentType();
	}
	
	/**
	 * @return \em string
	 *  the unprocessed HTTP body data, or null if there was no body
	 */
	public function getBodyData() {
		return $this->bodyData;
	}
	
	/**
	 * @return \em SimpleXMLElement
	 *  the HTTP body data parsed as a SimpleXMLElement, or null if there was no XML in the body
	 */
	public function getResultXML() {
		return $this->resultXML;
	}
	
	/**
	 * @return \em string
	 *  a human-readable representation of the HTTP request result
	 */
	public function toString() {
		$result = "";
		$result .= "status code: " . $this->getStatusCode() . " "
				. com_maileon_api_HTTPResponseCodes::getStringFromHTTPStatusCode($this->getStatusCode()) . "\n";
		$result .= "is success: " . ($this->isSuccess() ? "true" : "false") . "\n";
		$result .= "is client error: " . ($this->isClientError() ? "true" : "false") . "\n";
		if ($this->bodyData) {
			$result .= "\nbody data:\n";
			$result .= $this->bodyData;
			$result .= "\n\n";
		} else {
			$result .= "No body data.\n";
		}
		if ($this->resultXML) {
			$result .= "Body contains XML.\n";
		}
		$resultType = gettype($this->result);
		if ($resultType == "object") {
			$result .= "Result type: " . get_class($this->result) . "\n";
		} else {
			$result .= "result type: " . $resultType . "\n";
		}
		return $result;
	}

	private function startsWith($haystack, $needle) {
		// search backwards starting from haystack length characters from the end
		return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
	}
}

?>