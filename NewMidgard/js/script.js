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
        document.getElementById("passFields").innerHTML = "";
        document.getElementById("changePass").innerHTML = '<i class="fas fa-unlock"></i> Cambiar Contraseña';
        document.getElementById("confirmarPass").style.display = "none";
    });
});

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

//  !!!     WARZONE     !!!
//  !!! VALIDAR_USUARIO !!!
//  !!!     WARZONE     !!!
//  !!!     WARZONE     !!!

/*Bien*/
const formulario = document.getElementById('formUser');
const inputs = document.querySelectorAll('#formUser input');

const expresiones = { /*Bien*/
	username: /^[a-zA-Z0-9\_\-]{4,50}$/, // Letras, numeros, guion y guion_bajo
	fullname: /^[a-zA-ZÀ-ÿ\s]{4,50}$/, // Letras y espacios, pueden llevar acentos.
	clave: /^(?=.*[0-9])[a-zA-Z0-9!@#$%^&*]{6,20}$/, // 6 a 20 digitos. minimo 1 numero
	email: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/,
	dni: /^\d{8}[A-Z]$/ // 8 digitos.
}

const campos = { /*Bien*/
	username: false,
	fullname: false,
	clave: false,
	email: false,
	dni: false
}

const validarFormulario = (e) => { /*Bien*/
	switch (e.target.name) {
		case "username":
			validarCampo(expresiones.username, e.target, 'username');
		break;
		case "fullname":
			validarCampo(expresiones.fullname, e.target, 'fullname');
		break;
		case "clave":
			validarCampo(expresiones.clave, e.target, 'clave');
		break;
		case "email":
			validarCampo(expresiones.email, e.target, 'email');
		break;
		case "dni":
			validarCampo(expresiones.dni, e.target, 'dni');
		break;
	}
}

const validarCampo = (expresion, input, campo) => {
	if(expresion.test(input.value)){
		document.getElementById(`grupo__${campo}`).classList.remove('formulario__grupo-incorrecto');
		document.getElementById(`grupo__${campo}`).classList.add('formulario__grupo-correcto');
		document.querySelector(`#grupo__${campo} i`).classList.add('fa-check-circle');
		document.querySelector(`#grupo__${campo} i`).classList.remove('fa-times-circle');
		document.querySelector(`#grupo__${campo} .input-error`).classList.remove('input-error-activo');
		campos[campo] = true;
	} else {
		document.getElementById(`grupo__${campo}`).classList.add('formulario__grupo-incorrecto');
		document.getElementById(`grupo__${campo}`).classList.remove('formulario__grupo-correcto');
		document.querySelector(`#grupo__${campo} i`).classList.add('fa-times-circle');
		document.querySelector(`#grupo__${campo} i`).classList.remove('fa-check-circle');
		document.querySelector(`#grupo__${campo} .input-error`).classList.add('input-error-activo');
		campos[campo] = false;
	}
}

inputs.forEach((input) => { /*Bien*/
	input.addEventListener('onfocusout', validarFormulario);
	input.addEventListener('blur', validarFormulario);
});

formulario.addEventListener('submit', (e) => {
	e.preventDefault();
    let rolSelected = false;

    let rol = document.getElementById('rol');
    
    if (rol.value != "select"){
        rolSelected = true;
    }


	if(campos.username && campos.fullname && campos.clave && campos.email && campos.dni && rolSelected ){
		formulario.reset();

		document.getElementById('mensaje-exito').classList.add('mensaje-exito-activo');
		setTimeout(() => {
			document.getElementById('mensaje-exito').classList.remove('mensaje-exito-activo');
		}, 5000);

		document.querySelectorAll('.formulario__grupo-correcto').forEach((icono) => {
			icono.classList.remove('formulario__grupo-correcto');
		});
	} else {
		document.getElementById('formulario__mensaje').classList.add('mensaje-activo');
	}
});
// WARZONE END VALIDACION USUARIO


//  !!!     WARZONE     !!!
//  !!! VALIDAR_MENSAJE !!!
//  !!!     WARZONE     !!!
//  !!!     WARZONE     !!!

/*Bien*/
const formMensaje = document.getElementById('formPubli');
const mensajeInputs = document.querySelectorAll('#formPubli input');

const mensajeExpresiones = { 
	asunto: /^[0-9a-zA-Z!@#$%^&*À-ÿ\s]{4,30}$/, // Letras, numeros, espacios... minimo 4, hasta 30
	fecha: /^\d{4}-\d{2}-\d{2}$/, // regex Fecha
    archivo: (/\.(gif|jpe?g|tiff?|png|webp|bmp|pdf)$/i) // Archivo imagen
}

const mensajeCampos = {
	asunto: false,
	dateA: false,
	dateB: false,
    mensaje: false,
    publiImg: false
    
}

const validarFormMensaje = (e) => {
	switch (e.target.name) {
		case "asunto":
			validarCampoMensaje(mensajeExpresiones.asunto, e.target, 'asunto');
		break;
		case "dateA":
			validarCampoMensaje(mensajeExpresiones.fecha, e.target, 'dateA');
		break;
		case "dateB":
			validarCampoMensaje(mensajeExpresiones.fecha, e.target, 'dateB');
		break;
        case "publiImg":
			validarCampoMensaje(mensajeExpresiones.archivo, e.target, 'publiImg');
		break;
	}
}

const validarCampoMensaje = (expresion, input, campo) => {
	if(expresion.test(input.value)){
        alert('Grovyle');
		document.getElementById(`grupo__${campo}`).classList.remove('formulario__grupo-incorrecto');
		document.getElementById(`grupo__${campo}`).classList.add('formulario__grupo-correcto');
		document.querySelector(`#grupo__${campo} i`).classList.add('fa-check-circle');
		document.querySelector(`#grupo__${campo} i`).classList.remove('fa-times-circle');
		document.querySelector(`#grupo__${campo} .input-error`).classList.remove('input-error-activo');
		mensajeCampos[campo] = true;
	} else {
        alert('Gengar');
		document.getElementById(`grupo__${campo}`).classList.add('formulario__grupo-incorrecto');
		document.getElementById(`grupo__${campo}`).classList.remove('formulario__grupo-correcto');
		document.querySelector(`#grupo__${campo} i`).classList.add('fa-times-circle');
		document.querySelector(`#grupo__${campo} i`).classList.remove('fa-check-circle');
		document.querySelector(`#grupo__${campo} .input-error`).classList.add('input-error-activo');
		mensajeCampos[campo] = false;
	}
}

mensajeInputs.forEach((input) => {
	input.addEventListener('onfocusout', validarFormMensaje);
	input.addEventListener('blur', validarFormMensaje);
});

formMensaje.addEventListener('submit', (e) => {
	e.preventDefault();

	if(mensajeCampos.asunto && mensajeCampos.dateA && mensajeCampos.dateB && mensajeCampos.mensaje && mensajeCampos.publiImg){
		formMensaje.reset();

		document.getElementById('mensaje-exito').classList.add('mensaje-exito-activo');
		setTimeout(() => {
			document.getElementById('mensaje-exito').classList.remove('mensaje-exito-activo');
		}, 5000);

		document.querySelectorAll('.formulario__grupo-correcto').forEach((icono) => {
			icono.classList.remove('formulario__grupo-correcto');
		});
	} else {
		document.getElementById('formulario__publicacion').classList.add('mensaje-activo');
	}
});
// WARZONE END VALIDACION MENSAJE


//  !!!      WARZONE     !!!
//  !!! VALIDAR_PANTALLA !!!
//  !!!      WARZONE     !!!
//  !!!      WARZONE     !!!

/*Bien*/
const formPantalla = document.getElementById('formPantalla');
const pantallaInputs = document.querySelectorAll('#formPantalla input');

const pantallaExpresiones = { 
	nombre: /^[a-zA-Z0-9\_\-]{4,16}$/, // Letras, numeros, espacios... minimo 4, hasta 30
	mac: /^([0-9a-f]{1,2}[\.:-]){5}([0-9a-f]{1,2})$/ // regex Fecha
}

const pantallaCampos = {
	nombre: false,
	mac: false
}

const validarFormPantalla = (e) => {
	switch (e.target.name) {
		case "nombre":
			validarCampoPantalla(pantallaExpresiones.nombre, e.target, 'nombre');
		break;
		case "mac":
			validarCampoPantalla(pantallaExpresiones.mac, e.target, 'mac');
		break;
	}
}

const validarCampoPantalla = (expresion, input, campo) => {
	if(expresion.test(input.value)){
        alert('Grovyle');
		document.getElementById(`grupo__${campo}`).classList.remove('formulario__grupo-incorrecto');
		document.getElementById(`grupo__${campo}`).classList.add('formulario__grupo-correcto');
		document.querySelector(`#grupo__${campo} i`).classList.add('fa-check-circle');
		document.querySelector(`#grupo__${campo} i`).classList.remove('fa-times-circle');
		document.querySelector(`#grupo__${campo} .input-error`).classList.remove('input-error-activo');
		pantallaCampos[campo] = true;
	} else {
        alert('Gengar');
		document.getElementById(`grupo__${campo}`).classList.add('formulario__grupo-incorrecto');
		document.getElementById(`grupo__${campo}`).classList.remove('formulario__grupo-correcto');
		document.querySelector(`#grupo__${campo} i`).classList.add('fa-times-circle');
		document.querySelector(`#grupo__${campo} i`).classList.remove('fa-check-circle');
		document.querySelector(`#grupo__${campo} .input-error`).classList.add('input-error-activo');
		pantallaCampos[campo] = false;
	}
}

pantallaInputs.forEach((input) => {
	input.addEventListener('onfocusout', validarFormPantalla);
	input.addEventListener('blur', validarFormPantalla);
});

formPantalla.addEventListener('submit', (e) => {
	e.preventDefault();

	if(pantallaCampos.asunto && pantallaCampos.dateA && pantallaCampos.dateB){
		formPantalla.reset();

		document.getElementById('mensaje-exito').classList.add('mensaje-exito-activo');
		setTimeout(() => {
			document.getElementById('mensaje-exito').classList.remove('mensaje-exito-activo');
		}, 5000);

		document.querySelectorAll('.formulario__grupo-correcto').forEach((icono) => {
			icono.classList.remove('formulario__grupo-correcto');
		});
	} else {
		document.getElementById('formulario__pantalla').classList.add('mensaje-activo');
	}
});
// WARZONE END VALIDACION PANTALLA





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
