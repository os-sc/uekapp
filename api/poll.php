<?php

class poll
{
    public $id;
    public $question;
    public $answers;
    public $public;
    public $allowMultiAnswers;
    public $checkDuplicate;
    public $date;
    public $username;

    public function __construct() {
    }

    public function parseAnswers($answers, $votes) {
        $new = array();
        for ($i = 0; $i <= $answers->count(); $i++) {
            $new[$i] = [$i, $answers[$i], $votes[$i] ];
        }
        return $new;
    }

}