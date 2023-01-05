<?php
class Clientes extends Controller{ //usuarios hereda de controller porque controller ya carga todos los Model, por lo tanto, se puede acceder a todos los métodos de los modelos desde controller
    
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
        $data = $this->model->getClientes(); 
        for ($i=0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 1){
                $data[$i]['estado'] = '<div><button type="button" style="pointer-events: none; border-radius: 30px;" class="btn btn-success">Activo</button></div>';
                $data[$i]['acciones'] = '<div>
                <button type="button" class="btn btn-primary" onclick="btnEditarCli('.$data[$i]['id'].');"><i class="fas fa-edit"></i></button>
                <button type="button" class="btn btn-danger" onclick="btnEliminarCli('.$data[$i]['id'].');"><i class="fas fa-trash"></i></button>
                </div>';
            } else {
                $data[$i]['estado'] = '<div><button type="button" style="pointer-events: none; border-radius: 30px; " class="btn btn-warning">Inactivo</button></div>';
                $data[$i]['acciones'] = '<div>
                <button type="button" class="btn btn-success" onclick="btnReingresarCli('.$data[$i]['id'].');"><i class="fas fa-check"></i></button>
                </div>';
            } 
            
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function registrar(){
        $identificacion = $_POST['identificacion'];
        $nombre = $_POST['nombre'];
        $telefono = $_POST['telefono'];
        $direccion = $_POST['direccion'];
        $id = $_POST['id'];
        if (empty($identificacion) || empty($nombre) || empty($telefono)|| empty($direccion)) {
            $msg = "Todos los campos son obligatorios";
        } else {
            if($id == ""){
                    $data = $this->model->registrarCliente($identificacion, $nombre,$telefono,$direccion);
                    if($data == "ok"){
                        $msg = "si";
                    } else if ($data == "existe"){
                        $msg = "La identificacion ya existe";
                    }else {
                        $msg = "Error al registrar el cliente";
                    }
            } else{
                $data = $this->model->modificarCliente($identificacion, $nombre, $telefono,$direccion, $id);
                    if($data == "modificado"){
                        $msg = "modificado";
                    }else {
                        $msg = "Error al modificar  el cliente";
                    }
            }
        }
        echo json_encode($msg,JSON_UNESCAPED_UNICODE);
        die();
    }
    public function editar(int $id){
        $data = $this->model->editarCli($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function eliminar(int $id){
        $data = $this->model->accionCli(0, $id);
        if($data == 1){
            $msg = "ok";
        }else {
            $msg = "Error al eliminar el cliente";
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function reingresar(int $id){
        $data = $this->model->accionCli(1, $id);
        if($data == 1){
            $msg = "ok";
        }else {
            $msg = "Error al reingresar el cliente";
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
}
?>
