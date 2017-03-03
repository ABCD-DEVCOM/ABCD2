<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      loanobjects.php
 * @desc:      Reads and update the loan policy
 * @author:    Guilda Ascencio
 * @since:     20091203
 * @version:   1.0
 *
 * == BEGIN LICENSE ==
 *
 *    This program is free software: you can redistribute it and/or modify
 *    it under the terms of the GNU Lesser General Public License as
 *    published by the Free Software Foundation, either version 3 of the
 *    License, or (at your option) any later version.
 *
 *    This program is distributed in the hope that it will be useful,
 *    but WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *    GNU Lesser General Public License for more details.
 *
 *    You should have received a copy of the GNU Lesser General Public License
 *    along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * == END LICENSE ==
*/
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../common/get_post.php");
include("../config.php");
$lang=$_SESSION["lang"];
include("../lang/dbadmin.php");
include("../lang/prestamo.php");

$rows_title[0]=$msgstr["tit_tm"];
$rows_title[1]=$msgstr["tit_tu"];
$rows_title[2]=$msgstr["tit_np"];
$rows_title[3]=$msgstr["tit_lpn"];
$rows_title[4]=$msgstr["tit_lpr"];
$rows_title[5]=$msgstr["tit_unid"];
$rows_title[6]=$msgstr["tit_renov"];
$rows_title[7]=$msgstr["tit_multa"];
$rows_title[8]=$msgstr["tit_multar"];
$rows_title[9]=$msgstr["tit_susp"];
$rows_title[10]=$msgstr["tit_suspr"];
$rows_title[11]=$msgstr["tit_reserva"];
$rows_title[12]=$msgstr["tit_permitirp"];
$rows_title[13]=$msgstr["tit_permitirr"];
$rows_title[14]=$msgstr["tit_copias"];
$rows_title[15]=$msgstr["tit_limusuario"];
$rows_title[16]=$msgstr["tit_limobjeto"];
$rows_title[17]=$msgstr["tit_inf"];
$rows_title[18]=$msgstr["tit_espera"];


$rows_title_a[0]=$msgstr["tit_tm_a"];
$rows_title_a[1]=$msgstr["tit_tu_a"];
$rows_title_a[2]=$msgstr["tit_np_a"];
$rows_title_a[3]=$msgstr["tit_lpn_a"];
$rows_title_a[4]=$msgstr["tit_lpr_a"];
$rows_title_a[5]=$msgstr["tit_unid_a"];
$rows_title_a[6]=$msgstr["tit_renov_a"];
$rows_title_a[7]=$msgstr["tit_multa_a"];
$rows_title_a[8]=$msgstr["tit_multar_a"];
$rows_title_a[9]=$msgstr["tit_susp_a"];
$rows_title_a[10]=$msgstr["tit_suspr_a"];
$rows_title_a[11]=$msgstr["tit_reserva_a"];
$rows_title_a[12]=$msgstr["tit_permitirp_a"];
$rows_title_a[13]=$msgstr["tit_permitirr_a"];
$rows_title_a[14]=$msgstr["tit_copias_a"];
$rows_title_a[15]=$msgstr["tit_limusuario_a"];
$rows_title_a[16]=$msgstr["tit_limobjeto_a"];
$rows_title_a[17]=$msgstr["tit_inf_a"];
$rows_title_a[18]=$msgstr["tit_espera_a"];

$archivo= $db_path."circulation/def/".$_SESSION["lang"]."/typeofusers.tab";
if (!file_exists($archivo))  $archivo=$db_path."circulation/def/".$lang_db."/typeofusers.tab";
if (file_exists($archivo)){
	$fp=file($archivo);
}else{
	$fp[0]='||';

}
foreach ($fp as $value){	$value=trim($value);	if ($value!=""){		$t=explode('|',$value."|||||");
		if (!isset($t[1]) or trim($t[1]=="")) $t[1]=$t[0];
		$type_users[$t[0]]=$t[1];
	}}
unset($fp);
$archivo=$db_path."circulation/def/".$_SESSION["lang"]."/items.tab";
if (!file_exists($archivo)) $archivo=$db_path."circulation/def/".$lang_db."/items.tab";
if (file_exists($archivo)){
	$fp=file($archivo);
}else{
	$fp[0]='||';

}
foreach ($fp as $value){	$value=trim($value);
	if ($value!=""){
		$t=explode('|',$value);
		$type_items[$t[0]]=$t[1];
	}
}






