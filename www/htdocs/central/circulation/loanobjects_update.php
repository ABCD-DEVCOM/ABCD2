<?php

session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
$lang=$_SESSION["lang"];
include("../common/get_post.php");
include("../config.php");
include("../lang/dbadmin.php");
include("../lang/prestamo.php");


//foreach ($arrHttp as $var=>$value) echo "$var=".urldecode($value)."<br>";

include("../common/header.php");
$encabezado="";
include("../common/institutional_info.php");
?>

<div class="sectionInfo">
	<div class="breadcrumb">
		<?php echo $msgstr["policy"];?>
	</div>
	<div class="actions">

		<?php
		$backtoscript="configure_menu.php?encabezado=s";
		include "../common/inc_back.php";
		?>
	</div>
	<div class="spacer">&#160;</div>
</div>
	<div class="middle form">
			<div class="formContent">

<?php			
$archivo=$db_path."circulation/def/".$_SESSION["lang"]."/typeofitems.tab";

if (!file_exists($archivo)) $archivo=$db_path."circulation/def/".$lang_db."/typeofitems.tab";

$fp=fopen($archivo,"w");

$ValorCapturado=urldecode($arrHttp["ValorCapturado"]);

fwrite($fp,$ValorCapturado);

fclose($fp);
?>

<h4>circulation/def/<?php echo $_SESSION["lang"];?>/typeofitems.tab</h4>
<h2 class="alert"><?php echo $msgstr["saved"];?></h2>

</div>
	</div>

<?php
include("../common/footer.php");
?>