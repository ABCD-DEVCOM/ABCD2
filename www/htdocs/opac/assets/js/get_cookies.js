		document.cookie = 'ABCD; expires=Thu, 01 Jan 1970 00:00:01 GMT; path=/;SameSite=Lax'

		/* Marcado y presentación de registros*/
		function getCookie(cname) {
			var name = cname + "=";
			var decodedCookie = decodeURIComponent(document.cookie);
			var ca = decodedCookie.split(';');
			for (var i = 0; i < ca.length; i++) {
				var c = ca[i];
				while (c.charAt(0) == ' ') {
					c = c.substring(1);
				}
				if (c.indexOf(name) == 0) {
					return c.substring(name.length, c.length);
				}
			}
			return "";
		}

		function Seleccionar(Ctrl) {
			cookie = getCookie('ABCD')
			if (Ctrl.checked) {
				if (cookie != "") {
					c = cookie + "|"
					if (c.indexOf(Ctrl.name + "|") == -1)
						cookie = cookie + "|" + Ctrl.name
				} else {
					cookie = Ctrl.name
				}
			} else {
				sel = Ctrl.name + "|"
				c = cookie + "|"
				n = c.indexOf(sel)
				if (n != -1) {
					cookie = cookie.substr(0, n) + cookie.substr(n + sel.length)
				}

			}
			document.cookie = "ABCD=" + cookie
			Ctrl = document.getElementById("cookie_div")
			Ctrl.style.display = "inline-block"
		}

/* Marcado y presentación de registros*/
/*
function getCookie(cname) {
	var name = cname + "=";
	var decodedCookie = decodeURIComponent(document.cookie);
	var ca = decodedCookie.split(';');
	for (var i = 0; i < ca.length; i++) {
		var c = ca[i];
		while (c.charAt(0) == ' ') {
			c = c.substring(1);
		}
		if (c.indexOf(name) == 0) {
			return c.substring(name.length, c.length);
		}
	}
	return "";
}
*/
function Seleccionar(Ctrl) {
	cookie = getCookie('ABCD')
	if (Ctrl.checked) {
		if (cookie != "") {
			c = cookie + "|"
			if (c.indexOf(Ctrl.name + "|") == -1)
				cookie = cookie + "|" + Ctrl.name
		} else {
			cookie = Ctrl.name
		}
	} else {
		sel = Ctrl.name + "|"
		c = cookie + "|"
		n = c.indexOf(sel)
		if (n != -1) {
			cookie = cookie.substr(0, n) + cookie.substr(n + sel.length)
		}

	}
	document.cookie = "ABCD=" + cookie
	Ctrl = document.getElementById("cookie_div")
	Ctrl.style.display = "inline-block"
}

function delCookie() {
	for (var i = 0; i < document.continuar.elements.length; i++) {
		element = document.continuar.elements[i];
		switch (element.type) {
			case 'checkbox':
				element.checked = false
				break;
		}
	}
	document.cookie = 'ABCD=;';
	//alert(msgstr["no_rsel"])
	Ctrl = document.getElementById("cookie_div")
	Ctrl.style.display = "none"

}


function showCookie(cname) {
	cookie = getCookie(cname)
	if (cookie == "") {
		alert(msgstr["rsel_no"])
		return
	}
	//document.buscar.action = "views/view_selection.php"
	document.buscar.action = "index.php"
	document.buscar.cookie.value = cookie

	document.buscar.submit()
}


/*
		function delCookie() {
			document.cookie = 'ABCD=;';

		}
		
		var user = getCookie("ABCD");
		if (user != "") {
			alert("Welcome again " + user);
		} else {

		}
		*/