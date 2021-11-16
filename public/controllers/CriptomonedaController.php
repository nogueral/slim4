<?php
require_once './models/Criptomoneda.php';
require_once './interfaces/IApiUsable.php';


class CriptomonedaController extends Criptomoneda implements IApiUsable
{
    public function CargarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $precio = $parametros['precio'];
        $nombre = $parametros['nombre'];
        $nacionalidad = $parametros['nacionalidad'];
        $foto = 'sin foto';

        $archivos = $request->getUploadedFiles();
        if($archivos['foto']->getError() === UPLOAD_ERR_OK){
          $destino="./fotos/";
          $nombreAnterior=$archivos['foto']->getClientFilename();
          $extension= explode(".", $nombreAnterior);
          $extension=array_reverse($extension);
          $destino=$destino . $nombre.".".$extension[0];
          $archivos['foto']->moveTo($destino);
          $foto = $destino;
        }

        $hortaliza = new Criptomoneda();
        $hortaliza->precio = $precio;
        $hortaliza->nombre = $nombre;
        $hortaliza->foto = $foto;
        $hortaliza->nacionalidad = $nacionalidad;
        $hortaliza->crearCripto();

        $payload = json_encode(array("mensaje" => "Criptomoneda creada con exito"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function ModificarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();
        //var_dump($parametros);
        $id = $parametros['id'];
        $precio = $parametros['precio'];
        $nombre = $parametros['nombre'];
        $nacionalidad = $parametros['nacionalidad'];
        $foto = 'sin foto';

        $archivos = $request->getUploadedFiles();
        if($archivos['foto']->getError() === UPLOAD_ERR_OK){

          $destino="./fotos/";
          $nombreAnterior=$archivos['foto']->getClientFilename();
          $extension= explode(".", $nombreAnterior);
          $extension=array_reverse($extension);
          $destino=$destino . $nombre.".".$extension[0];
          $foto = $destino;
          
          $auxCripto = Criptomoneda::obtenerCriptoPorRuta($foto);

          if($auxCripto != false && $auxCripto->foto == $foto){
            $destino="./backup/";
            $nombreAnterior=$archivos['foto']->getClientFilename();
            $extension= explode(".", $nombreAnterior);
            $extension=array_reverse($extension);
            $destino=$destino . $nombre.".".$extension[0];
            $foto = $destino;

          }

          $archivos['foto']->moveTo($destino);

        }

        $criptomoneda = new Criptomoneda();
        $criptomoneda->id = $id;
        $criptomoneda->precio = $precio;
        $criptomoneda->nombre = $nombre;
        $criptomoneda->foto = $foto;
        $criptomoneda->nacionalidad = $nacionalidad;
        $columnas = $criptomoneda->modificarCripto();

        if($columnas != false){
          $payload = json_encode(array("mensaje" => "Criptomoneda modificada con exito"));
        }else{
          $payload = json_encode(array("mensaje" => "No se pudo modificar"));
        }

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerTodos($request, $response, $args)
    {
        
        $lista = Criptomoneda::TraerTodosCripto();
        $payload = json_encode(array("Criptomonedas" => $lista));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerTodosPorNacionalidad($request, $response, $args)
    {
        $nacionalidad = $args['nacionalidad'];
        $lista = Criptomoneda::obtenerTodosPornacionalidad($nacionalidad);
        $payload = json_encode(array("Criptomonedas" => $lista));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function BorrarUno($request, $response, $args)
    {
        $id = $args['id'];

        $cripto = Criptomoneda::obtenerCripto($id);

        if($cripto != false){
          Criptomoneda::borrarCripto($id);
          $payload = json_encode(array("mensaje" => "Criptomoneda borrada con exito"));
        } else{
          $payload = json_encode(array("mensaje" => "No se encontro hortaliza"));
        }


        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }


    public function TraerUno($request, $response, $args)
    {
        $id = $args['id'];
        $cripto = Criptomoneda::obtenerCripto($id);
        $payload = json_encode($cripto);

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }



}