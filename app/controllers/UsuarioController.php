<?php
require_once './models/Usuario.php';
require_once './interfaces/IApiUsable.php';

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

    $pdf = new Pdf([
      'no-outline',
      'margin-top'    => 0,
      'margin-right'  => 0,
      'margin-bottom' => 0,
      'margin-left'   => 0,
      'disable-smart-shrinking',
      /*  'user-style-sheet' => '/path/to/pdf.css', */
    ]);

    $pdf->addPage('<html>' . $payload . '</html>');
    $pdf->saveAs('report.pdf');

    return $response->download('report.pdf')->withHeader('Content-Type', 'application/pdf');
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
