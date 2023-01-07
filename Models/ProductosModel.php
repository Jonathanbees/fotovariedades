<?php

class ProductosModel extends Query{
    private $codigo, $nombre, $precio_compra,$precio_venta, $id_medida,$id_categoria, $id, $estado, $img;
    public function __construct()
    {
        parent::__construct(); //se va a cargar el constructor del archivo de query
    }
    public function getMedidas()
    {
        $sql = "SELECT * FROM medidas WHERE estado = 1";
        $data = $this->selectAll($sql); //como la clase hereda de query, se pueden acceder a los métodos
        return $data;
    }
    public function getCategorias()
    {
        $sql = "SELECT * FROM categorias WHERE estado = 1";
        $data = $this->selectAll($sql); //como la clase hereda de query, se pueden acceder a los métodos
        return $data;
    }
    public function getProductos()
    {
        $sql = "SELECT p.*,m.id AS id_medida,m.nombre AS medida,c.id AS id_categoria,c.nombre AS categoria FROM productos p JOIN medidas m ON p.id_medida = m.id JOIN categorias c ON p.id_categoria = c.id";
        $data = $this->selectAll($sql); //como la clase hereda de query, se pueden acceder a los métodos
        return $data;
    }
    public function registrarProducto(string $codigo, string $nombre, string $precio_compra, string $precio_venta, int $id_medida, int $id_categoria, string $img){
        $this->codigo = $codigo;
        $this->nombre = $nombre;
        $this->precio_compra = $precio_compra;
        $this->precio_venta = $precio_venta;
        $this->id_medida = $id_medida;
        $this->id_categoria = $id_categoria;
        $this->img = $img;
        $verificar = "SELECT * FROM productos WHERE codigo = '$this->codigo'";
        $existe = $this->select($verificar); 
        if (empty($existe)){ //si no existe la variable "existe", quiere decir que no hay ningún Producto seleccionado que tenga ese nombre, y se realiza la inserción
            $sql = "INSERT INTO productos (codigo,descripcion, precio_compra,precio_venta,id_medida, id_categoria,foto) VALUES (?,?,?,?,?,?,?)";
            $datos = array($this->codigo,$this->nombre,$this->precio_compra, $this->precio_venta, $this->id_medida, $this->id_categoria,$this->img);
            $data = $this->save($sql,$datos);
            if ($data) {
                $res = "ok"; //si la inserción fue correcta, entonces se mostrará la respuesta ok
            }else{
                $res = "error";
            }
        } else {
            $res = "existe";
        }
        
        return $res;
    }
    public function modificarProducto(string $codigo, string $nombre, string $precio_compra, string $precio_venta, int $id_medida, int $id_categoria,string $img, int $id){
        $this->codigo = $codigo;
        $this->nombre = $nombre;
        $this->precio_compra = $precio_compra;
        $this->precio_venta = $precio_venta;
        $this->id_medida = $id_medida;
        $this->id_categoria = $id_categoria;
        $this->img = $img;
        $this->id = $id;

        $sql = "UPDATE productos SET codigo=?,descripcion=?,precio_compra=?,precio_venta=?,id_medida=?,id_categoria=?,foto = ? WHERE id = ?";
        $datos = array($this->codigo,$this->nombre,$this->precio_compra, $this->precio_venta, $this->id_medida, $this->id_categoria,$this->img, $this->id);
        $data = $this->save($sql,$datos);
        if ($data == 1) {
            $res = "modificado"; //si la inserción fue correcta, entonces se mostrará la respuesta ok
        }else{
            $res = "error";
        }
        
        return $res;
    }
    public function editarPro(int $id){
        $sql = "SELECT * FROM productos WHERE id = $id";
        $data = $this->select($sql);
        return $data;
    }
    public function accionPro(int $estado, int $id){ //accionUser se encargará de eliminar(poner inactivo al Producto) y reingresarlo (ponerlo activo)
        $this->id = $id;
        $this->estado = $estado;
        $sql = "UPDATE productos SET estado = ? WHERE id = ?";
        $datos = array($this->estado, $this->id);
        $data = $this->save($sql,$datos);
        return $data;
    }
}



?>