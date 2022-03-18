<?php
/*
20220125 fho4abcd home button replaces back button + div-helper + more  and better translation
*/
global $arrHttp;
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
if (!isset($_SESSION['lang'])) $_SESSION["lang"]="es";
include("../common/get_post.php");
include ("../config.php");

if (isset($_SESSION["UNICODE"])) {
	IF ($_SESSION["UNICODE"]==1)
		$meta_encoding="UTF-8";
	else
		$meta_encoding="ISO-8859-1";
}
include("../lang/dbadmin.php");

if (isset($_SESSION["CISIS_VERSION"])){
	$_POST['CISIS_VERSION']=$_SESSION["CISIS_VERSION"];
} else { 
	$_POST['CISIS_VERSION']="16-60";
}

if (isset($_SESSION["UNICODE"])) {
	$UNICODE=$_REQUEST["UNICODE"];
} else {
	$UNICODE="0";
}

if (isset($_SESSION["DCIMPORT"])) {
	$_POST['dcimport']=$_SESSION["DCIMPORT"];
} else {
	$_POST['dcimport']="";
}

function MostrarPft(){
global $arrHttp,$xWxis,$db_path,$Wxis,$mx_path,$UNICODE;
/*
	if($_POST['CISIS_VERSION']!=''){
		$OS=strtoupper(PHP_OS);
		$converter_path=$Wxis;
		$converter_path=str_replace('wxis.exe','',$converter_path);
		$converter_path.=$_POST['cisis']."/wxis.exe";
		$Wxis=$converter_path;
	}

	echo "<p><font color=red>".$Wxis."</p>";
*/
  @ $fp = fopen($db_path.$arrHttp['base'].'/dr_path.def', "w");
	@  flock($fp, 2);
  	if (!$fp){
    	echo "<p><strong> Error ocurred in ISIS Script."
         ."Please try again.</strong></p></body></html>";
    	exit;
  	}
  	if($_POST['dcimport']=='yes'){
   		$str="ROOT=".$db_path.$arrHttp['base']."/\nIMPORTPDF=Y\n";
 	}else
 		$str="ROOT=".$db_path.$arrHttp['base']."/\n";
 	fwrite($fp, $str);

 	$str="CISIS_VERSION=".$_POST['CISIS_VERSION']."\n";
   	fwrite($fp, $str);
   	$str="UNICODE=".$UNICODE."\n";
   	fwrite($fp, $str);
  	flock($fp, 3);
  	fclose($fp);

  	@ $fp = fopen($db_path.'par/'.$arrHttp['base'].".par", "a");
	@  flock($fp, 2);
  	if (!$fp){
    	echo "<p><strong> Error ocurred in ISIS Script."
       		."Please try again.</strong></p></body></html>";
    	exit;
  	}
    if($_POST['UNICODE']=='1'){
      		$str="isisac.tab=%path_database%"."isisactab_utf8.tab\n"."isisuc.tab=%path_database%"."isisuctab_utf8.tab\n";
     } else {
      	  		$str="isisac.tab=%path_database%"."isisac.tab\n"."isisuc.tab=%path_database%"."isisuc.tab\n";
     }
 	fwrite($fp, $str);
  	flock($fp, 3);
  	fclose($fp);

 	$IsisScript=$xWxis."inicializar_bd.xis";
 	$query = "&base=".$arrHttp["base"]."&cipar=$db_path"."par/".$arrHttp["cipar"];
 	include("../common/wxis_llamar.php");
	foreach ($contenido as $linea){
	   	echo "$linea\n";
 	}
}


