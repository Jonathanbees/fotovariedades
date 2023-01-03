<?php
    require_once "Config/Config.php";
    $ruta = !empty($_GET['url']) ? $_GET['url'] : "Home/index"; //si la ruta no se especifica, será home/index, sino, será la que coloque el usuario, para así no generar errores
    $array = explode("/", $ruta);
    $controller = $array[0]; //la primera ruta que se especifica es el controlador
    $metodo = "index"; //la segunda ruta, es el método (index 1)
    $parametro = ""; //se le puede pasar cualquier parámetro a partir de los indices 2,3 etc. [o ID, para poder editarlo, por ejemplo, a la hora de listar usuarios]
    if (!empty($array[1])) {
        if (!empty($array[1] != "")) {
            $metodo = $array[1];
        }
    }
    if (!empty($array[2])) {
        if (!empty($array[2] != "")) {
            for ($i=2; $i < count($array); $i++) { 
                $parametro .= $array[$i]. ","; // esto solo es para verificar que todo si se esté pasando correctamente (controlador, metodo y parámetros)
            }
            $parametro = trim($parametro, ","); //simplemente elimina la coma al final del parámetro 
        }
    }
    require_once "Config/App/autoload.php";
    $dirControllers = "Controllers/".$controller.".php";    //se va a tomar la ruta que el usuario diga, en este caso, el controlador, para posteriormente validarlo si existe o no
    if (file_exists($dirControllers)){
        require_once $dirControllers; // si el controlador existe, se hace una instancia del mismo
        $controller = new $controller();
        if (method_exists($controller, $metodo)){
            $controller ->$metodo($parametro); //si el controlador junto con el método existen, se envía al parámetro (el número-ID) para redirigir al usuario
        } else{
            echo "No existe el método";
        }
    } else {
        echo "No existe el controlador";
    }
                                   
?>