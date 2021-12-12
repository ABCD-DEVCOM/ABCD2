<?php
/*
20211209 fho4abcd Rewrite, echos-> script. improve layout & html
20211212 fho4abcd Add TOP button + keep pref if db is switched + add breadcrumb to help the db manager+resolve script errors
*/
/*
** Functionality:
** - Search function: Show a list of search terms, sorted form A-Z
** - Copy from another database: Show a list of databases and show a list of search terms, sorted from A-Z
*/
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
session_start();
if (!isset($_SESSION["permiso"])){
    header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include("../config.php");
include ("../lang/admin.php");
include ("../lang/dbadmin.php");
include ("leerregistroisispft.php");

// ------------------------------------------------------
// INICIO DEL PROGRAMA
// ------------------------------------------------------

include("../common/header.php");
//foreach ($arrHttp as $var => $value)     echo "$var = $value<br>";
?>
<body onblur=self.close()>
<?php
/*
** Read the FDT
** Some calls do not supply correct parameters: check first
*/
if (!isset($arrHttp["base"]) OR $arrHttp["base"]=="" ) {
    echo "<div style='color:red'>ERROR: base is not set. Dump of all url parameters:<br>";
    var_dump($arrHttp);
    echo "<br>-</div>";die;
}
if (file_exists($db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$arrHttp["base"].".fdt"))
    $fp=file($db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$arrHttp["base"].".fdt");
else
    $fp=file($db_path.$arrHttp["base"]."/def/".$lang_db."/".$arrHttp["base"].".fdt");
foreach($fp as $value) {
    $f=explode('|',$value);
    if ($f[3]==1){
        if (substr($f[13],0,1)!="@")
            if (trim($f[13])!="")    // si no se especificó el formato para extraer la entrada principal se toma el tag del campo
                $arrHttp["formato_e"]=$f[13]."'$$$'f(mfn,1,0)";
            else
                $arrHttp["formato_e"]="mhl,v".$f[1]."'$$$'f(mfn,1,0)";
        else
            $arrHttp["formato_e"]=$f[13];
    }
}

$arrHttp["formato_e"]=stripslashes($arrHttp["formato_e"]);
if (!isset($arrHttp["tagfst"])) $arrHttp["tagfst"]="";
if (!isset($arrHttp["delimitador"]))$arrHttp["delimitador"]="";
if (!isset($arrHttp["Tag"]))$arrHttp["Tag"]="";
if (!isset($arrHttp["prefijo"]))$arrHttp["prefijo"]="";
if (!isset($arrHttp["capturar"]))$arrHttp["capturar"]="";
if (!isset($arrHttp["pref"]))$arrHttp["pref"]=$arrHttp["prefijo"];

$IsisScript=$xWxis."ifp.xis";
if (substr($arrHttp["formato_e"],0,1)=="@"){
    $Formato=$db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/".substr($arrHttp["formato_e"],1);
    if (!file_exists($Formato)) $Formato=$db_path.$arrHttp["base"]."/pfts/".$lang_db."/".substr($arrHttp["formato_e"],1);
    $Formato="@".$Formato;
}else{
    $Formato=$arrHttp["formato_e"];
}
$query ="&base=".$arrHttp["base"] ."&cipar=$db_path"."par/".$arrHttp["cipar"]."&Opcion=autoridades"."&tagfst=".$arrHttp["tagfst"]."&prefijo=".urlencode($arrHttp["prefijo"])."&pref=".$arrHttp["pref"]."&formato_e=".urlencode($Formato)."&bymfn=S";
//echo $query;
include("../common/wxis_llamar.php");
$contenido = array_unique ($contenido);
//foreach ($contenido as $var=>$value) echo "$var=$value<br>";

?>
<script language=Javascript>
document.onkeypress =
    function (evt) {
        var c = document.layers ? evt.which
            : document.all ? event.keyCode
            : evt.keyCode;
        return true;
}
var nav4 = window.Event ? true : false;

function codes(e) {
    if (nav4) // Navigator 4.0x
        var whichCode = e.which

    else // Internet Explorer 4.0x
        if (e.type == 'keypress') // the user entered a character
             var whichCode = e.keyCode
        else
            var whichCode = e.button;
    if (e.type == 'keypress' && whichCode==13)
        IrA()
    else
        if (whichCode==13) IrA()
}
Separa="<?php echo $arrHttp["delimitador"]?>"
Tag="<?php echo $arrHttp["Tag"]?>"
Prefijo="<?php echo $arrHttp["prefijo"]?>"
cnv="N"
bsel="N"
<?php
if (isset($arrHttp["cnvtab"]))
    echo "cnvtabsel=\"&cnvtabsel".$arrHttp["prefijo"]."\"\n";
else
    echo "cnvtabsel=\"\"\n";
?>
function CambiarBase(){
    //Change Base
    tl=""
    nr=""
    i=document.Lista.baseSel.selectedIndex
    if (i==-1) i=0
    abd=document.Lista.baseSel.options[i].value
    if (i==-1 || i==0){
        return
    }
    a=abd.split("|")
    basecap=a[0]
    ciparcap=basecap+".par"
    <?php $arrHttp["formato_e"]=str_replace('"','|',$arrHttp["formato_e"])?>
    formato_ix="<?php echo stripslashes($arrHttp["formato_e"])?>"
    Prefijo="&prefijo=<?php echo $arrHttp["pref"]?>"+"&formato_e="+ formato_ix
    if (top.frames.length>0){
        parent.indice.location.href="alfa.php?base="+basecap+"&cipar="+ciparcap+Prefijo+"&Opcion=autoridades&capturar=S&bymfn=S"
    }else{
        parent.indice.location.href="alfa.php?base="+basecap+"&ciparcap="+cipar+Prefijo+"&Opcion=autoridades&capturar=S&bymfn=S"

    }
}
function ObtenerTerminos(){
    //conversion table
    if (cnv=="S"){
        if (document.Lista.cnvtab.selectedIndex>0){
            cnvtabsel="&cnvtabsel="+document.Lista.cnvtab.options[document.Lista.cnvtab.selectedIndex].value
        }else{
            cnvtabsel=""
        }
    }else{
        cnvtabsel=""
    }
    basecap=""
    if (bsel=="S"){
        if (document.Lista.baseSel.selectedIndex>0){
            basecap=document.Lista.baseSel.options[document.Lista.baseSel.selectedIndex].value
        }
        top.basecap=basecap
        top.ciparcap=basecap+".par"
        top.cnvtabsel=cnvtabsel
    }else{
        basecap="<?php echo $arrHttp["base"]?>"
    }
    Seleccion=""
    icuenta=0
    i=document.Lista.autoridades.selectedIndex
    for (i=0;i<document.Lista.autoridades.options.length; i++){
        if (document.Lista.autoridades.options[i].selected){
            icuenta=icuenta+1
            if (Seleccion=="")
                Seleccion=document.Lista.autoridades.options[i].value
            else
                Seleccion=Seleccion+Separa+document.Lista.autoridades.options[i].value
        }

    }
    db="<?php echo $arrHttp["base"]?>"

    if (Seleccion!=""){
        if (bsel=="S"){
            if (top.NombreBaseCopiara=="")
                db="<?php echo $arrHttp["base"]?>"
            else
                db=top.NombreBaseCopiara
        }
        pref="<?php echo $arrHttp["pref"]?>"
        cipar="<?php echo $arrHttp["cipar"]?>"
        <?php
        if (isset($arrHttp["capturar"]) and $arrHttp["capturar"]!=""){
            echo "top.xeditar=\"S\"\n";

            echo 'parent.main.location="fmt.php?xx=xx&base="+db+"&cipar="+db+".par&basecap="+basecap+"&ciparcap="+basecap+".par&Mfn="+Seleccion+"&Opcion=captura_bd&ver=S&capturar=S"+cnvtabsel+"&Formato="+basecap'."\n";
        }else{
            if (isset($arrHttp["Formato"]))
                echo "Formato='&Formato=".$arrHttp["Formato"]."'\n";
            else
                echo "Formato=''\n";
            echo 'window.opener.top.main.location.href="fmt.php?cc=xx&base="+db+"&cipar="+cipar+"&Mfn="+Seleccion+"&Opcion=ver&ver=S&Formato="+Formato+cnvtabsel
            window.opener.focus()'."\n";
        }
        ?>
    }
}

function Continuar(){
    i=document.Lista.autoridades.length
    a=' '
    if (i>1) {
        i--
        a=document.Lista.autoridades[i].text
    }
    AbrirIndice(a)
}

function IrA(ixj){
    a=document.Lista.ira.value
    AbrirIndice(a)
}

function AbrirIndice(Termino){
    <?php
    if (isset($arrHttp["Formato"])) {
    ?>
    Formato='<?php echo urlencode($arrHttp["Formato"])?>'
    <?php } else { ?>
    Formato=''
    <?php } ?>
    db='<?php echo $arrHttp["base"]?>'
    cipar='<?php echo $arrHttp["cipar"]?>'
    Pref='<?php echo $arrHttp["pref"]?>'
    Prefijo=Pref+Termino
    capturar='<?php echo $arrHttp["capturar"]?>'

    if (capturar!='') capturar='&capturar='+capturar
    if (cnv=="S"){
        if (document.Lista.cnvtab.selectedIndex>0){
            cnvtabsel="&cnvtabsel="+document.Lista.cnvtab.options[document.Lista.cnvtab.selectedIndex].value
        }else{
            cnvtabsel=""
        }
    }
    URL='alfa.php?&opcion=autoridades&base='+db+'&cipar='+cipar+'&pref='+Pref+'&prefijo='+Prefijo+capturar+'&formato_e=<?php echo urlencode($arrHttp["formato_e"])?>'+cnvtabsel
    if (Formato!=""){
        URL+='&Formato='+Formato
    }
    self.location.href=URL
}
</script>
<div class="sectionInfo">
    <div class="breadcrumb">
        <?php echo $msgstr["indicede"].": ".urldecode($arrHttp["pref"])?>
    </div>
    <div class="actions">
    </div>
<div class="spacer">&#160;</div>
</div>
<?php
include "../common/inc_div-helper.php";
?>
<div class="middle form">
<div class="formContent">
<form method=post name=Lista onSubmit="javascript:return false">
<?php
// si viene de la opción de capturar de otra base de datos se presenta la lista de bases de datos disponibles
// if it comes from the option to capture from another database, the list of available databases is displayed
if (isset($arrHttp["capturar"]) and $arrHttp["capturar"]=="S"){
    $key_bd="";
    if (isset($arrHttp["base"])) $key_bd=$arrHttp["base"];
    $prefijo="";
    if (isset($arrHttp["prefijo"])) $prefijo=$arrHttp["prefijo"];
    if (!isset($arrHttp["Mfn"])) $arrHttp["Mfn"]="";
    $fp = file($db_path."bases.dat");
    foreach ($fp as $linea){
        if (trim($linea)!="") {
            $ix=strpos($linea,"|");
            $llave=trim(substr($linea,0,$ix));
            if ($llave!="acces")
                $lista_bases[$llave]=$linea;
        }
    }
    ?>
    <script>bsel="S"</script>
    &nbsp;
    <table  cellspacing=0 cellpadding=0 border=0  >
    <tr>
        <td><?php echo $msgstr["database"]?></td>
        <td>
            <select name=baseSel onChange=CambiarBase() style=width:150px>
            <option value="">
            <?php
            $i=-1;
            foreach ($lista_bases as $key => $value) {
                $i=$i+1;
                $v=explode('|',$value);
                if (isset($_SESSION["permiso"]["db_".$key]) or isset($_SESSION["permiso"]["db_ALL"]) or isset($_SESSION["permiso"]["CENTRAL_ALL"])  or isset($_SESSION["permiso"][$key."_CENTRAL_ALL"])){
                    if ($v[0]==$arrHttp["base"])
                        $sel="selected";
                    else
                        $sel="";
                    echo "<option value=\"".$key."\" $sel >".trim($v[1]);
                }
            }
            ?>
            </select>
        </td>
        <td>
        <a href='../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/ayuda_captura.html' target=_blank><?php echo $msgstr["help"]?></a>
        <?php
        if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"])) {
            ?>
            <br>
            <a href='../documentacion/edit.php?archivo=".$_SESSION["lang"]."/ayuda_captura.html' target=_blank><?php echo $msgstr["edhlp"]?></a>
            <?php
        }
        ?>
        </td>
    </tr>
    <?php
    // read conversion tables
    $archivo=$db_path."/cnv/z3950.cnv";
    if (file_exists($archivo)){
        $fp=file($archivo);
        ?>
        <tr>
            <td>
                <script>cnv="S"</script>
                <?php echo $msgstr["z3950_tab"]?>
            </td><td>
                <select name=cnvtab style=width:150px>
                <option></option>
                <?php
                foreach ($fp as $value){
                    $v=explode('|',$value);
                    $xsel="";
                    if (isset($arrHttp["cnvtabsel"])){
                        if ($v[0]==$arrHttp["cnvtabsel"]) $xsel=" selected";
                    }
                    echo "<option value='".$v[0]."' $xsel title='".$v[1]."' alt='".$v[1]."'>".$v[1]."\n";
                }
                ?>
            </select>
            </td>
        </tr>
    <?php } ?>
    </table>
<?php
}
if (isset($arrHttp["capturar"]) and $arrHttp["capturar"]=="S")
    $xwidth="330";
