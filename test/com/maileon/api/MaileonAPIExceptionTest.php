<?php

class MaileonAPIExceptionTest extends PHPUnit_Framework_TestCase
{

    public function testGetResponse()
    {
        $exception = new com_maileon_api_MaileonAPIException("Something went wrong", "The response");
        $this->assertEquals("The response", $exception->getResponse());
    }
}