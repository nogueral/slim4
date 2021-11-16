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
        $tipo = $parametros['tipo'];

        // Creamos el usuario
        $usr = new Usuario();
        $usr->usuario = $usuario;
        $usr->clave = $clave;
        $usr->tipo = $tipo;
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
        //var_dump($parametros);

        $usuario = $parametros['usuario'];
        $clave = $parametros['clave'];
        $tipo = $parametros['tipo'];

        // Creamos el usuario
        $usr = new Usuario();
        $usr->usuario = $usuario;
        $usr->clave = $clave;
        $usr->tipo = $tipo;
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
      $payload = json_encode(array("mensaje" => "Error de autenticacion"));

      $auxUser = Usuario::obtenerUsuario($usuario);

      if($auxUser != false){

        $validar = password_verify($clave, $auxUser->clave);
        //var_dump($validar);
        if($validar){

          $datos = array('usuario' => $usuario, 'clave' => $auxUser->clave, 'tipo' => $auxUser->tipo);
          $token = AutentificadorJWT::CrearToken($datos);
          $payload = json_encode(array("jwt" => $token, "response" => "ok", "perfil de usuario" => $auxUser->tipo));
        }

      };


      $response->getBody()->write($payload);
      return $response
        ->withHeader('Content-Type', 'application/json');


    }
}