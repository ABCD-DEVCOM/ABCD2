/**
* Script validation form
*
* @author:			Ana Katia Camilo <katia.camilo@bireme.org>
* @author:			Bruno Neofiti <bruno.neofiti@bireme.org>
* @author:			Domingos Teruel <domingos.teruel@bireme.org>
* @since	        2008-09-09
* @copyright:      (c) 2008 BIREME/PAHO/WHO - PFI
*
* The contents of this file are subject to the Mozilla Public License
* Version 1.1 (the "License"); you may not use this file except in
* compliance with the License. You may obtain a copy of the License at
* http://www.mozilla.org/MPL/
*
* Software distributed under the License is distributed on an "AS IS"
* basis, WITHOUT WARRANTY OF ANY KIND, either express or implied. See the
* License for the specific language governing rights and limitations
* under the License. 
******************************************************************************/

/*
 * Se os campos Library e Role de Manage Users estiverem preenchidos e o botao
 * de insert nao estiver sido pressionado, faz essa funcao
 * @param
 * @return
 */
function fillRepTitPlus(){

    var locationRoom = document.getElementById("locationRoom");
    var estMap = document.getElementById("estMap");
    var ownClassif = document.getElementById("ownClassif");
    var ownDesc = document.getElementById("ownDesc");

    if(locationRoom.value != ""){
        InsertLineOriginal('locationRoom', 'superTextEntry2', '{$smarty.session.lang}');
    }
    if(estMap.value != ""){
        InsertLineOriginal('estMap', 'superTextEntry2', '{$smarty.session.lang}');
    }
    if(ownClassif.value != ""){
        InsertLineOriginal('ownClassif', 'superTextEntry2', '{$smarty.session.lang}');
    }
    if(ownDesc.value != ""){
        InsertLineOriginal('ownDesc', 'superTextEntry2', '{$smarty.session.lang}');
    }
}


/*
 * Se os campos Library e Role de Manage Users estiverem preenchidos e o botao
 * de insert nao estiver sido pressionado, faz essa funcao
 * @param
 * @return
 */
function fillRoleLib(lang){
    
    var role = document.getElementById("role");
    var library = document.getElementById("library");

    if(role.value != "" && library.value != ""){
        InsertLineSelect('role', 'library', lang);
    }
    
}

/*
 * Verifica se existem campos Library e Role preenchidos em Manage Users
 * @param lang language
 * @return true se tiver campos preenchidos senao false
 */
function validateRoleLib(lang){

var form = document.getElementById("formData");
var filled = false;

    for (var i=0; i<form.length; i++)
    {
        if(form.elements[i].id.substr(0,4) == "role" || form.elements[i].id.substr(0,7) == "library"){
            if(form.elements[i].name == "field[library][]" || form.elements[i].name == "field[role][]"){
                //existem campo preenchidos com Role e Library
                filled = true;
            }
        }
    }

    if(filled == false){

        var role = document.getElementById("role");
        var library = document.getElementById("library");
        var msg1 = errorMsgs(lang, '0');
        var msg2 = errorMsgs(lang, '1');

        if(role.value == ""){
            alert(msg1 + role.id + msg2);
        }
        if(library.value == ""){
            alert(msg1 + library.id + msg2);
        }
    }
    return filled;

}

/*
 * Funcao utilizada para exibir mensagens em PT e EN(default)
 * @param lang language
 * @param2 returnMsg a mensagem que voce deseja visualizar
 * @return mensagem
 */
function labelsJS(lang, returnMsg){
  	switch (lang) {
		case "pt":
                    var msg = new Array("Excluir",
                                        "Informações para o Portal",
                                        "Agregador/Fornecedor",
                                        "Tipo de Acesso",
                                        "Controle de Acesso",
                                        "Periodo",
                                        "de",
                                        "Anos complementares ou unicos",
                                        "ate",
                                        "Salvar"
                                        );
			break;
		case "en":
                    var msg = new Array("Delete",
                                        "Portal Informations",
                                        "Aggregator/Supplier",
                                        "Access Type",
                                        "Access Control",
                                        "Period",
                                        "from",
                                        "Complementary or unique years",
                                        "until",
                                        "Save"
                                        );
		case "es":
                    var msg = new Array("Suprimir",
                                        "Información para el Portal",
                                        "Agregador/Proveedor",
                                        "Tipo de Acceso",
                                        "Controle de Acceso",
                                        "Período",
                                        "de",
                                        "Años complementarios o unicos",
                                        "hasta",
                                        "Guardar"
                                        );
			break;
		case "fr":
                    var msg = new Array("Supprimer",
                                        "Portail Informations",
                                        "Agrégateur/Fournisseur",
                                        "Type d'accès",
                                        "Contrôle d'accès",
                                        "Période",
                                        "à partir de",
                                        "Complémentaires ou uniques année",
                                        "jusqu'à ce que",
                                        "Sauver"
                                        );
		default:
                    var msg = new Array("Delete",
                                        "Portal Informations",
                                        "Aggregator/Supplier",
                                        "Access Type",
                                        "Access Control",
                                        "Period",
                                        "from",
                                        "Complementary or unique years",
                                        "until",
                                        "Save"
                                        );
	}
    return msg[returnMsg];
}

