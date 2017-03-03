<?php
session_start();
if (!isset($_SESSION["login"])){
	echo "La sesión expiró o Ud. no tiene permiso para acceder a este módulo";
	die;
}
include("../config.php");


include("../common/get_post.php");

$rows_title[0]="Tipo de material";
$rows_title[1]="Tipo de usuario";
$rows_title[2]="Reservas permitidas";
$rows_title[3]="Tiempo espera (si disponible)";
$rows_title[4]="Tiempo espera (si prestado)";

$rows_title_a[0]="T.Mat";
$rows_title_a[1]="T.Usuar";
$rows_title_a[2]="Res.Perm.";
$rows_title_a[3]="Espera ( si disp.)";
$rows_title_a[4]="Espera (si prest.)";

$archivo= $db_path."/reserva/tablas/usuarios.tab";
if (file_exists($archivo)){
	$fp=file($archivo);
}else{
	$fp[0]='||';

}
foreach ($fp as $value){	$value=trim($value);	if ($value!=""){		$t=explode('|',$value);
		if (!isset($t[1]) or trim($t[1]=="")) $t[1]=$t[0];
		$type_users[$t[0]]=$t[1];
	}}
unset($fp);
$archivo=$db_path."/reserva/tablas/materiales.tab";
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

$file=$db_path."/reserva/tablas/politicas.tab";
if (file_exists($file)){
	$fp=file($file);
}else{
	$fp=array();
	for ($i=0;$i<20;$i++){
		$fp[$i]='||||||||||';
	}
	$tope=20;
}
include("../common/header.php");
?>
		<script>
			var item=new Array()
			var RT=new Array()
			var RT_A=new Array()
			var TU=new Array()
			var TI=new Array()

<?php
// Se crea el arreglo con la lista de objetos

$ix=-1;
foreach ($fp as $value) {
	if (trim($value!="")){
		$ix++;
		echo "item[$ix]=\"".trim($value)."\"\n";
    }
}
foreach ($rows_title as $var=>$value){	echo "RT['$var']='$value'\n";}

foreach ($rows_title_a as $var=>$value){
	echo "RT_A['$var']='$value'\n";
}

foreach  ($type_users as $var=>$value){	echo "TU['$var']=\"$value\"\n";}
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



    	x=Trim(document.forma1.np_p.value)
    	if (x==""){    		alert("Falta <?php echo $rows_title[2]?>")
    		return    	}
    	xItem+='|'+x

		x=Trim(document.forma1.lapsop_n.value)
    	if (x==""){
    		alert("Falta <?php echo $rows_title[3]?>")
    		return
    	}
    	xItem+='|'+x

    	x=Trim(document.forma1.lapsop_r.value)
    	if (x==""){
  //  		alert("Falta <?php $rows_title[4]?>")
  //  		return
    	}
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
        alert(xItem)
        Cancelar()
        Redraw_Table()
    }
	function Redraw(sel,index){    	elem = document.getElementById("type_e");
    	html='<p><br><table>';
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
    				html+="<input type=text name=np_p value=\""+cell[c]+"\"></td>"
    				break
    			case "3":
    				html+="<input type=text name=lapsop_n value=\""+cell[c]+"\"></td>"
    				break
    			case "4":
    				html+="<input type=text name=lapsop_r value=\""+cell[c]+"\"></td>"
    				break
    		}
            html+="</tr>"
    	}
    	elem.innerHTML = html+"</table>"
    	elem = document.getElementById("acciones")
    	elem.innerHTML = "<a href=javascript:Aceptar_Item("+index+") class=boton>Aceptar</a>&nbsp &nbsp; <a href=javascript:Cancelar() class=boton>Cancelar</a>"

	}

	function Redraw_Table(){
    	elem = document.getElementById("type_e");
    	html='<br><table class="listTable" border=1 width=800>';
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
		    				html+="<td><a href=javascript:Eliminar("+i+")><img src=../../imagenes/cancelar.gif border=0 height=10 alt='Eliminar'></a>"
		    				html+=" <a href=javascript:Agregar("+i+")><img src=../../imagenes/add.gif border=0 height=10 alt='Crear'><a href=javascript:Editar_Tabla("+i+")>"+TI[cell[c]]+"</a></td>\n"
		    				break
		    			case "1":
		    				html+="<td>"+TU[cell[c]]+"&nbsp;</td>\n"
		    				break
		    			case "2":
		    			case "3":
		    			case "4":
		    				html+="<td align=center>"+cell[c]+"&nbsp;</td>"
		    				break
		    		}
                }
	    	}
	    	html+="</tr>"
	  	}
    	html+="<tr><td colspan=5 align=center>"
		html+="<a href=javascript:Guardar() class=boton>Guardar</a>&nbsp; &nbsp; &nbsp; &nbsp;"
    	html+="<a href=inicio.php?Opcion=continuar class=boton>Menú</a>"
        html+="</td></table><p>"
        elem.innerHTML = html

	}

	function Guardar(){
		ValorCapturado=""		for (i=0;i<item.length;i++){
            ValorCapturado+=item[i]+"\n"
  		}
  		alert(ValorCapturado)
  		document.forma2.ValorCapturado.value=ValorCapturado
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
<body>
    <form name=forma1>
    <div id=type_e class="middle list"> </div>
    <p>
    <div id=acciones>
    </div>


</form>
<form name=forma2 action=politicas_guardar.php method=post>
<input type=hidden name=ValorCapturado>
</form>



<?php

echo "</body></html>
<script>
	Redraw_Table()
</script>" ;

?>