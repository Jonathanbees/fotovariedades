<?php
class Usuarios extends Controller{ //usuarios hereda de controller porque controller ya carga todos los Model, por lo tanto, se puede acceder a todos los métodos de los modelos desde controller
    
    public function __construct() {
        session_start(); //para que toda la funcion de validar funcione, hay que poner el constructor que ejecute las funciones
        
        parent::__construct(); //hay que cargar el constructor del padre para cargar el modelo
    }
    public function index()
    {
        if (empty($_SESSION['activo'])){
            header("location: ".base_url);
        }
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
                $data[$i]['acciones'] = '<div>
                <button type="button" class="btn btn-primary" onclick="btnEditarUser('.$data[$i]['id'].');"><i class="fas fa-edit"></i></button>
                <button type="button" class="btn btn-danger" onclick="btnEliminarUser('.$data[$i]['id'].');"><i class="fas fa-trash"></i></button>                </div>';
            } else {
                $data[$i]['estado'] = '<div><button type="button" style="pointer-events: none; border-radius: 30px; " class="btn btn-warning">Inactivo</button></div>';
                $data[$i]['acciones'] = '<div>
                <button type="button" class="btn btn-success" onclick="btnReingresarUser('.$data[$i]['id'].');"><i class="fas fa-check"></i></button>
                </div>';
            } 
            
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
            $hash = hash("SHA256", $clave);
            $data = $this->model->getUsuario($usuario, $hash); //el controlador se conecta con el modelo (UsuariosModel) para mandarle los parámetros de usaurio y contraseña y hacer la consulta
            
            if ($data){ //si la consulta de mysql trae los datos correctamente 
                $_SESSION['id_usuario'] = $data['id']; //se inicia la sesión
                $_SESSION['usuario'] = $data['usuario'];
                $_SESSION['nombre'] = $data['nombre'];
                $_SESSION['activo'] = true;
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
            $msg = array('msg'=> 'Todos los campos son obligatorios', 'icono'=>'warning'); //este mensaje es para colocarlo en la alerta
        } else {
            if($id == ""){
                if ($clave != $confirmar){
                    $msg = array('msg'=> 'Las contraseñas no coinciden', 'icono'=>'warning'); //este mensaje es para colocarlo en la alerta
                }else{
                    $data = $this->model->registrarUsuario($usuario, $nombre, $hash, $caja);
                    if($data == "ok"){
                        $msg = array('msg'=> 'Usuario registrado exitosamente', 'icono'=>'success'); //este mensaje es para colocarlo en la alerta

                    } else if ($data == "existe"){
                        $msg = array('msg'=> 'El usuario ya existe', 'icono'=>'warning'); //este mensaje es para colocarlo en la alerta

                    }else {
                        $msg = array('msg'=> 'Error al modificar el usuario', 'icono'=>'error'); //este mensaje es para colocarlo en la alerta

                    }
                }
            } else{
                $data = $this->model->modificarUsuario($usuario, $nombre, $caja, $id);
                    if($data == "modificado"){
                    $msg = array('msg'=> 'Usuario modificado con éxito', 'icono'=>'success'); //este mensaje es para colocarlo en la alerta
                        
                    }else {
                    $msg = array('msg'=> 'Error al modificar el usuario', 'icono'=>'error'); //este mensaje es para colocarlo en la alerta
                        
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
        $data = $this->model->accionUser(0, $id);
        if($data == 1){
            $msg = array('msg'=> 'Usuario eliminado', 'icono'=>'success'); //este mensaje es para colocarlo en la alerta

        }else {
            $msg = array('msg'=> 'Error al eliminar el usuario', 'icono'=>'error'); //este mensaje es para colocarlo en la alerta
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function reingresar(int $id){
        $data = $this->model->accionUser(1, $id);
        if($data == 1){
            $msg = array('msg'=> 'Usuario reingresado', 'icono'=>'success'); //este mensaje es para colocarlo en la alerta
        }else {
            $msg = array('msg'=> 'Error al reingresar el usuario', 'icono'=>'error'); //este mensaje es para colocarlo en la alerta
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function cambiarPass(){
        $actual = $_POST['clave_actual'];
        $nueva = $_POST['clave_nueva'];
        $confirmar = $_POST['confirmar_clave'];
        if(empty($actual) || empty($nueva) || empty($confirmar)){
            $mensaje = array('msg' => 'Todos los campos son obligatorios', 'icono'=> 'warning');
        } else{
            if ($nueva != $confirmar){
                $mensaje = array('msg' => 'Las contraseñas no coinciden', 'icono'=> 'warning');
            }else{
                $id = $_SESSION['id_usuario'];
                $hash = hash("SHA256", $actual);
                $data = $this->model->getPass($hash, $id);
                if(!empty($data)){
                    $verificar = $this->model->modificarPass(hash("SHA256", $nueva), $id);
                    if($verificar == 1){
                        $mensaje = array('msg' => 'Contraseña modificada con exito', 'icono'=> 'success');
                    }else{
                        $mensaje = array('msg' => 'Error al modificar la contraseña', 'icono'=> 'error');
                    }
                } else{
                    $mensaje = array('msg' => 'La contraseña actual es incorrecta', 'icono'=> 'warning');
                }
            }
        }
        echo json_encode($mensaje, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function salir(){
        session_destroy();
        header("location: ".base_url);
    }
}
?>
