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
    setInterval(function () {
        preloader = document.getElementsByClassName("preloader")[0];
        preloader.remove(); //PREGUNTAR PORQUE MARCA ERROR AQUÍ
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
    if (window.innerWidth >= 992){
        menu = document.getElementById("menu2");
        menu.classList.add("navbar-center");
    }else{
        menu.classList.remove("navbar-center")
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
const arrayModales = document.querySelectorAll('.modal'); //SELECCIONA TODOS LOS ELEMENTOS QUE TIENEN LA CLASE MODAL
arrayModales.forEach(modal =>{ //PARA CADA MODAL REALIZAMOS LO SIGUIENTE
    modal.addEventListener('hidden.bs.modal', function () { //SACADO DE BOOTSTRAP MODAL/EVENTS ES EL NOMBRE DE LA FUNCION QUE SE ENCARGA DE CERRAR EL MODAL
        let form = document.getElementsByTagName("form");
        for (i=0; i<form.length; i++){
         form[i].reset(); //HACEMOS UN RESET DE SUS CAMPOS
        }
        document.getElementById("dateB").disabled = true; //EVITA QUE SE ROMPA EL TEMA DE FECHAS
        document.getElementById("botonMarcar").classList.replace("btn-secondary", "btn-success")
        document.getElementById("botonMarcar").innerHTML = "Marcar todos"; //MANTIENE EL TEXTO POR DEFAULT
    });
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


// CORRIGE MAC ADDRESS
var macAddress = document.getElementById("mac");

    function formatMAC(e) {

        // /i Ignora mayusculas
        // Valida si las letras estan dentro de la A a la F, si no, coloca espacio en blanco
        var r = /([a-f0-9]{2})([a-f0-9]{2})/i, str = e.target.value.replace(/[^a-f0-9]/ig, "");

        while (r.test(str)) {
            // Coloca : despues de cada 2 digitos
            str = str.replace(r, '$1' + ':' + '$2');
        }

        e.target.value = str.slice(0, 17);

    };

// Comprueba cuando el usuario suelta la tecla
macAddress.addEventListener("keyup", formatMAC, false);
