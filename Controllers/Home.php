<?php
 class Home extends Controller {
    public function index()
    {
        $this->views->getView($this,"index"); // se trae el método de la clase Controller, el "views lo trae de la instancia que se hizo en Controller"
    }               //los parámetros que recibe, el primero, es el controlador, y el segundo es el index, que será la página principal del proyecto
 }




?>