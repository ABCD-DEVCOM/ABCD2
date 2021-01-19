<?php
session_start();



//echo "<pre>"; print_r($_SESSION); ECHO "</pre>";

$Permiso=$_SESSION["permiso"];
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../common/get_post.php");
if (!isset($arrHttp["base"])) $arrHttp["base"]="";

if (strpos($arrHttp["base"],"|")===false){

}   else{
		$ix=explode('|',$arrHttp["base"]);
		$arrHttp["base"]=$ix[0];
}
$db=$arrHttp["base"];
include ("../config.php");
$lang=$_SESSION["lang"];
include("../lang/admin.php");
include("../lang/soporte.php");
include("../lang/dbadmin.php");

if (!isset($_SESSION["permiso"]["CENTRAL_ALL"]) and
    !isset($_SESSION["permiso"]["CENTRAL_DBUTILS"]) and
    !isset($_SESSION["permiso"][$db."_CENTRAL_ALL"]) and
    !isset($_SESSION["permiso"][$db."_CENTRAL_DBUTILS"])
    ){
	echo "<script>
	      alert('".$msgstr["invalidright"]."')
          history.back();
          </script>";
    die;
}


//SEE IF THE DATABASE IS LINKED TO COPIES
$copies="N";
$fp=file($db_path."bases.dat");
foreach ($fp as $value){
	$value=trim($value);
	$x=explode("|",$value);
	if ($x[0]==$arrHttp["base"]){
		if (isset($x[2]) and $x[2]=="Y"){			$copies="Y";
		}
		break;
	}
}
//foreach ($arrHttp as $var=>$value) echo "$var = $value<br>";
include("../common/header.php");
?>

<script language="JavaScript" type="text/javascript" src=../dataentry/js/lr_trim.js></script>



<body onunload=win.close()>
<?php

	include("../common/institutional_info.php");
	$encabezado="&encabezado=s";
echo "
	<div class=\"sectionInfo\">
			<div class=\"breadcrumb\">".
				$msgstr["maintenance"]. ": " . $arrHttp["base"]."
			</div>
			<div class=\"actions\">

	";

	echo "<a href=\"../common/inicio.php?reinicio=s&base=".$arrHttp["base"]."\" class=\"defaultButton backButton\">";
echo "<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
	<span><strong>". $msgstr["back"]."</strong></span></a>";
echo "</div>
	<div class=\"spacer\">&#160;</div>
	</div>";
?>
<div class="helper">
	<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/menu_mantenimiento.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
 	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/menu_mantenimiento.html target=_blank>".$msgstr["edhlp"]."</a>";
echo " &nbsp; &nbsp; <a href='http://abcdwiki.net/wiki/es/index.php?title=Utilitarios' target=_blank>Abcdwiki</a>";
echo "<font color=white>&nbsp; &nbsp; Script: dbadmin/menu_mantenimiento.php";
?>
</font>
</div>
<div class="middle form">
	<div class="formContent" style="min-height:300px;">

<?php include("menu_bar.php")?>

<br><br>
<?php
$IsisScript=$xWxis."administrar.xis";
$query = "&base=".$arrHttp["base"] . "&cipar=$db_path"."par/".$arrHttp["base"].".par&Opcion=status";
include("../common/wxis_llamar.php");
$ix=-1;
foreach($contenido as $linea) {
	$ix=$ix+1;
	if ($ix>0) {
		if (trim($linea)!=""){
	   		$a=explode(":",$linea);
	   		if (isset($a[1])) $tag[$a[0]]=$a[1];
	  	}
	}
}
if (!isset($tag["MAXMFN"]))   $tag["MAXMFN"]=0;
echo "<center><b>".$msgstr["bd"].": ".$arrHttp["base"]."</b>";
if ( !isset($def_db["UNICODE"]) or $def_db["UNICODE"] == "ansi" || $def_db["UNICODE"] == '0' ) {
	$charset_db="ISO-8859-1";
}else{
	$charset_db="UTF-8";
}
echo "<br><strong>$charset_db</strong>" ;
echo "<br><b><font color=darkred>". $msgstr["maxmfn"].": ".$tag["MAXMFN"]."</b></font>";

if ($tag["BD"]=="N")
	echo "<p>".$msgstr["database"]." ".$msgstr["ne"];
if ($tag["IF"]=="N")
	echo "<p>".$msgstr["if"]." ".$msgstr["ne"];
if ($tag["EXCLUSIVEWRITELOCK"]!=0) {
	echo "<p>".$msgstr["database"]." ".$msgstr["exwritelock"]."=".$tag["EXCLUSIVEWRITELOCK"].". ".$msgstr["contactdbadm"]."
	<script>top.lock_db='Y'</script>
	";

}

