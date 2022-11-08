<?php
session_start();

if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}

if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../config.php");

$lang=$_SESSION["lang"];

include("../lang/admin.php");
include("../lang/dbadmin.php");
include("../lang/acquisitions.php");

include("../common/get_post.php");
//foreach ($arrHttp as $var=>$value)  echo "$var=$value<br>";
$sep='|';
$b=explode('|',$arrHttp["base"]);
if (!isset($b[2])) $b[2]="";
$flag=$b[2];   // Y= the dababase can manage copies
$base=$b[0];
$cn_val="";
$inv_val="";
$file_cn=$db_path.$base."/data/control_number.cn";
if (file_exists($file_cn)){
	$fp=file($file_cn);
	$cn_val=implode("",$fp);
}
include("../common/header.php");


?>
<script src=../dataentry/js/lr_trim.js></script>

<script>
function Enviar(){
	control=Trim(document.forma1.control_n.value)
	if (control=="" || control=="0"){
		if (confirm("The control number of the database will be restored to 0 \n\n Is that correct? ")){
			if (confirm("are you sure?")){
			}else{
				return
			}
		}else{
			return
		}
	}
	document.forma1.submit()
}

</script>

<body>
<?php

include("../common/institutional_info.php");

if (isset($arrHttp['encabezado'])) {
    $encabezado=$arrHttp['encabezado'];
} else {
    $encabezado = "s";
}

?>
<div class="sectionInfo">
	<div class="breadcrumb">
		<?php echo $msgstr["resetctl"].": $base"?>
	</div>
	<div class="actions">
        <?php
        if (!isset($arrHttp["return"])){
            $ret="../common/inicio.php?reinicio=s".$encabezado;
            if (isset($arrHttp["modulo"])) $ret.="&modulo=".$arrHttp["modulo"];
            if (isset($base)) $ret.="&base=".$base;
        }else{
            $ret=str_replace("|","?",$arrHttp["return"])."&encabezado=".$arrHttp["encabezado"];
        }

		$backtoscript = $ret;;
		include "../common/inc_back.php";
	?>


	</div>
	<div class="spacer">&#160;</div>
</div>

<?php
$ayuda="copies_configuration.html";
include "../common/inc_div-helper.php";
?>

<div class="middle form">
	<div class="formContent">
		<form name="forma1" action="resetautoinc_update.php" method="post" onsubmit="javascript:return false">
		<input type="hidden" name="base" value="<?php echo $base; ?>">
			<label><?php echo $msgstr["lastcn"]; ?></label>
			<input type="text" name="control_n" value="<?php echo $cn_val;?>">
			<input type="submit" class="bt-green" name="send" value="<?php echo $msgstr["update"]; ?>" onclick="Enviar()">
		</form>
	</div>
</div>

<?php include("../common/footer.php");?>