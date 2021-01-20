<?php
session_start();

unset($_SESSION["Browse_Expresion"]);
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

//echo "<pre>"; print_r($_SESSION); ECHO "</pre>";

$Permiso=$_SESSION["permiso"];
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../common/get_post.php");
if (!isset($arrHttp["base"])) $arrHttp["base"]="";

if (strpos($arrHttp["base"],"|")===false){

}   else{
		$ix=explode('|',$arrHttp["base"]);
		$arrHttp["base"]=$ix[0];
}
$db=$arrHttp["base"];
include ("../config.php");
$lang=$_SESSION["lang"];
include("../lang/admin.php");
include("../lang/soporte.php");
include("../lang/dbadmin.php");

if (!isset($_SESSION["permiso"]["CENTRAL_ALL"]) and
    !isset($_SESSION["permiso"]["CENTRAL_DBUTILS"]) and
    !isset($_SESSION["permiso"][$db."_CENTRAL_ALL"]) and
    !isset($_SESSION["permiso"][$db."_CENTRAL_DBUTILS"])
    ){
	echo "<script>
	      alert('".$msgstr["invalidright"]."')
          history.back();
          </script>";
    die;
}


//SEE IF THE DATABASE IS LINKED TO COPIES
$copies="N";
$fp=file($db_path."bases.dat");
foreach ($fp as $value){
	$value=trim($value);
	$x=explode("|",$value);
	if ($x[0]==$arrHttp["base"]){
		if (isset($x[2]) and $x[2]=="Y"){			$copies="Y";
		}
		break;
	}
}
//foreach ($arrHttp as $var=>$value) echo "$var = $value<br>";
include("../common/header.php");
?>

<script src=../dataentry/js/lr_trim.js></script>


<script language="javascript" type="text/javascript">
<!--
/****************************************************
     Author: Eric King
     Url: http://redrival.com/eak/index.shtml
     This script is free to use as long as this info is left in
     Featured on Dynamic Drive script library (http://www.dynamicdrive.com)
****************************************************/
var win=null;
function NewWindow(mypage,myname,w,h,scroll,pos){
if(pos=="random"){LeftPosition=(screen.width)?Math.floor(Math.random()*(screen.width-w)):100;TopPosition=(screen.height)?Math.floor(Math.random()*((screen.height-h)-75)):100;}
if(pos=="center"){LeftPosition=(screen.width)?(screen.width-w)/2:100;TopPosition=(screen.height)?(screen.height-h)/2:100;}
else if((pos!="center" && pos!="random") || pos==null){LeftPosition=0;TopPosition=20}
settings='width='+w+',height='+h+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=no';
win=window.open(mypage,myname,settings);}
win.focus()
// -->

