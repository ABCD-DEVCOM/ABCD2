<?php

session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
$lang=$_SESSION["lang"];
include("../common/get_post.php");
include("../config.php");
include("../lang/dbadmin.php");
include("../lang/soporte.php");

$files = $_FILES['userfile'];
foreach ($files['name'] as $key=>$name) {
	if ($files['size'][$key]) {
      // clean up file name
   		$name = ereg_replace("[^a-z0-9._]", "",
       	str_replace(" ", "_",
       	str_replace("%20", "_", strtolower($name)
   			)
      		)
        );
      	$fp=file($files['tmp_name'][$key]);
       	$Pft="";
        foreach($fp as $linea) $Pft.=$linea;
	}
}
echo "<script>window.resizeBy(700,400);
window.moveTo(0,0)
function Enviar(){
	window.opener.document.forma1.pft.value=document.forma1.formato.value
	window.opener.toggleLayer('pftedit')
	self.close()
}
</script>\n";

echo "<form name=forma1>". $msgstr["edit"]." ".$msgstr["pft"]."
<br><font color=red>".$msgstr["pftwd1"]." <a href=javascript:Enviar()><img src=../dataentry/img/copy_to_folder.gif border=0></a> ".$msgstr["pftwd2"]."</span>";
echo "<textarea cols=150 rows=40 name=formato>".$Pft."</textarea>";
echo "
<br><font color=red>".$msgstr["pftwd1"]." <a href=javascript:Enviar()><img src=../dataentry/img/copy_to_folder.gif border=0></a> ".$msgstr["pftwd2"]."</span>
</form>
</body>\n";
echo "</html>\n";
?>
