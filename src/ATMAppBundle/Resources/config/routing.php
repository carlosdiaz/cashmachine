<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$collection->add('atmapp_homepage', new Route('/hello/{name}', array(
    '_controller' => 'ATMAPPBundle:Default:index',
)));

return $collection;
