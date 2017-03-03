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
echo "
		<div class=\"sectionInfo\">
			<div class=\"breadcrumb\">".
				$msgstr["policy"]."
			</div>
			<div class=\"actions\">\n";

				echo "<a href=\"loanobjects.php?encabezado=s\" class=\"defaultButton backButton\">
					<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
					<span><strong>". $msgstr["back"]."</strong></span>
				</a>
			</div>
			<div class=\"spacer\">&#160;</div>
		</div>
		<div class=\"middle form\">
			<div class=\"formContent\">\n";
$archivo=$db_path."circulation/def/".$_SESSION["lang"]."/typeofitems.tab";
if (!file_exists($archivo)) $archivo=$db_path."circulation/def/".$lang_db."/typeofitems.tab";
$fp=fopen($archivo,"w");
$ValorCapturado=urldecode($arrHttp["ValorCapturado"]);
fwrite($fp,$ValorCapturado);
fclose($fp);
echo "<h4>circulation/def/".$_SESSION["lang"]."/typeofitems.tab<strong>". $msgstr["saved"]." </strong></h4>";
echo "</div></div>";
include("../common/footer.php");
echo "
</body>
</html>";
?>