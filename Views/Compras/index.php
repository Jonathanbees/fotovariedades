<?php include "Views/templates/header.php"; ?>
<div class="card">
    <div class="card-header bg-primary text-white">
        <h4>Nueva compra</h4>
    </div>
    <div class="card-body">
        <form id="frmCompra">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="codigo"><i class="fas fa-barcode"></i>Codigo de barras</label>
                        <input type="hidden" id="id" name="id">
                        <input type="text" name="codigo" id="codigo" class="form-control" placeholder="Codigo de barras" onkeyup="buscarCodigo(event)">
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="nombre">Descripción</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Descripción del producto" disabled>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="cantidad">Cantidad</label>
                        <input type="number" name="cantidad" id="cantidad" class="form-control" onkeyup="calcularPrecio(event)">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="precio">Precio</label>
                        <input type="text" name="precio" id="precio" class="form-control" placeholder="Precio de compra" disabled>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="subtotal">Sub total</label>
                        <input type="number" name="subtotal" id="subtotal" class="form-control" placeholder="Subtotal" disabled>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>
<table class="table table-light table-bordered table-hover">
    <thead class="thead-dark">
        <tr>
            <th>Id</th>
            <th>Descripción</th>
            <th>Cantidad</th>
            <th>Precio</th>
            <th>Sub total</th>
            <th></th>
        </tr>
    </thead>
    <tbody id="tblDetalle">
    </tbody>
</table>
<div class="row">
    <div class="col-md-4  ms-auto ">
        <div class="form-group">
            <label for="total"><b>Total</b></label>
            <input type="text" name="total" id="total" class="form-control" placeholder="Total" disabled>
            <button type="button" class="btn btn-primary mt-2 btn-block" onclick="generarCompra()">Generar compra</button>
        </div>
        
    </div>
</div>
<?php include "Views/templates/footer.php"; ?>