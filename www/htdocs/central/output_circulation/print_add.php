<?php

//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include ("../config.php");
include ("../lang/admin.php");
include ("../lang/dbadmin.php");
include ("../lang/prestamo.php");

if (!isset($_SESSION["login"])){	echo $msgstr["sessionexpired"];
	die;}
include("../common/header.php");
//foreach ($arrHttp as $var=>$value)  echo "$var=$value<br>";

// ==================================================================================================
// INICIO DEL PROGRAMA
// ==================================================================================================

//

include("../common/institutional_info.php");
?>
<script src=../dataentry/js/lr_trim.js></script>
<script>
	function LeerFst(base){		msgwin=window.open("../dbadmin/fst_leer.php?base="+base,"fst","width=400,height=400,resizable,scrollbars=yes")
		msgwin.focus()	}
	function Guardar(){
		if (Trim(document.forma1.code.value)==""){			alert("<?php echo $msgstr["falta"]. " ".$msgstr["o_code"]?>")
			return		}

        if (Trim(document.forma1.pft.value)==""){
			alert("<?php echo $msgstr["falta"]. " ".$msgstr["o_pft_name"]?>")
			return
		}
		code=document.forma1.pft.value
		ix=code.indexOf(".php")
		if (ix==-1){
			if (Trim(document.forma1.heading.value)==""){
				alert("<?php echo $msgstr["falta"]. " ".$msgstr["o_rows"]?>")
				return
			}
			if (Trim(document.forma1.expresion.value)==""){
				alert("<?php echo $msgstr["falta"]. " ".$msgstr["o_search"]?>")
				return
			}
		}
		if (Trim(document.forma1.title.value)==""){
			alert("<?php echo $msgstr["falta"]. " ".$msgstr["o_title"]?>")
			return
		}
		document.forma1.submit()	}
</script>
<div class="sectionInfo">
	<div class="breadcrumb">
	<?php echo $msgstr["new_report"]?>
	</div>
	<div class="actions">
		<a href="menu.php" class="defaultButton backButton">
		<img src="../images/defaultButton_iconBorder.gif" alt="" title="" />
		<span><strong><?php echo $msgstr["back"];?></strong></span></a>
		<a href=javascript:Guardar() class="defaultButton saveButton">
			<img src="../images/defaultButton_iconBorder.gif" alt="" title="" />
			<span><strong><?php echo $msgstr["update"]?></strong></span>
		</a>
	</div>

<div class="spacer">&#160;</div>
</div>
<div class="helper">
<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/circulation/reports.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/circulation/reports.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: output_circulation/print_add.php";
?>
</font>
	</div>
<form name=forma1 method=post action=print_add_ex.php>
<div class="middle form">
	<div class="formContent">
	<table bgcolor=#cccccc >
