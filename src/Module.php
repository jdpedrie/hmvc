<?php namespace QL\HMVC;

/**
 * @copyright ©2005—2014 Quicken Loans Inc. All rights reserved.
 */

use Symfony\Component\HttpFoundation\Response;
use QL\HMVC\Exceptions;

class Module
{
    private $controller;
    private $response;

    /**
     * @codeCoverageIgnore
     */
    public function __construct($controller)
    {
        $this->controller = $controller;
    }

    public function __call($method, $args = array())
    {
        if (!method_exists($this->controller, $method)) {
            $this->throwMethodException();
        }

        $this->response = call_user_func_array(array($this->controller, $method), $args);

        if (!($this->response instanceof Response)) {
            $this->throwResponseException();
        }

        if ($this->response->getStatusCode() === 200) {
            return $this->response;
        }

        $this->throwException($this->response->getContent());
    }

    private function throwException($message)
    {
        throw new Exceptions\ModuleException($message);
    }

    private function throwResponseException()
    {
        throw new Exceptions\ResponseException();
    }

    private function throwMethodException()
    {
        throw new Exceptions\MethodException();
    }

    public function getController()
    {
        return $this->controller;
    }

    public function getResponse()
    {
        return $this->response;
    }
}
