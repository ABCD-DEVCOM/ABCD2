<?php
/* Modifications
20210314 fho4abcd html + improved hovering to submenu and subsubmenu
20210314 fho4abcd removed css xbox/xtext declarations (attempt without x was disappointing)
20210314 fho4abcd Menu: removed duplicate READ DB/ISO, removed empty button
20210315 fho4abcd Menu: Other code for Export ISO whith MX.Code to frame and back button
20210317 fho4abcd Initilalize DB uses now code inicio_bd.php
20210325 fho4abcd Reorganized exports: all exports by 1 menu item. Others removed
20210411 fho4abcd unlock_db_retag_check -> unlock_db_retag
20210418 fho4abcd vmxISO_load -> vmx_import_iso
20210421 fho4abcd Commented mxdbread (dangerous and currently not working correct)
20210421 fho4abcd Improved text Import ISO (no longer with MX in the title)
20210516 fho4abcd Add function upload file
20210526 fho4abcd function for convert replaced. Update convert menu text (translated text) add option to convert language
20210607 fho4abcd Add function to convert an iso to utf-8
20210702 fho4abcd Add function to match an iso with an fdt
20210705 fho4abcd Uncomment mxdbread, move to db maintenance and make it work for current mst file (should be safe)
20210718 fho4abcd Add function DSpace bridge
20210829 fho4abcd Modified Import Documents
*/
$lang=$_SESSION["lang"];
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
?>
<style>
nav {
  display: block;
  text-align: left;
  width:100%;
  background: #364C6C;
}
nav ul {
  margin: 0;
  padding:0;
  list-style: none;
}
.nav a {
  display:block;
  background: #364C6C;
  color: #fff;
  text-decoration: none;
  padding: 0.8em 1.8em;
  text-transform: uppercase;
  font-size: 80%;
  letter-spacing: 2px;
  position: relative;
}
.nav{
  vertical-align: top;
  display: inline-block;
  border-radius:6px;
}
.nav li {
  position: relative;
}
.nav > li {
  float: left;
  border-bottom: 4px #aaa solid;
  margin-right: 1px;
}
.nav > li > a {
  margin-bottom: 1px;
}
.nav > li:hover,
.nav > li:hover > a {
  border-bottom-color: orange;
}
.nav li:hover > a {
  color:orange;
}
.nav > li:first-child {
  border-radius: 4px 0 0 4px;
}
.nav > li:first-child > a {
  border-radius: 4px 0 0 0;
}
.nav > li:last-child {
  border-radius: 0 0 4px 0;
  margin-right: 0;
}
.nav > li:last-child > a {
  border-radius: 0 4px 0 0;
}
.nav li li a {
  margin-top: 1px;
}

.nav li a:first-child:nth-last-child(2):before {
  content: "";
  position: absolute;
  height: 0;
  width: 0;
  border: 5px solid transparent;
  top: 50% ;
  right:5px;
 }

/* submenu positioning*/
.nav ul {
  position: absolute;
  white-space: nowrap;
  border-bottom: 5px solid  orange;
  z-index: 1;
  left: -99999em;
}
.nav > li:hover > ul {
  left: auto;
  margin-top: 1px;
  min-width: 100%;
}
.nav > li li:hover > ul {
  left: 100%;
  margin-left: 0px;
  top: -6px;
}
/* arrow hover styling */
.nav > li > a:first-child:nth-last-child(2):before {
  border-top-color: #aaa;
}
.nav > li:hover > a:first-child:nth-last-child(2):before {
  border: 5px solid transparent;
  border-bottom-color: orange;
  margin-top:-5px
}
.nav li li > a:first-child:nth-last-child(2):before {
  border-left-color: #aaa;
  margin-top: -5px
}
.nav li li:hover > a:first-child:nth-last-child(2):before {
  border: 5px solid transparent;
  border-right-color: orange;
  right: 10px;
}

</style>
<script language="javascript" type="text/javascript">

