<?php
/*
20220121 fho4abcd backbutton-> close button + div-helper + improve html + remove institutional info (to inhibit logout from subscreen)
*/
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include("../config.php");
include("../lang/dbadmin.php");
include("../lang/admin.php");
include("../common/header.php");
?>
<body>
<?php
//foreach ($arrHttp as $var=>$value)  echo "$var=$value<br>";
?>
<div class="sectionInfo">
	<div class="breadcrumb">
        <?php echo $msgstr["sortkey"].$arrHttp["base"] ?>
	</div>
	<div class="actions">
        <?php include "../common/inc_close.php";?>
    </div>
    <div class="spacer">&#160;</div>
</div>
<?php include "../common/inc_div-helper.php"; ?>
<div class="middle form">
<div class="formContent">
<?php
$fp=fopen($db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/sort.tab","w");
$accents=explode("\n",$arrHttp["ValorCapturado"]);
echo "\n<script>
sort=new Array()
window.opener.document.forma1.sort.length=0
";
$ix=0;
foreach ($accents as $val){
	$val=trim($val);
	$ix=$ix+1;
	if($val!=""){
		$a=explode('|',$val);
		echo "window.opener.document.forma1.sort.options[$ix]= new Option('".$a[0]."','".$a[1]."')\n";
		fwrite($fp,$a[0]."|".$a[1]."\n");
	}
}
fclose($fp);
echo "</script>\n";
echo "sort.tab ".$msgstr["updated"]."<p>";
?>
</div>
</div>
</body>
</html>

