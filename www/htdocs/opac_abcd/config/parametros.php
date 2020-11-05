<?php
include ("tope_config.php");
$wiki_help="wiki.abcdonline.info/index.php?desde=ayuda&title=OPAC-ABCD_configuraci%C3%B3n#Par.C3.A1metros_globales";
$wiki_trad="wiki.abcdonline.info/index.php?title=OPAC-ABCD_configuraci%C3%B3n#Par.C3.A1metros_globales";
if (isset($_REQUEST["Opcion"]) and $_REQUEST["Opcion"]=="Guardar"){
	$fp=fopen($db_path."/opac_conf/opac_abcd.def","w");	foreach ($_REQUEST as $var=>$value){		$value=trim($value);
		if ($value!=""){			$var=trim($var);
			if (substr($var,0,5)=="conf_"){				if (substr($var,5)=="OpacHttp"){					if (substr($value,strlen($value)-1,1)!="/"){						$value.="/";					}				}
				echo substr($var,5)."=".$value."<br>";
				fwrite($fp,substr($var,5)."=".$value."\n");			}		}	}
	fclose($fp);
    echo "<p><font color=red>opac_conf/opac_abcd.def ".$msgstr["updated"]."</font><p>";
	include("../php/footer.php");	die;}
$UNICODE="";
$MULTIPLE_DB_FORMATS="";
$WEBRESERVATION="";
$WEBRENOVATION="";
$ONLINESTATMENT="";
$showhelp="";
if (file_exists($db_path."abcd.def")){	$fp=file($db_path."abcd.def");
	foreach ($fp as $value){
		$v=explode('=',$value);
		switch($v[0]){			case "UNICODE";
				$UNICODE=trim($v[1]);
				break;
			case "MULTIPLE_DB_FORMATS":
				$MULTIPLE_DB_FORMATS=trim($v[1]);
				break;		}	}}
if (file_exists($db_path."opac_conf/opac_abcd.def")){	$fp=file($db_path."opac_conf/opac_abcd.def");
	foreach ($fp as $value){
		if (trim($value)!=""){			$a=explode('=',$value);
			switch ($a[0]){
				case "Web_Dir":
					$Web_Dir=trim($a[1]);
					break;
				case "OpacHttp":
					$OpacHttp=trim($a[1]);
					break;
				case "styles":
				    $styles=trim($a[1]);
					break;
				case "logo":
					$logo=trim($a[1]);
					break;
				case "link_logo":
				    $link_logo=trim($a[1]);
					break;
				case "TituloPagina":
				    $TituloPagina=trim($a[1]);
					break;
				case "shortIcon":
				    $shortIcon=trim($a[1]);
					break;
				case "WEBRESERVATION":
					$WEBRESERVATION=trim($a[1]);
					break;
				case "WEBRENOVATION":
					$WEBRENOVATION=trim($a[1]);
					break;
				case "ONLINESTATMENT":
					$ONLINESTATMENT=trim($a[1]);
					break;
				case "multiple_db_formats":
					$multiple_db_formats=trim($a[1]);
					break;


				case "footer":
				    $footer=trim($a[1]);
					break;
				case "CentralHttp":
				    $CentralHttp=trim($a[1]);
					break;
				case "charset":
				    $charset=trim($a[1]);
					break;
				case "SHOWHELP":
				    $showhelp=trim($a[1]);
					break;


			}		}	}}
?>
<form name=parametros method=post>
<input type=hidden name=db_path value=<?php echo $db_path;?>>
<input type=hidden name=lang value=<?php echo $_REQUEST["lang"];?>>
<?php
if (isset($_REQUEST["conf_level"])){
	echo "<input type=hidden name=conf_level value=".$_REQUEST["conf_level"].">\n";
}

