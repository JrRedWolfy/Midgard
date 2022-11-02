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

function prueba(){
    let activar = "<?php echo include 'base.php'; cerrarSesion();?>";
    document.write("<?php echo include 'base.php'; cerrarSesion();?>");
}

//DESAPARECE LA CAPA DEL PRELOADER AL CARGAR LA PÁGINA
// window.onload = function fadeout(){
//     preloader = document.getElementsByClassName("preloader")[0];
//     preloader.style.opacity="0";
//     preloader.remove();
// }


window.addEventListener("load", function() { 
    // menu = document.getElementById("usuario");
    // if(menu != null){
    //    menu.remove(); 
    // } 
});

//GESTION DE ROLES
function noLogin(){
    document.getElementsByTagName("ul")[0].remove();
    li = document.getElementsByTagName("li");
    li[li.length-1].remove();
}
function admin(){
    //alert("SOY ADMIN");
    li = document.getElementsByTagName("li");
    li[li.length-2].remove();
}
function aprobador(){
    alert("SOY APROBADOR");
    menu = document.getElementById("menu");
    menu.classList.replace("bg-dark", "bg-secondary");
    menu.classList.replace("navbar-dark", "navbar-light");
}
function publicador(){
    alert("SOY PUBLICADOR");
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
        alert('Haz marcado '+marcado+' casillas');
    }
}

//MARCARA TODAS LAS CASILLAS DEL FORMULARIO (PENDIENTE)
function marcarTodos(){
    alert("PENDIENTE");
}
