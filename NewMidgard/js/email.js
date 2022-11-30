function sendEmail() {
    
    alert(document.getElementById('writer').innerText);

    var insTextoComp = "De locos";
    var sEmail = "redcatter554@gmail.com";
	var sLink = "mailto:" + escape(sEmail)
	+ "?subject=" + escape("Te han compartirdo el siguente texto")
	+ "&body=" + insTextoComp;
	window.location.href = sLink;

}
