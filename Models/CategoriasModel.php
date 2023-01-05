<?php

class CategoriasModel extends Query{
    private $nombre, $id, $estado;
    public function __construct()
    {
        parent::__construct(); //se va a cargar el constructor del archivo de query
    }
    public function getCategorias()
    {
        $sql = "SELECT * FROM categorias";
        $data = $this->selectAll($sql); //como la clase hereda de query, se pueden acceder a los métodos
        return $data;
    }
    public function registrarCategorias(string $nombre){
        $this->nombre = $nombre;
        $verificar = "SELECT * FROM categorias WHERE nombre = '$this->nombre'";
        $existe = $this->select($verificar); 
        if (empty($existe)){ //si no existe la variable "existe", quiere decir que no hay ningún identificacion seleccionado que tenga ese nombre, y se realiza la inserción
            $sql = "INSERT INTO categorias (nombre) VALUES (?)";
            $datos = array($this->nombre);
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
    public function modificarCategorias(string $nombre,int $id){
        $this->nombre = $nombre;
        $this->id = $id;

        $sql = "UPDATE categorias SET nombre=? WHERE id = ?";
        $datos = array($this->nombre, $this->id);
        $data = $this->save($sql,$datos);
        if ($data == 1) {
            $res = "modificado"; //si la inserción fue correcta, entonces se mostrará la respuesta ok
        }else{
            $res = "error";
        }
        
        return $res;
    }
    public function editarCategoria(int $id){
        $sql = "SELECT * FROM categorias WHERE id = $id";
        $data = $this->select($sql);
        return $data;
    }
    public function accionCategoria(int $estado, int $id){ //accionUser se encargará de eliminar(poner inactivo al identificacion) y reingresarlo (ponerlo activo)
        $this->id = $id;
        $this->estado = $estado;
        $sql = "UPDATE categorias SET estado = ? WHERE id = ?";
        $datos = array($this->estado, $this->id);
        $data = $this->save($sql,$datos);
        return $data;
    }
}



?>