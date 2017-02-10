<?php
session_start();
include("../common/get_post.php");
include ("../config.php");
if (!isset($_SESSION["permiso"]) or !isset($arrHttp["base"])){
	header("Location: ../common/error_page.php") ;
}

include("../lang/dbadmin.php");
include("../lang/soporte.php");
$lang=$_SESSION["lang"];
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";

function Ejecutar($db,$action,$db_path){
	$filename=$db_path.$db."/protect_status.def";
	switch($action){		case "protect_db":
			if (!$handle = fopen($filename, 'w')) {
	         	echo "Cannot open file ($filename)";
	         	return -1;
			 	exit;
	   		}
	   		$contenido="PROTECTED";
			// Write $somecontent to our opened file.
			if (fwrite($handle, $contenido) === FALSE) {
	       		echo "Cannot write to file ($filename)";
		   		return -1;
	       		exit;
	   		}
	   		fclose($handle);
	   		return 0;
   			break;
   		case "unprotect_db":
   			$res=0;
   			if (file_exists($filename)){
   				$res=unlink($filename);
   			}
   			return 0 ;
            break;	}




	$ix=strlen($db_path);


   return 0;

}


//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
include("../common/header.php");
?>
<script>
function EnviarForma(){	seleccion=""	for(ix=0;ix<document.protect.action.length;ix++){		if (document.protect.action[ix].checked)
			seleccion="Y"
	}
	if (seleccion==""){		return	}
	document.protect.submit()}
</script>
<?php
echo "<body>\n";
include("../common/institutional_info.php");
?>
<div class="sectionInfo">

			<div class="breadcrumb">
				<?php echo "<h5>".$msgstr["protect_db"]." " .$msgstr["database"].": ".$arrHttp["base"]."</h5>"?>
			</div>

			<div class="actions">
<?php
	if (!isset($arrHttp["eliminar"]))
    	echo "<a href=\"menu_mantenimiento.php?base=".$arrHttp["base"]."&encabezado=S\" class=\"defaultButton backButton\">";
	else
		echo "<a href=\"../common/inicio.php?reinicio=s\" class=\"defaultButton backButton\">";

?>
					<img src="../images/defaultButton_iconBorder.gif" alt="" title="" />
					<span><strong><?php echo $msgstr["back"]?></strong></span>
				</a>
			</div>
			<div class="spacer">&#160;</div>
</div>
<?php
echo "<div class=helper>
<font size=1>Script: dbadmin/lock_bd.php</font>
</div>
<div class=\"middle form\">
			<div class=\"formContent\">

";
if (!isset($_SESSION["permiso"]["CENTRAL_ALL"])){	echo "<h4>".$msgstr["invalidright"]."</h4>";}else{
	if (!isset($arrHttp["action"])){		echo "<form name=protect onsubmit='return false'><table align=center class=listTable>";
		echo "<input type=hidden name=base value=".$arrHttp["base"].">\n";
		echo "<tr><td><input type=radio name=action value=protect_db>".$msgstr["protect_db"]."</td></tr>\n";
		echo "<tr><td><input type=radio name=action value=unprotect_db>".$msgstr["unprotect_db"]."</td></tr>\n";
		echo "<tr><td><input type=submit name=send value=".$msgstr["send"]." onclick=EnviarForma()></td></tr>\n";
		echo "</table></form>";
	}else{		$res=Ejecutar($arrHttp["base"],$arrHttp["action"],$db_path);
		echo "<h4>".$arrHttp["base"].": ".$msgstr[$arrHttp["action"]];
		switch ($res){			case 0:
				echo " OK";
				break;
			case -1:		       echo " FAILED!!!";
		       break;
		}
	    echo "</h4>";	}
}
echo "</div>
</div>
";
include("../common/footer.php");
echo "</body></html>\n";

?>