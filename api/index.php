<?php
class api
{
    private $path;
    private $params;
    function __construct($params)
    {
        $this->params = $params;
        $this->path = $this->requireParameter($this->params, 'p');
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
        // return results
    }

    function getNewPolls($count){
        // loop through all polls
        // get newest x
        // return result
    }

    function getPollsByUser($username){
        // check username exists
        // return filtered results
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
