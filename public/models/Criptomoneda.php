<?php

class Criptomoneda
{
    public $id;
    public $precio;
    public $nombre;
    public $foto;
    public $nacionalidad;

    public function crearCripto()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO criptomonedas (precio, nombre, foto, nacionalidad) VALUES (:precio, :nombre, :foto, :nacionalidad)");
        $consulta->bindValue(':precio', $this->precio, PDO::PARAM_INT);
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':foto', $this->foto, PDO::PARAM_STR);
        $consulta->bindValue(':nacionalidad', $this->nacionalidad, PDO::PARAM_STR);
        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }

    public function modificarCripto()
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("UPDATE criptomonedas SET precio = :precio, nombre = :nombre, foto = :foto, nacionalidad = :nacionalidad WHERE id = :id");

        $consulta->bindValue(':precio', $this->precio, PDO::PARAM_INT);
        $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':foto', $this->foto, PDO::PARAM_STR);
        $consulta->bindValue(':nacionalidad', $this->nacionalidad, PDO::PARAM_STR);
        $consulta->execute();
        return $consulta->rowCount();
    }
    

    public static function obtenerTodosPornacionalidad($nacionalidad)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id, precio, nombre, nacionalidad FROM criptomonedas WHERE nacionalidad = :nacionalidad");
        $consulta->bindValue(':nacionalidad', $nacionalidad, PDO::PARAM_STR);
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Criptomoneda');
    }

    public static function obtenerCripto($id)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id, precio, foto, nombre, nacionalidad FROM criptomonedas WHERE id = :id");
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->execute();

        return $consulta->fetchObject('Criptomoneda');
    }

    public static function TraerTodosCripto()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id, precio, nombre, nacionalidad FROM criptomonedas");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Criptomoneda');
    }

    public static function obtenerCriptoPorRuta($foto)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id, precio, nombre, nacionalidad, foto FROM criptomonedas WHERE foto = :foto");
        $consulta->bindValue(':foto', $foto, PDO::PARAM_STR);
        $consulta->execute();

        return $consulta->fetchObject('Criptomoneda');
    }

    public static function borrarCripto($id)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("DELETE FROM criptomonedas WHERE id = :id");
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->execute();
    }

}