function EnviarForma(Opcion,Mensaje){

	base="<?php echo $arrHttp["base"]?>"
	if (Opcion=="eliminarbd" || Opcion=="inicializar"){
		if (base==""){
			alert("<?php echo $msgstr["seldb"]?>")
			return
		}

	}
	switch (Opcion){		case "dbcp":
			document.admin.base.value=base
			document.admin.cipar.value=base+".par"
			document.admin.action="../utilities/copy_db.php"
			document.admin.target=""
			break;
		case "mxdbread":
			document.admin.base.value=base
			document.admin.cipar.value=base+".par"
			document.admin.action="../utilities/mx_dbread.php"
			document.admin.target=""
			break;
//		case "readiso":
//			document.admin.base.value=base
//			document.admin.cipar.value=base+".par"
//			document.admin.action="../utilities/mx_dbread.php"
//			document.admin.iso="Y"
//			document.admin.target=""
//			break;
		case "dbrestore":
			document.admin.base.value=base
			document.admin.cipar.value=base+".par"
			document.admin.action="../utilities/dbrestore.php"
			document.admin.target=""
			break;
		case "lock":
			document.admin.base.value=base
			document.admin.cipar.value=base+".par"
			document.admin.action="lock_bd.php"
			document.admin.target=""
			break;
		case "eliminarbd":
			document.admin.base.value=base
			document.admin.cipar.value=base+".par"
			document.admin.action="eliminarbd.php"
			document.admin.target=""
			break;
		case "inicializar":
			document.admin.base.value=base
			document.admin.target=""
			break;
        case "cn":  //assign control number
          	document.admin.base.value=base
			document.admin.cipar.value=base+".par"
			document.admin.action="assign_control_number.php"
			document.admin.target=""
			break
		case "resetcn":    //RESET LAST CONTROL NUMBER IN THE BIBLIOGRAPHIC DATABASE
			document.admin.base.value=base
			document.admin.cipar.value=base+".par"
			document.admin.action="reset_control_number.php"
			document.admin.target=""
			break;
		case "linkcopies":    //LINK BIBLIOGRAPHIC DATABASE WITH COPIES DATABASE
			document.admin.base.value=base
			document.admin.cipar.value=base+".par"
			document.admin.action="copies_linkdb.php"
			document.admin.target=""
			break;
		case "addcopiesdatabase":    //Marcos Script
			document.admin.base.value=base
			document.admin.cipar.value=base+".par"
			document.admin.action="../utilities/addcopiesdatabase.php"
			document.admin.target=""
			break;
		case "copiesocurrenciesreport":    //Marcos Script
			document.admin.base.value=base
			document.admin.cipar.value=base+".par"
			document.admin.action="../utilities/copiesdupreport.php"
			document.admin.target=""
			break;
		case "addloanobjectcopies":    //Marcos Script
			document.admin.base.value=base
			document.admin.cipar.value=base+".par"
			document.admin.action="../utilities/addloanobjectcopies.php"
			document.admin.target=""
			break;
		case "addloanobj":    //Marino Vretag
			document.admin.base.value=base
			document.admin.cipar.value=base+".par"
			document.admin.action="../utilities/addloanobject.php"
			document.admin.target=""
			break;
		case "fullinv":     //INVERTED FILE GENERATION WITH MX
				NewWindow("../dataentry/img/preloader.gif","progress",100,100,"NO","center")
			document.admin.base.value=base
			document.admin.cipar.value=base+".par"
			document.admin.action="../utilities/vmx_fullinv.php"
			document.admin.target=""
			break;
		case "importiso":    //Marino ISO load
			document.admin.base.value=base
			document.admin.cipar.value=base+".par"
			document.admin.action="../utilities/vmxISO_load.php"
			document.admin.target=""
			break;
case "isoexport":    //Marino ISO export
				
				document.admin.base.value=base
				document.admin.cipar.value=base+".par"
				document.admin.action="../utilities/vmxISO_export.php"
				document.admin.target=""
				
				break;
case "importdoc":    //Marino doc import
				
				document.admin.base.value=base
				document.admin.cipar.value=base+".par"
				document.admin.action="../utilities/import_doc.php"
				document.admin.target=""
				
				break;
case "cleandb":    //Marino clean DB
				
				document.admin.base.value=base
				document.admin.cipar.value=base+".par"
				document.admin.action="../utilities/clean_db.php"
				document.admin.target=""
				
				break;
				case "unlock":    //Marino Vretag
				
				document.admin.base.value=base
				document.admin.cipar.value=base+".par"
				document.admin.action="../utilities/unlock_db_retag_check.php"
				document.admin.target=""
				break;
				case "addloanobj":    //Marino addloanobj
				
				document.admin.base.value=base
				document.admin.cipar.value=base+".par"
				document.admin.action=",,/utilities/addloanobject.php"
				document.admin.target=""
				
				break;
				
				case "barcode":    //Marino barcode search
				
				document.admin.base.value=base
				document.admin.cipar.value=base+".par"
				document.admin.action="../utilities/barcode.php"
				document.admin.target=""
				
								break;
								case "docbatchimport":     //Marcos docbatchimport
				//NewWindow("../dataentry/img/preloader.gif","progress",100,100,"NO","center")
				document.admin.base.value=base
				document.admin.cipar.value=base+".par"
				document.admin.action="../utilities/docbatchimport.php"
				document.admin.target=""
				break;
			case "dirtree": //EXPLORE DATABASE DIRECTORY
				switch (Mensaje){
					case "par":
					case "www":
					case "wrk":
						document.admin.base.value=Mensaje
						break;
					default:
						document.admin.base.value=base
						break;
				}

				document.admin.action="dirtree.php";
				document.admin.target=""
				break;
				case "mx_based_utils":    //Marino addloanobj
				
				document.admin.base.value=base
				document.admin.cipar.value=base+".par"
				document.admin.action="../utilities/menu_mx_based.php"
				document.admin.target=""
				
				break;
			default:
				alert("")
				return;

		}
		document.admin.Opcion.value=Opcion
		document.admin.cipar.value=base+".par"
		document.admin.submit()
//	}

}

