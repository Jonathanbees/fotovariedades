<?php
class Usuarios extends Controller{ //usuarios hereda de controller porque controller ya carga todos los Model, por lo tanto, se puede acceder a todos los métodos de los modelos desde controller
    
    public function __construct() {
        session_start(); //para que toda la funcion de validar funcione, hay que poner el constructor que ejecute las funciones
        parent::__construct(); //hay que cargar el constructor del padre para cargar el modelo
    }
    public function index()
    {
        //por defecto se va a ejecutar la funcion index
        $data['cajas'] = $this->model->getCajas();
        $this->views->getView($this,"index", $data);
    }
    public function listar()
    {
        $data = $this->model->getUsuarios(); 
        for ($i=0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 1){
                $data[$i]['estado'] = '<div><button type="button" style="pointer-events: none; border-radius: 30px;" class="btn btn-success">Activo</button></div>';
            } else {
                $data[$i]['estado'] = '<div><button type="button" style="pointer-events: none; border-radius: 30px; " class="btn btn-warning">Inactivo</button></div>';
            } 
            $data[$i]['acciones'] = '<div>
            <button type="button" class="btn btn-primary" onclick="btnEditarUser('.$data[$i]['id'].');">Editar</button>
            <button type="button" class="btn btn-danger" onclick="btnEliminarUser('.$data[$i]['id'].');">Eliminar</button>
            <button type="button" class="btn btn-success" onclick="btnReingresarUser('.$data[$i]['id'].');">Reingresar</button>
            </div>';
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die;
    }
    public function validar()
    {
        if(empty($_POST['usuario']) || empty($_POST['clave'])){
            $msg = "los campos están vacíos";
        } else{
            $usuario = $_POST['usuario'];
            $clave = $_POST['clave'];
            $data = $this->model->getUsuario($usuario, $clave); //el controlador se conecta con el modelo (UsuariosModel) para mandarle los parámetros de usaurio y contraseña y hacer la consulta
            
            if ($data){ //si la consulta de mysql trae los datos correctamente 
                $_SESSION['id_usuario'] = $data['id']; //se inicia la sesión
                $_SESSION['usuario'] = $data['usuario'];
                $_SESSION['nombre'] = $data['nombre'];
                $msg = "ok";
            } else{
                $msg = "Usuario o contraseña incorrecta";
            }

        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);//esa segunda parte de la funcion, indica que permita caracteres especiales en el mensaje
        die();
    }
    public function registrar(){
        $usuario = $_POST['usuario'];
        $nombre = $_POST['nombre'];
        $clave = $_POST['clave'];
        $confirmar = $_POST['confirmar'];
        $caja = $_POST['caja'];
        $id = $_POST['id'];
        $hash = hash("SHA256", $clave);
        if (empty($usuario) || empty($nombre) || empty($caja)){
            $msg = "Todos los campos son obligatorios";
        } else {
            if($id == ""){
                if ($clave != $confirmar){
                    $msg = "las contraseñas no coinciden";
                }else{
                    $data = $this->model->registrarUsuario($usuario, $nombre, $hash, $caja);
                    if($data == "ok"){
                        $msg = "si";
                    } else if ($data == "existe"){
                        $msg = "El usuario ya existe";
                    }else {
                        $msg = "Error al registrar el usuario";
                    }
                }
            } else{
                $data = $this->model->modificarUsuario($usuario, $nombre, $caja, $id);
                    if($data == "modificado"){
                        $msg = "modificado";
                    }else {
                        $msg = "Error al modificar  el usuario";
                    }
            }
        }
        echo json_encode($msg,JSON_UNESCAPED_UNICODE);
        die();
    }
    public function editar(int $id){
        $data = $this->model->editarUser($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function eliminar(int $id){
        $data = $this->model->eliminarUser($id);
        if($data == 1){
            $msg = "ok";
        }else {
            $msg = "Error al eliminar el usuario";
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
}
?>
