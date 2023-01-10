<?php
class Productos extends Controller{ //Productos hereda de controller porque controller ya carga todos los Model, por lo tanto, se puede acceder a todos los métodos de los modelos desde controller
    
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
        $data['medidas'] = $this->model->getMedidas();
        $data['categorias'] = $this->model->getCategorias();
        $this->views->getView($this,"index", $data);
    }
    public function listar()
    {
        $data = $this->model->getProductos(); 
        for ($i=0; $i < count($data); $i++) {
            $data[$i]['imagen'] = '<img class="img-thumbnail" src="'.base_url. "Assets/img/". $data[$i]['foto'].'" width="100"></img>';
            if ($data[$i]['estado'] == 1){
                $data[$i]['estado'] = '<div><button type="button" style="pointer-events: none; border-radius: 30px;" class="btn btn-success">Activo</button></div>';
                $data[$i]['acciones'] = '<div>
                <button type="button" class="btn btn-primary" onclick="btnEditarPro('.$data[$i]['id'].');"><i class="fas fa-edit"></i></button>
                <button type="button" class="btn btn-danger" onclick="btnEliminarPro('.$data[$i]['id'].');"><i class="fas fa-trash"></i></button>                </div>';
            } else {
                $data[$i]['estado'] = '<div><button type="button" style="pointer-events: none; border-radius: 30px; " class="btn btn-warning">Inactivo</button></div>';
                $data[$i]['acciones'] = '<div>
                <button type="button" class="btn btn-success" onclick="btnReingresarPro('.$data[$i]['id'].');"><i class="fas fa-check"></i></button>
                </div>';
            } 
            
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die;
    }
    public function registrar(){
        $codigo = $_POST['codigo'];
        $nombre = $_POST['nombre'];
        $precio_compra = $_POST['precio_compra'];
        $precio_venta = $_POST['precio_venta'];
        $medida = $_POST['medida'];
        $categoria = $_POST['categoria'];
        $id = $_POST['id'];
        $img = $_FILES['imagen'];
        $name = $img['name'];
        $tmpname = $img['tmp_name'];

        $fecha = date("YmdHis");

        if (empty($codigo) || empty($nombre) || empty($precio_compra)|| empty($precio_venta)){
            $msg = "Todos los campos son obligatorios";
        } else {
            if(!empty($name)){
                $imgNombre = $fecha . ".jpg";
                $destino = "Assets/img/".$imgNombre;
            }else if (!empty($_POST['foto_actual']) && empty($name)){
                $imgNombre = $_POST['foto_actual'];
            }else{
                $imgNombre = "default.jpg";
            }
            if($id == ""){
                    $data = $this->model->registrarProducto($codigo, $nombre, $precio_compra, $precio_venta, $medida, $categoria,$imgNombre);
                    if($data == "ok"){
                        if(!empty($name)){
                            move_uploaded_file($tmpname,$destino);
                        }
                        $msg = "si";
                        
                    } else if ($data == "existe"){
                        $msg = "El Producto ya existe";
                    }else {
                        $msg = "Error al registrar el Producto";
                    }
            } else{     
                $imgDelete = $this->model->editarPro($id);
                    if($imgDelete['foto'] != 'default.jpg'){
                        if(file_exists("Assets/img/" . $imgDelete['foto'])){
                            unlink("Assets/img/" . $imgDelete['foto']);
                        }
                    }
                    $data = $this->model->modificarProducto($codigo, $nombre, $precio_compra, $precio_venta, $medida, $categoria,$imgNombre, $id);
                    if($data == "modificado"){
                        if(!empty($name)){
                            move_uploaded_file($tmpname,$destino);
                        }
                        $msg = "modificado";
                    }else {
                        $msg = "Error al modificar  el Producto";
                    }
            }
        }
        echo json_encode($msg,JSON_UNESCAPED_UNICODE);
        die();
    }
    public function editar(int $id){
        $data = $this->model->editarPro($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function eliminar(int $id){
        $data = $this->model->accionPro(0, $id);
        if($data == 1){
            $msg = "ok";
        }else {
            $msg = "Error al eliminar el Producto";
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function reingresar(int $id){
        $data = $this->model->accionPro(1, $id);
        if($data == 1){
            $msg = "ok";
        }else {
            $msg = "Error al reingresar el Producto";
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
}
?>
