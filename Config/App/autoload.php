<?php
spl_autoload_register(function($class){   //esta funcion sirve para ejecutar Controller (todos los controladores)
    if (file_exists("Config/App/".$class.".php")) {
        require_once "Config/App/" . $class . ".php"; 
    }
})
?>