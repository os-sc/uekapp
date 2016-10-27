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
                "public" => true,
                "ORDER" => "date DESC"
            ]
        );
        return $this->parseToPoll($data);
    }

    function getUserById($id) {
        $data = $this->database->select(
            'users',
            'username',
            ['index' => $id]
        );
        return $data[0]['username'];
    }

    function getIdOfUser($username) {
        $data = $this->database->select(
            'users',
            'index',
            ['username' => $username]
        );
        return $data[0]['index'];
    }


    function parseToPoll($data){
        $new = new poll();
        foreach ($data as $item) {
            $new->id = $item['id'];
            $new->question = $item['question'];
            $new->answers = $new->parseAnswers($item['answers'], $item['answercounts']);
            $new->public = $item['public'];
            $new->allowMultiAnswers = $item['allowmulti'];
            $new->checkDuplicate = $item['checkdupes'];
            $new->date = $item['date'];
        }
        return $new;
    }





}

?>