<?php
class Administracion extends Controller{
    public function __construct()
    {
        session_start(); //para que toda la funcion de validar funcione, hay que poner el constructor que ejecute las funciones
        if (empty($_SESSION['activo'])){
            header("location: ".base_url);
        }
        parent::__construct(); //hay que cargar el constructor del padre para cargar el modelo
    }
    public function index()
    {
        $data = $this->model->getEmpresa();
        //por defecto se va a ejecutar la funcion index
        $this->views->getView($this,"index", $data);
    }
    public function modificar(){
        $rut = $_POST['rut'];
        $nombre = $_POST['nombre'];
        $tel = $_POST['telefono'];
        $dir = $_POST['direccion'];
        $mensaje = $_POST['mensaje'];
        $id = $_POST['id'];
        $data = $this->model->modificar($rut, $nombre, $tel, $dir, $mensaje, $id);
        if($data == "ok"){
            $msg = "ok";
        } else{
            $msg = "Error";
        }
        echo json_encode($msg);
        die();
    }
}



?>