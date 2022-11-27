
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
