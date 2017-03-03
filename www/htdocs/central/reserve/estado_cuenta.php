<html>

<head>
  <title></title>
</head>

<body>

<?php
include("../config.php");
$IsisScript=$xWxis."/ecta.xis";
include("../common/get_post.php");
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
$query="&base=presta&cipar=bibliosupers.par&usuario=".$arrHttp["usuario"];
putenv('REQUEST_METHOD=GET');
putenv('QUERY_STRING='."?xx=".$query);
$contenido="";
exec("\"".$Wxis."\" IsisScript=$IsisScript",$contenido);
foreach ($contenido as $value) print "$value";


?>

</body>

</html>