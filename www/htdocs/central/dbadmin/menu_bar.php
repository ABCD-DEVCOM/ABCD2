<?php
/* Modifications
20210314 fho4abcd html + improved hovering to submenu and subsubmenu
20210314 fho4abcd removed css xbox/xtext declarations (attempt without x was disappointing)
20210314 fho4abcd Menu: removed duplicate READ DB/ISO, removed empty button
20210315 fho4abcd Menu: Other code for Export ISO whith MX.Code to frame and back button
20210317 fho4abcd Initilalize DB uses now code inicio_bd.php
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
		case "importiso":    //Marino ISO load
			document.admin.base.value=base
			document.admin.cipar.value=base+".par"
			document.admin.action="../utilities/vmxISO_load.php"
			document.admin.target=""
			break;
		case "exportisoold":
			document.admin.base.value=base
			document.admin.cipar.value=base+".par"
			document.admin.action="../utilities/iso_export.php"
			document.admin.target=""
            document.admin.tipo.value="iso"
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
		case "advanced2":    //Marino ISO load
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
			document.admin.action="../utilities/addloanobject.php"
			document.admin.target=""
			break;
		case "convertutf8":    //Marino convert
			document.admin.base.value=base
			document.admin.cipar.value=base+".par"
			document.admin.action="../utilities/convert_utf8.php"
			document.admin.target=""
			break;
		case "convertansi":    //Marino convert
			document.admin.base.value=base
			document.admin.cipar.value=base+".par"
			document.admin.action="../utilities/convert_ansi.php"
			document.admin.target=""
			break;
		case "barcode":    //Marino barcode search
			document.admin.base.value=base
			document.admin.cipar.value=base+".par"
			document.admin.action="../utilities/barcode_check.php"
			document.admin.target=""
			break;
		case "docbatchimport":     //Marcos docbatchimport
			//NewWindow("../dataentry/img/preloader.gif","progress",100,100,"NO","center")
			document.admin.base.value=base
			document.admin.cipar.value=base+".par"
			document.admin.action="../utilities/docbatchimport.php"
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
  <li><a href="#">Db Maintenance</a>
      <ul>
        <li><a href='javascript:EnviarFormaMNT("fullinv","<?php echo $msgstr["mnt_gli"]?>")'><?php echo $msgstr["mnt_gli"] ."(MX)"?></a></li>
		<li><a href='javascript:EnviarFormaMNT("unlock","<?php echo $msgstr["mnt_unlock"]?>")'><?php echo $msgstr["mnt_unlock"]?></a></li>
		<li><a href='javascript:EnviarFormaMNT("cn","<?php echo $msgstr["assigncn"]?>")'><?php echo $msgstr["assigncn"]?></a></li>
		<li><a href='javascript:EnviarFormaMNT("lock","<?php echo $msgstr["protect_db"]?>")'><?php echo $msgstr["protect_db"]?></a></li>
		<li><a href='javascript:EnviarFormaMNT("inicializar","<?php echo $msgstr["mnt_ibd"]?>")'><?php echo $msgstr["mnt_ibd"]?></a></li>
		<li><a href='javascript:EnviarFormaMNT("eliminarbd","<?php echo $msgstr["mnt_ebd"]?>")'><?php echo $msgstr["mnt_ebd"]?></a></li>


      </ul>
  </li>
  <li><a href="#">Import/Export</a>
  	<ul>
       	<li><a href='Javascript:EnviarFormaMNT("exportiso","<?php echo "ExportISO MX"?>")'><?php echo $msgstr["exportiso_mx"]?></a></li>
       	<li><a href='Javascript:EnviarFormaMNT("exportisoold","<?php echo "ExportISO MX OLD"?>")'><?php echo "Export ISO WITH MX (iso_export.php)"?></a></li>
		<li><a href='Javascript:EnviarFormaMNT("isoexport","<?php echo "ExportISO MX"?>")'><?php echo "Export ISO with Visual MX"?></a></li>
		<li><a href='javascript:EnviarFormaMNT("mxdbread","<?php echo $msgstr["mx_dbread"]?>")'><?php echo $msgstr["mx_dbread"]?></a></li>
		<li><a href='Javascript:EnviarFormaMNT("importiso","<?php echo "ImportISO MX"?>")'><?php echo $msgstr["importiso_mx"]?></a></li>
  		<li><a href="#">Import documents</A>
    		<ul>
    			<li><a href='Javascript:EnviarFormaMNT("docbatchimport","<?php echo $msgstr["docbatchimport_mx"]?>")'><?php echo $msgstr["docbatchimport_mx"]?></a></li>
				<li><a href='Javascript:EnviarFormaMNT("importdoc","<?php echo "Import Document"?>")'><?php echo "Upload/Import Document"?></a></li>
			</ul>
  		</li>
  	</ul>
  </li>
  <li><a href="#">Backup/Restore</a>
   	<ul>
   		<li><a href='javascript:EnviarFormaMNT("dbcp","<?php echo $msgstr["db_cp"]?>")'><?php echo $msgstr["db_cp"]?></a></li>
   		<li><a href='javascript:EnviarFormaMNT("dbrestore","<?php echo $msgstr["db_restore"]?>")'><?php echo $msgstr["db_restore"]?></a></li>
		<li><a href='Javascript:EnviarFormaMNT("cleandb","<?php echo "Clean DB"?>")'><?php echo "Clean/Compact DB"?></a></li>
	</ul>
  </li>
  <li><a href="#">Copies/Loan objects</a>
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

  <li><a href="#">Convert UTF8 &lt;==&gt; ANSI</A>
  	<ul>
  		<li><a href='Javascript:EnviarFormaMNT("convertutf8","<?php echo "Convert ABCD to Unicode"?>")'><?php echo "Convert ABCD to Unicode"?></a></li>
        <li><a href='Javascript:EnviarFormaMNT("convertansi","<?php echo "Convert ABCD to ANSI"?>")'><?php echo "Convert ABCD to ANSI"?></a></li>
    </ul>
  </li>
<?php
	if (($_SESSION["profile"]=="adm" or isset($_SESSION["permiso"]["CENTRAL_ALL"]) or
		isset($_SESSION["permiso"]["CENTRAL_EXDBDIR"]) or
        isset($_SESSION["permiso"][$arrHttp["base"]."_CENTRAL_EXDBDIR"]))
        and isset($dirtree) and $dirtree=="Y"
    ){

?>
  <li><a href="#">Explore</A>
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
<input type=hidden name=encabezado value=s>
<input type=hidden name=folder>
<input type=hidden name=backtoscript value="/central/dbadmin/menu_mantenimiento.php">
<input type=hidden name=inframe value=0>
<input type=hidden name=tipo>
<input type=hidden name=activa value=<?php echo $_REQUEST["base"]?>>
<input type=hidden name=lang value=<?php echo $_SESSION["lang"]?>>
</form>
