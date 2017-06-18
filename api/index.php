<?php

/**
 * index.php
 * by rashaud
 * Sun June 18 2017
 *
 */

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';

$app = new \Slim\App;

/**
 * main routes
 */
// / GET
$app->get('/', function (Request $request, Response $response) {
    $response->getBody()->write("Home");
    return $response;
});
// /{uri: not in (gallery,photos,tags,categories,search,subscribers,admin)} GET

// /gallery GET
// /gallery/{uri} GET

// /photos GET
// /photos/{uri} GET

// /tags/{uri} GET

// /categories/{uri} GET

// /search GET

// /subscribers GET
// /subscribers POST
// /subscribers/{id} GET
// /subscribers/{id} PUT 
// /subscribers/{id} DELETE

/**
 * admin routes
 */
// /admin GET
// /admin/settings GET
// /admin/settings/{key} PUT

// /admin/accounts GET
// /admin/accounts POST
// /admin/accounts DELETE
// /admin/accounts/{id} GET
// /admin/accounts/{id} PUT
// /admin/accounts/{id} DELETE

// /admin/pages GET
// /admin/pages POST
// /admin/pages DELETE
// /admin/pages/{id} GET
// /admin/pages/{id} PUT
// /admin/pages/{id} DELETE

// /admin/photos GET
// /admin/photos POST
// /admin/photos DELETE
// /admin/photos/{id} GET
// /admin/photos/{id} PUT
// /admin/photos/{id} DELETE

// /admin/galleries GET
// /admin/galleries POST
// /admin/galleries DELETE
// /admin/galleries/{id} GET
// /admin/galleries/{id} PUT
// /admin/galleries/{id} DELETE

// /admin/tags GET
// /admin/tags POST
// /admin/tags DELETE
// /admin/tags/{id} GET
// /admin/tags/{id} PUT
// /admin/tags/{id} DELETE

// /admin/categories GET
// /admin/categories POST
// /admin/categories DELETE
// /admin/categories/{id} GET
// /admin/categories/{id} POST
// /admin/categories/{id} DELETE

// /admin/subscribers GET
// /admin/subscribers POST
// /admin/subscribers DELETE
// /admin/subscribers/{id} GET
// /admin/subscribers/{id} POST
// /admin/subscribers/{id} DELETE

$app->run();







