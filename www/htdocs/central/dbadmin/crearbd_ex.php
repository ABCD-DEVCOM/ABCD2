<?php
global $arrHttp;
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include ("../config.php");
if (!isset($_SESSION['lang'])) $_SESSION["lang"]="es";
include("../lang/admin.php");
include("../lang/soporte.php");

function MostrarPft(){
global $arrHttp,$xWxis,$db_path,$wxisUrl,$Wxis;
 	$IsisScript="wxis/".$arrHttp["IsisScript"];
 	$query = "&base=".$arrHttp["base"]."&cipar=$db_path"."par/".$arrHttp["cipar"]."&Opcion=".$arrHttp["Opcion"];
 	include("../common/wxis_llamar.php");
	foreach ($contenido as $linea){
	   	if (substr($linea,0,10)=='$$LASTMFN:'){
		     return $linea;
		}else{
  			echo "$linea\n";
  		}
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
echo "<html>
<script>
function Continuar(){    if (confirm(\"".$msgstr["borrartodo"]."\")==true ) {    	document.continuar.accion.value=\"cont\"
    	document.continuar.submit()    }
}

function ActualizarListaBases(bd,desc){
	ix=top.encabezado.document.OpcionesMenu.baseSel.options.length
	for (i=0;i<ix;i++){		xbase=top.encabezado.document.OpcionesMenu.baseSel.options[i].value
		ixsel=xbase.indexOf('^b')
		if (ixsel==-1)
			basecomp=xbase.substr(2)
		else
			basecomp=xbase.substr(2,ixsel-2)
		if (basecomp==bd){			top.encabezado.document.OpcionesMenu.baseSel.options[i].text=desc
			return		}	}
	top.encabezado.document.OpcionesMenu.baseSel.options[ix]=new Option('^a'+bd+'^badm',desc)
}
</script>
<body><font face=arial>
<form name=continuar method=post action=crearbd_ex.php>
<input type=hidden name=nombre value=\"".$arrHttp["nombre"]."\">
<input type=hidden name=desc value=\"".$arrHttp["desc"]."\">
<input type=hidden name=base value=\"".$arrHttp["base"]."\">
<input type=hidden name=accion value=''>
</form>
";

echo "<font size=1> &nbsp; &nbsp; Script: crearbd_ex.php</font>";
//foreach ($arrHttp as $var => $value) echo "$var = $value<br>";
$Dir = $db_path;
$bd = $arrHttp['nombre'];
$descripcion=$arrHttp['desc'];
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
                	echo "<center><br><br><font color=red face=verdana><h4>".$bd." ".$msgstr["bdexiste"]."</h4>";
                	echo "<p><center><a href=javascript:history.back()>".$msgstr["regresar"]."</a>";
                	echo "&nbsp;&nbsp;<a href=javascript:Continuar()>".$msgstr["continuar"]."</a>";
					die;
				}
            }
   }
}
closedir($handle);
$bd=strtolower($bd);
if (!file_exists($Dir."$bd")) if (mkdir($Dir."$bd")==false and $arrHttp["accion"]!="cont") {
    echo "no se puede crear la base de datos solicitada";
	die;
}
if (!file_exists($Dir."$bd"."/data")) mkdir($Dir."$bd"."/data");
if (!file_exists($Dir."$bd"."/www")) mkdir($Dir."$bd"."/www");
if (!file_exists($Dir."$bd"."/cnv")) mkdir($Dir."$bd"."/cnv");
if (!file_exists($Dir."$bd"."/def")) mkdir($Dir."$bd"."/def");
chmod($Dir."$bd"."/data",0777);
chmod($Dir."$bd"."/www",0777);
chmod($Dir."$bd"."/cnv",0777);
chmod($Dir."$bd"."/def",0777);
//se crea el fullinv.sh en la carpeta data
 if (stristr($OS,"win")==false){
	$contenido="mx $bd fst=@$bd.fst uctab=../../isisuc.tab actab=../../isisac.tab fullinv=$bd -all now tell=100";
	$filename=$Dir."$bd"."/data/fullinv.sh";
 } else{
 	$contenido="mx $bd fst=@$bd.fst uctab=..\..\isisuc.tab actab=..\..\isisac.tab fullinv=$bd -all now tell=100";
	$filename=$Dir."$bd"."/data/fullinv.bat";
 }
$ce=CrearArchivo($filename,$contenido);

//Bases.dat
$filename= $db_path."bases.dat";
$fp=file($db_path."bases.dat");
$contenido="";
foreach ($fp as $value){
	$ixpos=strpos($value,"|");
	$comp=trim(substr($value,0,$ixpos));
	if ($comp!=$bd) $contenido.=$value;
}
$contenido=trim($contenido);
if (!isset($arrHttp["type_r"])) $arrHttp["type_r"]="";
$contenido.="\n".$bd."|".$descripcion."|".$arrHttp["type_marc"]."|".$arrHttp["type_r"];
//echo $contenido;
$ce=CrearArchivo($filename,$contenido);

