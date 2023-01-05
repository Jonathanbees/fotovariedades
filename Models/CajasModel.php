<?php

class CajasModel extends Query{
    private $caja, $idcaja, $estado;
    public function __construct()
    {
        parent::__construct(); //se va a cargar el constructor del archivo de query
    }
    public function getCajas()
    {
        $sql = "SELECT * FROM caja";
        $data = $this->selectAll($sql); //como la clase hereda de query, se pueden acceder a los métodos
        return $data;
    }
    public function registrarCaja(string $caja){
        $this->caja = $caja;
        $verificar = "SELECT * FROM caja WHERE caja = '$this->caja'";
        $existe = $this->select($verificar); 
        if (empty($existe)){ //si no existe la variable "existe", quiere decir que no hay ningún identificacion seleccionado que tenga ese nombre, y se realiza la inserción
            $sql = "INSERT INTO caja (caja) VALUES (?)";
            $datos = array($this->caja);
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
    public function modificarCaja(string $caja,int $idcaja){
        $this->caja = $caja;
        $this->idcaja = $idcaja;

        $sql = "UPDATE caja SET caja=? WHERE idcaja = ?";
        $datos = array($this->caja, $this->idcaja);
        $data = $this->save($sql,$datos);
        if ($data == 1) {
            $res = "modificado"; //si la inserción fue correcta, entonces se mostrará la respuesta ok
        }else{
            $res = "error";
        }
        
        return $res;
    }
    public function editarCaja(int $idcaja){
        $sql = "SELECT * FROM caja WHERE idcaja = $idcaja";
        $data = $this->select($sql);
        return $data;
    }
    public function accionCaja(int $estado, int $idcaja){ //accionUser se encargará de eliminar(poner inactivo al identificacion) y reingresarlo (ponerlo activo)
        $this->idcaja = $idcaja;
        $this->estado = $estado;
        $sql = "UPDATE caja SET estado = ? WHERE idcaja = ?";
        $datos = array($this->estado, $this->idcaja);
        $data = $this->save($sql,$datos);
        return $data;
    }
}



?>