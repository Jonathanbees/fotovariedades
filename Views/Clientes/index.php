<?php include "Views/templates/header.php";?>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Clientes</li>
</ol>
<button type="button" class="btn btn-primary mb-2" onclick="frmCliente();"><i class="fas fa-plus"></i></button>
<table class="table table-light table-responsive" id= "tblClientes">
    <thead class="thead-dark">
        <tr>
            <th>Id</th>
            <th>identificacion</th>
            <th>Nombre</th>
            <th>Teléfono</th>
            <th>Direccion</th>
            <th>Estado</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>

<!-- Modal Body -->
<!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
<div class="modal fade" id="nuevo_cliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">    
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="title">Nuevo Cliente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="frmCliente">
                    <div class="form-group">
                      <label for="identificacion">identificacion</label>
                      <input type="hidden" id = "id" name="id">
                      <input type="text" name="identificacion" id="identificacion" class="form-control" placeholder="Identificacion" aria-describedby="helpId">
                    </div>
                    <div class="form-group">
                      <label for="nombre">Nombre</label>
                      <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre del Cliente" aria-describedby="helpId">
                    </div>
                    <div class="form-group">
                      <label for="telefono">telefono</label>
                      <input type="text" name="telefono" id="telefono" class="form-control" placeholder="telefono del Cliente" aria-describedby="helpId">
                    </div>
                    <div class="form-group">
                      <label for="direccion">direccion</label>
                      <textarea class="form-control" name="direccion" id="direccion" placeholder="Direccion"rows="3"></textarea>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" onclick="registrarCli(event);" id="btnAccion">Registrar</button>
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
