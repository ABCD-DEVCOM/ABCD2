<?php
/* Modifications
20210312 fho4abcd show also charset if different from metaencoding
20210312 logout without [] to visually detect this script
20210415 fho4abcd Show db characterset if available, otherwise meta characterset. No longer show difference
20211220 rogercgui Moved script from dataentry to common
20211221 fho4abcd improved path to logout.php
20220119 fho4abcd add empty value in language menu to indicate to no language matches
20220122 rogercgui Default logo is displayed if institution image is absent
20220316 fho4abcd Replace undefined $Permiso by $_SESSION["permiso"] to ensure correct databases list
20220501 rogercgui Improved the language change option - in the core module the selected database was lost when the language was changed. add base = document.cambiolang.base.value;
20220613 fho4abcd Removed unused functions Modulo(gave errors) + ChangeLang + AbrirAyuda + rename Cambiarbase:avoid confusion with duplicates
    display language menu value in "best" characterset +
    remove BOM (Byte Order Mark) if present on first line of language file
20221122 rogercgui Removed $session_mfn_admin=="1" in line 181 because it displayed the list of bases in data entry only for MFN 1 of the Acces database
*/

global $ABCD_scripts_path;

include ("$ABCD_scripts_path/central/lang/admin.php");
include ("$ABCD_scripts_path/central/lang/lang.php");   