</script>
<body onunload=win.close()>
<?php
if (isset($arrHttp["encabezado"])) {
	include("../common/institutional_info.php");
	$encabezado="&encabezado=s";
}
echo "
	<div class=\"sectionInfo\">
			<div class=\"breadcrumb\">".
				$msgstr["maintenance"]. ": " . $arrHttp["base"]."
			</div>
			<div class=\"actions\">

	";
if (isset($arrHttp["encabezado"])){
	echo "<a href=\"../common/inicio.php?reinicio=s&base=".$arrHttp["base"]."\" class=\"defaultButton backButton\">";
echo "<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
	<span><strong>". $msgstr["back"]."</strong></span></a>";
}
echo "</div>
	<div class=\"spacer\">&#160;</div>
	</div>";
?>
<div class="helper">
	<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/menu_mantenimiento.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
 	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/menu_mantenimiento.html target=_blank>".$msgstr["edhlp"]."</a>";
echo " &nbsp; &nbsp; <a href='http://abcdwiki.net/wiki/es/index.php?title=Utilitarios' target=_blank>Abcdwiki</a>";
echo "<font color=white>&nbsp; &nbsp; Script: dbadmin/menu_mantenimiento.php";
?>
</font>
</div>
<div class="middle form">
	<div class="formContent">
<form name=maintenance>
<table cellspacing=5 width=500 align=center>
	<tr>
		<td nowrap>

		<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>

             <br>
			<ul style="font-size:12px;line-height:20px">

			<li><a href='javascript:EnviarForma("fullinv","<?php echo $msgstr["mnt_gli"]?>")'><?php echo $msgstr["mnt_gli"] ."(MX)"?></a></li>
			<li><a href='javascript:EnviarForma("dbcp","<?php echo $msgstr["db_cp"]?>")'><?php echo $msgstr["db_cp"]?></a></li>
			<li><a href='javascript:EnviarForma("mxdbread","<?php echo $msgstr["mx_dbread"]?>")'><?php echo $msgstr["mx_dbread"]?></a></li>
			<li><a href='javascript:EnviarForma("dbrestore","<?php echo $msgstr["db_restore"]?>")'><?php echo $msgstr["db_restore"]?></a></li>
			<li><a href='javascript:EnviarForma("inicializar","<?php echo $msgstr["mnt_ibd"]?>")'><?php echo $msgstr["mnt_ibd"]?></a></li>
			<li><a href='javascript:EnviarForma("eliminarbd","<?php echo $msgstr["mnt_ebd"]?>")'><?php echo $msgstr["mnt_ebd"]?></a></li>
			<li><a href='javascript:EnviarForma("lock","<?php echo $msgstr["protect_db"]?>")'><?php echo $msgstr["protect_db"]?></a></li>
			<li><a href='javascript:EnviarForma("unlock","<?php echo $msgstr["mnt_unlock"]?>")'><?php echo $msgstr["mnt_unlock"]?></a></li>
<!--			<li><a href='Javascript:EnviarForma("exportiso","<?php echo "ExportISO MX"?>")'><?php echo $msgstr["exportiso_mx"]?></a></li>  -->
<!--			<li><a href='Javascript:EnviarForma("importiso","<?php echo "ImportISO MX"?>")'><?php echo $msgstr["importiso_mx"]?></a></li>  -->
<!--			<li><a href='Javascript:EnviarForma("readiso","<?php echo "ReadISO  MX"?>")'><?php echo $msgstr["readiso_mx"]?></a></li> -->
			<li><a href='javascript:EnviarForma("cn","<?php echo $msgstr["assigncn"]?>")'><?php echo $msgstr["assigncn"]?></a></li>
