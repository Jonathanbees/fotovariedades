<?php

class MedidasModel extends Query{
    private $nombre, $corto, $id, $estado;
    public function __construct()
    {
        parent::__construct(); //se va a cargar el constructor del archivo de query
    }
    public function getMedidas()
    {
        $sql = "SELECT * FROM medidas";
        $data = $this->selectAll($sql); //como la clase hereda de query, se pueden acceder a los métodos
        return $data;
    }
    public function registrarMedidas(string $nombre, string $corto){
        $this->corto = $corto;
        $this->nombre = $nombre;

        $verificar = "SELECT * FROM medidas WHERE nombre = '$this->nombre'";
        $existe = $this->select($verificar); 
        if (empty($existe)){ //si no existe la variable "existe", quiere decir que no hay ningún identificacion seleccionado que tenga ese nombre, y se realiza la inserción
            $sql = "INSERT INTO medidas (nombre, nombrecorto) VALUES (?,?)";
            $datos = array($this->nombre,$this->corto);
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
    public function modificarMedidas(string $nombre, string $corto, int $id){
        $this->nombre = $nombre;
        $this->corto = $corto;
        $this->id = $id;

        $sql = "UPDATE medidas SET nombre=?,nombrecorto=? WHERE id = ?";
        $datos = array($this->nombre,$this->corto,$this->id);
        $data = $this->save($sql,$datos);
        if ($data == 1) {
            $res = "modificado"; //si la inserción fue correcta, entonces se mostrará la respuesta ok
        }else{
            $res = "error";
        }
        
        return $res;
    }
    public function editarMedida(int $id){
        $sql = "SELECT * FROM medidas WHERE id = $id";
        $data = $this->select($sql);
        return $data;
    }
    public function accionMedida(int $estado, int $id){ //accionUser se encargará de eliminar(poner inactivo al identificacion) y reingresarlo (ponerlo activo)
        $this->id = $id;
        $this->estado = $estado;
        $sql = "UPDATE medidas SET estado = ? WHERE id = ?";
        $datos = array($this->estado, $this->id);
        $data = $this->save($sql,$datos);
        return $data;
    }
}



?>