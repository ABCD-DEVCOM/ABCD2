<?php
include("../config.php");
$arrHttp["base"]="biblo";
$arrHttp["cipar"]="biblo.par";
$_SESSION["lang"]="es";
require_once ("../lang/dbadmin.php");
require_once ("../lang/admin.php");
include("../dataentry/scripts_dataentry.php");


$base=$arrHttp["base"];
$width=50*5.5;
require_once("combo_inc.php");
echo "<p>";
echo "No Repetible COMBORO tabla<BR>";
ComboBox("COMBORO",10,$width,0,"P","countries.tab","","",$db_path,"biblo","aaa");

echo "<p>";
echo "No Repetible COMBORO read only base de datos<BR>";
ComboBox("COMBORO",20,$width,0,"D","biblo","@autoridades.pft","MA_",$db_path,"biblo","aaa");
/*
echo "<p>";
echo "No Repetible COMBO tabla<BR>";
ComboBox("COMBO",30,$width,0,"P","countries.tab","","",$db_path,"aaa");
echo "<p>";
echo "No Repetible COMBO base de datos<BR>";
ComboBox("COMBO",40,$width,0,"D","","@autoridades.pft","MA_",$db_path,"biblo","aaa");

echo "<p>";
echo "Repetible COMBORO tabla<BR>";
ComboBox("COMBORO",50,$width,1,"P","countries.tab","","",$db_path,"biblo","aaa");
echo "<p>";
*/
echo "Repetible COMBORO base de datos<BR>";
ComboBox("COMBORO",60,$width,1,"D","biblo","@autoridades.pft","MA_",$db_path,"biblo","aaa");
echo "<p>";
die;
echo "Repetible COMBO tabla<BR>";
ComboBox("COMBO",70,$width,1,"P","countries.tab","","",$db_path,"biblo","aaa");
echo "<p>";
echo "Repetible COMBO base de datos<BR>";
ComboBox("COMBO",80,$width,1,"D","biblo","@autoridades.pft","MA_",$db_path,"biblo","aaa");

echo "
</form>
</body></html> ";
?>
