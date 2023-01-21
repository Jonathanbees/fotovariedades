let tblUsuarios, tblClientes, tblCategorias, tblMedidas, tblCajas, tblProductos;
document.addEventListener("DOMContentLoaded", function () {
    tblUsuarios = $('#tblUsuarios').DataTable({
        ajax: {
            url: base_url + "Usuarios/listar",
            dataSrc: ''
        },
        columns: [{
            'data': 'id'
        },
        {
            'data': 'usuario'
        },
        {
            'data': 'nombre'
        },
        {
            'data': 'caja'
        },
        {
            'data': 'estado'
        },
        {
            'data': 'acciones'
        }
        ]
    });
    //FIN TABLA USUARIOS
    tblClientes = $('#tblClientes').DataTable({
        ajax: {
            url: base_url + "Clientes/listar",
            dataSrc: ''
        },
        columns: [{
            'data': 'id'
        },
        {
            'data': 'identificacion'
        },
        {
            'data': 'nombre'
        },
        {
            'data': 'telefono'
        },
        {
            'data': 'direccion'
        },
        {
            'data': 'estado'
        },
        {
            'data': 'acciones'
        }
        ]
    });
    //FIN TABLA CLIENTES
    tblCategorias = $('#tblCategorias').DataTable({
        ajax: {
            url: base_url + "Categorias/listar",
            dataSrc: ''
        },
        columns: [{
            'data': 'id'
        },
        {
            'data': 'nombre'
        },
        {
            'data': 'estado'
        },
        {
            'data': 'acciones'
        }
        ]
    });
    //FIN TABLA CATEGORIAS
    tblMedidas = $('#tblMedidas').DataTable({
        ajax: {
            url: base_url + "Medidas/listar",
            dataSrc: ''
        },
        columns: [{
            'data': 'id'
        },
        {
            'data': 'nombre'
        },
        {
            'data': 'nombrecorto'
        },
        {
            'data': 'estado'
        },
        {
            'data': 'acciones'
        }
        ]
    });
    //FIN TABLA MEDIDAS
    tblCajas = $('#tblCajas').DataTable({
        ajax: {
            url: base_url + "Cajas/listar",
            dataSrc: ''
        },
        columns: [{
            'data': 'idcaja'
        },
        {
            'data': 'caja'
        },
        {
            'data': 'estado'
        },
        {
            'data': 'acciones'
        }
        ]
    });
    //FIN TABLA CAJAS
    tblProductos = $('#tblProductos').DataTable({
        ajax: {
            url: base_url + "Productos/listar",
            dataSrc: ''
        },
        columns: [{
            'data': 'id'
        },
        {
            'data': 'imagen'
        },
        {
            'data': 'codigo'
        },
        {
            'data': 'descripcion'
        },
        {
            'data': 'precio_venta'
        },
        {
            'data': 'cantidad'
        },
        {
            'data': 'estado'
        },
        {
            'data': 'acciones'
        }
        ],
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json"
        },
        dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                buttons: [{
                    //Botón para Excel
                    extend: 'excelHtml5',
                    footer: true,
                    title: 'Archivo',
                    filename: 'Export_File',
     
                    //Aquí es donde generas el botón personalizado
                    text: '<span class="badge badge-success"><i class="fas fa-file-excel"></i></span>'
                },
                //Botón para PDF
                {
                    extend: 'pdfHtml5',
                    download: 'open',
                    footer: true,
                    title: 'Reporte de usuarios',
                    filename: 'Reporte de usuarios',
                    text: '<span class="badge  badge-danger"><i class="fas fa-file-pdf"></i></span>',
                    exportOptions: {
                        columns: [0, ':visible']
                    }
                },
                //Botón para copiar
                {
                    extend: 'copyHtml5',
                    footer: true,
                    title: 'Reporte de usuarios',
                    filename: 'Reporte de usuarios',
                    text: '<span class="badge  badge-primary"><i class="fas fa-copy"></i></span>',
                    exportOptions: {
                        columns: [0, ':visible']
                    }
                },
                //Botón para print
                {
                    extend: 'print',
                    footer: true,
                    filename: 'Export_File_print',
                    text: '<span class="badge badge-light"><i class="fas fa-print"></i></span>'
                },
                //Botón para cvs
                {
                    extend: 'csvHtml5',
                    footer: true,
                    filename: 'Export_File_csv',
                    text: '<span class="badge  badge-success"><i class="fas fa-file-csv"></i></span>'
                },
                {
                    extend: 'colvis',
                    text: '<span class="badge  badge-info"><i class="fas fa-columns"></i></span>',
                    postfixButtons: ['colvisRestore']
                }
            ]
    });
    //Fin productos
    $('#t_historial_c').DataTable({
        ajax: {
            url: base_url + "Compras/listar_historial",
            dataSrc: ''
        },
        columns: [{
            'data': 'id'
        },
        {
            'data': 'total'
        },
        {
            'data': 'fecha'
        },
        {
            'data': 'acciones'
        }
        ]
    });
    //Fin historial compras
})