function EnviarFormaMNT(Opcion,Mensaje){

	base="<?php echo $arrHttp["base"]?>"
	if (Opcion=="eliminarbd" || Opcion=="inicializar"){
		if (base==""){
			alert("<?php echo $msgstr["seldb"]?>")
			return
		}

	}
	switch (Opcion){
		case "dbcp":
			document.admin.base.value=base
			document.admin.cipar.value=base+".par"
			document.admin.action="../utilities/copy_db.php"
			document.admin.target=""
			break;
		case "mxdbread":
			document.admin.base.value=base
			document.admin.cipar.value=base+".par"
            document.admin.storein.value=base+"/data"
			document.admin.copyname.value=base+".mst"
			document.admin.action="../utilities/mx_dbread.php"
			document.admin.target=""
			break;
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
            document.admin.action="inicio_bd.php"
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
			document.admin.action="addcopiesdatabase.php"
			document.admin.target=""
			break;
		case "copiesocurrenciesreport":    //Marcos Script
			document.admin.base.value=base
			document.admin.cipar.value=base+".par"
			document.admin.action="copiesdupreport.php"
			document.admin.target=""
			break;
		case "addloanobjectcopies":    //Marcos Script
			document.admin.base.value=base
			document.admin.cipar.value=base+".par"
			document.admin.action="addloanobjectcopies.php"
			document.admin.target=""
			break;
		case "addloanobj":    //Marino Vretag
			document.admin.base.value=base
			document.admin.cipar.value=base+".par"
			document.admin.action="addloanobject.php"
			document.admin.target=""
			break;
		case "fullinv":     //INVERTED FILE GENERATION WITH MX
			document.admin.base.value=base
			document.admin.cipar.value=base+".par"
			document.admin.action="../utilities/vmx_fullinv.php"
			document.admin.target=""
			break;
		case "importiso":    //ISO load
			document.admin.base.value=base
			document.admin.cipar.value=base+".par"
			document.admin.action="../utilities/vmx_import_iso.php"
			document.admin.target=""
			break;
		case "exportiso":
			document.admin.base.value=base
			document.admin.cipar.value=base+".par"
            document.admin.action="../dataentry/exporta_txt.php"
			document.admin.target=""
            document.admin.tipo.value="iso"
			break;
		case "addloanobj":    //Marino addloanobj
			document.admin.base.value=base
			document.admin.cipar.value=base+".par"
			document.admin.action="addloanobject.php"
			document.admin.target=""
			break;
		case "barcode":    //Marino barcode search
			document.admin.base.value=base
			document.admin.cipar.value=base+".par"
			document.admin.action="../utilities/barcode.php"
			document.admin.target=""
			break;
		case "dirtree": //EXPLORE DATABASE DIRECTORY
			switch (Mensaje){
				case "par":
				case "www":
				case "wrk":
					document.admin.folder.value=Mensaje
					document.admin.base.value=base
					break;
				default:
					document.admin.base.value=base
					break;
			}
			document.admin.action="dirtree.php";
			document.admin.target=""
			break;
		case "addcopiesdatabase":    //Marino Script
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
			document.admin.action="addloanobjectcopies.php"
			document.admin.target=""
			break;
		case "importdoc":
			document.admin.base.value=base
			document.admin.cipar.value=base+".par"
			document.admin.action="../utilities/docfiles_upload.php"
			document.admin.target=""
			break;
		case "cleandb":    //Marino clean DB
  			document.admin.base.value=base
			document.admin.cipar.value=base+".par"
			document.admin.action="../utilities/clean_db.php"
			document.admin.target=""
   			break;
		case "unlock":    // unlock db
			document.admin.base.value=base
			document.admin.cipar.value=base+".par"
			document.admin.action="../utilities/unlock_db_retag.php"
			document.admin.target=""
			break;
		case "addloanobj":    //Marino addloanobj
			document.admin.base.value=base
			document.admin.cipar.value=base+".par"
			document.admin.action="../utilities/addloanobject.php"
			document.admin.target=""
			break;
		case "convertdbutf":
			document.admin.base.value=base
			document.admin.targetcode.value="UTF-8"
			document.admin.function.value="database"
			document.admin.cipar.value=base+".par"
			document.admin.action="../utilities/convert_txt.php"
			document.admin.target=""
			break;
		case "convertdbiso":
			document.admin.base.value=base
			document.admin.targetcode.value="ISO-8859-1"
			document.admin.function.value="database"
			document.admin.cipar.value=base+".par"
			document.admin.action="../utilities/convert_txt.php"
			document.admin.target=""
			break;
		case "convertlangutf":
			document.admin.base.value=base
			document.admin.targetcode.value="UTF-8"
			document.admin.function.value="language"
			document.admin.cipar.value=base+".par"
			document.admin.action="../utilities/convert_txt.php"
			document.admin.target=""
			break;
		case "convertlangiso":
			document.admin.base.value=base
			document.admin.targetcode.value="ISO-8859-1"
			document.admin.function.value="language"
			document.admin.cipar.value=base+".par"
			document.admin.action="../utilities/convert_txt.php"
			document.admin.target=""
			break;
		case "convertiso2utf":    //convert ISO
			document.admin.base.value=base
			document.admin.cipar.value=base+".par"
			document.admin.action="../utilities/cnv_iso_2_utf.php"
			document.admin.target=""
			break;
		case "matchisofdt":    //Match ISO with fdt
			document.admin.base.value=base
			document.admin.cipar.value=base+".par"
			document.admin.action="../utilities/match_iso_with_fdt.php"
			document.admin.target=""
			break;
		case "barcode":    //Marino barcode search
			document.admin.base.value=base
			document.admin.cipar.value=base+".par"
			document.admin.action="../utilities/barcode_check.php"
			document.admin.target=""
			break;
		case "docbatchimport":     //was Marcos docbatchimport
			//NewWindow("../dataentry/img/preloader.gif","progress",100,100,"NO","center")
			document.admin.base.value=base
			document.admin.cipar.value=base+".par"
			document.admin.action="../utilities/docfiles_import.php"
			document.admin.target=""
			break;
		case "uploadfile":
			document.admin.base.value=base
			document.admin.cipar.value=base+".par"
			document.admin.action="../utilities/upload_wrkfile.php"
			document.admin.target=""
			break;
		case "dcdspace":
			document.admin.base.value=base
			document.admin.cipar.value=base+".par"
			document.admin.action="../utilities/dcdspace.php"
			document.admin.target=""
			break;
		default:
			alert(Opcion+" Not Available")
			return;

	}
	document.admin.Opcion.value=Opcion
	document.admin.cipar.value=base+".par"
	document.admin.submit()
}

