<?php
/* Modifications
20211216 fho4abcd Backbutton & helper by included file+ improve date prefix
20220220 fho4abcd Make search for MFN and by expression equal to Reports.
20220220 fh04abcd The option to search by date is covered by expression (and better) : removed completely
20220220 fh04abcd Removed global process: too much code fails. Unclear what it should do. Sanitized html
*/
// ==================================================================================================
// GENERA LOS CUADROS ESTADÍSTICOS
// ==================================================================================================
//

session_start();
include("../common/get_post.php");
include ("../config.php");
include ("../lang/admin.php");
include ("../lang/dbadmin.php");
include ("../lang/statistics.php");
$backtoscript="../common/inicio.php"; // The default return script

//foreach ($arrHttp as $key => $value) echo "$key = $value <br>";
//SE EXTRAE EL NOMBRE DE LA BASE DE DATOS
$x=explode('|',$arrHttp["base"]);
$arrHttp["base"]=$x[0];
if (!isset($arrHttp["Opcion"]))$arrHttp["Opcion"]="";

if (isset($arrHttp["encabezado"]))
	$encabezado="&encabezado=S";
else
	$encabezado="";


//HEADER DEL LA PÁGINA HTML Y ARCHIVOS DE ESTIVO
include("../common/header.php");
include ("../common/inc_get-dbinfo.php");// sets $arrHttp["MAXMFN"]

?>
<body>
<script language="JavaScript" type="text/javascript" src="../dataentry/js/lr_trim.js"></script>
<style type=text/css>

div#statsgen{
	margin: 0px 20px 0px 20px;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000000;
}

div#useextproc{

	display: none;
	margin: 0px 20px 0px 20px;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000000;
}

div#useextable{

	display: none;
	margin: 0px 20px 0px 20px;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000000;
}

div#createtable{
<?php if ($arrHttp["Opcion"]!="new") echo "display: none;\n"?>

	margin: 0px 20px 0px 20px;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000000;
}

div#generate{
	display: none;
	margin: 0px 20px 0px 20px;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000000;
}

div#pftedit{
	display: none;
	margin: 0px 20px 0px 20px;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000000;
}

div#configure{
	display: none;
	margin: 0px 20px 0px 20px;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000000;
}
</style>
<script languaje=javascript>

TipoFormato=""
C_Tag=Array()
var strValidChars = "0123456789$";


function AbrirVentana(Archivo){
	xDir=""
	msgwin=window.open(xDir+"ayudas/"+Archivo,"Ayuda","menu=no, resizable,scrollbars")
	msgwin.focus()
}

function EsconderVentana( whichLayer ){
var elem, vis;
	if( document.getElementById ) // this is the way the standards work
		elem = document.getElementById( whichLayer );
	else if( document.all ) // this is the way old msie versions work
		elem = document.all[whichLayer];
	else if( document.layers ) // this is the way nn4 works
		elem = document.layers[whichLayer];
	vis = elem.style;
	// if the style.display value is blank we try to figure it out here
	if( vis.display == '' && elem.offsetWidth != undefined && elem.offsetHeight != undefined )
		vis.display = 'none';
	vis.display =  'none';
}

function toggleLayer( whichLayer ){
	var elem, vis;

	switch (whichLayer){
        case "useextproc":
            EsconderVentana("useextable")
			EsconderVentana("createtable")
			break
		case "useextable":
            EsconderVentana("useextproc")
			EsconderVentana("createtable")
			break
		case "createtable":
            EsconderVentana("useextproc")
            EsconderVentana("useextable")
			break
	}
	if( document.getElementById ) // this is the way the standards work
		elem = document.getElementById( whichLayer );
	else if( document.all ) // this is the way old msie versions work
		elem = document.all[whichLayer];
	else if( document.layers ) // this is the way nn4 works
		elem = document.layers[whichLayer];
	vis = elem.style;
	// if the style.display value is blank we try to figure it out here
	if( vis.display == '' && elem.offsetWidth != undefined && elem.offsetHeight != undefined )
		vis.display = ( elem.offsetWidth != 0 && elem.offsetHeight != 0 ) ? 'block':'none';
	vis.display = ( vis.display == '' || vis.display == 'block' ) ? 'none':'block';
}
function IsNumeric(data){

   	//  test strString consists of valid characters listed above
   	for (i = 0; i < data.length; i++){
    	strChar = data.charAt(i);
    	if (strValidChars.indexOf(strChar) == -1){
    		return false

    	}
    }
    return true
}

function BorrarExpresion(){
	document.forma1.Expresion.value=''
}

