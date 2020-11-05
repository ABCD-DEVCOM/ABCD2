<?php
//PARA ELIMINAR LAS VARIABLES DE SESSION DEL DIRTREE
unset($_SESSION["root_base"]);
unset($_SESSION["dir_base"]);
unset($_SESSION["Folder_Name"]);
unset($_SESSION["Folder_Type"]);
unset($_SESSION["Opened_Folder"]);
unset($_SESSION["Father"]);
unset($_SESSION["Numfile"]);
unset($_SESSION["File_Date"]);
unset($_SESSION["Last_Node"]);
unset($_SESSION["Level_Tree"]);
unset($_SESSION["Levels_Fixed_Path"]);
unset($_SESSION["Numbytes"]);
unset($_SESSION["Children_Files"]);
unset($_SESSION["Children_Subdirs"]);
unset($_SESSION["Maxfoldersize"]);
unset($_SESSION["Last_Level_Node"]);
unset($_SESSION["Total_Time"]);
unset($_SESSION["Server_Path"]);
$Permiso=$_SESSION["permiso"];
$modulo_anterior="";
if (isset($_SESSION["MODULO"]))
	$modulo_anterior=$_SESSION["MODULO"];

if (isset($arrHttp["modulo"])) {	$_SESSION["MODULO"]=$arrHttp["modulo"];
}
$lista_bases=array();
if (file_exists($db_path."bases.dat")){
	$fp = file($db_path."bases.dat");
	foreach ($fp as $linea){
		$linea=trim($linea);
		if ($linea!="") {
			$ix=strpos($linea,"|");
			$llave=trim(substr($linea,0,$ix));
			$lista_bases[$llave]=trim(substr($linea,$ix+1));
		}
	}
}
$central="";
$circulation="";
$acquisitions="";
$ixcentral=0;
foreach ($_SESSION["permiso"] as $key=>$value){	$p=explode("_",$key);
	if (isset($p[1]) and $p[1]=="CENTRAL"){		$central="Y";
		$ixcentral=$ixcentral+1;	}
	if (substr($key,0,8)=="CENTRAL_")  	{		$central="Y";
		$ixcentral=$ixcentral+1;	}
	if (substr($key,0,4)=="ADM_"){		$central="Y";
		$ixcentral=$ixcentral+1;	}
	if (substr($key,0,5)=="CIRC_")  	$circulation="Y";
	if (substr($key,0,4)=="ACQ_")  		$acquisitions="Y";

}
// Se determina el nombre de la página de ayuda a mostrar
if (!isset($_SESSION["MODULO"])) {	if ($central=="Y" and $ixcentral>0) {		$arrHttp["modulo"]="catalog";	}else{		if ($circulation=="Y"){			$arrHttp["modulo"]="loan";		}else{			$arrHttp["modulo"]="acquisitions";		}	}}else{	$arrHttp["modulo"]=$_SESSION["MODULO"];}
switch ($arrHttp["modulo"]){	case "catalog":
		$ayuda="homepage.html";
		$module_name=$msgstr["catalogacion"];
		$_SESSION["MODULO"]="catalog";
		break;
	case "acquisitions":
		$ayuda="acquisitions/homepage.html";
		$module_name=$msgstr["acquisitions"];
		$_SESSION["MODULO"]="acquisitions";
		break;
	case "loan":
		$ayuda="circulation/homepage.html";
		$module_name=$msgstr["loantit"];
		$_SESSION["MODULO"]="loan";}
if (file_exists($db_path."logtrans/data/logtrans.mst")){
	if ($_SESSION["MODULO"]!="loan" and $modulo_anterior=="loan"){
		include("../circulation/grabar_log.php");
		$datos_trans["operador"]=$_SESSION["login"];
		GrabarLog("Q",$datos_trans,$Wxis,$xWxis,$wxisUrl,$db_path);
	}else{		if ($_SESSION["MODULO"]=="loan" and $modulo_anterior!="loan"){
			include("../circulation/grabar_log.php");
			$datos_trans["operador"]=$_SESSION["login"];
			GrabarLog("P",$datos_trans,$Wxis,$xWxis,$wxisUrl,$db_path);
		}	}
}
include("header.php");
?>
<script>