</script>
<?php

//foreach ($_REQUEST AS $var=>$value) echo "$var=$value<br>"; die;

?>
<nav>

  <ul class="nav">
  <li><a href="#"><?php echo $msgstr["dbmaintenance"]?></a>
      <ul>
        <li><a href='javascript:EnviarFormaMNT("fullinv","<?php echo $msgstr["mnt_gli"]?>")'><?php echo $msgstr["mnt_gli"]?></a></li>
		<li><a href='javascript:EnviarFormaMNT("unlock","<?php echo $msgstr["mnt_unlock"]?>")'><?php echo $msgstr["mnt_unlock"]?></a></li>
		<li><a href='javascript:EnviarFormaMNT("cn","<?php echo $msgstr["assigncn"]?>")'><?php echo $msgstr["assigncn"]?></a></li>
		<li><a href='javascript:EnviarFormaMNT("lock","<?php echo $msgstr["protect_db"]?>")'><?php echo $msgstr["protect_db"]?></a></li>
		<li><a href='javascript:EnviarFormaMNT("inicializar","<?php echo $msgstr["mnt_ibd"]?>")'><?php echo $msgstr["mnt_ibd"]?></a></li>
		<li><a href='javascript:EnviarFormaMNT("eliminarbd","<?php echo $msgstr["mnt_ebd"]?>")'><?php echo $msgstr["mnt_ebd"]?></a></li>
		<li><a href='javascript:EnviarFormaMNT("mxdbread","<?php echo $msgstr["mx_dbread"]?>")'><?php echo $msgstr["mx_dbread"]?></a></li>
      </ul>
  </li>
  <li><a href="#"><?php echo $msgstr["cnv_export"]."/".$msgstr["cnv_import"]?></a>
  	<ul>
       	<li><a href='Javascript:EnviarFormaMNT("exportiso","<?php echo $msgstr["cnv_export"]." ".$msgstr["cnv_iso"]?>")'><?php echo $msgstr["cnv_export"]." ".$msgstr["cnv_iso"]?></a></li>
		<li><a href='Javascript:EnviarFormaMNT("importiso","<?php echo $msgstr["cnv_import"]." ISO ".$msgstr["archivo"]?>")'><?php echo $msgstr["cnv_import"]." ISO ".$msgstr["archivo"]?></a></li>
		<li><a href='Javascript:EnviarFormaMNT("matchisofdt","<?php echo $msgstr["matchisofdt"]?>")'><?php echo $msgstr["matchisofdt"]?></a></li>
		<li><a href='Javascript:EnviarFormaMNT("uploadfile","<?php echo $msgstr["uploadfile"]?>")'><?php echo $msgstr["uploadfile"]?></a></li>
        <?php if ($arrHttp["base"]==("dcdspace")) { ?>
		<li><a href='Javascript:EnviarFormaMNT("dcdspace","<?php echo $msgstr["dspace_title"]?>")'><?php echo $msgstr["dspace_title"]?></a></li>
        <?php } ?>
  		<li><a href="#"><?php echo $msgstr["dd_documents"]?></a>
    		<ul>
				<li><a href='Javascript:EnviarFormaMNT("importdoc","<?php echo $msgstr["dd_upload"]?>")'><?php echo $msgstr["dd_upload"]?></a></li>
    			<li><a href='Javascript:EnviarFormaMNT("docbatchimport","<?php echo $msgstr["dd_batchimport"]?>")'><?php echo $msgstr["dd_batchimport"]?></a></li>
			</ul>
  		</li>
  	</ul>
  </li>
  <li><a href="#"><?php echo $msgstr["dbbackrest"]?></a>
   	<ul>
   		<li><a href='javascript:EnviarFormaMNT("dbcp","<?php echo $msgstr["db_cp"]?>")'><?php echo $msgstr["db_cp"]?></a></li>
   		<li><a href='javascript:EnviarFormaMNT("dbrestore","<?php echo $msgstr["db_restore"]?>")'><?php echo $msgstr["db_restore"]?></a></li>
		<li><a href='Javascript:EnviarFormaMNT("cleandb","<?php echo "Clean DB"?>")'><?php echo "Clean/Compact DB"?></a></li>
	</ul>
  </li>
  <li><a href="#"><?php echo $msgstr["copyloanobjects"]?></a>
  	<ul>
  		<li><a href='javascript:EnviarFormaMNT("linkcopies","<?php echo $msgstr["linkcopies"]?>")'><?php echo $msgstr["linkcopies"]?></a></li>
		<?php if ($arrHttp["base"]!="copies" and $arrHttp["base"]!="providers" and $arrHttp["base"]!="suggestions" and $arrHttp["base"]!="purchaseorder" and $arrHttp["base"]!="users" and $arrHttp["base"]!="loanobjects" and $arrHttp["base"]!="trans" and $arrHttp["base"]!="suspml" and $arrHttp["base"]!="reserve" ) {
				if ($copies=="Y" or $arrHttp["base"]=="copies" or $arrHttp["base"]=="loanobjects"){
  		?>

  	    <li><a href='Javascript:EnviarFormaMNT("addloanobj","<?php echo $msgstr["addLOfromDB_mx"]?>")'><?php echo $msgstr["addLOfromDB_mx"]?></a></li>
		<li><a href='Javascript:EnviarFormaMNT("addloanobjectcopies","<?php echo $msgstr["addLOwithoCP_mx"]?>")'><?php echo $msgstr["addLOwithoCP_mx"]?></a></li>
		<li><a href='Javascript:EnviarFormaMNT("addcopiesdatabase","<?php echo $msgstr["addCPfromDB_mx"]?>")'><?php echo $msgstr["addCPfromDB_mx"]?></a></li>
        <li><a href='Javascript:EnviarFormaMNT("barcode","<?php echo "Barcode search"?>")'><?php echo "Barcode search"?></a></li>
  	    <li><a href='Javascript:EnviarFormaMNT("copiesocurrenciesreport","<?php echo $msgstr["CPdupreport_mx"]?>")'><?php echo $msgstr["CPdupreport_mx"]?></a></li>
  		<?php } } ?>
  	</ul>
  </li>

  <li><a href="#"><?php echo $msgstr["convert"];?> ISO &harr; UTF-8</A>
  	<ul>
  		<li><a href='Javascript:EnviarFormaMNT("convertdbutf","<?php echo $msgstr["convert_txtutf"]?>")'><?php echo $msgstr["convert_txtutf"]?></a></li>
  		<li><a href='Javascript:EnviarFormaMNT("convertiso2utf","<?php echo $msgstr["cnv_iso2utf"]?>")'><?php echo $msgstr["cnv_iso2utf"]?></a></li>
  		<li><a href='Javascript:EnviarFormaMNT("convertlangutf","<?php echo $msgstr["convert_langutf"]?>")'><?php echo $msgstr["convert_langutf"]?></a></li>
        <li><a href='#'>&nbsp;</a></li>
        <li><a href='Javascript:EnviarFormaMNT("convertdbiso","<?php echo $msgstr["convert_txtiso"]?>")'><?php echo $msgstr["convert_txtiso"]?></a></li>
  		<li><a href='Javascript:EnviarFormaMNT("convertlangiso","<?php echo $msgstr["convert_langiso"]?>")'><?php echo $msgstr["convert_langiso"]?></a></li>
    </ul>
  </li>
