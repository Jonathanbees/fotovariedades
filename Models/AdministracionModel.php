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
    public function getDatos(string $table)
    {
        $sql = "SELECT COUNT(*) AS total FROM $table";
        $data = $this->select($sql); //como la clase hereda de query, se pueden acceder a los métodos
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
    public function getStockMinimo(){
        $sql = "SELECT * FROM productos WHERE cantidad < 15 ORDER BY cantidad DESC LIMIT 10";
        $data = $this->selectAll($sql); //como la clase hereda de query, se pueden acceder a los métodos
        return $data;
    }
    public function getproductosVendidos(){
        $sql = "SELECT productos.descripcion, SUM(detalle_ventas.cantidad) as total
        FROM detalle_ventas JOIN productos ON detalle_ventas.id_producto = productos.id
        GROUP BY productos.id
        ORDER BY SUM(detalle_ventas.cantidad) DESC LIMIT 10";
        $data = $this->selectAll($sql); //como la clase hereda de query, se pueden acceder a los métodos
        return $data;
    }
}



?>