function ActivarModulo(Url,base){	if (base=="Y"){		ix=document.admin.base.selectedIndex
		if (ix<1){
		  	alert("<?php echo $msgstr["seldb"]?>")
		   	return
		}
		base=document.admin.base.options[ix].value
		b=base.split('|')
		base=b[0]
		base="?base="+base;
	}else{		base="";	}
	Url="../"+Url+base
	top.location.href=Url}
function Modulo(){
	Opcion=document.cambiolang.modulo.options[document.cambiolang.modulo.selectedIndex].value
	switch (Opcion){
		case "loan":
			top.location.href="../common/change_module.php?modulo=loan"
			break
		case "acquisitions":
			top.location.href="../common/change_module.php?modulo=acquisitions"
			break

		case "catalog":
			top.location.href="../common/change_module.php?modulo=catalog"
			break


	}
}

	function CambiarLenguaje(){
		if (document.cambiolang.lenguaje.selectedIndex>0){
               lang=document.cambiolang.lenguaje.options[document.cambiolang.lenguaje.selectedIndex].value
               self.location.href="inicio.php?reinicio=s&lang="+lang
		}
	}

	function CambiarBaseAdministrador(Modulo){
		db=""
		if (Modulo!="traducir"){
			ix=document.admin.base.selectedIndex
		    if (ix<1){
		    	alert("<?php echo $msgstr["seldb"]?>")
		    	return
		    }
		    db=document.admin.base.options[ix].value
		    b=db.split('|')
		    db=b[0]
		}
	    switch(Modulo){			case 'table':
				document.admin.action="../dataentry/browse.php"
				break
	    	case "resetautoinc":
	    		if (db+"_CENTRAL_RESETLCN" in perms || "CENTRAL_RESETLCN" in perms || "CENTRAL_ALL" in perms || db+"_CENTRAL_ALL" in perms){
	    	   		document.admin.action="../dbadmin/resetautoinc.php";
	    		}else{	    			alert("<?php echo $msgstr["invalidright"];?>")
	    			return;	    		}
	    		break;
	    	case "toolbar":
	    		document.admin.action="../dataentry/inicio_main.php";
	    		break;
			case "utilitarios":

				if (db+"_CENTRAL_DBUTILS" in perms || "CENTRAL_DBUTILS" in perms || "CENTRAL_ALL" in perms || db+"_CENTRAL_ALL" in perms ){
					document.admin.action="../dbadmin/menu_mantenimiento.php";
				}else{
	    			alert("<?php echo $msgstr["invalidright"];?>")
	    			return;
	    		}
                break;
   			case "estructuras":
   				if (db+"_CENTRAL_MODIFYDEF" in perms || "CENTRAL_MODIFYDEF" in perms || "CENTRAL_ALL" in perms || db+"_CENTRAL_ALL" in perms){					document.admin.action="../dbadmin/menu_modificardb.php";
				}else{
	    			alert("<?php echo $msgstr["invalidright"];?>")
	    			return;
	    		}
                break;
    		case "reportes":
    			if (db+"_CENTRAL_PREC" in perms || "CENTRAL_PREC" in perms || "CENTRAL_ALL" in perms || db+"_CENTRAL_ALL" in perms){
					document.admin.action="../dbadmin/pft.php";
				}else{
	    			alert("<?php echo $msgstr["invalidright"];?>")
	    			return;
	    		}
                break;
    		case "traducir":
    			if (db+"_CENTRAL_TRANSLATE" in perms || "CENTRAL_TRANSLATE" in perms || "CENTRAL_ALL" in perms || db+"_CENTRAL_ALL" in perms){
					document.admin.action="../dbadmin/menu_traducir.php";
				}else{
	    			alert("<?php echo $msgstr["invalidright"];?>")
	    			return;
	    		}
                break;
    		case "stats":
    			if (db+"_CENTRAL_STATGEN" in perms || "CENTRAL_STATGEN" in perms || "CENTRAL_STATGEN" in perms || "CENTRAL_ALL" in perms || db+"_CENTRAL_ALL" in perms){
					document.admin.action="../statistics/tables_generate.php";
				}else{
	    			alert("<?php echo $msgstr["invalidright"];?>")
	    			return;
	    		}
    			break;
    		case "z3950":
    			if (db+"_CENTRAL_Z3950CONF" in perms || "CENTRAL_Z3950CONF" in perms || "CENTRAL_ALL" in perms || db+"CENTRAL_ALL" in perms){
					document.admin.action="../dbadmin/z3950_conf.php";
				}else{
	    			alert("<?php echo $msgstr["invalidright"];?>")
	    			return;
	    		}
    			break;
	    }
		document.admin.submit();
	}

	function FuncionesAdministracion(Accion){
		switch (Accion){			case "CBD":
				document.admFrm.action="../dbadmin/menu_creardb.php"
				document.admFrm.encabezado.value="s"
				break;
           	case "AUSR":
				document.admFrm.action="../dbadmin/users_adm.php"
				document.admFrm.encabezado.value="s"
				document.admFrm.base.value="acces"
				document.admFrm.cipar.value="acces.par"
				break;
			case "RNU":
				document.admFrm.action="../dbadmin/reset_inventory_number.php"
				document.admFrm.encabezado.value="s"
				break;
   			case "CABCD":
				document.admFrm.action="../dbadmin/conf_abcd.php"
				document.admFrm.Opcion.value="abcd_def"
				break;
			case "DIRTREE":
				document.admFrm.action="../dbadmin/dirtree.php"
				document.admFrm.encabezado.value="s"
				document.admFrm.retorno.value="inicio"
				break;


		}
		document.admFrm.submit()	}


	</script>

