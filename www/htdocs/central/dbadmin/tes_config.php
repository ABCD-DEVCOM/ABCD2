<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../common/get_post.php");
//foreach ($_REQUEST  as $key=>$value)  echo "$key=$value<br>";
include ("../config.php");
$lang=$_SESSION["lang"];
include("../common/header.php");
include("../lang/admin.php");
include("../lang/soporte.php");
include("../lang/dbadmin.php");
if (!isset($_SESSION["login"])or $_SESSION["profile"]!="adm" ){
	echo "<script>
	      alert('".$msgstr["invalidright"]."')
          history.back();
          </script>";
    die;
}
$Permiso=$_SESSION["permiso"];
$BT="";
$NT="";
$RT="";
$RT_INV;
$USE="";
$UF="";
$PREFIX="";
$TERM="";
$REF="";
$PREFIXALPHA="";
$PREFIXPERM="";
$TERMPFT="";
$DISPLAYPFT="";
?>

<script language="JavaScript" type="text/javascript" src=../dataentry/js/lr_trim.js></script>
<script language="javascript" type="text/javascript">
function Enviar(){	document.maintenance.submit()}
</script>
<body >
<?php

	include("../common/institutional_info.php");
echo "
	<div class=\"sectionInfo\">
			<div class=\"breadcrumb\">".
				$msgstr["tes_config"]. ": " . $arrHttp["base"]."
			</div>
			<div class=\"actions\">

	";
echo "<a href=\"../dbadmin/menu_modificardb.php?reinicio=s&base=".$arrHttp["base"]."&encabezado=".$arrHttp["encabezado"]."\" class=\"defaultButton backButton\">";
echo "<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
	<span><strong>Regresar</strong></span></a>";
if (!isset($arrHttp["Accion"]) or $arrHttp["Accion"]!=="actualizar"){
	echo "<a href=\"javascript:Enviar()\" class=\"defaultButton saveButton\">";
	echo "
			<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
			<span><strong>". $msgstr["save"]."</strong></span>
			</a>";
}
echo "</div>
	<div class=\"spacer\">&#160;</div>
	</div>";
?>
<div class="helper">
<?php
echo "&nbsp; &nbsp; <a href=http://abcdwiki.net/wiki/es/index.php?title=Tesauros target=_blank>". $msgstr["help"].": abcdwiki.net</a>";

?>
</font>
</div>
<div class="middle">
	<div class="formContent" >
<form name=maintenance method=post>
<input type=hidden name=Opcion value=<?php echo $arrHttp["Opcion"]?>>
<input type=hidden name=encabezado value=<?php echo $arrHttp["encabezado"]?>>

<?php
echo "<center><strong><font style='font-size:14px;'>".$msgstr["tes_config"]."</font></strong></center>";
$ini=array();
$modulo=array();
$mod="";
$prefix="";$ref="";$term="";$nt="";$bt="";$rt="";$rt_inv="";$use="";$uf="";$prefixalpha="";$prefixperm="";$termpft="";$displaypft="";
$file=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/tesaurus.rel";
if (file_exists($file)){
	$fp=file($file);
	foreach ($fp as $key=>$value){
		$value=trim($value);
		$value=preg_replace('/\s\s+/',' ',$value);
		if ($value!=""){
			$v=explode(" ",$value);
			$v[0]=strtoupper(trim($v[0]));
			switch ($v[0]){				case "PREFIX":
					$prefix=trim($v[1]);
					break;
				case "REF":
					$ref=trim($v[1]);
					break;
				case "TERM":
					$term=trim($v[1]);
					break;
				case "BT":
					$bt=trim($v[1]);
					$nt=trim($v[2]);
					break;
				case "RT":
					$rt=trim($v[1]);
					$rt_inv=trim($v[2]);
					break;
				case "USE":
					$uf=trim($v[1]);
					$use=trim($v[2]);
					break;			}
		}
	}
}
$file=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$arrHttp["base"].".dat";
if (file_exists($file)){
	$fp=file($file);
	foreach ($fp as $key=>$value){		$value=trim($value);
		if ($value!=""){			$v=explode('=',$value);
			switch ($v[0]){				case "alpha_prefix":
					$prefixalpha=$v[1];
					break;
				case "perm_prefix":
					$prefixperm=$v[1];
					break;
				case "alpha_pft":
					$termpft=$v[1];
					break;
				case "display":
					$displaypft=$v[1];
					break;			}		}
	}
}
if (isset($arrHttp["base"]))
	echo "<input type=hidden name=base value=".$arrHttp["base"].">\n";