//Archivo .par
$filename=$db_path."par/$bd.par";
$contenido="$bd.*=%path_database%"."$bd/data/$bd.*\n";
$contenido.="$bd.pft=%path_database%"."$bd/www/$bd.pft\n";
$contenido.="prologoact.pft=%path_database%"."www/prologoact.pft\nepilogoact.pft=%path_database%"."www/epilogoact.pft\n";
$ce=CrearArchivo($filename,$contenido);

$file = $Dir."$base"."/";
$newfile = $Dir."$bd"."/";

if ($arrHttp["base"]=="~~NewDb"){
	echo "<P><b><font color=darkred>";
	$arrHttp["IsisScript"]="administrar.xis";
	$arrHttp["Opcion"]="inicializar";
	$arrHttp["cipar"]=$bd.".par";
	$arrHttp["base"]=$bd;
	MostrarPft();

	echo "<script>
	ActualizarListaBases('$bd','$descripcion')
	</script>
	<font color=black><p>";
	echo "<h4>Remember to assign the users of ABCD which have acces to the new database ";
	echo "<a href=../../documentacion/".$_SESSION["lang"]."/assign_operators.html target=_blank>How to assign operators? <img src=../img/about.gif alt=Help border=0></a>&nbsp &nbsp;
        		<a href=../../documentacion/php/edit.php?archivo=../". $_SESSION["lang"]."/assign_operators.html target=_blank>edit help file</a></h4>";	echo "<p><font face=arial size=4><a href=fdt.php?base=$bd&dir=$newfile&Opcion=NewBd><b>Continue<b></a>";
	die;}
if ($arrHttp["base"]=="~~WinIsis" or $arrHttp["base"]=="~~DocuManager"){	echo "<p><font face=arial size=4><a href=winisis.php?base=$bd&dir=$newfile><b>Upload CDS/Isis Definitions</b></a>";
	die;}
echo "<p>copying files ... <p>";
CopiarDirectorio($file,$newfile,$base,$bd);

$file = $Dir."$base"."/www/";
$newfile = $Dir."$bd"."/www/";
CopiarDirectorio($file,$newfile,$base,$bd);

mkdir($Dir."$bd"."/def");
$file = $Dir."$base"."/def/";
$newfile = $Dir."$bd"."/def/";
CopiarDirectorio($file,$newfile,"","");


mkdir($Dir."$bd"."/cnv");
$file = $Dir."$base"."/cnv/";
$newfile = $Dir."$bd"."/cnv/";
CopiarDirectorio($file,$newfile,"","");

//se crea el fullinv.sh en la carpeta data
 if (stristr($OS,"win")==false){
	$contenido="mx $bd fst=@$bd.fst uctab=../../isisuc.tab actab=../../isisac.tab fullinv=$bd -all now tell=100";
	$filename=$Dir."$bd"."/data/fullinv.sh";
 } else{
 	$contenido="mx $bd fst=@$bd.fst uctab=..\..\isisuc.tab actab=..\..\isisac.tab fullinv=$bd -all now tell=100";
	$filename=$Dir."$bd"."/data/fullinv.bat";
 }
$ce=CrearArchivo($filename,$contenido);

// se copia la fst
$file = $Dir."$base"."/data/$base.fst";
$newfile=$Dir."$bd"."/data/$bd.fst";
if(copy($file, $newfile)) {
    touch($newfile, filemtime($file));
}else{
	echo "Error: File '$file' could not be copied!\n";
}

//Archivo.par
$fp=file($db_path."par/$base.par");
$contenido="";
foreach ($fp as $value){
	$contenido.=str_replace($base,"$bd",$value);
}
$newfile=$db_path."par/$bd.par";
$ce=CrearArchivo($newfile,$contenido);

//formatos.dat
$fp=file($db_path."$bd/www/formatos.dat");
$contenido="";
foreach ($fp as $value){
	$contenido.=str_replace($base,"$bd",$value);
}
$newfile=$db_path."$bd/www/formatos.dat";
$ce=CrearArchivo($newfile,$contenido);
echo "

<form action=winisis_creardb.php method=POST >

<input type=hidden name=dir value=".$arrHttp["dir"]."data/>
<input type=hidden name=base value=".$arrHttp["base"].">
<input type=hidden name=Opcion value=INIT>

<p><dd><input type=submit value=\"Create database\">
</form>";

?>
<script>
	alert("recuerde asignar los operadores que tienen acceso a la nueva base de datos")
	self.location="administrar_ex.php?base=<?php echo "$bd&cipar=$bd.par&Opcion=inicializar"?>"
</script>