<body>
<div class=heading>
	<div class="institutionalInfo">
		<h1><img src=<?php if (isset($logo))
								echo $logo;
							else
								echo "../images/logoabcd.jpg";
					  ?>><?php echo $institution_name?> </h1>
    </div>
	<div class="userInfo">
		<span><?php echo $_SESSION["nombre"]?></span>,
		<?php echo $_SESSION["profile"]?> |
		<?php  $dd=explode("/",$db_path);
               if (isset($dd[count($dd)-2]) and $dd[count($dd)-2]!=""){
			   		$da=$dd[count($dd)-2];
			   		echo " (".$da.") ";
				}else{					echo " (".$db_path.") ";				}
				echo " | $meta_encoding";
		?> |
		<a href="../dataentry/logout.php" xclass="button_logout"><span>[logout]</span></a><br>
<?php
	if (isset($msg_path))
		$path_this=$msg_path;
	else
		$path_this=$db_path;
	$a=$path_this."lang/".$_SESSION["lang"]."/lang.tab";
 	if (!file_exists($a)) {
 		$a=$path_this."lang/en/lang.tab";
 	}
 	if (!file_exists($a)){
		echo $msgstr["flang"]." ".$a;
		die;
	}
 	$a=$path_this."lang/".$_SESSION["lang"]."/lang.tab";
 	if (!file_exists($a)) {
 		$a=$path_this."lang/en/lang.tab";
 	}
 	if (!file_exists($a)){
		echo $msgstr["flang"]." ".$path_this."lang/".$_SESSION["lang"]."/lang.tab";
		die;
	}
