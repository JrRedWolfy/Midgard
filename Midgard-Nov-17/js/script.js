//BOTÓN DEL LOGIN QUE CAMBIA EL TIPO DEL INPUT Y SU CLASE EN FUNCIÓN DE SU ESTADO
function password(){
    let icono = document.getElementById('ojo');
    let clave = document.getElementById('clave');
    
    if (clave.type == "password"){
        icono.className = "fa fa-eye-slash"
        clave.type = "text";
    }else{
        icono.className = "fa fa-eye"
        clave.type = "password";
    }
}
//SE EJECUTA AL CARGAR LA PAGINA
window.addEventListener("load", function() { 
    
    //DESAPARECE LA CAPA DEL PRELOADER AL CARGAR LA PÁGINA
    let prelod = setInterval(function (){
        preloader = document.getElementsByClassName("preloader")[0];
        preloader.remove(); 
        clearInterval(prelod);
    }, 1000);

    //LLAMA A LA FUNCION DE FECHA MINIMA
    thisDate();

    //LLAMA A LA FUNCION QUE ME CENTRA MI MENU
    menuCentrado();
});

//SE EJECUTA AL CAMBIAR EL TAMAÑO DE LA PAGINA
window.addEventListener("resize", function(){

    menuCentrado();
});

//COLOCA EL MENU EN EL CENTRO EN FUNCIÓN DEL ANCHO DEL MONITOR
function menuCentrado(){

    if(document.getElementById("menu2") != null){
        if (window.innerWidth >= 992){
            menu = document.getElementById("menu2");
            menu.classList.add("navbar-center");
        }else{
            menu.classList.remove("navbar-center");
        }
    }
}


//TOMA LA FECHA ACTUAL Y COLOCA EL VALOR MINIMO A LA FECHA DE LOS FORMULARIOS
function thisDate() {
    let fecha = new Date();
    let year = fecha.getFullYear();
    let mes = fecha.getMonth() + 1;
    let day = fecha.getDate();
    
    if (mes < 10){
        mes = "0" + mes;
    }
    if (day < 10){
        day = "0" + day;
    }
    let fechaStr = year + "-" + mes + "-" + day;
    if (document.getElementById("dateA")){
        document.getElementById("dateA").setAttribute('min', ''+fechaStr);
    }
    
}

//ASIGNA EL MINIMO DE FECHAINICIO A LA FECHAFIN
function selectDate() {

    valorDate = document.getElementById("dateA").value;
    fechaFin = document.getElementById("dateB");

    fechaFin.min = valorDate;
    fechaFin.value = valorDate;
    fechaFin.disabled = false; 
}

//GESTION DE ROLES
function noLogin(){
    //REMUEVE EL MENU
    document.getElementsByTagName("ul")[0].remove();
        
    //REMUEVE EL INGRESAR
    li = document.getElementsByTagName("li");
    li[li.length-1].remove();

    //REMUEVE EL SUBMENU
    document.getElementsByClassName("container")[0].remove();
}

function admin(){
    //REMUEVE EL INGRESAR
    li = document.getElementsByTagName("li");
    li[li.length-2].remove();
}
function aprobador(){
    //REMUEVE EL INGRESAR
    li = document.getElementsByTagName("li");
    li[li.length-2].remove();
   
    //REMUEVE LOS ELEMENTOS NEW USER Y NEW SCREEN
    li[0].remove();
    li[1].remove();

    //REMUEVE ALGUNOS ELEMENTOS DEL SUBMENU
    submenu = document.getElementsByClassName("capa");
    submenu[2].remove();
    submenu[3].remove();

    //AÑADE CLASES PARA ALINEAR CONTENIDOS
    submenu[2].classList.replace("offset-lg-2", "offset-md-3");
    submenu[2].classList.add("offset-lg-0");
}
function publicador(){
    //REMUEVE EL INGRESAR
    li = document.getElementsByTagName("li");
    li[li.length-2].remove();
   
    //REMUEVE LOS ELEMENTOS NEW USER Y NEW SCREEN
    li[0].remove();
    li[1].remove();

    //REMUEVE ALGUNOS ELEMENTOS DEL SUBMENU
    submenu = document.getElementsByClassName("capa");
    submenu[2].remove();
    submenu[3].remove();
    submenu[2].remove();
    submenu[0].classList.add("offset-lg-2");

    //CAMBIA EL COLOR DEL MENÚ
    menu = document.getElementById("menu");
    menu.classList.replace("bg-dark", "bg-primary");
}

