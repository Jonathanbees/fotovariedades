<?php include "Views/templates/header.php";?>
<div class="card">
  <div class="card-header bg-dark text-white">
    Datos de la empresa
  </div>
  <div class="card-body">
    <form id="frmEmpresa">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <input type="hidden" name="id" id="id" class="form-control" value="<?php echo $data[0]['id'] ?>">
            <label for="rut">Rut</label>
            <input type="text" name="rut" id="rut" class="form-control" placeholder="Rut" value="<?php echo $data[0]['rut'] ?>" >
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre" value="<?php echo $data[0]['nombre'] ?>" >
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="telefono">Telefono</label>
            <input type="text" name="telefono" id="telefono" class="form-control" placeholder="Telefono" value="<?php echo $data[0]['telefono'] ?>">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="direccion">Direccion</label>
            <input type="text" name="direccion" id="direccion" class="form-control" placeholder="Direccion" value="<?php echo $data[0]['direccion'] ?>">
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group">
            <label for="mensaje">Mensaje</label>
            <textarea class="form-control" name="mensaje" id="mensaje" rows="3" placeholder="Mensaje"><?php echo $data[0]['mensaje'] ?></textarea>
          </div>
        </div>
      </div>
      <button class="btn btn-primary" type="button" onclick="modificarEmpresa()">Modificar</button>

    </form>
    
  </div>
</div>

<?php include "Views/templates/footer.php";?>