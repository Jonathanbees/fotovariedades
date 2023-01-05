<?php
class Cajas extends Controller{ //usuarios hereda de controller porque controller ya carga todos los Model, por lo tanto, se puede acceder a todos los métodos de los modelos desde controller
    
    public function __construct() {
        session_start(); //para que toda la funcion de validar funcione, hay que poner el constructor que ejecute las funciones
        if (empty($_SESSION['activo'])){
            header("location: ".base_url);
        }
        parent::__construct(); //hay que cargar el constructor del padre para cargar el modelo
    }
    public function index()
    {
        //por defecto se va a ejecutar la funcion index
        $this->views->getView($this,"index");
    }
    public function listar()
    {
        $data = $this->model->getCajas(); 
        for ($i=0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 1){
                $data[$i]['estado'] = '<div><button type="button" style="pointer-events: none; border-radius: 30px;" class="btn btn-success">Activo</button></div>';
                $data[$i]['acciones'] = '<div>
                <button type="button" class="btn btn-primary" onclick="btnEditarCajas('.$data[$i]['idcaja'].');"><i class="fas fa-edit"></i></button>
                <button type="button" class="btn btn-danger" onclick="btnEliminarCajas('.$data[$i]['idcaja'].');"><i class="fas fa-trash"></i></button>
                </div>';
            } else {
                $data[$i]['estado'] = '<div><button type="button" style="pointer-events: none; border-radius: 30px; " class="btn btn-warning">Inactivo</button></div>';
                $data[$i]['acciones'] = '<div>
                <button type="button" class="btn btn-success" onclick="btnReingresarCajas('.$data[$i]['idcaja'].');"><i class="fas fa-check"></i></button>
                </div>';
            } 
            
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function registrar(){
        $caja = $_POST['caja'];
        $idcaja = $_POST['idcaja'];
        if (empty($caja)) {
            $msg = "Todos los campos son obligatorios";
        } else {
            if($idcaja == ""){
                    $data = $this->model->registrarCaja($caja);
                    if($data == "ok"){
                        $msg = "si";
                    } else if ($data == "existe"){
                        $msg = "El caja ya existe";
                    }else {
                        $msg = "Error al registrar la caja";
                    }
            } else{
                $data = $this->model->modificarCaja($caja, $idcaja);
                    if($data == "modificado"){
                        $msg = "modificado";
                    }else {
                        $msg = "Error al modificar  la caja";
                    }
            }
        }
        echo json_encode($msg,JSON_UNESCAPED_UNICODE);
        die();
    }
    public function editar(int $idcaja){
        $data = $this->model->editarCaja($idcaja);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function eliminar(int $idcaja){
        $data = $this->model->accionCaja(0, $idcaja);
        if($data == 1){
            $msg = "ok";
        }else {
            $msg = "Error al eliminar la caja";
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function reingresar(int $idcaja){
        $data = $this->model->accionCaja(1, $idcaja);
        if($data == 1){
            $msg = "ok";
        }else {
            $msg = "Error al reingresar la caja";
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
}
?>