function EnviarForma(Desde){
	switch (Desde){
		case 1:
			break
		case 2:
			de=Trim(document.forma1.Mfn.value)
  			a=Trim(document.forma1.to.value)
  			Se=""
			blnResult=true
   	//  test strString consists of valid characters listed above
   			for (i = 0; i < de.length; i++){
    			strChar = de.charAt(i);
    			if (strValidChars.indexOf(strChar) == -1){
    				alert("<?php echo $msgstr["inv_mfn"]?>")
	    			return
    			}
    		}
    		for (i = 0; i < a.length; i++){
    			strChar = a.charAt(i);
    			if (strValidChars.indexOf(strChar) == -1){
    				alert("<?php echo $msgstr["inv_mfn"]?>")
	    			return
    			}
    		}
    		de=Number(de)
    		a=Number(a)
    		if (de<=0 || a<=0 || de>a ||a><?php echo $arrHttp["MAXMFN"]?>){
	    		alert("<?php echo $msgstr["inv_mfn"]?>")
	    		return
			}
			document.forma1.Opcion.value="MFN"
			break
		case 3:
			if (Trim(document.forma1.Expresion.value)==""){
				alert("<?php echo $msgstr["selreg"]?>")
				return
			}
			document.forma1.Opcion.value="BUSQUEDA"
			break
	}
    if (document.forma1.proc.selectedIndex<1 && document.forma1.tables.selectedIndex<1 && document.forma1.rows.selectedIndex<1 && document.forma1.cols.selectedIndex<1){
	  	alert("<?php echo $msgstr["seltab"]?>")
	  	return
	}
	i=0
	if (document.forma1.proc.selectedIndex>0 ){
		document.forma1.Accion.value="Procesos"
		i=i+1
	}
	if (document.forma1.tables.selectedIndex>0 ){
		document.forma1.Accion.value="Tablas"
		i=i+1
	}
    if ( document.forma1.rows.selectedIndex>0 || document.forma1.cols.selectedIndex>0){
    	document.forma1.Accion.value="Variables"
    	i=i+1
    }
    if (i>1){
    	alert("<?php echo $msgstr["seltab"]?>")
	  	return
    }
	document.forma1.submit();
}

function Buscar(){
	base=document.forma1.base.value
	cipar=document.forma1.cipar.value
  	Url="../dataentry/buscar.php?Opcion=formab&Target=s&Tabla=Expresion&base="+base+"&cipar="+cipar
  	msgwin=window.open(Url,"Buscar","menu=no, resizable,scrollbars,width=750,height=400")
	msgwin.focus()
}

function Configure(Option){
	if (document.configure.base.value==""){
		alert("<?php echo $msgstr["seldb"]?>")
		return
	}
	switch (Option){
		case "stats_gen":
			document.configure.action="stats_gen_cfg.php"
			break
		case "stats_var":
			document.configure.action="config_vars.php"
			break
		case "stats_tab":
			document.configure.action="tables_cfg.php"
			break
		case "stats_proc":
			document.configure.action="proc_cfg.php"
			break
		case "stats_pft":
			document.configure.action="config_tables.php"
			break
	}
	document.configure.submit()
}
</script>
<?php
if (isset($arrHttp["encabezado"])){
	include("../common/institutional_info.php");
	$encabezado="&encabezado=s";
}
?>
<div class="sectionInfo">
	<div class="breadcrumb">
    <?php echo $msgstr["stats"].": ".$arrHttp["base"]?>
	</div>

	<div class="actions">
    <?php
    if (isset($arrHttp["encabezado"])){
        include "../common/inc_back.php";
    }
    ?>
    </div>
    <div class="spacer">&#160;</div>
</div>
<?php
include "../common/inc_div-helper.php";
?>

<div class="middle form">
<div class="formContent">
<table class=listTable>
    <tr>
	<td style="text-align:center">
		<?php echo "<strong>".$msgstr["stats"].": ".$arrHttp["base"]."</strong>";?>
   </td>
   </tr>
</table>

<form name=forma1 method=post action=tables_generate_ex.php onsubmit="Javascript:return false">
<?php if (isset($arrHttp["encabezado"])) echo "<input type=hidden name=encabezado value=s>\n";?>
<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
<input type=hidden name=cipar value=<?php echo $arrHttp["base"]?>.par>
<input type=hidden name=Opcion>
<input type=hidden name=Accion>

<!-- USAR UN PROCESO PRE-DEFINIDO/ USE PROCESS -->

