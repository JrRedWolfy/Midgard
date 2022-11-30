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

    //GESTONA LA POSICIÓN DEL MENU EN LA WEB
    if(document.getElementById("menu2") != null){
        if (window.innerWidth >= 992){
            menu = document.getElementById("menu2");
            menu.classList.add("navbar-center");
        }else{
            menu.classList.remove("navbar-center");
        }
    }

    //GESTIONA LA POSICIÓN DEL FOOTER EN LA WEB
    if (document.getElementsByTagName("footer")[0] != null){
        if (window.innerWidth <= 992){
            footer = document.getElementsByTagName("footer")[0];
            footer.classList.remove("fixed-bottom");
        } else{
            footer.classList.add("fixed-.bottom");
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
    submenu[3].classList.add("offset-lg-4");

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
}


//MUESTRA LAS CASILLAS DE CAMBIO DE CONTRASEÑA
function showPassField(){

    let action = 1;

    if (action == 1){
        
        document.getElementById("changePass").innerHTML = '<i class="fas fa-lock"></i> Cancelar';
        document.getElementById("passFields").style.display = "block";
        
    } else {
        passField = 0;
        document.getElementById("changePass").innerHTML = '<i class="fas fa-unlock"></i> Cambiar Contraseña';
        document.getElementById("passFields").style.display = "none";
    }

}

//MARCA TODAS LAS CASILLAS DEL FORMULARIO
function marcarTodos(){
    let checkbox = document.getElementsByClassName('checkPantalla');
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

//OCULTA ELEMENTOS DE MARCAR PANTALLA Y RANGO DE FECHAS
function ocultar(){
    
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

        document.querySelectorAll('.formulario__grupo-correcto').forEach((icono) => {
			icono.classList.remove('formulario__grupo-correcto');
		});
    });
});


//ELIMINA LOS VALORES DEL MODAL NOTICIA AL CERRARSE
modalNews = document.getElementById('modalNews'); //SELECCIONA MODAL NOTICIA
if (modalNews){
    modalNews.addEventListener('hidden.bs.modal', function () { //SACADO DE BOOTSTRAP MODAL/EVENTS ES EL NOMBRE DE LA FUNCION QUE SE ENCARGA DE CERRAR EL MODAL
        document.getElementById("imgPublicacion").innerHTML = "";
    });    
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

//HABILITA LOS POPOVERS DE TODO EL DOCUMENTO
let popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
let popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
  return new bootstrap.Popover(popoverTriggerEl)
})

//BORRA EL POPOVER AL SIGUIENTE CLICK
let popover = new bootstrap.Popover(document.querySelector('.popover-dismiss'), {
    trigger: 'focus'
  });


//  !!!    AJAX PANTALLAS    !!!
//  !!!    AJAX PANTALLAS    !!!

function ajaxPantalla(div){
    // boton.id / boton.name
    //CREAREMOS UNA CONSTANTE QUE ME RECOGERA EL DATO QUE QUIERO ENVIAR (TENER EN CUENTA EL NOMBRE YA QUE SE UTILIZARA EN)
    const dataP = {pantalla : div.id};
    
    fetch("php/fetch.php",{//ESPECIFICAMOS LA RUTA A LA QUE SE ENVIA
        method: 'POST',
        body: JSON.stringify(dataP), //CODIFICAMOS LA VARIABLE PARA ENVIARLA A PHP
        headers:{ //LE INDICAMOS AL PROGRAMA QUE TIPO DE INFORMACIÓN ENVIAMOS
            'Accept' : 'application/json',
            'Content-Type' : 'application/json',
        }
    }).then(response =>{//RECIBIMOS LA RESPUESTA EN UN OBJETO TIPO JSON
        
        return response.json();
        
    }).then(dataP => { 

        //console.log(dataP);
        document.getElementById("nombre").innerHTML = dataP.pantalla[0]["nombre"];
        document.getElementById("direccion").innerHTML = dataP.pantalla[0]["mac_pantalla"];
        document.getElementById("ubicacion").innerHTML = dataP.pantalla[0]["ubicacion"];
        
    }).catch(error => console.error(error));//EN CASO DE ERROR ME LO MUESTRA POR CONSOLA
}


//  !!!    AJAX EDIT PANTALLAS    !!!
//  !!!    AJAX EDIT PANTALLAS    !!!

