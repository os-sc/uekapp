<?php

class databaseTest extends PHPUnit_Framework_TestCase
{
    function testGetByIdReturnsCorrectId() {
        $api = new api(['pid' => '0']);
        $api->route('getPollById');
        assertequals($api->id, 0);
    }
}