include("../common/header.php");
$file=$db_path."circulation/def/".$_SESSION["lang"]."/typeofitems.tab";
if (!file_exists($file))  $file=$db_path."circulation/def/".$lang_db."/typeofitems.tab";
if (file_exists($file)){
	$fp=file($file);
}else{
	$fp=array();
	for ($i=0;$i<20;$i++){
		$fp[$i]='|||||||||||||||||';
	}
	$tope=20;
}
// Se crea el arreglo con la lista de objetos
echo "
<script>
Editar=\"\"
var item=new Array()
";
$ix=-1;
foreach ($fp as $value) {
	if (trim($value)!=""){		$value=trim($value);		$value.="||||";
		$ix=$ix+1;
		echo "
		item[$ix]=\"".trim($value)."\"\n" ;
	//	echo "item[$ix][1]=\"".$type_items[$Ti[0]]." - ".$Ti[1]."\"\n";
    }
}
echo "</script>\n";
?>
<script  src="../dataentry/js/lr_trim.js"></script>
<script>
	var RT=new Array()
	var RT_A=new Array()

<?php
foreach ($rows_title as $var=>$value){	echo "RT['$var']=\"$value\"\n";}

foreach ($rows_title_a as $var=>$value){
	echo "RT_A['$var']=\"$value\"\n";
}