function CopiarDirectorio($srcdir, $dstdir,$basesrc,$basedst, $verbose = true) {
  $num = 0;
//  if(!is_dir($dstdir)) mkdir($dstdir);
  if($curdir = opendir($srcdir)) {
   while($file = readdir($curdir)) {
     if($file != '.' && $file != '..') {
       $srcfile = $srcdir . '/' . $file;
       $dstfile = $dstdir . '/' . str_replace($basesrc,$basedst,$file);

       if(is_file($srcfile)) {
         if(is_file($dstfile)) $ow = filemtime($srcfile) - filemtime($dstfile); else $ow = 1;
         if($ow > 0) {
           if($verbose) echo "Copying '$srcfile' to '$dstfile'...<br>";
           if(copy($srcfile, $dstfile)) {
             touch($dstfile, filemtime($srcfile)); $num++;
             if($verbose) echo "OK\n";
           }
           else echo "Error: File '$srcfile' could not be copied!\n";
         }
       }
       else if(is_dir($srcfile)) {
 //        $num += dircopy($srcfile, $dstfile, $verbose);
       }
     }
   }
   closedir($curdir);
  }
  return $num;
}


function CrearArchivo($filename,$contenido){
echo "<xmp>$contenido</xmp>";
	if (!$handle = fopen($filename, 'w')) {
         echo "Cannot open file ($filename)";
         return -1;
		 exit;
   	}

   // Write $somecontent to our opened file.
	if (fwrite($handle, $contenido) === FALSE) {
       echo "Cannot write to file ($filename)";
	   return -1;
       exit;
   }

   echo "<p><b>File created:</b> $filename";         //<xmp>$contenido</xmp>

   fclose($handle);
//   chmod($filename,0777);
   return 0;

}

//----------------------------------------------------------
$requestedURL= $_SERVER['PHP_SELF'];
$ix=strrpos($requestedURL,"/");
$requestedURL=substr($requestedURL,0,$ix+1);



//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
if (isset($arrHttp["pft"])) $_SESSION["PFT"]=$arrHttp["pft"];
include("../common/header.php");

