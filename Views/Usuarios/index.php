<?php include "Views/templates/header.php";?>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Usuarios</li>
</ol>
<button type="button" class="btn btn-primary mb-2" onclick="frmUsuario();"><i class="fas fa-plus"></i></button>
<table class="table table-light table-responsive" id= "tblUsuarios">
    <thead class="thead-dark">
        <tr>
            <th>Id</th>
            <th>Usuario</th>
            <th>Nombre</th>
            <th>Caja</th>
            <th>Estado</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>

<!-- Modal Body -->
<!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
<div class="modal fade" id="nuevo_usuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">    
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="title">Nuevo usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="frmUsuario">
                    <div class="form-group">
                      <label for="usuario">Usuario</label>
                      <input type="hidden" id = "id" name="id">
                      <input type="text" name="usuario" id="usuario" class="form-control" placeholder="Usuario" aria-describedby="helpId">
                    </div>
                    <div class="form-group">
                      <label for="nombre">Nombre</label>
                      <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre del Usuario" aria-describedby="helpId">
                    </div>
                    <div class="row" id="claves">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="clave">Contraseña</label>
                                <input type="password" name="clave" id="clave" class="form-control" placeholder="Contraseña" aria-describedby="helpId">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="confirmar">Confirmar contraseña</label>
                                <input type="password" name="confirmar" id="confirmar" class="form-control" placeholder="Confirmar Contraseña" aria-describedby="helpId">
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="form-group">
                      <label for="caja">Caja</label>
                      <select class="form-control" name="caja" id="caja">
                        <?php foreach ($data['cajas'] as $row) { ?>
                            <option value="<?php echo $row['idcaja']; ?>"><?php echo $row['caja']; ?></option>
                        <?php }?>
                      </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" onclick="registrarUser(event);" id="btnAccion">Registrar</button>
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