<?php
	$base[]="trans";
	$base[]="suspml";
	$base[]="reserve";
	$code="";
	$pft_name="";
	$rows="";
	$sort="";
	$search="";
	$title="";
	$ask_date="";
	$tag_date_trans="40";
	$tag_date_suspml_1="60";
	$tag_date_suspml_2="110";
	$ask_usertype="";
	$tag_usertype="70";
	$ask_itemtype="";
	$tag_itemtype="80";
	$tag="";
	if (isset($arrHttp["base"]) and isset($arrHttp["codigo"])){
		$bd=$arrHttp["base"];
		if (file_exists($db_path."$bd/pfts/".$_SESSION["lang"]."/outputs.lst")){			$fp=file($db_path."$bd/pfts/".$_SESSION["lang"]."/outputs.lst");
			$ix=0;
			foreach ($fp as $value){				$value=trim($value);
				if (substr($value,0,2)!="//") {					$t=explode("|",$value);

					if ($t[0]==$arrHttp["codigo"]){						$code=$t[0];
						$pft_name=$t[1];
						$rows=$t[2];
						$sort=$t[3];
						$search=$t[4];
						$title=$t[5];
						if (isset($t[6])){
							switch ($t[6]){								case "DATE":
									$ask_date=$t[6];

									break;
								case "DATEQUAL":
									$ask_date=$t[6];
									break;
								case "USERTYPE":
									$ask_usertype=$t[6];
									break;
								case "ITEMTYPE":
									$ask_itemtype=$t[6];
									break;							}
						}else{						}
						if (isset($t[7])) $tag=$t[7];
						break;					}				}			}		}
	}
	echo "<tr><td bgcolor=white width=200>".$msgstr["database"]."</td>";
	echo "<td bgcolor=white>";
	foreach ($base as $value){
		echo "<input type=radio name=base value=$value";
		if ($value==$bd) echo " checked";
		echo ">$value&nbsp; &nbsp;";
		echo "<a href=javascript:LeerFst('$value')>FDT/FST</a>";
	}
	echo "</td>";
	echo "<tr><td bgcolor=white valign=top>".$msgstr["o_code"]."</td>";
	echo "<td bgcolor=white valign=top><input type=text name=code value=\"".$code."\"></td>";
	echo "<tr><td bgcolor=white valign=top>".$msgstr["o_pft_name"]."</td>";
	echo "<td bgcolor=white><input type=text name=pft value=\"".$pft_name."\">&nbsp; &nbsp; <a href=../dbadmin/leertxt.php?base=trans&desde=recibos&archivo=$pft_name target=_blank>".$msgstr["edit"]."</a></td>";
	echo "<tr><td bgcolor=white valign=top>".$msgstr["o_rows"]."</td>";
	$rows=str_replace("#","\n",$rows);
	echo "<td bgcolor=white valign=top><textarea name=heading cols=30 rows=3>$rows</textarea></td>";
	echo "<tr><td bgcolor=white valign=top>".$msgstr["o_sort"]."</td>";
	echo "<td bgcolor=white valign=top><textarea cols=100 rows=2 name=sort>$sort</textarea></td>";
	echo "<tr><td bgcolor=white valign=top>".$msgstr["o_search"]."</td>";
	echo "<td bgcolor=white valign=top><textarea cols=100 rows=2 name=expresion>$search</textarea></td>";
	echo "<tr><td bgcolor=white valign=top>".$msgstr["o_title"]."</td>";
	echo "<td bgcolor=white valign=top><input type=text name=title size=100 value=\"".$title."\"></td>";
	echo "<tr><td colspan=2 bgcolor=white><table border=0 bgcolor=#dddddd width=100%>";
	echo "<tr><td align=center width=200><font size=2>".$msgstr["o_ask"]."</td>";
	echo "<td align=center><font size=2>( ".$msgstr["basedatos"].": trans)</font></td>";
	echo "<td align=center><font size=2>( ".$msgstr["basedatos"].": suspml)</font></td>";
	echo "<tr><td bgcolor=white valign=top>".$msgstr["date"]."</td>";
	echo "<td bgcolor=white valign=top><input type=radio name=ask value=\"DATE_40\"";
	if ($ask_date=="DATE" and $tag_date_trans==$tag) echo " checked";
	echo ">";
	echo $msgstr["o_compare"]." >= ".$msgstr["tag"].": $tag_date_trans (".$msgstr["devdate"].")";
	echo "</td>";

	echo "<td bgcolor=white valign=top><input type=radio name=ask value=\"DATE_60\"";
	if ($ask_date=="DATE" and $tag_date_suspml_1==$tag) echo " checked";
	echo ">";
	echo $msgstr["o_compare"]." >= ".$msgstr["tag"].": $tag_date_suspml_1 (".$msgstr["o_paymentdate"].")";
	echo "</td>";
    echo "<tr><td bgcolor=white valign=top>".$msgstr["date"]."</td>";
	echo "<td bgcolor=white valign=top><input type=radio name=ask value=\"DATEQUAL_40\"";
	if ($ask_date=="DATEQUAL"  and $tag_date_trans==$tag) echo " checked";
	echo ">";
	echo $msgstr["o_compare"]." = &nbsp; ".$msgstr["tag"].": $tag_date_trans (".$msgstr["devdate"].")";
	echo "</td>";
	echo "<td bgcolor=white valign=top><input type=radio name=ask value=\"DATEQUAL_60\"";
	if ($ask_date=="DATEQUAL"  and $tag_date_suspml_1==$tag) echo " checked";
	echo ">";
	echo $msgstr["o_compare"]." = &nbsp; ".$msgstr["tag"].": $tag_date_suspml_1 (".$msgstr["o_paymentdate"].")";
	echo "</td>";
	echo "<tr><td bgcolor=white valign=top>".$msgstr["date"]."</td>";
	echo "<td bgcolor=white valign=top>";
	echo "<input type=radio name=ask value=\"DATELESS_40\"";
	if ($ask_date=="DATELESS"  and $tag_date_trans==$tag) echo " checked";
	echo ">";
	echo $msgstr["o_compare"]." <= &nbsp; ".$msgstr["tag"].": $tag_date_trans (".$msgstr["devdate"].")";
	echo "</td>";
	echo "</td>";

	echo "<td bgcolor=white valign=top><input type=radio name=ask value=\"DATE_110\"";
	if ($ask_date=="DATE" and $tag_date_suspml_2==$tag) echo " checked";
	echo ">";
	echo $msgstr["o_compare"]." >= ".$msgstr["tag"].": $tag_date_suspml_2 (".$msgstr["o_canceldate"].")";
	echo "</td>";
    echo "<tr><td bgcolor=white valign=top>".$msgstr["date"]."</td>";
	echo "<td bgcolor=white valign=top> </td>";
	echo "<td bgcolor=white valign=top><input type=radio name=ask value=\"DATEQUAL_110\"";
	if ($ask_date=="DATEQUAL" and $tag_date_suspml_2==$tag) echo " checked";
	echo ">";
	echo $msgstr["o_compare"]." = &nbsp; ".$msgstr["tag"].": $tag_date_suspml_2 (".$msgstr["o_canceldate"].")";
	echo "</td>";

	echo "<tr><td bgcolor=white valign=top>".$msgstr["typeofusers"]."</td>";
	echo "<td bgcolor=white valign=top><input type=radio name=ask value=\"USERTYPE\"";
	if ($ask_usertype=="USERTYPE") echo " checked";
	echo ">";
	echo $msgstr["o_compare"]." = &nbsp; ".$msgstr["tag"].": $tag_usertype";
	echo "</td><td bgcolor=white></td>";
	echo "<tr><td bgcolor=white valign=top>".$msgstr["typeofitems"]."</td>";
	echo "<td bgcolor=white valign=top><input type=radio name=ask value=\"ITEMTYPE\"";
	if ($ask_itemtype=="ITEMTYPE") echo " checked";
	echo ">";
	echo $msgstr["o_compare"]." = &nbsp; ".$msgstr["tag"].": $tag_itemtype";
	echo "</td><td bgcolor=white></td>";
	echo "<tr><td bgcolor=white valign=top>".$msgstr["o_noask"]."</td>";
	echo "<td bgcolor=white valign=top><input type=radio name=ask value=\"\"";
	echo ">";
	echo "</td><td bgcolor=white> </td>";
	echo "</table></td>";
    echo "


</table>
<p>";
   if (isset($arrHttp["codigo"])){   	   echo $msgstr["saveas"];
   	   echo "&nbsp;&nbsp;<input type=text name=saveas size=15>&nbsp;";   }
?>

</form>
<p>
</div>
</div>
<?php
include("../common/footer.php");
?>
</body>
</html>
