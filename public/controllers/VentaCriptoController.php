<?php
require_once './models/VentaCripto.php';
require_once './models/pdf.php';

class VentaCriptoController extends VentaCripto
{
    public function CargarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $nombre = $parametros['nombre'];
        $idUser = $parametros['idUser'];
        $idCripto = $parametros['idCripto'];
        $cliente = $parametros['cliente'];
        $fecha = date("Y-m-d");
        $cantidad = $parametros['cantidad'];
        $foto = 'sin foto';

        $archivos = $request->getUploadedFiles();

        //var_dump($archivos);

        if($archivos['foto']->getError() === UPLOAD_ERR_OK){
          $destino="./FotosCripto/";
          $nombreAnterior=$archivos['foto']->getClientFilename();
          $extension= explode(".", $nombreAnterior);
          $extension=array_reverse($extension);
          $destino=$destino . $nombre."-".$cliente."-".$fecha.".".$extension[0];
          $archivos['foto']->moveTo($destino);
          $foto = $destino;
        }

        $cripto = new VentaCripto();
        $cripto->nombre = $nombre;
        $cripto->idUser = $idUser;
        $cripto->idCripto = $idCripto;
        $cripto->cliente = $cliente;
        $cripto->fecha = $fecha;
        $cripto->foto = $foto;
        $cripto->cantidad = $cantidad;

        //var_dump($cripto);
        $cripto->crearVenta();

        $payload = json_encode(array("mensaje" => "Venta creada con exito"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public static function TraerVentasPorFecha($request, $response, $args)
    {
        $nacionalidad = $args['nacionalidad'];
        $fechaUno = $args['fechaUno'];
        $fechaDos = $args['fechaDos'];
        $lista = VentaCripto::TraerVentasPorFecha($fechaUno, $fechaDos, $nacionalidad);
        $payload = json_encode(array("Ventas" => $lista));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public static function ObtenerUsuarios($request, $response, $args)
    {
        $cripto = $args['cripto'];
        $lista = VentaCripto::ObtenerUsuariosPorProducto($cripto);
        $payload = json_encode(array("Ventas" => $lista));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    
    public function TraerTodos($request, $response, $args)
    {
        ob_clean();
        ob_start();
        $lista = VentaCripto::obtenerTodos();
        $pdf = new PDF();
        $pdf->SetTitle("Ventas Cripto");
        $pdf->AddPage();
        $pdf->Cell(150,10,'Ventas Cripto: ', 0, 1);
        foreach($lista as $venta){
          $pdf->Cell(150,10, VentaCripto::toString($venta));
          $pdf->Ln();
        }
        $pdf->Output('F', './archivos/PDFVENTAS.pdf',false);
        ob_end_flush();

        $payload = json_encode(array("message" => "pdf generado"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }


}