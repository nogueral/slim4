<?php

use Slim\Psr7\Response as Response;

class Logger
{


    public static function VerificadorUsuariosRegistrados($request, $handler){

      $header = $request->getHeaderLine('Authorization');
      $token = trim(explode("Bearer", $header)[1]);
      $esValido = false;

      if($token != null){

        try {
          AutentificadorJWT::VerificarToken($token);
          $esValido = true;

        } catch (Exception $e) {
          $payload = json_encode(array('error' => $e->getMessage()));
        }
  
        if($esValido){
  
          $response = $handler->handle($request);
  
        } else{
  
          $response = new Response();
          $response->getBody()->write(json_encode(array('error' => 'error de autenticacion')));
        }

      } else {

          $response = new Response();
          $response->getBody()->write(json_encode(array('error' => 'token vacio')));
      }
      
        return $response->withHeader('Content-Type', 'application/json'); 
    }


    public static function VerificadorAdmin($request, $handler){

      $header = $request->getHeaderLine('Authorization');
      $token = trim(explode("Bearer", $header)[1]);
  
      if($token != null){

        try {
          $payload = AutentificadorJWT::ObtenerData($token);
        } catch (Exception $e) {
          $payload = json_encode(array('error' => $e->getMessage()));
        }

        //var_dump($payload);
  
        if($payload->tipo == 'admin'){
  
          $response = $handler->handle($request);
  
        } else{
  
          $response = new Response();
          $response->getBody()->write(json_encode(array('error' => 'error de autenticacion')));
        }

      } else {

          $response = new Response();
          $response->getBody()->write(json_encode(array('error' => 'token vacio')));
      }
      
        return $response->withHeader('Content-Type', 'application/json'); 


    }

}