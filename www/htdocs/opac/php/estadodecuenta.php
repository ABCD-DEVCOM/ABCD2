<?php

include("config.php");
include("leer_bases.php");
//foreach ($_REQUEST as $key=>$value)    echo "$key=>".urldecode($value)."<br>";
include("head.php");
echo "<div id=\"search\" >";
echo "<br><br><br>";
echo "<input type=button Value='Regresar' onclick=javascript:history.back()><br>";
echo "<br><br><br>";
echo "<form name=continuar action=buscar_integrada.php method=post>\n";

echo "</form>";
echo "<br><br><br>";
echo "<input type=button Value='Regresar' onclick=javascript:history.back()><br>";
echo "</div>"
?>
<?php
include("footer.php");

?>