&nbsp; <A HREF="javascript:toggleLayer('useextproc')"> <strong><?php echo $msgstr["exist_proc"];?></strong></a>
<div id=useextproc><br>
    <select name=proc  style="width:300px">
        <option value=''>
        <?php
        unset($fp);
        $file=$db_path.$arrHttp["base"]."/def/".$lang."/proc.cfg";
        if (!file_exists($file)) $file=$db_path.$arrHttp["base"]."/def/".$lang_db."/proc.cfg";
        if (!file_exists($file)){
            $error="S";
        }else{
            $fp=file($file);
            $fields="";
            foreach ($fp as $value) {
                $value=trim($value);
                if ($value!=""){
                    $t=explode('||',$value);
                    echo "<option value=".urlencode($value).">".trim($t[0])."</option>";
                }
            }
        }
        ?>
    </select>
</div>
<p>
<!-- USAR UNA TABLA YA EXISTENTE / USE EXISTING TABLE -->
&nbsp; <A HREF="javascript:toggleLayer('useextable')"> <strong><?php echo $msgstr["exist_tb"];?></strong></a>
<div id=useextable>
    <select name=tables  style="width:300">
        <option value=''>
        <?php
        unset($fp);
        $file=$db_path.$arrHttp["base"]."/def/".$lang."/tabs.cfg";
        if (!file_exists($file)) $file=$db_path.$arrHttp["base"]."/def/".$lang_db."/tabs.cfg";
        if (!file_exists($file)){
            $error="S";
        }else{
            $fp=file($file);
            $fields="";
            foreach ($fp as $value) {
                $value=trim($value);
                if ($value!=""){
                    $t=explode('|',$value);
                    echo "<option value=".urlencode($value).">".trim($t[0])."</option>";
                }
            }
        }
        $file=$db_path.$arrHttp["base"]."/def/".$lang."/tables.cfg";
        if (!file_exists($file)) $file=$db_path.$arrHttp["base"]."/def/".$lang_db."/tables.cfg";
        if (!file_exists($file)){
            $error="S";
        }else{
            $fp=file($file);
            $fields="";
            foreach ($fp as $value) {
                $value=trim($value);
                if ($value!=""){
                    $t=explode('|',$value);
                    echo "<option value=\"".$value.'{{PFT'."\">".trim($t[0])."</option>";
                }
            }
        }
        ?>
    </select>
</div>
<p>
<!-- CONSTRUIR UNA TABLA SELECCIONANDO FILAS Y COLUMNAS / CREATE TABLE -->
&nbsp; <A HREF="javascript:toggleLayer('createtable')"><strong><?php echo $msgstr["create_tb"]?></strong></a>
<div id=createtable>
<table>
    <tr>
    <td>
        <strong><?php echo $msgstr["rows"]?></strong><br>
        <Select name=rows style="width:250px">
        <option value=""></option>
        <?php
        unset($fp);
        $file=$db_path.$arrHttp["base"]."/def/".$lang."/stat.cfg";
        if (!file_exists($file)) $file=$db_path.$arrHttp["base"]."/def/".$lang_db."/stat.cfg";
        if (!file_exists($file)){
            $error="S";
        }else{
            $fp=file($file);
            foreach ($fp as $value) {
                $value=trim($value);
                if ($value!=""){
                    $t=explode('|',$value);
                    echo "<option value=".urlencode($value).">".trim($t[0])."</option>";
                }
            }
        }
        ?>
        </select>
    </td>
    <td>
        <strong><?php echo $msgstr["cols"]?></strong><br>
        <Select name=cols style="width:250px">
        <option value=""></option>
        <?php
            foreach ($fp as $value) {
                $value=trim($value);
                if ($value!=""){
                    $t=explode('|',$value);
                    echo "<option value=\"".$value."\">".trim($t[0])."</option>";
                }
            }
        ?>
        </select>
    </td>
    </tr>
