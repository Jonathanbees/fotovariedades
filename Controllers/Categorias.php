<?php
class Categorias extends Controller{ //usuarios hereda de controller porque controller ya carga todos los Model, por lo tanto, se puede acceder a todos los métodos de los modelos desde controller
    
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
        $data = $this->model->getCategorias(); 
        for ($i=0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 1){
                $data[$i]['estado'] = '<div><button type="button" style="pointer-events: none; border-radius: 30px;" class="btn btn-success">Activo</button></div>';
                $data[$i]['acciones'] = '<div>
                <button type="button" class="btn btn-primary" onclick="btnEditarCategorias('.$data[$i]['id'].');"><i class="fas fa-edit"></i></button>
                <button type="button" class="btn btn-danger" onclick="btnEliminarCategorias('.$data[$i]['id'].');"><i class="fas fa-trash"></i></button>
                </div>';
            } else {
                $data[$i]['estado'] = '<div><button type="button" style="pointer-events: none; border-radius: 30px; " class="btn btn-warning">Inactivo</button></div>';
                $data[$i]['acciones'] = '<div>
                <button type="button" class="btn btn-success" onclick="btnReingresarCategorias('.$data[$i]['id'].');"><i class="fas fa-check"></i></button>
                </div>';
            } 
            
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function registrar(){
        $nombre = $_POST['nombre'];
        $id = $_POST['id'];
        if (empty($nombre)) {
            $msg = "Todos los campos son obligatorios";
        } else {
            if($id == ""){
                    $data = $this->model->registrarCategorias($nombre);
                    if($data == "ok"){
                        $msg = array('msg'=>'Categoria registrada', 'icono'=>'success');
                    } else if ($data == "existe"){
                        $msg = array('msg'=>'El nombre ya existe', 'icono'=>'warning');
                    }else {
                        $msg = array('msg'=>'Error al registrar la categoria', 'icono'=>'error');
                    }
            } else{
                $data = $this->model->modificarCategorias($nombre, $id);
                    if($data == "modificado"){
                        $msg = array('msg'=>'Categoria modificada', 'icono'=>'success');
                    }else {
                        $msg = array('msg'=>'Error al modificar la categoria', 'icono'=>'error');
                    }
            }
        }
        echo json_encode($msg,JSON_UNESCAPED_UNICODE);
        die();
    }
    public function editar(int $id){
        $data = $this->model->editarCategoria($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function eliminar(int $id){
        $data = $this->model->accionCategoria(0, $id);
        if($data == 1){
            $msg = array('msg'=>'Categoria eliminada', 'icono'=>'success');
        }else {
            $msg = array('msg'=>'Error al eliminar la categoría', 'icono'=>'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function reingresar(int $id){
        $data = $this->model->accionCategoria(1, $id);
        if($data == 1){
            $msg = array('msg'=>'Categoria reingresada', 'icono'=>'success');
        }else {
            $msg = array('msg'=>'Error al eliminar la categoría', 'icono'=>'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
}
?>
