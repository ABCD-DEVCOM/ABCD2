<?php
function LeerTerminos($base,$Prefijo,$Pft){
global $db_path,$xWxis,$Wxis;
//	$db_path="/bases_abcd/demo_nocopies/";
	$_SESSION["lang"]="es";
	$lang_db="es";
	$IsisScript=$xWxis."ifp.xis";
	if (substr($Pft,0,1)=="@"){
		$Formato=$db_path.$base."/pfts/".$_SESSION["lang"]."/".substr($Pft,1);
		if (!file_exists($Formato)) $Formato=$db_path.$base."/pfts/".$lang_db."/".substr($Pft,1);
		$Formato="@".$Formato;
	}else{
		$Formato=$Pft;
	}
	$query ="&base=".$base ."&cipar=$db_path"."par/".$base.".par&Opcion=autoridades"."&prefijo=$Prefijo&pref=$Prefijo&count=200&postings=1&formato_e=".urlencode($Formato);
	include("../common/wxis_llamar.php");
	$contenido = array_unique ($contenido);
	$arr_combo="";
	foreach ($contenido as $value){

		$value=trim($value);
		if ($value!=""){
			$v=explode('$$$',$value);
			$value=$v[0];
			$value=str_replace("(","-",$value);
			$value=str_replace(")"," ",$value);
			if ($arr_combo==""){
			   	$arr_combo="\"$value\"";
			}else{
				$arr_combo.=",\"$value\"";
			}
		}
	}
	return $arr_combo;
}
function ComboBox($type,$tag,$width,$repetible,$pick,$pick_name,$formato_e,$Prefijo,$db_path,$base,$valor){

	echo "<script>\n
	var combolist$tag = Array(";
	switch ($pick){
		case "D":
			$arr_combo=LeerTerminos($pick_name,$Prefijo,$formato_e);
			break;
		case "P":

			$Tab_name=str_replace("%path_database%",$db_path,$pick_name);

  			$xx=explode('/',$Tab_name);
			if (count($xx)>1){
				$fp=file($Tab_name);
			}else{
				$fp=file($db_path.$base."/def/".$_SESSION["lang"]."/".$pick_name);
			}
			$arr_combo="";
			foreach ($fp as $value){
				$value=trim($value);
				if ($value!=""){
					$v=explode("|",$value);
					if ($arr_combo==""){
					   	$arr_combo="\"".$v[0]."\"";
					}else{
						$arr_combo.=",\"".$v[0]."\"";
					}
				}
			}
	}
	echo "$arr_combo)\n
	</script>\n";
	switch ($type){
		case "COMBO":
			$readonly="";
			break;
		case "COMBORO":
			$readonly=" onfocus=blur() ";
			break;
	}
	echo "<table><td valign=top>";
	echo "<input onKeyUp=\"handleKeyUp(9999999,document.forma1.combotext$tag,this,combolist$tag);\" type=\"text\" name=\"cbtag$tag\" VALUE=\"$valor\" autocomplete=\"off\" style=\"font-size:10pt;width:$width"."px;\"><br>
		<select onClick=\"handleSelectClick(this,tag$tag,$repetible);\" name=\"combotext$tag\" size=\"5\" style=\"font-size:10pt;width:$width"."px;\">
		</select></td>";
	echo "<td valign=top>";
	switch ($repetible){
		case 0: //NO ES REPETIBLE
            echo "<input type=text name=tag$tag style=\"font-size:10pt;width:$width"."px;\" value=\"$valor\" $readonly>";
            if ($type=="COMBORO")
            	echo "&nbsp; <a href=\"javascript:Limpiar(document.forma1.tag$tag)\">Clear</a>";
			break;
		case 1: //REPETIBLE
			echo "<textarea rows=5 cols=50 id=tag$tag name=tag$tag $readonly>$valor</textarea>\n";
			echo "<br><a href=\"javascript:DeleteText(document.forma1.combotext$tag,'tag$tag')\">Delete</a>";
			echo "&nbsp; <a href=\"javascript:Limpiar(document.forma1.tag$tag)\">Clear</a>";
			break;
	}
	echo "</td></table>\n";
            echo "
<script>
	document.forma1.cbtag$tag.value=\"\"
	handleKeyUp(9999999,document.forma1.combotext$tag,document.forma1.cbtag$tag,combolist$tag)
</script>";
}
?>