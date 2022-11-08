<?php
/*
20220129 fho4abcd div-helper+backbutton+improve logic+translation
*/
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include ("../config.php");

include("../lang/admin.php");
include("../lang/dbadmin.php");

include("../lang/soporte.php");
$lang=$_SESSION["lang"];
$Permiso=$_SESSION["permiso"];
$archivo="";
if (isset($arrHttp["pft"])){
	$file=$arrHttp["pft"];
	$url="pft.php";
	$archivo=$arrHttp["pft"].".pft";
	$lista="formatos.dat";
	$arrHttp["path"]="/pfts/".$_SESSION["lang"];
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
    <?php echo $msgstr["pft"]." - ". $msgstr["delete"].": ".$archivo." (".$arrHttp["base"].")"?>
	</div>
	<div class="actions">
    <?php
        $backtoscript="pft.php";
        include "../common/inc_back.php";
        include "../common/inc_home.php";
    ?>
    </div>
    <div class="spacer">&#160;</div>
</div>
<?php include "../common/inc_div-helper.php";?>
<div class="middle form">
<div class="formContent">
<?php
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";

if ($archivo!=""){
    $basearchivo=$arrHttp["base"].$arrHttp["path"]."/".$archivo;
    if (file_exists($db_path.$basearchivo)) {
        $res=unlink($db_path.$basearchivo);
    }else{
        $res=true;
    }
	if ($res==false){
		echo "<h2 style='color:red'>".$msgstr["archivo"]." ".$basearchivo.": ".$msgstr["nodeleted"]."</h2>";
	}else{
		echo "<h2>".$msgstr["archivo"]." ".$basearchivo.": ".$msgstr["eliminados"]."</h2>";
	}
	if ($lista!=""){
		$salida="";
        $baselista=$arrHttp["base"].$arrHttp["path"]."/".$lista;
		$fp=file($db_path.$baselista);
		foreach ($fp as $value){
			$value=trim($value);
			$v=explode('|',$value);
			if ($v[0]!=$file) $salida.=$value."\n";
		}
        $fp=fopen($db_path.$baselista,"w");
        fwrite($fp,$salida);
        fclose($fp);
        echo "<h3>".$msgstr["archivo"]." ".$baselista.": ".$msgstr["updated"]."</h3>";
	}
}
echo "</div></div>";
include "../common/footer.php";
?>