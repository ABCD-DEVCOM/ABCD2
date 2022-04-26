<?php
/*
2021-08-30 fho4abcd Restored from accidental delete
2021-08-30 fho4abcd Added some description, inserted div-helper
2021-08-30 fho4abcd Cleanup html, lineends, resolved undefined variable tag_s
2022-01-11 rogercgui add new backbutton
2022-01-12 fho4abcd Removed nested tables and unused code&copcions+test in pop-up
2022-04-25 rogercgui Add encabezado in forma1
**
** Do not get confused by a file with the same name in central/dataentry.
** This file is to create and modify worksheets (with the extension .fmt)
*/
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
global  $arrHttp;

// ==================================================================================================
// INICIO DEL PROGRAMA
// ==================================================================================================

//
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include("../config.php");
$lang=$_SESSION["lang"];
include("../lang/admin.php");
include("../lang/dbadmin.php");
$base =$arrHttp["base"];
$cipar =$arrHttp["base"].".par";

//foreach ($arrHttp as $key => $value) echo "$key = $value <br>";
// se lee el archivo mm.fdt
$archivo=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$arrHttp["base"].".fdt";
if (file_exists($archivo))
	$fpTm=file($archivo);
else
	$fpTm=file($db_path.$arrHttp["base"]."/def/".$lang_db."/".$arrHttp["base"].".fdt");
foreach ($fpTm as $linea){
	if (trim($linea)!="") {
		$Fdt[]=$linea;
	}
}
//sort($Fdt);
if (isset($arrHttp["fmt_name"])) {
	if (file_exists($db_path.$base."/def/".$_SESSION["lang"]."/".$arrHttp["fmt_name"].".fmt"))
    	$fp = file($db_path.$base."/def/".$_SESSION["lang"]."/".$arrHttp["fmt_name"].".fmt");
    else
		$fp = file($db_path.$base."/def/".$lang_db."/".$arrHttp["fmt_name"].".fmt");
	$arrHttp["tagsel"]="";
	foreach($fp as $linea){
		if (trim($linea)!=""){
			$t=explode('|',$linea);
			$tag_s[trim($t[1])]=trim($linea);
		}
	}
}
include("../common/header.php");

?>
<body>

<script language="JavaScript" type="text/javascript" src="../dataentry/js/lr_trim.js"></script>
<script language="JavaScript" type="text/javascript" src="../dataentry/js/selectbox.js"></script>
<script language="JavaScript">

function Genera_Fmt(){
  	formato=""
  	for (i=0;i<document.forma1.list21.options.length;i++){
	    campo=document.forma1.list21.options[i].value
	    if (document.forma1.link_fdt.checked){
	    	c=campo.split('|')
	    	tipo=campo[0]
	    	if (tipo=='H' || tipo=='L' || tipo=='S'){

	    	}else{
	    		c[18]=1
	    		campo=""
	    		for (j=0;j<c.length;j++){
	    			campo+= c[j]
	    			if (j!=c.length-1)
	    				campo+="|"
	    		}
	    	}
	  	}
	    formato+=campo+"\n"
	}
    return formato
}

function Preview(){
	formato=Genera_Fmt()
	if (formato=="" ){
	  	alert("<?php echo $msgstr["selfieldsfmt"]?>")
	  	return
	}
    msgwin=window.open("","Previewpop","status=yes,resizable=yes,toolbar=no,menu=no,scrollbars=yes,height=400,width=1000")
    msgwin.focus()
	document.preview.fmt.value=escape(formato)
	document.preview.submit()
}

function GenerarFormato(){
	formato=Genera_Fmt()
	if (formato=="" ){
	  	alert("<?php echo $msgstr["selfieldsfmt"]?>")
	  	return
	}
	document.forma1.wks.value=formato
	if (Trim(document.forma1.nombre.value)==""){
		alert("<?php echo $msgstr["fmtmisname"]?>")
		return
	}
	if (Trim(document.forma1.descripcion.value)==""){
		alert("<?php echo $msgstr["fmtmisdes"]?>")
		return
	}
	fn=document.forma1.nombre.value
	bool=  /^[a-z][\w]+$/i.test(fn)
 	if (bool){

   	}
   	else {
      	alert("<?php echo $msgstr["errfilename"]?>");
      	return
   	}
	document.forma1.submit()
}
function EditarFormato(){
	if (document.forma1.fmt.selectedIndex==0 || document.forma1.fmt.selectedIndex==-1){
		alert("<?php echo $msgstr["fmtplsselect"]?>")
		return
	}
	ix=document.forma1.fmt.selectedIndex
	fmt=document.forma1.fmt.options[ix].value
	fmt=fmt.split('|')
    document.forma1.fmt_name.value=fmt[0]
    document.forma1.fmt_desc.value=document.forma1.fmt.options[ix].text
    document.forma1.action="fdt.php"
    document.forma1.submit()
}

