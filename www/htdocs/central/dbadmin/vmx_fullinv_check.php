<?
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../common/get_post.php");
include("../config.php");
$lang=$_SESSION["lang"];
include("../lang/dbadmin.php");
include("../lang/acquisitions.php");
include("../config.php");
include("../common/header.php");
echo "<script src=../dataentry/js/lr_trim.js></script>";
echo "<body>\n";
if (isset($arrHttp["encabezado"])) {
	include("../common/institutional_info.php");
	$encabezado="&encabezado=s";
}
echo "<a href=\"menu_mantenimiento.php?base=".$arrHttp["base"]."$encabezado\" class=\"defaultButton backButton\">";
echo "<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
					<span><strong> back </strong></span>
				</a>";
$base=$arrHttp["base"];
echo "<form id=\"form1\" name=\"form1\" method=\"post\" action=\"vmx_fullinv.php\">
    <input type=\"hidden\" name=\"resp\" value=\"y\" id=\"resp\" />
  <input type=\"hidden\" name=\"base\" value=\"$base\" id=\"base\" />
</form>";
echo "<script>
if(confirm(\"are you sure?\"))
{
document.form1.submit();

}
else
{
self.location=\"menu_mantenimiento.php?base=".$arrHttp["base"]."$encabezado\";
}
</script>";
?>