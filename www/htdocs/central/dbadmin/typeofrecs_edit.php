<?php
/*
20220121 fho4abcd buttons+html cleanup+div-helper
*/
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include("../config.php");
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";

include("../lang/dbadmin.php");
$lang=$_SESSION["lang"];
include("../common/header.php");
?>
<body>
<script language="JavaScript" type="text/javascript" src="../dataentry/js/lr_trim.js"></script>

<script language=javascript>

function EnviarTipoR(){
	if (Trim(document.tipordef.tipom.value)==""){
		alert("<?php echo $msgstr["typeofrecords_new"]?>")
		return
	}
	document.tipordef.submit()
}

function Enviar(rows){
	err=false
	for (i=1;i<rows;i++){
		c1=""
		c2=""
		c3=""
		c4=""
		tr=0
		for (j=1;j<5;j++){
			Ctrl=eval("document.tor.cell"+i+"_"+j)
			switch (j){
				case 1:
					c1=Ctrl.value
					break
				case 2:
					c2=Trim(Ctrl.value)
					if (c2=="")
					break
				case 3:
					c3=Trim(Ctrl.value )
					if (c3=="")
					break
				case 4:
					c4=Ctrl.value
					break
			}
		}
		if (c1+c2+c3+c4==""){

		}else{
			if (c1=="" || (c2=="" && c3=="") || c4==""){
				alert ("<?php echo $msgstr["typeofrecerror"]?>")
				err=true
			}else{
				if (c2==""){
					Ctrl=eval("document.tor.cell"+i+"_"+2)
					Ctrl.value="_"
				}
				if (c3==""){
					Ctrl=eval("document.tor.cell"+i+"_"+3)
					Ctrl3=Ctrl
					Ctrl.value="_"
				}
				tr++
			}
		}
	}


    if (err==false) document.tor.submit();
}


</script>
<?php if (isset($arrHttp["encabezado"])){
    include("../common/institutional_info.php");
    $encabezado="&encabezado=s";
}else{
	$encabezado="";
}
?>
<div class="sectionInfo">
    <div class="breadcrumb">
        <?php echo $msgstr["typeofrecords"].": ".$arrHttp["base"]?>
    </div>
    <div class="actions">
        <?php
        $backtocancelscript="menu_modificardb.php";
        include "../common/inc_cancel.php";
        include "../common/inc_home.php";
        ?>
    </div>
    <div class="spacer">&#160;</div>
</div>
<?php $ayudad="typeofrecs.html"; include "../common/inc_div-helper.php"?>
<div class="middle form">
    <div class="formContent">
<br><center>
<?php
$archivo=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/formatos.wks";
if (!file_exists($archivo))
	$archivo=$db_path.$arrHttp["base"]."/def/".$lang_db."/formatos.wks";
if (!file_exists($archivo)){
	echo "<p><span class=title>".$msgstr["typeofrecnowks"];
	if (!isset($arrHttp["encabezado"]))
		echo "<p><a href=menu_modificardb.php?base=".$arrHttp["base"].">".$msgstr["back"]."</a><p>";
	die;
}

$fp = file($archivo);
foreach ($fp as $linea){
	$fmt[]=$linea;
}
$archivo=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/typeofrecord.tab";
if (!file_exists($archivo))
    $archivo=$db_path.$arrHttp["base"]."/def/".$lang_db."/typeofrecord.tab";
if (!file_exists($archivo)){
?>
<p>
	<form name=tipordef method=post action=typeofrecs_update.php onsubmit='javascript:return false'>
	<input type=hidden name=Opcion value=tipom>
	<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
	<?php if (isset($arrHttp["encabezado"])) echo "<input type=hidden name=encabezado value=s>";?>

    <table border=0 >
	<tr>
		<td valign=top colspan=2><?php echo $msgstr["typeofrecords_new"];?></td>
	</tr>
	<tr>
		<td width=80><?php echo $msgstr["tag"]." 1"?></td><td><input type=text name=tipom value='' size=4></td>
	</tr>
	<tr>
		<td width=80><?php echo $msgstr["tag"]." 2"?></td><td><input type=text name=nivelr value='' size=4></td>
	</tr>

</table><p>
<button class="bt-green" type="button"
    title="<?php echo $msgstr["save"]?>"
    onclick="javascript:EnviarTipoR()" >
    <i class="far fa-save"></i>&nbsp;<?php echo $msgstr["save"]?> </button>
</form>
</div></div></center>
<?php
include("../common/footer.php");
	die;
}
echo "<form name=tor method=post action=typeofrecs_update.php onsubmit='return false'>
<input type=hidden name=base value=".$arrHttp["base"].">\n";
if (isset($arrHttp["encabezado"])) echo "<input type=hidden name=encabezado value=s>";
$archivo=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/typeofrecord.tab";
if (!file_exists($archivo))
    $archivo=$db_path.$arrHttp["base"]."/def/".$lang_db."/typeofrecord.tab";
