<?php
class api
{
    public $params;
    public $database;
    function __construct($params)
    {
        $this->params = $params;
        $this->database = new database();
    }

    function route($path = null) {
        if (!isset($path))
            $path = $this->requireParameter($_GET, 'p');
        switch ($path) {
            case 'getAllPolls':
                $this->requireMethod('GET');
                $this->getAllPolls();
                break;
            case 'getNewPolls':
                $this->requireMethod('GET');
                $this->getNewPolls(
                    $this->requireParameter($this->params, 'c')
                );
                break;
            case 'getPollsByUser':
                $this->requireMethod('GET');
                $this->getPollsByUser(
                    $this->requireParameter($this->params, 'u')
                );
                break;
            case 'addPoll':
                $this->requireMethod('POST');
                $this->addPoll(
                    $this->requireParameter($this->params, 'q')
                );
                break;
            case 'login':
                $this->requireMethod('POST');
                $this->login(
                    $this->requireParameter($this->params, 'u'),
                    $this->requireParameter($this->params, 'pw')
                );
                break;
            case 'register':
                $this->requireMethod('POST');
                $this->registerUser(
                    $this->requireParameter($this->params, 'u'),
                    $this->requireParameter($this->params, 'pw')
                );
                break;
            case 'vote':
                $this->requireMethod('POST');
                $this->login(
                    $this->requireParameter($this->params, 'pid'),
                    $this->requireParameter($this->params, 'a')
                );
                break;
        }
    }

    function getAllPolls(){
        $data = $this->database->getAllPolls();
        $this->httpReturnAsJson(200, $data);
    }

    function getNewPolls($count){
        $data = $this->database->getNewPolls();
        $this->httpReturnAsJson(200, array_slice($data, 0, $count));
    }

    function getPollsByUser($username){
        $data = $this->database->getPollsByUser($username);
        $this->httpReturnAsJson(200, $data);
    }

    function login($username, $password) {
        if (!$this->database->userExists($username))
            $this->httpReturn(401, 'Ungültiger Username oder Passwort.');

        if (strlen($password) < 8)
            $this->httpReturn(401, 'Ungültiger Username oder Passwort.');

        $pwhash = helper::hashPassword($password, $username);
        $result = helper::checkPassword($password, $pwhash);

        if($result) {
            // TODO: do session handling
            $this->httpReturn(200, 'Login erfolgreich.');
        }
        else {
            $this->httpReturn(401, 'Ungültiger Username oder Passwort.');
        }
    }

    function registerUser($username, $password) {
        try {
            if ($this->database->userExists($username))
                $this->httpReturn(400, 'Username bereits vergeben.');

            if (strlen($password) < 8)
                $this->httpReturn(400, 'Passwort muss mind. 8 Zeichen lang sein.');

            $newuser = new user(true);
            $newuser->name = $username;
            $newuser->hashedpw = helper::hashPassword($password, $username);

            $this->database->addUser($newuser);
        }
        catch(Exception $e) {
            $this->httpReturn(500, 'Interner Fehler.');
        }

        $this->httpReturn(200, 'User angelegt.');
    }

    function vote($pollId, $answers){
        // check login
        // check pollId
        // save vote
        // return ok
    }

    function httpReturnAsJson($code, $data) {
        $this->httpReturn($code, json_encode($data));
    }

    function httpReturn($code, $data) {
        http_response_code($code);
        echo($data);
        exit(0);
    }

    function decodeJson($json) {
        return json_decode($json, true);
    }

    function requireParameter($collection, $paramName){
        if (!isset($collection[$paramName]))
            die('Missing Parameter ' . $paramName); // TODO: return http error
        else
            return $collection[$paramName];
    }

    function requireMethod($meth){
        if ($_SERVER['REQUEST_METHOD'] != $meth)
            die('Missing Parameter'); // TODO: return http error
        else
            return;
    }
}


?>