?>
<div class="language"><form name=cambiolang> <table border=0><td><?php echo $msgstr["lang"]?>:</td>
	<td><select name=lenguaje style="width:90px;font-size:10pt;font-family:arial narrow" onchange=CambiarLenguaje()>
		<option value=""></option>
		 <?php

 	if (file_exists($a)){
		$fp=file($a);
		$selected="";
		foreach ($fp as $value){
			$value=trim($value);
			if ($value!=""){
				$l=explode('=',$value);
				if ($l[0]==$_SESSION["lang"]) $selected=" selected";
				echo "<option value=$l[0] $selected>".$l[1]."</option>";
				$selected="";
			}
		}
		echo "</select>";
	}else{
		echo $msgstr["flang"].$db_path."lang/".$_SESSION["lang"]."/lang.tab";
		die;
	}
	echo "</td><tr>";
	$central="";
$circulation="";
$acquisitions="";
foreach ($_SESSION["permiso"] as $key=>$value){
	$p=explode("_",$key);
	if (isset($p[1]) and $p[1]=="CENTRAL") $central="Y";
	if (substr($key,0,8)=="CENTRAL_")  $central="Y";
	if (substr($key,0,5)=="CIRC_")  $circulation="Y";
	if (substr($key,0,4)=="ACQ_")  $acquisitions="Y";

}
if ($circulation=="Y" or $acquisitions=="Y" or $central=="Y"){
	echo "<td>".$msgstr["modulo"].":</td><td>";
  	echo '<select name=modulo style="width:90px;font-size:8pt;font-family:arial narrow"   onchange=Modulo()>';
  	echo '<option value=""></option>';
  	if ($central=="Y") {
  		echo "<option value=catalog";
  		if ($_SESSION["MODULO"]=="catalog") echo " selected";
  		echo ">".$msgstr["catalogacion"];
  	}
  	if ($circulation=="Y") {
  		echo "<option value=loan";
  		if ($_SESSION["MODULO"]=="loan") echo " selected";
  		echo ">".$msgstr["prestamo"];
  	}
  	if ($acquisitions=="Y") {
  		echo "<option value=acquisitions";
  		if ($_SESSION["MODULO"]=="acquisitions") echo " selected";
  		echo ">".$msgstr["acquisitions"];
  	}
  	echo "</select></td></table>";
}
?>
    </form>
    </div>
	</div>
	<div class="spacer">&#160;</div>
</div>



<div class="sectionInfo">
	<div class="breadcrumb">
		<strong><?php echo $msgstr["inicio"]." - $module_name"?></strong>
	</div>
	<div class="actions">
      &nbsp;
	</div>
	<div class="spacer">&#160;</div>
</div>

<div class="helper">
	<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]."/$ayuda"?> target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
 <?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"])){
 	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/$ayuda target=_blank>".$msgstr["edhlp"];
	echo "</a>
		&nbsp; &nbsp; Script: homepage.php";
}
?>
</div>
<div class="middle homepage">
<?php
$Permiso=$_SESSION["permiso"];
switch ($_SESSION["MODULO"]){	case "catalog":
		AdministratorMenu();
		break;
	case "loan":
		MenuLoanAdministrator();
		break;
	case "acquisitions":
		MenuAcquisitionsAdministrator();
		break;}
echo "		</div>
	</div>";
include("footer.php");
echo "<form name=admFrm method=post>
<input type=hidden name=Opcion>
<input type=hidden name=encabezado>
<input type=hidden name=base>
<input type=hidden name=retorno>
<input type=hidden name=cipar>
</form>";
echo "	</body>
</html>";

///---------------------------------------------------------------

