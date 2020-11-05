<?php
include ("tope_config.php");
$wiki_help="wiki.abcdonline.info/index.php?title=OPAC-ABCD_Circulacion_y_pr%C3%A9stamos";

?>
<form name=parametros method=post>
<input type=hidden name=db_path value=<?php echo $db_path;?>>
<input type=hidden name=lang value=<?php echo $_REQUEST["lang"];?>>
<div id="page">
	<p>
    <h3>
    <?php
    echo $msgstr["WEBRENOVATION"]." &nbsp; ";
    include("wiki_help.php");
echo "<p>".$msgstr["ONLINESTATMENT"];
if (!isset($ONLINESTATMENT) or $ONLINESTATMENT!="Y")
	echo ": <font color=darkblue><strong>".$msgstr["is_not_set"]."</strong></font>";
else
    echo ": <font color=darkblue><strong>".$msgstr["is_set"]."</strong></font>";

echo "<p>".$msgstr["WEBRENOVATION"];
if (!isset($WEBRENOVATION) or $WEBRENOVATION!="Y")
	echo ": <font color=darkblue><strong>".$msgstr["is_not_set"]."</strong></font>";
else
    echo ": <font color=darkblue><strong>".$msgstr["is_set"]."</strong></font>";
Echo "<BR><font color=darkblue><strong>".$msgstr["parm_cnf_menu"]."</strong></font><br>";
echo "<H3>".$msgstr["ols_required"]."</h3>";
echo "<h4>".$msgstr["minf_loans"]." <a href=http://wiki.abcdonline.info/Configuraci%C3%B3n_del_sistema_de_pr%C3%A9stamos target=_blank><font color=blue>Loans configuration</font></a> in wiki.abcdonline.info</h4>";

?>