else
    $xwidth="570";
?>
<table cellpadding=0 cellspacing=0 border=0  height=80%>
<tr>

<td  width=5% align=center><font size=1 face="verdana"><?php for ($i=65;$i<91;$i++ ) echo "<a href=\"javascript:AbrirIndice('".chr($i)."')\">".chr($i)."</a><br>"?></td>
<td width=95% valign=top>
<select name=autoridades size=28 style="width:<?php echo $xwidth?>px; height:400px" onchange=ObtenerTerminos()>
<?php
foreach ($contenido as $linea){
    if (trim($linea)!=""){
        $f=explode('$$$',$linea);
        echo "<option value=".$f[1]." title='".str_replace("'","&apos;",$f[0])."'>".$f[0]."</option>\n";
    }
}
?>
</select></td>

</tr>
<tr>
    <td colspan=2><!--full width required to avoid wrap in all languages-->
        <a href="javascript:AbrirIndice(' ')" class="bt bt-gray" title='<?php echo $msgstr["src_top"]?>'>
             <i class="fas fa-chevron-circle-up"></i> 
        </a>
        <a href="javascript:Continuar()" class="bt bt-gray" title='<?php echo $msgstr["masterms"]?>'>
             <i class="fas fa-chevron-circle-down"></i>
        </a>
        &nbsp;
        <?php echo $msgstr["avanzara"]?>
        <input type=text name=ira size=5 value="" onKeyPress="codes(event)" title="<?php echo $msgstr["src_advance"];?>">
        <a href=Javascript:IrA() class="bt bt-gray" title='<?php echo $msgstr["src_enter"]?>'>
            <i class="fas fa-arrow-alt-circle-right"></i></a>
    </td>
</tr>
</table>
</form>
</div>
</div>
</body>
</html>
