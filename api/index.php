<?php
class api
{
    private $path;
    private $params;
    private $database;
    function __construct($params)
    {
        $this->params = $params;
        $this->path = $this->requireParameter($this->params, 'p');
        $this->database = new database();
    }

    function route($path) {
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
                $this->getAllPolls(
                    $this->requireParameter($this->params, 'u')
                );
                break;
            case 'login':
                $this->requireMethod('POST');
                $this->login(
                    $this->requireParameter($this->params, 'u'),
                    $this->requireParameter($this->params, 'p')
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
        $data = $this->database->getPollsByUser();
        $this->httpReturnAsJson(200, $data);
    }

    function login($username, $password) {

        // check username exists
        // hash pw
        // compare
        // return result
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
        echo(var_dump($data));
    }

    function decodeJson($json) {
        return json_decode($json, true);
    }

    function requireParameter($collection, $paramName){
        if (!isset($collection[$paramName]))
            die('Missing Parameter' . $paramName); // TODO: return http error
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
