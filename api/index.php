<?php
class api
{
    private $path;
    private $params;
    function __construct($params)
    {
        $this->params = $params;
        $this->requireParameter($this->params, 'p');
        $this->path = $params['p'];
    }

    function route($path, $params) {
        switch ($path) {
            case 'getAllPolls':
                $this->requireMethod('GET');
                $this->getAllPolls();
                break;
            case 'getPollsByUser':
                $this->requireMethod('GET');
                $this->requireParameter($this->params, 'u');
                $this->getAllPolls();
                break;
        }
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
