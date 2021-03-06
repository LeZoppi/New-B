<?php
error_reporting(-1);
ini_set('display_errors', 1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;
use Slim\Routing\RouteContext;
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/acessoDatos/AcessoDatos.php';
require __DIR__ . '/entidades/usuario.php';
require __DIR__ . '/controllers/usuarioController.php';
require __DIR__ . '/entidades/juegos.php';
require __DIR__ . '/controllers/juegosController.php';


$app = AppFactory::create();
$app->addErrorMiddleware(true, true, true);

// Enable CORS

$app->add(function (
    Request $request,
    RequestHandlerInterface $handler
): Response {

    $response = $handler->handle($request);

    $requestHeaders = $request->getHeaderLine('Access-Control-Request-Headers');

    $response = $response->withHeader('Access-Control-Allow-Origin', '*');
    $response = $response->withHeader('Access-Control-Allow-Methods','get,post');
    $response = $response->withHeader('Access-Control-Allow-Headers',$requestHeaders);

    return $response;
});

$app->get('/hello/{name}', function (
    Request $request,
    Response $response,
    array $args
) {
    $name = $args['name'];
    $response->getBody()->write("Hello, $name");
    return $response;
});

$app->post('[/]', \usuarioController::class . ':CrearUsuario');
$app->post('/login[/]', \usuarioController::class . ':retornarUsuario');
$app->get('/juegos[/]', \juegosController::class . ':RetornarJuegos');
$app->post('/altajuego[/]', \juegosController::class . ':Alta');
$app->post('/eliminarjuego[/]', \juegosController::class . ':DeleteJuegos');
$app->post('/FormModJuego[/]', \juegosController::class . ':obtenerFormMod');
$app->post('/modificarjuego[/]', \juegosController::class . ':ModJuegos');




$app->run();