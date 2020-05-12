<?php 
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
// Composer autoloader
require 'vendor/autoload.php'; 

require 'init.php'; 


$app = AppFactory::create();

// Add error middleware
$app->addErrorMiddleware(true, true, true);

// Home Page
// Company and its Contacts List
$app->get('/', function (Request $request, Response $response, $args)
{
    $Controller = new App\Controllers\Controller;
    $Controller->index();
    return $response;
});
 
 
// Add company and Contact
// Show register company and Contact form
$app->get('/add', function (Request $request, Response $response, $args)
{
    $Controller = new \App\Controllers\Controller;
    $Controller->create();
    return $response;
});
 
// process register company and Contact form
$app->post('/add', function (Request $request, Response $response, $args)
{
    $Controller = new \App\Controllers\Controller;
    $Controller->store();
    return $response;
});
 
 
// Edit company and Contact
// Show Company Edit Form
$app->get('/edit/{id}', function (Request $request, Response $response, $args)
{
    // Get ID from URL
    $id = $args['id'];
 
    $Controller = new \App\Controllers\Controller;
    $Controller->edit($id);
    return $response;
});
 
// Process company edit form
$app->post('/edit', function (Request $request, Response $response, $args)
{
    $Controller = new \App\Controllers\Controller;
    $Controller->update();
    return $response;
});

// Edit contact
// Show Edit contact Form
$app->get('/edit/contact/{id}', function (Request $request, Response $response, $args)
{
    // Get ID from URL
    $id = $args['id'];
 
    $Controller = new \App\Controllers\ContactController;
    $Controller->edit($id);
    return $response;
});
 
// Process Edit contact Form
$app->post('/edit/contact', function (Request $request, Response $response, $args)
{
    $Controller = new \App\Controllers\ContactController;
    $Controller->update();
    return $response;
});
 
// Delete Company
$app->get('/remove/{id}', function (Request $request, Response $response, $args)
{
    // Get ID from URL
    $id = $args['id'];
 
    $Controller = new \App\Controllers\Controller;
    $Controller->remove($id);
    return $response;
});

// Delete Contact
$app->get('/remove/contact/{id}', function (Request $request, Response $response, $args)
{
    // Get ID from URL
    $id = $args['id'];
 
    $Controller = new \App\Controllers\ContactController;
    $Controller->remove($id);
    return $response;
});

// Receive deal event updated
$app->post('/deal_updated', function (Request $request, Response $response, $args)
{
    $Controller = new \App\Handlers\DealHandler;
    $Controller->dealUpdated($request);
    return $response;
});
 
$app->run();