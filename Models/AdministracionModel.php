<?php

class AdministracionModel extends Query
{
    public function __construct()
    {
        parent::__construct(); //se va a cargar el constructor del archivo de query
    }
    public function getEmpresa()
    {
        $sql = "SELECT * FROM configuracion";
        $data = $this->selectAll($sql); //como la clase hereda de query, se pueden acceder a los métodos
        return $data;
    }
    public function modificar(string $rut, string $nombre, string $tel, string $dir, string $mensaje, int $id)
    {
        $sql = "UPDATE configuracion SET rut= ?, nombre=?,telefono=?, direccion=?, mensaje=? WHERE id=?";
        $datos = array($rut, $nombre, $tel, $dir, $mensaje, $id);
        $data = $this->save($sql, $datos);
        if ($data) {
            $res = "ok"; //si la inserción fue correcta, entonces se mostrará la respuesta ok
        } else {
            $res = "error";
        }
        return $res;
    }
}



?>