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
                    window.location = base_url + "Administracion/home";
               }else{
                document.getElementById("alerta").classList.remove("d-none");
                document.getElementById("alerta").innerHTML = res;
               }
            }
        }
    }
}