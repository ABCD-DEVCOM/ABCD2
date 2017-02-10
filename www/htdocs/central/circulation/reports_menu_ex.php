<?
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
session_start();
if (!isset($_SESSION["permiso"])){
	echo "Session Expired";
	die;
}
include("../common/get_post.php");
include("../config.php");
include ("../lang/admin.php");
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";

if (isset($arrHttp["Expresion"])){	$arrHttp["Expresion"]=stripslashes($arrHttp["Expresion"]);
	if (strpos('"',$arrHttp["Expresion"])==0) {
    	$arrHttp["Expresion"]=str_replace('"','',$arrHttp["Expresion"]);
	}
	$Expresion=urlencode($arrHttp["Expresion"]);}
switch ($arrHttp["Opcion"]){	case "vence":
		$arrHttp["pft"]="mov";
		break;
	case "suspen":
		$arrHttp["pft"]="susp";
		break;
	case "fine":
		$arrHttp["pft"]="susp";
		break;}
$Formato=$db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/".$arrHttp["pft"].".pft";
if (!file_exists($Formato)){	$Formato=$db_path.$arrHttp["base"]."/pfts/".$lang_db."/".$arrHttp["pft"].".pft";}
if (file_exists($Formato)) $Formato="@".$Formato;
// READ THE HEADINGS, IF ANY
$heading="<strong>".$arrHttp["title"]."</strong>";
$head=$db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/".$arrHttp["pft"].".tab";
if (!file_exists($head)){
	$head=$db_path.$arrHttp["base"]."/pfts/".$lang_db."/".$arrHttp["pft"].".tab";
}
if (file_exists($head)){	$fp=file($head);
	$head=implode('',$fp);
	$h=explode('|',$head);
	foreach ($h as $value)
		if (trim($value!="")) $heading.="<th>".trim($value)."</th>";
}

if (isset($arrHttp["Expresion"])) {
    $Opcion="buscar";
}else{
	$Opcion="rango";
}

$query = "&base=".$arrHttp["base"]."&cipar=$db_path"."par/".$arrHttp["cipar"]."&Expresion=".$Expresion."&Opcion=$Opcion&Word=S&Formato=".$Formato;
$query.="&from=".$arrHttp["Mfn"]."&to=".$arrHttp["to"];
if (!isset($arrHttp["sortkey"])){
	$IsisScript=$xWxis."imprime.xis";
}else{
	$query.='&sortkey='.urlencode($arrHttp["sortkey"]);
	$IsisScript=$xWxis."sort.xis";
}
include("../common/wxis_llamar.php");
$data=$heading;
foreach ($contenido as $linea){
	$l=explode('|',$linea);
	switch ($arrHttp["Opcion"]){
		case "vence":
			$user=$l[2];
			$usr_data=UserData($l[2]);
			$data.="\n<tr><td valign=top>".$l[4]."</td>";
			$data.=$usr_data;

			$data.="<td valign=top>".$l[0]."</td><td valign=top>".$l[1]."</td><td valign=top>".$l[2]."</td><td valign=top>".$l[3]."</td><td valign=top>".FormatDate($l[5])."</td><td valign=top>".$l[6]."</td>";
			$data.="<td valign=top>".FormatDate($l[7])."</td><td valign=top>".$l[8]."</td><td valign=top>".$l[9]."</td><td valign=top>".$l[10]."</td><td valign=top>".$l[11]."</td>";
			break;
		case "suspen":
		case "fine":
			$user=$l[2];
			$usr_data=UserData($l[2]);
			$data.="\n<tr><td valign=top>".$l[2]."</td>";
			$data.=$usr_data;
			$data.="<td valign=top>".$l[0]."</td><td valign=top>".$l[1]."</td><td valign=top>".FormatDate($l[3])."</td><td valign=top>".$l[4]."</td>";
			$data.="<td valign=top>".$l[5]."</td><td valign=top>".FormatDate($l[6])."</td><td valign=top>".$l[7]."</td><td valign=top>".$l[8]."</td><td valign=top>".$l[9]."</td>";
			break;
	}
}
$data.="\n</table>";switch ($arrHttp["vp"]){	case "WP":
    	$filename=$arrHttp["base"].".doc";
		header('Content-Type: application/msword; charset=windows-1252');
		header("Content-Disposition: attachment; filename=\"$filename\"");
   		header("Expires: 0");
   		header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
   		header("Pragma: public");
		echo '<html xmlns:o="urn:schemas-microsoft-com:office:office"' . "\n";
		echo '   xmlns:w="urn:schemas-microsoft-com:office:word"' . "\n";
		echo '   xmlns="http://www.w3.org/TR/REC-html40">' . "\n";
		break;
	case "TB":
		$filename=$arrHttp["base"].".xls";
		header('Content-Type: application/excel; charset=windows-1252');
		header("Content-Disposition: attachment; filename=\"$filename\"");
   		header("Expires: 0");
   		header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
   		header("Pragma: public");
		echo '<html xmlns:o="urn:schemas-microsoft-com:office:office"' . "\n";
		echo '   xmlns:w="urn:schemas-microsoft-com:office:word"' . "\n";
		echo '   xmlns="http://www.w3.org/TR/REC-html40">' . "\n";
		break;
	case "TXT":
		$filename=$arrHttp["base"].".txt";
		header('Content-Type: application/excel; charset=windows-1252');
		header("Content-Disposition: attachment; filename=\"$filename\"");
   		header("Expires: 0");
   		header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
   		header("Pragma: public");
		break;
	default:
}
include("../common/header.php");
echo "<div class=\"middle form\">
			<div class=\"formContent\">";
echo "\n<body bgcolor=white>";
echo "<table class=listTable>";
   echo $data;
switch ($arrHttp["tipof"]){              //TYPE OF FORMAT
	case "T":  //TABLE
		echo "</body></html>";
		break;
	case "P":  //PARRAGRAPH
		echo "</body></html>";
		break;
	case "CT": //COLUMNS (TABLE)
		echo "</table></body></html>";
		break;
	case "CD":
		break;
}

die;

//==========================================================
function UserData($user){
global $db_path,$Wxis,$wxisUrl,$xWxis;
	$formato_us=$db_path."users/loans/".$_SESSION["lang"]."/tbuser.pft";
    if (!isset($formato_us)) $formato_us=$db_path."users/loans/".$lang_db."/tbuser.pft";
   	$query = "&Expresion=CO_".$user."&base=users&cipar=$db_path/par/users.par&Formato=".$formato_us;
	$contenido="";
	$IsisScript=$xWxis."cipres_usuario.xis";
	include("../common/wxis_llamar.php");
	$cont=trim(implode("",$contenido));
	$c=explode("|",$cont);
	$output="";
	foreach ($c as $linea){
		$linea=trim($linea);		if ($linea!="")
			$output.= "<td bgcolor=white valign=top>".$linea."</td>";
	}
	if ($output=="") $output="<td>&nbsp;</td><td>&nbsp;</td>";
	return $output;}

function FormatDate ($FechaP){
global $locales,$config_date_format;
//CONVERT ISO DATE TO LOCAL DATE FORMAT
	$f_date=explode('/',$config_date_format);
	switch ($f_date[0]){
		case "DD":
			$exp_date=substr($FechaP,6,2)."-".substr($FechaP,4,2)."-".substr($FechaP,0,4);
			break;
		case "MM":
			$exp_date=substr($FechaP,4,2)."-".substr($FechaP,6,2)."-".substr($FechaP,0,4);
			break;
	}
	return $exp_date;
}
?>
