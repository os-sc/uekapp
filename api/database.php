<?php
require  'medoo.php';
class database
{
    private $database;
    function __construct()
    {
        $this->database = new medoo([
            'database_type' => 'mysql',
            'database_name' => 'umf_db',
            'server' => 'localhost',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8'
        ]);
    }

    function getAllPolls(){
        $data = $this->database->select(
            "polls",
            "*"
        );
        return $this->parseToPoll($data);
    }

    function getPollsByUser($username){
        $uid = $this->getIdOfUser($username);
        $data = $this->database->select(
            "polls",
            "*",
            ['users_index' => $uid]
        );
        return $this->parseToPoll($data);
    }

    function getNewPolls(){
        $data = $this->database->select(
            "polls",
            "*",
            [
                "public" => 1,
                "ORDER" => "polls.date DESC"
            ]
        );
        return $this->parseToPoll($data);
    }

    function getPollById($pid) {
        $data = $this->database->select(
            'polls',
            '*',
            ['index' => $pid]
        );
        return $this->parseToPoll($data)[0];
    }

    function getUserById($id) {
        $data = $this->database->select(
            'users',
            'username',
            ['index' => $id]
        );
        return $data[0]['username'];
    }

    function addUser($user){
        $id = $this->database->insert(
            'users',
            $user->toArray()
        );
    }

    function addPoll($q,
                     $answers,
                     $answerCounts,
                     $public,
                     $dupes,
                     $now,
                     $uid) {
        $data = [
            'question' => $q,
            'answers' => $answers,
            'answercounts' => $answerCounts,
            'public' => $public,
            'checkdupes' => $dupes,
            'date' => $now,
            'creator' => $uid
        ];
        $id = $this->database->insert('polls', $data);
    }

    function addVote($pid, $vote, $voter) {
        $curr = $this->database->select(
            'polls',
            ['index', 'answercounts', 'voters'],
            ['index' => $pid]
        )[0];
        $arr = explode('|', $curr['answercounts']);
        $arr[$vote] = intval($arr[$vote]) + 1;

        $voters = $curr['voters'];
        if(!$voters || $voters == '')
            $voters=$voter;
        else
            $voters = $voters . '|' . $voter;

        $new = $arr[0].'|'.$arr[1].'|'.$arr[2].'|'.$arr[3];
        $this->database->update(
            'polls',
            [
                'answercounts' => $new,
                'voters' => $voters
            ],
            ['index' => $pid]
        );
    }

    function getPwOfUser($username) {
        $data = $this->database->select(
            'users',
            'hashedpw',
            ['username' => $username]
        );
        return $data[0];
    }

    function getIdOfUser($username) {
        $data = $this->database->select(
            'users',
            'index',
            ['username' => $username]
        );
        return $data[0];
    }

    function userExists($username) {
        $data = $this->database->count(
            'users',
            'username',
            ['username' => $username]
        );
        if($data > 0) return true;
        return false;
    }

    function pollExists($pid) {
        $data = $this->database->count(
            'polls',
            'index',
            ['index' => $pid]
        );
        if($data > 0) return true;
        return false;
    }

    function votersContains($pid, $v) {
        $poll = $this->getPollById($pid);
        return $poll->votersContains($v);
    }

    function parseToPoll($data){
        $arr = array();

        if(!$data || !isset($data))
            return null;

        foreach ($data as $item) {
            $new = new poll();
            $new->id = $item['index'];
            $new->question = $item['question'];
            $new->answers = poll::parseAnswers($item['answers'], $item['answercounts']);
            $new->voters = poll::parseVoters($item['voters']);
            $new->public = $item['public'];
            $new->checkDuplicate = $item['checkdupes'];
            $new->date = $item['date'];
            $arr[] = $new;
        }
        return $arr;
    }





}

?>