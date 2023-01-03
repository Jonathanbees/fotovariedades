<?php
class Query extends Conexion{
    private $pdo, $con, $sql, $datos;
    public function __construct() {
        $this->pdo = new Conexion(); //se hace la instancia de la conexion
        $this->con = $this->pdo->conect(); //y se invoca el la función conect()
    }
    public function select(string $sql)
    {
        $this->sql = $sql;
        $resul = $this->con->prepare($this->sql);
        $resul->execute();
        $data = $resul->fetch(PDO::FETCH_ASSOC);
        return $data;
    }
    public function selectAll(string $sql)
    {
        $this->sql = $sql;
        $resul = $this->con->prepare($this->sql);
        $resul->execute();
        $data = $resul->fetchAll(PDO::FETCH_ASSOC); //esto va a traer todo el resultado, por eso el fetchall
        return $data;
    }
    public function save(string $sql, array $datos)
    {
        $this->sql = $sql;
        $this->datos = $datos;
        $insert = $this->con->prepare($this->sql); // si la consulta se ejecuta exitosamente, va a devolver un 1
        $data = $insert->execute($this->datos);
        if ($data) {
            $res = 1; //si si se ejecuta la consulta (con los datos del form), entonces la respuesta va a ser positiva
        }else{
            $res = 0;
        }
        return $res;
    }
}
 
 
?>