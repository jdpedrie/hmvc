<?php

class ServiceModuleServiceProviderTest extends PHPUnit_Framework_TestCase
{
    public function testRegister()
    {
        $app = new Silex\Application();
        $app->register(new QL\HMVC\ServiceModuleServiceProvider);
        $this->assertInstanceOf('QL\\HMVC\\ModuleControllerResolver',$app['resolver']);
    }
}
