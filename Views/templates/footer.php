</div>
</main>                
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2022</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>

        
        <!-- Modal -->
        <div class="modal fade" id="cambiarPass" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-dark text-white">
                        <h5 class="modal-title">Modificar Contraseña</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-bs-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
                    <div class="modal-body">
                        <form id= "frmCambiarPass" onsubmit="frmCambiarPass(event);">
                            <div class="form-group">
                              <label for="clave_actual">Contraseña actual</label>
                              <input type="password" name="clave_actual" id="clave_actual" class="form-control" placeholder="Contraseña actual" aria-describedby="helpId">
                            </div>
                            <div class="form-group">
                              <label for="clave_nueva">Contraseña nueva</label>
                              <input type="password" name="clave_nueva" id="clave_nueva" class="form-control" placeholder="Nueva contraseña" aria-describedby="helpId">
                            </div>
                            <div class="form-group">
                              <label for="confirmar_clave">Confirmar contraseña</label>
                              <input type="password" name="confirmar_clave" id="confirmar_clave" class="form-control" placeholder="Confirmar contraseña" aria-describedby="helpId">
                            </div>
                            <button type="submit" class="btn btn-primary">Modificar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script src="<?php echo base_url ?>Assets/js/jquery-3.6.3.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="<?php echo base_url ?>Assets/js/scripts.js" crossorigin="anonymous"></script>
        <script src="<?php echo base_url ?>Assets/js/jquery.dataTables.min.js"></script>
        <script src="<?php echo base_url ?>Assets/js/simple-datatables@latest.js" crossorigin="anonymous"></script>
        <script src="<?php echo base_url ?>Assets/js/chart.js" crossorigin="anonymous"></script>
        
        <script>
            const base_url = "<?php echo base_url; ?>";
        </script>
        <script src="<?php echo base_url ?>Assets/js/sweetalert2.all.min.js"></script>
        <script src="<?php echo base_url ?>Assets/js/select2.min.js"></script>
        <script src="<?php echo base_url ?>Assets/js/funciones.js"></script>
        </body>
</html>