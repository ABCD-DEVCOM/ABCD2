<?php
$path="../";
//include("../central/config_opac.php");
//include("leer_bases.php");
//include("head.php");



function indexes($name,$columnas,$in_prefix) { 
global $bd_list, $db_path,$xWxis, $actparfolder,$terminos,$charset,$primero;

$_REQUEST["prefijoindice"]=$in_prefix;
$_REQUEST["prefijo"]=$in_prefix;
$_REQUEST["titulo"]=$name;
$_REQUEST["columnas"]=$columnas;
$_REQUEST["posting"]=1;

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
		function LocalizarIndex(Expresion,Existencias){
			Expr=Expresion.split('$#$')
			document.indiceAlfa.Sub_Expresion.value=Expresion
			document.indiceAlfa.letra.value=primero
			document.indiceAlfa.Opcion.value="detalle"
			document.indiceAlfa.action="buscar_integrada.php"
			document.indiceAlfa.Existencias.value=Existencias
			document.indiceAlfa.submit()
			console.log(Sub_Expresion);
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




	<form name="iraFrm" onSubmit="IrA();return false" method="get">
		<input type="hidden" name="titulo" value="<?php echo $_REQUEST["titulo"]?>">
		<?php
		if (isset($_REQUEST["Formato"])) echo "<input type=hidden name=Formato value=\"".$_REQUEST["Formato"]."\">\n";
		if (isset($_REQUEST["db_path"])) echo "<input type=hidden name=db_path value=\"".$_REQUEST["db_path"]."\">\n";
		if (isset($_REQUEST["lang"])) echo "<input type=hidden name=lang value=\"".$_REQUEST["lang"]."\">\n";
		if (!isset($_REQUEST["Opcion"])) $_REQUEST["Opcion"]="";
		if (isset($_REQUEST["prefijoindice"]) and $_REQUEST["Opcion"]!="fecha"){
			$Prefijo=$_REQUEST["prefijoindice"];
			include("sidebar_indice.php");
		}
		?>








<?php
$alfa_actual=$_REQUEST["titulo"];
$ixc=count($terminos);

$comp="XXXXX";
$cuenta=0;

if ($ixc>0 ){
    $prefijo=$_REQUEST["prefijoindice"];
	$cuenta=-1;
	$tope=count($terminos);
	$nfilas=$tope;
	$cuenta=0;
	echo "<ul  class=\"list-unstyled\">";
	$primeraVez="S";
	$total_terminos=0;
	foreach ($terminos as $key=>$linea){
		//echo "$key=>$linea<br>";
		$total_terminos=$total_terminos+1;
		//IMPORTANT
		if ($total_terminos>5) break;
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
		$Expresion=str_replace('"','',$Expresion);
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
			$url="<li><a href=javascript:LocalizarIndex('$Expresion','$Existencias')>";
			echo	"$url".substr(trim($c[1]),strlen($prefijo))   ;
			if ($prefijo!="TI_"){
				if (isset($postings[$key]) and !isset($a[2]) ) {
					echo "&nbsp;&nbsp;<i>[".$postings[$key]."]</i>";
				}

			}

			echo "</a>";
			echo "</li>\n";
        }
		if ($_REQUEST["columnas"]==2){
			if ($cuenta>=$tope/2) {
				echo "</ul><ul>";
				$cuenta=0;
			}
		}
	}
?>
	</ul>

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

<?php
}
?>

<form name="indiceAlfa" method="get" action="indexes.php">
	<input type="hidden" name="alfa" value="<?php if (isset($_REQUEST["alfa"]) and $_REQUEST["alfa"]!="") echo $_REQUEST["alfa"]?>">
	<input type="hidden" name="titulo" value="<?php echo $_REQUEST["titulo"]?>">
	<input type="hidden" name="columnas" value="<?php echo $_REQUEST["columnas"]?>">
	<input type="hidden" name="Opcion" value="<?php echo $_REQUEST["Opcion"]?>">
	<input type="hidden" name="count" value="5">
	<input type="hidden" name="posting" value="<?php echo $_REQUEST["posting"]?>">
	<input type="hidden" name="prefijo" value="<?php echo $_REQUEST["prefijo"]?>">
	<input type="hidden" name="prefijoindice" value="<?php echo $_REQUEST["prefijo"]?>">
	<input type="hidden" name="ira" value="<?php if (isset($_REQUEST["ira"])) echo $_REQUEST["ira"]?>">
	<input type="hidden" name="Expresion">
	<input type="hidden" name="Sub_Expresion">
	<input type="hidden" name="letra" value="<?php echo str_replace($_REQUEST["prefijo"],'',$primero) ?>">
	<input type="hidden" name="Existencias">
	<input type="hidden" name="coleccion" value="<?php if (isset($_REQUEST["coleccion"])) echo $_REQUEST["coleccion"]?>">
	<input type="hidden" name="lang" value="<?php if (isset($_REQUEST["lang"])) echo $_REQUEST["lang"]?>">
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


<?php if (!isset($_REQUEST["alfa"]) or $_REQUEST["alfa"]==""){ ?>

<script>
	Ctrl=document.getElementById("0")
	Ctrl.style.display="block"
	Ctrl=document.getElementById("collation")
	Ctrl.style.display="block"
</script>
<?php } 


}
?>


<?php 
if (isset($_REQUEST["modo"]) and $_REQUEST["modo"]=="integrado"){
	$archivo="indice.ix";
	$base="";
	$file_ix=$db_path."opac_conf/".$lang."/".$archivo;
}else{
	if (isset($_REQUEST["coleccion"]) and $_REQUEST["coleccion"]!=""){
		$col=explode("|",$_REQUEST["coleccion"]);
		$archivo=$_REQUEST["base"].'_'.$col[0].".ix";
		$file_ix=$db_path.$_REQUEST["base"]."/opac/".$lang."/".$archivo;
	}else{
		$archivo=$_REQUEST["base"].".ix";
		$file_ix=$db_path.$_REQUEST["base"]."/opac/".$lang."/".$archivo;
	}

	$base=$_REQUEST["base"];
}

if (file_exists($file_ix)){
	$fp=file($file_ix);
	foreach ($fp as $value){
		$val=trim($value);
		if ($val!=""){
			$v=explode('|',$val);
			$columnas=1;
			$name=$v[0];
			$in_prefix=$v[1];

			//echo "<li><a href='Javascript:ActivarIndice(\"".str_replace("'","'",$v[0])."\",$columnas,\"inicio\",90,1,\"".$v[1]."\",\""."$base\")'>".$v[0]."</a></li>\n";
			?>
			<h6>
			<?php
			echo "<a href='Javascript:ActivarIndice(\"".str_replace("'","",$v[0])."\",$columnas,\"inicio\",90,1,\"".$v[1]."\",\""."$base\")'>".$name."</a></h6>";
			indexes($name,$columnas,$in_prefix);
			
			echo "<hr>";
		}
	}
}

?>
