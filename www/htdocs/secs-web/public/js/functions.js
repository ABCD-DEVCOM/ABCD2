/**
 * @file:	function.js
 * @desc:	Main JavaScript file
 * @author:	Ana Katia Camilo <katia.camilo@bireme.org>
 * @author:	Bruno Neofiti <bruno.neofiti@bireme.org>
 * @author:	Domingos Teruel <domingos.teruel@bireme.org>
 * @since       2008-09-09
 * @copyright:  (c) 2008 BIREME/PAHO/WHO - PFI
 *
******************************************************************************/

/*
 * Hide all Menu Export, that are open
 */
function hideFullExportMenu(){

document.getElementById('menuExport').style.display = "none";
document.getElementById('formatMenuAllRegisters').style.display = "none";
document.getElementById('formatMenuOneRegister').style.display = "none";
document.getElementById('collectionMenuSeCSFormat').style.display = "none";
document.getElementById('collectionMenuMarcFormat').style.display = "none";
document.getElementById('catalogExport').style.display = "none";
//document.getElementById('nextStepExport').style.display = "none";
document.getElementById('exportID').style.display = "none";
document.getElementById('fileNameID').value = "";
//document.getElementById('fileName2').value = "";
document.getElementById('fileName').value = "";
hideExportDialog();

}

/*
 * Show an export menu
 */
function fullExportMenu(itemMenu, numberRegisters){
    
    switch(itemMenu) {
        case 'menuRegisters':
            hideFullExportMenu();
            document.getElementById('menuExport').style.display = "block";
            break;
        case 'allRegisters':
            hideFullExportMenu();
            document.getElementById('menuExport').style.display = "block";
            document.getElementById('formatMenuAllRegisters').style.display = "block";
            break;
        case 'oneRegister':
            hideFullExportMenu();
            document.getElementById('menuExport').style.display = "block";
            document.getElementById('exportID').style.display = "block";
            break;
        case 'secsFormat':
            if(numberRegisters == "oneRegister"){
                var registerID = document.getElementById('fileNameID').value;
                if(registerID != ""){
                    document.getElementById('collectionMenuSeCSFormat').style.display = "block";
                    document.getElementById('collectionMenuSeCSFormat').style.top = "262px";
                    document.getElementById('collectionMenuSeCSFormat').style.right = "100px";
                    var registerID = document.getElementById('fileNameID').value;
                    document.getElementById('btCollectionMenuSeCSFormatTitleOnly').href = "javascript: hideFullExportMenu();exportDialog('titWithoutCollection', 'oneRegister', 'secsFormat', '"+registerID+"');";
                    document.getElementById('btCollectionMenuSeCSFormatCollectionTitleCollection').href = "javascript: hideFullExportMenu();exportDialog('titWithCollection', 'oneRegister', 'secsFormat', '"+registerID+"');";
                }else{
                    alert("ID is empty");
                }
            }else{
                document.getElementById('collectionMenuSeCSFormat').style.display = "block";
                document.getElementById('collectionMenuSeCSFormat').style.top = "190px";
                document.getElementById('collectionMenuSeCSFormat').style.right = "0px";
                document.getElementById('btCollectionMenuSeCSFormatTitleOnly').href = "javascript: hideFullExportMenu();exportDialog('titWithoutCollection', 'allRegisters', 'secsFormat');";
                document.getElementById('btCollectionMenuSeCSFormatCollectionTitleCollection').href = "javascript: hideFullExportMenu();exportDialog('titWithCollection', 'allRegisters', 'secsFormat');";
            }
            break;
        case 'marcFormat':
            if(numberRegisters == "oneRegister"){
                var registerID = document.getElementById('fileNameID').value;
                if(registerID != ""){
                    document.getElementById('collectionMenuMarcFormat').style.display = "block";
                    document.getElementById('collectionMenuMarcFormat').style.top = "290px";
                    document.getElementById('btCollectionMenuMarcFormatTitleOnly').href = "javascript: hideFullExportMenu();exportDialog('titWithoutCollection', 'oneRegister', 'marcFormat');";
                }else{
                    alert("ID is empty");
                }
            }else{
                document.getElementById('collectionMenuMarcFormat').style.display = "block";
                document.getElementById('collectionMenuMarcFormat').style.top = "210px";
                document.getElementById('btCollectionMenuMarcFormatTitleOnly').href = "javascript: hideFullExportMenu();exportDialog('titWithoutCollection', 'allRegisters', 'marcFormat');";
            }
            break;
        case 'menuCatalog':
            hideFullExportMenu();
            document.getElementById('catalogExport').style.display = "block";
            break;
    }

}

function showMenuExport(){
    YAHOO.example.container.exportDialogResizable.hide();

}

function showExportDialog(){
    YAHOO.example.container.exportDialogResizableStep2.show();
}

function hideExportDialog(){
    YAHOO.example.container.exportDialogResizable.hide();
    YAHOO.example.container.exportDialogResizableStep2.hide();
}


/*
 * @desc Funcao que pega o valor do input text ou select, depende de qual deles esta
 * ativo. E coloca em searchExpr que e o valor usado na busca, somente ele esta
 * no form.
 * @param field
 */
function changeVal(field){
    
    var freeText = document.getElementById(field);
    var acquisitionMethod = document.getElementById("AcquisitionMethod");
    var acquisitionControl = document.getElementById("AcquisitionControl");
    var acquisitionPriority = document.getElementById("AcquisitionPriority");
    var frm = document.getElementById("searchTitlePlusForm");

    if(freeText.style.display == "block" || freeText.style.display == ""){
        frm.elements[1].value  = freeText.value;
    }

    if(acquisitionMethod.style.display == "block" || acquisitionMethod.style.display == ""){
        frm.elements[1].value  = acquisitionMethod.value;
    }

    if(acquisitionControl.style.display == "block" || acquisitionControl.style.display == ""){
        frm.elements[1].value  = acquisitionControl.value;
    }

    if(acquisitionPriority.style.display == "block" || acquisitionPriority.style.display == ""){
        frm.elements[1].value  = acquisitionPriority.value;
    }
}

/*
 * Funcao que troca o input text da Title Plus na Homepage e TitlePlus List.
 * Ao selecionar Acquisition Method ou Acquisition Control o input text
 * e mudado para um select
 * Caso seja selecionada outra opcao, volta o input text
 * Obs: Eles nao fazem parte do form
 * @param whoAccess. Parametro usado para diferenciar se quem esta usando a funcao
 * e a homepage.tpl.php ou search.tpl.php
 */
function checkSelection(whoAccess){
    var frm = document.getElementById("searchTitlePlusForm");
    //pegando do form, pq existe um select com mesmo nome
    var indexesTitPlus = frm.elements[2]; 
    var searchExpr = document.getElementById("searchExpr");
    var acquisitionMethod = document.getElementById("AcquisitionMethod");
    var acquisitionControl = document.getElementById("AcquisitionControl");
    var acquisitionPriority = document.getElementById("AcquisitionPriority");
    var freeText = document.getElementById("freeText");
    
    if(whoAccess == "2"){
        switch (indexesTitPlus.selectedIndex) {
            case 2:
                searchExpr.style.display = "none";
                acquisitionMethod.style.display = "";
                acquisitionControl.style.display = "none";
                acquisitionPriority.style.display = "none";
                break;
            case 3:
                searchExpr.style.display = "none";
                acquisitionMethod.style.display = "none";
                acquisitionControl.style.display = "";
                acquisitionPriority.style.display = "none";
                break;
            default:
                searchExpr.style.display = "";
                acquisitionMethod.style.display = "none";
                acquisitionControl.style.display = "none";
                acquisitionPriority.style.display = "none";
                break;
        }
    }else{
        switch (indexesTitPlus.selectedIndex) {
            case 3:
                freeText.style.display = "none";
                acquisitionMethod.style.display = "block";
                acquisitionControl.style.display = "none";
                acquisitionPriority.style.display = "none";
                break;
            case 4:
                freeText.style.display = "none";
                acquisitionMethod.style.display = "none";
                acquisitionControl.style.display = "block";
                acquisitionPriority.style.display = "none";
                break;
            default:
                freeText.style.display = "block";
                acquisitionMethod.style.display = "none";
                acquisitionControl.style.display = "none";
                acquisitionPriority.style.display = "none";
                break;
        }
    }

}

function showISBD(lang){
    var pathTohelpISBD = 'lang/'+lang+'/helpISBD.html';
    window.open(pathTohelpISBD);

}

function showHelp(msgHelpFieldNumber, msgHelpTitle, msgHelpBody){
    
    var handleSuccess = function(o) {
        document.getElementById('helpTitle').innerHTML = labelHelp+" ["+msgHelpFieldNumber +"] " + msgHelpTitle;
        document.getElementById('helpBody').innerHTML = msgHelpBody;
    }
    var handleFailure = function(o) {
        document.getElementById('helpBody').innerHTML = YAHOO.widget.DataTable.MSG_ERROR;
    }
    var callback = {
            success: handleSuccess,
            failure: handleFailure
    };
    document.getElementById('helpBody').innerHTML = YAHOO.widget.DataTable.MSG_LOADING;
    YAHOO.util.Connect.asyncRequest('GET', '#', callback, "");
    YAHOO.example.container.helpDialog.show();

}



/* Change Libray and Role of and user, if he has the permission
 * @param lang: system language
 * @param returnMsg: success message,
 * @param userID
 */
function changeLanguage(lang, returnMsg, userID){

    var handleSuccess = function(o) {
        var msg = errorMsgs(lang, returnMsg);
        document.getElementById('collectionDisplayed').innerHTML = msg;
    }
    var handleFailure = function(o) {
        var msg = errorMsgs(lang, returnMsg);
        document.getElementById('collectionDisplayed').innerHTML = msg;
        //YAHOO.example.container.collectionDialog.hide();
    }
    var callback = {
            success: handleSuccess,
            failure: handleFailure
    };
    document.getElementById('collectionDisplayed').innerHTML = YAHOO.widget.DataTable.MSG_LOADING;
    YAHOO.util.Connect.asyncRequest('GET', '?lang='+lang+'&amp;m=users&amp;edit='+userID, callback, "");
    YAHOO.example.container.collectionDialog.show();

}

/* Change Libray and Role of and user, if he has the permission
 * @param lang: system language
 * @param msg: success message
 * @param m: redirect to report section inseted of home(default)
 * @return URL
 */
