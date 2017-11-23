<?php

class PingServiceTest extends PHPUnit_Framework_TestCase
{
    private static $service;

    public static function setUpBeforeClass()
    {
        self::$service = new com_maileon_api_utils_PingService($GLOBALS['config']);
    }

    public function testGet()
    {
        $response = self::$service->pingGet();
        $this->assertTrue($response->isSuccess());
    }

    public function testPut()
    {
        $response = self::$service->pingGet();
        $this->assertTrue($response->isSuccess());
    }

    public function testDelete()
    {
        $response = self::$service->pingGet();
        $this->assertTrue($response->isSuccess());
    }

    public function testPost()
    {
        $response = self::$service->pingGet();
        $this->assertTrue($response->isSuccess());
    }
}