function frmUsuario() {
    document.getElementById("title").innerHTML = "Nuevo Usuario"; //toma el id del titulo del modal, y lo cambia si se ejecuta esta funcion
    document.getElementById("btnAccion").innerHTML = "Registrar";
    document.getElementById("claves").classList.remove("d-none");
    document.getElementById("frmUsuario").reset();
    $("#nuevo_usuario").modal("show");
    document.getElementById("id").value = "";
}
function registrarUser(e) { 
    e.preventDefault();
    const usuario = document.getElementById("usuario");
    const nombre = document.getElementById("nombre");
    const caja = document.getElementById("caja");
    if (usuario.value == "" || nombre.value == "" || caja.value == "") {
        alertas('Todos los campos son obligatorios', 'warning');
    } else {
        const url = base_url + "Usuarios/registrar"; //controlador/metodo
        const frm = document.getElementById("frmUsuario");
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send(new FormData(frm));
        http.onreadystatechange = function () { //si el readystate es igual a 4 y el status es igual a 200, la respuesta está lista, y se puede ejecutar
            if (this.readyState == 4 && this.status == 200) {
                const res = JSON.parse(this.responseText);
                //console.log(this.responseText); //en esta línea se imprime en un arreglo que se muestra por consola, los datos que el usuario haya ingresado
                $("#nuevo_usuario").modal("hide");
                alertas(res.msg,res.icono);
                tblUsuarios.ajax.reload();
            }
        }
    }
}
function btnEditarUser(id) {
    document.getElementById("title").innerHTML = "Actualizar usuario"; //toma el id del titulo del modal, y lo cambia si se ejecuta esta funcion
    document.getElementById("btnAccion").innerHTML = "Modificar";
    const url = base_url + "Usuarios/editar/" + id; //controlador/metodo
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function () { //si el readystate es igual a 4 y el status es igual a 200, la respuesta está lista, y se puede ejecutar
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            //console.log(this.responseText); //que está mostrando/respondiendo el servidor
            document.getElementById("id").value = res.id;
            document.getElementById("usuario").value = res.usuario;
            document.getElementById("nombre").value = res.nombre;
            document.getElementById("caja").value = res.id_caja;
            document.getElementById("claves").classList.add("d-none"); // se ocultan las contraseñas para que el admin no las pueda cambiar
            $("#nuevo_usuario").modal("show");
        }
    }

}
function btnEliminarUser(id) {
    Swal.fire({
        title: 'Estás seguro?',
        text: "Se cambiará el estado del usuario a inactivo",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Usuarios/eliminar/" + id; //controlador/metodo
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () { //si el readystate es igual a 4 y el status es igual a 200, la respuesta está lista, y se puede ejecutar
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    tblUsuarios.ajax.reload();
                    alertas(res.msg,res.icono);
                }
            }

        }
    })
}
function btnReingresarUser(id) {
    Swal.fire({
        title: 'Estás seguro de reingresar?',
        text: "Se cambiará el estado del usuario a: 'activo'",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Reingresar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Usuarios/reingresar/" + id; //controlador/metodo
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () { //si el readystate es igual a 4 y el status es igual a 200, la respuesta está lista, y se puede ejecutar
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    tblUsuarios.ajax.reload();
                    alertas(res.msg,res.icono);
                }
            }

        }
    })
}
//FIN USUARIOS