function changeLib(lang, msg, m){
    var library = document.getElementById('library').selectedIndex;
    if (library != 0){
        var selLibrary = document.getElementById('library').options[library].value;
        var libName = document.getElementById('library').options[library].text;
        if(document.getElementById('role').value == ""){
            var selRole = document.getElementById('role').options[library].value;
        }else{
            var selRole = document.getElementById('role').value;
        }
    }

    if(m == "report"){ 
        var openUrl = "?library="+selLibrary+"&role="+selRole+"&libName="+libName+"&libSel="+library+"&lang="+lang+"&m="+m;
    }else{
        var openUrl = "?library="+selLibrary+"&role="+selRole+"&libName="+libName+"&libSel="+library+"&lang="+lang;
    }
    window.location = openUrl;
    alert(msg);
}

/*
 * Funcao usada em users.form para adicionar campos repetitiveis
 * @param ofId: role
 * @param ofId2: library
 * @param lang: language
 * @return adiciona ao formulario mais um campo com role e library preenchidos
 */
function InsertLineSelect(ofId, ofId2, lang) {

    var frDataFields = 'frDataFields'+ofId;
    var frDataFieldsLib = 'frDataFieldsLibrary';
    var obj = document.getElementById(frDataFields);
    var objLib = document.getElementById(frDataFieldsLib);
    var inputValue01 = document.getElementById(ofId).value;
    var inputValue02 = document.getElementById(ofId2).options[document.getElementById(ofId2).selectedIndex].text;
    var inputValue03 = document.getElementById(ofId2).options[document.getElementById(ofId2).selectedIndex].value;
    var isEmptyVal02 = document.getElementById(ofId2).value;
    var btDeleteRecord = labelsJS(lang, "0");

    if (inputValue01 != "" && isEmptyVal02 != ""){
        if(obj) {
            insertString = '';
            insertString += '<div class="frDataFields">';
            insertString += '<div class="frDFRow">';
            insertString += '   <div id="roleLib">';
            insertString += '		<div class="frDFColumn" id="frDataFields'+lineCounter+'">';
            insertString += '			<input type="text" id="'+ofId+lineCounter+'" name="field['+ofId+'][]" value="'+inputValue01+'" readonly="readonly"  class="textEntry" />';
            insertString += '       </div>';
            insertString += '		<div class="frDFColumn" id="frDataFields'+lineCounter+'a">';
            insertString += '			<input type="text" id="'+ofId2+lineCounter+'" name="field['+ofId2+'][]" value="'+inputValue02+'"  readonly="readonly" class="textEntry" />';
            insertString += '           <input type="hidden" id="'+ofId2+"Dir"+lineCounter+'" name="field['+ofId2+"Dir"+'][]" value="'+inputValue03+'" />';
            insertString += '			<a href="javascript:;" class="singleButton eraseButton" onclick="removeRow(\'frDataFields'+lineCounter+'\'); removeRow(\'frDataFields'+lineCounter+'a\');">';
            insertString += '				<span class="sb_lb">&#160;</span>';
            insertString += '				<img src="public/images/common/spacer.gif" alt="" title="" />';
            insertString += btDeleteRecord;
            insertString += '				<span class="sb_rb">&#160;</span>';
            insertString += '			</a>';
            insertString += '       </div>';
            insertString += '   </div>';
            insertString += '</div>';
            insertString += '</div>';
            insertString += '       <div class="spacer">&#160;</div>';
            obj.innerHTML += insertString;
            
            if(obj.style.display == 'none') {
                    obj.style.display = "block";
            }
            
            document.getElementById(ofId2).value = "";
            document.getElementById(ofId2).focus();
            lineCounter++;
        }
    }else{
        var result = errorMsgs(lang, "4")
        alert (result);
    }
}

/*function selectViewTitle(id,view){

    document.getElementById("selectViewTitle").style.display = "block";
}*/

/*
 * @param id integer
 * @param view string 
 */
function selectView(id,view){

 
    document.getElementById("viewHead"+id).style.display = "block";
    
    switch(view)
    {
        case "selView":
            document.getElementById("selView" + id).style.display = "block";
            document.getElementById("btView"+id).href = "javascript: selectView("+id+", 'noSelView'); ";
            //document.getElementById("btAdd"+id).src = "public/images/common/icon/singleButton_erase.png";
            break;
        case "noSelView":
            document.getElementById("btAdd"+id).src = "public/images/common/icon/singleButton_info.png";
            document.getElementById("btView"+id).href = "javascript: selectView("+id+", 'selView'); ";
            document.getElementById("selView" + id).style.display = "none";
            //document.getElementById("btExport"+id).href = "javascript: selectView("+id+", 'selView'); ";
            //document.getElementById("selExport" + id).style.display = "none"; //por enquanto sem uso
            break;
/*       case "off":
           document.getElementById("selView" + id).style.display = "none";
           //document.getElementById("selExport" + id).style.display = "none";
           break;
        case "selExport":
           //document.getElementById("selExport" + id).style.display = "block";
           document.getElementById("btExport"+id).href = "javascript: selectView("+id+", 'noSelExport'); ";
           break;
        case "noSelExport":
           //document.getElementById("btExport"+id).href = "javascript: selectView("+id+", 'selExport'); ";
           //document.getElementById("selExport" + id).style.display = "none";
*/
    }

}


/*
 * Funcao usada para deixar visivel ou invisivel o campo perfil do formulario users
 * @param nome do campo que sera analisado (no caso role)
 * @return muda o estado do campo 9, para display none ou block
 */
function abreNovoCampo(campo){
	var role = document.getElementById("role");
	var formRow09 = document.getElementById("formRow09");
        var formRow12 = document.getElementById("formRow12");
	var centerCod = document.getElementById("centerCod");
	
	if(campo=="role" && role.value=="Administrador"){
		formRow09.style.display="none";
		centerCod.title = centerCod.title.substr("1");
        formRow12.style.display="block";
	}else{
		formRow09.style.display="block";
        formRow12.style.display="none";
	}
}

/*
 * Make validation of the fields.
 * If is ok submit the form
 * If not show warning messages
 * @param page the form name
 * @param lang string
 */
function submitFormNew(page, lang)
{
    document.getElementById("gravar").value="true";
    document.getElementById("formData").submit();
}

/*
 * Make validation of the fields.
 * If is ok submit the form
 * If not show warning messages
 * @param page the form name
 * @param lang string
 */
function submitForm(page, lang)
{
	
	
    if(page=="preferences"){
        page = "users";
    }

    if(page=="users" && validateFormUsers('formData',lang)==true)
    {
        
        var myRole = document.getElementById("myRole").value
        if(myRole == "Administrator" ){
            fillRoleLib(lang);
            var roleLib = validateRoleLib(lang);
        }else{
            var roleLib = true;
        }
        
        if(roleLib == true){
            var senha = document.getElementById("passwd").value;
            var csenha = document.getElementById("cpasswd").value;
            document.getElementById("passwd").value = hex_md5(senha);
            document.getElementById("cpasswd").value = hex_md5(csenha);
            document.getElementById("gravar").value = "true";
            document.formData.submit();
        }

    }

    if(page=="title" && validateFormTitle('formData',lang)==true)
    {
        document.getElementById("gravar").value="true";
        document.formData.submit();
    }

    if(page=="mask" && validateFormMask('formData')==true)
    {
        document.getElementById("gravar").value = "true";
        document.formData.submit();
    }

    if(page=="facic")
    {
        document.getElementById("gravar").value = "true";
        document.formData.submit();
    }

    if(page=="titleplus" && validateFormMask('formData')==true)
    {
        fillRepTitPlus();
        document.getElementById("record").value = "true";
        document.formData.submit();
    }

    if(page=="library" && validateFormLibrary('formData')==true)
    {
        document.getElementById("gravar").value = "true";
        document.formData.submit();
    }
    
    if (page=="import"){

        var importFile = document.getElementById('importFile');
        if(importFile.value != ""){
            doit("importFormIssues");
            var openURL = "index.php?m=maintenance"
            window.location = openURL;
        }else{
            var msg = errorMsgs(lang, "5");
            alert(msg);
        }


    }

}

/*
 * @param frmName deve ser o nome do formulario
 * @return true se formulario for valido, senao retorna false.
 */
function validateFormLibrary(frmName)
{
	var success = true;
	var frm = document.forms[frmName];
        success = success && checkLibCode();
	success = success && validaForm(frm);

	return success;
}

/*
 * @param frmName deve ser o nome do formulario
 * @return true se formulario for valido, senao retorna false.
 */
function validateFormMask(frmName) 
{
	var success = true;
	var frm = document.forms[frmName];
	success = success && validaForm(frm);
	
	return success;
}

/*
 * @param frmName deve ser o nome do formulario
 * @return true se formulario for valido, senao retorna false.
 */
function validateFormUsers(frmName, lang) 
{
        var success = true;
	var frm = document.forms[frmName];
	/*
	 *	Compara success com o que retornar de checarPwd	 	
	 *  se for true, success continua como true
	 *  se for false, success igual a false
	 */
	success = success && checarPwd(lang);
        success = success && validaForm(frm, lang);
	
	return success;
}

/*
 * @param frmName deve ser o nome do formulario
 * @param lang string
 * @return true se formulario for valido, senao retorna false.
 */
function validateFormTitle(frmName, lang) 
{
	var success = true;
	var frm = document.forms[frmName];
	success = success && checarCampos(lang);
        success = success && validaForm(frm, lang);
	
	return success;
}

function basedMask()
{
	var indice = document.formData.basedMask.selectedIndex;
	var valor = document.formData.basedMask.options[indice].value ;
	var myWindow = window.open('?m=mask&edit='+valor+'&basedMask=true','_self');
}

// codigo para campos repetitivos
var lineCounter = 1;
function InsertLineOriginal(ofId, oTclass, lang) {

var frDataFields = 'frDataFields'+ofId;
var obj = document.getElementById(frDataFields);
var inputValue01 = document.getElementById(ofId).value;
var inpId = document.getElementById(ofId).name;
var btDeleteRecord = labelsJS(lang, "0");

    if (inputValue01 != ""){
	       	if(obj) {
			insertString = '';
			insertString += '<div class="frDataFields" id="frDataFields'+lineCounter+'">';
			insertString += '	<input type="text" id="'+inpId+lineCounter+'" name="field['+ofId+'][]" value="'+inputValue01+'" class="textEntry '+oTclass+'" />';
			insertString += '	<a href="javascript:;" class="singleButton eraseButton" onclick="removeRow(\'frDataFields'+lineCounter+'\')">';
			insertString += '		<span class="sb_lb">&#160;</span>';
			insertString += '		<img src="public/images/common/spacer.gif" alt="" title="" />';
			insertString += btDeleteRecord ;
			insertString += '		<span class="sb_rb">&#160;</span>';
			insertString += '	</a>';
			insertString += '			<div class="spacer">&#160;</div>';		    
			insertString += '</div>';
			obj.innerHTML += insertString;
			if(obj.style.display == 'none') {
				obj.style.display = "block";
			}
			document.getElementById(ofId).value = "";
			document.getElementById(ofId).focus();
			lineCounter++;
		}
                
    }else{
        var result = errorMsgs(lang, "4")
        alert (result + inputValue01);
    }
}


