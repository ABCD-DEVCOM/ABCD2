<?php
session_start();
//echo $_SESSION["REC_PASS"];
include("../common/get_post.php");
include("../config.php");
require_once ("../lang/admin.php");
include("../common/header.php");
?>
<html>

<script language="JavaScript" src="js/lr_trim.js"></script>
<script>
function Verificar(){
	if (Trim(document.forma1.password.value)==""){		alert("<?php echo $msgstr["record_protected"]?>")
		return	}    document.forma1.submit()}
function Cancelar(){	if (top.window.frames.length>0){
		top.Menu("same")
	}}
</script>


<body>
<form name=forma1 action=check_record_password_ex.php>
<?php
echo "<input type=hidden name=base value=".$arrHttp["base"].">
      <input type=hidden name=Mfn value=".$arrHttp["Mfn"].">
      <input type=hidden name=Formato value=".$arrHttp["Formato"].">
      \n";
echo "	<div class=\"middle form\">
			<div class=\"formContent\">";
//foreach ($arrHttp as $var=>$value) echo "$var=>$value<br>";
echo "<br><br><br><br><p align=center><h4>";
echo $msgstr["record_protected"];
echo ": &nbsp <input name=password type=password size=15 >";
echo " &nbsp; <input type=button value=".$msgstr["entrar"]." onclick=javascript:Verificar()>
      &nbsp; &nbsp;<input type=button value=".$msgstr["cancelar"]." onclick=javascript:Cancelar()>";

?>
</p>
</div>
</div>
</form>
</body>

</html>