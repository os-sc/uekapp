<?php

 abstract class helper
{
    public static function hashPassword($password, $username) {
        $salt = substr(md5($username), 0, 30);
        return password_hash($password, PASSWORD_BCRYPT, ['cost' => 11, 'salt' => $salt]);
    }

    public static function checkPassword($password, $hash) {
        return password_verify($password, $hash);
    }
}

?>