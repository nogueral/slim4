<?php
require_once './models/Usuario.php';
require_once './interfaces/IApiUsable.php';
require_once __DIR__ . '/../../vendor/tecnickcom/tcpdf/tcpdf.php';

use Slim\Http\Stream;
use mikehaertl\wkhtmlto\Pdf;


class UsuarioController extends Usuario implements IApiUsable
{
  public function CargarUno($request, $response, $args)
  {
    $parametros = $request->getParsedBody();

    $usuario = $parametros['usuario'];
    $clave = $parametros['clave'];

    // Creamos el usuario
    $usr = new Usuario();
    $usr->usuario = $usuario;
    $usr->clave = $clave;
    $usr->crearUsuario();

    $payload = json_encode(array("mensaje" => "Usuario creado con exito"));

    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }

  public function TraerUno($request, $response, $args)
  {
    // Buscamos usuario por nombre
    $usr = $args['usuario'];
    $usuario = Usuario::obtenerUsuario($usr);
    $payload = json_encode($usuario);

    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }

  public function TraerUnoPorId($request, $response, $args)
  {
    // Buscamos usuario por id
    $id = $args['id'];
    $usuario = Usuario::obtenerUsuarioPorId($id);
    $payload = json_encode($usuario);

    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }

  public function TraerUnPdfPorId($request, $response, $args)
  {
    $id = $args['id'];
    $usuario = Usuario::obtenerUsuarioPorId($id);
    $payload = json_encode($usuario);


    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false, true);

    $pdf->addPage();
    $pdf->write(0, 'My Test');

    $content = $pdf->output('doc.pdf', 'S');
    $fileName = 'example.pdf';

    $response = $response->withHeader('Content-Disposition','application/pdf', sprintf('attachment; filename="%s"', $fileName));

    $stream = fopen('php://memory', 'w+');
    fwrite($stream, $content);
    rewind($stream);

    $response->getBody()->write(fread($stream, (int)fstat($stream)['size']));

    return $response;
  }

  public function TraerTodos($request, $response, $args)
  {
    $lista = Usuario::obtenerTodos();
    $payload = json_encode(array("listaUsuario" => $lista));

    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }

  public function ModificarUno($request, $response, $args)
  {
    $parametros = $request->getParsedBody();

    $nombre = $parametros['nombre'];
    Usuario::modificarUsuario($nombre);

    $payload = json_encode(array("mensaje" => "Usuario modificado con exito"));

    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }

  public function BorrarUno($request, $response, $args)
  {
    $parametros = $request->getParsedBody();

    $usuarioId = $parametros['usuarioId'];
    Usuario::borrarUsuario($usuarioId);

    $payload = json_encode(array("mensaje" => "Usuario borrado con exito"));

    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }
}
