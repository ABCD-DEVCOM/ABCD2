<?php
include("../php/config_opac.php");
if (isset($_REQUEST["Opcion"]) and $_REQUEST["Opcion"]=="Guardar"){	$fp=fopen($_REQUEST["archivo"],"w");
	fwrite($fp,$_REQUEST["Formato"]);
	fclose($fp);	//foreach ($_REQUEST as $var=>$value) echo "$var=$value<br>";
    echo "<h2>".$_REQUEST["archivo"]." Updated!!</h2>";
	die;}
echo "Base: ".$_REQUEST["base"]."<br>";
echo "Pft: " .$_REQUEST["Pft"].".pft<br>";
$base=$_REQUEST["base"];
if (substr($_REQUEST["Pft"],strlen($_REQUEST["Pft"])-4)==".pft") $_REQUEST["Pft"]=substr($_REQUEST["Pft"],0,strlen($_REQUEST["Pft"])-4);
$Pft=$_REQUEST["Pft"].".pft";
$lang=$_REQUEST["lang"];
$par_array=array();
$db_path=$_REQUEST["db_path"];
$archivo=$db_path."par/$base.par";
if (!file_exists($archivo)){
	echo "Error: missing $archivo<br>";
}else{
	$par=file($archivo);
	foreach($par as $value) {
		$value=trim($value);
		if ($value!=""){
			$p=explode('=',$value);
			$par_array[$p[0]]=$p[1];
		}
	}
}
//var_dump($par_array);
if (!isset($par_array[$Pft])){
	echo "<font color=red>Missing in $base.par</font><br>";
	$archivo=$db_path.$base."/pfts/$lang/$Pft.pft";
}else{
	$path=str_replace('%path_database%',$db_path,$par_array[$Pft]);
	$path=str_replace('%lang%',$lang,$path);
	$archivo=$path;
}
if (!file_exists($archivo)){
	echo "<br><font color=red>Missing file $path</font>";
	die;
}
echo "$archivo<p>";
$fp=file($archivo);
$texto=implode("",$fp);
echo "<form name=forma1 method=post>\n";
echo "<input type=hidden name=Opcion value=Guardar>\n";
echo "<input type=hidden name=lang value=$lang>\n";
echo "<input type=hidden name=base value=$base>\n";
echo "<input type=hidden name=Pft value=$Pft>\n";
echo "<input type=hidden name=archivo value=$archivo>\n";
echo "<textarea name=Formato cols=100 rows=30>$texto</textarea>";
echo "<p><input type=submit value=\"".$msgstr["save"]. " $Pft\">";

?>