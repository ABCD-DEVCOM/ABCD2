<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../common/get_post.php");
include ("../config.php");
$lang=$_SESSION["lang"];
include("../lang/admin.php");
include("../lang/dbadmin.php");

//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";if (file_exists($db_path.$tesaurus."/def/".$_SESSION["lang"]."/".$tesaurus.".dat"))
	$fp=file($db_path.$tesaurus."/def/".$_SESSION["lang"]."/".$tesaurus.".dat");
else
	$fp=file($db_path.$tesaurus."/def/".$lang_db."/".$tesaurus.".dat");
foreach($fp as $value) {	$f=explode('=',$value);
	switch($f[0]){		case "alpha_prefix":
			$prefijo=trim($f[1]);
			break;
		case "display":
			$Formato=trim($f[1]);
			break;
	}}

//foreach ($contenido as $var=>$value) echo "$var=$value<br>";
$subtitle= " Tesaurus";
include("../common/header.php");
echo "<h3>Tesaurus ($tesaurus)</h3>\n";
echo "<script language=\"JavaScript\" type=\"text/javascript\" src=../dataentry/js/lr_trim.js></script>\n";
$Tag="";
echo "
<script languaje=Javascript>\n";

    echo "Tag=''\n";
	if (isset($arrHttp["Tag"])){
		echo "Tag='".$arrHttp["Tag"]."'\n";
		$Tag=$arrHttp["Tag"];
	}
?>
	function Show(Seleccion){        document.show.termino.value=Seleccion
        document.show.submit()
	}
	function Search(Seleccion){
		if (Tag==""){
			window.opener.top.Expresion="<?php echo $prefix_search_tesaurus?>"+Seleccion
			window.opener.top.Menu("ejecutarbusqueda")
		}else{
			Var=eval("window.opener.document.forma1."+Tag)
			if (Var.type=="text")
				Separa=";"
			else
				Separa="\n"
			VarOriginal=Var.value
			VarOriginal=Trim(VarOriginal)
			if (VarOriginal=="")
				VarOriginal=Seleccion
			else
				VarOriginal=Var.value+Separa+Seleccion
			Var.value=VarOriginal
			a=Var.value
			if (Var.type=="textarea") {
				b=a.split("\n")
				if(b.length>Var.rows) Var.rows=b.length
			}
		}
	}

</script>
<body>
	<div class="helper">
	<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/alfa.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
	<?php if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"])) echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/alfa.html target=_blank>".$msgstr["edhlp"]."</a>";
	echo " &nbsp; &nbsp; ><a href='http://abcdwiki.net/wiki/es/index.php?title=Tesauros' target=_blank>abcdwiki.net</a>";
	echo "<font color=white>&nbsp; &nbsp; Script: tesaurus/show.php" ?>
</font></div>
<form method=post name=Lista onSubmit="javascript:return false">
	<table width=100%>
		<td width=50%><img src=../dataentry/img/toolbarSearch.png> <a href=index.php?base=<?php echo $arrHttp["base"];if ($Tag!="") echo "&Tag=$Tag"?>><strong><font color=white><?php echo $msgstr["tes_alphabetic"]?></strong></font></a>  &nbsp; &nbsp; <a href=perm.php?perm=Y&base=<?php echo $arrHttp["base"];if ($Tag!="") echo "&Tag=$Tag"?>><strong><font color=white><?php echo $msgstr["tes_permuted"]?></strong></font></a></td>
    </table>
 <div class="middle form">
			<div class="formContent">

<?php
	$xwidth="350";
?>
	<table border=0  width=100% height=80%>
	<td width=95% valign=top>
<?php
	$Expresion=$prefijo.urlencode(trim($arrHttp["termino"]));

	$a=$db_path.$tesaurus."/pfts/".$_SESSION["lang"]."/".$Formato;
	$Formato=$a;
	$contenido="";
	$IsisScript=$xWxis."buscar.xis";
	$arrHttp["from"]=1;

	$query = "&base=$tesaurus&cipar=$db_path"."par/$tesaurus.par&Expresion=".$Expresion."&count=1&from=".$arrHttp["from"]."&Formato=$Formato&prologo=prologoact&epilogo=epilogoact&Opcion=buscar";
	include("../common/wxis_llamar.php");
    foreach ($contenido as $value)  echo "$value";

?>
	</td>

	</table>
	<br><img src=../dataentry/img/toolbarSearch.png><a href=index.php?base=<?php echo $arrHttp["base"];if ($Tag!="") echo "&Tag=$Tag"?>><strong><?php echo $msgstr["tes_alphabetic"]?></a>  &nbsp; &nbsp; <a href=perm.php?perm=Y&base=<?php echo $arrHttp["base"];if ($Tag!="") echo "&Tag=$Tag"?>><?php echo $msgstr["tes_permuted"]?></a></strong><br>
	</form>
	</div>
	</div>
	</body>
	</html>
<form name=show method=post action=show.php>
<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
<input type=hidden name=termino>
<?php if (isset($arrHttp["Tag"])) echo "<input type=hidden name=Tag value=".$arrHttp["Tag"].">\n";?>
</form>