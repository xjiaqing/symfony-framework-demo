<?php


use Calendar\Controller\LeapYearController;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

$routes = new RouteCollection();;
$routes->add('leap_year', new Route('/is-leap-year/{year}', [
        'year' => null,
        '_controller' => LeapYearController::class . '::index',
    ]
));