function submete3(client_textarea_1,subfield)
{
	if (subfield.length < 2) {
	  if (client_textarea_1.value != "") {
	  client_textarea_1.value += ", ^" + subfield; 
	  }
	}else{
	oldContent = client_textarea_1.value.split ("\r\n"); 
	}
	//alert(document.index.termsFromIndex.value); //1� nome selecionado
	client_textarea_1.value +=  document.index.termsFromIndex.value; 
	window.close();
}

function WriteSubField(campo1, subcampo1){
	obj = document.getElementById(campo1).value;
	objsub = document.getElementById(subcampo1).value;
	alert ('Teste !!'+obj);
}

function callsubfields(field, returnSubfield){
    var subfield = [];
    switch (field) {
        case "180":
            subfield = new Array("","a");
            break;
        case "436":
            subfield = new Array("^a", "b");
            break;
        default:
            subfield = new Array("","x");
            break;
    }
    return subfield[returnSubfield];
}

var lineCounter = 1;
function InsertLineSubField_1(frm, ofId, oTclass, field, lang) {
   var subfield1 = callsubfields(field, '0');
   var subfield2 = callsubfields(field, '1');
   var frDataFields = 'frDataFields'+ofId;
   var obj = document.getElementById(frDataFields);
   var btDeleteRecord = labelsJS(lang, "0");

    if(obj == 'null') {
        obj = document.getElementById(ofId);
    }
	nameField = document.getElementById(ofId).title;

	if(obj) {
		insertString = '';
		insertString += '		<div id="helpOverlay'+lineCounter+'" class="helpBG" style="display: block;">';
		insertString += '			<div class="subFields">';
		insertString += '				<span class="exit"><a href="#" onclick="removeRow(\'frDataFields'+lineCounter+'\'); showHideDiv(\'helpOverlay'+lineCounter+'\'); return false;" title="Fechar"><img src="public/images/common/icon/defaultButton_cancel.png"></a></span>';
		insertString += '				<h5> '+nameField+'</h5>';
		insertString += '				<div id="subFieldRow04" class="subFieldRow">';
		insertString += '					<label for="nameOfIssuingBody"><strong>'+nameField+'</strong></label>';
		insertString += '					<div class="frDataFields" id="frDataFields'+lineCounter+'">';
		insertString += '						<input type="text" id="'+field+subfield1+'" name="field[campo][]" value="" class="textEntry '+oTclass+'" />';
		insertString += '					</div>';
		insertString += '					<div class="spacer">&#160;</div>';
		insertString += '				</div>';
		insertString += '				<div id="subFieldRow05" class="subFieldRow">';
		insertString += '					<label for="nameOfIssuingBody"><strong>ISSN</strong></label>';
		insertString += '					<div class="frDataFields" id="frDataFields'+lineCounter+'">';
		insertString += '						<input type="text" id="'+field+subfield2+'" name="field[subcampo][]" value="" class="textEntry '+oTclass+'" />';
		insertString += '					</div>';
		insertString += '					<div class="spacer">&#160;</div>';
		insertString += '				</div>';
		insertString += '					<div class="spacer">&#160;</div>';
		insertString += '<a href="javascript:implementsGenericField(\''+field+'\',\''+ofId+'\',\''+lineCounter+'\');InsertLineOriginal(\''+ofId+'\', \'singleTextEntry\', \''+lang+'\');" class="defaultButton saveButton">';
		insertString += '<img src="public/images/common/defaultButton_iconBorder.gif" alt="" title="Salvar">';
		insertString += '<span><strong>Salvar</strong></span></a>';
		insertString += '				</div>';
		insertString += '			</div>';
		insertString += '		</div>';
		obj.innerHTML += insertString;
		if(obj.style.display == 'none') {
			obj.style.display = "block";
		}
		//document.getElementById(ofId).value = "";
		document.getElementById(ofId).focus();
		//alert (frDataFields+lineCounter);
		lineCounter++;
	}
}

/*
 * The function subFieldWizard is replacing the function InsertLineSubField_1
 */
function subFieldWizard(frm, ofId, oTclass, field, lang, labels, validation){

   var subfield1 = callsubfields(field, '0');
   var subfield2 = callsubfields(field, '1');
   var frDataFields = 'frDataFields'+ofId;
   var obj = document.getElementById(frDataFields);
   //var btDeleteRecord = labelsJS(lang, "0");

   if(obj == 'null') {
        obj = document.getElementById(ofId);
   }

    var validISSN = (labels[1] == 'ISSN') ? 'validateISSN(this);' : '';
    
    var handleSuccess = function(o) {
        document.getElementById('helpTitle').innerHTML = labelHelp+" ["+field+"] " + document.getElementById(ofId).title;
            insertString = '';
            insertString += '		<div id="helpOverlay'+lineCounter+'">';
            insertString += '			<div class="formHead">';
            insertString += '				<div class="fieldBlock">';
            insertString += '				<div id="formRow01" class="formRow">';
            insertString += '					<label><strong>'+labels[0]+'</strong></label>';
            insertString += '					<div class="frDataFields" id="frDataFields'+lineCounter+'">';
            insertString += '						<input type="text" id="'+field+subfield1+'" name="field[campo][]" value="" class="textEntry '+oTclass+'" onkeyup="'+validation+'" />';
            insertString += '					</div>';
            insertString += '					<div class="spacer">&#160;</div>';
            insertString += '				</div>';
            insertString += '				<div id="formRow02" class="formRow">';
            insertString += '					<label for="nameOfIssuingBody"><strong>'+labels[1]+'</strong></label>';
            insertString += '					<div class="frDataFields" id="frDataFields'+lineCounter+'">';
            insertString += '						<input type="text" id="'+field+subfield2+'" name="field[subcampo][]" value="" class="textEntry '+oTclass+'" onkeyup="'+validISSN+'" />';
            insertString += '					</div>';
            insertString += '					<div class="spacer">&#160;</div>';
            insertString += '				</div>';
            insertString += '				<div id="formRow03" class="formRow">';
            insertString += '<a href="javascript:implementsGenericField(\''+field+'\',\''+ofId+'\',\''+lineCounter+'\');InsertLineOriginal(\''+ofId+'\', \'singleTextEntry\', \''+lang+'\'); YAHOO.example.container.helpDialog.cancel();" class="defaultButton saveButton">';
            insertString += '<img src="public/images/common/defaultButton_iconBorder.gif" alt="" title="Salvar">';
            insertString += '<span><strong>Salvar</strong></span></a>';
            insertString += '				</div>';
            insertString += '<div class="spacer">&#160;</div>';
            insertString += '			</div></div>';
            insertString += '		</div>';
            lineCounter++;
            document.getElementById('helpBody').innerHTML = insertString;
    }
    var handleFailure = function(o) {
        document.getElementById('helpBody').innerHTML = YAHOO.widget.DataTable.MSG_ERROR;
    }
    var callback = {
            success: handleSuccess,
            failure: handleFailure
    };
    document.getElementById('helpBody').innerHTML = YAHOO.widget.DataTable.MSG_LOADING;
    YAHOO.util.Connect.asyncRequest('GET', '#', callback, "");
    YAHOO.example.container.helpDialog.show();

}

