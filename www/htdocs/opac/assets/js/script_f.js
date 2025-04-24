
function BuscarIntegrada(base, modo, Opcion, Expresion, Coleccion, titulo_c, resaltar, submenu, Pft, mostrar_exp) {
	if (mostrar_exp != "") document.bi.action = "inicio_base.php"
	document.bi.base.value = base
	document.bi.Opcion.value = Opcion
	document.bi.modo.value = modo
	document.bi.home.value = mostrar_exp

	if (Opcion == "free") {
		document.bi.coleccion.value = Coleccion
		document.bi.Expresion.value = Expresion
	}

	if (Opcion == "directa") {
		document.bi.Expresion.value = Expresion
		document.bi.titulo_c.value = titulo_c
		document.bi.resaltar.value = resaltar
		document.bi.submenu.value = submenu
		document.bi.Pft.value = Pft
		document.bi.mostrar_exp.value = mostrar_exp
	}
	document.bi.submit()
}


function EnviarReserva(){
	hayerror=0
	document.enviarreserva.items_por_reservar.value=items_por_reservar;
	if (Trim(document.enviarreserva.usuario.value)==''  ){
		hayerror=1
	}

	if (hayerror==1){
		return false
	}else{
		document.enviarreserva.submit()
	}
}


function validateForm() {
	return true; // Allow submission
}



function MarkExpr(term) {
	highlightSearchTerms(term);
	console.log(term);
}

// buscar_integrada.php - line 568
window.onload = function () {
	const highlightElements = document.querySelectorAll('.highlight-terms');
	highlightElements.forEach(element => {
		const expression = element.getAttribute('data-expression');
		if (expression) {
			highlightSearchTerms(expression);
			console.log(expression);
		}
	});
};


// To top
jQuery(function () {
	jQuery(document).on('scroll', function () {
		if (jQuery(window).scrollTop() > 100) {
			jQuery('.smoothscroll-top').addClass('show');
		} else {
			jQuery('.smoothscroll-top').removeClass('show');
		}
	});
	jQuery('.smoothscroll-top').on('click', scrollToTop);
});

function scrollToTop() {
	verticalOffset = typeof (verticalOffset) != 'undefined' ? verticalOffset : 0;
	element = jQuery('body');
	offset = element.offset();
	offsetTop = offset.top;
	jQuery('html, body').animate({ scrollTop: offsetTop }, 600, 'linear').animate({ scrollTop: 25 }, 200).animate({ scrollTop: 0 }, 150).animate({ scrollTop: 0 }, 50);
}

document.getElementById('enviarDetalhes').addEventListener('click', function () {
	document.detailed.submit();
});


function handleCookieVisibility() {
	const cookie = getCookie('ABCD');
	const cookieDiv = document.getElementById('cookie_div');
	if (cookie && cookie.trim() !== "") {
		cookieDiv.style.display = 'inline-block';
	} else {
		cookieDiv.style.display = 'none';
	}
}

window.onload = handleCookieVisibility;