if (isset($_SESSION["nombre"])) {
    $name = $_SESSION["nombre"];
} else {
    $name = "";
}
if (isset($_SESSION["profile"])) {
    $profile = $_SESSION["profile"];
} else {
    $profile = "";
}
if (isset($_SESSION["login"])) {
    $login = $_SESSION["login"];
} else {
    $login = "";
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

function database_list() {
    global $lista_bases, $arrHttp, $def;
    $i=-1;
    foreach ($lista_bases as $key => $value) {
        $xselected="";
        $value=trim($value);
        $t=explode('|',$value);
        if (isset($_SESSION["permiso"]["db_".$key]) or isset($_SESSION["permiso"]["db_ALL"]) or isset($_SESSION["permiso"]["CENTRAL_ALL"])){
            
            if ((isset($def['MAIN_DATABASE'])) && $def['MAIN_DATABASE']==$key) {
                $xselected=" selected";
                //echo "<option value=\"$key|adm|$value\" $xselected>".$t[0]."\n";
            } elseif (isset($arrHttp["base"]) and $arrHttp["base"]==$key or count($lista_bases)==1) 
                $xselected=" selected";
                echo "<option value=\"$key|adm|$value\" $xselected>".$t[0]."\n";
        }
    }
}
?>

<script>
lang='<?php echo $_SESSION["lang"]?>'

function VerificarEdicion(Modulo){
     if(top.xeditar=="S"){
        alert("<?php echo $msgstr["aoc"];?>")
        return
    }
}

function CambiarBaseInst(){
    tl=""
    nr=""
    top.img_dir=""
    i=document.OpcionesMenu.baseSel.selectedIndex
    top.ixbasesel=i
    if (i==-1) i=0
    abd=document.OpcionesMenu.baseSel.options[i].value

    if (abd.substr(0,2)=="--"){
        alert("<?php echo $msgstr["seldb"]?>")
        return
    }
    ab=abd+'|||'
    ix=ab.split('|')
    base=ix[0]
    top.base=base
    if (document.OpcionesMenu.baseSel.options[i].text==""){
        return
    }
    base_sel=base+'|'+ix[1]+'|'+top.basesdat[base]+'|'+ix[2]
    top.db_copies=ix[2]
    cipar=base+".par"
    top.nr=nr
    document.OpcionesMenu.base.value=base
    document.OpcionesMenu.cipar.value=cipar
    document.OpcionesMenu.tlit.value=tl
    document.OpcionesMenu.nreg.value=nr
    top.base=base
    top.cipar=cipar
    top.mfn=0
    top.maxmfn=99999999
    top.browseby="mfn"
    top.Expresion=""
    top.Mfn_Search=0
    top.Max_Search=0
    top.Search_pos=0
    lang=document.OpcionesMenu.lang.value
    switch (top.ModuloActivo){
        case "dbadmin":
            top.menu.location.href="../dbadmin/index.php?base="+base
            break;
        case "catalog":
            i=document.OpcionesMenu.baseSel.selectedIndex
            document.OpcionesMenu.baseSel.options[i].text
            top.NombreBase=document.OpcionesMenu.baseSel.options[i].text
            top.location.href="inicio_main.php?base="+base_sel+"|"+"&base_activa="+base_sel+"&lang="+lang+"&cambiolang=s"
            top.menu.document.forma1.ir_a.value=""
            i=document.OpcionesMenu.baseSel.selectedIndex
            break
        case "Capturar":
            break
    }
}

function CambiarLenguaje(){
    if (document.cambiolang.lenguaje.selectedIndex>=0){
        base = document.cambiolang.base.value;
        lang=document.cambiolang.lenguaje.options[document.cambiolang.lenguaje.selectedIndex].value
        self.location.href="?base="+base+"&reinicio=s&lang="+lang
    }
}
</script>
<div class=heading>
    <div class="institutionalInfo">
    <?php
    if (isset($def['LOGO_DEFAULT'])) {
        echo "<img src='/assets/images/logoabcd.png?".time()."' title='$institution_name'>";
    } elseif ((isset($def["LOGO"])) && (!empty($def["LOGO"]))) {
        echo "<img src='".$folder_logo.$def["LOGO"]."?".time()."' title='";
        if (isset($institution_name)) echo $institution_name;
        echo "'>";
    } else {
        echo "<img src='/assets/images/logoabcd.png?".time()."' title='ABCD'>";
    }
    ?>
    </div>
    <div class="heading-database">
    <?php   
    global $central;
    if ($central=="Y") {
        if ($_SESSION["MODULO"]=="catalog")  {
        ?>
            <form name="admin" action="../dataentry/inicio_main.php" method="post" accept-charset=utf-8>
                <input type=hidden name=encabezado value=s>
                <input type=hidden name=retorno value="../common/inicio.php">
                <input type=hidden name=modulo value=catalog>
                <input type=hidden name=screen_width>
                <?php if (isset($arrHttp["newindow"]))
                echo "<input type=hidden name=newindow value=Y>\n";?>
                <label><?php echo $msgstr["db_list"]?> </label>
                <select class="heading-database" name=base  id="selbase" onchange="doReload(this.value)">
                    <option value=""></option>
                    <?php database_list(); ?>
                </select>
            </form>
        <?php
        }
    }

    global $verify_selbase;
    if (($verify_selbase=="Y")) {
    //if (($verify_selbase=="Y") && ($session_mfn_admin=="1")) {
        ?>
        <form name=OpcionesMenu accept-charset=utf-8>
        <input type=hidden name=base value="">
        <input type=hidden name=cipar value="">
        <input type=hidden name=marc value="">
        <input type=hidden name=tlit value="">
        <input type=hidden name=nreg value="">
        <input type=hidden name=lang value="">
        <label><?php echo $msgstr["db_list"]?></label>
        <select class="heading-database" name="baseSel" onchange="CambiarBaseInst()" onclick="VerificarEdicion()">
        <option value=""></option>
        <?php
        $i=-1;
        $hascopies="";
        foreach ($lista_bases as $key => $value) {
            $xselected="";
            $t=explode('|',$value);
            if (isset($_SESSION["permiso"]["db_".$key]) or isset($_SESSION["permiso"]["db_ALL"]) or isset($_SESSION["permiso"]["CENTRAL_ALL"]) or  isset($_SESSION["permiso"][$key."_CENTRAL_ALL"])){
                if (isset($arrHttp["base_activa"])){
                    if ($key==$arrHttp["base_activa"])  {
                        $xselected=" selected";
                        if (isset($t[1])) $hascopies=$t[1];
                    }
                }
                if (!isset($t[1])) $t[1]="";
                $database_list=$key;
                echo "<option value=\"$key|adm|".$t[1]."\" $xselected>".$t[0]."\n";
            }
        }
        ?>
        </select>
        <?php
        if ($hascopies=="Y" and (isset($_SESSION["permiso"]["CENTRAL_ADDCO"]) or isset($_SESSION["permiso"]["CENTRAL_ALL"]) or  isset($_SESSION["permiso"][$arrHttp["base"]."_CENTRAL_ALL"]) or isset($_SESSION["permiso"][$arrHttp["base"]."_CENTRAL_ADDCO"]))){
            echo "\n<script>top.db_copies='Y'\n</script>\n";
        }
        ?>
        </form>
    <?php
    }
    ?>
    </div>
    <nav class="heading-nav">
    <ul>
        <?php
        if ($central=="Y") {
            $central="";
            $circulation="";
            $acquisitions="";
            $style_cat="";
            $style_loan="";
            $style_acq="";

            foreach ($_SESSION["permiso"] as $key=>$value){
                $p=explode("_",$key);
                if (isset($p[1]) and $p[1]=="CENTRAL") $central="Y";
                if (substr($key,0,8)=="CENTRAL_")  $central="Y";
                if (substr($key,0,5)=="CIRC_")  $circulation="Y";
                if (substr($key,0,4)=="ACQ_")  $acquisitions="Y";
            }           
            if ($circulation=="Y" or $acquisitions=="Y" or $central=="Y"){
                if ($central=="Y") {
                if ($_SESSION["MODULO"]=="catalog") $style_cat="active";
                ?>      
                <li>
                <form accept-charset=utf-8>
                    <button class="bt-mod bt-cat <?php echo $style_cat;?>" type="submit" name=modulo value="catalog" title="<?php echo $msgstr["modulo"]." ".$msgstr["catalogacion"];?>"></button>
                </form>
                </li>
                <?php } ?>
                <li>
                <?php
                if ($circulation=="Y") {
                    if ($_SESSION["MODULO"]=="loan") $style_loan="active";
                ?>
                    <form accept-charset=utf-8>
                        <button class="bt-mod bt-loan <?php echo $style_loan;?>" type="submit" name=modulo value="loan" title="<?php echo $msgstr["modulo"]." ".$msgstr["prestamo"];?>"></button>
                    </form>
                <?php } ?>
                </li>
                <li>
                <?php
                if ($acquisitions=="Y") {
                    if ($_SESSION["MODULO"]=="acquisitions") $style_acq="active";
                ?>
                    <form accept-charset=utf-8>
                        <button class="bt-mod bt-acq <?php echo $style_acq;?>" type="submit" name=modulo value="acquisitions" title="<?php echo $msgstr["modulo"]." ".$msgstr["acquisitions"];?>"></button>
                    </form>
                <?php } ?>
                </li>
 <?php
        }
    } 
    global $circulation, $acquisitions;
    if  (($central=="Y") or  ($circulation=="Y") or ($acquisitions=="Y") or ($verify_selbase=="Y"))  {
        if (isset($_REQUEST['base'])) {
            $selbase = $_REQUEST['base'];
        } else {
            $selbase="";
        }
 ?>
            <li>
                <form name="cambiolang"  class="language" accept-charset=utf-8>
                    <input type="hidden" name="base" value="<?php echo $selbase; ?>">
                    <input type="hidden" name="cipar" value="">
                    <input type="hidden" name="marc" value="">
                    <input type="hidden" name="tlit" value="">
                    <input type="hidden" name="nreg" value="">  

                    <select name="lenguaje"  onchange="CambiarLenguaje()">
                    <?php
                    include "inc_get-langtab.php";
                    $a=get_langtab();
                    $fp=file($a);
                    $selected="";
                    $bom="\xef\xbb\xbf"; // String with Byte Order Mark for utf-8
                    ?>
                    <option title='' value=''></option>
                    <?php
                    foreach ($fp as $value){
                        $value=trim($value);
                        if ($value!=""){
                            $larr=explode('=',$value);
                            if ($larr[0]!="lang"){
                                $langval=trim($larr[0]);
                                $langval=str_replace($bom,"",$langval);
                                $trvalue=$larr[1];
                                if ($charset=="UTF-8") {
                                    if (!mb_check_encoding($trvalue,'UTF-8')) {
                                        $trvalue=mb_convert_encoding($trvalue,'UTF-8','ISO-8859-1');
                                    }
                                }
                                $langses=$_SESSION["lang"];
                                if ($langval==$langses) $selected=" selected";
                                echo "<option value=$langval $selected title='$trvalue'>".$langval."</option>\n";
                                $selected="";
                            }
                        }
                    }
                    ?>
                    </select>
                </form>
            </li>
<?php } ?>

            <li>
                <a class="bt-charset" href="#"><?php if ( isset( $charset )) {
                          echo $charset;
                      } else {
                          echo $meta_encoding;
                      }
                    ?>
                </a>
            </li>

            <li>
                <a class="bt-charset" href="#" title=
                    <?php echo '"'.$name;?> (<?php echo $profile; ?>)
                    <?php
                        $dd=explode("/",$db_path);
                        if (isset($dd[count($dd)-2]) and $dd[count($dd)-2]!=""){
                            $da=$dd[count($dd)-2];
                            echo $da;
                        }else{
                            echo $db_path;
                        }
                        echo '"';
                    ?>><i class="fas fa-user"></i>&nbsp;<?php echo $login;?> 
                </a>
            </li>

            <li>
                <a class="bt-exit" href="../common/logout.php"><img src="/assets/svg/ic_fluent_sign_out_24_regular.svg"></a>
            </li>
        </ul>
    </nav>
</div>
