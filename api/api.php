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
        session_start();
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
            case 'getPollById':
                $this->requireMethod('GET');
                $this->getPollById(
                    $this->requireParameter($this->params, 'id')
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
                    $this->requireParameter($this->params, 'q'),
                    [
                        $this->requireParameter($this->params, 'a0'),
                        $this->requireParameter($this->params, 'a1'),
                        $this->requireParameter($this->params, 'a2'),
                        $this->requireParameter($this->params, 'a3')
                    ],
                    $this->requireParameter($this->params, 'pub'),
                    $this->requireParameter($this->params, 'dupes')
                );
                break;
            case 'login':
                $this->requireMethod('POST');
                $this->login(
                    $this->requireParameter($this->params, 'u'),
                    $this->requireParameter($this->params, 'pw')
                );
                break;
            case 'logout':
                $this->logout();
                break;
            case 'getLoginInfo':
                $this->requireMethod('GET');
                $this->getLoginInfo();
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
                $this->vote(
                    $this->requireParameter($this->params, 'pid'),
                    $this->params
                );
                break;
            case 'makeCoffee':
                $this->httpReturn(418, 'I\'m a teapot.');
        }
    }

    function getAllPolls(){
        $data = $this->database->getAllPolls();
        $this->httpReturnAsJson(200, $data);
    }

    function getNewPolls($count){
        $data = $this->database->getNewPolls();
        $arr = array();
        if ($count < count($data))
            $data = array_slice($data, 0, $count);
        foreach ($data as $poll) {
            $arr[] = $poll->serializeSelf();
        }
        $this->httpReturnAsJson(200, $arr);
    }

    function getPollsByUser($username){
        $data = $this->database->getPollsByUser($username);
        $this->httpReturnAsJson(200, $data->serializeSelf());
    }

    function getPollById($pid) {
        $data = $this->database->getPollById($pid);
        $this->httpReturnAsJson(200, $data->serializeSelf());
    }

    function login($username, $password) {
        if(isset($_SESSION['username']))
            $this->httpReturn(400, 'Du bist bereits angemeldet.');

        if (!$this->database->userExists($username))
            $this->httpReturn(401, 'Ungültiger Username oder Passwort.');

        if (strlen($password) < 8)
            $this->httpReturn(401, 'Ungültiger Username oder Passwort.');

        $pwhash = $this->database->getPwOfUser($username);
        if ($pwhash == '-1')
            $this->httpReturn(401, 'Ungültiger Username oder Passwort.');

        $result = helper::checkPassword($password, $pwhash);

        if($result) {
            if (!session_start())
                $this->httpReturn(500, 'Interner Fehler.');

            $_SESSION['username'] = $username;
            $this->httpReturn(200, 'Login erfolgreich.');
        }
        else {
            $this->httpReturn(401, 'Ungültiger Username oder Passwort.');
        }
    }

    function getLoginInfo() {
        if(session_status() == PHP_SESSION_ACTIVE)
            if(isset($_SESSION['username']))
                $this->httpReturn(200, $_SESSION['username']);
        $this->httpReturn(200, 'false');
    }

    function logout(){
        $_SESSION = array();
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params["path"],
                $params["domain"], $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
        $this->httpReturn(200, 'Logged out.');
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
            $this->login($username, $password);
        }
        catch(Exception $e) {
            $this->httpReturn(500, 'Interner Fehler.');
        }
        $this->httpReturn(200, 'User angelegt.');
    }

    function addPoll($q, $a, $public, $dupes) {
        $uid = 0;
        if(isset($_SESSION['username'])) {
            $uid = $this->database->getIdOfUser($_SESSION['username']);
        }

        $answers = '';
        $answerCounts = '';
        foreach ($a as $item) {
            if (strlen($item) > 100)
                $this->httpReturn(400, 'Antworten können nicht länger als 100 Zeichen sein.');
            if (strpos($item, '|') !== false)
                $this->httpReturn(400, 'Antworten können kein "|" enthalten.');

            if (empty($answers)) {
                $answers = $item;
                $answerCounts = '0';
                continue;
            }

            $answers = $answers.'|'.$item;
            $answerCounts = $answerCounts.'|0';
        }
        if($public != 'true' || !$public) $public = false;
        else $public = true;
        if($dupes != 'true' || !$dupes) $dupes = false;
        else $dupes = true;

        $now = date('U');
        $this->database->addPoll(
            $q,
            $answers,
            $answerCounts,
            $public,
            $dupes,
            $now,
            $uid);
        $this->httpReturn(200, 'Neue Umfrage angelegt.');
    }

    function vote($pollId, $collection){
        $ipaddr = $_SERVER['REMOTE_ADDR'];

        if(!$this->database->pollExists($pollId))
            $this->httpReturn(404, 'Keine Umfrage mit dieser ID gefunden.');

        $answers = array();
        $answers[0] = false;
        $answers[1] = false;
        $answers[2] = false;
        $answers[3] = false;
        if (isset($collection['a0'])
            && $collection['a0'] != '')
            $answers[0] = true;
        if (isset($collection['a1'])
            && $collection['a1'] != '')
            $answers[1] = true;
        if (isset($collection['a2'])
            && $collection['a2'] != '')
            $answers[2] = true;
        if (isset($collection['a3'])
            && $collection['a3'] != '')
            $answers[3] = true;

        if(!$answers[0] && !$answers[1] && !$answers[2] && !$answers[3])
            $this->httpReturn(200, 'Nichts angegeben.');

        $poll = $this->database->getPollById($pollId);

        if($poll->votersContains($ipaddr) && $poll->checkDuplicate)
            $this->httpReturn(403, 'Du hast bereits abgestummen');

        $i = 0;
        foreach ($answers as $answer) {
            if($answer == true) {
                $this->database->addVote($pollId, $i, $ipaddr);
            }
            $i++;
        }

        $this->httpReturn(200, 'Gespeichert.');
    }

    function httpReturnAsJson($code, $data) {
        header('Content-Type: application/json');
        echo(json_encode($data));
        http_response_code($code);
        exit(0);
    }

    function httpReturn($code, $data) {
        header('Content-Type: text/plain');
        echo($data);
        http_response_code($code);
        exit(0);
    }

    function decodeJson($json) {
        return json_decode($json, true);
    }

    function requireParameter($collection, $paramName){
        if (!isset($collection[$paramName])
        || $collection[$paramName] == '')
            $this->httpReturn(400, 'Nicht alle Felder ausgefüllt // ' . $paramName);
        else
            return $collection[$paramName];
    }

    function requireMethod($meth){
        if ($_SERVER['REQUEST_METHOD'] != $meth)
            $this->httpReturn(400, 'Ungültige anfrage // ' . $_SERVER['REQUEST_METHOD']);
        else
            return;
    }
}


?>
