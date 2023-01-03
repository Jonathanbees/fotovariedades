let tblUsuarios;
document.addEventListener("DOMContentLoaded", function() {
    tblUsuarios = $('#tblUsuarios').DataTable({
        ajax: {
            url: base_url + "Usuarios/listar",
            dataSrc: ''
        },
        columns: [{
            'data' : 'id'
        }, 
        {
            'data' : 'usuario'
        }, 
        {
            'data' : 'nombre'
        }, 
        {
            'data' : 'caja'
        },
        {
            'data' : 'estado'
        },
        {
            'data' : 'acciones'
        }
    ]
    });
})
function frmLogin(e) {
    e.preventDefault();
    const usuario = document.getElementById("usuario"); //se recibe el elemento usuario
    const clave = document.getElementById("clave"); //se recibe el elemento clave
    if (usuario.value == "") {
        clave.classList.remove("is-invalid");
        usuario.classList.add("is-invalid");
        usuario.focus();
    } else if (clave.value == ""){
        usuario.classList.remove("is-invalid");
        clave.classList.add("is-invalid"); //todas estas validaciones anteriores simplemente sirven para poner la casilla del usuario o la contraseña en rojo cuando no se marca algo
        clave.focus();
    } else{ 
        const url = base_url + "Usuarios/validar";
        const frm = document.getElementById("frmLogin");
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send(new FormData(frm)); 
        http.onreadystatechange = function(){ //si el readystate es igual a 4 y el status es igual a 200, la respuesta está lista, y se puede ejecutar
            if (this.readyState == 4 && this.status == 200){
                // console.log(this.responseText); en esta línea se imprime en un arreglo que se muestra por consola, los datos que el usuario haya ingresado
               const res = JSON.parse(this.responseText); // se parsea lo que el usuario ponga (que a la vez saca los datos de la base de datos) 
               //para encontrar lo que se pide, que es la respuesta "ok", esta se ve en el controlador usuario que imprime la respuesta por un json
               if (res == "ok"){
                //si todo funciona correctamente, se le concatena el controlador usuarios para mandarlo allá
                    window.location = base_url + "Usuarios";
               }else{
                document.getElementById("alerta").classList.remove("d-none");
                document.getElementById("alerta").innerHTML = res;
               }
            }
        }
    }
}
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
    const clave = document.getElementById("clave");
    const confirmar = document.getElementById("confirmar");
    const caja = document.getElementById("caja");
    if (usuario.value == "" || nombre.value == "" || caja.value == "") {
        Swal.fire({
            position: 'center',
            icon: 'error',
            title: 'Todos los campos son obligatorios',
            showConfirmButton: false,
            timer: 2000
          })
    } else{ 
        const url = base_url + "Usuarios/registrar"; //controlador/metodo
        const frm = document.getElementById("frmUsuario");
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send(new FormData(frm)); 
        http.onreadystatechange = function(){ //si el readystate es igual a 4 y el status es igual a 200, la respuesta está lista, y se puede ejecutar
            if (this.readyState == 4 && this.status == 200){
                console.log(this.responseText);
                const res = JSON.parse(this.responseText);
                console.log(this.responseText); //en esta línea se imprime en un arreglo que se muestra por consola, los datos que el usuario haya ingresado
               if (res == "si"){
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Usuario registrado con exito',
                    showConfirmButton: false,
                    timer: 2000
                  })
                  frm.reset();
                  $("#nuevo_usuario").modal("hide");
                  tblUsuarios.ajax.reload();
                
               } else if(res=="modificado") {
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Usuario modificado con exito',
                    showConfirmButton: false,
                    timer: 2000
                  })
                  $("#nuevo_usuario").modal("hide");
                  tblUsuarios.ajax.reload();
               }else {
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
function btnEditarUser(id) {
    document.getElementById("title").innerHTML = "Actualizar usuario"; //toma el id del titulo del modal, y lo cambia si se ejecuta esta funcion
    document.getElementById("btnAccion").innerHTML = "Modificar";
    const url = base_url + "Usuarios/editar/"+id; //controlador/metodo
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function(){ //si el readystate es igual a 4 y el status es igual a 200, la respuesta está lista, y se puede ejecutar
            if (this.readyState == 4 && this.status == 200){
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
        cancelButtonText:'no'
      }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Usuarios/eliminar/"+id; //controlador/metodo
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function(){ //si el readystate es igual a 4 y el status es igual a 200, la respuesta está lista, y se puede ejecutar
            if (this.readyState == 4 && this.status == 200){
                const res = JSON.parse(this.responseText);
                if(res == "ok"){
                    Swal.fire(
                        'Eliminado!',
                        'Usuario eliminado',
                        'success'
                      )
                      tblUsuarios.ajax.reload();
                } else{
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
function btnReingresarUser(id) {
    Swal.fire({
        title: 'Estás seguro de reingresar?',
        text: "se cambiará el estado del usuario a: 'activo'",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Eliminar',
        cancelButtonText:'no'
      }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Usuarios/reingresar/"+id; //controlador/metodo
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function(){ //si el readystate es igual a 4 y el status es igual a 200, la respuesta está lista, y se puede ejecutar
            if (this.readyState == 4 && this.status == 200){
                const res = JSON.parse(this.responseText);
                if(res == "ok"){
                    Swal.fire(
                        'Eliminado!',
                        'Usuario eliminado',
                        'success'
                      )
                      tblUsuarios.ajax.reload();
                } else{
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