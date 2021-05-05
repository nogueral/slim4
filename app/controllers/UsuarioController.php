<?php
require_once './models/Usuario.php';
require_once './interfaces/IApiUsable.php';
require_once __DIR__ . '/../../vendor/tecnickcom/tcpdf/tcpdf.php';

use Slim\Http\Stream;
use mikehaertl\wkhtmlto\Pdf;
use Dompdf\Dompdf;


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
    $html='<h1>Descarga de PDF - Slim Framework 4 - Heroku MYSQL</h1> <h2>Descarga de información de usuarios</h2>
    <ul>
        <li> ID: ' . $usuario->id . '</li>
        <li> Usuario: ' . $usuario->usuario . '</li>
        <li> Clave: ' . $usuario->clave . '</li>
    </ul>';        
    $dompdf = new Dompdf();
    $dompdf->loadHtml('<h4>' . $html . '</h4>');
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->render();
    $archivo = 'pdftest_' . $id . '.pdf';
    $string = $dompdf->output();
    $lengthString = mb_strlen($string, '8bit');
    $response->getBody()->write($string);

    return $response->withHeader('Cache-Control', 'private')
      ->withHeader('Content-type', 'application/pdf')
      ->withHeader('Content-Length', $lengthString)
      ->withHeader('Content-Disposition', 'attachment;  filename=' . $archivo)
      ->withHeader('Accept-Ranges', $lengthString);
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
