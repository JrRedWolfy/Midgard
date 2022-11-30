
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

function fetchNews(boton){

    //CREAREMOS UNA CONSTANTE QUE ME RECOGERA EL DATO QUE QUIERO ENVIAR (TENER EN CUENTA EL NOMBRE YA QUE SE UTILIZARA EN)
    const dataN2 = {editNews : boton.name};
    
    fetch("php/fetch.php",{//ESPECIFICAMOS LA RUTA A LA QUE SE ENVIA
        method: 'POST',
        body: JSON.stringify(dataN2), //CODIFICAMOS LA VARIABLE PARA ENVIARLA A PHP
        headers:{ //LE INDICAMOS AL PROGRAMA QUE TIPO DE INFORMACIÓN ENVIAMOS
            'Accept' : 'application/json',
            'Content-Type' : 'application/json',
        }
    }).then(response =>{//RECIBIMOS LA RESPUESTA EN UN OBJETO TIPO JSON
        return response.json();
        
    }).then(editNews => {

        console.log(editNews.news);
        modalPublicacion = document.getElementById("publicacion"); //MODAL DE PUBLICACIÓN
        checkboxes = modalPublicacion.getElementsByClassName('form-check-input'); //TODOS LOS CHECKBOXES DE PUBLICACIÓN 

        for (i=1; i<editNews.news.length; i++){
            for (j=0; j<checkboxes.length; j++){
                if (checkboxes[j].value == editNews.news[i]){
                    checkboxes[j].checked = true;
                }
            }
        }
        document.getElementById("asunto").value = editNews.news[0]["titulo"];
        document.getElementById("mensaje").innerHTML = editNews.news[0]["mensaje"];
        document.getElementById("dateA").value = editNews.news[0]["fechaInicio"];
        document.getElementById("dateB").value = editNews.news[0]["fechaFin"];

    }).catch(error => console.error(error));//EN CASO DE ERROR ME LO MUESTRA POR CONSOLA
}