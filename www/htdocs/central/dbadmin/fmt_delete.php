<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include ("../config.php");

include("../lang/dbadmin.php");

include("../lang/soporte.php");
if (!isset($_SESSION["permiso"])) die;
$lang=$_SESSION["lang"];
$Permiso=$_SESSION["permiso"];
//foreach ($arrHttp as $var=>$value)  echo "$var=$value<br>";
$archivo="";
$archivo=$arrHttp["fmt"].".fmt";
$file=$arrHttp["fmt"];
$url="fmt.php";$lista="formatos.wks";
$titulo=$msgstr["fmt"];
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
	 echo "<a href=\"fmt.php?base=".$arrHttp["base"]."$encabezado\" class=\"defaultButton backButton\">";
?>
<img src="../images/defaultButton_iconBorder.gif" alt="" title="" />
<span><strong><?php echo $msgstr["back"]?></strong></span>
</a>
			</div>
			<div class="spacer">&#160;</div>
</div>
<div class="helper">
<?php echo "<font color=white>&nbsp; &nbsp; Script: delete_file.php" ?></font>
	</div>
<div class="middle form">
			<div class="formContent">
<center><font face=verdana color=red>
<?php echo "<h4>".$msgstr["file"].": ".$archivo ."</h4>";
if ($archivo!=""){
	$a=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/$archivo";
	if (!file_exists($a )) $a=$db_path.$arrHttp["base"]."/def/".$lang_db."/$archivo";
	if (!file_exists($a)){		echo "<p>".$msgstr["ne"];	}else{
		$res=unlink($a);
		if ($res==0){			echo $msgstr["nodeleted"];
		}else{			echo $msgstr["deleted"];
			if ($lista!=""){
				$salida="";				$fp=file($db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/$lista");
				foreach ($fp as $value){					$value=trim($value);
					$v=explode('|',$value);
					if ($v[0]!=$file) $salida.=$value."\n";				}
	            $fp=fopen($db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/$lista","w");
	            fwrite($fp,$salida);
	            fclose($fp);
	            echo "<p>$lista: Updated!!!";
			}		}
	}
}
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