<?php
class Conexion{
    private $conect;
    public function __construct()
    {
        $pdo = "mysql:host=".host.";dbname=".db.";.charset."; //se hace la conexion instanciando las constantes que se habían definido en config, tales como el nombre de la base de datos, el usuario, y la contraseña
        try {
            $this->conect = new PDO($pdo, user, pass); //se abre una conexion de PDO (PHP Data Objects) para operar bases de datos (Se ha de observar que no se puede realizar ninguna de las funciones de las bases de datos utilizando la extensión PDO por sí misma; se debe utilizar un controlador de PDO específico de la base de datos  para tener acceso a un servidor de bases de datos.)
            // por ejemplo, para imprimir los métodos PDO que se hagan, puede ser: print_r(PDO::getUsers())
            $this->conect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // se indican los posibles errores de la conexion, y se recogen en la variable
        } catch (PDOException $e) {
            echo "Error en la conexion".$e->getMessage(); // para posteriormente mostrarlos
        }
    }
    public function conect()
    {
        return $this->conect;
    }
}
 
?>