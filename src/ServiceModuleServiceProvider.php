<?php namespace QL\HMVC;

/**
 * @copyright ©2005—2014 Quicken Loans Inc. All rights reserved.
 */

use Silex\ServiceControllerResolver;
use Silex\Application;
use Silex\ServiceProviderInterface;

class ServiceModuleServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['resolver'] = $app->share($app->extend('resolver', function ($resolver, $app) {
            $serviceResolver = new ServiceControllerResolver($resolver,$app);
            return new ModuleControllerResolver($serviceResolver);
        }));
    }

    public function boot(Application $app)
    {

    }
}

?>