//SE ENCARGA DE GESTIONAR QUE AL MENOS UN CHECKBOX SEA MARCADO ANTES DE ENVIAR EL FORM AL PHP
function verificarForm(){
    let marcado=0;
    let checkbox = document.getElementsByClassName('form-check-input'); 
    
    for (i = 0; i < checkbox.length; i++) {
        if(checkbox[i].checked == true){
            marcado++;
        }
    }
     
    if(marcado == 0){
        alert('Debe seleccionar al menos un departamento'); //HACER UN ALERT DE BOOTSTRAP (PENDIENTE)
        return false;
    }else{
        return true;
    }
}

//MUESTRA LAS CASILLAS DE CAMBIO DE CONTRASEÑA
function showPassField(){

    let action = document.getElementById("passFields").innerHTML;
    let passField;
    if (action == ""){
        passField = '<label for="clave" class="form-label mt-2">Contraseña Actual</label><input type="password" class="form-control" id="clave" name="clave" required><label for="clave" class="form-label mt-2">Contraseña Nueva</label><input type="password" class="form-control" id="clave" name="clave" required><label for="clave" class="form-label mt-2">Repetir Contraseña Nueva</label><input type="password" class="form-control" id="clave" name="clave" required>'
        document.getElementById("changePass").innerHTML = '<i class="fas fa-lock"></i> Cancelar';
        document.getElementById("confirmarPass").style.display = "block";
    } else {
        passField = "";
        document.getElementById("changePass").innerHTML = '<i class="fas fa-unlock"></i> Cambiar Contraseña';
        document.getElementById("confirmarPass").style.display = "none";
    }


    
    document.getElementById("passFields").innerHTML = passField;

}

//MARCA TODAS LAS CASILLAS DEL FORMULARIO
function marcarTodos(){
    let checkbox = document.getElementsByClassName('form-check-input');
    let botonMarcar = document.getElementById("botonMarcar");
    for (i = 0; i < checkbox.length; i++) {
        if(checkbox[i].checked == true && botonMarcar.className == "btn btn-secondary btn-sm mt-2"){
            checkbox[i].checked = false;
        }else{
            checkbox[i].checked = true;
        }
    }
 
    //CAMBIA EL TEXTO Y EL BOTON
    if (botonMarcar.innerHTML == "Marcar todos"){
        botonMarcar.innerHTML = "Desmarcar todos";
        botonMarcar.classList.replace("btn-success", "btn-secondary");
    }else{
        botonMarcar.innerHTML="Marcar todos";
        botonMarcar.classList.replace("btn-secondary", "btn-success");
    }
}

//ELIMINA LOS VALORES DEL MODAL AL CERRARSE 
const arrayModales = document.querySelectorAll('.modalForm'); //SELECCIONA TODOS LOS ELEMENTOS QUE TIENEN LA CLASE MODAL
arrayModales.forEach(modal =>{ //PARA CADA MODAL REALIZAMOS LO SIGUIENTE
    modal.addEventListener('hidden.bs.modal', function () { //SACADO DE BOOTSTRAP MODAL/EVENTS ES EL NOMBRE DE LA FUNCION QUE SE ENCARGA DE CERRAR EL MODAL
        let form = document.getElementsByTagName("form");
        for (i=0; i<form.length; i++){
         form[i].reset(); //HACEMOS UN RESET DE SUS CAMPOS
        }
        document.getElementById("dateB").disabled = true; //EVITA QUE SE ROMPA EL TEMA DE FECHAS
        document.getElementById("botonMarcar").classList.replace("btn-secondary", "btn-success")
        document.getElementById("botonMarcar").innerHTML = "Marcar todos"; //MANTIENE EL TEXTO POR DEFAULT
        document.getElementById("passFields").innerHTML = "";
        document.getElementById("changePass").innerHTML = '<i class="fas fa-unlock"></i> Cambiar Contraseña';
        document.getElementById("confirmarPass").style.display = "none";
    });
});


