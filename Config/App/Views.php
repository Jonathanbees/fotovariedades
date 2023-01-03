<?php   // este archivo sirve para conectar las vistas con el controlador
class Views{
 
    public function getView($controlador, $vista, $data="")
    {
        $controlador = get_class($controlador);
        if ($controlador == "Home") { //si el controlador es igual a home (que va a ser la pestaña principal de la página en views, entonces lo manda para allá)
            $vista = "Views/".$vista.".php";
        }else{
            $vista = "Views/".$controlador."/".$vista.".php";
        }
        require $vista;
    }
}
 
 
?>