function ajaxEditPantalla(boton){
    // boton.id / boton.name
    //CREAREMOS UNA CONSTANTE QUE ME RECOGERA EL DATO QUE QUIERO ENVIAR (TENER EN CUENTA EL NOMBRE YA QUE SE UTILIZARA EN)
    const dataEP = {pantallaEdit : boton.name};
    
    fetch("php/fetch.php",{//ESPECIFICAMOS LA RUTA A LA QUE SE ENVIA
        method: 'POST',
        body: JSON.stringify(dataEP), //CODIFICAMOS LA VARIABLE PARA ENVIARLA A PHP
        headers:{ //LE INDICAMOS AL PROGRAMA QUE TIPO DE INFORMACIÓN ENVIAMOS
            'Accept' : 'application/json',
            'Content-Type' : 'application/json',
        }
    }).then(response =>{//RECIBIMOS LA RESPUESTA EN UN OBJETO TIPO JSON
        
        return response.json();
        
    }).then(dataEP => { 

        //console.log(dataP);
        document.getElementById("nombreEdit").setAttribute("value", dataEP.pantalla[0]["nombre"]);
        document.getElementById("macEdit").setAttribute("value", dataEP.pantalla[0]["mac_pantalla"]);
        document.getElementById("ubicacionEdit").innerHTML = dataEP.pantalla[0]["ubicacion"];
        
    }).catch(error => console.error(error));//EN CASO DE ERROR ME LO MUESTRA POR CONSOLA
}

//  !!!    AJAX USUARIOS    !!!
//  !!!    AJAX USUARIOS    !!!

