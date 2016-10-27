<?php

class databaseTest extends PHPUnit_Framework_TestCase
{
    function testGetByIdReturnsCorrectId(){
        $api = new api(['p' => 'getAllPolls']);
        $this->assertNotEmpty($api);
    }
}