</table>
</div>
<p>
<!-- SELECCION DE LOS REGISTROS  / RECORD SELECTION-->
&nbsp; <A HREF="javascript:toggleLayer('generate')"><strong><?php echo $msgstr["r_recsel"]?></strong></a>
<div id=generate><p>
    <table>
        <tr> <!-- row 1 record selection by MFN range -->
        <td><?php echo $msgstr["r_recsel"]?><br>
            <b><?php echo $msgstr["r_mfnr"]?></b>
        </td>
        <td>
            <?php echo $msgstr["r_desde"]?>: <input type=text name=Mfn size=10>&nbsp; &nbsp; &nbsp; &nbsp;
            <?php echo $msgstr["r_hasta"]?>: <input type=text name=to size=10>
            &nbsp;<?php echo $msgstr["maxmfn"]?>:&nbsp;<?php echo $arrHttp["MAXMFN"] ?>
            &nbsp; &nbsp; 
            <button class="bt-blue" type="button"
                title="<?php echo $msgstr["send"]?>" onclick='EnviarForma(2)'>
                <i class="fa fa-step-forward"></i> <?php echo $msgstr["send"]?></button>
        </td>
        </tr>
        <tr><td></td><td><hr class="color-gray-100"><br></td></tr>
        
        <tr> <!-- row 2 record selection by Search -->
        <td><?php echo $msgstr["r_recsel"]?><br>
            <b><?php echo $msgstr["r_busqueda"]?></b>
        </td>
        <td>
        <table>
            <tr><td colspan=2>
                <?php // proces a possible search expression table
                unset($fp);
                if (file_exists($db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/search_expr.tab"))
                    $fp = file($db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/search_expr.tab");
                else
                    if (file_exists($db_path.$arrHttp["base"]."/pfts/".$lang_db."/search_expr.tab"))
                        $fp = file($db_path.$arrHttp["base"]."/pfts/".$lang_db."/search_expr.tab");
                if (isset($fp)){
                    ?>
                    <?php echo $msgstr["copysearch"]?> :&nbsp;
                    <select name=Expr  onChange=CopiarExpresion()>
                        <option value=''>
                        <?php
                        foreach ($fp as $value){
                            $value=trim($value);
                            if ($value!=""){
                                $pp=explode('|',$value);
                                ?>
                                <option value='<?php echo $pp[1]?>'><?php echo $pp[0]?></option>
                                <?php
                            }
                        }
                        ?>
                    </select> &nbsp; &nbsp;
                    <?php
                }
                ?>
                <button class="bt-green" type="button"
                    title="<?php echo $msgstr["pftcreatesrcexpr"]?>"
                    onclick='javascript:Buscar()'>
                    <i class="far fa-plus-square"></i> <?php echo $msgstr["pftcreatesrcexpr"]?></button>
                </td>
            </tr>
            <tr><td>
                <textarea rows=2 cols=100 name=Expresion><?php if (isset($Expresion)) echo $Expresion?></textarea>
            </td>
            <td> &nbsp;
                <button class="bt-blue" type="button"
                    title="<?php echo $msgstr["send"]?>" onclick='javascript:EnviarForma(3)'>
                    <i class="fa fa-step-forward"></i> <?php echo $msgstr["send"]?></button>
            </td>
            </tr>
            <?php
            if (isset($_SESSION["permiso"]["CENTRAL_ALL"]) or
                isset($_SESSION["permiso"]["CENTRAL_SAVEXPR"])  or
                isset($_SESSION["permiso"][$arrHttp["base"]."_CENTRAL_ALL"]) or
                isset($_SESSION["permiso"][$arrHttp["base"]."_CENTRAL_SAVEXPR"])){
                ?>
                <tr><td>
                    <button class="bt-green" type="button"
                        title="<?php echo $msgstr["savesearch"]?>"
                        onclick="javascript:GuardarBusqueda()">
                        <i class="far fa-save"></i> <?php echo $msgstr["savesearch"]?></button>
                    <?php echo $msgstr["r_desc"].": " ?>
                    <input type=text name=Descripcion size=40>
                </td>
                <?php
            }
            ?>
        </table>
        </td>
        </tr>
        <tr><td></td><td><hr class="color-gray-100"><br></td></tr>
    </table>
</div>
</form>

<?php
if (isset($_SESSION["permiso"]["CENTRAL_STATCONF"]) or isset($_SESSION["permiso"]["CENTRAL_ALL"])){
    ?>
    <hr>
    &nbsp; <a href="javascript:toggleLayer('configure')"> <strong><?php echo $msgstr["stats_conf"]?></strong></a>
    <div id=configure>
    <ul>
        <li><a href='javascript:Configure("stats_var")'><?php echo $msgstr["var_list"]?></a></li>
        <li><a href='javascript:Configure("stats_pft")'><?php echo $msgstr["def_pre_tabs"]?></a></li>
        <li><a href='javascript:Configure("stats_tab")'><?php echo $msgstr["tab_list"]?></a></li>
        <li><a href='javascript:Configure("stats_proc")'><?php echo $msgstr["exist_proc"]?></a></li>
        <!--<li><a href='javascript:Configure("stats_gen")'><?php echo $msgstr["stats_gen"]?></a><p></li>-->
    </ul>
    </div>
<?php } ?>

</div>
</div>
<form name=configure onSubmit="return false">
	<input type=hidden name=Opcion value=update>
	<input type=hidden name=from value="statistics">
	<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
	<?php if (isset($arrHttp["encabezado"])) echo "<input type=hidden name=encabezado value=s>";?>
</form>
<?php
include("../common/footer.php");
?>