if ($wxisUrl!=""){
	echo "<p>CISIS version: $wxisUrl</p>";
}else{
	$ix=strpos($Wxis,"cgi-bin");
	$wxs=substr($Wxis,$ix);
    echo "<p>CISIS version: ".$wxs."</p>";
}
?>
</div>
<!--form name=maintenance>
<table cellspacing=5 width=500 align=center>
	<tr>
		<td nowrap>

		<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>

             <br>
			<ul style="font-size:12px;line-height:20px">

			<li><a href='javascript:EnviarForma("fullinv","<?php echo $msgstr["mnt_gli"]?>")'><?php echo $msgstr["mnt_gli"] ."(MX)"?></a></li>
			<li><a href='javascript:EnviarForma("dbcp","<?php echo $msgstr["db_cp"]?>")'><?php echo $msgstr["db_cp"]?></a></li>
			<li><a href='javascript:EnviarForma("mxdbread","<?php echo $msgstr["mx_dbread"]?>")'><?php echo $msgstr["mx_dbread"]?></a></li>
			<li><a href='javascript:EnviarForma("dbrestore","<?php echo $msgstr["db_restore"]?>")'><?php echo $msgstr["db_restore"]?></a></li>
			<li><a href='javascript:EnviarForma("inicializar","<?php echo $msgstr["mnt_ibd"]?>")'><?php echo $msgstr["mnt_ibd"]?></a></li>
			<li><a href='javascript:EnviarForma("eliminarbd","<?php echo $msgstr["mnt_ebd"]?>")'><?php echo $msgstr["mnt_ebd"]?></a></li>
			<li><a href='javascript:EnviarForma("lock","<?php echo $msgstr["protect_db"]?>")'><?php echo $msgstr["protect_db"]?></a></li>
			<li><a href='javascript:EnviarForma("unlock","<?php echo $msgstr["mnt_unlock"]?>")'><?php echo $msgstr["mnt_unlock"]?></a></li>
			<li><a href='Javascript:EnviarForma("exportiso","<?php echo "ExportISO MX"?>")'><?php echo $msgstr["exportiso_mx"]?></a></li>
			<li><a href='Javascript:EnviarForma("importiso","<?php echo "ImportISO MX"?>")'><?php echo $msgstr["importiso_mx"]?></a></li>
			<li><a href='Javascript:EnviarForma("readiso","<?php echo "ReadISO  MX"?>")'><?php echo $msgstr["readiso_mx"]?></a></li>
			<li><a href='javascript:EnviarForma("cn","<?php echo $msgstr["assigncn"]?>")'><?php echo $msgstr["assigncn"]?></a></li>
			<li><a href='javascript:EnviarForma("linkcopies","<?php echo $msgstr["linkcopies"]?>")'><?php echo $msgstr["linkcopies"]?></a></li>
			<?php if (($arrHttp["base"]!="copies") and ($arrHttp["base"]!="providers") and ($arrHttp["base"]!="suggestions") and ($arrHttp["base"]!="purchaseorder") and ($arrHttp["base"]!="users") and ($arrHttp["base"]!="loanobjects") and ($arrHttp["base"]!="trans") and ($arrHttp["base"]!="suspml") ) {				if ($copies=="Y"){
			?>

			<?php }}
			if ($arrHttp["base"]!="providers" and $arrHttp["base"]!="suggestions" and $arrHttp["base"]!="purchaseorder" and $arrHttp["base"]!="users" and $arrHttp["base"]!="loanobjects" and $arrHttp["base"]!="trans" and $arrHttp["base"]!="suspml") {
				if ($copies=="Y" or $arrHttp["base"]=="copies" or $arrHttp["base"]=="loanobjects"){
            ?>
			<li><a href='Javascript:EnviarForma("addloanobj","<?php echo $msgstr["addLOfromDB_mx"]?>")'><?php echo $msgstr["addLOfromDB_mx"]?></a></li>
			<li><a href='Javascript:EnviarForma("addloanobjectcopies","<?php echo $msgstr["addLOwithoCP_mx"]?>")'><?php echo $msgstr["addLOwithoCP_mx"]?></a></li>
			<li><a href='Javascript:EnviarForma("addcopiesdatabase","<?php echo $msgstr["addCPfromDB_mx"]?>")'><?php echo $msgstr["addCPfromDB_mx"]?></a></li>
            <?php }?>
             <li><a href='Javascript:EnviarForma("barcode","<?php echo "Barcode search"?>")'><?php echo "Barcode search"?></a></li>
			<?php
			}
			if ($arrHttp["base"]=="copies") {
			?>
			<li><a href='Javascript:EnviarForma("copiesocurrenciesreport","<?php echo $msgstr["CPdupreport_mx"]?>")'><?php echo $msgstr["CPdupreport_mx"]?></a></li>
			<?php }?>
			<li><a style="color:green;" href='Javascript:EnviarForma("menu_extra","<?php echo "menu_extra"?>")'><?php echo "EXTRA UTILITIES"?></a></li>

	<?php
	if (($_SESSION["profile"]=="adm" or isset($_SESSION["permiso"]["CENTRAL_ALL"]) or
		isset($_SESSION["permiso"]["CENTRAL_EXDBDIR"]) or
        isset($_SESSION["permiso"][$arrHttp["base"]."_CENTRAL_EXDBDIR"]))
        and isset($dirtree) and $dirtree=="Y"
    ){

    ?>
    		<li><a href='Javascript:EnviarForma("dirtree","<?php echo $msgstr["expbases"]?>")'><?php echo $msgstr["expbases"]?></a></li>
	        <li><?php echo $msgstr["explore_sys_folders"]?></li>
	        <ul>
			<li><a href='Javascript:EnviarForma("dirtree","par")'><?php echo "par"?></a></li>
			<li><a href='Javascript:EnviarForma("dirtree","www")'><?php echo "www"?></a></li>
			<li><a href='Javascript:EnviarForma("dirtree","wrk")'><?php echo "wrk"?></a></li>
	        </ul>
	<?php }?>

	<!--li><a href='javascript:EnviarForma("more_utils","<?php echo $msgstr["more_utils"]?>")'><?php echo $msgstr["more_utils"]?></a></li-->
			</ul>

		</td>
</table></form-->

</div>
</div>
<?php include("../common/footer.php");?>
</body>
</html>
