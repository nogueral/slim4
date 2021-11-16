<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Routing\RouteCollectorProxy;
use Slim\Routing\RouteContext;
use Slim\Ps7\Response as ResponseMW;

require __DIR__ . '/../vendor/autoload.php';
require_once './controllers/UsuarioController.php';
require_once './controllers/CriptomonedaController.php';
require_once './controllers/VentaCriptoController.php';
require_once './db/AccesoDatos.php';
require_once './middlewares/Logger.php';
require_once './middlewares/AutentificadorJWT.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$app = AppFactory::create();
$app->setBasePath('/public');
/*
por bash:
composer update
php -S localhost:666 -t public
localhost:666/public/

para jwt:
composer require firebase/php-jwt
*/
$app->addRoutingMiddleware();

$app->addBodyParsingMiddleware();
$errorMiddleware = $app->addErrorMiddleware(true, true, true);

$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write("hola alumnos de los lunes!");
    return $response;
});

// peticiones
$app->group('/usuarios', function (RouteCollectorProxy $group) {
    $group->get('[/]', \UsuarioController::class . ':TraerTodos');
    $group->get('/{usuario}', \UsuarioController::class . ':TraerUno');
    $group->post('[/]', \UsuarioController::class . ':CargarUno');
    $group->put('/{id}', \UsuarioController::class . ':ModificarUno');
    $group->delete('/{id}', \UsuarioController::class . ':BorrarUno');
  });

  $app->group('/criptomonedas', function (RouteCollectorProxy $group) {
    $group->post('[/]', \CriptomonedaController::class . ':CargarUno')->add(\Logger::class . ':VerificadorAdmin');
    $group->get('[/]', \CriptomonedaController::class . ':TraerTodos');
    $group->get('/nacionalidad/{nacionalidad}', \CriptomonedaController::class . ':TraerTodosPorNacionalidad');
    $group->get('/id/{id}', \CriptomonedaController::class . ':TraerUno')->add(\Logger::class . ':VerificadorUsuariosRegistrados');
    $group->delete('/{id}', \CriptomonedaController::class . ':BorrarUno')->add(\Logger::class . ':VerificadorAdmin');
    $group->post('/modificar', \CriptomonedaController::class . ':ModificarUno')->add(\Logger::class . ':VerificadorAdmin');
  });

  $app->group('/ventaCripto', function (RouteCollectorProxy $group) {
    $group->post('[/]', \VentaCriptoController::class . ':CargarUno')->add(\Logger::class . ':VerificadorUsuariosRegistrados');
    $group->get('/ventas/{fechaUno}/{fechaDos}/{nacionalidad}', \VentaCriptoController::class . ':TraerVentasPorFecha')->add(\Logger::class . ':VerificadorAdmin');
    $group->get('/usuarios/{cripto}', \VentaCriptoController::class . ':ObtenerUsuarios')->add(\Logger::class . ':VerificadorAdmin');
    $group->get('/traerTodos', \VentaCriptoController::class . ':TraerTodos');
  });

$app->group('/login', function (RouteCollectorProxy $group) {
    $group->post('[/]', \UsuarioController::class . ':ValidarUsuario');
  });

// Run app
$app->run();