if (!isset($arrHttp["Accion"])){	echo "<input type=hidden name=Accion value=\"actualizar\">\n";	echo "<table cellspacing=5 width=600 border=0 align=center style='font-size:20px;'>";
	echo "<td></td><td colspan=4><font style='font-size:14px;'><strong>".$msgstr["tag"]."</strong></font></td>\n";
	echo "<tr><td style='font-size:12px;'>";
	echo $msgstr["tes_descriptor"];
	echo "</td>";
	echo "<td colspan=4>";
	echo "<input type=text name=tag_term value='$term' size=5>";
	echo "</td></tr>";
	echo "<tr><td style='font-size:12px;'>";
	echo $msgstr["tes_nodescriptor"];
	echo "</td>";
	echo "<td colspan=4>";
	echo "<input type=text name=tag_ref value='$ref' size=5>";
	echo "</td></tr>";
	echo "<tr><td style='font-size:12px;'>";
	echo $msgstr["tes_prefix"];
	echo "</td>";
	echo "<td colspan=4>";
    echo "<input type=text name=tag_prefix value=\"$prefix\" size=5>";
	echo "</td></tr>";
	echo "<tr><td colspan=5><p><font style='font-size:14px;'><strong>";
	echo $msgstr["tes_invrel"]."</strong></font>";
	echo "</td>";
	echo "<tr><td><font style='font-size:14px;'><strong>".$msgstr["tes_term"]."</font></strong></td>";
	echo "<td><font style='font-size:14px;'><strong>".$msgstr["tag"]."</font></strong></td>";
	echo "<td>&nbsp; &nbsp;</td><td><font style='font-size:14px;'><strong>".$msgstr["tes_invrel"]."</font></strong></td>";
	echo "<td><font style='font-size:14px;'><strong>".$msgstr["tag"]."</font></strong></td>";
	echo "</tr>";
	echo "<tr><td style='font-size:12px;'>";
	echo $msgstr["tes_bt"]." (".$msgstr["tes_BT"].")</td>";
	echo "<td><input type=text name=tag_bt size=3 value=".$bt."></td>";
	echo "<td> </td>";
	echo "<td style='font-size:12px;'>";
	echo $msgstr["tes_nt"]." (".$msgstr["tes_NT"].")</td>";
	echo "<td><input type=text name=tag_nt size=3 value=".$nt."></td>";
	echo "</tr>";
	echo "<tr><td style='font-size:12px;'>";
	echo $msgstr["tes_rt"]." (".$msgstr["tes_RT"].")</td>";
	echo "<td><input type=text name=tag_rt size=3 value=".$rt."></td>";
	echo "<td> </td>";
	echo "<td style='font-size:12px;'>";
	echo $msgstr["tes_rt"]." (".$msgstr["tes_RT"].")</td>";
	echo "<td><input type=text name=tag_rt_inv size=3 value=".$rt_inv."></td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td style='font-size:12px;'>";
	echo $msgstr["tes_use"]." (".$msgstr["tes_USE"].")</td>";
	echo "<td><input type=text name=tag_use size=3 value=".$use."></td>";
	echo "<td> </td>";
	echo "<td style='font-size:12px;'>";
	echo $msgstr["tes_uf"]." (".$msgstr["tes_UF"].")</td>";
	echo "<td><input type=text name=tag_uf size=3 value=".$uf."></td>";
	echo "</tr>";
	echo "</table>\n";
	echo "<p>";
	echo "<table cellspacing=5 width=600 border=0 align=center style='font-size:20px;'>";
	echo "<tr><td colspan=2><font style='font-size:14px;'><strong>".$msgstr["tes_accesscnf"]."</strong></font></td></tr>\n";
	echo "<tr><td width=172 style='font-size:12px;' >";
	echo $msgstr["tes_accessalpha"];
	echo "</td>";
	//echo "<td width=100> &nbsp; &nbsp; </td>";
	echo "<td width=328>";
	echo "<input type=text name=tag_prefixalpha value='$prefixalpha' size=5>";
	echo "</td></tr>";
	echo "<tr><td style='font-size:12px;'>";
	echo $msgstr["tes_accessperm"];
	echo "</td>";
	//echo "<td> &nbsp; &nbsp; </td>";
	echo "<td>";
	echo "<input type=text name=tag_prefixperm value='$prefixperm' size=5>";
	echo "</td></tr>";
	echo "<tr><td style='font-size:12px;'>";
	echo $msgstr["tes_termpft"];
	echo "</td>";
	//echo "<td> &nbsp; &nbsp; </td>";
	echo "<td>";
	echo "<input type=text name=tag_termpft value='$termpft' size=50>";
	echo "</td></tr>";
	echo "<tr><td style='font-size:12px;'>";
	echo $msgstr["tes_displaypft"];
	echo "</td>";
	//echo "<td> &nbsp; &nbsp; </td>";
	echo "<td>";
	echo "<input type=text name=tag_displaypft value='$displaypft' size=5>";
	echo "</td></tr>";
	echo "</table>\n";
}else{
$PREFIXALPHA="";
$PREFIXPERM="";
$TERMPFT="";
$DISPLAYPFT="";	if ($arrHttp["Accion"]=="actualizar"){
		$file=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/tesaurus.rel";
	   	$fp=fopen($file,"w");
	    foreach ($arrHttp as $key=>$Opt){	    	if (substr($key,0,4)=="tag_"){	    		$key=trim(substr($key,4));	    		switch ($key){
	    			case "prefix":
	    				$PREFIX=$Opt;
	    				break;
	    			case "term":
	    				$TERM=$Opt;
	    				break;
	    			case "ref":
	    				$REF=$Opt;
	    				break;	    			case "nt":
	    				$NT=$Opt;
	    				break;
	    			case"bt":
	    				$BT=$Opt;
	    				break;
	    			case "rt":
	    				$RT=$Opt;
	    				break;
	    			case "rt_inv":
	    				$RT_INV=$Opt;
	    				break;
	    			case "use":
	    				$USE=$Opt;
	    				break;
	    			case "uf":
	    				$UF=$Opt;
	    				break;
	    		}

	    	}	    }
	    if ($PREFIX!="") fwrite($fp,"PREFIX ".$PREFIX."\n");
	    if ($TERM!="")   fwrite($fp,"TERM   ".$TERM."\n");
	    if ($REF!="")    fwrite($fp,"REF    ".$REF."\n");
	    if ($BT!="")     fwrite($fp,"BT     ".$BT. "  ".$NT.    "  NT\n");
	    if ($RT!="")     fwrite($fp,"RT     ".$RT. "  ".$RT_INV."  RT\n");
	    if ($USE!="")    fwrite($fp,"USE    ".$USE."  ".$UF.    "  UF\n");
	    fclose($fp);
	    echo "<h4>$file ".$msgstr["updated"]."</h4>";
	    $file=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$arrHttp["base"].".dat";
	    $fp=fopen($file,"w");
	    foreach ($arrHttp as $key=>$Opt){
	    	if (substr($key,0,4)=="tag_"){
	    		$key=trim(substr($key,4));
	    		switch ($key){	    			case "prefixalpha":
	    				$PREFIXALPHA=$Opt;
	    				break;
	    			case "prefixperm":
	    				$PREFIXPERM=$Opt;
	    				break;
	    			case "termpft":
	    				$TERMPFT=$Opt;
	    				break;
	    			case "displaypft":
	    				$DISPLAYPFT=$Opt;
	    				break;
	    		}
	   		}
		}
		if ($PREFIXALPHA!="") fwrite($fp,"alpha_prefix=".$PREFIXALPHA."\n");
	    if ($PREFIXPERM!="")  fwrite($fp,"perm_prefix=" .$PREFIXPERM."\n");
	    if ($TERMPFT!="")     fwrite($fp,"alpha_pft="   .$TERMPFT."\n");
	    if ($DISPLAYPFT!="")  fwrite($fp,"display="     .$DISPLAYPFT."\n");
		fclose($fp);
	    echo "<h4>$file ".$msgstr["updated"]."</h4>";
	}}
?>
</form>
</div>
</div>
<?php include("../common/footer.php");?>
</body>
</html>