function CopiarFormato(){
	if (document.forma1.fmt.selectedIndex==0 || document.forma1.fmt.selectedIndex==-1){
		alert("<?php echo $msgstr["fmtplsselect"]?>")
		return
	}
	ix=document.forma1.fmt.selectedIndex
	fmt=document.forma1.fmt.options[ix].value
	fmt=fmt.split('|')
    document.forma1.fmt_name.value=fmt[0]
    document.forma1.fmt_desc.value=document.forma1.fmt.options[ix].text
    document.forma1.action="fmt_saveas.php"
    document.forma1.submit()
}

function EliminarFormato(){
	if (document.forma1.fmt.selectedIndex==0 || document.forma1.fmt.selectedIndex==-1){
		alert("<?php echo $msgstr["fmtplsselect"]?>")
		return
	}
	ix=document.forma1.fmt.selectedIndex
	fmt=document.forma1.fmt.options[ix].value
	fmt=fmt.split('|')
    document.frmdelete.fmt.value=fmt[0]
    document.frmdelete.path.value="def"
    document.frmdelete.submit()
}
</script>
<?php
include("../common/institutional_info.php");
?>
<div class="sectionInfo">
    <div class="breadcrumb">
    <?php echo $msgstr["credfmt"].": ".$arrHttp["base"]?>
    </div>
    <div class="actions">
    <?php
    include "../common/inc_back.php";
    include "../common/inc_home.php";
    ?>
	</div>
    <div class="spacer">&#160;</div>
</div>

<?php
include "../common/inc_div-helper.php";
?>
<div class="middle form">
<div class="formContent">
<form name=forma1 method=post action=fmt_update.php onsubmit="Javascript:return false" >
<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
<input type=hidden name=cipar value="<?php if (isset($arrHttp["cipar"])) echo $arrHttp["cipar"]?>">
<input type=hidden name=tagsel>
<input type=hidden name=wks>
<input type=hidden name=fmt_name>
<input type=hidden name=fmt_desc>
<input type=hidden name=ret_script value=fmt_adm.php>

<?php if (isset($arrHttp["encabezado"])) echo "<input type=hidden name=encabezado value=s>";?>

<table style="margin-left:auto;margin-right:auto">
    <tr>
    <td>
    <?php echo $msgstr["selfmt"]?></td>
    <td>
    <select name=fmt>
        <option value=""></option>
        <?php
        unset($fp);
        $archivo=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/"."formatos.wks";

        if (!file_exists($archivo)) $archivo = $db_path.$arrHttp["base"]."/def/".$lang_db."/"."formatos.wks";
        if (file_exists($archivo)){
            $fp=file($archivo);
            if (isset($fp)) {
                foreach($fp as $linea){
                    //echo "***$linea<br>";
                    if (trim($linea)!="") {
                        $linea=trim($linea);
                        $l=explode('|',$linea);
                        $cod=trim($l[0]);
                        $nom=trim($l[1]);
                        $oper="|";
                        if (isset($l[2])) $oper.=$l[2];
                        echo "<option value='$cod$oper'>$nom</option>\n";
                    }
                }

            }
        }
        ?>
    </select>
    <a href="javascript:EditarFormato()"><?php echo $msgstr["edit"]?></a> | 
    <a href="javascript:EliminarFormato()"><?php echo $msgstr["delete"]?></a> | 
    <a href="javascript:CopiarFormato()"><?php echo $msgstr["saveas"]?></a>
    </td>
    </tr>
