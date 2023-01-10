<?php

class ComprasModel extends Query{
    public function __construct()
    {
        parent::__construct(); //se va a cargar el constructor del archivo de query
    }
    public function getProCod(string $cod){
        $sql = "SELECT * FROM productos WHERE codigo = '$cod'";
        $data = $this->select($sql);
        return $data;
    }
    public function getProductos(int $id){
        $sql = "SELECT * FROM productos WHERE id = $id";
        $data = $this->select($sql);
        return $data;
    }
    public function registrarDetalle(int $id_producto, int $id_usuario, string $precio, int $cantidad, string $sub_total)
    {

        $sql = "INSERT INTO detalle(id_producto,id_usuario,precio,cantidad,sub_total) VALUES  (?,?,?,?,?)";
        $datos = array($id_producto, $id_usuario, $precio, $cantidad, $sub_total);
        $data = $this->save($sql,$datos);
        if($data == 1 ){
            $res = "ok";
        }else{
            $res = "error";
        }
        return $res;
    }
    public function getDetalle(int $id){
        $sql = "SELECT d.*, p.id AS id_pro,p.descripcion FROM detalle d INNER JOIN productos p ON d.id_producto = p.id WHERE d.id_usuario = $id";
        $data = $this->selectAll($sql);
        return $data; 
    }
    public function calcularCompra(int $id_usuario){
        $sql = "SELECT SUM(sub_total) AS total FROM detalle";
        $data = $this->select($sql);
        return $data; 
    }
    public function deleteDetalle(int $id){
        $sql = "DELETE FROM detalle WHERE id = ?";
        $datos = array($id);
        $data = $this->save($sql, $datos);
        if($data == 1 ){
            $res = "ok";
        }else{
            $res = "error";
        }
        return $res;
    }
    public function consultarDetalle(int $id_producto, int $id_usuario){
        $sql = "SELECT * FROM detalle WHERE id_producto = $id_producto AND id_usuario = $id_usuario";
        $data = $this->select($sql);
        return $data; 
    }
    public function actualizarDetalle(string $precio, int $cantidad, string $sub_total,int $id_producto, int $id_usuario)
    {

        $sql = "UPDATE detalle SET precio = ?,cantidad=?, sub_total = ? WHERE id_producto = ? AND id_usuario = ?";
        $datos = array($precio, $cantidad, $sub_total,$id_producto, $id_usuario);
        $data = $this->save($sql,$datos);
        if($data == 1 ){
            $res = "modificado";
        }else{
            $res = "error";
        }
        return $res;
    }
    public function registrarCompra(string $total){
        $sql = "INSERT INTO compras (total) VALUES (?)";
        $datos = array($total);
        $data = $this->save($sql,$datos);
        if($data == 1 ){
            $res = "ok";
        }else{
            $res = "error";
        }
        return $res;
    }
    public function id_compra(){
        $sql = "SELECT MAX(id) AS id FROM compras";
        $data = $this->select($sql);
        return $data;
    }
    public function registrarDetalleCompra(int $id_compra,int $id_pro, int $cantidad, int $precio, string $sub_total){
        $sql = "INSERT INTO detalle_compras (id_compra,id_producto, cantidad, precio, sub_total) VALUES (?,?,?,?,?)";
        $datos = array($id_compra,$id_pro, $cantidad, $precio, $sub_total);
        $data = $this->save($sql,$datos);
        if($data == 1 ){
            $res = "ok";
        }else{
            $res = "error";
        }
        return $res;
    }
}



?>