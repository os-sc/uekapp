<?php
function __autoload ($c){
    $c = strtolower($c).'.php';
    if(file_exists($c)){include($c);}
}


if ($_SERVER['REQUEST_METHOD'] == 'GET')
    $api = new api($_GET);
elseif ($_SERVER['REQUEST_METHOD'] == 'POST')
    $api = new api($_POST);
else
    die('error 400');

#$newuser = new user(true);
#$newuser->hashedpw = 'IchBinK1Genie';
#$newuser->name = 'Bob';

#$api->database->addUser($newuser);

$api->route();

?>