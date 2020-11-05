<?php

$path="../";
include("config_opac.php");
include("leer_bases.php");
include("tope.php");
if (!isset($_REQUEST["prefijoindice"]) or $_REQUEST["prefijoindice"]=="") $_REQUEST["prefijoindice"]=$_REQUEST["prefijo"];
//foreach ($_REQUEST as $var=>$value) echo "$var=$value<br>";
$index_alfa=array();
if (is_dir($db_path."opac_conf/alpha/$charset")){
	$handle=opendir($db_path."opac_conf/alpha/$charset");
	while (false !== ($entry = readdir($handle))) {
		if (!is_file($db_path."opac_conf/alpha/$charset/$entry")) continue;
		$file = basename($entry, ".tab");
		$index_alfa[]=$file;
	}
}

if (!isset($_REQUEST["modo"]) or $_REQUEST["modo"]!="integrado"){
 	if (isset($_REQUEST["base"]) and $_REQUEST["base"]!=""){
 		if (file_exists($db_path."opac_conf/".$_REQUEST["lang"]."/".$_REQUEST["base"].".lang")){
 			$index_alfa=array();
 			$fp=file($db_path."opac_conf/".$_REQUEST["lang"]."/".$_REQUEST["base"].".lang");
 			foreach ($fp as $lang_val){
 				$l=explode('|',$lang_val);
 				foreach ($l as $xxl)
 					$index_alfa[]=$xxl;
 			}
 		}
 	}
}
$terminos=array();
?>
<script language=JavaScript>
<?php
if (count($index_alfa)>0){
	$primer_indice=$index_alfa[0];
}else{
	$primer_indice="";
}
?>
primer_indice="<?php echo $primer_indice?>"
		function CambiarAlfabeto(){
			ilen=document.iraFrm.alfabeto.options.length
			for (ix=0;ix<ilen;ix++){
				Ctrl=document.getElementById(ix)
				Ctrl.style.display="none"

			}
			ix=document.iraFrm.alfabeto.selectedIndex
			alpha_sel=document.iraFrm.alfabeto.options[ix].value
			document.indiceAlfa.alfa.value=alpha_sel
			Ctrl=document.getElementById(ix)
			Ctrl.style.display="block"
		}
		function Localizar(Expresion,Existencias){
			Expr=Expresion.split('$#$')
			document.indiceAlfa.Sub_Expresion.value=Expresion
			document.indiceAlfa.letra.value=primero
			document.indiceAlfa.Opcion.value="detalle"
			document.indiceAlfa.action="buscar_integrada.php"
			document.indiceAlfa.Existencias.value=Existencias
			document.indiceAlfa.submit()
		}

		function IrA(){
			ix=document.iraFrm.coleccion.selectedIndex
            tipologia=""
			if (ix>-1){
				tipologia=document.iraFrm.coleccion.options[ix].value
			}
			//document.indiceAlfa.coleccion.value=tipologia
			Indice(document.iraFrm.ira.value)
		}

		function AbrirVentana(Nombre) {
    		msgwin=window.open("",Nombre,"status=yes,resizable=yes,toolbar=no,menu=yes,scrollbars=yes,width=750,height=400,top=10,left=0")
    		msgwin.focus()
		}
		function ContinuarIndice(){
			Indice(ultimo)
		}

		function Indice(Letra){

			if (Letra==""){
				Letra=document.buscar.Expresion.value
			}

			re= / /gi
			//Letra=escape(Letra)
			document.indiceAlfa.letra.value=Letra
			document.indiceAlfa.submit()
		}
	</script>
	<form name=iraFrm onSubmit="IrA();return false" method=post>
	<input type=hidden name=titulo value="<?php echo $_REQUEST["titulo"]?>">
<?php
if (isset($_REQUEST["Formato"])) echo "<input type=hidden name=Formato value=\"".$_REQUEST["Formato"]."\">\n";
if (isset($_REQUEST["db_path"])) echo "<input type=hidden name=db_path value=\"".$_REQUEST["db_path"]."\">\n";
if (isset($_REQUEST["lang"])) echo "<input type=hidden name=lang value=\"".$_REQUEST["lang"]."\">\n";
if (!isset($_REQUEST["Opcion"])) $_REQUEST["Opcion"]="";
if (isset($_REQUEST["prefijoindice"]) and $_REQUEST["Opcion"]!="fecha"){
	$Prefijo=$_REQUEST["prefijoindice"];
	include("mostrar_indice.php");
}
echo "<br><div id=\"indices\" style=\"width:90%\">";
echo "<span class=tituloBase><strong>".$_REQUEST["titulo"]."</strong></span><br><br>";
$alfa_actual=$_REQUEST["titulo"];
$ixc=count($terminos);
echo "<table id=\"tabla_indices\"  border=0><td>".$msgstr["ira"];

