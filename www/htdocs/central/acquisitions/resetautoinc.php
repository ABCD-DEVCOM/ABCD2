<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../config.php");
$lang=$_SESSION["lang"];
include("../lang/dbadmin.php");
include("../lang/acquisitions.php");

include("../common/get_post.php");
//foreach ($arrHttp as $var=>$value)  echo "$var=$value<br>";
$sep='^';
$b=explode('|',$arrHttp["base"]);
if (!isset($b[2])) $b[2]="";
$flag=$b[2];   // Y= the dababase can manage copies
$base=$b[0];
$cn_val="";
$inv_val="";
$file_cn=$db_path.$base."/data/control_number.cn";
if (file_exists($file_cn)){	$fp=file($file_cn);
	$cn_val=implode("",$fp);}
include("../common/header.php");
echo "<script src=../dataentry/js/lr_trim.js></script>"
?>
<script>
function Enviar(){	control=Trim(document.forma1.control_n.value)
	if (control=="" || control=="0"){		if (confirm("The control number of the database will be restored to 0 \n\n Is that correct? ")){			if (confirm("are you sure?")){			}else{				return			}		}else{			return		}	}
	document.forma1.submit()}

</script>
<?php
echo "<body>\n";
include("../common/institutional_info.php");


?>
<div class="sectionInfo">
	<div class="breadcrumb">
		<?php echo $msgstr["resetctl"].": $base"?>
	</div>
	<div class="actions">
<?php echo "<a href=\"../inicio.php?reinicio=s&base=".$base."$encabezado\" class=\"defaultButton cancelButton\">";
?>
					<img src="../images/defaultButton_iconBorder.gif" alt="" title="" />
					<span><strong>Cancelar</strong></span>
				</a>
	</div>
	<div class="spacer">&#160;</div>
</div>
<div class="helper">
<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/copies_configuration.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=". $_SESSION["lang"]."/copies_configuration.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: resetautoinc.php</font>\n";
echo "
	</div>
<div class=\"middle form\">
	<div class=\"formContent\">";
 echo "<form name=forma1 action=resetautoinc_update.php method=post onsubmit=\"javascript:return false\">
 <input type=hidden name=base value=$base>\n";
	echo "<table>
		<td>".$msgstr["lastcn"]."</td><td><input type=textbox name=control_n value=$cn_val></td>";
	echo "<tr><td colspan=2>&nbsp;</td>";
	echo "<table>";
	echo "<p><input type=submit name=send value=".$msgstr["update"]." onclick=Enviar()>";

echo "<form></div></div></body></html>";
?>