<!--			<li><a href='javascript:EnviarForma("linkcopies","<?php echo $msgstr["linkcopies"]?>")'><?php echo $msgstr["linkcopies"]?></a></li> -->
			<?php if (($arrHttp["base"]!="copies") and ($arrHttp["base"]!="providers") and ($arrHttp["base"]!="suggestions") and ($arrHttp["base"]!="purchaseorder") and ($arrHttp["base"]!="users") and ($arrHttp["base"]!="loanobjects") and ($arrHttp["base"]!="trans") and ($arrHttp["base"]!="suspml") ) {				if ($copies=="Y"){
			?>

			<?php }}
			if (($arrHttp["base"]!="copies") and ($arrHttp["base"]!="providers") and ($arrHttp["base"]!="suggestions") and ($arrHttp["base"]!="purchaseorder") and ($arrHttp["base"]!="users") and ($arrHttp["base"]!="loanobjects") and ($arrHttp["base"]!="trans") and ($arrHttp["base"]!="suspml") ) {
				if ($copies=="Y" or $arrHttp["base"]=="copies" or $arrHttp["base"]=="loanobjects"){
            ?>
    			<li><a href='javascript:EnviarForma("linkcopies","<?php echo $msgstr["linkcopies"]?>")'><?php echo $msgstr["linkcopies"]?></a></li>
<!-- 			<li><a href='Javascript:EnviarForma("addloanobj","<?php echo $msgstr["addLOfromDB_mx"]?>")'><?php echo $msgstr["addLOfromDB_mx"]?></a></li> -->
<!--			<li><a href='Javascript:EnviarForma("addloanobjectcopies","<?php echo $msgstr["addLOwithoCP_mx"]?>")'><?php echo $msgstr["addLOwithoCP_mx"]?></a></li> -->
<!--			<li><a href='Javascript:EnviarForma("addcopiesdatabase","<?php echo $msgstr["addCPfromDB_mx"]?>")'><?php echo $msgstr["addCPfromDB_mx"]?></a></li> -->
            <?php }?>
<!--             		<li><a href='Javascript:EnviarForma("barcode","<?php echo "Barcode search"?>")'><?php echo "Barcode search"?></a></li> -->
			<?php
			}
			if ($arrHttp["base"]=="copies") {
			?>
			<li><a href='Javascript:EnviarForma("copiesocurrenciesreport","<?php echo $msgstr["CPdupreport_mx"]?>")'><?php echo $msgstr["CPdupreport_mx"]?></a></li>
			<?php }?>

	<?php
	if (($_SESSION["profile"]=="adm" or isset($_SESSION["permiso"]["CENTRAL_ALL"]) or
		isset($_SESSION["permiso"]["CENTRAL_EXDBDIR"]) or
        isset($_SESSION["permiso"][$arrHttp["base"]."_CENTRAL_EXDBDIR"]))
        and isset($dirtree) and $dirtree=="Y"
    ){

    ?>
    		<li><a href='Javascript:EnviarForma("dirtree","<?php echo $msgstr["expbases"]?>")'><?php echo $msgstr["expbases"]?></a></li>
	        <?php echo $msgstr["explore_sys_folders"]?>
	        <ul>
			<li><a href='Javascript:EnviarForma("dirtree","par")'><?php echo "par"?></a></li>
			<li><a href='Javascript:EnviarForma("dirtree","www")'><?php echo "www"?></a></li>
			<li><a href='Javascript:EnviarForma("dirtree","wrk")'><?php echo "wrk"?></a></li>
	        </ul>
			<li><a style="color:green;" href='Javascript:EnviarForma("mx_based_utils","<?php echo "mx_based_utils"?>")'><?php echo "EXTRA UTILITIES"?></a></li>
	<?php }?>
<!--	<li><a href='javascript:EnviarForma("more_utils","<?php echo $msgstr["more_utils"]?>")'><?php echo $msgstr["more_utils"]?></a></li>  -->
			</ul>

		</td>
</table></form>
<form name=admin method=post action=administrar_ex.php onSubmit="Javascript:return false">
<input type=hidden name=base>
<input type=hidden name=cipar>
<input type=hidden name=Opcion>
<input type=hidden name=encabezado value=s>
<input type=hidden name=folder>
<input type=hidden name=iso>
<input type=hidden name=activa value=<?php echo $_REQUEST["base"]?>>
<?php if (isset($arrHttp["encabezado"])) echo "<input type=hidden name=encabezado value=s>"?>
</form>
</div>
</div>
<?php include("../common/footer.php");?>
</body>
</html>
