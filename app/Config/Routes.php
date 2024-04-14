<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\News;
use App\Controllers\Pages;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('news', [News::class, "index"]);
$routes->get('news/(:segment)', [News::class, "view"]);

$routes->get('pages', [Pages::class, "index"]);
$routes->get('(:segment)', [Pages::class, "view"]);
