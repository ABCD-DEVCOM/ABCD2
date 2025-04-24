<?php
/**
 * 20250402 rogercgui altera o local de verificação de alfabetos disponívels para a pasta da base de dados. Linha 26.
 * 
 * 
 */


$scptpath="../";
//include("../head.php");

if (!isset($_REQUEST["prefijoindice"]) or $_REQUEST["prefijoindice"]=="") $_REQUEST["prefijoindice"]=$_REQUEST["prefijo"];
//foreach ($_REQUEST as $var=>$value) echo "$var=$value<br>";
$index_alfa=array();
if (is_dir($db_path."opac_conf/alpha/$meta_encoding")){
	$handle=opendir($db_path."opac_conf/alpha/$meta_encoding");
	while (false !== ($entry = readdir($handle))) {
		if (!is_file($db_path."opac_conf/alpha/$meta_encoding/$entry")) continue;
		$file = basename($entry, ".tab");
		$index_alfa[]=$file;
	}
}

if (!isset($_REQUEST["modo"]) or $_REQUEST["modo"]!="integrado"){
 	if (isset($_REQUEST["base"]) and $_REQUEST["base"]!=""){
		$file_lang=$db_path.$_REQUEST["base"]."/opac/".$_REQUEST["lang"]."/".$_REQUEST["base"].".lang";
		$fp=file($file_lang);
 		if (file_exists($file_lang)){
 			$index_alfa=array();
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

<script language="JavaScript">

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

<form name="iraFrm" onSubmit="IrA();return false" method="post">
		<input type="hidden" name="titulo" value="<?php echo $_REQUEST["titulo"]?>">
		<input type="hidden" name="page" value="startsearch">
		<?php
			if (isset($_REQUEST["Formato"])) echo "<input type=hidden name=Formato value=\"".$_REQUEST["Formato"]."\">\n";
			if (isset($_REQUEST["db_path"])) echo "<input type=hidden name=db_path value=\"".$_REQUEST["db_path"]."\">\n";
			if (isset($_REQUEST["lang"])) echo "<input type=hidden name=lang value=\"".$_REQUEST["lang"]."\">\n";
			if (!isset($_REQUEST["Opcion"])) $_REQUEST["Opcion"]="";
			if (isset($_REQUEST["prefijoindice"]) and $_REQUEST["Opcion"]!="fecha"){
				$Prefijo=$_REQUEST["prefijoindice"];
				include("mostrar_indice.php");
			}
		?>

<div id="indices">

<h6 class="text-dark"><?php echo $_REQUEST["titulo"]?></h6>

<?php
$alfa_actual=$_REQUEST["titulo"];
$ixc=count($terminos);
?>


<div class="container">

<?php if (count($index_alfa)>1){ ?>

   	<select class="form-select" name="alfabeto" onchange="CambiarAlfabeto()" id="floatingSelect"	>
	<?php
		foreach ($index_alfa as $alfabeto){
			if (isset($opac_gdef["ALPHABET"]) and $opac_gdef["ALPHABET"]==$alfabeto){
				$selected=" selected";
				$display="block";
			}else{
				$selected="";
				$display="none";
			}
			echo "<option value=\"$alfabeto\" $selected>$alfabeto</option>\n";
		}
	?>
	</select>
	<label  for="floatingSelect"><?php echo $msgstr["front_ira"];?></label>

</div>

<?php  } ?>

 	<div id="collation" name="collation" style=\"position:relative;\" class="row py-3">

	<?php
	$ixndiv=-1;
	foreach ($index_alfa as $alfabeto){
		$ixndiv=$ixndiv+1;
		if (isset($_REQUEST["alfa"]) and (isset($opac_gdef["ALPHABET"])) and $opac_gdef["ALPHABET"]==$alfabeto)
			$display="block";
		else
			$display="none";
	  	echo "<div id=$ixndiv style=\"margin-top:10px;display:$display;\">";
		$file_al=file($db_path."opac_conf/alpha/".$meta_encoding."/".$alfabeto.".tab");
		foreach ($file_al as $l_ix){
			$l_ix=trim($l_ix);
			echo "<a class=\"btn btn-outline-primary btn-sm m-1\" href=\"javascript:Indice('$l_ix')\">$l_ix</a> ";
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
	?>
	</div>


<div class="row py-3">
	<div class="col-md-8">
		<input class="form-control" type="text" name="ira" size="15">
	</div>

	<div  class="col-md-4">
		<a class="btn btn-success" href="javascript:IrA()">
			<i class="fas fa-search"></i> <?php echo $msgstr["front_search"]?>
		</a>
	</div>
</div>

<?php
$comp="XXXXX";
$cuenta=0;

$file_collection=$db_path."opac_conf/".$_REQUEST["lang"]."/colecciones.tab";

if (file_exists($file_collection)){ ?>

	<label>Filter by collection: </label>
	<select name="coleccion" class="form-control" onchange="javascript:document.buscar.Expresion.value='';IrA();">
		<option value=''></option>
		<?php
		$fp=file($file_collection);
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
		?>
  	</select>

	<?php } else { ?>

	<input type="hidden" name="coleccion">

	<?php } ?>
 
	</div>
</form>

<?php
if ($ixc>0 ){
    $prefijo=$_REQUEST["prefijoindice"];
	
	$cuenta=-1;
	$tope=count($terminos);
	$nfilas=$tope;
	$cuenta=0;
	echo '<ul class="list-group';
	if ($_REQUEST["columnas"]==2) echo "col-md-6";
	echo '" >';

	$primeraVez="S";
	$total_terminos=0;
	foreach ($terminos as $key=>$linea){
		//echo "$key=>$linea<br>";
		$total_terminos=$total_terminos+1;
		//if ($total_terminos>200) break;
		$cuenta++;
		$linea=trim($linea);
		$a=explode('|$$|',$linea);
		$b=explode('$$$',$a[1]);
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
			$url="<li class=\"list-group-item list-group-item-action bg-light\"><a href=javascript:Localizar(\"$Expresion\",\"$Existencias\")>";
			echo	$url.substr(trim($c[1]),strlen($prefijo))   ;
			if ($prefijo!="TI_"){
				if (isset($postings[$key]) and !isset($a[2]) ) {
					echo "&nbsp;&nbsp;<font size=-1><i>[".$postings[$key]."]</i>";
				}

			}
			echo " (".$b[0].") ";
			echo "</a>";
			echo "</li>\n";
        }
		if ($_REQUEST["columnas"]==2){
			if ($cuenta>=$tope/2) {
				echo "</ul></td><td width=50% valign=top><ul class=\"list-group\">";
				$cuenta=0;
			}
		}
	}
?>
	</ul>
	</table>
	
	<a class="btn btn-outline-primary" href="javascript:history.back()">
		<i class="fas fa-angle-double-left"></i>
	</a> 
	<a class="btn btn-outline-primary" href=javascript:ContinuarIndice()>
		<i class="fas fa-angle-double-right"></i>
	</a>
	</td>
</table>

</td>
</table>

</form>

<?php
//$UltimoTermino=substr($mayorclave,strlen($_REQUEST["prefijo"]));
$prefijo=$_REQUEST["prefijoindice"];
$primero=urlencode(substr($primerTermino,strlen($prefijo)));
?>

<script>
ultimo="<?php echo urlencode(substr($UltimoTermino,strlen($prefijo)));?>";
primero="<?php echo $primero;?>";
</script>

<?php } ?>

<?php //include("footer.php")?>


<?php if (!isset($_REQUEST["alfa"]) or $_REQUEST["alfa"]==""){ ?>

<script>
	Ctrl=document.getElementById("0")
	Ctrl.style.display="block"
	Ctrl=document.getElementById("collation")
	Ctrl.style.display="block"
</script>

<?php } ?>