<?php
	if (($_SESSION["profile"]=="adm" or isset($_SESSION["permiso"]["CENTRAL_ALL"]) or
		isset($_SESSION["permiso"]["CENTRAL_EXDBDIR"]) or
        isset($_SESSION["permiso"][$arrHttp["base"]."_CENTRAL_EXDBDIR"]))
        and isset($dirtree) and $dirtree=="Y"
    ){

?>
  <li><a href="#"><?php echo $msgstr["explore"];?></A>
    <ul>

    	<li><a href='Javascript:EnviarFormaMNT("dirtree","<?php echo $msgstr["expbases"]?>")'><?php echo $msgstr["expbases"]?></a></li>
	    <li><a href="#"><?php echo $msgstr["explore_sys_folders"]?></a>
	    <ul>
			<li><a href='Javascript:EnviarFormaMNT("dirtree","par")'><?php echo "par"?></a></li>
			<li><a href='Javascript:EnviarFormaMNT("dirtree","www")'><?php echo "www"?></a></li>
			<li><a href='Javascript:EnviarFormaMNT("dirtree","wrk")'><?php echo "wrk"?></a></li>
	    </ul>
		</li>

    </ul>
  </li>
  </ul>
<?php }?>
</nav>
<!--administrar_default.php is never used see document.admin.action in javascript above -->
<form name=admin method=post action=administrar_default.php onSubmit="Javascript:return false">
<input type=hidden name=base value=<?php if (isset($_REQUEST["base"])) echo $_REQUEST["base"]?>>
<input type=hidden name=cipar value=<?php if (isset($_REQUEST["base"])) echo $_REQUEST["base"]?>.par>
<input type=hidden name=Opcion>
<input type=hidden name=storein>
<input type=hidden name=copyname>
<input type=hidden name=encabezado value=s>
<input type=hidden name=folder>
<input type=hidden name=backtoscript value="/central/dbadmin/menu_mantenimiento.php">
<input type=hidden name=inframe value=0>
<input type=hidden name=tipo>
<input type=hidden name=function>
<input type=hidden name=targetcode>
<input type=hidden name=activa value=<?php echo $_REQUEST["base"]?>>
<input type=hidden name=lang value=<?php echo $_SESSION["lang"]?>>
</form>