echo "var TU=new Array()\n";
foreach  ($type_users as $var=>$value){	echo "TU['$var']=\"$value\"\n";}
echo "var TI=new Array()\n";
foreach  ($type_items as $var=>$value){
	echo "TI['$var']=\"$value\"\n";
}
?>
	Accion=""

    function NuevoTipo(){       	sel="||||||||||||||||||||||||"
       	Accion="nuevo"
       	Redraw(sel)    }

    function ModificarTipo(){    	i=document.forma1.item.selectedIndex
    	if (i==0) {    		Cancelar()
    		return    	}
    	sel=document.forma1.item.options[i].value    	Accion="modificar"
    	Redraw(sel)    }

	function Cancelar(){
		elem = document.getElementById("acciones");		html="<a href=javascript:Enviar()><?php echo $msgstr["update"]?></a>&nbsp; &nbsp; &nbsp; &nbsp;"
    	html+="<a href=configure_menu.php?encabezado=s><?php echo $msgstr["cancel"]?></a>"        elem.innerHTML = html
        elem = document.getElementById("type_e");
        elem.innerHTML = ""
        Redraw_Table()
	}

	function Eliminar(index){		item.splice(index,1)
		Redraw_Table()	}

	function Agregar(index){
		item.splice(index,0,"||||||||||||||||||||||||||||||||")
		Redraw_Table()
	}



	function Editar_Tabla(index){
		sel=item[index]
    	Accion="modificar"
    	Redraw(sel,index)	}

    function Aceptar_Item(Index){
    	xItem=""
    	i=document.forma1.tipo_m.selectedIndex
    	if (i<0){
    		alert("debe seleccionar el tipo de material")
    		return
    	}
    	tipo_material=Trim(document.forma1.tipo_m.options[i].value)
    	xItem=tipo_material

    	i=document.forma1.tipo_u.selectedIndex
    	if (i<0){    		alert("debe seleccionar el tipo de usuario")
    		return    	}
    	tipo_usuario=Trim(document.forma1.tipo_u.options[i].value)
    	xItem+='|'+tipo_usuario



    	x=Trim(document.forma1.np_p.value)
    	if (x==""){    		//alert("<?php echo $msgstr["falta"].$rows_title[2]?>")
    		//return    	}
    	xItem+='|'+x

		x=Trim(document.forma1.lapsop_n.value)
    	if (x==""){
    		alert("<?php echo $msgstr["falta"].$rows_title[3]?>")
    		return
    	}
    	xItem+='|'+x

    	x=Trim(document.forma1.lapsop_r.value)
    	if (x==""){
  //  		alert("<?php echo $msgstr["falta"].$rows_title[4]?>")
  //  		return
    	}
    	xItem+='|'+x

		x=""
    	if (document.forma1.unidad[0].checked) x=document.forma1.unidad[0].value
    	if (document.forma1.unidad[1].checked) x=document.forma1.unidad[1].value
    	if (x==""){
    		alert("<?php echo $msgstr["falta"].$rows_title[5]?>")
    		return
    	}
    	xItem+='|'+x

    	x=Trim(document.forma1.renov_n.value)
    	if (x==""){
//    		alert("<?php echo $msgstr["falta"].$rows_title[6]?>")
//    		return
    	}
    	xItem+='|'+x

    	x=Trim(document.forma1.multa_n.value)
    	if (x==""){
 //   		alert("<?php echo $msgstr["falta"].$rows_title[7]?>")
 //   		return
    	}
    	xItem+='|'+x

    	x=Trim(document.forma1.multa_r.value)
    	if (x==""){
//    		alert("<?php echo $msgstr["falta"].$rows_title[8]?>")
//    		return
    	}
    	xItem+='|'+x

    	x=Trim(document.forma1.susp_n.value)
    	if (x==""){
//    		alert("<?php echo $msgstr["falta"].$rows_title[9]?>")
//    		return
    	}
    	xItem+='|'+x

    	x=Trim(document.forma1.susp_r.value)
    	if (x==""){
//    		alert("<?php echo $msgstr["falta"].$rows_title[10]?>")
//    		return
    	}
    	xItem+='|'+x

    	if (document.forma1.reserva.checked)
    		x=Trim(document.forma1.reserva.value)
    	else
    		x=""
    	xItem+='|'+x

    	if (document.forma1.permiteprestamo.checked)
    		x=Trim(document.forma1.permiteprestamo.value)
    	else
    		x=""
    	xItem+='|'+x

    	if (document.forma1.permiterenovacion.checked)
    		x=Trim(document.forma1.permiterenovacion.value)
    	else
    		x=""
    	xItem+='|'+x

		if (document.forma1.copiasmismoitem.checked)
    		x=Trim(document.forma1.copiasmismoitem.value)
    	else
    		x=""
    	xItem+='|'+x

    	x=Trim(document.forma1.fecha_u.value)
    	if (x!=""){    		res=ValidarFecha(x.substr(4,2)+"/"+x.substr(6,2)+"/"+x.substr(0,4))
    		if (res==false){
    			alert("Fecha límite para el tipo de objeto inválida")
    			return
    		}
    	}
    	xItem+='|'+x

    	x=Trim(document.forma1.fecha_i.value)
    	if (x!=""){
	    	res=ValidarFecha(x.substr(4,2)+"/"+x.substr(6,2)+"/"+x.substr(0,4))
	    	if (res==false){	    		alert("Fecha límite para el tipo de objeto inválida")
	    		return
	   		}    	}
    	xItem+='|'+x

    	if (document.forma1.infadicional.checked)
    		x=Trim(document.forma1.infadicional.value)
    	else
    		x=""
    	xItem+='|'+x
    	x=Trim(document.forma1.waiting_i.value)
        xItem+='|'+x
        switch (Accion){
        	case "nuevo":
        		i=item.length
        		item[i]=xItem
        		break;
        	case "modificar":
        		item[Index]=xItem
        		break
        }

        Cancelar()
        Redraw_Table()
    }
	function Redraw(sel,index){		Editar="Y"    	elem = document.getElementById("type_e");
    	html='<table class="listTable" width=100% border=0>';
    	html+="<tr><td></td><td align=right>"
    	html+="<p align=right><a href=javascript:Aceptar_Item("+index+")><img src=../dataentry/img/aceptar.gif height=15 align=middle><?php echo $msgstr["acc_changes"]?></a>&nbsp &nbsp; <img src=../dataentry/img/toolbarCancelEdit.png align=middle><a href=javascript:Cancelar()><?php echo $msgstr["can_changes"]?></a>"
    	html+="</td></tr>"
    	cell=sel.split('|')
    	for (var c in RT){
    		html+="<tr onmouseover=\"this.className = 'rowOver';\" onmouseout=\"this.className = '';\"><td>"+RT[c]+"</td><td>"
    		switch (c){    			case "0":
    				html+="<select name=tipo_m>\n"
    				for (a in TI){
    					selected=""
    					if (cell[c]==a) selected=" selected"    					html+="<option value=\""+a+"\""+selected+">"+TI[a]+" ("+a+")"    				}
    				html+="</select></td>"
    				break
    			case "1":
    				html+="<select name=tipo_u>\n"
    				for (a in TU){
    					selected=""
    					if (cell[c]==a) selected=" selected"
    					html+="<option value=\""+a+"\""+selected+">"+TU[a]+" ("+a+")"
    				}
    				html+="</select></td>"
    				break
    			case "2":
    				html+="<input type=text name=np_p value=\""+cell[c]+"\"></td>"
    				break
    			case "3":
    				html+="<input type=text name=lapsop_n value=\""+cell[c]+"\"></td>"
    				break
    			case "4":
    				html+="<input type=text name=lapsop_r value=\""+cell[c]+"\"></td>"
    				break
				case "5":
					Dias=""
					Horas=""
					if (cell[c]=="D") Dias=" checked"
					if (cell[c]=="H") Horas=" checked"
					html+="<input type=radio name=unidad value=D"+Dias+">"+"<?php echo $msgstr["days"]?>"+"<input type=radio name=unidad value=H"+Horas+"><?php echo $msgstr["hours"]?></td>"
					break;
				case "6":
    				html+="<input type=text name=renov_n value=\""+cell[c]+"\"></td>"
    				break
    			case "7":
    				html+="<input type=text name=multa_n value=\""+cell[c]+"\"></td>"
    				break
    			case "8":
    				html+="<input type=text name=multa_r value=\""+cell[c]+"\"></td>"
    				break
    			case "9":
    				html+="<input type=text name=susp_n value=\""+cell[c]+"\"></td>"
    				break
    			case "10":
    				html+="<input type=text name=susp_r value=\""+cell[c]+"\"></td>"
    				break
    			case "11":
    				chk=""
					if (cell[c]=="Y") chk=" checked"
    				html+="<input type=checkbox name=reserva value=\"Y\" "+chk+"></td>"
    				break
				case "12":
					chk=""
					if (cell[12]=="Y") chk=" checked"
				    html+="<input type=checkbox name=permiteprestamo value=Y"+chk+"></td>"
				    break;
				case "13":
					chk=""
					if (cell[13]=="Y") chk=" checked"
				    html+="<input type=checkbox name=permiterenovacion value=Y"+chk+"></td>"
				    break
				case "14":
					chk=""
					if (cell[14]=="Y") chk=" checked"
				    html+="<input type=checkbox name=copiasmismoitem value=Y"+chk+"></td>"
				    break
				case "15":
    				html+="<input type=text name=fecha_u value=\""+cell[c]+"\" size=8> En formato ISO (YYYYMMAA)</td>"
    				break
    			case "16":
    				html+="<input type=text name=fecha_i value=\""+cell[c]+"\" size=8> En formato ISO (YYYYMMAA)</td>"
    				break
				case "17":
					chk=""
					if (cell[17]=="Y") chk=" checked"
				    html+="<input type=checkbox name=infadicional value=Y"+chk+"></td>"
				    break
				case "18":
    				html+="<input type=text name=waiting_i value=\""+cell[c]+"\" size=2></td>"
    				break
    		}
            html+="</tr>"
    	}
    	elem.innerHTML = html+"</table>"
    	elem = document.getElementById("acciones")
    	elem.innerHTML = "<a href=javascript:Aceptar_Item("+index+")><img src=../dataentry/img/aceptar.gif height=15 align=middle><?php echo $msgstr["acc_changes"]?></a>&nbsp &nbsp; <a href=javascript:Cancelar()><img src=../dataentry/img/toolbarCancelEdit.png align=middle><?php echo $msgstr["can_changes"]?></a>"

	}

	function Redraw_Table(){		Editar="N"   //PARA DARLE OTRO SENTIDO AL BOTÓN REGRESAR
    	elem = document.getElementById("type_e");
    	html='<br><table class="listTable" border=0 width=100%>';
    	for (var c in RT_A){    		html+= "<th>"+RT_A[c]+"</th>"
    	}

    	for (i=0;i<item.length;i++){
            sel=item[i]

            if (Trim(sel)!="" && sel!="undefined"){	            html+="<tr onmouseover=\"this.className = 'rowOver';\" onmouseout=\"this.className = '';\">"
		    	cell=sel.split('|')
		    	for (var c in cell){

		    		switch (c){
		    			case "0":
		    				html+="<td width=100><a href=javascript:Eliminar("+i+")><img src=../dataentry/img/cancelar.gif border=0 height=10 alt='<?PHP echo $msgstr["delete"]?>' title='<?PHP echo $msgstr["delete"]?>'></a>"
		    				html+=" <a href=javascript:Agregar("+i+")><img src=../dataentry/img/add.gif border=0 height=10 alt='<?PHP echo $msgstr["crear"]?>' title='<?PHP echo $msgstr["crear"]?>'><a href=javascript:Editar_Tabla("+i+")>"+TI[cell[c]]+" ("+cell[c]+")</a></td>\n"
		    				break
		    			case "1":
		    				html+="<td>"+TU[cell[c]]+" ("+cell[c]+")</td>\n"
		    				break
		    			case "2":
		    			case "3":
		    			case "4":
		    			case "6":
		    			case "7":
		    			case "8":
		    			case "9":
		    			case "10":
		    			case "15":
		    			case "16":
		    			case "18":
		    				html+="<td>"+cell[c]+"</td>"
		    				break
		  				case "11":
		    				chk=""
							if (cell[11]=="Y") chk="Y"
						    html+="<td>"+chk+"</td>"
						    break
						case "5":
							unidad=""
							if (cell[c]=="D") unidad="<?php echo $msgstr["days"]?>"
							if (cell[c]=="H") unidad="<?php echo $msgstr["hours"]?>"
							html+="<td>"+unidad+"</td>"
		    				break
		  				case "11":
							chk=""
							if (cell[11]=="Y") chk="Y"
						    html+="<td>"+chk+"</td>"
						    break;
						case "12":
							chk=""
							if (cell[12]=="Y") chk="Y"
						    html+="<td>"+chk+"</td>"
						    break;
						case "13":
							chk=""
							if (cell[13]=="Y") chk="Y"
						    html+="<td>"+chk+"</td>"
						    break
						case "14":
							chk=""
							if (cell[14]=="Y") chk="Y"
						    html+="<td>"+chk+"</td>"
						    break
						case "17":
							chk=""
							if (cell[17]=="Y") chk="Y"
						    html+="<td>"+chk+"</td>"
						    break
		    		}
                }
	    	}
	    	html+="</tr>"
	  	}
    	elem.innerHTML = html+"</table>"
    	elem = document.getElementById("acciones");
        html="<a href=javascript:Enviar()><img src=../dataentry/img/barSave.png align=middle><?php echo $msgstr["update"]?></a>&nbsp; &nbsp; &nbsp; &nbsp;"
    	html+="<a href=configure_menu.php?encabezado=s><img src=../dataentry/img/toolbarCancelEdit.png align=middle><?php echo $msgstr["cancel"]?></a></td></tr>"
        elem.innerHTML = html

	}

	function Enviar(){
		ValorCapturado=""		for (i=0;i<item.length;i++){
            ValorCapturado+=item[i]+"\n"
  		}
  		document.forma2.ValorCapturado.value=escape(ValorCapturado)
  		document.forma2.submit()
	}

/**
 * DHTML date validation script. Courtesy of SmartWebby.com (http://www.smartwebby.com/dhtml/)
 */
// Declaring valid date character, minimum year and maximum year
var dtCh= "/";
var minYear=1900;
var maxYear=2100;

function isInteger(s){
	var i;
    for (i = 0; i < s.length; i++){
        // Check that current character is number.
        var c = s.charAt(i);
        if (((c < "0") || (c > "9"))) return false;
    }
    // All characters are numbers.
    return true;
}

function stripCharsInBag(s, bag){
	var i;
    var returnString = "";
    // Search through string's characters one by one.
    // If character is not in bag, append to returnString.
    for (i = 0; i < s.length; i++){
        var c = s.charAt(i);
        if (bag.indexOf(c) == -1) returnString += c;
    }
    return returnString;
}

function daysInFebruary (year){
	// February has 29 days in any year evenly divisible by four,
    // EXCEPT for centurial years which are not also divisible by 400.
    return (((year % 4 == 0) && ( (!(year % 100 == 0)) || (year % 400 == 0))) ? 29 : 28 );
}
function DaysArray(n) {
	for (var i = 1; i <= n; i++) {
		this[i] = 31
		if (i==4 || i==6 || i==9 || i==11) {this[i] = 30}
		if (i==2) {this[i] = 29}
   }
   return this
}

function isDate(dtStr){
	var daysInMonth = DaysArray(12)
	var pos1=dtStr.indexOf(dtCh)
	var pos2=dtStr.indexOf(dtCh,pos1+1)
	var strMonth=dtStr.substring(0,pos1)
	var strDay=dtStr.substring(pos1+1,pos2)
	var strYear=dtStr.substring(pos2+1)
	strYr=strYear
	if (strDay.charAt(0)=="0" && strDay.length>1) strDay=strDay.substring(1)
	if (strMonth.charAt(0)=="0" && strMonth.length>1) strMonth=strMonth.substring(1)
	for (var i = 1; i <= 3; i++) {
		if (strYr.charAt(0)=="0" && strYr.length>1) strYr=strYr.substring(1)
	}
	month=parseInt(strMonth)
	day=parseInt(strDay)
	year=parseInt(strYr)
	if (pos1==-1 || pos2==-1){
		alert("The date format should be : mm/dd/yyyy")
		return false
	}
	if (strMonth.length<1 || month<1 || month>12){
		alert("Please enter a valid month")
		return false
	}
	if (strDay.length<1 || day<1 || day>31 || (month==2 && day>daysInFebruary(year)) || day > daysInMonth[month]){
		alert("Please enter a valid day")
		return false
	}
	if (strYear.length != 4 || year==0 || year<minYear || year>maxYear){
		alert("Please enter a valid 4 digit year between "+minYear+" and "+maxYear)
		return false
	}
	if (dtStr.indexOf(dtCh,pos2+1)!=-1 || isInteger(stripCharsInBag(dtStr, dtCh))==false){
		alert("Please enter a valid date")
		return false
	}
return true
}

function ValidarFecha(Fecha){
	if (isDate(Fecha)==false){
		return false
	}
    return true
 }

 function Verificar(){
 	switch (Editar){ 		case "Y":
			Cancelar()
 			break
 		case "N":
 			self.location.href="configure_menu.php?encabezado=s"
 			break; 	} }


</script>
<?php
$encabezado="";
include("../common/institutional_info.php");
echo "
		<div class=\"sectionInfo\">
			<div class=\"breadcrumb\">".
				$msgstr["typeofitems"]."
			</div>
			<div class=\"actions\">\n";

				echo "<a href=javascript:Verificar() class=\"defaultButton backButton\">
					<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
					<span><strong>". $msgstr["cancel"]."</strong></span>
				</a>
			</div>
			<div class=\"spacer\">&#160;</div>
		</div>
		<div class=\"helper\">
	<a href=../documentacion/ayuda.php?help=".$_SESSION["lang"]."/circulation/policy.html target=_blank>".$msgstr["help"]."</a>&nbsp &nbsp;";
	if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
		echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/circulation/policy.html target=_blank>".$msgstr["edhlp"]."</a>";
	echo "<font color=white>&nbsp; &nbsp; Script: loanobjects.php </font>";

echo"</div>
		<div class=\"middle form\">
			<div class=\"formContent\">";

?>

    <form name=forma1>
  	<a href="javascript:NuevoTipo()" ><?php echo $msgstr["crear"]?></a>
    <div id=type_e class="middle list"> </div>
    <p>
    <div id=acciones>
    <a href=javascript:Enviar()><?php echo $msgstr["update"]?></a>&nbsp; &nbsp; &nbsp; &nbsp;
    <a href=configure_menu.php?encabezado=s><?php echo $msgstr["cancel"]?></a>
    </div>


</form>
<form name=forma2 action=loanobjects_update.php method=post>
<input type=hidden name=ValorCapturado>
<input type=hidden name=desc>
<input type=hidden name=Opcion value=>
<input type=hidden name=base value=users>
<?php if (isset($arrHttp["encabezado"])) echo "<input type=hidden name=encabezado value=S>"; ?>
</form>



<?php

echo "</div></div>";
include("../common/footer.php");
echo "</body></html>
<script>
	Redraw_Table()
</script>" ;

?>