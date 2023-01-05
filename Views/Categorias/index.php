<?php include "Views/templates/header.php";?>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Categorias</li>
</ol>
<button type="button" class="btn btn-primary mb-2" onclick="frmCategorias();"><i class="fas fa-plus"></i></button>
<table class="table table-light table-responsive" id= "tblCategorias">
    <thead class="thead-dark">
        <tr>
            <th>Id</th>
            <th>Nombre</th>
            <th>Estado</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>

<!-- Modal Body -->
<!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
<div class="modal fade" id="nuevo_categoria" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">    
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="title">Nuevo Cliente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="frmCategorias">
                    <div class="form-group">
                      <label for="nombre">Nombre</label>
                      <input type="hidden" id = "id" name="id">
                      <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre de la categoria" aria-describedby="helpId">
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" onclick="registrarCategorias(event);" id="btnAccion">Registrar</button>
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