//ELIMINA LOS VALORES DEL MODAL NOTICIA AL CERRARSE
modalNews = document.getElementById('modalNews'); //SELECCIONA MODAL NOTICIA

modalNews.addEventListener('hidden.bs.modal', function () { //SACADO DE BOOTSTRAP MODAL/EVENTS ES EL NOMBRE DE LA FUNCION QUE SE ENCARGA DE CERRAR EL MODAL
    document.getElementById("imgPublicacion").innerHTML = "";
});



//CARRUSEL INDEX
function next(){
    //SELECCIONAMOS TODOS LOS ELEMENTOS CON LA CLASE "carruselPantalla"
    nombrePantalla = document.getElementsByClassName("carruselPantalla");
    contenidoPantalla = document.getElementsByClassName("carrusel-pantalla");
    
    for (i=0; i<nombrePantalla.length; i++){ //Por cada elemento que tiene la clase
        if(nombrePantalla[i].classList.contains("activo")){ //Ocultamos o mostramos el contenido
            nombrePantalla[i].classList.replace("activo", "d-none");
            contenidoPantalla[i].classList.replace("activo", "d-none");
            if (i == nombrePantalla.length-1){
                nombrePantalla[0].classList.replace("d-none", "activo");
                contenidoPantalla[0].classList.replace("d-none", "activo");
                break;
            }else{
                nombrePantalla[i+1].classList.replace("d-none", "activo");
                contenidoPantalla[i+1].classList.replace("d-none", "activo");
                break;
            }
        }
    }
    
}
function prev(){
    nombrePantalla = document.getElementsByClassName("carruselPantalla");
    contenidoPantalla = document.getElementsByClassName("carrusel-pantalla");
    for (i=0; i<nombrePantalla.length; i++){
        if(nombrePantalla[i].classList.contains("activo")){
            nombrePantalla[i].classList.replace("activo", "d-none");
            contenidoPantalla[i].classList.replace("activo", "d-none");
            if (i == 0){
                nombrePantalla[nombrePantalla.length-1].classList.replace("d-none", "activo");
                contenidoPantalla[nombrePantalla.length-1].classList.replace("d-none", "activo");
                break;
            }else{
                nombrePantalla[i-1].classList.replace("d-none", "activo"); 
                contenidoPantalla[i-1].classList.replace("d-none", "activo");
                break;
            }
        }
    }
}


//HABILITA LOS POPOVERS DE TODO EL DOCUMENTO
var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
  return new bootstrap.Popover(popoverTriggerEl)
})

//BORRA EL POPOVER AL SIGUIENTE CLICK
var popover = new bootstrap.Popover(document.querySelector('.popover-dismiss'), {
    trigger: 'focus'
  })

  
//  !!!    AJAX PANTALLAS    !!!
//  !!!    AJAX PANTALLAS    !!!

function ajaxPantalla(div){
    
    // boton.id / boton.name
    //CREAREMOS UNA CONSTANTE QUE ME RECOGERA EL DATO QUE QUIERO ENVIAR (TENER EN CUENTA EL NOMBRE YA QUE SE UTILIZARA EN)
    const dataP = {pantalla : div.id};
    
    fetch("base.php",{//ESPECIFICAMOS LA RUTA A LA QUE SE ENVIA
        method: 'POST',
        body: JSON.stringify(dataP), //CODIFICAMOS LA VARIABLE PARA ENVIARLA A PHP
        headers:{ //LE INDICAMOS AL PROGRAMA QUE TIPO DE INFORMACIÓN ENVIAMOS
            'Accept' : 'application/json',
            'Content-Type' : 'application/json',
        }
    }).then(response =>{//RECIBIMOS LA RESPUESTA EN UN OBJETO TIPO JSON
        
        return response.json();
        
    }).then(dataP => {

        document.getElementById("nombre").innerHTML = dataP.pantalla[0]["nombre"];
        document.getElementById("direccion").innerHTML = dataP.pantalla[0]["mac_pantalla"];
        document.getElementById("ubicacion").innerHTML = dataP.pantalla[0]["ubicacion"];
        
        //document.getElementById("resultados").innerHTML= "<p>"+data.usuario[0]['id_rol']+"</p>";
        
    }).catch(error => console.error(error));//EN CASO DE ERROR ME LO MUESTRA POR CONSOLA
}

