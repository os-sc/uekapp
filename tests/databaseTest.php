<?php

class databaseTest extends PHPUnit_Framework_TestCase
{
    function testGetByIdReturnsCorrectId(){
        $_GET = ['p' => 'getPollById'];
        $data = new api(['pid' => '0']);
        assertequals($data->id, 0);
    }
}