if (count($index_alfa)>1){
   	echo "<select name=alfabeto onchange=CambiarAlfabeto()>\n";
	foreach ($index_alfa as $alfabeto){
		if (isset($_REQUEST["alfa"]) and $_REQUEST["alfa"]==$alfabeto){
			$selected=" selected";
		}else{
			$selected="";
		}
		echo "<option value=\"$alfabeto\" $selected>$alfabeto</option>\n";
	}
	echo "</select><br>";
 }
 	echo "<div id=collation name=collation style=\"position:relative;\">";
 	$ixndiv=-1;
	foreach ($index_alfa as $alfabeto){
		$ixndiv=$ixndiv+1;
		if (isset($_REQUEST["alfa"]) and $_REQUEST["alfa"]==$alfabeto)
			$display="block";
		else
			$display="none";
	  	echo "<div id=$ixndiv style=\"margin-top:10px;display:$display;\">";
		$file_al=file($db_path."opac_conf/alpha/$meta_encoding/".$alfabeto.".tab");
		foreach ($file_al as $l_ix){
			$l_ix=trim($l_ix);
			echo "<a href=\"javascript:Indice('$l_ix')\">$l_ix</a> ";
			echo "  ";
		}
		echo "</div>";
	}
	if (count($index_alfa)==0){
  		$file_al=array("0-9","A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
		foreach ($file_al as $l_ix){
			$l_ix=trim($l_ix);
			echo "<a href=\"javascript:Indice('$l_ix')\">$l_ix</a> ";
			echo "  ";
		}
	}
	echo "</div>";
   echo "</td></tr>" ;
    echo "<tr><td><input type=text name=ira size=15><a href=javascript:IrA()><Img src=../images/lupa.gif border=0></a></font></td>";

$comp="XXXXX";
$cuenta=0;
if (file_exists($db_path."opac_config/xxcolecciones.tab")){
	echo "<tr><td align=right>Filtrar por colección: </td>";
		echo "<td><xselect name=coleccion onchange='javascript:document.buscar.Expresion.value=\"\";IrA();'>
		<option value=''></option>\n";
		$fp=file($path."data/".$_REQUEST["lang"]."/colecciones.tab");
       	foreach ($fp as $value){
       	echo "$value<br>";
       		$value=trim($value);
       		if ($value!=""){
       			$v=explode('|',$value);
       			echo "<option value='".$value."'";
       			if (isset($_REQUEST["coleccion"]) and $value==$_REQUEST["coleccion"]) echo " selected";
       			echo ">".$v[1]."</option>\n";
       		}
       	}
  	echo "</select>";
     echo "</span></td></tr>";
}else{
	echo "<input type=hidden name=coleccion>";
}
echo "

    </table>
    <hr>
    <p>
    </div>
</form>";
if ($ixc>0 ){
    $prefijo=$_REQUEST["prefijoindice"];
	echo "<table width=100% align=center border=0><td ";
	if ($_REQUEST["columnas"]==2) echo "width=50%";
	echo " valign=top>";
	$cuenta=-1;
	$tope=count($terminos);
	$nfilas=$tope;
	$cuenta=0;
	echo "<ul>";
	$primeraVez="S";
	$total_terminos=0;
	foreach ($terminos as $key=>$linea){
		//echo "$key=>$linea<br>";
		$total_terminos=$total_terminos+1;
		//if ($total_terminos>200) break;
		$cuenta++;
		$linea=trim($linea);
		$a=explode('|$$|',$linea);
		$b=explode('$$$',$a[0]);
		$c=explode('$$$',$a[1]);
		if ($primeraVez=="S") {
			$primerTermino=$c[1];
			$primeraVez="N";
		}
		$UltimoTermino=$c[1];
		$Expresion=$c[1];
		$Expresion=str_replace(" ","+",$Expresion);
		$Expresion=str_replace("&",urlencode("&"),$Expresion);
		$ixpos=strpos($Expresion,'|');
		if ($ixpos>0) {
		    $Expresion=substr($Expresion,$ixpos+1);
		}
		if ($Expresion!=""){
			$titulo=explode("_",$Expresion,2);
			if (isset($titulo[1]))
				$titulo=$titulo[1];
			else
				$titulo="";
			$prefijo=$_REQUEST["prefijoindice"];
			$prefijoindice=$_REQUEST["prefijoindice"];
			$coleccion="";
			if (isset($_REQUEST["coleccion"]))
				$coleccion=$_REQUEST["coleccion"];
			$titulo=$_REQUEST["titulo"];
			$columnas=$_REQUEST["columnas"];
            //$Expresion=substr($Expresion,strlen($prefijo));
            if (isset($a[2]))
            	$Existencias=$a[2];
            else
            	$Existencias="";
            $Expresion=substr($Expresion,strlen($prefijo));
			$url="<li><a href=javascript:Localizar(\"$Expresion\",\"$Existencias\")>";
			echo	"$url"."<font color=black>".trim($b[0]);
			if ($prefijo!="TI_"){
				if (isset($postings[$key]) and !isset($a[2]) ) {
					echo "&nbsp;&nbsp;<font size=-1><i>[".$postings[$key]."]</i></font>";
				}

			}

			echo "</a>";
			echo "</font></li>\n";
        }
		if ($_REQUEST["columnas"]==2){
			if ($cuenta>=$tope/2) {
				echo "</ul></td><td width=50% valign=top><ul>";
				$cuenta=0;
			}
		}
	}
	echo "</ul>";
	echo "</table><p><center><a href=javascript:history.back()><img src=../images/retroceder.gif border=0  valign=middle></a> &nbsp; &nbsp;";
	echo "&nbsp; <a href=javascript:ContinuarIndice()><img src=../images/avanzar.gif border=0  valign=middle></a>";
echo "</td></table>
					</td>
</table>

</form>
<script>
ultimo='";
//$UltimoTermino=substr($mayorclave,strlen($_REQUEST["prefijo"]));
$prefijo=$_REQUEST["prefijoindice"];


echo urlencode(substr($UltimoTermino,strlen($prefijo)));
//echo $UltimoTermino;
echo "'
primero='";
echo urlencode(substr($primerTermino,strlen($prefijo)));
echo "'
</script>

";
}
?>

<?php include("footer.php")?>
<form name=indiceAlfa method=post action=alfabetico.php>
<input type=hidden name=alfa value="<?php if (isset($_REQUEST["alfa"]) and $_REQUEST["alfa"]!="") echo $_REQUEST["alfa"]?>">
<input type=hidden name=titulo value="<?php echo $_REQUEST["titulo"]?>">
<input type=hidden name=columnas value="<?php echo $_REQUEST["columnas"]?>">
<input type=hidden name=Opcion value="<?php echo $_REQUEST["Opcion"]?>">
<input type=hidden name=count value="25">
<input type=hidden name=posting value="<?php echo $_REQUEST["posting"]?>">
<input type=hidden name=prefijo value="<?php echo $_REQUEST["prefijo"]?>">
<input type=hidden name=prefijoindice value="<?php echo $_REQUEST["prefijo"]?>">
<input type=hidden name=ira value="<?php if (isset($_REQUEST["ira"])) echo $_REQUEST["ira"]?>">
<input type=hidden name=Expresion>
<input type=hidden name=Sub_Expresion>
<input type=hidden name=letra value="<?php echo str_replace($_REQUEST["prefijo"],'',$primero) ?>">
<input type=hidden name=Existencias>
<input type=hidden name=coleccion value="<?php if (isset($_REQUEST["coleccion"])) echo $_REQUEST["coleccion"]?>">
<input type=hidden name=lang value="<?php if (isset($_REQUEST["lang"])) echo $_REQUEST["lang"]?>">
<?php
if (isset($_REQUEST["base"]))  	echo "<input type=hidden name=base value=".$_REQUEST["base"].">\n";
if (isset($_REQUEST["indice_base"]))  echo "<input type=hidden name=indice_base value=".$_REQUEST["indice_base"].">\n";
if (isset($_REQUEST["cipar"])) echo "<input type=hidden name=cipar value=".$_REQUEST["cipar"].">\n";
if (isset($_REQUEST["modo"])) echo "<input type=hidden name=modo value=".$_REQUEST["modo"].">\n";
if (isset($_REQUEST["Formato"])) echo "<input type=hidden name=Formato value=\"".$_REQUEST["Formato"]."\">\n";
if (isset($_REQUEST["db_path"])) echo "<input type=hidden name=db_path value=\"".$_REQUEST["db_path"]."\">\n";
if (isset($_REQUEST["lang"])) echo "<input type=hidden name=lang value=\"".$_REQUEST["lang"]."\">\n";
?>
</form>
<?php if (!isset($_REQUEST["alfa"]) or $_REQUEST["alfa"]==""){
?>

<script>
	Ctrl=document.getElementById("0")
	Ctrl.style.display="block"
	Ctrl=document.getElementById("collation")
	Ctrl.style.display="block"
</script>
<?php } ?>