<?php
require_once './models/Usuario.php';
require_once './interfaces/IApiUsable.php';

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

        $usuario = $parametros['usuario'];
        $clave = $parametros['clave'];

        // Creamos el usuario
        $usr = new Usuario();
        $usr->usuario = $usuario;
        $usr->clave = $clave;
        $usr->id = $args['id'];
        $columnas = $usr->modificarUsuario();

        if($columnas != false){
          $payload = json_encode(array("mensaje" => "Usuario modificado con exito"));
        }else{
          $payload = json_encode(array("mensaje" => "No se pudo modificar"));
        }

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function BorrarUno($request, $response, $args)
    {
        //$parametros = $request->getParsedBody();

        //$usuarioId = $parametros['usuarioId'];
        $usuarioId = $args['id'];

        $usuario = Usuario::obtenerUsuario($usuarioId);

        if($usuario != false){
          Usuario::borrarUsuario($usuarioId);
          $payload = json_encode(array("mensaje" => "Usuario borrado con exito"));
        } else{
          $payload = json_encode(array("mensaje" => "No se encontro usuario"));
        }


        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function ValidarUsuario($request, $response, $args){

      $parametros = $request->getParsedBody();

      $usuario = $parametros['usuario'];
      $clave = $parametros['clave'];
      $usr = new Usuario();
      $usr->usuario = $usuario;
      $usr->clave = $clave;

      $auxUser = Usuario::obtenerUsuario($usr->usuario);

      $retorno = $usr->Equals($auxUser);


      if($retorno == 1){
        $payload = json_encode(array("mensaje" => "Login exitoso"));
      } else if($retorno == 0){
        $payload = json_encode(array("mensaje" => "Error en la clave"));
      } else{
        $payload = json_encode(array("mensaje" => "Usuario incorrecto"));
      }


      $response->getBody()->write($payload);
      return $response
        ->withHeader('Content-Type', 'application/json');


    }
}