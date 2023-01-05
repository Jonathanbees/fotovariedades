<?php

class ClientesModel extends Query{
    private $identificacion, $nombre, $telefono, $direccion, $id, $estado;
    public function __construct()
    {
        parent::__construct(); //se va a cargar el constructor del archivo de query
    }
    public function getClientes()
    {
        $sql = "SELECT * FROM clientes";
        $data = $this->selectAll($sql); //como la clase hereda de query, se pueden acceder a los métodos
        return $data;
    }
    public function registrarCliente(string $identificacion, string $nombre, string $telefono, string $direccion){
        $this->identificacion = $identificacion;
        $this->nombre = $nombre;
        $this->telefono = $telefono;
        $this->direccion = $direccion;
        $verificar = "SELECT * FROM clientes WHERE identificacion = '$this->identificacion'";
        $existe = $this->select($verificar); 
        if (empty($existe)){ //si no existe la variable "existe", quiere decir que no hay ningún identificacion seleccionado que tenga ese nombre, y se realiza la inserción
            $sql = "INSERT INTO clientes (identificacion, nombre, telefono,direccion) VALUES (?,?,?,?)";
            $datos = array($this->identificacion,$this->nombre,$this->telefono, $this->direccion);
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
    public function modificarCliente(string $identificacion, string $nombre, string $telefono, string $direccion, int $id){
        $this->identificacion = $identificacion;
        $this->nombre = $nombre;
        $this->telefono = $telefono;
        $this->direccion = $direccion;
        $this->id = $id;

        $sql = "UPDATE clientes SET identificacion=?,nombre=?,telefono=?,direccion=? WHERE id = ?";
        $datos = array($this->identificacion,$this->nombre,$this->telefono, $this->direccion, $this->id);
        $data = $this->save($sql,$datos);
        if ($data == 1) {
            $res = "modificado"; //si la inserción fue correcta, entonces se mostrará la respuesta ok
        }else{
            $res = "error";
        }
        
        return $res;
    }
    public function editarCli(int $id){
        $sql = "SELECT * FROM clientes WHERE id = $id";
        $data = $this->select($sql);
        return $data;
    }
    public function accionCli(int $estado, int $id){ //accionUser se encargará de eliminar(poner inactivo al identificacion) y reingresarlo (ponerlo activo)
        $this->id = $id;
        $this->estado = $estado;
        $sql = "UPDATE clientes SET estado = ? WHERE id = ?";
        $datos = array($this->estado, $this->id);
        $data = $this->save($sql,$datos);
        return $data;
    }
}



?>