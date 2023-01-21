<?php include "Views/templates/header.php";?>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Productos</li>
</ol>
<button type="button" class="btn btn-primary mb-2" onclick="frmProducto();"><i class="fas fa-plus"></i></button>
<div class="table-responsive">
    <table class="table table-light table-responsive" id= "tblProductos">
        <thead class="thead-dark">
            <tr>
                <th>Id</th>
                <th>Imagen</th>
                <th>Codigo</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Estado</th>
                <th></th>
            </tr>
        </thead>
    <tbody>
    </tbody>
    </table>
</div>

<!-- Modal Body -->
<!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
<div class="modal fade" id="nuevo_producto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">    
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="title">Nuevo Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="frmProducto">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="codigo">Código de barras</label>
                            <input type="hidden" id = "id" name="id">
                            <input type="text" name="codigo" id="codigo" class="form-control" placeholder="Código de barras" aria-describedby="helpId">
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                            <label for="nombre">Descripción</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre del Producto" aria-describedby="helpId">
                        </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                              <label for="precio_compra">Precio Compra</label>
                              <input type="text" name="precio_compra" id="precio_compra" class="form-control" placeholder="precio de compra" aria-describedby="helpId">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                              <label for="precio_venta">Precio venta</label>
                              <input type="text" name="precio_venta" id="precio_venta" class="form-control" placeholder="precio de venta" aria-describedby="helpId">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                            <label for="medida">Medidas</label>
                            <select class="form-control" name="medida" id="medida">
                                <?php foreach ($data['medidas'] as $row) { ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['nombre']; ?></option>
                                <?php }?>
                            </select>
                            </div>
                        </div>
                
                        <div class="col-md-6">
                            <div class="form-group">
                            <label for="categoria">Categorias</label>
                            <select class="form-control" name="categoria" id="categoria">
                                <?php foreach ($data['categorias'] as $row) { ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['nombre']; ?></option>
                                <?php }?>
                            </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                              <label>foto</label>
                              <div class="card border-primary">
                                <div class="card-body">
                                    <label for="imagen" class="btn btn-primary" id="icon-image"><i class="fas fa-image"></i></label>
                                    <span id= "icon-cerrar"></span>
                                    <input type="file" class="d-none" name="imagen" id="imagen" onchange="preview(event)">
                                    <input type="hidden" id="foto_actual" name="foto_actual">
                                    <input type="hidden" id="foto_delete" name="foto_delete">
                                    <img src="" class="img-thumbnail" id = "img-preview">
                                </div>
                              </div>
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" onclick="registrarPro(event);" id="btnAccion">Registrar</button>
                    </div>
                </form>
            </div>
            
        </div>
    </div>
</div>



<!-- Optional: Place to the bottom of scripts -->
<script>
    const myModal = new bootstrap.Modal(document.getElementById('modalId'), options)

</script>

<?php include "Views/templates/footer.php";?>
