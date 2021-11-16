<?php

class VentaCripto
{
    public $id;
    public $idUser;
    public $idCripto;
    public $nombre;
    public $cliente;
    public $fecha;
    public $cantidad;
    public $foto;

    public function crearVenta()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO ventacripto (idUser, idCripto, cliente, nombre, fecha, cantidad, foto) VALUES (:idUser, :idCripto, :cliente, :nombre, :fecha, :cantidad, :foto)");
        $consulta->bindValue(':idUser', $this->idUser, PDO::PARAM_INT);
        $consulta->bindValue(':idCripto', $this->idCripto, PDO::PARAM_INT);
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':cliente', $this->cliente, PDO::PARAM_STR);
        $consulta->bindValue(':fecha', $this->fecha, PDO::PARAM_STR);
        $consulta->bindValue(':cantidad', $this->cantidad, PDO::PARAM_INT);
        $consulta->bindValue(':foto', $this->foto, PDO::PARAM_STR);
        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function TraerVentasPorFecha($fechaUno, $fechaDos, $nacionalidad){

        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT ventacripto.id, ventacripto.idUser, ventacripto.idCripto, ventacripto.nombre, ventacripto.cliente, ventacripto.fecha, criptomonedas.nacionalidad FROM ventacripto, criptomonedas WHERE ventacripto.idCripto = criptomonedas.id AND ventacripto.fecha BETWEEN :fechaUno AND :fechaDos AND criptomonedas.nacionalidad = :nacionalidad");
        $consulta->bindValue(':fechaUno', $fechaUno, PDO::PARAM_STR);
        $consulta->bindValue(':fechaDos', $fechaDos, PDO::PARAM_STR);
        $consulta->bindValue(':nacionalidad', $nacionalidad, PDO::PARAM_STR);
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_ASSOC);

    }

    
    public static function ObtenerUsuariosPorProducto($nombre)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT usuariocripto.id, usuariocripto.usuario, usuariocripto.tipo FROM usuariocripto, ventacripto WHERE usuariocripto.id = ventacripto.idUser AND ventacripto.nombre = :nombre");
        $consulta->bindValue(':nombre', $nombre, PDO::PARAM_STR);
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    
    public static function obtenerTodos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM ventacripto");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'VentaCripto');
    }

    public static function toString($venta){


        return 'ID:'.$venta->id.' | USER: '.$venta->idUser.' | ID CRIPTO: '.$venta->idCripto.' | NOMBRE: '.$venta->nombre.' | CLIENTE: '.$venta->cliente.' | FECHA: '.$venta->fecha.' | CANTIDAD: '.$venta->cantidad;
    }

}