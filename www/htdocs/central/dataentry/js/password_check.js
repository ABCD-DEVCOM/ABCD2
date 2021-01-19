var ver_password=new Array("","","")
score=-1
function pwd_Validation(tag) {
	if (secure_password_level=="" && secure_password_length=="") return
    var strengths = ["Blank or too short", "Very Weak", "Weak", "Medium", "Strong", "Very Strong"];
    var colors = ["#FF0000", "#FF0000", "#FFCC00", "#FFCC00", "#19D119", "#006600"];
    score = -1;
    var regLower = /[a-z]/, regUpper = /[A-Z]/, regNumber = /\d/, regPunctuation = /[.,!@#$%^&*?_~\-£()]/;
//secure_password_level=0  Verifica solo si está presente
//secure_password_level=1  Solo debe tener el largo especificado
//secure_password_level=2  solo requiere letras
//secure_password_level=3  solo requiere letras y números
//secure_password_level=4  solo requiere letras, números y a menos un letra mayúscula
//secure_password_level=5  Requiere letras, números, al menos una letra mayúscula y un caracter especial
    var password = document.getElementById(tag).value;
    pwd=document.getElementById(tag)
    if (Trim(password)=="") {
        score = 0;
    } else {
         if (password.length < secure_password_length && secure_password_length!="") {
			// no cumple la longitud
        	score = 0;
    	} else {
    		if (secure_password_level>0) {
        		if (regLower.test(password) && regUpper.test(password) && regNumber.test(password) && regPunctuation.test(password)) {
					// tiene minúsculas, mayúsculas, números y caracteres especiales
					score=5
				}else{
					if (regLower.test(password) && regUpper.test(password) && regNumber.test(password) ) {
                    	// no tiene caracteres especiales
						score=4
					}else{
						if (regLower.test(password) && regUpper.test(password)) {
							//no tiene números
                    		score = 3;
            			} else {
							if (regLower.test(password) ) {
                				score = 2;
                			}else{                				score = 1                			}
                		}
            		}
        		}
        	}
    	}
	}
	var spanPwd = document.getElementById('spnPwd');
	if (score!=-1){
		spanPwd.innerHTML = strengths[score];
		spanPwd.style.color = colors[score];
	}else{		spanPwd.innerHTML =""	}
}

//Esta función se activa antes del submit de la forma para ver si la clave cumple con los requisitos establecidos
function VerificarPassword(tag){
	if (score==-1) return true
	if (secure_password_length>0){
		pwd_Validation(tag)
		if (score<secure_password_level && secure_password_level!=""){			pwd=document.getElementById(tag)
			if (mandatory_password==1 && Trim(pwd.value)!="") pwd.focus()
			return false		}else{			return true		}
	}
}

//Esta función permite desplegar/esconder la palabra clave que se está ingrsando
function DisplayPassword(tag){
	switch (tag){
		case "actualpwd":
			ixPwd=0;
			break;
		case "pwd":
			ixPwd=1;
			break;
		case "confirmpwd":
			ixPwd=2;
			break;
		default:
			ixPwd=1;
			break;
	}
	if (ver_password[ixPwd]==""){
		document.getElementById(tag).type='text'
		ver_password[ixPwd]="Y"
	}else{
		document.getElementById(tag).type='password'
		ver_password[ixPwd]=""
	}
}