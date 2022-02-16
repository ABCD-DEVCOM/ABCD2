<?php
/*
20220215 fho4abcd titles blue+ translations+html improvements+ add input type (not translated)
*/
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include ("../config.php");
include("../lang/dbadmin.php");

if (!isset($arrHttp["Opcion"])) $arrHttp["Opcion"]="";
include("../common/header.php");
?>
<style>
	td{		font-family:arial;
		font-size:10px;	}
</style>
<font size=1 face=arial color=blue><?php echo "Script: ".$_SERVER['PHP_SELF'];?></font><br>
<b><font face=arial size=1 color=blue><?php echo $msgstr["fdt"].". ".$msgstr["database"]?>: <?php echo $arrHttp["base"]?></font>
		<table bgcolor=#EEEEEE width=100%>
        <tr>
			<td><?php echo $msgstr["tag"];?></td><td><?php echo $msgstr["fn"]?></td>
            <td><?php echo $msgstr["subfields"]?></td>
            <td><?php echo $msgstr["repeat"]?></td>
            <td><?php echo $msgstr["inputtype"]?></td>
            <td><?php echo $msgstr["prefix"]?></td>
        </tr>
<?php
if ($arrHttp["Opcion"]!="new"){
	$archivo=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$arrHttp["base"].".fdt";
	if (file_exists($archivo)){		$fp=file($archivo);
	}else{
		$archivo=$db_path.$arrHttp["base"]."/def/".$lang_db."/".$arrHttp["base"].".fdt";
		if (file_exists($archivo)){
			$fp=file($archivo);
		}else{
			echo "missing file ".$arrHttp["base"]."/".$arrHttp["base"].".fdt";
	    	die;
	  	}
	}
}else{	$fp=explode("\n",$_SESSION["FDT"]);}
foreach ($fp as $value){
	$t=explode('|',$value);
    ?>
	<tr>
        <td bgcolor=white><?php echo $t[1];?></td>
        <td bgcolor=white><?php echo $t[2];?></td>
        <td bgcolor=white><?php echo $t[5];?></td>
        <td bgcolor=white><?php if ($t[4]==1) echo "R";?></td>
        <td bgcolor=white><?php echo $t[7];?></td>
        <td bgcolor=white><?php echo $t[12];?></td>
    </tr>
    <?php
}
?>
</table>
