<?php
include ("tope_config.php");
$wiki_help="wiki.abcdonline.info/index.php?desde=help&title=OPAC-ABCD_Circulacion_y_pr%C3%A9stamos";
$wiki_trad="wiki.abcdonline.info/index.php?title=OPAC-ABCD_Circulacion_y_pr%C3%A9stamos";

?>
<form name=parametros method=post>
<input type=hidden name=db_path value=<?php echo $db_path;?>>
<input type=hidden name=lang value=<?php echo $_REQUEST["lang"];?>>
<div id="page">
	<p>
    <h3>
    <?php
    echo $msgstr["ONLINESTATMENT"]." &nbsp; ";
    include("wiki_help.php");
$fp=file($db_path."/par/syspar.par");
foreach ($fp as $value){	$value=trim($value);
	if ($value!=""){		$x=explode('=',$value);
		$syspar_array[$x[0]]=$x[1];	}}
echo "<p>".$msgstr["ONLINESTATMENT"];
if (!isset($ONLINESTATMENT) or $ONLINESTATMENT!="Y")
	echo ": <font color=darkblue><strong>".$msgstr["is_not_set"]."</strong></font>";
else
    echo ": <font color=darkblue><strong>".$msgstr["is_set"]."</strong></font>";
echo "<br>".$msgstr["onlinestatment_isset"]."</p>";

echo "<p>".$msgstr["Web_Dir"];
echo ": <font color=darkblue><strong>$Web_Dir</strong></font>";
echo "<br>Result: ";
if (!is_dir($Web_Dir))
   echo " Wrong folder";
else
	echo " OK";
echo "</p>";
echo "<p>".$msgstr["chk_opachttp"]." <font color=darkblue><strong><a href=$OpacHttp target =_blank>$OpacHttp</a></strong></font><br>";
Echo "<font color=darkblue><strong>".$msgstr["parm_cnf_menu"]."</strong></font><br>";
if (!is_dir($db_path."circulation"))
	echo "<br><font color=red>".$msgstr["missing_folder"]." "."<strong>$db_path"."/circulation</strong> (".$msgstr["ver"]." <a href=http://wiki.abcdonline.info/Configuraci%C3%B3n_del_sistema_de_pr%C3%A9stamos target=_blank>"."Configuración de préstamos"."</a>)</font>";
if (!is_dir($db_path."trans"))
	echo "<br><font color=red>".$msgstr["missing"]." ".$msgstr["trans_db"]." (trans)</font>";
if (!file_exists($db_path."par/trans.par")){	echo "<br><font color=red>".$msgstr["missing"]." "."trans.par</font>";}
if (!is_dir($db_path."suspml"))
	echo "<br><font color=red>".$msgstr["missing"]." ".$msgstr["suspml_db"]." (suspml)</font>";
if (!file_exists($db_path."par/suspml.par")){
	echo "<br><font color=red>".$msgstr["missing"]." "."suspml.par</font>";
}
if (!is_dir($db_path."users"))
	echo "<br><font color=red>".$msgstr["missing"]." ".$msgstr["users_db"]." (users)</font>";
if (!file_exists($db_path."par/users.par")){
	echo "<br><font color=red>".$msgstr["missing"]." "."users.par</font>";
}
if (file_exists($db_path."opac_conf/".$_REQUEST["lang"]."/bases.dat")){	$fp=file($db_path."opac_conf/".$_REQUEST["lang"]."/bases.dat");
	foreach ($fp as $value){		$value=trim($value);		if ($value!=""){			$b=explode('|',$value);
			$base_array[$b[0]]=$value;		}	}}else{	echo "<p><font color=red size=2>".$msgstr["missing"]." opac_conf/".$_REQUEST["lang"]."/bases.dat</font>";
	die;}
foreach ($base_array as $key=>$value){
	echo "<p>".$msgstr["check_conf"].": <strong><font style=\"size:14px;color:darkblue\">".$key."</strong></font>";	if (!is_dir($db_path.$key."/loans/".$_REQUEST["lang"]) ) {		echo  "<br>".$msgstr["missing"]." /loans folder";
		echo "<br>this database is not configured in the loans system";
		// Set the current working directory
	}else{
		$dir = $db_path.$key."/loans/".$_REQUEST["lang"];
		$i = 0;
		if( $handle = opendir($dir) ) {
    		while( ($file = readdir($handle)) !== false ) {
        		if( !in_array($file, array('.', '..')) && !is_dir($dir.$file))
            		$i++;
    		}
		}
		if ($i==0){			echo "<br><font color=red>".$msgstr["ncf_loans"]."</font><br>";		}else{			echo "<br>".$msgstr["cf_loans"]."<br>";		}
	}}

echo "<h4>".$msgstr["minf_loans"]." <a href=http://wiki.abcdonline.info/Configuraci%C3%B3n_del_sistema_de_pr%C3%A9stamos target=_blank><font color=blue>Loans configuration</font></a> in wiki.abcdonline.info</h4>";

?>