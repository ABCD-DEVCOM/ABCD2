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
$rows_title[2]=$msgstr["reserve_tit_1"];
$rows_title[3]=$msgstr["reserve_tit_2"];
$rows_title[4]=$msgstr["reserve_tit_3"];


$rows_title_a[0]=$msgstr["tit_tm_a"];
$rows_title_a[1]=$msgstr["tit_tu_a"];
$rows_title_a[2]=$msgstr["reserve_tit_1"];
$rows_title_a[3]=$msgstr["reserve_tit_2"];
$rows_title_a[4]=$msgstr["reserve_tit_3"];


$archivo= $db_path."circulation/def/".$_SESSION["lang"]."/typeofusers.tab";
if (!file_exists($archivo))  $archivo=$db_path."circulation/def/".$lang_db."/typeofusers.tab";
if (file_exists($archivo)){
	$fp=file($archivo);
}else{
	$fp[0]='||||';

}
foreach ($fp as $value){	$value=trim($value);	if ($value!=""){		$t=explode('|',$value);
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
$file=$db_path."circulation/def/".$_SESSION["lang"]."/reserve.tab";
if (!file_exists($file))  $file=$db_path."circulation/def/".$lang_db."/reserve.tab";

if (file_exists($file)){
	$fp_items=file($file);
}else{
	$fp_items=array();
	$fp_items[0]='||||';
}
// Se crea el arreglo con la lista de objetos
echo "
<script>
var item=new Array()
";
$ix=-1;
foreach ($fp_items as $value) {	if (trim($value)!=""){
		$ix=$ix+1;
		echo "
		item[$ix]=\"".trim($value)."\"\n" ;
	//	echo "item[$ix][1]=\"".$type_items[$Ti[0]]." - ".$Ti[1]."\"\n";
    }
}
echo "tot_item=$ix\n";
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

    function NuevoTipo(){       	sel="||||||||||||||||||||||"
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
		item.splice(index,0,"||||||||||||||||||||||||")
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



    	x=Trim(document.forma1.nr.value)
    	if (x==""){    		alert("<?php echo $msgstr["falta"].$rows_title[2]?>")
    		return    	}
    	xItem+='|'+x

		x=Trim(document.forma1.waiting.value)
    	if (x==""){
    		alert("<?php echo $msgstr["falta"].$rows_title[3]?>")
    		return
    	}
    	xItem+='|'+x

    	if (document.forma1.res_loaned.checked)
    		x="Y"
    	else
    		x=""
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
	function Redraw(sel,index){    	elem = document.getElementById("type_e");
    	html='<p><br><table class="listTable" width=10>';
    	cell=sel.split('|')
    	for (var c in RT){
    		html+="<tr onmouseover=\"this.className = 'rowOver';\" onmouseout=\"this.className = '';\"><td>"+RT[c]+"</td><td>"
    		switch (c){    			case "0":
    				html+="<select name=tipo_m>\n"
    				for (a in TI){
    					selected=""
    					if (cell[c]==a) selected=" selected"    					html+="<option value=\""+a+"\""+selected+">"+TI[a]    				}
    				html+="</select></td>"
    				break
    			case "1":
    				html+="<select name=tipo_u>\n"
    				for (a in TU){
    					selected=""
    					if (cell[c]==a) selected=" selected"
    					html+="<option value=\""+a+"\""+selected+">"+TU[a]
    				}
    				html+="</select></td>"
    				break
    			case "2":
    				html+="<input type=text name=nr value=\""+cell[c]+"\"></td>"
    				break
    			case "3":
    				html+="<input type=text name=waiting value=\""+cell[c]+"\"></td>"
    				break
    			case "4":
    				chk=""
					if (cell[c]=="Y") chk=" checked"
    				html+="<input type=checkbox name=res_loaned value=\"Y\" "+chk+"></td>"
    				break
    		}
            html+="</tr>"
    	}
    	elem.innerHTML = html+"</table>"
    	elem = document.getElementById("acciones")
    	elem.innerHTML = "<a href=javascript:Aceptar_Item("+index+")>Aceptar</a>&nbsp &nbsp; <a href=javascript:Cancelar()>Cancelar</a>"

	}

	function Redraw_Table(){
    	elem = document.getElementById("type_e");
    	html='<br><table class="listTable" border=1 width=100%>';
    	for (var c in RT_A){    		html+= "<th>"+RT_A[c]+"</th>"
    	}
    	for (i=0;i<item.length;i++){
            sel=item[i]
            if (Trim(sel)!=""){
	            html+="<tr onmouseover=\"this.className = 'rowOver';\" onmouseout=\"this.className = '';\">"
		    	cell=sel.split('|')
		    	for (var c in cell){

		    		switch (c){
		    			case "0":
		    				html+="<td width=100><a href=javascript:Eliminar("+i+")><img src=../dataentry/img/cancelar.gif border=0 height=10 alt='<?PHP echo $msgstr["delete"]?>'></a>"
		    				html+=" <a href=javascript:Agregar("+i+")><img src=../dataentry/img/add.gif border=0 height=10 alt='<?PHP echo $msgstr["crear"]?>'><a href=javascript:Editar_Tabla("+i+")>"+TI[cell[c]]+" ("+cell[c]+")</a></td>\n"
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
		html="<a href=javascript:Enviar()><?php echo $msgstr["update"]?></a>&nbsp; &nbsp; &nbsp; &nbsp;"
    	html+="<a href=configure_menu.php?encabezado=s><?php echo $msgstr["cancel"]?></a>"
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


</script>
<?php
$encabezado="";
include("../common/institutional_info.php");
echo "
		<div class=\"sectionInfo\">
			<div class=\"breadcrumb\">".
				$msgstr["reservepolicy"]."
			</div>
			<div class=\"actions\">\n";

				echo "<a href=\"../circulation/configure_menu.php?encabezado=s\" class=\"defaultButton backButton\">
					<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
					<span><strong>". $msgstr["back"]."</strong></span>
				</a>
			</div>
			<div class=\"spacer\">&#160;</div>
		</div>
		<div class=\"helper\">
	<a href=../documentacion/ayuda.php?help=".$_SESSION["lang"]."/circulation/reserve_policy.html target=_blank>".$msgstr["help"]."</a>&nbsp &nbsp;";
	if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
		echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/circulation/reserve_policy.html target=_blank>".$msgstr["edhlp"]."</a>";
	echo "<font color=white>&nbsp; &nbsp; Script: reserve/policy.php </font>";

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
<form name=forma2 action=policy_update.php method=post>
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