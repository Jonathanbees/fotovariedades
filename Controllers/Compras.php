<?php

class Compras extends Controller
{
    public function __construct()
    {
        session_start();
        parent::__construct();
    }
    public function index()
    {
        $this->views->getView($this, "index");
    }
    public function ventas()
    {
        $data = $this->model->getClientes();
        $this->views->getView($this, "ventas", $data);
    }
    public function historial_ventas()
    {
        $this->views->getView($this, "historial_ventas");
    }
    public function buscarCodigo($cod)
    {
        $data = $this->model->getProCod($cod);
        //print_r($data);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function ingresar()
    {
        $id = $_POST['id'];
        $datos = $this->model->getProductos($id);
        $id_producto = $datos['id'];
        $id_usuario = $_SESSION['id_usuario']; //se recuperan los datos desde la sesión, los demás datos, son desde el resultado de la consulta del formulario
        $precio = $datos['precio_compra'];
        $cantidad = $_POST['cantidad']; //se recuperan los datos desde el formulario
        $comprobar = $this->model->consultarDetalle('detalle', $id_producto, $id_usuario);
        if (empty($comprobar)) {
            $sub_total = $precio * $cantidad;
            $data = $this->model->registrarDetalle('detalle', $id_producto, $id_usuario, $precio, $cantidad, $sub_total);
            if ($data == "ok") {
                $msg = "ok";
                $msg = array('msg' => 'Producto ingresado a la compra', 'icono' => 'success');
            } else {
                $msg = array('msg' => 'Error al ingresar el producto a la compra', 'icono' => 'error');
            }
        } else {
            $total_cantidad = $comprobar['cantidad'] + $cantidad;
            $sub_total = $total_cantidad * $precio;
            $data = $this->model->actualizarDetalle('detalle', $precio, $total_cantidad, $sub_total, $id_producto, $id_usuario);
            if ($data == "modificado") {
                $msg = array('msg' => 'Producto actualizado', 'icono' => 'success');
            } else {
                $msg = array('msg' => 'Error al actualizar el producto', 'icono' => 'error');
            }
        }

        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function ingresarVenta()
    {
        $id = $_POST['id'];
        $datos = $this->model->getProductos($id);
        $id_producto = $datos['id'];
        $id_usuario = $_SESSION['id_usuario']; //se recuperan los datos desde la sesión, los demás datos, son desde el resultado de la consulta del formulario
        $precio = $datos['precio_venta'];
        $cantidad = $_POST['cantidad']; //se recuperan los datos desde el formulario
        $comprobar = $this->model->consultarDetalle('detalle_temp', $id_producto, $id_usuario);
        if (empty($comprobar)) {
            $sub_total = $precio * $cantidad;
            $data = $this->model->registrarDetalle('detalle_temp', $id_producto, $id_usuario, $precio, $cantidad, $sub_total);
            if ($data == "ok") {
                $msg = "ok";
                $msg = array('msg' => 'Producto ingresado a la venta', 'icono' => 'success');
            } else {
                $msg = array('msg' => 'Error al ingresar el producto a la venta', 'icono' => 'error');
            }
        } else {
            $total_cantidad = $comprobar['cantidad'] + $cantidad;
            $sub_total = $total_cantidad * $precio;
            $data = $this->model->actualizarDetalle('detalle_temp', $precio, $total_cantidad, $sub_total, $id_producto, $id_usuario);
            if ($data == "modificado") {
                $msg = array('msg' => 'Producto actualizado', 'icono' => 'success');
            } else {
                $msg = array('msg' => 'Error al actualizar el producto', 'icono' => 'error');
            }
        }

        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function listar($table)
    {
        $id_usuario = $_SESSION['id_usuario'];
        $data['detalle'] = $this->model->getDetalle($table, $id_usuario);
        $data['total_pagar'] = $this->model->calcularCompra($table, $id_usuario);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function delete($id)
    {
        $data = $this->model->deleteDetalle('detalle', $id);
        if ($data == "ok") {
            $msg = "ok";
        } else {
            $msg = "error";
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function deleteVenta($id)
    {
        $data = $this->model->deleteDetalle('detalle_temp', $id);
        if ($data == "ok") {
            $msg = "ok";
        } else {
            $msg = "error";
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function registrarCompra()
    {
        $id_usuario = $_SESSION['id_usuario'];
        $total = $this->model->calcularCompra('detalle', $id_usuario);
        $data = $this->model->registrarCompra($total['total']);
        if ($data == "ok") {
            $detalle = $this->model->getDetalle('detalle', $id_usuario);
            $id_compra = $this->model->getId('compras');
            foreach ($detalle as $row) {
                $cantidad = $row['cantidad'];
                $precio = $row['precio'];
                $id_pro = $row['id_producto'];
                $sub_total = $cantidad * $precio;
                $this->model->registrarDetalleCompra($id_compra['id'], $id_pro, $cantidad, $precio, $sub_total);
                $stock_actual = $this->model->getProductos($id_pro);
                $stock = $stock_actual['cantidad'] + $cantidad;
                $this->model->actualizarStock($stock, $id_pro);
            }
            $vaciar = $this->model->vaciarDetalle('detalle', $id_usuario);
            if ($vaciar == 'ok') {
                $msg = array('msg' => 'ok', 'id_compra' => $id_compra['id']);
            }
        } else {
            $msg = "Error al realizar la compra";
        }
        echo json_encode($msg);
        die();

    }
    public function registrarVenta($id_cliente)
    {
        $id_usuario = $_SESSION['id_usuario'];
        $total = $this->model->calcularCompra('detalle_temp', $id_usuario);
        $data = $this->model->registraVenta($id_cliente, $total['total']);
        if ($data == "ok") {
            $detalle = $this->model->getDetalle('detalle_temp', $id_usuario);
            $id_venta = $this->model->getId('ventas');
            foreach ($detalle as $row) {
                $cantidad = $row['cantidad'];
                $precio = $row['precio'];
                $id_pro = $row['id_producto'];
                $sub_total = $cantidad * $precio;
                $this->model->registrarDetalleVenta($id_venta['id'], $id_pro, $cantidad, $precio, $sub_total);
                $stock_actual = $this->model->getProductos($id_pro);
                $stock = $stock_actual['cantidad'] - $cantidad;
                $this->model->actualizarStock($stock, $id_pro);
            }
            $vaciar = $this->model->vaciarDetalle('detalle_temp', $id_usuario);
            if ($vaciar == 'ok') {
                $msg = array('msg' => 'ok', 'id_venta' => $id_venta['id']);
            }
        } else {
            $msg = "Error al realizar la venta";
        }
        echo json_encode($msg);
        die();
    }
    public function generarPdf($id_compra)
    {
        $empresa = $this->model->getEmpresa();
        $productos = $this->model->getProCompra($id_compra);
        //print_r($productos);
        require('Libraries/fpdf185/fpdf.php');
        $pdf = new FPDF('P', 'mm', /*array(210,297)*/array(100, 200));
        $pdf->AddPage();
        $pdf->SetMargins(5, 0, 0);
        $pdf->setTitle('Reporte de compra');
        $pdf->SetFont('Arial', 'B', 14); //el tamaño de todas las letras del pdf si no se le asigna otra
        $pdf->Cell(85, 10, utf8_decode($empresa['nombre']), 0, 1, 'C');
        $pdf->Image(base_url . 'Assets/img/logo.jpg', 67, 18, 25, 25);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(18, 5, 'Rut: ', 0, 0, 'L');
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(18, 5, $empresa['rut'], 0, 1, 'L');
        //Telefono
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(18, 5, utf8_decode('Teléfono: '), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(18, 5, $empresa['telefono'], 0, 1, 'L');
        //direccion
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(18, 5, utf8_decode('Dirección: '), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(18, 5, utf8_decode($empresa['direccion']), 0, 1, 'L');
        //folio(identificador unico)
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(18, 5, utf8_decode('Nro folio'), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(18, 5, $id_compra, 0, 1, 'L');
        $pdf->Ln();

        //Encabezados de los productos
        $pdf->SetFillColor(0, 0, 0);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Cell(18, 5, 'Cantidad', 0, 0, 'L', true);
        $pdf->Cell(35, 5, utf8_decode('Descripción'), 0, 0, 'L', true);
        $pdf->Cell(18, 5, 'Precio', 0, 0, 'L', true);
        $pdf->Cell(17, 5, 'Sub total', 0, 1, 'L', true);
        //recorrido de productos
        $pdf->SetTextColor(0, 0, 0);
        $total = 0.00;
        foreach ($productos as $row) {
            $total += $row['sub_total'];
            $pdf->Cell(18, 5, $row['cantidad'], 0, 0, 'L');
            $pdf->Cell(35, 5, utf8_decode($row['descripcion']), 0, 0, 'L');
            $pdf->Cell(18, 5, number_format($row['precio'], 2, '.', ','), 0, 0, 'L');
            $pdf->Cell(17, 5, number_format($row['sub_total'], 2, '.', ','), 0, 1, 'L');
        }
        $pdf->Ln();
        $pdf->Cell(89, 5, 'Total a pagar', 0, 1, 'R');
        $pdf->Cell(89, 5, number_format($total, 2, '.', ','), 0, 1, 'R');
        $pdf->Output();
    }
    public function generarPdfVenta($id_venta)
    {
        $empresa = $this->model->getEmpresa();
        $productos = $this->model->getProVenta($id_venta);
        //print_r($productos);
        require('Libraries/fpdf185/fpdf.php');
        $pdf = new FPDF('P', 'mm', /*array(210,297)*/array(100, 200));
        $pdf->AddPage();
        $pdf->SetMargins(5, 0, 0);
        $pdf->setTitle('Reporte de ventas');
        $pdf->SetFont('Arial', 'B', 14); //el tamaño de todas las letras del pdf si no se le asigna otra
        $pdf->Cell(85, 10, utf8_decode($empresa['nombre']), 0, 1, 'C');
        $pdf->Image(base_url . 'Assets/img/logo.jpg', 67, 18, 25, 25);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(18, 5, 'Rut: ', 0, 0, 'L');
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(18, 5, $empresa['rut'], 0, 1, 'L');
        //Telefono
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(18, 5, utf8_decode('Teléfono: '), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(18, 5, $empresa['telefono'], 0, 1, 'L');
        //direccion
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(18, 5, utf8_decode('Dirección: '), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(18, 5, utf8_decode($empresa['direccion']), 0, 1, 'L');
        //folio(identificador unico)
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(18, 5, utf8_decode('Nro folio'), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(18, 5, $id_venta, 0, 1, 'L');
        $pdf->Ln();
        //Encabezados de los clientes
        $pdf->SetFillColor(0, 0, 0);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(25, 5, 'Nombre', 0, 0, 'L', true);
        $pdf->Cell(20, 5, utf8_decode('Teléfono'), 0, 0, 'L', true);
        $pdf->Cell(25, 5, utf8_decode('Dirección'), 0, 1, 'L', true);
        $pdf->SetTextColor(0, 0, 0);
        $clientes = $this->model->clientesVenta($id_venta);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(25, 5, utf8_decode($clientes['nombre']), 0, 0, 'L');
        $pdf->Cell(20, 5, utf8_decode($clientes['telefono']), 0, 0, 'L');
        $pdf->Cell(25, 5, utf8_decode($clientes['direccion']), 0, 1, 'L');

        //Encabezados de los productos
        $pdf->SetFillColor(0, 0, 0);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Cell(18, 5, 'Cantidad', 0, 0, 'L', true);
        $pdf->Cell(35, 5, utf8_decode('Descripción'), 0, 0, 'L', true);
        $pdf->Cell(18, 5, 'Precio', 0, 0, 'L', true);
        $pdf->Cell(17, 5, 'Sub total', 0, 1, 'L', true);
        //recorrido de productos
        $pdf->SetTextColor(0, 0, 0);
        $total = 0.00;
        foreach ($productos as $row) {
            $total += $row['sub_total'];
            $pdf->Cell(18, 5, $row['cantidad'], 0, 0, 'L');
            $pdf->Cell(35, 5, utf8_decode($row['descripcion']), 0, 0, 'L');
            $pdf->Cell(18, 5, number_format($row['precio'], 2, '.', ','), 0, 0, 'L');
            $pdf->Cell(17, 5, number_format($row['sub_total'], 2, '.', ','), 0, 1, 'L');
        }
        $pdf->Ln();
        $pdf->Cell(89, 5, 'Total a pagar', 0, 1, 'R');
        $pdf->Cell(89, 5, number_format($total, 2, '.', ','), 0, 1, 'R');
        $pdf->Output();


    }
    public function historial()
    {
        $this->views->getView($this, "historial");
    }
    public function listar_historial()
    {
        $data = $this->model->getHistorialcompras();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 1){
                $data[$i]['estado'] = '<div><button type="button" style="pointer-events: none; border-radius: 30px;" class="btn btn-success">Completado</button></div>';
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-warning" onclick="btnAnularC('.$data[$i]['id'].')"><i class="fas fa-ban"></i></button>
                <a class="btn btn-danger" href="' . base_url . "Compras/generarPdf/" . $data[$i]['id'] . '" target="_blank"><i class="fas fa-file-pdf"></i></a>
                </div>';
            } else {
                $data[$i]['estado'] = '<div><button type="button" style="pointer-events: none; border-radius: 30px; " class="btn btn-warning">Anulado</button></div>';
                $data[$i]['acciones'] = '<div>
                <a class="btn btn-danger" href="' . base_url . "Compras/generarPdf/" . $data[$i]['id'] . '" target="_blank"><i class="fas fa-file-pdf"></i></a>
                </div>';
            } 
            
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function listar_historial_venta()
    {
        $data = $this->model->getHistorialVentas();
        for ($i = 0; $i < count($data); $i++) {
            if($data[$i]['estado'] == 1){
                $data[$i]['estado'] = '<div><button type="button" style="pointer-events: none; border-radius: 30px;" class="btn btn-success">Completado</button></div>';
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-warning" onclick="btnAnularV('.$data[$i]['id'].')"><i class="fas fa-ban"></i></button>
                <a class="btn btn-danger" href="' . base_url . "Compras/generarPdfVenta/" . $data[$i]['id'] . '" target="_blank"><i class="fas fa-file-pdf"></i></a>
                </div>';
            }else {
                $data[$i]['estado'] = '<div><button type="button" style="pointer-events: none; border-radius: 30px; " class="btn btn-warning">Anulado</button></div>';
                $data[$i]['acciones'] = '<div>
                <a class="btn btn-danger" href="' . base_url . "Compras/generarPdfVenta/" . $data[$i]['id'] . '" target="_blank"><i class="fas fa-file-pdf"></i></a>
                </div>';
            } 
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function anularCompra($id_compra){
        $data = $this->model->getAnularCompra($id_compra);
        $anular = $this->model->getAnular('compras',$id_compra);
        foreach ($data as $key => $row) {
            $stock_actual = $this->model->getProductos($row['id_producto']);
            $stock = $stock_actual['cantidad'] - $row['cantidad'];
            $this->model->actualizarStock($stock, $row['id_producto']);
        }
        if ($anular == 'ok'){
            $msg = array('msg' => 'Compra Anulada', 'icono'=> 'success');
        } else{
            $msg = array('msg' => 'Error al anular la compra', 'icono'=> 'error');
        }
        echo json_encode($msg);
        die(); 
    }
    public function anularVenta($id_compra){
        $data = $this->model->getAnularVenta($id_compra);
        $anular = $this->model->getAnular('ventas',$id_compra);
        foreach ($data as $key => $row) {
            $stock_actual = $this->model->getProductos($row['id_producto']);
            $stock = $stock_actual['cantidad'] + $row['cantidad'];
            $this->model->actualizarStock($stock, $row['id_producto']);
        }
        if ($anular == 'ok'){
            $msg = array('msg' => 'Venta Anulada', 'icono'=> 'success');
        } else{
            $msg = array('msg' => 'Error al anular la venta', 'icono'=> 'error');
        }
        echo json_encode($msg);
        die(); 
    }
}