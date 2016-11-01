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

    # Self encoding function for potato framework
    public function potato() {
        $potato = array();
        $potato = [
            'id' => $this->id,
            '%phcontent%-question-title' => $this->question,
            '%phcontent%-answer0' => $this->answers[0],
            '%phcontent%-answer1' => $this->answers[1],
            '%phcontent%-answer2' => $this->answers[2],
            '%phcontent%-answer3' => $this->answers[3],
            'question' => $this->question
        ];
    }
}