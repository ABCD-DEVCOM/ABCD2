<?php
include ("conf_opac_top.php");
$wiki_help="OPAC-ABCD_configuraci%C3%B3n#Par.C3.A1metros_globales";
include "../../common/inc_div-helper.php";
?>

<script>
var idPage="general";
</script>

<div class="middle form row m-0">
	<div class="formContent col-2 m-2">
			<?php include("conf_opac_menu.php");?>
	</div>
	<div class="formContent col-9 m-2">

<?php
if (isset($_REQUEST["Opcion"]) and $_REQUEST["Opcion"]=="Guardar") {
	$file_update=$db_path."opac_conf/opac.def";
	$fp=fopen($file_update,"w");
	?>

    <div class="alert success" onload="setTimeout(function () { window.location.reload(); }, 10)" >
		<?php echo $msgstr["updated"];?>
		<pre><?php echo $file_update; ?></pre>
	</div>

	<pre><code>
<?php
	foreach ($_REQUEST as $var=>$value){
		$value=trim($value);
		if ($value!=""){
			$var=trim($var);
			if (substr($var,0,5)=="conf_"){
				if (substr($var,5)=="OpacHttp"){
					if (substr($value,strlen($value)-1,1)!="/"){
						$value.="/";
					}
				}
				echo substr($var,5)."=".$value."\n";
				fwrite($fp,substr($var,5)."=".$value."\n");
			}
		}
	}
	echo "</code></pre>";
	fclose($fp);
	
	?>
	<a class="bt bt-green" href="javascript:EnviarForma('parametros.php')">Voltar</a>
	<?php
	exit();

}

$showhelp="";
if (file_exists($db_path."abcd.def")){
	$fp=file($db_path."abcd.def");
	foreach ($fp as $value){
		$v=explode('=',$value);
		switch($v[0]){
			case "UNICODE";
				$UNICODE=trim($v[1]);
				break;
			case "MULTIPLE_DB_FORMATS":
				$MULTIPLE_DB_FORMATS=trim($v[1]);
				break;
		}
	}
}

$opac_global_def = $db_path."/opac_conf/opac.def";
$opac_gdef = parse_ini_file($opac_global_def,true); 

if (isset( $opac_gdef['logo'])) $logo = $opac_gdef['logo']; else $logo ='';
if (isset( $opac_gdef['link_logo'])) $link_logo = $opac_gdef['link_logo'] ; else $link_logo='';
if (isset( $opac_gdef['TituloPagina'])) $titulopagina = $opac_gdef['TituloPagina'] ; else $titulopagina='';
if (isset( $opac_gdef['TituloEncabezado'])) $tituloencabezado = $opac_gdef['TituloEncabezado'] ; else $tituloencabezado;
if (isset( $opac_gdef['footer'])) $footer = $opac_gdef['footer'] ; else $footer='';
if (isset( $opac_gdef['charset'])) $charset = $opac_gdef['charset'] ; else $charset='';
if (isset( $opac_gdef['Web_Dir'])) $web_dir = $opac_gdef['Web_Dir'] ; else $web_dir=$Web_Dir;
if (isset( $opac_gdef['ONLINESTATMENT'])) $onlinestatment = $opac_gdef['ONLINESTATMENT'] ; else $onlinestatment='';
if (isset( $opac_gdef['WEBRESERVATION'])) $webreservation = $opac_gdef['WEBRESERVATION'] ; else $webreservation;
if (isset( $opac_gdef['WEBRENOVATION'])) $webrenovation = $opac_gdef['WEBRENOVATION'] ; else $webrenovation='';
if (isset( $opac_gdef['SHOWHELP'])) $showhelp = $opac_gdef['SHOWHELP'] ; else $showhelp = '';
if (isset( $opac_gdef['OpacHttp'])) $opachttp = $opac_gdef['OpacHttp'] ; else $opachttp = '';
if (isset( $opac_gdef['shortIcon'])) $shorticon = $opac_gdef['shortIcon'] ; else $shorticon = '';
if (isset( $opac_gdef['SITE_DESCRIPTION'])) $site_description = $opac_gdef['SITE_DESCRIPTION'] ; else $site_description = '';
if (isset( $opac_gdef['GANALYTICS'])) $ganalytics = $opac_gdef['GANALYTICS'] ; else $ganalytics = '';
?>


<h3><?php echo $msgstr["parametros"]." (opac.def)";?></h3>

<form name="parametros" method="post">
<input type="hidden" name="db_path" value="<?php echo $db_path;?>">
<input type="hidden" name="lang" value="<?php echo $_REQUEST["lang"];?>">
<?php
if (isset($_REQUEST["conf_level"])){
	echo "<input type=hidden name=conf_level value=".$_REQUEST["conf_level"].">\n";
}
/*
if (!isset($web_dir) or $web_dir==""){
	$web_dir=getcwd();
	$web_dir=str_replace('\\','/',$web_dir);
	$ix=strrpos($web_dir,'/');
	$web_dir=substr($web_dir,0,$ix+1);
}*/