function frmCliente() {
    document.getElementById("title").innerHTML = "Nuevo Cliente"; //toma el id del titulo del modal, y lo cambia si se ejecuta esta funcion
    document.getElementById("btnAccion").innerHTML = "Registrar";
    document.getElementById("frmCliente").reset();
    $("#nuevo_cliente").modal("show");
    document.getElementById("id").value = "";
}
function registrarCli(e) {
    e.preventDefault();
    const identificacion = document.getElementById("identificacion");
    const nombre = document.getElementById("nombre");
    const telefono = document.getElementById("telefono");
    const direccion = document.getElementById("direccion");
    if (identificacion.value == "" || nombre.value == "" || telefono.value == "" || direccion.value == "") {
        Swal.fire({
            position: 'center',
            icon: 'error',
            title: 'Todos los campos son obligatorios',
            showConfirmButton: false,
            timer: 2000
        })
    } else {
        const url = base_url + "Clientes/registrar"; //controlador/metodo
        const frm = document.getElementById("frmCliente");
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send(new FormData(frm));
        http.onreadystatechange = function () { //si el readystate es igual a 4 y el status es igual a 200, la respuesta está lista, y se puede ejecutar
            if (this.readyState == 4 && this.status == 200) {
                console.log(this.responseText);
                const res = JSON.parse(this.responseText);
                console.log(this.responseText); //en esta línea se imprime en un arreglo que se muestra por consola, los datos que el usuario haya ingresado
                if (res == "si") {
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Cliente registrado con exito',
                        showConfirmButton: false,
                        timer: 2000
                    })
                    frm.reset();
                    $("#nuevo_cliente").modal("hide");
                    tblClientes.ajax.reload();

                } else if (res == "modificado") {
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Cliente modificado con exito',
                        showConfirmButton: false,
                        timer: 2000
                    })
                    $("#nuevo_cliente").modal("hide");
                    tblClientes.ajax.reload();
                } else {
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: res,
                        showConfirmButton: false,
                        timer: 2000
                    })
                }
            }
        }
    }
}
function btnEditarCli(id) {
    document.getElementById("title").innerHTML = "Actualizar cliente"; //toma el id del titulo del modal, y lo cambia si se ejecuta esta funcion
    document.getElementById("btnAccion").innerHTML = "Modificar";
    const url = base_url + "Clientes/editar/" + id; //controlador/metodo
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function () { //si el readystate es igual a 4 y el status es igual a 200, la respuesta está lista, y se puede ejecutar
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            //console.log(this.responseText); //que está mostrando/respondiendo el servidor

            document.getElementById("id").value = res.id;
            document.getElementById("identificacion").value = res.identificacion;
            document.getElementById("nombre").value = res.nombre;
            document.getElementById("telefono").value = res.telefono;
            document.getElementById("direccion").value = res.direccion;
            $("#nuevo_cliente").modal("show");
        }
    }

}
function btnEliminarCli(id) {
    Swal.fire({
        title: 'Estás seguro?',
        text: "Se cambiará el estado del cliente a inactivo",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Clientes/eliminar/" + id; //controlador/metodo
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () { //si el readystate es igual a 4 y el status es igual a 200, la respuesta está lista, y se puede ejecutar
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    if (res == "ok") {
                        Swal.fire(
                            'Eliminado!',
                            'Cliente eliminado',
                            'success'
                        )
                        tblClientes.ajax.reload();
                    } else {
                        Swal.fire(
                            'Alerta',
                            res,
                            'error'
                        )
                    }
                }
            }

        }
    })
}
function btnReingresarCli(id) {
    Swal.fire({
        title: 'Estás seguro de reingresar?',
        text: "Se cambiará el estado del cliente a: 'activo'",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Reingresar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Clientes/reingresar/" + id; //controlador/metodo
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () { //si el readystate es igual a 4 y el status es igual a 200, la respuesta está lista, y se puede ejecutar
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    if (res == "ok") {
                        Swal.fire(
                            'Reigresado!',
                            'Cliente reingreasado con exito',
                            'success'
                        )
                        tblClientes.ajax.reload();
                    } else {
                        Swal.fire(
                            'Alerta',
                            res,
                            'error'
                        )
                    }
                }
            }

        }
    })
}
//FIN CLIENTES
function frmCategorias() {
    document.getElementById("title").innerHTML = "Nueva Categoria"; //toma el id del titulo del modal, y lo cambia si se ejecuta esta funcion
    document.getElementById("btnAccion").innerHTML = "Registrar";
    document.getElementById("frmCategorias").reset();
    $("#nuevo_categoria").modal("show");
    document.getElementById("id").value = "";
}
function registrarCategorias(e) {
    e.preventDefault();
    const nombre = document.getElementById("nombre");
    if (nombre.value == "") {
        Swal.fire({
            position: 'center',
            icon: 'error',
            title: 'Todos los campos son obligatorios',
            showConfirmButton: false,
            timer: 2000
        })
    } else {
        const url = base_url + "Categorias/registrar"; //controlador/metodo
        const frm = document.getElementById("frmCategorias");
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send(new FormData(frm));
        http.onreadystatechange = function () { //si el readystate es igual a 4 y el status es igual a 200, la respuesta está lista, y se puede ejecutar
            if (this.readyState == 4 && this.status == 200) {
                console.log(this.responseText);
                const res = JSON.parse(this.responseText);
                console.log(this.responseText); //en esta línea se imprime en un arreglo que se muestra por consola, los datos que el usuario haya ingresado
                if (res == "si") {
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Categoria registrada con exito',
                        showConfirmButton: false,
                        timer: 2000
                    })
                    frm.reset();
                    $("#nuevo_categoria").modal("hide");
                    tblCategorias.ajax.reload();

                } else if (res == "modificado") {
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Categoria modificada con exito',
                        showConfirmButton: false,
                        timer: 2000
                    })
                    $("#nuevo_categoria").modal("hide");
                    tblCategorias.ajax.reload();
                } else {
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: res,
                        showConfirmButton: false,
                        timer: 2000
                    })
                }
            }
        }
    }
}
function btnEditarCategorias(id) {
    document.getElementById("title").innerHTML = "Actualizar Categorias"; //toma el id del titulo del modal, y lo cambia si se ejecuta esta funcion
    document.getElementById("btnAccion").innerHTML = "Modificar";
    const url = base_url + "Categorias/editar/" + id; //controlador/metodo
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function () { //si el readystate es igual a 4 y el status es igual a 200, la respuesta está lista, y se puede ejecutar
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            //console.log(this.responseText); //que está mostrando/respondiendo el servidor

            document.getElementById("id").value = res.id;
            document.getElementById("nombre").value = res.nombre;
            $("#nuevo_categoria").modal("show");
        }
    }

}
function btnEliminarCategorias(id) {
    Swal.fire({
        title: 'Estás seguro?',
        text: "Se cambiará el estado de la categoria a inactiva",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Categorias/eliminar/" + id; //controlador/metodo
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () { //si el readystate es igual a 4 y el status es igual a 200, la respuesta está lista, y se puede ejecutar
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    if (res == "ok") {
                        Swal.fire(
                            'Eliminada!',
                            'Categoria eliminado',
                            'success'
                        )
                        tblCategorias.ajax.reload();
                    } else {
                        Swal.fire(
                            'Alerta',
                            res,
                            'error'
                        )
                    }
                }
            }

        }
    })
}
function btnReingresarCategorias(id) {
    Swal.fire({
        title: 'Estás seguro de reingresar?',
        text: "Se cambiará el estado de la categoria a: 'activo'",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Reingresar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Categorias/reingresar/" + id; //controlador/metodo
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () { //si el readystate es igual a 4 y el status es igual a 200, la respuesta está lista, y se puede ejecutar
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    if (res == "ok") {
                        Swal.fire(
                            'Reigresado!',
                            'Categoria reingreasada con exito',
                            'success'
                        )
                        tblCategorias.ajax.reload();
                    } else {
                        Swal.fire(
                            'Alerta',
                            res,
                            'error'
                        )
                    }
                }
            }

        }
    })
}
//FIN CATEGORIAS
function frmMedidas() {
    document.getElementById("title").innerHTML = "Nueva Medida"; //toma el id del titulo del modal, y lo cambia si se ejecuta esta funcion
    document.getElementById("btnAccion").innerHTML = "Registrar";
    document.getElementById("frmMedidas").reset();
    $("#nuevo_medida").modal("show");
    document.getElementById("id").value = "";
}
function registrarMedidas(e) {
    e.preventDefault();
    const nombre = document.getElementById("nombre");
    const corto = document.getElementById("nombrecorto");
    if (nombre.value == "" || corto.value == "") {
        Swal.fire({
            position: 'center',
            icon: 'error',
            title: 'Todos los campos son obligatorios',
            showConfirmButton: false,
            timer: 2000
        })
    } else {
        const url = base_url + "Medidas/registrar"; //controlador/metodo
        const frm = document.getElementById("frmMedidas");
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send(new FormData(frm));
        http.onreadystatechange = function () { //si el readystate es igual a 4 y el status es igual a 200, la respuesta está lista, y se puede ejecutar
            if (this.readyState == 4 && this.status == 200) {
                console.log(this.responseText);
                const res = JSON.parse(this.responseText); //en esta línea se imprime en un arreglo que se muestra por consola, los datos que el usuario haya ingresado
                if (res == "si") {
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Medida registrada con exito',
                        showConfirmButton: false,
                        timer: 2000
                    })
                    frm.reset();
                    $("#nuevo_medida").modal("hide");
                    tblMedidas.ajax.reload();

                } else if (res == "modificado") {
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Medida modificada con exito',
                        showConfirmButton: false,
                        timer: 2000
                    })
                    $("#nuevo_medida").modal("hide");
                    tblMedidas.ajax.reload();
                } else {
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: res,
                        showConfirmButton: false,
                        timer: 2000
                    })
                }
            }
        }
    }
}
function btnEditarMedidas(id) {
    document.getElementById("title").innerHTML = "Actualizar Medidas"; //toma el id del titulo del modal, y lo cambia si se ejecuta esta funcion
    document.getElementById("btnAccion").innerHTML = "Modificar";
    const url = base_url + "Medidas/editar/" + id; //controlador/metodo
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function () { //si el readystate es igual a 4 y el status es igual a 200, la respuesta está lista, y se puede ejecutar
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            //console.log(this.responseText); //que está mostrando/respondiendo el servidor

            document.getElementById("id").value = res.id;
            document.getElementById("nombre").value = res.nombre;
            document.getElementById("nombrecorto").value = res.nombrecorto;
            $("#nuevo_medida").modal("show");
        }
    }

}
function btnEliminarMedidas(id) {
    Swal.fire({
        title: 'Estás seguro?',
        text: "Se cambiará el estado de la medida a inactiva",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Medidas/eliminar/" + id; //controlador/metodo
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () { //si el readystate es igual a 4 y el status es igual a 200, la respuesta está lista, y se puede ejecutar
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    if (res == "ok") {
                        Swal.fire(
                            'Eliminada!',
                            'Medida eliminada',
                            'success'
                        )
                        tblMedidas.ajax.reload();
                    } else {
                        Swal.fire(
                            'Alerta',
                            res,
                            'error'
                        )
                    }
                }
            }

        }
    })
}
function btnReingresarMedidas(id) {
    Swal.fire({
        title: 'Estás seguro de reingresar?',
        text: "Se cambiará el estado de la medida a: 'activo'",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Reingresar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Medidas/reingresar/" + id; //controlador/metodo
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () { //si el readystate es igual a 4 y el status es igual a 200, la respuesta está lista, y se puede ejecutar
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    if (res == "ok") {
                        Swal.fire(
                            'Reigresada!',
                            'Medida reingreasada con exito',
                            'success'
                        )
                        tblMedidas.ajax.reload();
                    } else {
                        Swal.fire(
                            'Alerta',
                            res,
                            'error'
                        )
                    }
                }
            }

        }
    })
}
//FIN MEDIDAS
function frmCajas() {
    document.getElementById("title").innerHTML = "Nueva caja"; //toma el id del titulo del modal, y lo cambia si se ejecuta esta funcion
    document.getElementById("btnAccion").innerHTML = "Registrar";
    document.getElementById("frmCajas").reset();
    $("#nuevo_caja").modal("show");
    document.getElementById("idcaja").value = "";
}
function registrarCaja(e) {
    e.preventDefault();
    const nombre = document.getElementById("caja");
    if (nombre.value == "") {
        alertas('Todos los campos son obligatorios', 'warning');
    } else {
        const url = base_url + "Cajas/registrar"; //controlador/metodo
        const frm = document.getElementById("frmCajas");
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send(new FormData(frm));
        http.onreadystatechange = function () { //si el readystate es igual a 4 y el status es igual a 200, la respuesta está lista, y se puede ejecutar
            if (this.readyState == 4 && this.status == 200) {
                //console.log(this.responseText);
                const res = JSON.parse(this.responseText); //en esta línea se imprime en un arreglo que se muestra por consola, los datos que el usuario haya ingresado
                alertas(res.msg,res.icono);
                frm.reset();
                $("#nuevo_caja").modal("hide");
                tblCajas.ajax.reload();
            }
        }
    }
}
function btnEditarCajas(idcaja) {
    document.getElementById("title").innerHTML = "Actualizar Cajas"; //toma el id del titulo del modal, y lo cambia si se ejecuta esta funcion
    document.getElementById("btnAccion").innerHTML = "Modificar";
    const url = base_url + "Cajas/editar/" + idcaja; //controlador/metodo
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function () { //si el readystate es igual a 4 y el status es igual a 200, la respuesta está lista, y se puede ejecutar
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            //console.log(this.responseText); //que está mostrando/respondiendo el servidor
            document.getElementById("idcaja").value = res.idcaja;
            document.getElementById("caja").value = res.caja;
            $("#nuevo_caja").modal("show");
        }
    }

}
function btnEliminarCajas(idcaja) {
    Swal.fire({
        title: 'Estás seguro?',
        text: "Se cambiará el estado de la caja a inactiva",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Cajas/eliminar/" + idcaja; //controlador/metodo
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () { //si el readystate es igual a 4 y el status es igual a 200, la respuesta está lista, y se puede ejecutar
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    tblCajas.ajax.reload();
                    alertas(res.msg,res.icono);
                }
            }

        }
    })
}
function btnReingresarCajas(idcaja) {
    Swal.fire({
        title: 'Estás seguro de reingresar?',
        text: "Se cambiará el estado de la caja a: 'activo'",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Reingresar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Cajas/reingresar/" + idcaja; //controlador/metodo
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () { //si el readystate es igual a 4 y el status es igual a 200, la respuesta está lista, y se puede ejecutar
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    tblCajas.ajax.reload();
                    alertas(res.msg,res.icono);
                }
            }

        }
    })
}
//FIN CAJAS
function frmProducto() {
    document.getElementById("title").innerHTML = "Nuevo Producto"; //toma el id del titulo del modal, y lo cambia si se ejecuta esta funcion
    document.getElementById("btnAccion").innerHTML = "Registrar";
    document.getElementById("frmProducto").reset();
    $("#nuevo_producto").modal("show");
    document.getElementById("id").value = "";
    deleteImg();
}
function registrarPro(e) {
    e.preventDefault();
    const codigo = document.getElementById("codigo");
    const nombre = document.getElementById("nombre");
    const precio_compra = document.getElementById("precio_compra");
    const precio_venta = document.getElementById("precio_venta");
    const id_medida = document.getElementById("medida");
    const id_cat = document.getElementById("categoria");
    if (codigo.value == "" || nombre.value == "" || precio_compra.value == "" || precio_venta.value == "") {
        Swal.fire({
            position: 'center',
            icon: 'error',
            title: 'Todos los campos son obligatorios',
            showConfirmButton: false,
            timer: 2000
        })
    } else {
        const url = base_url + "Productos/registrar"; //controlador/metodo
        const frm = document.getElementById("frmProducto");
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send(new FormData(frm));
        http.onreadystatechange = function () { //si el readystate es igual a 4 y el status es igual a 200, la respuesta está lista, y se puede ejecutar
            if (this.readyState == 4 && this.status == 200) {
                console.log(this.responseText);
                const res = JSON.parse(this.responseText);
                console.log(this.responseText); //en esta línea se imprime en un arreglo que se muestra por consola, los datos que el usuario haya ingresado
                if (res == "si") {
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Producto registrado con exito',
                        showConfirmButton: false,
                        timer: 2000
                    })
                    frm.reset();
                    $("#nuevo_producto").modal("hide");
                    tblProductos.ajax.reload();

                } else if (res == "modificado") {
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Producto modificado con exito',
                        showConfirmButton: false,
                        timer: 2000
                    })
                    $("#nuevo_producto").modal("hide");
                    tblProductos.ajax.reload();
                } else {
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: res,
                        showConfirmButton: false,
                        timer: 2000
                    })
                }
            }
        }
    }
}
function btnEditarPro(id) {
    document.getElementById("title").innerHTML = "Actualizar Producto"; //toma el id del titulo del modal, y lo cambia si se ejecuta esta funcion
    document.getElementById("btnAccion").innerHTML = "Modificar";
    const url = base_url + "Productos/editar/" + id; //controlador/metodo
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function () { //si el readystate es igual a 4 y el status es igual a 200, la respuesta está lista, y se puede ejecutar
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            //console.log(this.responseText); //que está mostrando/respondiendo el servidor

            document.getElementById("id").value = res.id;
            document.getElementById("codigo").value = res.codigo;
            document.getElementById("nombre").value = res.descripcion;
            document.getElementById("precio_compra").value = res.precio_compra;
            document.getElementById("precio_venta").value = res.precio_venta;
            document.getElementById("medida").value = res.id_medida;
            document.getElementById("categoria").value = res.id_categoria;
            document.getElementById("img-preview").src = base_url + 'Assets/img/' + res.foto;
            document.getElementById("icon-cerrar").innerHTML = `<button class="btn btn-danger" onclick="deleteImg()"><i class="fas fa-xmark"></i></button>`;
            document.getElementById("icon-image").classList.add("d-none");
            document.getElementById("foto_actual").value = res.foto;
            $("#nuevo_producto").modal("show");
        }
    }

}
function btnEliminarPro(id) {
    Swal.fire({
        title: 'Estás seguro?',
        text: "Se cambiará el estado del Producto a inactivo",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Productos/eliminar/" + id; //controlador/metodo
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () { //si el readystate es igual a 4 y el status es igual a 200, la respuesta está lista, y se puede ejecutar
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    if (res == "ok") {
                        Swal.fire(
                            'Eliminado!',
                            'Producto eliminado',
                            'success'
                        )
                        tblProductos.ajax.reload();
                    } else {
                        Swal.fire(
                            'Alerta',
                            res,
                            'error'
                        )
                    }
                }
            }

        }
    })
}
function btnReingresarPro(id) {
    Swal.fire({
        title: 'Estás seguro de reingresar?',
        text: "Se cambiará el estado del producto a: 'activo'",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Reingresar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Productos/reingresar/" + id; //controlador/metodo
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () { //si el readystate es igual a 4 y el status es igual a 200, la respuesta está lista, y se puede ejecutar
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    if (res == "ok") {
                        Swal.fire(
                            'Reigresado!',
                            'Producto reingreasado con exito',
                            'success'
                        )
                        tblProductos.ajax.reload();
                    } else {
                        Swal.fire(
                            'Alerta',
                            res,
                            'error'
                        )
                    }
                }
            }

        }
    })
}
function preview(e) { //funcion para previsualizar la imagen cuando se selecciona en el registrar
    // console.log(e.target.files); //esto mostrará los valores de la imagen que se selecciona(tamaño, nombre, tipo, etc.)
    const url = e.target.files[0];
    const urlTmp = URL.createObjectURL(url);
    document.getElementById("img-preview").src = urlTmp;
    document.getElementById("icon-image").classList.add("d-none");
    document.getElementById("icon-cerrar").innerHTML = `<button class="btn btn-danger" onclick="deleteImg()"><i class="fas fa-xmark"></i></button>
   ${url['name']}`;
}
function deleteImg() { //funcion para eliminar la vista previa de la imagen puesta
    document.getElementById("icon-cerrar").innerHTML = '';
    document.getElementById("icon-image").classList.remove("d-none");
    document.getElementById("img-preview").src = '';
    document.getElementById("imagen").value = '';
    document.getElementById("foto_actual").value = '';
}
//FIN PRODUCTOS
function buscarCodigo(e) {
    e.preventDefault();
    const cod = document.getElementById("codigo").value;
    if(cod !=  ''){
        if (e.which == 13) {
            const url = base_url + "Compras/buscarCodigo/" + cod; //controlador/metodo
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () { //si el readystate es igual a 4 y el status es igual a 200, la respuesta está lista, y se puede ejecutar
                if (this.readyState == 4 && this.status == 200) {
                    //console.log(this.responseText);
                    const res = JSON.parse(this.responseText);
                    if (res) {
                        document.getElementById("nombre").value = res.descripcion;
                        document.getElementById("precio").value = res.precio_compra;
                        document.getElementById("id").value = res.id;
                        document.getElementById("cantidad").removeAttribute('disabled');
                        document.getElementById("cantidad").focus();
                    } else {
                        alertas('El producto no existe', 'error');
                        document.getElementById("codigo").value = '';
                        document.getElementById("codigo").focus();
                    }
    
                }
            }
        } 
    }

}