$fp = file($archivo);
$ix=0;

$j=0;
if ($fp) {
	foreach($fp as $linea){
		if (trim($linea)!="") {
			$linea=trim($linea);
			if ($ix==0){
				$ixpos=strpos($linea," ");
				if ($ixpos===false){
					$tipom=trim($linea);
					$nivelr="";
				}else{
					$tipom=trim(substr($linea,0,$ixpos));
					$nivelr=trim(substr($linea,$ixpos+1));
				}
				echo "
<table border=0 width=450>
	<tr>
		<TD valign=top colspan=2>" .$msgstr["typeofrecords_new"]." ". $msgstr["typeofrecords_tags"]."</td>
	</tr>
	<tr>
		<td width=80>".$msgstr["tag"]." 1</td><td width=400><input type=text name=tipom value='$tipom' size=3></td>
	</tr>
	<tr>
		<td>".$msgstr["tag"]." 2</td><td><input type=text name=nivelr value='$nivelr' size=3></td>
	</tr>

</table><p>\n";
				$ix=1;
				echo "<table>";
				echo "<tr><td align=center>".$msgstr["fmt"]."</td><td align=center>".$msgstr["tag"]." 1 ".$msgstr["value"]."</td><td align=center>".$msgstr["tag"]." 2 ".$msgstr["value"]."</td><td align=center>".$msgstr["typeofrecords"]." ".$msgstr["description"]."</td><td>";
			}else{
				$j=$j+1;
				$i=0;
				$l=explode('|',$linea);
				echo "<tr>";
				foreach ($l as $value) {
					$value=trim($value);
					$i=$i+1;
					if ($i==1){
						echo "<td><select name=cell$j"."_".$i.">
						<option value=\"\"></option>-- ";
						foreach ($fmt as $f){
							$xxtm=explode('|',$f);
							$xselected="";
							if ($xxtm[0].".fmt"==$l[0]) $xselected=" selected";
							echo "<option value=\"".$xxtm[0].".fmt\"$xselected>".trim($xxtm[1])." (".$xxtm[0].")\n";
						}
						echo "</select></td>";
					}else{
						switch ($i){
							case 2:
							case 3:
								$xsize=" size=10";
								break;
							case 4:
								$xsize=" size=30";
								break;
						}
						echo "<td><input type=text name=cell$j"."_".$i." value=\"$value\" $xsize></td>";
					}
				}
			}
		}
	}
}

for ($k=$j+1;$k<$j+8;$k++){
	$i=0;
	$linea="|||";
	$l=explode('|',$linea);
	echo "<tr>";
	foreach ($l as $value) {
		$i=$i+1;
		$value=trim($value);

		if ($i==1){
			echo "<td><select name=cell$k"."_".$i.">
			<option value=\"\"></option> ";
			foreach ($fmt as $f){
				$xxtm=explode('|',$f);
				echo "<option value=\"".$xxtm[0].".fmt\">".trim($xxtm[1])." (".$xxtm[0].")\n";
			}
			echo "</select></td>";
		}else{
			switch ($i){
				case 2:
				case 3:
					$xsize=" size=10";
					break;
				case 4:
					$xsize=" size=30";
					break;
			}
			echo "<td><input type=text name=cell$k"."_".$i." value=\"$value\" $xsize></td>";
		}
	}
}
?>
</table>
<p>
<button class="bt-green" type="button"
    title="<?php echo $msgstr["update"]?>"
    onclick="javascript:Enviar(<?php echo $k;?>)" >
    <i class="far fa-save"></i>&nbsp;<?php echo $msgstr["update"]?> </button>

</form>
</center>
</div></div>
<?php include("../common/footer.php");?>