/*
 * Funcao utilizada para exibir mensagens em PT e EN
 * @param lang language
 * @param2 returnMsg a mensagem que voce deseja visualizar
 * @return mensagem
 */
function errorMsgs(lang, returnMsg){
    
  	switch (lang) {
		case "pt":
                    var msg = new Array("O campo ",
                                " é de preenchimento obrigatório!",
                                "Erro no campo ",
                                "Idioma do sistema alterado",
                                "Campos Vazio !",
                                "Selecione um arquivo para ser importado",
                                "Em construção"
                            );
			break;
		case "en":
                    var msg = new Array("The field ",
                                " is mandatory!",
                                "Error in field ",
                                "System language changed",
                                "Empty Field!",
                                "Select a file to be import",
                                "Under construction"
                            );
			break;
		case "es":
                    var msg = new Array("El campo ",
                                " es obligatorio llenas!",
                                "Error en el campo ",
                                "Idioma del sistema alterado",
                                "Campos Vacios !",
                                "Seleccione un archivo para ser importado",
                                "En construcción"
                            );
			break;
		case "fr":
                    var msg = new Array("Le champ ",
                                " est obligatoire!",
                                "Erreur dans le champ ",
                                "Système de la langue a changé",
                                "Les champs vides!",
                                "Sélectionnez un fichier à importer",
                                "En construction"
                            );
			break;
		default:
                    var msg = new Array("The field ",
                                " is mandatory!",
                                "Error in field ",
                                "System language changed",
                                "Empty Field!",
                                "Select a file to be import",
                                "Under construction"
                            );
			break;
	}
        
    return msg[returnMsg];
}

/*
 * FACIC Form, automatic fill of quantity 
 */
function selectNumOfCopys(idCampo){
	var	fieldValue = document.getElementById(idCampo).value; 
	if(fieldValue == "P"){
		document.getElementById('quantity').value = "1";
	}
	if(fieldValue == "A"){
		document.getElementById('quantity').value = "0";
	}

}

function repetitivo(idCampo){ 
	
	var	tamanho = document.getElementById(idCampo).value; 
	if(tamanho!=''){ 
		InsertLineOriginal(idCampo, 'singleTextEntry'); 
	}
}



/**
* Funcao que valida os campos obrigatorios num formulario.
* Para que um campos seja obrigatorio, o valor do seu atributo
* 'title' deve comecar com um asterisco (*)
*
* @return boolean
*/
function validaForm(frm, lang){
	
    var valid = true;
    var msg1 = errorMsgs(lang, '0');
    var msg2 = errorMsgs(lang, '1');
    var msg3 = errorMsgs(lang, '2');

	for (var i = 0; i < frm.elements.length; i++){        
		if ( (frm.elements[i].title.substr(0,1)) == "*" ){		    
		    if(frm.elements[i].type == 'select-one') {
		        ElObj = document.getElementById(frm.elements[i].id);		        
		        objValue = ElObj.options[ElObj.selectedIndex].value;
		    }else {
		        objValue = frm.elements[i].value; 
		    }		    
			if (objValue == "" || objValue == "#"){
				msgErro = msg1 + frm.elements[i].title.substr(1,(frm.elements[i].title.length))+ msg2;
				errorObj = document.getElementById(frm.elements[i].id + "Error");
				if (errorObj != null) {
					errorObj.innerHTML = msgErro;
					errorObj.style.display = 'block';

					if(frm.elements[i].id != "tempnews") {
					frm.elements[i].style.backgroundColor = "#ffffcc";
					//frm.elements[i].focus();
					}
				}
				valid = false;
                                alert(msg3 + frm.elements[i].title.substr(1,(frm.elements[i].title.length)));
                                return valid;

			}else{
				frm.elements[i].style.backgroundColor = "#efefef";
			}
		}
	}
	return valid;
}

/*
 * Function deprecated, now validation is on server side
 */
function checarCampos(lang) 
{

	var status = document.getElementById("publicationStatus");
	var dtFinal = document.getElementById("finalDate");
	var pais = document.getElementById("country");
	var estado = document.getElementById("state");

	switch (lang) {
		case "pt":
			var msg1 = 'Se o campo Situacao da publicacao for Encerrado/Suspenso o campo ';
			var msg2 = ' deve ser preenchido';  
			var msg3 = 'Se o pais for Brasil o campo ';
			break;
		case "en":
			var msg1 = 'If the field Publication Situation is Locked up/Suspended the field '; 
			var msg2 = ' should be filled'; 
			var msg3 = 'If the country is Brazil the field '; 
			break;
		default:
			var msg1 = 'If the field Publication Situation is Locked up/Suspended the field '; 
			var msg2 = ' should be filled'; 
			var msg3 = 'If the country is Brazil the field '; 
	}

	if (status.value=="D" && dtFinal.value==""){
		alert(msg1 + dtFinal.title + msg2);
		dtFinal.style.backgroundColor = "#ffffcc";
		return false;
	}else{
		if(pais.value == "BR" && estado.value == ""){
			
			alert(msg3 + estado.title + msg2);
			estado.style.backgroundColor = "#ffffcc";
			return false;
		}else{
			return true;
		}
	}
}