//subfields of v999
var lineCounter = 1;
function InsertLineSubField(frm, ofId, oTclass, subfield, lang, optAgregators,optAcessType, optControlAccess) {
       
	frDataFields = 'frDataFields'+ofId;
	obj = document.getElementById(frDataFields);
	inputValue01 = document.getElementById(ofId).value;
	x = inputValue01.indexOf(subfield,0);
        y = inputValue01.length;

        if (x== -1)
        {
            inputValue02 = inputValue01.substring(0,y);
            inputValue03 = "";
        }else{
            inputValue02 = inputValue01.substring(0,x);
            inputValue03 = inputValue01.substring(x+2,y);
        }

	var inicio = (inputValue01.search(/b/i));
        var lblField999Title = labelsJS(lang, '1');
        var lblField999AggregatorSupplier = labelsJS(lang, '2');
        var lblField999AccessType = labelsJS(lang, '3');
        var lblField999AccessControl = labelsJS(lang, '4');
        var lblField999Period = labelsJS(lang, '5');
        var lblField999From = labelsJS(lang, '6');
        var lblField999ComplementaryYears = labelsJS(lang, '7');
        var lblField999Until = labelsJS(lang, '8');
        var lblField999Save = labelsJS(lang, '9');
      
	if(obj) {        
		insertString = '';
		insertString += '		<div id="helpOverlay'+lineCounter+'" class="helpBG" style="display: block;">';
		insertString += '			<div class="subFields">';
		insertString += '				<span class="exit"><a href="#" onclick="removeRow(\'frDataFields'+lineCounter+'\'); showHideDiv(\'helpOverlay'+lineCounter+'\'); return false;" title="Fechar"><img src="public/images/common/icon/defaultButton_cancel.png"></a></span>';
		insertString += '				<h5>'+lblField999Title+'</h5>';
		insertString += '				<div id="subFieldRow04" class="subFieldRow">';
		insertString += '					<label for="nameOfIssuingBody"><strong>URL</strong></label>';
		insertString += '					<div class="frDataFields" id="frDataFields'+lineCounter+'">';
		insertString += '						<input type="text" id="999b" name="field[campo][]" value="'+inputValue02+'" class="textEntry '+oTclass+'" onkeyup=validateUrl(this); />';
                insertString += '                                               <span id="formRow999b_help">';
              	insertString += '                                                   <a href="javascript:showHelp(\'999^b\',\''+lblField999Title+'\',\''+help999subfieldB+'\');"><img src="public/images/common/icon/helper_bg.png" title="help" alt="help" /></a>';
		insertString += '                                               </span>';
		insertString += '					</div>';
		insertString += '					<div class="spacer">&#160;</div>';
		insertString += '				</div>';
		insertString += '				<div id="subFieldRow05" class="subFieldRow formRowFocus">';
		insertString += '					<label for="field14"><strong>'+lblField999AggregatorSupplier+'</strong></label>';
		insertString += '					<div class="frDataFields">';
		insertString += '						<select name="field14" id="999c" class="textEntry lenAdjust">';
		insertString += '                             <option value""></option>';
		var itens_total = optAgregators.length;
                for (var i=0;i<itens_total;i++) {
                    insertString += '<option value="'+optAgregators[i][0]+'">'+optAgregators[i][1]+'</option>';
                }
		insertString += '						</select>';
        insertString += '                                               <span id="formRow999c_help">';
        insertString += '                                                   <a href="javascript:showHelp(\'999^c\',\''+lblField999Title+'\',\''+help999subfieldC+'\');"><img src="public/images/common/icon/helper_bg.png" title="help" alt="help" /></a>';
        insertString += '                                               </span>';
        insertString += '					</div>';
		insertString += '					<div class="spacer">&#160;</div>';
		insertString += '				</div>';
		insertString += '                               <div id="subFieldRow09" class="subFieldRow formRowFocus">';
        insertString += '                                       <label for="field14"><strong>'+lblField999AccessType+'</strong></label>';
        insertString += '                                       <div class="frDataFields">';
        insertString += '                                               <select name="field14" id="999a" class="textEntry">';
        var itens_total = optAcessType.length;
        for (var i=0;i<itens_total;i++) {
            insertString += '<option value="'+optAcessType[i][0]+'">'+optAcessType[i][1]+'</option>';
        }
        insertString += '                                               </select>';
        insertString += '                                               <span id="formRow999a_help">';
        insertString += '                                                   <a href="javascript:showHelp(\'999^a\',\''+lblField999Title+'\',\''+help999subfieldA+'\');"><img src="public/images/common/icon/helper_bg.png" title="help" alt="help" /></a>';
        insertString += '                                               </span>';
        insertString += '                                       </div>';
        insertString += '                                       <div class="spacer">&#160;</div>';
        insertString += '                               </div>';
		insertString += '				<div id="subFieldRow10" class="subFieldRow formRowFocus">';
		insertString += '					<label for="field13"><strong>'+lblField999AccessControl+'</strong></label>';
		insertString += '					<div class="frDataFields">';
		insertString += '						<select name="field13" id="999d" class="textEntry singleTextEntry">';
		var itens_total = optControlAccess.length;
        for (var i=0;i<itens_total;i++) {
            insertString += '<option value="'+optControlAccess[i][0]+'">'+optControlAccess[i][1]+'</option>';
        }
		insertString += '						</select>';
                insertString += '                                               <span id="formRow999d_help">';
		insertString += '                                                   <a href="javascript:showHelp(\'999^d\',\''+lblField999Title+'\',\''+help999subfieldD+'\');"><img src="public/images/common/icon/helper_bg.png" title="help" alt="help" /></a>';
		insertString += '                                               </span>';
		insertString += '					</div>';
		insertString += '					<div class="spacer">&#160;</div>';
		insertString += '				</div>';
		insertString += '				<div id="subFieldRow09" class="subFieldRow">';
		insertString += '					<label for="nameOfIssuingBody"><strong>'+lblField999Period+'</strong></label>';
		insertString += '					<div class="frDataFields">';
		insertString += '						'+lblField999From+' <span><input type="text" id="999e" name="field[subcampo][]" value="'+inputValue03+'" class="textEntry miniTextEntry" /></span> '+lblField999Until+' <span><input type="text" id="999f" name="field[subcampo][]" value="'+inputValue03+'" class="textEntry miniTextEntry" /></span>';
                insertString += '                                               <span id="formRow999e_help">';
		insertString += '                                                   <a href="javascript:showHelp(\'999^e\',\''+lblField999Title+'\',\''+help999subfieldE+'\');"><img src="public/images/common/icon/helper_bg.png" title="help" alt="help" /></a>';
		insertString += '                                               </span><br/>';
                insertString += lblField999ComplementaryYears;
		insertString += '						<textarea name="field13" id="999g" rows="4" cols="50" class="textEntry singleTextEntry"></textarea>';
                insertString += '                                               <span id="formRow999g_help">';
		insertString += '                                                   <a href="javascript:showHelp(\'999^g\',\''+lblField999Title+'\',\''+help999subfieldG+'\');"><img src="public/images/common/icon/helper_bg.png" title="help" alt="help" /></a>';
		insertString += '                                               </span><br/>';insertString += '					</div>';
		insertString += '					<div class="spacer">&#160;</div>';
		insertString += '				</div>';
		insertString += '					<div class="spacer">&#160;</div>';
		insertString += '<a href="javascript: implements999Field('+lineCounter+');" class="defaultButton saveButton">';
		insertString += '<img src="public/images/common/defaultButton_iconBorder.gif" alt="" title="'+lblField999Save+'">';
		insertString += '<span><strong>'+lblField999Save+'</strong></span></a>';
		insertString += '				</div>';
		insertString += '			</div>';
		insertString += '		</div>';
		obj.innerHTML += insertString;
		if(obj.style.display == 'none') {
			obj.style.display = "block";
		}
		//document.getElementById(ofId).value = "";
		document.getElementById(ofId).focus();
		//alert (frDataFields+lineCounter);
		lineCounter++;
	}
        
}

//subfields of v450
var lineCounter = 1;
function insertSubField450(frm, ofId, oTclass, subfield, lang, optIndexingCoverage, lblIndexingCoverage) {
       
	frDataFields = 'frDataFields'+ofId;
	obj = document.getElementById(frDataFields);
	inputValue01 = document.getElementById(ofId).value;
	x = inputValue01.indexOf(subfield,0);
        y = inputValue01.length;

        if (x== -1)
        {
            inputValue02 = inputValue01.substring(0,y);
            inputValue03 = "";
        }else{
            inputValue02 = inputValue01.substring(0,x);
            inputValue03 = inputValue01.substring(x+2,y);
        }
        var lblField999Save = labelsJS(lang, '9');

	if(obj) {
		insertString = '';
		insertString += '		<div id="helpOverlay'+lineCounter+'" class="helpBG" style="display: block;">';
		insertString += '			<div class="subFields">';
		insertString += '				<span class="exit"><a href="#" onclick="removeRow(\'frDataFields'+lineCounter+'\'); showHideDiv(\'helpOverlay'+lineCounter+'\'); return false;" title="Fechar"><img src="public/images/common/icon/defaultButton_cancel.png"></a></span>';
		insertString += '				<h5>'+lblIndexingCoverage[0]+'</h5>';
		insertString += '				<div id="subFieldRow05" class="subFieldRow formRowFocus">';
		insertString += '					<label for="field14"><strong>'+lblIndexingCoverage[1]+'</strong></label>';
		insertString += '					<div class="frDataFields">';
		insertString += '						<select name="field14" id="450" class="textEntry lenAdjust">';
		var itens_total = optIndexingCoverage.length;
                for (var i=0;i<itens_total;i++) {
                    if(optIndexingCoverage[i]){
                        insertString += '<option value="'+optIndexingCoverage[i][0]+'">'+optIndexingCoverage[i][1]+'</option>';
                    }
                }
		insertString += '						</select>';
        insertString += '                                               <span id="formRow999c_help">';
        insertString += '                                                   <a href="javascript:showHelp(\'999^c\',\''+lblIndexingCoverage[0]+'\',\''+help450subfieldC+'\');"><img src="public/images/common/icon/helper_bg.png" title="help" alt="help" /></a>';
        insertString += '                                               </span>';
        insertString += '					</div>';
		insertString += '					<div class="spacer">&#160;</div>';
		insertString += '				</div>';
		insertString += '                               <div id="subFieldRow09" class="subFieldRow formRowFocus">';
        insertString += '                                       <label for="field14"><strong>'+lblIndexingCoverage[2]+'</strong></label>';
        insertString += '                                       <div class="frDataFields">';
        insertString += '                                               <input type="text" name="field14" id="450a" class="textEntry">';
        insertString += '                                               <span id="formRow450a_help">';
        insertString += '                                                   <a href="javascript:showHelp(\'450^a\',\''+lblIndexingCoverage[0]+'\',\''+help450subfieldA+'\');"><img src="public/images/common/icon/helper_bg.png" title="help" alt="help" /></a>';
        insertString += '                                               </span>';
        insertString += '                                       </div>';
        insertString += '                                       <div class="spacer">&#160;</div>';
        insertString += '                               </div>';
		insertString += '				<div id="subFieldRow10" class="subFieldRow formRowFocus">';
		insertString += '					<label for="field13"><strong>'+lblIndexingCoverage[3]+'</strong></label>';
		insertString += '					<div class="frDataFields">';
		insertString += '						<input type="text" name="field13" id="450b" class="textEntry singleTextEntry">';
                insertString += '                                               <span id="formRow450b_help">';
		insertString += '                                                   <a href="javascript:showHelp(\'450^b\',\''+lblIndexingCoverage[0]+'\',\''+help450subfieldB+'\');"><img src="public/images/common/icon/helper_bg.png" title="help" alt="help" /></a>';
		insertString += '                                               </span>';
		insertString += '					</div>';
		insertString += '					<div class="spacer">&#160;</div>';
		insertString += '				</div>';
		insertString += '				<div id="subFieldRow09" class="subFieldRow">';
		insertString += '					<label for="nameOfIssuingBody"><strong>'+lblIndexingCoverage[4]+'</strong></label>';
		insertString += '                                       <div class="frDataFields">';
                insertString += '                                               <input type="text" name="field14" id="450c" class="textEntry">';
                insertString += '                                               <span id="formRow450c_help">';
                insertString += '                                                   <a href="javascript:showHelp(\'450^c\',\''+lblIndexingCoverage[0]+'\',\''+help450subfieldC+'\');"><img src="public/images/common/icon/helper_bg.png" title="help" alt="help" /></a>';
                insertString += '                                               </span>';
                insertString += '                                       </div>';
                insertString += '                                       <div class="spacer">&#160;</div>';
		insertString += '				</div>';

                insertString += '				<div id="subFieldRow11" class="subFieldRow">';
		insertString += '					<label for="nameOfIssuingBody"><strong>'+lblIndexingCoverage[5]+'</strong></label>';
		insertString += '                                       <div class="frDataFields">';
                insertString += '                                               <input type="text" name="field14" id="450d" class="textEntry">';
                insertString += '                                               <span id="formRow450d_help">';
                insertString += '                                                   <a href="javascript:showHelp(\'450^d\',\''+lblIndexingCoverage[0]+'\',\''+help450subfieldD+'\');"><img src="public/images/common/icon/helper_bg.png" title="help" alt="help" /></a>';
                insertString += '                                               </span>';
                insertString += '                                       </div>';
                insertString += '                                       <div class="spacer">&#160;</div>';
		insertString += '				</div>';

                insertString += '				<div id="subFieldRow12" class="subFieldRow">';
		insertString += '					<label for="nameOfIssuingBody"><strong>'+lblIndexingCoverage[6]+'</strong></label>';
		insertString += '                                       <div class="frDataFields">';
                insertString += '                                               <input type="text" name="field14" id="450e" class="textEntry">';
                insertString += '                                               <span id="formRow450e_help">';
                insertString += '                                                   <a href="javascript:showHelp(\'450^e\',\''+lblIndexingCoverage[0]+'\',\''+help450subfieldE+'\');"><img src="public/images/common/icon/helper_bg.png" title="help" alt="help" /></a>';
                insertString += '                                               </span>';
                insertString += '                                       </div>';
                insertString += '                                       <div class="spacer">&#160;</div>';
		insertString += '				</div>';

		insertString += '				<div id="subFieldRow13" class="subFieldRow">';
		insertString += '					<label for="nameOfIssuingBody"><strong>'+lblIndexingCoverage[7]+'</strong></label>';
		insertString += '                                       <div class="frDataFields">';
                insertString += '                                               <input type="text" name="field14" id="450f" class="textEntry">';
                insertString += '                                               <span id="formRow450f_help">';
                insertString += '                                                   <a href="javascript:showHelp(\'450^f\',\''+lblIndexingCoverage[0]+'\',\''+help450subfieldF+'\');"><img src="public/images/common/icon/helper_bg.png" title="help" alt="help" /></a>';
                insertString += '                                               </span>';
                insertString += '                                       </div>';
                insertString += '                                       <div class="spacer">&#160;</div>';
		insertString += '				</div>';


		insertString += '					<div class="spacer">&#160;</div>';
		insertString += '<a href="javascript:implements450Field('+lineCounter+');" class="defaultButton saveButton">';
		insertString += '<img src="public/images/common/defaultButton_iconBorder.gif" alt="" title="'+lblField999Save+'">';
		insertString += '<span><strong>'+lblField999Save+'</strong></span></a>';
		insertString += '				</div>';
		insertString += '			</div>';
		insertString += '		</div>';
		obj.innerHTML += insertString;
		if(obj.style.display == 'none') {
			obj.style.display = "block";
		}
		
		document.getElementById(ofId).focus();
		lineCounter++;
	}

}


