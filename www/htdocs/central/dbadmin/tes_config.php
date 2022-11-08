<?php
/* Modifications
2021-01-05 guilda Added $msgstr["regresar"]
2022-02-01 fho4abcd buttons+div-helper+convert echo to html+correct USE/UF sequence
*/
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
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
<body >
<script language="JavaScript" type="text/javascript" src=../dataentry/js/lr_trim.js></script>
<script language="javascript" type="text/javascript">
function Enviar(){
	document.maintenance.submit()
}
</script>
<?php
include("../common/institutional_info.php");
?>
<div class="sectionInfo">
    <div class="breadcrumb">
        <?php echo $msgstr["tes_config"]. ": " . $arrHttp["base"] ?>
    </div>
    <div class="actions">
        <?php
        $backtoscript="../dbadmin/menu_modificardb.php";
        include "../common/inc_back.php";
        include "../common/inc_home.php";
        if (!isset($arrHttp["Accion"]) or $arrHttp["Accion"]!=="actualizar"){
            $savescript="javascript:Enviar()";
            include "../common/inc_save.php";
        }
        ?>
    </div>
	<div class="spacer">&#160;</div>
</div>
<?php include "../common/inc_div-helper.php";
?>
<div class="middle">
<div class="formContent" >
<form name=maintenance method=post>
<input type=hidden name=Opcion value=<?php echo $arrHttp["Opcion"]?>>
<input type=hidden name=encabezado value=<?php echo $arrHttp["encabezado"]?>>
<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>

<h2 style='text-align:center'><?php echo $msgstr["tes_config"]?></h2>
<?php
$ini=array();
$modulo=array();
$mod="";
$prefix="";$ref="";$term="";$nt="";$bt="";$rt="";$rt_inv="";$use="";$uf="";$prefixalpha="";$prefixperm="";$termpft="";$displaypft="";

$thesaurusfilebase=$arrHttp["base"]."/def/".$lang."/tesaurus.rel";
$datfilebase=$arrHttp["base"]."/def/".$lang."/".$arrHttp["base"].".dat";

$thesaurusfile=$db_path.$thesaurusfilebase;
$datfile=$db_path.$datfilebase;
if (file_exists($thesaurusfile)){
	$fp=file($thesaurusfile);
	foreach ($fp as $key=>$value){
		$value=trim($value);
		$value=preg_replace('/\s\s+/',' ',$value);
		if ($value!=""){
			$v=explode(" ",$value);
			$v[0]=strtoupper(trim($v[0]));
			switch ($v[0]){
				case "PREFIX":
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
					$use=trim($v[1]);
					$uf=trim($v[2]);
					break;
			}
		}
	}
}

