<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include ("../config.php");

include("../lang/dbadmin.php");

include("../lang/soporte.php");
$lang=$_SESSION["lang"];
$Permiso=$_SESSION["permiso"];
$archivo="";
if (isset($arrHttp["fmt"])) {
	$archivo=$arrHttp["fmt"].".fmt";
	$file=$arrHttp["fmt"];
	$url="fmt.php";	$lista="formatos.wks";
	$titulo=$msgstr["fmt"];
}
if (isset($arrHttp["pft"])){
	$file=$arrHttp["pft"];
	$url="pft.php";	$archivo=$arrHttp["pft"].".pft";
	$lista="formatos.dat";
	$titulo=$msgstr["pft"];
	$arrHttp["path"]="/pfts/".$_SESSION["lang"];
}
if (isset($arrHttp["tab"])){
	$archivo=$arrHttp["tab"];
	$lista="";
    $titulo=$msgstr["it_tb"];
	$url="";
}
include("../common/header.php");
?>
<body>
<?php
if (isset($arrHttp["encabezado"])){
	include("../common/institutional_info.php");
	$encabezado="&encabezado=s";
}else{
	$encabezado="";
}
?>
<div class="sectionInfo">
	<div class="breadcrumb">
<?php echo $arrHttp["base"].": ".$msgstr["delete"].". $titulo: ".$archivo?>
	</div>

	<div class="actions">
<?php
	 echo "<a href=\"pft.php?base=".$arrHttp["base"]."$encabezado\" class=\"defaultButton backButton\">";
?>
<img src="../images/defaultButton_iconBorder.gif" alt="" title="" />
<span><strong><?php echo $msgstr["back"]?></strong></span>
</a>
			</div>
			<div class="spacer">&#160;</div>
</div>
<div class="helper">
<?php  echo "<font color=white>&nbsp; &nbsp; Script: pft_delete.php" ?></font>
	</div>
<div class="middle form">
			<div class="formContent">
<center><font face=verdana color=red>File:
<?php echo "$archivo</h4>";
if ($archivo!=""){
	$res=unlink($db_path.$arrHttp["base"].$arrHttp["path"]."/$archivo");
	if ($res==0){		echo "$archivo: The file could not be deleted";
	}else{		echo "$archivo: Deleted!!!";
	}
	if ($lista!=""){
		$salida="";		$fp=file($db_path.$arrHttp["base"]."/".$arrHttp["path"]."/$lista");
		foreach ($fp as $value){			$value=trim($value);
			$v=explode('|',$value);
			if ($v[0]!=$file) $salida.=$value."\n";		}
           $fp=fopen($db_path.$arrHttp["base"]."/".$arrHttp["path"]."/$lista","w");
           fwrite($fp,$salida);
           fclose($fp);
           echo "<p>$lista: Updated!!!";
	}}
if ($encabezado!=""){
	if (isset($arrHttp["pft"]) or $url!=""){		echo "<script>
			url='".$url."'

			if ( top.frames.length>0){
				if (top.ModuloActivo==\"Catalogar\")
					document.writeln(\"<p><a href=javascript:top.Menu('imprimir')>".$msgstr["back"]."</a>\")
				else
					document.writeln(\"<p><a href=\"+url+\"?base=".$arrHttp["base"].">".$msgstr["back"]."</a>\")
			}
			</script>
			";
	}}
?>