//  !!!    AJAX USUARIOS    !!!
//  !!!    AJAX USUARIOS    !!!

function ajaxUser(div){
    
    // boton.id / boton.name
    //CREAREMOS UNA CONSTANTE QUE ME RECOGERA EL DATO QUE QUIERO ENVIAR (TENER EN CUENTA EL NOMBRE YA QUE SE UTILIZARA EN)
    let dataU = {usuario : div.id};
    
    fetch("base.php",{//ESPECIFICAMOS LA RUTA A LA QUE SE ENVIA
        method: 'POST',
        body: JSON.stringify(dataU), //CODIFICAMOS LA VARIABLE PARA ENVIARLA A PHP
        headers:{ //LE INDICAMOS AL PROGRAMA QUE TIPO DE INFORMACIÓN ENVIAMOS
            'Accept' : 'application/json',
            'Content-Type' : 'application/json',
        }
    }).then(response =>{//RECIBIMOS LA RESPUESTA EN UN OBJETO TIPO JSON
        
        return response.json();
        
    }).then(dataU => {

        document.getElementById("user").innerHTML = dataU.usuario[0]["username"];
        document.getElementById("pass").innerHTML = dataU.usuario[0]["clave"];
        document.getElementById("nombre").innerHTML = dataU.usuario[0]["nombre"];
        document.getElementById("email").innerHTML = dataU.usuario[0]["email"];
        document.getElementById("dni").innerHTML = dataU.usuario[0]["dni"];

        if(dataU.usuario[0]["inactivo"] == 0){
            document.getElementById("inactive").innerHTML = "No";
        } else{
            document.getElementById("inactive").innerHTML = "Si";
        }

        switch(dataU.usuario[0]["id_rol"]){
            case 1:
                document.getElementById("funcion").innerHTML = "Administrador";
                break;
            case 2:
                document.getElementById("funcion").innerHTML = "Aprobador";
                break;
            case 3:
                document.getElementById("funcion").innerHTML = "Publicador";
                break;
        }
        
    }).catch(error => console.error(error));//EN CASO DE ERROR ME LO MUESTRA POR CONSOLA
}


function ajaxNews(div){
    
    // boton.id / boton.name
    //CREAREMOS UNA CONSTANTE QUE ME RECOGERA EL DATO QUE QUIERO ENVIAR (TENER EN CUENTA EL NOMBRE YA QUE SE UTILIZARA EN)
    const dataN = {news : div.id};
    
    fetch("base.php",{//ESPECIFICAMOS LA RUTA A LA QUE SE ENVIA
        method: 'POST',
        body: JSON.stringify(dataN), //CODIFICAMOS LA VARIABLE PARA ENVIARLA A PHP
        headers:{ //LE INDICAMOS AL PROGRAMA QUE TIPO DE INFORMACIÓN ENVIAMOS
            'Accept' : 'application/json',
            'Content-Type' : 'application/json',
        }
    }).then(response =>{//RECIBIMOS LA RESPUESTA EN UN OBJETO TIPO JSON
        
        return response.json();
        
    }).then(dataN => {
        
        if(dataN.news[0]["imagen"] != null){
            document.getElementById("imgPublicacion").innerHTML = '<img class="img-fluid" src="img/userImage/'+dataN.news[0]["imagen"]+'">';
        }

        document.getElementById("title").innerHTML = dataN.news[0]["titulo"];
        document.getElementById("msg").innerHTML = dataN.news[0]["mensaje"];
        document.getElementById("writer").innerHTML = dataN.news[0]["escritor"];
        document.getElementById("dateS").innerHTML = dataN.news[0]["fechaInicio"];
        document.getElementById("dateE").innerHTML = dataN.news[0]["fechaFin"];
        document.getElementById("state").innerHTML = dataN.news[0]["estado"];
        document.getElementById("aprove").innerHTML = dataN.news[0]["aprobador"];
        document.getElementById("dateAprove").innerHTML = dataN.news[0]["fechaAprobacion"];




        
    }).catch(error => console.error(error));//EN CASO DE ERROR ME LO MUESTRA POR CONSOLA
}

