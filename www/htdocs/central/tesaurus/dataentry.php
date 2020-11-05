<?php
$titulo="Relaciones";
/*$display="display:none";
$ivars=$ivars+1;
echo "\n<div id=\"wrapper\">";
echo "<a onclick=\"switchMenu('myvar_$ivars');\" style=\"text-decoration:none \">";
echo "<img src=../dataentry/img/plus.gif border=0 style=\"vertical-align:middle\" > &nbsp;<strong>$titulo</strong>";
echo "</a>";
echo "<div id=\"myvar_$ivars\" style=\"$display;border: 2px solid #cccccc;-moz-border-radius: 15px;
border-radius: 15px;padding: 10px 10px 5px 10px;\">";
echo "<table>";   */
for ($ivars=0;$ivars<count($vars);$ivars++){
	$help_url="";
 	$linea=$vars[$ivars];
	$t=explode('|',$linea);
	$titulo=$t[2];
	$len=$t[9];
	$rep=$t[4];
	$tag=intval($t[1]);
	if (!isset($rels[$tag]["tag"])) continue;
	$ant_rel[$tag]=$valortag[$tag];
	$filas=Array();
	$field_t=$vars[$ivars];
/*
    echo "\n<tr><td bgcolor=#FFFFFF valign=top width=130>$tag</td>\n";
	DibujarTextRepetible($tag,"#FFFFFF",$field_t);
	echo "</tr>";
*/
}
//echo "</table>";
//echo "</div></div>";
    	echo "<a href=javascript:RelacionesInversas()>Analizar relaciones inversas</a>\n";
echo "\n\n<script>
tag_termino=\"".trim($term_tag)."\"
tag_refer=\"".trim($refer_tag)."\"
term_prefix=\"$term_prefix\"
val_rel_ant=Array()
tag_rel=Array()
";

foreach ($ant_rel as $val=>$value) {
	$xx=explode("\n",$value);
	echo "val_rel_ant[$val]=\"".str_replace("\n",'$$',$value)."\"\n";

}
$ix=-1;
foreach ($rels as $key=>$value){	$ix=$ix+1;
	$tag_rel=$value["rel_tag"];	echo "tag_rel[$key]=$tag_rel\n";}
echo "</script>\n\n";
?>