//subfields of v913
var lineCounter = 1;
function insertSubField913(frm, ofId, subfield, lang, lblAcquisitionHistory) {
        
	frDataFields = 'frDataFields'+ofId;
	obj = document.getElementById(frDataFields);
	inputValue01 = document.getElementById(ofId).value;
	x = inputValue01.indexOf(subfield,0);
        y = inputValue01.length;

        if (x== -1)
        {
            inputValue02 = inputValue01.substring(0,y);
            inputValue03 = "";
        }else{
            inputValue02 = inputValue01.substring(0,x);
            inputValue03 = inputValue01.substring(x+2,y);
        }
        var lblField999Save = labelsJS(lang, '9');

	if(obj) {
		insertString = '';
		insertString += '		<div id="helpOverlay'+lineCounter+'" class="helpBG" style="display: block;">';
		insertString += '			<div class="subFields">';
		insertString += '				<span class="exit"><a href="#" onclick="removeRow(\'frDataFields'+lineCounter+'\'); showHideDiv(\'helpOverlay'+lineCounter+'\'); return false;" title="Fechar"><img src="public/images/common/icon/defaultButton_cancel.png"></a></span>';
		insertString += '				<h5>'+lblAcquisitionHistory[0]+'</h5>';
		insertString += '					<div class="spacer">&#160;</div>';
                insertString += '				<div id="subFieldRow09" class="subFieldRow">';
		insertString += '					<label for="nameOfIssuingBody"><strong>'+lblAcquisitionHistory[1]+'</strong></label>';
		insertString += '                                       <div class="frDataFields">';
                insertString += '                                               <input type="text" name="field14" id="913d" class="textEntry">';
                insertString += '                                                                <div class="yui-skin-sam"><div id="datefields" style="display: none;"></div></div>';
                insertString += '                                                                    <a id="#calend" href="#" onclick="calendarButton(\'913d\'); showHideDiv(\'datefields\');" >';
                insertString += '                                                                        <img src="public/images/common/calbtn.gif" title="calend" alt="calend" />';
                insertString += '                                                                    </a>';
                insertString += '                                               <span id="formRow913d_help">';
                insertString += '                                                   <a href="javascript:showHelp(\'913^d\',\''+lblAcquisitionHistory[0]+'\',\''+help913subfieldD+'\');"><img src="public/images/common/icon/helper_bg.png" title="help" alt="help" /></a>';
                insertString += '                                               </span>';
                insertString += '                                       </div>';
                insertString += '                                       <div class="spacer">&#160;</div>';
		insertString += '				</div>';

                insertString += '				<div id="subFieldRow11" class="subFieldRow">';
		insertString += '					<label for="nameOfIssuingBody"><strong>'+lblAcquisitionHistory[2]+'</strong></label>';
		insertString += '                                       <div class="frDataFields">';
                insertString += '                                               <input type="text" name="field14" id="913v" class="textEntry">';
                insertString += '                                               <span id="formRow913v_help">';
                insertString += '                                                   <a href="javascript:showHelp(\'913^v\',\''+lblAcquisitionHistory[0]+'\',\''+help913subfieldV+'\');"><img src="public/images/common/icon/helper_bg.png" title="help" alt="help" /></a>';
                insertString += '                                               </span>';
                insertString += '                                       </div>';
                insertString += '                                       <div class="spacer">&#160;</div>';
		insertString += '				</div>';

                insertString += '				<div id="subFieldRow12" class="subFieldRow">';
		insertString += '					<label for="nameOfIssuingBody"><strong>'+lblAcquisitionHistory[3]+'</strong></label>';
		insertString += '                                       <div class="frDataFields">';
                insertString += '                                               <input type="text" name="field14" id="913a" class="textEntry">';
                insertString += '                                               <span id="formRow913a_help">';
                insertString += '                                                   <a href="javascript:showHelp(\'913^a\',\''+lblAcquisitionHistory[0]+'\',\''+help913subfieldA+'\');"><img src="public/images/common/icon/helper_bg.png" title="help" alt="help" /></a>';
                insertString += '                                               </span>';
                insertString += '                                       </div>';
                insertString += '                                       <div class="spacer">&#160;</div>';
		insertString += '				</div>';

		insertString += '				<div id="subFieldRow13" class="subFieldRow">';
		insertString += '					<label for="nameOfIssuingBody"><strong>'+lblAcquisitionHistory[4]+'</strong></label>';
		insertString += '                                       <div class="frDataFields">';
                insertString += '                                               <input type="text" name="field14" id="913f" class="textEntry">';
                insertString += '                                               <span id="formRow913f_help">';
                insertString += '                                                   <a href="javascript:showHelp(\'913^f\',\''+lblAcquisitionHistory[0]+'\',\''+help913subfieldF+'\');"><img src="public/images/common/icon/helper_bg.png" title="help" alt="help" /></a>';
                insertString += '                                               </span>';
                insertString += '                                       </div>';
                insertString += '                                       <div class="spacer">&#160;</div>';
		insertString += '				</div>';


		insertString += '					<div class="spacer">&#160;</div>';
		insertString += '<a href="javascript:implements913Field('+lineCounter+');" class="defaultButton saveButton">';
		insertString += '<img src="public/images/common/defaultButton_iconBorder.gif" alt="" title="'+lblField999Save+'">';
		insertString += '<span><strong>'+lblField999Save+'</strong></span></a>';
		insertString += '				</div>';
		insertString += '			</div>';
		insertString += '		</div>';
		obj.innerHTML += insertString;
		if(obj.style.display == 'none') {
			obj.style.display = "block";
		}

		document.getElementById(ofId).focus();
		lineCounter++;
	}

}



/*function OpenEdWizard(mitag,idcampo)
      { 
              janela = new Object();
              var theURL = "/cgi-bin/wxis1660.exe/lildbi/?IsisScript=lildbi/scripts/lildbiw.xis&POPUP.x=POPUP&DataBase=LILACS^l/bvs/www/bases/lildbi/dbcertif/lilacs^m1&User=katia^kkatia309152108^m3^r50^pD&path=/bvs/www/bases/lildbi/&Idioma=p&mitag="+mitag+"&idcampo="+idcampo
              janela = window.open(theURL,"Wizard","height=520,width=540,resizable=no,scrollbars=yes,top=200,left=200,toolbar=no,status=yes");
              janela.focus();
    return true; 
}*/

// codigo para New URL repetitivos
var lineCounter = 1;
function InsertLineNewURL(ofId, oTclass) {
	frDataFields = 'frDataFields'+ofId;
	obj = document.getElementById(frDataFields);
	inputValue01 = document.getElementById(ofId).value;
//var btDeleteRecord = labelsJS(lang, "0");

	if(obj) {

		insertString = '';
		insertString += '		<div class="frDataFields" id="frDataFields'+lineCounter+'">';
		insertString += '			<input type="text" name="field['+ofId+'][]" value="'+inputValue01+'" class="textEntry '+oTclass+'" />';
		insertString += '			<a href="javascript:;" class="singleButton eraseButton" onclick="removeRow(\'frDataFields'+lineCounter+'\')">';
		insertString += '				<span class="sb_lb">&#160;</span>';
		insertString += '				<img src="public/images/common/spacer.gif" alt="" title="" />';
		//insertString += btDeleteRecord;
		insertString += '				<span class="sb_rb">&#160;</span>';
		insertString += '			</a>';
		insertString += '					<div class="spacer">&#160;</div>';
		insertString += '<a href="javascript: formatSubField();" class="defaultButton saveButton">';
		insertString += '<img src="public/images/common/defaultButton_iconBorder.gif" alt="" title="Salvar">';
		insertString += '<span><strong>Salvar</strong></span></a>';
		insertString += '				</div>';
		insertString += '		</div>';
		obj.innerHTML += insertString;
		if(obj.style.display == 'none') {
			obj.style.display = "block";
		}
		document.getElementById(ofId).value = "";
		document.getElementById(ofId).focus();
		//alert (frDataFields+lineCounter);
		lineCounter++;
	}
}


