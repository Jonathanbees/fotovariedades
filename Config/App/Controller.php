<?php
class Controller{
    public function __construct()
    {
        $this->views = new Views(); //se hace la instancia de la clase Views
        $this->cargarModel();    //con esto carga toda la funcion, para cargar el modelo
    }
    public function cargarModel()      //esta funcion sirve para validar que los archivos que estén en Models se carguen correctamente y si existan
    {
        $model = get_class($this)."Model";   //obtiene el nombre Model
        $ruta = "Models/".$model.".php";            //y lo concatena con .php en la carpeta Models
        if (file_exists($ruta)) {
            require_once $ruta;
            $this->model = new $model();
        }
    }
} 
 
?>