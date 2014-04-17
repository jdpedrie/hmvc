<?php

use QL\HMVC\Module;
use QL\HMVC\Exceptions;
use Mockery as m;

class Controller {
  private $response;

  public function __construct()
  {
    $response = m::mock('Symfony\\Component\\HttpFoundation\\Response');
    $response->shouldReceive('getContent')->andReturn('Hello World');
    $this->response = $response;
  }

  public function index()
  {
    $this->response->shouldReceive('getStatusCode')->andReturn(200);
    return $this->response;
  }

  public function badResponse()
  {
    return 'test';
  }

  public function badStatusCode()
  {
    $this->response->shouldReceive('getStatusCode')->andReturn('404');

    return $this->response;
  }
}

class ModuleTest extends PHPUnit_Framework_TestCase
{
  private $module;

  public function __construct()
  {
    $this->module = new Module(new Controller);
  }

  public function testCall()
  {
    $response = $this->module->index();

    $this->assertEquals($response->getContent(), 'Hello World');
    $this->assertInstanceOf('Symfony\\Component\\HttpFoundation\\Response', $this->module->getResponse());
    $this->assertEquals($this->module->getResponse()->getStatusCode(), 200);
  }

  public function testInvalidMethod()
  {
    try {
      $response = $this->module->foobar();
      $this->assertEquals('Should throw MethodException', 2);
    }
    catch (Exceptions\MethodException $e) {
      $this->assertEquals(1, 1);
    }
    catch(\Exception $e) {
      $this->assertEquals('Should throw MethodException', 3);
    }
  }

  public function testInvalidResponse()
  {
    try {
      $response = $this->module->badResponse();
      $this->assertEquals('Should throw ResponseException', 1);
    }
    catch (Exceptions\ResponseException $e) {
      $this->assertEquals(1, 1);
    }
    catch (\Exception $e) {
      $this->assertEquals('Should throw ResponseException', 3);
    }
  }

  public function testInvalidStatusCode()
  {
    try {
      $response = $this->module->badStatusCode();
      $this->assertEquals('Should throw ModuleException', 1);
    }
    catch (Exceptions\ModuleException $e) {
      $this->assertEquals(1, 1);
    }
    catch (\Exception $e) {
      $this->assertEquals('Should throw ModuleException', 3);
    }
  }
}