function calcularPrecio(e) {
    e.preventDefault();
    const cant = document.getElementById("cantidad").value;
    const precio = document.getElementById("precio").value;
    document.getElementById("subtotal").value = precio * cant; //calcular la cantidad en base al precio del producto que se tenga en la base de datos
    if (e.which == 13) { //esta validación significa que si sí se ha presionado la tecla enter que envía la info
        if (cant > 0) {
            const url = base_url + "Compras/ingresar"; //controlador/metodo
            const frm = document.getElementById("frmCompra");
            const http = new XMLHttpRequest();
            http.open("POST", url, true);
            http.send(new FormData(frm));
            http.onreadystatechange = function () {//si el readystate es igual a 4 y el status es igual a 200, la respuesta está lista, y se puede ejecutar
                if (this.readyState == 4 && this.status == 200) {
                    //console.log(this.responseText);
                    const res = JSON.parse(this.responseText);
                    alertas(res.msg,res.icono);
                    frm.reset();
                    cargarDetalle();
                    document.getElementById('cantidad').setAttribute('disabled','disabled');
                    document.getElementById('codigo').focus();
                }
            }
        }
    }
}
if(document.getElementById('tblDetalle')){
    cargarDetalle();
}
function cargarDetalle() {
    const url = base_url + "Compras/listar"; //controlador/metodo
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function () {//si el readystate es igual a 4 y el status es igual a 200, la respuesta está lista, y se puede ejecutar
        if (this.readyState == 4 && this.status == 200) {
            //console.log(this.responseText);
            const res = JSON.parse(this.responseText);
            let html = '';
            res.detalle.forEach(row => {
                html += `<tr>
                    <td>${row['id']}</td>
                    <td>${row['descripcion']}</td>
                    <td>${row['cantidad']}</td>
                    <td>${row['precio']}</td>
                    <td>${row['sub_total']}</td>
                    <td>
                        <button class="btn btn-danger" type="button" onclick="deleteDetalle(${row['id']})"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>`
            });
            document.getElementById("tblDetalle").innerHTML = html;
            document.getElementById("total").value = res.total_pagar.total;
        }
    }
}
function deleteDetalle(id) {
    const url = base_url + "Compras/delete/" + id; //controlador/metodo
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function () {//si el readystate es igual a 4 y el status es igual a 200, la respuesta está lista, y se puede ejecutar
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            if (res == "ok") {
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Producto eliminado',
                    showConfirmButton: false,
                    timer: 2000
                })
                cargarDetalle();
            } else {
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'error al eliminar el producto',
                    showConfirmButton: false,
                    timer: 2000
                })
            }
        }
    }
}
function generarCompra() {
    Swal.fire({
        title: 'Estás seguro de realizar la compra?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Confirmar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Compras/registrarCompra/" + id; //controlador/metodo
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () { //si el readystate es igual a 4 y el status es igual a 200, la respuesta está lista, y se puede ejecutar
                if (this.readyState == 4 && this.status == 200) {
                    //console.log(this.responseText);
                    const res = JSON.parse(this.responseText);
                    if (res.msg == "ok") {
                        Swal.fire(
                            'Listo!',
                            'Compra generada',
                            'success'
                        )
                        const ruta = base_url + 'Compras/generarPdf/' + res.id_compra;
                        window.open(ruta);
                        setTimeout(()=> {
                            window.location.reload();
                        }, 200);
                    } else {
                        Swal.fire(
                            'Alerta',
                            res,
                            'error'
                        )
                    }
                }
            }

        }
    })
}
//FIN DETALLE-COMPRA
function modificarEmpresa(){
    const frm = document.getElementById('frmEmpresa');
    const url = base_url + "Administracion/modificar/" + id; //controlador/metodo
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(new FormData(frm));
    http.onreadystatechange = function () { //si el readystate es igual a 4 y el status es igual a 200, la respuesta está lista, y se puede ejecutar
        if (this.readyState == 4 && this.status == 200) {
            //console.log(this.responseText);
            const res = JSON.parse(this.responseText);
            if(res == "ok"){
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Datos modificados',
                    showConfirmButton: false,
                    timer: 2000
                })
            }
        }
    }
}
function alertas(mensaje, icono){
    Swal.fire({
        position: 'center',
        icon: icono,
        title: mensaje,
        showConfirmButton: false,
        timer: 2000
    })
}