if (file_exists($datfile)){
	$fp=file($datfile);
	foreach ($fp as $key=>$value){
		$value=trim($value);
		if ($value!=""){
			$v=explode('=',$value);
			switch ($v[0]){
				case "alpha_prefix":
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
					break;
			}
		}
	}
}
// Next part is executed at the first invocation
if (!isset($arrHttp["Accion"])){
    ?>
	<input type=hidden name=Accion value="actualizar">
	<table cellspacing=5 width=600 border=0 align=center style='font-size:20px;'>
    <tr>
        <th></th>
        <th colspan=4><?php echo $msgstr["tag"]?></th>
    </tr>
	<tr>
        <td style='font-size:12px;'><?php echo $msgstr["tes_descriptor"];?></td>
        <td colspan=4><input type=text name=tag_term value='<?php echo $term?>' size=5></td>
    </tr>
    <tr>
        <td style='font-size:12px;'><?php echo $msgstr["tes_nodescriptor"];?></td>
        <td colspan=4><input type=text name=tag_ref value='<?php echo $ref?>' size=5></td>
    </tr>
	<tr>
        <td style='font-size:12px;'><?php echo $msgstr["tes_prefix"];?></td>
        <td colspan=4><input type=text name=tag_prefix value="<?php echo $prefix?>" size=5></td>
    </tr>
	<tr><th colspan=5><?php echo $msgstr["tes_invrel"]?></th></tr>
    <tr>
        <th><?php echo $msgstr["tes_term"]?></th>
        <th><?php echo $msgstr["tag"]?></th>
        <th>&nbsp; &nbsp;</th>
        <th><?php echo $msgstr["tes_invrel"]?></th>
        <th><?php echo $msgstr["tag"]?></th>
    </tr>
    <tr>
        <td style='font-size:12px;'><?php echo $msgstr["tes_bt"]." (".$msgstr["tes_BT"].")"?></td>
        <td><input type=text name=tag_bt size=3 value="<?php echo $bt?>"></td>
        <td> </td>
        <td style='font-size:12px;'><?php echo $msgstr["tes_nt"]." (".$msgstr["tes_NT"].")"?></td>
        <td><input type=text name=tag_nt size=3 value="<?php echo $nt?>"></td>
    </tr>
    <tr>
        <td style='font-size:12px;'><?php echo $msgstr["tes_rt"]." (".$msgstr["tes_RT"].")"?></td>
        <td><input type=text name=tag_rt size=3 value="<?php echo $rt?>"></td>
        <td> </td>
        <td style='font-size:12px;'><?php echo $msgstr["tes_rt"]." (".$msgstr["tes_RT"].")"?></td>
        <td><input type=text name=tag_rt_inv size=3 value="<?php echo $rt_inv?>"></td>
    </tr>
    <tr>
        <td style='font-size:12px;'><?php echo $msgstr["tes_use"]." (".$msgstr["tes_USE"].")"?></td>
        <td><input type=text name=tag_use size=3 value="<?php echo $use?>"></td>
        <td> </td>
        <td style='font-size:12px;'><?php echo $msgstr["tes_uf"]." (".$msgstr["tes_UF"].")"?></td>
        <td><input type=text name=tag_uf size=3 value="<?php echo $uf?>"></td>
    </tr>
    </table>
    <p>
    <table cellspacing=5 width=600 border=0 align=center style='font-size:20px;'>
    <tr>
        <th colspan=2><?php echo $msgstr["tes_accesscnf"]?></th>
    </tr>
	<tr>
        <td style='font-size:12px;'><?php echo $msgstr["tes_accessalpha"]?></td>
        <td><input type=text name=tag_prefixalpha value='<?php echo $prefixalpha?>' size=5></td>
    </tr>
    <tr>
        <td style='font-size:12px;'><?php echo $msgstr["tes_accessperm"]?></td>
        <td><input type=text name=tag_prefixperm value='<?php echo $prefixperm?>' size=5></td>
    </tr>
    <tr>
        <td style='font-size:12px;'><?php echo $msgstr["tes_termpft"]?></td>
        <td><input type=text name=tag_termpft value='<?php echo $termpft?>' size=50></td>
    </tr>
    <tr>
        <td style='font-size:12px;'><?php echo $msgstr["tes_displaypft"];?></td>
        <td><input type=text name=tag_displaypft value='<?php echo $displaypft?>' size=5></td>
    </tr>
    </table>
    <?php
}else{
    // update/create of the config files
    $PREFIXALPHA="";
    $PREFIXPERM="";
    $TERMPFT="";
    $DISPLAYPFT="";
	if ($arrHttp["Accion"]=="actualizar"){
	   	$fp=fopen($thesaurusfile,"w");
	    foreach ($arrHttp as $key=>$Opt){
	    	if (substr($key,0,4)=="tag_"){
	    		$key=trim(substr($key,4));
	    		switch ($key){
	    			case "prefix":
	    				$PREFIX=$Opt;
	    				break;
	    			case "term":
	    				$TERM=$Opt;
	    				break;
	    			case "ref":
	    				$REF=$Opt;
	    				break;
	    			case "nt":
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

	    	}
	    }
	    if ($PREFIX!="") fwrite($fp,"PREFIX ".$PREFIX."\n");
	    if ($TERM!="")   fwrite($fp,"TERM   ".$TERM."\n");
	    if ($REF!="")    fwrite($fp,"REF    ".$REF."\n");
	    if ($BT!="")     fwrite($fp,"BT     ".$BT. "  ".$NT.    "  NT\n");
	    if ($RT!="")     fwrite($fp,"RT     ".$RT. "  ".$RT_INV."  RT\n");
	    if ($USE!="")    fwrite($fp,"USE    ".$USE."  ".$UF.    "  UF\n");
	    fclose($fp);
	    echo "<h4>$thesaurusfilebase ".$msgstr["updated"]."</h4>";

	    $fp=fopen($datfile,"w");
	    foreach ($arrHttp as $key=>$Opt){
	    	if (substr($key,0,4)=="tag_"){
	    		$key=trim(substr($key,4));
	    		switch ($key){
	    			case "prefixalpha":
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
	    echo "<h4>$datfilebase ".$msgstr["updated"]."</h4>";
	}
}
?>
</form>
</div>
</div>
<?php include("../common/footer.php");?>

