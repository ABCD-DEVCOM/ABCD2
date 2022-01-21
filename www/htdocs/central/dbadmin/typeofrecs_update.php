<?php
/*
20220121 fho4abcd buttons+div-helper
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
	<div class="breadcrumb"><?php echo $msgstr["typeofrecords"].": ".$arrHttp["base"]?></div>
	<div class="actions">
    <?php
        $backtoscript="typeofrecs_edit.php";
        include "../common/inc_back.php";
        $backtocancelscript="menu_modificardb.php";
        include "../common/inc_cancel.php";
        include "../common/inc_home.php";
    ?>
    </div>
    <div class="spacer">&#160;</div>
</div>
<div class="middle form">
<div class="formContent">
<?php
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
$cell=array();
foreach ($arrHttp as $var=>$value) {
	if (substr($var,0,4)=="cell"){
		$c=explode("_",$var);
		if ($value=="_") $value="";
		if (isset($cell[$c[0]]))
			$cell[$c[0]].='|'.$value;
		else
			$cell[$c[0]]=$value;
	}else{
	}
}
if (!isset($arrHttp["tipom"])) $arrHttp["tipom"]="";
if (!isset($arrHttp["nivelr"])) $arrHttp["nivelr"]="";
if ( $arrHttp["tipom"]=="" && $arrHttp["nivelr"]=="" ) {
    echo '<div style="color:red">'.$msgstr["typeofrecords_tagsempty"].'</div>';
} else {
    $archivo=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/typeofrecord.tab";
    $fp=fopen($archivo,"w");
    $res=fwrite($fp,$arrHttp["tipom"]." ".$arrHttp["nivelr"]."\n");
    foreach ($cell as $value){

        $l=explode('|',$value);
        $linea=str_replace('|',"",$value);
        if (trim($linea)!="") $res=fwrite($fp,$value."\n");;
    }
    fclose($fp);
    echo "<center><h4>".$arrHttp["base"]."/def/".$_SESSION["lang"]."/typeofrecord.tab"." ".$msgstr["updated"]."</h4>";
}
if (isset($arrHttp["encabezado"])) 	$encabezado="&encabezado=s";
else 	$encabezado="";

// Show this button always, even in case of an empty set tags
?>
<p>
<a href='typeofrecs_edit.php?base=<?php echo $arrHttp["base"].$encabezado?>' class="button_browse show">
<?php echo $msgstr["typeofrecords_create"]?></a>
<?php

echo "</div></div></center>";
include("../common/footer.php");
?>