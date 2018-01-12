<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
  <title>Document request</title>
</head>

<?php include ("header.php")?>
<form name=solicitud action=ver_documento_ex.php method=post>
<?php
include ("configure.php");
$db_path=$config["DB_PATH"];
$dbn=$arrHttp["base"];
$IsisScript=$xWxis."leer_mfnrange.xis";
//echo "xwxis=$xWxis<BR>";
$Pft=urlencode($config["DOCUMENT_DISPLAY"]);
$query="&base=$dbn&cipar=".$db_path."par/$dbn.par&from=".$arrHttp["mfn"]."&to=".$arrHttp["mfn"]."&Pft=$Pft";
//echo "query=$query<BR>";
include("../common/wxis_llamar.php");
?>
<font face="arial" size="2">
<font color="maroon">
<?php
foreach ($contenido as $value) echo "$value<br>";
?>
<p>
<font face="arial" size="1">
<b>	To consult the full text of the document enter your ID <BR>
             </b>
	<br><br>


<?php
echo "<br><br>";
echo "Código: ";
echo "<input type=text name=usuario size=10>\n";
echo "<input type=submit value=enviar target=_blank>\n";
foreach ($arrHttp as $var=>$value){
	echo "<input type=hidden name=$var value=\"$value\">\n";
}




?>
</form>
<br><br>
<a href="javascript:onClick=self.close()"><img src="/iah/es/image/salir.gif" border="0"></a>

</body>

</html>