echo "
<body>
<script>
function Continuar(){
    if (confirm(\"".$msgstr["borrartodo"]."\")==true ) {
    	document.continuar.accion.value=\"cont\"
    	document.continuar.submit()
    }
}
";
if (!isset($arrHttp["encabezado"])){
	echo "

function ActualizarListaBases(bd,desc){
	ix=top.encabezado.document.OpcionesMenu.baseSel.options.length
	for (i=0;i<ix;i++){
		xbase=top.encabezado.document.OpcionesMenu.baseSel.options[i].value
		ixsel=xbase.indexOf('^b')
		if (ixsel==-1)
			basecomp=xbase.substr(2)
		else
			basecomp=xbase.substr(2,ixsel-2)
		if (basecomp==bd){
			top.encabezado.document.OpcionesMenu.baseSel.options[i].text=desc
			return
		}
	}
	top.encabezado.document.OpcionesMenu.baseSel.options[ix]=new Option(desc,'^a'+bd+'^badm',1)
}";
}
echo "
</script>
";
if (isset($arrHttp["encabezado"]))
	include("../common/institutional_info.php");
?>
<div class="sectionInfo">
    <div class="breadcrumb">
        <?php echo $msgstr["createdb"].": " . $arrHttp["base"]?>
    </div>
	<div class="actions">
<?php
$arrHttp["Opcion"]="new";
if ($arrHttp["Opcion"]=="new"){
	if (isset($arrHttp["encabezado"]) ){
		include "../common/inc_home.php";
	}else{
        $backtoscript="menu_creardb.php";
		include "../common/inc_back.php";
	}
}else{
	if (isset($arrHttp["encabezado"]))
		$encabezado="&encabezado=s";
	else
		$encabezado="";
    $backtoscript="menu_modificardb.php";
    include "../common/inc_back.php";
}
?>
    </div>
    <div class="spacer">&#160;</div>
</div>
<?php
$ayuda="crearbd_new_create.html"; include "../common/inc_div-helper.php";
echo "
<div class=\"middle form\">
			<div class=\"formContent\">
<form name=continuar method=post action=crearbd_new_create.php>
<input type=hidden name=nombre value=\"".$arrHttp["base"]."\">
<input type=hidden name=pft value='".urlencode($_SESSION["PFT"])."'>
<input type=hidden name=desc value=\"".$_SESSION["DESC"]."\">
<input type=hidden name=base value=\"".$arrHttp["base"]."\">
<input type=hidden name=accion value=''> ";
if (isset($arrHttp["Opcion"])) echo "<input type=hidden name=Opcion value=\"".$arrHttp["base"]."\">\n";
if (isset($arrHttp["encabezado"])) echo "<input type=hidden name=encabezado value=s>\n";
echo "</form>";


$Dir = $db_path;
$bd = $arrHttp['base'];
$descripcion=$_SESSION["DESC"];
$base=$arrHttp['base'];
$_SESSION["NEWBD"]=$bd;
$_SESSION["NEWBASE"]=$descripcion;

$the_array = Array();
$handle = opendir($Dir);

if (!isset($arrHttp["accion"])) $arrHttp["accion"]="";
if ($arrHttp["accion"]!="cont"){
	while (false !== ($file = readdir($handle))) {
   		if ($file != "." && $file != "..") {
   			if(!is_file($Dir."/".$file))
            	if ($file==$bd) {
                	echo "<center><br><br><h4>".$bd." ".$msgstr["bdexiste"]."</h4>";
              //  	echo "<p><center><a href=javascript:history.back()>".$msgstr["regresar"]."</a>";
                	echo "&nbsp;&nbsp;<a href=javascript:Continuar()>".$msgstr["continuar"]."</a>";
					die;
				}
            }
   }
}
closedir($handle);
$bd=strtolower($bd);
if (!file_exists($Dir."$bd")){
	if (mkdir($Dir."$bd")==false and $arrHttp["accion"]!="cont") {
    	echo "no se puede crear la base de datos solicitada";
		die;
	}
}
//if (file_exists($img_path)){
//	if (!file_exists($img_path."$bd")) mkdir($img_path."$bd");
//}
if (!file_exists($Dir."$bd"."/data")) mkdir($Dir."$bd"."/data");
if (!file_exists($Dir."$bd"."/pfts")) mkdir($Dir."$bd"."/pfts");
if (!file_exists($Dir."$bd"."/def")) mkdir($Dir."$bd"."/def");
if (!file_exists($Dir."$bd"."/ayudas")) mkdir($Dir."$bd"."/ayudas");
if (!file_exists($Dir."$bd"."/cnv")) mkdir($Dir."$bd"."/cnv");
if (file_exists($msg_path."lang.tab")){
	$fp=file($msg_path."lang.tab");
}else{
	$fp=array("es","en","fr","pt");
}
foreach ($fp as $l){
	$l=trim($l);
	if (!file_exists($Dir."$bd"."/pfts/$l")) mkdir($Dir."$bd"."/pfts/$l");
	if (!file_exists($Dir."$bd"."/def/$l")) mkdir($Dir."$bd"."/def/$l");
}

chmod($Dir."$bd"."/data",0777);
chmod($Dir."$bd"."/pfts",0777);
chmod($Dir."$bd"."/cnv",0777);
chmod($Dir."$bd"."/def",0777);
chmod($Dir."$bd"."/ayudas",0777);
//chmod($img_path."$bd",0777);

//Bases.dat
$filename= $db_path."bases.dat";
$fp=file($db_path."bases.dat");
$contenido="";
foreach ($fp as $value){
	 $contenido.=$value;
}
$contenido=trim($contenido);
$contenido.="\n".$bd."|".$descripcion;
$ce=CrearArchivo($filename,$contenido);

//Archivo .par
$filename=$db_path."par/$bd.par";
$contenido="$bd.*=%path_database%"."$bd/data/$bd.*\n";
$contenido.="$bd.pft=%path_database%"."$bd/pfts/".$_SESSION["lang"]."/$bd.pft\n";
$contenido.="prologoact.pft=%path_database%"."www/prologoact.pft\nepilogoact.pft=%path_database%"."www/epilogoact.pft\n";
$ce=CrearArchivo($filename,$contenido);

//ARCHIVO DBN.DEF
$filename=$db_path."par/".strtoupper($bd).".def";
$contenido="[FILE_LOCATION]\n\nFILE DATABASE.*=%path_database%$bd/data/$bd.*";
$ce=CrearArchivo($filename,$contenido);

//ARCHIVO SHORTCUT.PFT
$filename=$db_path."$bd/pfts/shortcut.pft";
$contenido="";
$ce=CrearArchivo($filename,$contenido);

$filename=$db_path."$bd/pfts/".$_SESSION["lang"]."/camposbusqueda.tab";
$contenido="";
$ce=CrearArchivo($filename,$contenido);

$file = $Dir."$base"."/";
$newfile = $Dir."$bd"."/";

echo "<p><b>";
$arrHttp["IsisScript"]="";
$arrHttp["Opcion"]="inicializar";
$arrHttp["cipar"]=$bd.".par";
$arrHttp["base"]=$bd;
MostrarPft();
echo $msgstr["database"]." ".$arrHttp["base"]." ".$msgstr["created"];
$fp=fopen($db_path.$arrHttp["base"]."/data/control_number.cn","w");
fwrite($fp,"0");
fclose($fp);
$t=explode("\n",$_SESSION["FDT"]);
$fp=fopen($db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$arrHttp["base"].".fdt","w");
foreach ($t as $value){
	$val=trim(str_replace('|','',$value));
	if ($val=="00") $val="";
	if ($val!="") fwrite($fp,stripslashes($value)."\n");
	//echo "$value<br>";
}
fclose($fp);
echo "<p>".$msgstr["fdt"]." ".$msgstr["saved"];


$t=explode("\n",$_SESSION["FST"]);
$fp=fopen($db_path.$arrHttp["base"]."/data/".$arrHttp["base"].".fst","w");
foreach ($t as $value){
	$val=trim(str_replace('|','',$value));
	if ($val=="00") $val="";
	if ($val!="") fwrite($fp,stripslashes($value)."\n");
	//echo "$value<br>";
}
fclose($fp);
echo "<p>".$msgstr["fst"]." ".$msgstr["saved"];

$value=$_SESSION["PFT"];


$fp=fopen($db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/".$arrHttp["base"].".pft","w");
fwrite($fp,stripslashes($value)."\n");
fclose($fp);
echo "<p>".$msgstr["pft"]." ".$msgstr["saved"];

$fp=fopen($db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/formatos.dat","w");
fwrite($fp,$arrHttp["base"]."|".$_SESSION["DESC"]);
fclose($fp);

if (!isset($arrHttp["encabezado"])){
	$descripcion.="\n";
	echo  "<script>
	ActualizarListaBases('$bd','$descripcion')
	</script>
	";
}
echo "<p>";
if (!isset($arrHttp["encabezado"]))echo "<a href=../dataentry/inicio_base.php?base=".$arrHttp["base"]."&cipar=".$arrHttp["base"].".par&nueva=s>Continuar</a><p>";
echo "<h4>".$msgstr["assusdb"]."</h4>";
echo "

	<a href=../documentacion/ayuda.php?help=".$_SESSION["lang"]."/assign_operators.html target=_blank>".$msgstr["assop"]."</a>&nbsp &nbsp;
    <a href=../documentacion/edit.php?archivo=". $_SESSION["lang"]."/assign_operators.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<p><a href=iah_edit_db.php?encabezado=s&base=".$arrHttp["base"].">".$msgstr["iah-conf"]."</a>";

echo "</div></div>";
include("../common/footer.php");
unset($_SESSION["CISIS"]);
unset($_SESSION["dc_import"]);
?>
