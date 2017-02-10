<?php
session_start();
if (!isset($_SESSION["login"])) die;
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../common/get_post.php");
include("../config.php");
$lang=$_SESSION["lang"];
include("../lang/dbadmin.php");
include("../lang/prestamo.php");


$rows_title[0]=$msgstr["tit_tm"];
$rows_title[1]=$msgstr["tit_tu"];
$rows_title[2]=$msgstr["tit_np"];
$rows_title[3]=$msgstr["tit_lpn"];
$rows_title[4]=$msgstr["tit_lpr"];
$rows_title[5]=$msgstr["tit_unid"];
$rows_title[6]=$msgstr["tit_renov"];
$rows_title[7]=$msgstr["tit_multa"];
$rows_title[8]=$msgstr["tit_multar"];
$rows_title[9]=$msgstr["tit_susp"];
$rows_title[10]=$msgstr["tit_suspr"];
$rows_title[11]=$msgstr["tit_reserva"];
$rows_title[12]=$msgstr["tit_permitirp"];
$rows_title[13]=$msgstr["tit_permitirr"];
$rows_title[14]=$msgstr["tit_copias"];
$rows_title[15]=$msgstr["tit_limusuario"];
$rows_title[16]=$msgstr["tit_limobjeto"];
$rows_title[17]=$msgstr["tit_inf"];

$rows_title_a[0]=$msgstr["tit_tm_a"];
$rows_title_a[1]=$msgstr["tit_tu_a"];
$rows_title_a[2]=$msgstr["tit_np_a"];
$rows_title_a[3]=$msgstr["tit_lpn_a"];
$rows_title_a[4]=$msgstr["tit_lpr_a"];
$rows_title_a[5]=$msgstr["tit_unid_a"];
$rows_title_a[6]=$msgstr["tit_renov_a"];
$rows_title_a[7]=$msgstr["tit_multa_a"];
$rows_title_a[8]=$msgstr["tit_multar_a"];
$rows_title_a[9]=$msgstr["tit_susp_a"];
$rows_title_a[10]=$msgstr["tit_suspr_a"];
$rows_title_a[11]=$msgstr["tit_reserva_a"];
$rows_title_a[12]=$msgstr["tit_permitirp_a"];
$rows_title_a[13]=$msgstr["tit_permitirr_a"];
$rows_title_a[14]=$msgstr["tit_copias_a"];
$rows_title_a[15]=$msgstr["tit_limusuario_a"];
$rows_title_a[16]=$msgstr["tit_limobjeto_a"];
$rows_title_a[17]=$msgstr["tit_inf_a"];

$archivo= $db_path."users/def/".$_SESSION["lang"]."/usuarios.tab";
if (!file_exists($archivo))  $db_path."users/def/".$lang_db."/usuarios.tab";
$fp=file($archivo);
foreach ($fp as $value){
	$value=trim($value);	if ($value!=""){		$t=explode('|',$value);
		$type_users[$t[0]]=$t[1];
	}}
unset($fp);
$archivo=$db_path."circulation/def/".$_SESSION["lang"]."/items.tab";
if (!file_exists($archivo)) $db_path."circulation/def/".$lang_db."/items.tab";
$fp=file($archivo);
foreach ($fp as $value){	$value=trim($value);
	if ($value!=""){
		$t=explode('|',$value);
		$type_items[$t[0]]=$t[1];
	}
}

include("../common/header.php");
echo "<body>";
echo "<div class=\"sectionInfo\">
			<div class=\"breadcrumb\">".
				$msgstr["policy"]."
			</div>
			<div class=\"actions\">\n";
echo "<a href=javascript:self.close() class=\"defaultButton cancelButton\">
					<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
					<span><strong>". $msgstr["cancel"]."</strong></span>
				</a>\n
			</div>
	<div class=\"spacer\">&#160;</div>
</div";
echo "<div class=\"middle form\">
	<div class=\"formContent\">";
unset($fp);
$archivo=$db_path."circulation/def/".$_SESSION["lang"]."/typeofitems.tab";
if (!file_exists($archivo)) $archivo=$db_path."circulation/def/".$lang_db."/typeofitems.tab";
$fp=file($archivo);
	$ix=0;
	echo "<table bgcolor=#cccccc>";
	echo "<tr>";
	foreach ($rows_title as $r=>$v) echo "<td bgcolor=white align=center>$v</td>";
	$ixc=count($rows_title);

	foreach ($fp as $value) {		if (trim($value!="")){			$Ti=explode('|',$value);
			echo "<tr>";
			$i=0;
			foreach ($Ti as $obj) {				$i=$ix+1;
				if ($i>$ixc) break;
				switch ($i){					case 1:
						$obj=$type_items[$obj];
						break;
					case 2:
						$obj=$type_users[$obj];
						break;				}
				echo "<td bgcolor=white>".$obj."</td>";
			}
        }
	}
echo "
  	</table>
    </div>
</div></div>";
include("../common/footer.php");
echo "</body></html>";
?>