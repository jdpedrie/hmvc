<?php
use Symfony\Component\HttpFoundation\Response;

class PageController
{
    public function index()
    {
        return new Response("Hello World");
    }
}