if (!isset($Web_Dir) or $Web_Dir==""){
	$Web_Dir=getcwd();
	$Web_Dir=str_replace('\\','/',$Web_Dir);
	$ix=strrpos($Web_Dir,'/');
	$Web_Dir=substr($Web_Dir,0,$ix+1);
}
if (!isset($OpacHttp)){	$OpacHttp=$_SERVER["HTTP_ORIGIN"].str_replace("config/parametros.php","",$_SERVER['REQUEST_URI']);
}
if (!isset($shortIcon))$shortIcon="";
?>
<div id="page">
	<p>
    <h3>
    <?php
    echo $msgstr["parametros"]." (opac_abcd.def) &nbsp;";
    include("wiki_help.php");
 ?>
    <table cellpading=5>
    	<tr><td colspan=2 bgcolor=#cccccc>&nbsp;</td></tr>
    	<tr>
    		<td><?php echo $msgstr["Web_Dir"];?></td>
    		<td valign=top><input type=text name=conf_Web_Dir size=100 value="<?php echo $Web_Dir?>"></td>
    	</tr>
    	<tr>
    		<td><?php echo $msgstr["OpacHttp"];?></td>
    		<td valign=top><input type=text name=conf_OpacHttp size=100 value="<?php echo $OpacHttp?>"></td>
    	</tr>
    	<tr>
    		<td><?php echo $msgstr["styles_folder"];?></td>
    		<td valign=top><input type=text name=conf_styles size=100 value="<?php echo $styles?>"></td>
    	</tr>
    	<tr>
    		<td><?php echo $msgstr["url_logo"];?></td>
    		<td valign=top><input type=text name=conf_logo size=100 value="<?php echo $logo?>"></td>
    	</tr>
    	<tr>
    		<td><?php echo $msgstr["link_logo"];?></td>
    		<td valign=top><input type=text name=conf_link_logo size=100 value="<?php echo $link_logo?>"></td>
    	</tr>
    	<tr>
    		<td><?php echo $msgstr["title_page"];?></td>
    		<td valign=top><input type=text name=conf_TituloPagina size=100 value="<?php echo $TituloPagina?>"></td>
    	</tr>
    	<tr>
    		<td><?php echo $msgstr["shortIcon"];?></td>
    		<td valign=top><input type=text name=conf_shortIcon size=100 value="<?php echo $shortIcon?>"></td>
    	</tr>
    	<tr>
    		<td><?php echo $msgstr["footer"];?></td>
    		<td valign=top><input type=text name=conf_footer size=100 value="<?php echo $footer?>"></td>
    	</tr>
    	<tr>
    		<td><?php echo $msgstr["ONLINESTATMENT"];?></td>
    		<td valign=top><input type=radio name=conf_ONLINESTATMENT value="Y"
    		<?php if ($ONLINESTATMENT=="Y") echo " checked"?>> Y&nbsp;&nbsp;
    		<input type=radio name=conf_ONLINESTATMENT value="N" <?php if ($ONLINESTATMENT=="N") echo " checked"?>> N</td>
    	</tr>
    	<tr>
    		<td><?php echo $msgstr["WEBRENOVATION"];?></td>
    		<td valign=top><input type=radio name=conf_WEBRENOVATION value="Y"
    		<?php if ($WEBRENOVATION=="Y") echo " checked"?>> Y &nbsp;&nbsp;
    		<input type=radio name=conf_WEBRENOVATION value="N" <?php if ($WEBRENOVATION=="N") echo " checked"?>> N</td>
    	</tr>
    	<tr>
    		<td><?php echo $msgstr["WEBRESERVATION"];?></td>
    		<td valign=top><input type=radio name=conf_WEBRESERVATION value="Y"
    		<?php if ($WEBRESERVATION=="Y") echo " checked"?>> Y &nbsp;&nbsp;
    		<input type=radio name=conf_WEBRESERVATION value="N" <?php if ($WEBRESERVATION=="N") echo " checked"?>> N</td>
    	</tr>
        <tr>
    		<td valign=top><?php echo $msgstr["multiple_db_formats"];?></td>
    		<td valign=top><input type=checkbox name=multiple_db_formats value="Y"
    		<?php if (isset($multiple_db_formats) and $multiple_db_format=="Y"){    			 	echo " checked ";
    		      }else{    		      	if (isset($MULTIPLE_DB_FORMATS) and ($MULTIPLE_DB_FORMATS=="Y")) echo " checked";    		      }
    		?>
    		>
    		</td>
    	</tr>
    	<tr>
    		<td><?php echo $msgstr["show_help"];?></td>
    		<td valign=top><input type=radio name=conf_SHOWHELP value="Y"
    		<?php if ($showhelp=="Y") echo " checked"?>> Y&nbsp;&nbsp;
    		<input type=radio name=conf_SHOWHELP value="N" <?php if ($showhelp=="N") echo " checked"?>> N</td>

    	</tr>
    	<tr>
    		<td valign=top><?php echo $msgstr["charset"];?></td>
    		<td valign=top>
    			<?PHP if (!isset($charset) and isset($UNICODE) and $UNICODE==1) $charset="UTF-8";?>
    			<input type=radio name=conf_charset value=UTF-8 <?php if (isset($charset) and $charset=="UTF-8") echo " checked"?>> UTF-8&nbsp; &nbsp;
    			<input type=radio name=conf_charset value=ISO-8859-1  <?php if (isset($charset) and $charset=="ISO-8859-1") echo " checked"?>> ISO-8859-1</td>
    	</tr>
    </table>
    <p>
<input type=hidden name=Opcion value=Guardar>
<input type=submit value="<?php echo $msgstr["save"];?>">
</form>
<?php

include ("../php/footer.php");
?>
</div>
</div>
</body
</html>