function ajaxUser(div){
    
    // boton.id / boton.name
    //CREAREMOS UNA CONSTANTE QUE ME RECOGERA EL DATO QUE QUIERO ENVIAR (TENER EN CUENTA EL NOMBRE YA QUE SE UTILIZARA EN)
    let dataU = {usuario : div.id};
    
    fetch("php/fetch.php",{//ESPECIFICAMOS LA RUTA A LA QUE SE ENVIA
        method: 'POST',
        body: JSON.stringify(dataU), //CODIFICAMOS LA VARIABLE PARA ENVIARLA A PHP
        headers:{ //LE INDICAMOS AL PROGRAMA QUE TIPO DE INFORMACIÓN ENVIAMOS
            'Accept' : 'application/json',
            'Content-Type' : 'application/json',
        }
    }).then(response =>{//RECIBIMOS LA RESPUESTA EN UN OBJETO TIPO JSON
        
        return response.json();
        
    }).then(dataU => {
        //console.log(dataU);
        
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


//  !!!    AJAX EDIT USUARIOS    !!!
//  !!!    AJAX EDIT USUARIOS    !!!

function ajaxUserEdit(boton){
    
    // boton.id / boton.name
    //CREAREMOS UNA CONSTANTE QUE ME RECOGERA EL DATO QUE QUIERO ENVIAR (TENER EN CUENTA EL NOMBRE YA QUE SE UTILIZARA EN)
    let dataEU = {usuarioEdit : boton.name};
    
    fetch("php/fetch.php",{//ESPECIFICAMOS LA RUTA A LA QUE SE ENVIA
        method: 'POST',
        body: JSON.stringify(dataEU), //CODIFICAMOS LA VARIABLE PARA ENVIARLA A PHP
        headers:{ //LE INDICAMOS AL PROGRAMA QUE TIPO DE INFORMACIÓN ENVIAMOS
            'Accept' : 'application/json',
            'Content-Type' : 'application/json',
        }
    }).then(response =>{//RECIBIMOS LA RESPUESTA EN UN OBJETO TIPO JSON
        
        return response.json();
        
    }).then(dataEU => {
        //console.log(dataU);
        
        document.getElementById("usernameEdit").setAttribute("value", dataEU.usuario[0]["username"]);
        document.getElementById("claveEdit").setAttribute("value", dataEU.usuario[0]["clave"]);
        document.getElementById("fullnameEdit").setAttribute("value", dataEU.usuario[0]["nombre"]);
        document.getElementById("emailEdit").setAttribute("value", dataEU.usuario[0]["email"]);
        document.getElementById("dniEdit").setAttribute("value", dataEU.usuario[0]["dni"]);

        switch(dataEU.usuario[0]["id_rol"]){
            case 1:
                document.getElementById("rol1").setAttribute("selected", true);
                document.getElementById("rol2").removeAttribute("selected");
                document.getElementById("rol3").removeAttribute("selected");
                break;
            case 2:
                document.getElementById("rol1").removeAttribute("selected");
                document.getElementById("rol2").setAttribute("selected", true);
                document.getElementById("rol3").removeAttribute("selected");
                break;
            case 3:
                document.getElementById("rol1").removeAttribute("selected");
                document.getElementById("rol2").removeAttribute("selected");
                document.getElementById("rol3").setAttribute("selected", true);
                break;
        }


    }).catch(error => console.error(error));//EN CASO DE ERROR ME LO MUESTRA POR CONSOLA
}


function ajaxNews(div){
    
    // boton.id / boton.name
    //CREAREMOS UNA CONSTANTE QUE ME RECOGERA EL DATO QUE QUIERO ENVIAR (TENER EN CUENTA EL NOMBRE YA QUE SE UTILIZARA EN)
    const dataN = {news : div.id};
    
    fetch("php/fetch.php",{//ESPECIFICAMOS LA RUTA A LA QUE SE ENVIA
        method: 'POST',
        body: JSON.stringify(dataN), //CODIFICAMOS LA VARIABLE PARA ENVIARLA A PHP
        headers:{ //LE INDICAMOS AL PROGRAMA QUE TIPO DE INFORMACIÓN ENVIAMOS
            'Accept' : 'application/json',
            'Content-Type' : 'application/json',
        }
    }).then(response =>{//RECIBIMOS LA RESPUESTA EN UN OBJETO TIPO JSON
        
        return response.json();
        
    }).then(dataN => {

        document.getElementById("aprobarBtn").setAttribute("value", dataN.news[0]["id_publicacion"]);
        document.getElementById("rechazarBtn").setAttribute("value", dataN.news[0]["id_publicacion"]);
        
        
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

        if (dataN.news[0]["estado"] == "Pendiente"){
            document.getElementById("NewPendiente").removeAttribute("hidden");
        } else{
            document.getElementById("NewPendiente").setAttribute("hidden", true);
        }
        
    }).catch(error => console.error(error));//EN CASO DE ERROR ME LO MUESTRA POR CONSOLA
}

function ajaxMismensajes(div){
    
    // boton.id / boton.name
    //CREAREMOS UNA CONSTANTE QUE ME RECOGERA EL DATO QUE QUIERO ENVIAR (TENER EN CUENTA EL NOMBRE YA QUE SE UTILIZARA EN)
    const dataM = {mimensaje : div.id};
    
    fetch("php/fetch.php",{//ESPECIFICAMOS LA RUTA A LA QUE SE ENVIA
        method: 'POST',
        body: JSON.stringify(dataN), //CODIFICAMOS LA VARIABLE PARA ENVIARLA A PHP
        headers:{ //LE INDICAMOS AL PROGRAMA QUE TIPO DE INFORMACIÓN ENVIAMOS
            'Accept' : 'application/json',
            'Content-Type' : 'application/json',
        }
    }).then(response =>{//RECIBIMOS LA RESPUESTA EN UN OBJETO TIPO JSON
        
        return response.json();
        
    }).then(dataN => {        
        
        // if(dataN.news[0]["imagen"] != null){
        //     document.getElementById("imgPublicacion").innerHTML = '<img class="img-fluid" src="img/userImage/'+dataN.news[0]["imagen"]+'">';
        // }

        document.getElementById("title").innerHTML = dataN.news[0]["titulo"];
        document.getElementById("msg").innerHTML = dataN.news[0]["mensaje"];
        document.getElementById("dateS").innerHTML = dataN.news[0]["fechaInicio"];
        document.getElementById("dateE").innerHTML = dataN.news[0]["fechaFin"];
        document.getElementById("state").innerHTML = dataN.news[0]["estado"];
        document.getElementById("aprove").innerHTML = dataN.news[0]["aprobador"];
        document.getElementById("dateAprove").innerHTML = dataN.news[0]["fechaAprobacion"];
        
    }).catch(error => console.error(error));//EN CASO DE ERROR ME LO MUESTRA POR CONSOLA
}

//PASAR EL ID DE PANTALLA AL BOTON BORRAR Y EDITAR
function getIdPantalla(e){
    let id = e.name;
    document.getElementById("deletePantallaInp").setAttribute("value", id);

}

//PASAR EL ID DE PANTALLA AL BOTON BORRAR Y EDITAR
function getIdUser(e){
    let id = e.name;
    document.getElementById("deleteUserInp").setAttribute("value", id);

}

//PASAR EL ID DE PANTALLA AL BOTON BORRAR Y EDITAR
function getIdPubli(e){
    let id = e.name;
    document.getElementById("deletePubliInp").setAttribute("value", id);

}






//VALIDACIÓN DE LOS FORMULARIOS

const expresiones = {
	username: /^[a-zA-Z0-9\_\-]{4,50}$/, // Letras, numeros, guion y guion_bajo
	fullname: /^[a-zA-ZÀ-ÿ\s]{4,50}$/, // Letras y espacios, pueden llevar acentos.
	clave: /^(?=.*[0-9])[a-zA-Z0-9!@#$%^&*]{6,20}$/, // 6 a 20 digitos. minimo 1 numero
	email: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/, // Validar Email
	dni: /^\d{8}[A-Z]$/, // 8 digitos.
    asunto: /^[0-9a-zA-Z!@#$%^&*À-ÿ\s]{4,30}$/, // Validar Asunto
    mac: /^([0-9a-f]{1,2}[\.:-]){5}([0-9a-f]{1,2})$/, // Validar formato Mac
    nombre: /^[a-zA-Z0-9\_\-\ ]{4,16}$/, // Validar Nombre pantalla
}

const campos = {
    // Campos Modal Usuario
	username: false,
	fullname: false,
	clave: false,
	email: false,
	dni: false,

    // Campos Modal Publicacion
    asunto: false,
    dates: false,
    contenido: false,

    // Campos Modal Pantalla
    nombre: false,
	mac: false,
    ubicacion: false
}

const formPantalla = document.getElementById('formPantalla');
const formUser = document.getElementById('formUser');
const formMensaje = document.getElementById('formPubli');

const inputs = document.querySelectorAll('input');
const textareas = document.querySelectorAll('textarea');


inputs.forEach((input) => { /*Bien*/
	input.addEventListener('keyup', validarFormulario);
	input.addEventListener('blur', validarFormulario);
    input.addEventListener('change', validarFormulario);
});

textareas.forEach((textarea) => { /*Bien*/
	textarea.addEventListener('keyup', validarFormulario);
	textarea.addEventListener('blur', validarFormulario);
});

function validarFormulario(e){ /*Bien*/
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
        case "asunto":
			validarCampo(expresiones.asunto, e.target, 'asunto');
		break;
        case "nombre":
			validarCampo(expresiones.nombre, e.target, 'nombre');
		break;
		case "mac":
			validarCampo(expresiones.mac, e.target, 'mac');
		break;
        case "mensaje":
			console.log("Estas en mensaje")
		break;
        case "ubicacion":
			console.log("Estas en Ubicación")
		break;
        // default:
        //     console.log("No coincide");
        //     break;
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

//VALIDAR PUBLICACIÓN
function validarPubli(){

    let rolSelected = false;
    let rol = document.getElementById('rol');
    
    //COMPRUEBA SI ROL ESTA SELECCIONADO
    if (rol.value != "select"){
        rolSelected = true;
    }

	if(campos.username && campos.fullname && campos.clave && campos.email && campos.dni && rolSelected ){
        campos.username = false;
        campos.fullname = false;
        campos.clave = false;
        campos.email = false; 
        campos.dni = false;

        return true;

	} else {
		document.getElementById('formulario__mensaje').classList.add('mensaje-activo');
        return false;
	}
}
// WARZONE END VALIDACION USUARIO


//VALIDAR PUBLICACIÓN
function validarPubli(){

    let marcado=0;
    let checkbox = document.getElementsByClassName('form-check-input'); 
    
    //COMPRUEBA LOS CHECKBOX MARCADOS
    for (i = 0; i < checkbox.length; i++) {
        if(checkbox[i].checked == true){
            marcado++;
        }
    }
     
    if(marcado == 0){
        alert('Debe seleccionar al menos un departamento');
    }


    //COMPRUEBA QUE LAS FECHAS NO ESTEN VACIAS
    if (document.getElementById("dateA").value != "" && document.getElementById("dateB").value != ""){
        campos.dates=true;
    }else{
        campos.dates=false;
        alert("Debe seleccionar un rango de fechas")
    }

    //COMPRUEBA QUE TENGA UN MENSAJE O UN ARCHIVO
    if (document.getElementById("mensaje").value != ""  || document.getElementById("publiImg").value != ""){
        campos.contenido=true;
    }else{
        campos.contenido=false;
        alert("Debe subir un archivo o realizar un mensaje");
    }
    
    //SI TODOS LOS CAMBIOS ESTAN BIEN DEVOLVEMOS TRUE Y PONEMOS NUEVAMENTE EN FALSE TODOS LOS CAMPOS PARA EL SIGUIENTE INSERT
	if(campos.asunto && campos.dates && campos.contenido && marcado>0){
        campos.asunto=false;
        campos.dates=false; 
        campos.contenido=false;
		// document.getElementById('mensaje-exito').classList.add('mensaje-exito-activo');
		// setTimeout(() => {
		// 	document.getElementById('mensaje-exito').classList.remove('mensaje-exito-activo');
		// }, 5000);

		
        return true;
	} else {
		document.getElementById('formulario__publicacion').classList.add('mensaje-activo');
        return false;
	}
}

//VALIDAR PANTALLA
function validarPantalla(){

    if (document.getElementById("ubicacion").value != ""){
        ubicacion = true;
    }else{
        ubicacion = false;
    }

	if(campos.nombre && campos.mac){
        ubicacion = false;
        return true;
	} else {
		document.getElementById('formulario__pantalla').classList.add('mensaje-activo');
        return false;
	}
}
// WARZONE END VALIDACION PANTALLA