function AdministratorMenu(){
global $msgstr,$db_path,$arrHttp,$lista_bases,$Permiso,$dirtree,$def;
	$_SESSION["MODULO"]="catalog";
?>

	<div class="mainBox" onmouseover="this.className = 'mainBox mainBoxHighlighted';" onmouseout="this.className = 'mainBox';">
		<div class="boxTop">
			<div class="btLeft">&#160;</div>
			<div class="btRight">&#160;</div>
		</div>
		<div class="boxContent toolSection ">
			<div class="sectionIcon">
				&#160;
			</div>
			<div class="sectionTitle">
				<h4><strong><?php echo $msgstr["database"]?></strong></h4>
			</div>
			<div class="sectionButtons">
            	<div class="searchTitles">
					<form name="admin" action="dataentry/inicio_main.php" method="post">
					<input type=hidden name=encabezado value=s>
					<input type=hidden name=retorno value="../common/inicio.php">
					<input type=hidden name=modulo value=catalog>
					<input type=hidden name=screen_width>
					<?php if (isset($arrHttp["newindow"]))
					echo "<input type=hidden name=newindow value=Y>\n";?>
					<div class="stInput">
						<label for="searchExpr"><?php echo $msgstr["seleccionar"]?>:</label>
						<select name=base  class="textEntry singleTextEntry" >
							<option value=""></option>
<?php
$i=-1;
foreach ($lista_bases as $key => $value) {
	$xselected="";
	$value=trim($value);
	$t=explode('|',$value);
	if (isset($Permiso["db_".$key]) or isset($_SESSION["permiso"]["db_ALL"]) or isset($_SESSION["permiso"]["CENTRAL_ALL"])){
		if (isset($arrHttp["base"]) and $arrHttp["base"]==$key or count($lista_bases)==1) $xselected=" selected";
		echo "<option value=\"$key|adm|$value\" $xselected>".$t[0]."\n";
	}
}
?>
						</select>
					</div>
					<a href="javascript:CambiarBaseAdministrador('toolbar')" class="menuButton nextButton">
						<img src="../images/mainBox_iconBorder.gif" alt="" title="" />
						<span><strong><?php echo $msgstr["dataentry"]?></strong></span>
					</a>
					</form>
				</div>
					&nbsp;
<?php
if (isset($def["MODULOS"])){
	if (isset($def["MODULOS"]["SELBASE"])  ){		$base_sel=$def["MODULOS"]["SELBASE"];	}else{		$base_sel="";	}?>
	<a href="javascript:ActivarModulo('<?php echo $def["MODULOS"]["SCRIPT"]."','$base_sel";?>')" class="menuButton <?php echo $def["MODULOS"]["BUTTON"]?>">
		<img src="../images/mainBox_iconBorder.gif" alt="" title="" />
		<span><strong><?php echo $def["MODULOS"]["TITLE"]?></strong></span>
	</a>
<?php}
?>
				<a href="javascript:CambiarBaseAdministrador('stats')" class="menuButton statButton">
					<img src="../images/mainBox_iconBorder.gif" alt="" title="" />
					<span><strong><?php echo $msgstr["statistics"]?></strong></span>
				</a>

				<a href="javascript:CambiarBaseAdministrador('reportes')" class="menuButton reportButton">
					<img src="../images/mainBox_iconBorder.gif" alt="" title="" />
					<span><strong><?php echo $msgstr["reports"]?></strong></span>
				</a>

				<a href="javascript:CambiarBaseAdministrador('estructuras')" class="menuButton update_databaseButton">
					<img src="../images/mainBox_iconBorder.gif" alt="" title="" />
					<span><strong><?php echo $msgstr["updbdef"]?></strong></span>
				</a>

				<a href="javascript:CambiarBaseAdministrador('utilitarios')" class="menuButton utilsButton">
					<img src="../images/mainBox_iconBorder.gif" alt="" title="" />
					<span><strong><?php echo $msgstr["maintenance"]?></strong></span>
				</a>

				<a href="javascript:CambiarBaseAdministrador('z3950')"  class="menuButton z3950Button">
					<img src="../images/mainBox_iconBorder.gif" alt="" title="" />
					<span><strong><?php echo $msgstr["z3950"]?></strong></span>
				</a>
			</div>
			<div class="spacer">&#160;</div>
			</div>
			<div class="boxBottom">
			<div class="bbLeft">&#160;</div>
			<div class="bbRight">&#160;</div>
		</div>
	</div>
<?php

if (isset($Permiso["CENTRAL_ALL"])  or isset($Permiso["CENTRAL_CRDB"])  or isset($Permiso["CENTRAL_USRADM"])
  or isset($Permiso["CENTRAL_RESETLIN"])  or isset($Permiso["CENTRAL_TRANSLATE"])  or isset($Permiso["CENTRAL_EXDBDIR"]))
{
?>
			<div class="mainBox" onmouseover="this.className = 'mainBox mainBoxHighlighted';" onmouseout="this.className = 'mainBox';">
				<div class="boxTop">
					<div class="btLeft">&#160;</div>
					<div class="btRight">&#160;</div>
				</div>
				<div class="boxContent toolSection ">
					<div class="sectionIcon">
						&#160;
					</div>
					<div class="sectionTitle">
						<h4><strong><?php echo $msgstr["admtit"]?></strong></h4>
					</div>
					<div class="sectionButtons">
<?Php
if (isset($Permiso["CENTRAL_ALL"])  or isset($Permiso["CENTRAL_CRDB"]) or isset($Permiso["ADM_CRDB"])){?>
                    <a href="javascript:FuncionesAdministracion('CBD')" class="menuButton databaseButton">
					<img src="../images/mainBox_iconBorder.gif" alt="" title="" />
					<span><strong><?php echo $msgstr["createdb"]?></strong></span></a>
<?Php
}
if (isset($Permiso["CENTRAL_ALL"])  or isset($Permiso["CENTRAL_USRADM"]) or isset($Permiso["ADM_USRADM"])){
?>
				<a href="javascript:FuncionesAdministracion('AUSR')" class="menuButton userButton">
					<img src="../images/mainBox_iconBorder.gif" alt="" title="" />
					<span><strong><?php echo $msgstr["usuarios"]?></strong></span>
				</a>
<?Php
}
if (isset($Permiso["CENTRAL_ALL"])  or isset($Permiso["CENTRAL_RESETLIN"])){
?>
				<a href="javascript:FuncionesAdministracion('RNU')" class="menuButton resetButton">
					<img src="../images/mainBox_iconBorder.gif" alt="" title="" />
					<span><strong><?php echo $msgstr["resetinv"]?></strong></span>
				</a>
<?Php
}
if (isset($Permiso["CENTRAL_ALL"])  or isset($Permiso["CENTRAL_TRANSLATE"])){
?>
				<a href="javascript:CambiarBaseAdministrador('traducir')" class="menuButton exportButton">
					<img src="../images/mainBox_iconBorder.gif" alt="" title="" />
					<span><strong><?php echo $msgstr["translate"]?></strong></span>
				</a>
<?Php
}
if ($_SESSION["profile"]=="adm"){?>				<a href="javascript:FuncionesAdministracion('CABCD')" class="menuButton utilsButton">
					<img src="../images/mainBox_iconBorder.gif" alt="" title="" />
					<span><strong><?php echo $msgstr["configure"]. " ABCD"?></strong></span>
				</a><?php}

if ($dirtree==1 or $dirtree=="Y"){	if ($_SESSION["profile"]=="adm"){
?>
				<a href="javascript:FuncionesAdministracion('DIRTREE')" class="menuButton exploreButton">
					<img src="../images/mainBox_iconBorder.gif" alt="" title="" />
					<span><strong><?php echo $msgstr["expbases"]?></strong></span>
				</a>
<?Php }
}?>
					</div>
					<div class="spacer">&#160;</div>
				</div>
				<div class="boxBottom">
					<div class="bbLeft">&#160;</div>
					<div class="bbRight">&#160;</div>
				</div>
			</div>


<?php
	}
}
// end function Administrador



function MenuAcquisitionsAdministrator(){
	include("menuacquisitions.php");
}

function MenuLoanAdministrator(){
   include("menucirculation.php");
}
echo "\n<script>\n";
echo "var perms= new Array()\n";
foreach ($_SESSION["permiso"] as $key=>$value){
	echo "perms['$key']='$value';\n";
}
echo "</script>\n";
?>
<script>
screen_width=window.screen.availWidth
document.admin.screen_width.value=screen_width
</script>