function insertFieldMaskRepeat(oId, bTextOld, bTextNew){

	var	templ = document.getElementById('template');

	var copy = templ.cloneNode(true);


	obj = document.getElementById(oId);

	if (obj){

		var t = copy.innerHTML;
		t = t.replace('value=""', 'valuexx="'+ document.getElementById('volumesIns').value+'"');
		t = t.replace('value=""', 'value="'+ document.getElementById('numsIns').value+'"');
		t = t.replace('valuexx="', 'value="');
		
		t = t.replace('sequenceVolumesValue', 'field[sequenceVolumes][]');
		t = t.replace('numbersSequenceValue', 'field[numbersSequence][]');
		t = t.replace('numsIns', 'numsIns'+lineCounter);
		t = t.replace('volumesIns', 'volumesIns'+lineCounter);
		t = t.replace('okButton', 'eraseButton');
		t = t.replace('insertFieldMaskRepeat', 'removeRow');
		t = t.replace('frDFRowIns', 'frDFRow'+lineCounter);
		t = t.replace(','+ '\'' + bTextOld + '\'', '');
		t = t.replace(','+ '\'' + bTextNew + '\'', '');
		t = t.replace(bTextOld, bTextNew);

		copy.innerHTML = t;
		obj.appendChild(copy);

		//document.getElementById('volumesIns'+lineCounter).value = inputTempValue01;
		//document.getElementById('numsIns'+lineCounter).value = inputTempValue02;

//alert("depois "+ oId+ " "+ obj.innerHTML);

		lineCounter++;
	}

	document.getElementById('volumesIns').value = "";
	document.getElementById('volumesIns').focus();
	document.getElementById('numsIns').value = "";
}

function insertFieldInventoryRepeat(oId,  invContador){

	var	templ = document.getElementById('template');
	var copy = templ.cloneNode(true);
	var j = 0;

	obj = document.getElementById(oId);

	j = (invContador - 1);
	if (obj && (document.getElementById('formFacic_inventoryNumber_' + j).value != '')){
		document.getElementById('insert_' + j).style.display = 'none';
		if (invContador > 1)
		{
			document.getElementById('remove_' + j).style.display = 'none';
		}

		var t = copy.innerHTML;
		i=0;
		while (t.indexOf('template_')>0 || i <10)
		{
			t = t.replace('template_', '');
			i++;
		}
		i=0;
		while (t.indexOf('_counter')>0 || i <10)
		{
			t = t.replace('_counter', '_' + invContador);
			i++;
		}
		k = invContador + 1;
		t = t.replace("'_NewCounter'", k);

		copy.innerHTML = t;

		//alert(1);

		obj.appendChild(copy.childNodes[0]);
		//alert(2);

	}
}


function createDiv(oClass,oId){
	newObj = document.createElement("div");
	newObj.setAttribute('id',oId);
	newObj.setAttribute('class',oClass);

	return newObj;
}

function createInput(oType,oName,oClass,oId,oValue){
	newInp = document.createElement("input");
	newInp.setAttribute('type',oType);
	newInp.setAttribute('name',oName);
	newInp.setAttribute('id',oId);
	newInp.setAttribute('class',oClass);
	newInp.setAttribute('value',oValue);
	return newInp
}
/**
	deveria ser hideRow
*/
function removeRow(obj) {
	obj = document.getElementById(obj);
	if(obj) {
		obj.innerHTML = "";
		obj.style.display = 'none';
	}
}

/**
    reallyRemoveRow porque removeRow deveria ser hideRow
*/
function reallyRemoveRow(obj) {
    var obj = document.getElementById(obj);

    if (obj)
    {
            var p  = obj.parentNode;
            p.removeChild(obj);
    }
}

function cancelAction(dest)	{
    window.location.href = dest;
}

function doit(fId) {
    eForm = document.getElementById(fId);
    eForm.submit();
}

function selectAll() {
	var nodes = document.getElementById('listRecords').getElementsByTagName('input');
	nodes = YAHOO.util.Selector.filter(nodes, '.checkbox');
	for (i=0; i < nodes.length; i++) {
		nodes[i].checked = true;
	}
	return false;
}

function unselectAll() {
	var nodes = document.getElementById('listRecords').getElementsByTagName('input');
	nodes = YAHOO.util.Selector.filter(nodes, '.checkbox');
	for (i=0; i < nodes.length; i++) {
		nodes[i].checked = false;
	}
	return false;
}
function onOffCheck(obj) {
	if(obj.checked) {
		selectAll();
		obj.checked = true;
		return true;
	}else {
		unselectAll();
		obj.checked = false;
		return false;
	}
	//eturn false;
}

function queryString() {
	var loc = location.search.substring(1, location.search.length);
	var param_value = false;
	var qryString = "?";
	var params = loc.split("&");
	for (i=0; i<params.length;i++) {
		param_name = params[i].substring(0,params[i].indexOf('='));
		param_value = params[i].substring(params[i].indexOf('=')+1)
		if(param_name != "" && param_value != "") {
			qryString = qryString + param_name + "=" + param_value + "&";
		}
	}
	if (qryString) {
		return qryString;
	}
	else {
		return false; //Here determine return if no parameter is found
	}
}

// JavaScript usado no Formulario Title - funcao dos passos
function desligabloco(bloco) {
    
	var x = new Number;
	var myarray=new Array();
	x = 2

	obj = document.getElementById('BackNext');
	if(obj) {
		obj.innerHTML = "";
	
		insertString = '';
		insertString += '	<a href="javascript:;" class="defaultButton multiLine nextButton" onclick="desligabloco3()">';
		insertString += '		<img src="public/images/common/defaultButton_iconBorder.gif" alt="" title="" />';
		insertString +=  document.getElementById("nextStep").value;
		insertString += '	</a>';
		insertString += '	<a href="javascript:;" class="defaultButton multiLine backButton" onclick="desligabloco1()">';
		insertString += '		<img src="public/images/common/defaultButton_iconBorder.gif" alt="" title="" />';
		insertString +=  document.getElementById("previousStep").value;
		insertString += '	</a>';
		obj.innerHTML += insertString;
		if(obj.style.display == 'none') {
			obj.style.display = "block";
		}

	}

	objb = document;
	if(objb) {
		objb.innerHTML = "";
		insertStringb = '';
		
		for (y = 1; y < 7; ++y){
			if (x==y){
			insertStringb += ' document.getElementById("bloco_' + x + '").style.display="block" ';
			insertStringb += ' document.getElementById("bloco_' + x + '").style.position="relative" ';
			} 
			else{
			insertStringb += ' document.getElementById("bloco_' + y + '").style.display="none" ';
			insertStringb += ' document.getElementById("bloco_' + y + '").style.position="absolute" ';
			}
		}
			objb.innerHTML += insertStringb;
			alert ('First ' + objb.innerHTML + 'display' + objb.style.display );
			objb.style.display = "block";
			if(objb.style.display == 'none') {
				objb.style.display = "block";
				alert ('Before ' + objb.innerHTML);
			}
				alert ('After' + objb.innerHTML);
	}
	
    document.getElementById("middle").style.display="block";
    document.getElementById("middle").style.position="relative";

}

function btFormNavig(num){

    var obj = document.getElementById('BackNext');
    prev = num - 1;
    next = num + 1;

	if(obj) {
		obj.innerHTML = "";
		insertString += '	<a href="javascript:;" class="defaultButton multiLine nextButton" onclick="desligabloco'+next+'()">';
		insertString += '		<img src="public/images/common/defaultButton_iconBorder.gif" alt="" title="" />';
		insertString +=  document.getElementById("nextStep").value;
		insertString += '	</a>';

		insertString += '	<a href="javascript:;" class="defaultButton multiLine backButton" onclick="desligabloco'+prev+'()">';
		insertString += '		<img src="public/images/common/defaultButton_iconBorder.gif" alt="" title="" />';
		insertString +=  document.getElementById("previousStep").value;
		insertString += '	</a>';

        obj.innerHTML += insertString;
		if(obj.style.display == 'none') {
			obj.style.display = "block";
		}

	}

}

function desligabloco1() {

    //btFormNavig("1");
    document.getElementById("bloco_1").style.display = "block";
    document.getElementById("bloco_1").style.position = "relative";
    document.getElementById("bloco_2").style.display = "none";
    document.getElementById("bloco_2").style.position = "absolute";
    document.getElementById("bloco_3").style.display = "none";
    document.getElementById("bloco_3").style.position = "absolute";
    document.getElementById("bloco_4").style.display = "none";
    document.getElementById("bloco_4").style.position = "absolute";
    document.getElementById("bloco_5").style.display = "none";
    document.getElementById("bloco_5").style.position = "absolute";
    document.getElementById("bloco_6").style.display = "none";
    document.getElementById("bloco_6").style.position = "absolute";
    document.getElementById("bloco_7").style.display = "none";
    document.getElementById("bloco_7").style.position = "absolute";
    //botoes navegacao
    document.getElementById("bloco1").className = "singleButton selectedBlock";
    document.getElementById("bloco2").className = "singleButton singleButtonSelected";
    document.getElementById("bloco3").className = "singleButton singleButtonSelected";
    document.getElementById("bloco4").className = "singleButton singleButtonSelected";
    document.getElementById("bloco5").className = "singleButton singleButtonSelected";
    document.getElementById("bloco6").className = "singleButton singleButtonSelected";
    document.getElementById("bloco7").className = "singleButton singleButtonSelected";
    document.getElementById("bloco1a").className = "singleButton selectedBlock";
    document.getElementById("bloco2a").className = "singleButton singleButtonSelected";
    document.getElementById("bloco3a").className = "singleButton singleButtonSelected";
    document.getElementById("bloco4a").className = "singleButton singleButtonSelected";
    document.getElementById("bloco5a").className = "singleButton singleButtonSelected";
    document.getElementById("bloco6a").className = "singleButton singleButtonSelected";
    document.getElementById("bloco7a").className = "singleButton singleButtonSelected";
}