/**
 * Check if has an empty space in the content
 * @return bool true/false
 */
function checkLibCode(){

    var code = document.getElementById("code");
    if(code.value.match(" ")){
        var errorField = document.getElementById("spaceNotAllowedError");
		errorField.style.display = "block";
        code.style.backgroundColor = "#ffffcc";
		code.select();
		code.focus();
        return false;
    }else{
        return true;
    }
}

/**
* checa se os dois campos de password estao preenchidos iguais
* senao retorna falso
* @param
* @return true se os valores forem iguaus, senao false.
*/
function checarPwd(){
	var senha = document.getElementById("passwd");
	var csenha = document.getElementById("cpasswd");
	if (senha.value != csenha.value) {
		document.getElementById("difPasswdError").style.display = "block";
        senha.style.backgroundColor = "#ffffcc";
		senha.select();
		senha.focus();
		return false;
	}else{
		return true;
	}
}


/**
* only permits numbers
* @param src should be a HTML element.
*/
function validateNumeric(src) {
	src.value=src.value.replace(/\D/g,"");
}


/**
* @param field should be an HTML text form element.
* @return true if field is not empty, else false.
*/
function validateRequired(field) {
	trimField(field);	
	return (field.value != "");
}

/**
* Trim a field of leading or trailing whitespace
*
* @param field should be an HTML text form element.
*/
function trimField(field) {
	field.value = trim(field.value);
}

/**
* Trim a string of leading or trailing whitespace
*
* @param str is the string to trim.
* @return trimmed string.
*/
function trim(str) {
	return str.replace(/^\s+|\s+$/, "");
}

/**
* Shows a validation error for a given field, e.g.,
* onblur="showValidationError(this, validateRequired(this));"
* It assumes a span or div with id = element.id + "Error"
*
* @param element is the form item you are validating.
* @param focusItem
* @param valid is the current valid state - should use validate function.
* @return value of valid
*/
function showValidationError(element, valid, focusItem) {
	var errorObj = document.getElementById(element.id + "Error");
	if (errorObj) {
		errorObj.style.display = valid ? "none" : "block";
	}
	if (focusItem && element) {
		element.focus();
	}
	return valid;
}

/**
* Verifies that the value of a text area is a valid URL. Empty = true.
* This funciton also adds an http:// to the beginning if it doesn't exists.
*
* @param field is the HTML text area or text input to validate.
* @return false if field is empty or doesn't match the url regex.
*/
function validateUrl(field) {
    var v = field.value;
    v=v.replace(/^http:\/\/?/,"")
    dominio=v
    caminho=""
    if(v.indexOf("/")>-1)
        dominio=v.split("/")[0]
    caminho=v.replace(/[^\/]*/,"")
    dominio=dominio.replace(/[^\w\.\+-:@]/g,"")
    caminho=caminho.replace(/[^\w\d\+-@:\?&=%\(\)\.]/g,"")
    caminho=caminho.replace(/([\?&])=/,"$1")
    if(caminho!="")dominio=dominio.replace(/\.+$/,"")
    v="http://"+dominio+caminho
    field.value = v
}

/**
* Validates a phone number...very generic check...
*
* @param field is the HTML text area or text input to validate.
* @return false if field is empty or doesn't match the phone number regex.
*/
function validatePhone(field) {
    validateNumeric(field);
    var v = field.value;
    v=v.replace(/^(\d\d)(\d\d)(\d)/g,"($1 $2) $3");
    field.value = v;
}

/**
* This funciton should be used in validateForm when you have multiple items to
* check.
*
* @param element is the item that is being tested.
* @param elementIsValid test is whether or not the single item is valid.
* @return returns formIsValid if elementISValid == true, else returns false.
*/
function testElement(element, elementIsValid) {
	if (elementIsValid) {
		return true;
	} else {
		return showValidationError(element, false, true);
	}
}
/**
* Esta funcao adiciona um novo elemento ao objeto SELECT
* @param obj elemento origem
* @param dest elemento destino
*/
function addOption(obj,dest)
{
	org = window.parent.document.getElementById(obj);
	selectbox = window.parent.document.getElementById(dest);
	oldLength = selectbox.length;
	selectbox.options[oldLength++] = new Option(org.value);
	for(i=0; i<selectbox.length; i++)
	{
		selectbox.options[i].selected = true;
	}
	org.value = "";
	org.focus();

}
/**
* Esta fun��o serve para selecionar todos os  itens de um selct multiple
* @param obj
*/
function selectAll(obj)
{
	for(i=0; i<obj.length; i++)
	{
		obj.options[i].selected = true;
	}
}

function validateISSN(src){
    validateNumeric(src);
    src.value=src.value.replace(/^(\d{4})(\d)/,"$1-$2");
}