<?php

class poll
{
    public $id;
    public $question;
    public $answers;
    public $voters;
    public $public;
    public $allowMultiAnswers;
    public $checkDuplicate;
    public $date;
    public $username;

    public function __construct() {
    }

    public static function parseAnswers($answers, $votes) {
        $new = array();
        $answers = explode('|', $answers);
        $votes = explode('|', $votes);

        for ($i = 0; $i < count($answers); $i++) {
            $new[$i] = [$i, $answers[$i], $votes[$i] ];
        }

        return $new;
    }

    public static function parseVoters($v) {
        $new = array();
        foreach (explode('|', $v) as $item) {
            $new[] = $item;
        }
        return $new;
    }

    public function votersContains($v) {
        foreach ($this->voters as $voter) {
            if($voter == $v)
                return true;
            return false;
        }
    }

    public function serializeSelf() {
        $obj = [
            'pid' => $this->id,
            'question' => $this->question,
            'answer0' => $this->answers[0][1],
            'answer1' => $this->answers[1][1],
            'answer2' => $this->answers[2][1],
            'answer3' => $this->answers[3][1],
            'answer0-count' => $this->answers[0][2],
            'answer1-count' => $this->answers[1][2],
            'answer2-count' => $this->answers[2][2],
            'answer3-count' => $this->answers[3][2]
        ];
        return $obj;
    }
}