function desligabloco2() {

    //btFormNavig("2");
    document.getElementById("bloco_2").style.display="block";
    document.getElementById("bloco_2").style.position="relative";
    document.getElementById("bloco_1").style.display="none";
    document.getElementById("bloco_1").style.position="absolute";
    document.getElementById("bloco_3").style.display="none";
    document.getElementById("bloco_3").style.position="absolute";
    document.getElementById("bloco_4").style.display="none";
    document.getElementById("bloco_4").style.position="absolute";
    document.getElementById("bloco_5").style.display="none";
    document.getElementById("bloco_5").style.position="absolute";
    document.getElementById("bloco_6").style.display="none";
    document.getElementById("bloco_6").style.position="absolute";
    document.getElementById("bloco_7").style.display="none";
    document.getElementById("bloco_7").style.position="absolute";
    //botoes navegacao
    document.getElementById("bloco1").className = "singleButton singleButtonSelected";
    document.getElementById("bloco2").className = "singleButton selectedBlock";
    document.getElementById("bloco3").className = "singleButton singleButtonSelected";
    document.getElementById("bloco4").className = "singleButton singleButtonSelected";
    document.getElementById("bloco5").className = "singleButton singleButtonSelected";
    document.getElementById("bloco6").className = "singleButton singleButtonSelected";
    document.getElementById("bloco7").className = "singleButton singleButtonSelected";
    document.getElementById("bloco1a").className = "singleButton singleButtonSelected";
    document.getElementById("bloco2a").className = "singleButton selectedBlock";
    document.getElementById("bloco3a").className = "singleButton singleButtonSelected";
    document.getElementById("bloco4a").className = "singleButton singleButtonSelected";
    document.getElementById("bloco5a").className = "singleButton singleButtonSelected";
    document.getElementById("bloco6a").className = "singleButton singleButtonSelected";
    document.getElementById("bloco7a").className = "singleButton singleButtonSelected";
    //document.getElementById("singleButton selectedBlock").id = "vazio";
    //document.getElementById("bloco2").id = "bloco1";
}
function desligabloco3() {

    //btFormNavig("3");
    document.getElementById("bloco_3").style.display="block";
    document.getElementById("bloco_3").style.position="relative";
    document.getElementById("bloco_1").style.display="none";
    document.getElementById("bloco_1").style.position="absolute";
    document.getElementById("bloco_2").style.display="none";
    document.getElementById("bloco_2").style.position="absolute";
    document.getElementById("bloco_4").style.display="none";
    document.getElementById("bloco_4").style.position="absolute";
    document.getElementById("bloco_5").style.display="none";
    document.getElementById("bloco_5").style.position="absolute";
    document.getElementById("bloco_6").style.display="none";
    document.getElementById("bloco_6").style.position="absolute";
    document.getElementById("bloco_7").style.display="none";
    document.getElementById("bloco_7").style.position="absolute";
    //botoes navegacao
    document.getElementById("bloco1").className = "singleButton singleButtonSelected";
    document.getElementById("bloco2").className = "singleButton singleButtonSelected";
    document.getElementById("bloco3").className = "singleButton selectedBlock";
    document.getElementById("bloco4").className = "singleButton singleButtonSelected";
    document.getElementById("bloco5").className = "singleButton singleButtonSelected";
    document.getElementById("bloco6").className = "singleButton singleButtonSelected";
    document.getElementById("bloco7").className = "singleButton singleButtonSelected";
    document.getElementById("bloco1a").className = "singleButton singleButtonSelected";
    document.getElementById("bloco2a").className = "singleButton singleButtonSelected";
    document.getElementById("bloco3a").className = "singleButton selectedBlock";
    document.getElementById("bloco4a").className = "singleButton singleButtonSelected";
    document.getElementById("bloco5a").className = "singleButton singleButtonSelected";
    document.getElementById("bloco6a").className = "singleButton singleButtonSelected";
    document.getElementById("bloco7a").className = "singleButton singleButtonSelected";
    //
    //document.getElementById("middle").style.display="block";
    //document.getElementById("middle").style.position="relative";
}

function desligabloco4() {

    //btFormNavig("4");
    document.getElementById("bloco_4").style.display="block";
    document.getElementById("bloco_4").style.position="relative";
    document.getElementById("bloco_1").style.display="none";
    document.getElementById("bloco_1").style.position="absolute";
    document.getElementById("bloco_2").style.display="none";
    document.getElementById("bloco_2").style.position="absolute";
    document.getElementById("bloco_3").style.display="none";
    document.getElementById("bloco_3").style.position="absolute";
    document.getElementById("bloco_5").style.display="none";
    document.getElementById("bloco_5").style.position="absolute";
    document.getElementById("bloco_6").style.display="none";
    document.getElementById("bloco_6").style.position="absolute";
    document.getElementById("bloco_7").style.display="none";
    document.getElementById("bloco_7").style.position="absolute";
    //botoes navegacao
    document.getElementById("bloco1").className = "singleButton singleButtonSelected";
    document.getElementById("bloco2").className = "singleButton singleButtonSelected";
    document.getElementById("bloco3").className = "singleButton singleButtonSelected";
    document.getElementById("bloco4").className = "singleButton selectedBlock";
    document.getElementById("bloco5").className = "singleButton singleButtonSelected";
    document.getElementById("bloco6").className = "singleButton singleButtonSelected";
    document.getElementById("bloco7").className = "singleButton singleButtonSelected";
    document.getElementById("bloco1a").className = "singleButton singleButtonSelected";
    document.getElementById("bloco2a").className = "singleButton singleButtonSelected";
    document.getElementById("bloco3a").className = "singleButton singleButtonSelected";
    document.getElementById("bloco4a").className = "singleButton selectedBlock";
    document.getElementById("bloco5a").className = "singleButton singleButtonSelected";
    document.getElementById("bloco6a").className = "singleButton singleButtonSelected";
    document.getElementById("bloco7a").className = "singleButton singleButtonSelected";
    //document.getElementById("middle").style.display="block";
    //document.getElementById("middle").style.position="relative";
}
function desligabloco5() {
  
    //btFormNavig("5");
    document.getElementById("bloco_5").style.display="block";
    document.getElementById("bloco_5").style.position="relative";
    document.getElementById("bloco_1").style.display="none";
    document.getElementById("bloco_1").style.position="absolute";
    document.getElementById("bloco_2").style.display="none";
    document.getElementById("bloco_2").style.position="absolute";
    document.getElementById("bloco_3").style.display="none";
    document.getElementById("bloco_3").style.position="absolute";
    document.getElementById("bloco_4").style.display="none";
    document.getElementById("bloco_4").style.position="absolute";
    document.getElementById("bloco_6").style.display="none";
    document.getElementById("bloco_6").style.position="absolute";
    document.getElementById("bloco_7").style.display="none";
    document.getElementById("bloco_7").style.position="absolute";
    //botoes navegacao
    document.getElementById("bloco1").className = "singleButton singleButtonSelected";
    document.getElementById("bloco2").className = "singleButton singleButtonSelected";
    document.getElementById("bloco3").className = "singleButton singleButtonSelected";
    document.getElementById("bloco4").className = "singleButton singleButtonSelected";
    document.getElementById("bloco5").className = "singleButton selectedBlock";
    document.getElementById("bloco6").className = "singleButton singleButtonSelected";
    document.getElementById("bloco7").className = "singleButton singleButtonSelected";
    document.getElementById("bloco1a").className = "singleButton singleButtonSelected";
    document.getElementById("bloco2a").className = "singleButton singleButtonSelected";
    document.getElementById("bloco3a").className = "singleButton singleButtonSelected";
    document.getElementById("bloco4a").className = "singleButton singleButtonSelected";
    document.getElementById("bloco5a").className = "singleButton selectedBlock";
    document.getElementById("bloco6a").className = "singleButton singleButtonSelected";
    document.getElementById("bloco7a").className = "singleButton singleButtonSelected";
    //document.getElementById("middle").style.display="block";
    //document.getElementById("middle").style.position="relative";
}
   
function desligabloco6() {

    //btFormNavig("6");
    document.getElementById("bloco_6").style.display="block";
    document.getElementById("bloco_6").style.position="relative";
    document.getElementById("bloco_1").style.display="none";
    document.getElementById("bloco_1").style.position="absolute";
    document.getElementById("bloco_2").style.display="none";
    document.getElementById("bloco_2").style.position="absolute";
    document.getElementById("bloco_3").style.display="none";
    document.getElementById("bloco_3").style.position="absolute";
    document.getElementById("bloco_4").style.display="none";
    document.getElementById("bloco_4").style.position="absolute";
    document.getElementById("bloco_5").style.display="none";
    document.getElementById("bloco_5").style.position="absolute";
    document.getElementById("bloco_7").style.display="none";
    document.getElementById("bloco_7").style.position="absolute";
    //botoes navegacao
    document.getElementById("bloco1").className = "singleButton singleButtonSelected";
    document.getElementById("bloco2").className = "singleButton singleButtonSelected";
    document.getElementById("bloco3").className = "singleButton singleButtonSelected";
    document.getElementById("bloco4").className = "singleButton singleButtonSelected";
    document.getElementById("bloco5").className = "singleButton singleButtonSelected";
    document.getElementById("bloco6").className = "singleButton selectedBlock";
    document.getElementById("bloco7").className = "singleButton singleButtonSelected";
    document.getElementById("bloco1a").className = "singleButton singleButtonSelected";
    document.getElementById("bloco2a").className = "singleButton singleButtonSelected";
    document.getElementById("bloco3a").className = "singleButton singleButtonSelected";
    document.getElementById("bloco4a").className = "singleButton singleButtonSelected";
    document.getElementById("bloco5a").className = "singleButton singleButtonSelected";
    document.getElementById("bloco6a").className = "singleButton selectedBlock";
    document.getElementById("bloco7a").className = "singleButton singleButtonSelected";
	//document.getElementById("middle").style.display="block";
	//document.getElementById("middle").style.position="relative";
}
function desligabloco7() {

    //btFormNavig("7");
    document.getElementById("bloco_7").style.display="block";
    document.getElementById("bloco_7").style.position="relative";
    document.getElementById("bloco_1").style.display="none";
    document.getElementById("bloco_1").style.position="absolute";
    document.getElementById("bloco_2").style.display="none";
    document.getElementById("bloco_2").style.position="absolute";
    document.getElementById("bloco_3").style.display="none";
    document.getElementById("bloco_3").style.position="absolute";
    document.getElementById("bloco_4").style.display="none";
    document.getElementById("bloco_4").style.position="absolute";
    document.getElementById("bloco_5").style.display="none";
    document.getElementById("bloco_5").style.position="absolute";
    document.getElementById("bloco_6").style.display="none";
    document.getElementById("bloco_6").style.position="absolute";
    //botoes navegacao
    document.getElementById("bloco1").className = "singleButton singleButtonSelected";
    document.getElementById("bloco2").className = "singleButton singleButtonSelected";
    document.getElementById("bloco3").className = "singleButton singleButtonSelected";
    document.getElementById("bloco4").className = "singleButton singleButtonSelected";
    document.getElementById("bloco5").className = "singleButton singleButtonSelected";
    document.getElementById("bloco6").className = "singleButton singleButtonSelected";
    document.getElementById("bloco7").className = "singleButton selectedBlock";
    document.getElementById("bloco1a").className = "singleButton singleButtonSelected";
    document.getElementById("bloco2a").className = "singleButton singleButtonSelected";
    document.getElementById("bloco3a").className = "singleButton singleButtonSelected";
    document.getElementById("bloco4a").className = "singleButton singleButtonSelected";
    document.getElementById("bloco5a").className = "singleButton singleButtonSelected";
    document.getElementById("bloco6a").className = "singleButton singleButtonSelected";
    document.getElementById("bloco7a").className = "singleButton selectedBlock";
	//document.getElementById("middle").style.display="block";
	//document.getElementById("middle").style.position="relative";
}

