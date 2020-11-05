<html>

<head>
  <title></title>
</head>

<body>

<?php
$xWxis="/ABCD/www/htdocs/central/dataentry/wxis/loans/prestamo_disponibilidad.xis";
$url="http://localhost:9090/cgi-bin/wxis.exe?IsisScript=$xWxis&cttype=s";
$url.="&Opcion=disponibilidad&base=biblo&path_db=/ABCD/www/bases/demo_copies/&cipar=/ABCD/www/bases/demo_copies/par/biblo.par&Expresion=CN_126&Pft=@/ABCD/www/bases/demo_nocopies/biblo/loans/es/loans_display.pft, ".urlencode("/'||'v2[1]'||''L''###',if v6:'a' then if p(v10) then '^a'v10[1]^*,\"^b\"v10[1]^b, else if p(v11) then '^a'v11[1] fi fi if p(v12) then '^t'v12 fi, fi, if v6:'m' then if p(v16) then '^a'v16[1]^*,\"^b\"v16[1]^b, else if p(v17) then '^a'v17[1] fi fi, fi, if p(v18) then '^t'v18 fi, \"^e\"v38, \"^y\"v43, \"^k\"v9");
$result=file_get_contents($url);
$con=explode("\n",$result);
foreach ($con as $value) echo "$value<br>";
?>

</body>

</html>