</table>
<table style="margin-left:auto;margin-right:auto">
    <tr><td colspan=4><hr></td></tr>
    <tr><td colspan=4><?php echo $msgstr["selfields"]?></td></tr>
    <tr><td> &nbsp; &nbsp;
        <select name=list11 style="width:250px" multiple size=20 onDblClick="moveSelectedOptions(this.form['list11'],this.form['list21'],false)">
            <?php  $t=array();
            foreach ($Fdt as $linea){
                $linea=trim($linea);
                $t=explode('|',$linea);
                if ($t[0]!="S"){
                    if ($t[0]=="H" or $t[0]=="L"){
                        if (!isset($tag_s[$linea])){
                            $t[1]=$t[0];
                            echo "<option value='".trim($linea)."'>".trim($t[2])." (".trim($t[1]).")\n";
                        }
                    }else{
                        $key=trim($t[1]);
                        if (!isset($tag_s[$key])){
                            echo "<option value='".trim($linea)."'>".trim($t[2])." (".trim($t[1]).")\n";
                        }else{
                            $seleccionados[$key]=$linea;
                        }
                    }
                }
            }
            ?>
        </select>
        </td>
        <td>
            <a class="button_browse show" href="#" onClick="moveSelectedOptions(document.forms[0]['list11'],document.forms[0]['list21'],false);return false;">
                <i class="fas fa-angle-right"></i>
            </a>
            <br><br>
            <a class="button_browse show" href="#" onClick="moveAllOptions(document.forms[0]['list11'],document.forms[0]['list21'],false); return false;">
                <i class="fas fa-angle-double-right"></i>
            </a>
            <br><br>
            <a class="button_browse show" href="#" onClick="moveAllOptions(document.forms[0]['list21'],document.forms[0]['list11'],false); return false;"><i class="fas fa-angle-double-left"></i>
            </a>
            <br><br>
            <a class="button_browse show" href="#" onClick="moveSelectedOptions(document.forms[0]['list21'],document.forms[0]['list11'],false); return false;">
                <i class="fas fa-angle-left"></i>
            </a>
        </td>
        <td>
            <select NAME="list21" MULTIPLE SIZE=20 style="width:250px" onDblClick="moveSelectedOptions(this.form['list21'],this.form['list11'],false)">
            <?php  $t=array();
            if (isset($tag_s) ) {
                foreach ($tag_s as $linea){

                    $key=trim($linea);
                    if (isset($seleccionados[$key])){
                        $t=explode('|',$seleccionados[$key]);
                        echo "<option value='".trim($seleccionados[$key])."'>".$t[2]." (".trim($t[1]).")\n";
                    }else{
                        $t=explode('|',$key);
                        if ($t[0]=="H" or $t[0]=="L") $t[1]=$t[0];
                        echo "<option value='".$key."'>".$t[2]." (".trim($t[1]).")\n";
                    }
                }
            }
            ?>
            </select>
        </td>
        <td>
            <button class="button_browse show" type="button" value="<?php echo $msgstr["up"]?>" title="<?php echo $msgstr['up']?>" onClick="moveOptionUp(this.form['list21'])"><i class="fas fa-caret-up"></i></button>
            <br><br>
            <button class="button_browse show" type="button" value="<?php echo $msgstr["down"]?>" title="<?php echo $msgstr["down"]?>" onClick="moveOptionDown(this.form['list21'])"><i class="fas fa-caret-down"></i></button>
            <br><br><br>
            <a href="javascript:Preview()" class="button_browse show" title=<?php echo $msgstr["preview"]?>>
                <i class="far fa-eye"></i>
            </a>
            <br><br>
        </td>
    </tr>
	<tr><td colspan=4><input type=checkbox name=link_fdt checked> <?php echo $msgstr["link_fdt_msg"]?></td></tr>
	<tr><td colspan=4><?php echo $msgstr["whendone"]?></td></tr>
	<tr><td colspan=4>
		<?php echo $msgstr["name"]?>: 
        <input type=text name=nombre size=8 maxlength=12> <?php echo $msgstr["description"]?>: 
        <input type=text size=50 maxlength=50 name=descripcion> &nbsp;
        <button class="button_browse edit" type="button" onclick="javascript:GenerarFormato()" title="<?php echo $msgstr["save"]?>">
            <i class="far fa-save"></i> </button>
		</td>
    </tr>
</table>
<script>
    <?php
    if ((isset($arrHttp["fmt_name"]))) {
        ?>
        document.forma1.nombre.value="<?php echo $arrHttp['fmt_name']?>"
        document.forma1.descripcion.value="<?php echo $arrHttp['fmt_desc']?>"
        <?php
    }
    ?>
</script>
</form>

<form name=preview action="fmt_test.php"  method=post target=Previewpop>
<input type=hidden name=base value="<?php echo $arrHttp["base"]?>">
<input type=hidden name=fmt>
</form>

<form name=frmdelete action="fmt_delete.php" method=post>
<input type=hidden name=base value="<?php echo $arrHttp["base"]?>">
<input type=hidden name=path>
<input type=hidden name=fmt>
</form>
<form name=assignto action="fmt_update.php">
<input type=hidden name=base value="<?php echo $arrHttp["base"]?>">
<input type=hidden name=path>
<input type=hidden name=sel_oper>
<input type=hidden name=fmt>
</form>
</div>
</div>
<?php include("../common/footer.php");?>