/*
 * @param divId string recebe o nome de uma div HTML
 * @return se style.display for none vira block,
 * senao se for block vira none
 */
function showHideDiv(divId){
	obj = document.getElementById(divId);
	v = obj.style.display; 

	if (v == 'none' || v == '' ) {
		disp = 'block';
	}else {
		disp = 'none';
	}
	
	obj.style.display = disp;
}

/*
 *@param dest string URL
 *@return open URL
 */
function cancelAction(dest)
{
	window.location.href = dest;
}  

/*
 *@param lang string show message in selected language
 *@return alert
 */
function showMessage(lang){

        var result = errorMsgs(lang, "6");
        alert (result);
}

/*
 * Funcao feita pelo DGI para resolver problema com as imagens no IE6
 * @param {Object} myImage
 */
function fixPNG(myImage){ // correctly handle PNG transparency in Win IE 5.5 or higher.
	 var imgID = (myImage.id) ? "id='" + myImage.id + "' " : ""
	 var imgClass = (myImage.className) ? "class='" + myImage.className + "' " : ""
	 var imgTitle = (myImage.title) ? "title='" + myImage.title + "' " : "title='" + myImage.alt + "' "
	 var imgStyle = "display:inline-block;" + myImage.style.cssText
	 var strNewHTML = "<span " + imgID + imgClass + imgTitle
	 strNewHTML += " style=\"" + "width:" + myImage.width + "px; height:" + myImage.height + "px;" + imgStyle + ";"
	 strNewHTML += "filter:progid:DXImageTransform.Microsoft.AlphaImageLoader"
	 strNewHTML += "(src=\'" + myImage.src + "\', sizingMethod='scale');\"></span>"
	 myImage.outerHTML = strNewHTML
}

/*
 * The key enter send the login form 
 */
function handleEnter(event) {
	var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
	if (keyCode == 13) {
		doit('formData');
	}
	return false;
}
//aqui

function implementsGenericField(numField,oId,lineCounter)
{
    var Dom = YAHOO.util.Dom;    
    var field = Dom.get(oId);
    var new_value;
    var subfield1 = callsubfields(numField, '0');
    var subfield2 = callsubfields(numField, '1');
    
    new_value = subfield1 + Dom.get(numField+subfield1).value + "^"+ subfield2 + Dom.get(numField+subfield2).value;
    field.value = new_value;
    Dom.get(numField+subfield1).value = "";
    Dom.get(numField+subfield2).value = "";
    
    var elemento = document.getElementById("helpOverlay" + lineCounter);
    YAHOO.util.Dom.removeClass('helpOverlay'+lineCounter, 'helpBG');
    while (elemento.firstChild) {
	   elemento.removeChild(elemento.firstChild);
    }
}
function implements999Field(lineCounter)
{
    var Dom = YAHOO.util.Dom;    
    var field = Dom.get("urlPortal");
    var new_value;
    var new_value_g = "";
    new_value = "^a" + Dom.get("999a").value + "^b" + Dom.get("999b").value;
    new_value = new_value + "^c" + Dom.get("999c").value + "^d" + Dom.get("999d").value;
    new_value = new_value + "^e" + Dom.get("999e").value + "^f" + Dom.get("999f").value;
    new_value = new_value + "^g";
    var strg = Dom.get("999g").value;
    var strgSplitResult = strg.split("\n");
    for(i = 0; i < strgSplitResult.length; i++){
	       new_value_g = new_value_g + strgSplitResult[i];
    }
    new_value = new_value + new_value_g;    
    field.value = new_value;
    Dom.get("999a").value = "";
    Dom.get("999b").value = "";
    Dom.get("999c").value = "";
    Dom.get("999d").value = "";
    Dom.get("999e").value = "";
    Dom.get("999f").value = "";
    Dom.get("999g").value = "";    
    //showHideDiv('helpOverlay');
    var elemento = document.getElementById("helpOverlay"+lineCounter);
    YAHOO.util.Dom.removeClass('helpOverlay'+lineCounter, 'helpBG');
    while (elemento.firstChild) {
	   elemento.removeChild(elemento.firstChild);
    }
}

function implements450Field(lineCounter)
{
    var Dom = YAHOO.util.Dom;
    var field = Dom.get("indexingCoverage");
    var new_value;
    //var new_value_g = "";
    new_value = Dom.get("450").value + "^a" + Dom.get("450a").value + "^b" + Dom.get("450b").value;
    new_value = new_value + "^c" + Dom.get("450c").value + "^d" + Dom.get("450d").value;
    new_value = new_value + "^e" + Dom.get("450e").value + "^f" + Dom.get("450f").value;
    //new_value = new_value + "^g";
    //var strg = Dom.get("999g").value;
//    var strgSplitResult = strg.split("\n");
//    for(i = 0; i < strgSplitResult.length; i++){
//	       new_value_g = new_value_g + strgSplitResult[i];
//    }
    //new_value = new_value + new_value_g;
    field.value = new_value;
    Dom.get("450").value = "";
    Dom.get("450a").value = "";
    Dom.get("450b").value = "";
    Dom.get("450c").value = "";
    Dom.get("450d").value = "";
    Dom.get("450e").value = "";
    Dom.get("450f").value = "";
    //Dom.get("999g").value = "";
    //showHideDiv('helpOverlay');
    var elemento = document.getElementById("helpOverlay"+lineCounter);
    YAHOO.util.Dom.removeClass('helpOverlay'+lineCounter, 'helpBG');
    while (elemento.firstChild) {
	   elemento.removeChild(elemento.firstChild);
    }
}

function implements913Field(lineCounter)
{
    var Dom = YAHOO.util.Dom;
    var field = Dom.get("acquisitionHistory");
    var new_value;
    
    new_value = "^d" + Dom.get("913d").value + "^v" + Dom.get("913v").value;
    new_value = new_value + "^a" + Dom.get("913a").value + "^f" + Dom.get("913f").value;
 
    field.value = new_value;
    Dom.get("913d").value = "";
    Dom.get("913v").value = "";
    Dom.get("913a").value = "";
    Dom.get("913f").value = "";
    
    var elemento = document.getElementById("helpOverlay"+lineCounter);
    YAHOO.util.Dom.removeClass('helpOverlay'+lineCounter, 'helpBG');
    while (elemento.firstChild) {
	   elemento.removeChild(elemento.firstChild);
    }
}


function addSubFieldElement(oId, oEl, lang)
{

    frDataFields = 'frDataFields'+oId;
    theContainer = document.getElementById(frDataFields);
    theValue = document.getElementById(oId).value;
    var btDeleteRecord = labelsJS(lang, "0");

if (theValue != ""){
    oDiv = document.createElement("div");
    oDiv.setAttribute("id","frDataFields"+lineCounter);
    oDiv.setAttribute("class","frDataFields");
    oInp = document.createElement("input");
    oInp.setAttribute("type","text");
    oInp.setAttribute("name","field[urlPortal][]");
    oInp.setAttribute("value",theValue);
    oInp.setAttribute("class","textEntry singleTextEntry");    
    oLin = document.createElement("a");
    oLin.setAttribute("href","javascript:;");
    oLin.setAttribute("class","singleButton eraseButton");
    oLin.setAttribute("onclick","removeRow('frDataFields"+lineCounter+"'\');");
    insertString = '				<span class="sb_lb">&#160;</span>';
    insertString += '				<img src="public/images/common/spacer.gif" alt="" title="" />';
    insertString += btDeleteRecord;
    insertString += '				<span class="sb_rb">&#160;</span>';
    oLin.innerHTML = insertString;
    oDiv.appendChild(oInp);
    oDiv.appendChild(oLin);
    theContainer.appendChild(oDiv);
    lineCounter++;
    document.getElementById(oId).value="";
    }else{
        var result = errorMsgs(lang, "4");
        alert (result);
    }
}

function calendarButton(idField){

    var oCalendarMenu = new YAHOO.widget.Overlay("secsCalendar");
    oCalendarMenu.setBody("&#32;");
    oCalendarMenu.body.id = "calendar2";
    oCalendarMenu.render("datefields");
    oCalendarMenu.align();
    var oCalendar = new YAHOO.widget.Calendar("calendar3", oCalendarMenu.body.id);
    oCalendar.render();
    oCalendar.changePageEvent.subscribe(function () {
        window.setTimeout(function () {
            oCalendarMenu.show();
        }, 0);
    });

    oCalendar.selectEvent.subscribe(function (p_sType, p_aArgs) {
        var aDate;
        if (p_aArgs) {
            aDate = p_aArgs[0][0];
            if(aDate[1] == "10" || aDate[1] == "11" || aDate[1] == "12"){month = aDate[1];}else{month = "0"+aDate[1];}
            if(aDate[2] == "1" || aDate[2] == "2" || aDate[2] == "3" || aDate[2] == "4" || aDate[2] == "5" || aDate[2] == "6" || aDate[2] == "7" || aDate[2] == "8" || aDate[2] == "9")
            {day = "0"+aDate[2];}else{day = aDate[2];}
            YAHOO.util.Dom.get(idField).value = aDate[0].toString() + month.toString() + day.toString();
        }
        oCalendarMenu.hide();
        
    });
}
