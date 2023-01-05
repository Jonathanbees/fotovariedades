<?php include "Views/templates/header.php";?>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Cajas</li>
</ol>
<button type="button" class="btn btn-primary mb-2" onclick="frmCajas();"><i class="fas fa-plus"></i></button>
<table class="table table-light table-responsive" id= "tblCajas">
    <thead class="thead-dark">
        <tr>
            <th>idcaja</th>
            <th>caja</th>
            <th>estado</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>

<!-- Modal Body -->
<!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
<div class="modal fade" id="nuevo_caja" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">    
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="title">Nueva Caja</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="frmCajas">
                    <div class="form-group">
                      <label for="caja">Nombre de la caja</label>
                      <input type="hidden" id = "idcaja" name="idcaja">
                      <input type="text" name="caja" id="caja" class="form-control" placeholder="Nombre de la caja" aria-describedby="helpId">
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" onclick="registrarCaja(event);" id="btnAccion">Registrar</button>
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