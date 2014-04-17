<?php namespace QL\HMVC;

/**
 * @copyright ©2005—2014 Quicken Loans Inc. All rights reserved.
 */

use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;
use Symfony\Component\HttpFoundation\Request;
use Silex\ServiceControllerResolver;

class ModuleControllerResolver implements ControllerResolverInterface
{
    private $resolver;
    public function __construct(ServiceControllerResolver $resolver)
    {
        $this->resolver = $resolver;
    }

    public function strict($strict)
    {
        $this->strict = (bool) $strict;
    }

    public function getController(Request $request)
    {
        return $this->resolver->getController($request);
    }

    //@todo: handle type checking on controller for array, callable and module, maybe add strict mode
    public function getArguments(Request $request, $controller)
    {
        $controller = array($controller[0]->getController(),$controller[1]);
        return $this->resolver->getArguments($request, $controller);
    }
}