if (!isset($opachttp)){
	$opachttp=$_SERVER["HTTP_ORIGIN"].str_replace("config/parametros.php","",$_SERVER['REQUEST_URI']);
}
if (!isset($shorticon))$shorticon="";

?>

    <table class="table striped">
    	<tr>
    		<td><?php echo $msgstr["cfg_title_page"];?></td>
    		<td valign=top><input type=text name=conf_TituloPagina size=100 value="<?php echo $titulopagina?>"></td>
    	</tr>
    	<tr>
    		<td><?php echo $msgstr["cfg_footer"];?></td>
    		<td valign=top><input type=text name=conf_footer size=100 value="<?php echo $footer?>"></td>
    	</tr>
    	<tr>
    		<td><?php echo $msgstr["cfg_Web_Dir"];?></td>
    		<td valign=top><input disabled type=text name=conf_Web_Dir size=100 value="<?php echo $web_dir?>"></td>
    	</tr>
    	<tr>
    		<td><?php echo $msgstr["cfg_SITE_DESCRIPTION"];?></td>
    		<td valign=top><input disabled type=text name=conf_SITE_DESCRIPTION size=100 value="<?php echo $site_description?>"></td>
    	</tr>
    	<tr>
    		<td><?php echo $msgstr["cfg_OpacHttp"];?></td>
    		<td valign=top><input type=text name=conf_OpacHttp size=100 value="<?php echo $opachttp?>"></td>
    	</tr>
    	<tr>
    		<td><?php echo $msgstr["cfg_g_analytics"];?></td>
    		<td valign=top><input type=text name=conf_conf_g_analytics size=100 value="<?php echo $ganalytics?>"></td>
    	</tr>
    	<tr>
    		<td><?php echo $msgstr["cfg_url_logo"];?></td>
    		<td valign=top><input type=text name=conf_logo size=100 value="<?php echo $logo?>"></td>
    	</tr>
    	<tr>
    		<td><?php echo $msgstr["cfg_link_logo"];?></td>
    		<td valign=top><input type=text name=conf_link_logo size=100 value="<?php echo $link_logo?>"></td>
    	</tr>

    	<tr>
    		<td><?php echo $msgstr["cfg_shortIcon"];?></td>
    		<td valign=top><input type=text name=conf_shortIcon size=100 value="<?php echo $shorticon?>"></td>
    	</tr>

    	<tr>
    		<td><?php echo $msgstr["cfg_ONLINESTATMENT"];?></td>
    		<td valign=top><input type=radio name=conf_ONLINESTATMENT value="Y"
    		<?php if ($onlinestatment=="Y") echo " checked"?>> Y&nbsp;&nbsp;
    		<input type=radio name=conf_ONLINESTATMENT value="N" <?php if ($onlinestatment=="N") echo " checked"?>> N</td>
    	</tr>
    	<tr>
    		<td><?php echo $msgstr["cfg_WEBRENOVATION"];?></td>
    		<td valign=top><input type=radio name=conf_WEBRENOVATION value="Y"
    		<?php if ($webrenovation=="Y") echo " checked"?>> Y &nbsp;&nbsp;
    		<input type=radio name=conf_WEBRENOVATION value="N" <?php if ($webrenovation=="N") echo " checked"?>> N</td>
    	</tr>
    	<tr>
    		<td><?php echo $msgstr["cfg_WEBRESERVATION"];?></td>
    		<td valign=top><input type=radio name=conf_WEBRESERVATION value="Y"
    		<?php if ($webreservation=="Y") echo " checked"?>> Y &nbsp;&nbsp;
    		<input type=radio name=conf_WEBRESERVATION value="N" <?php if ($webreservation=="N") echo " checked"?>> N</td>
    	</tr>
    	<tr>
    		<td><?php echo $msgstr["cfg_show_help"];?></td>
    		<td valign=top><input type=radio name=conf_SHOWHELP value="Y"
    		<?php if ($showhelp=="Y") echo " checked"?>> Y&nbsp;&nbsp;
    		<input type=radio name=conf_SHOWHELP value="N" <?php if ($showhelp=="N") echo " checked"?>> N</td>

    	</tr>
    	<tr>
    		<td valign=top><?php echo $msgstr["cfg_charset"];?></td>
    		<td valign=top>
    			<?php if (!isset($charset) and isset($UNICODE) and $UNICODE==1) $charset="UTF-8";?>
    			<input type=radio name=conf_charset value=UTF-8 <?php if (isset($charset) and $charset=="UTF-8") echo " checked"?>> UTF-8&nbsp; &nbsp;
    			<input type=radio name=conf_charset value=ISO-8859-1  <?php if (isset($charset) and $charset=="ISO-8859-1") echo " checked"?>> ISO-8859-1
			</td>
    	</tr>
    </table>
    
<input type="hidden" name="Opcion" value="Guardar">
<input type="submit" class="bt-green mt-5" value="<?php echo $msgstr["save"];?>">
</form>
</div>
</div>



<?php include ("../../common/footer.php"); ?>