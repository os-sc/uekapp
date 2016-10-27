<?php

 abstract class helper
{
    public static function hashPassword($password, $username) {
        password_hash($password, PASSWORD_BCRYPT, ['cost' => 11, 'salt' => $username]);
    }

    public static function checkPassword($password, $username) {
        password_verify($password, PASSWORD_BCRYPT, ['cost' => 11, 'salt' => $username]);
    }
}

?>