<?php

class UsuariosModel extends Query{
    private $usuario, $nombre, $clave, $id_caja, $id;
    public function __construct()
    {
        parent::__construct(); //se va a cargar el constructor del archivo de query
    }
    public function getUsuario(string $usuario, string $clave)
    {
        $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario' AND clave = '$clave'";
        $data = $this->select($sql); //como la clase hereda de query, se pueden acceder a los métodos
        return $data;
    }
    public function getCajas()
    {
        $sql = "SELECT * FROM caja WHERE estado = 1";
        $data = $this->selectAll($sql); //como la clase hereda de query, se pueden acceder a los métodos
        return $data;
    }
    public function getUsuarios()
    {
        $sql = "SELECT u.*,c.idcaja, c.caja  FROM usuarios u JOIN caja c where u.id_caja = c.idcaja";
        $data = $this->selectAll($sql); //como la clase hereda de query, se pueden acceder a los métodos
        return $data;
    }
    public function registrarUsuario(string $usuario, string $nombre, string $clave, int $id_caja){
        $this->usuario = $usuario;
        $this->nombre = $nombre;
        $this->clave = $clave;
        $this->id_caja = $id_caja;
        $verificar = "SELECT * FROM usuarios WHERE usuario = '$this->usuario'";
        $existe = $this->select($verificar); 
        if (empty($existe)){ //si no existe la variable "existe", quiere decir que no hay ningún usuario seleccionado que tenga ese nombre, y se realiza la inserción
            $sql = "INSERT INTO usuarios (usuario, nombre, clave,id_caja) VALUES (?,?,?,?)";
            $datos = array($this->usuario,$this->nombre,$this->clave, $this->id_caja);
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
    public function modificarUsuario(string $usuario, string $nombre, int $id_caja, int $id){
        $this->usuario = $usuario;
        $this->nombre = $nombre;
        $this->id = $id;
        $this->id_caja = $id_caja;

        $sql = "UPDATE usuarios SET usuario=?,nombre=?,id_caja=? WHERE id = ?";
        $datos = array($this->usuario,$this->nombre, $this->id_caja, $this->id);
        $data = $this->save($sql,$datos);
        if ($data == 1) {
            $res = "modificado"; //si la inserción fue correcta, entonces se mostrará la respuesta ok
        }else{
            $res = "error";
        }
        
        return $res;
    }
    public function editarUser(int $id){
        $sql = "SELECT * FROM usuarios WHERE id = $id";
        $data = $this->select($sql);
        return $data;
    }
    public function eliminarUser(int $id){
        $this->id = $id;
        $sql = "UPDATE usuarios SET estado = 0 WHERE id = ?";
        $datos = array($this->id);
        $data = $this->save($sql,$datos);
        return $data;
    }
}



?>