<?php

/*
20220424 rogercgui add backbutton and inc-helper
20250321 rogercgui Improved addition of automatic copies. The spreadsheet now signals to the cataloguer the largest number of inventory used. It also correctly records the highest number used in the control_number.cn file.
*/

session_start();
if (!isset($_SESSION["permiso"])) {
    header("Location: ../common/error_page.php");
}
if (!isset($_SESSION["lang"]))  $_SESSION["lang"] = "en";
include("../common/get_post.php");
include("../config.php");
$lang = $_SESSION["lang"];

include("../lang/acquisitions.php");
include("../lang/admin.php");

//foreach ($arrHttp as $var=>$value)  echo "$var=$value<br>";
//die;

include("../common/abcd_ref.php");
include("../common/header.php");

?>

<div class="sectionInfo">
    <div class="breadcrumb">
        <?php echo $arrHttp["base"] . ": " . $msgstr["createcopies"]; ?>
    </div>
    <div class="actions">

        <?php
        unset($arrHttp["base"]);
        $backtoscript = "javascript:top.Menu('same')";
        include "../common/inc_back.php";
        ?>

    </div>
    <div class="spacer">&#160;</div>
</div>

<?php
$ayuda = "/acquisitions/copies_create.html";
include "../common/inc_div-helper.php" ?>

<div class="middle form">
    <div class="formContent">

        <?php
        $arrHttp["Opcion"] = "ver";
        $arrHttp["database"] = $arrHttp["tag10"];
        $arrHttp["objectid"] = $arrHttp["tag1"];

        // Read the FDT to get the label of the field where the automatic numbering is placed.

        LeerFst($arrHttp["database"]);

        // Read the catalog database to determine whether the object has been added.
        $Formato = $db_path . $arrHttp["database"] . "/pfts/" . $_SESSION["lang"] . "/" . $arrHttp["database"] . ".pft";

        if (!file_exists($Formato)) $Formato = $db_path . $arrHttp["database"] . "/pfts/" . $lang_db . "/" . $arrHttp["database"] . ".pft";
        $Formato = "@$Formato,/";
        $Expresion = "$pref_ctl" . $arrHttp["objectid"];
        $query = "&base=" . $arrHttp["database"] . "&cipar=$db_path" . "par/" . $arrHttp["database"] . ".par" . "&Expresion=$Expresion&Formato=$Formato&Opcion=buscar";
        $IsisScript = $xWxis . "imprime.xis";
        include("../common/wxis_llamar.php");
        $cont_database = implode('', $contenido);

        if (trim($cont_database) == "") {
            echo "<h4>" . $arrHttp["objectid"] . ": " . $msgstr["objnoex"] . "</h4>";
            echo "\n<script>top.toolbarEnabled=\"\"</script>\n";
            die;
        }
        $cont_database = $contenido;
        if (isset($arrHttp["copies"])) echo "<br>" . $msgstr["copies_no"] . ": " . $arrHttp["copies"];

        $Mfn = "";
        if (isset($arrHttp["tag30"])  and !isset($arrHttp["copies"])) {
            $inven = explode("\n", $arrHttp["tag30"]);
            unset($arrHttp["tag30"]);
            foreach ($inven as $cn) {
                if (trim($cn) != "")
                    CrearCopia(trim($cn), $max_inventory_length);
            }
        } else {

            $ultimo_cn = 0; // Initializes the variable to store the last used CN.
            for ($ix = 1; $ix <= $arrHttp["copies"]; $ix++) {
                echo "<hr>";
                if (isset($arrHttp["tag30"])) {
                    if ($ix == 1) {
                        $cn = $arrHttp["tag30"];
                    } else {
                        $cn = $cn + 1;
                    }
                } else {
                    $cn = ProximoNumero("copies", "ler") + 1; // Read and increment
                }
                $cn = str_pad($cn, $max_inventory_length, '0', STR_PAD_LEFT); // Format with leading zeros
                CrearCopia($cn, $max_inventory_length);
                $ultimo_cn = $cn; // Stores the last used CN
            }
            $write_result = ProximoNumero($ultimo_cn, "escrever"); // Update the file with the latest number (outside the loop)
            if ($write_result === 1) {
                echo "<br>".$msgstr['cn_fwrite_success']." " . $ultimo_cn;
            } else {
                echo "<br><font color='red'>".$msgstr['cn_fwrite_error']."</font>";
            }
        }

        /*foreach ($cont_database as $value){
            $value=trim($value);
            if (trim($value)!=""){
                if (substr($value,0,6)=='$$REF:'){
                    echo ABCD_Ref($value,"");
                } else {
                    echo $value;
                }
            }
        }*/

        echo "</div></div>";
        include("../common/footer.php");
        echo "</body></html>";
        echo "\n<script>top.toolbarEnabled=\"\"</script>\n";

        //=================================================================

        function CrearCopia($cn, $max_inventory_length) {
            global $msgstr, $arrHttp, $xWxis, $Wxis, $wxisUrl, $db_path;
            $Mfn = "";
            //$cn=str_pad($cn, $max_inventory_length, '0', STR_PAD_LEFT);
            echo "<br>" . $msgstr["createcopies"] . ": ";
            echo $msgstr["inventory"] . ": $cn";
            // Se verifica si ese número de inventario no existe
            $res = BuscarCopias($cn);
            if ($res > 0) {
                echo "<font color=red> &nbsp;" . $msgstr["invdup"] . "</font>";
            } else {
                $ValorCapturado = "";
                foreach ($arrHttp as $var => $value) {
                    if (substr($var, 0, 3) == "tag") {
                        $tag = trim(substr($var, 3));
                        if ($tag != 30) $ValorCapturado .= "<" . $tag . " 0>" . $value . "</" . $tag . ">";
                    }
                }
                $ValorCapturado .= "<30 0>" . $cn . "</30>";
                $ValorCapturado = urlencode($ValorCapturado);
                $IsisScript = $xWxis . "actualizar.xis";
                $query = "&base=copies&cipar=$db_path" . "par/copies.par&login=" . $_SESSION["login"] . "&Mfn=New&Opcion=crear&ValorCapturado=" . $ValorCapturado;
                include("../common/wxis_llamar.php");
                foreach ($contenido as $linea) {
                    if (substr($linea, 0, 4) == "MFN:") {
                        echo " &nbsp; Mfn: <a href=../dataentry/show.php?base=copies&Mfn=" . trim(substr($linea, 4)) . " target=_blank>" . trim(substr($linea, 4)) . "</a>";
                        $Mfn .= trim(substr($linea, 4)) . "|";
                    } else {
                        if (trim($linea != "")) echo $linea . "\n";
                    }
                }
            }
        }

function ProximoNumero($base, $modo = "ler") {
    global $db_path;
    $arquivo = $db_path . "copies/data/control_number.cn";

    error_log("ProximoNumero called based on: " . $base . ", modo: " . $modo);
    error_log("File path: " . $arquivo); // Log do caminho

    if (!file_exists($arquivo)) {
        error_log("Erro: File control_number.cn not found in: " . $arquivo);
        return 0;
    }

    $fp = fopen($arquivo, "c+");
    if (!$fp) {
        error_log("Erro: Could not open file: " . $arquivo);
        return 0;
    }

    if ($modo == "ler") {
        $cn = trim(fgets($fp));
        $cn = $cn === "" ? 0 : intval($cn);
        fclose($fp);
        error_log("ProximoNumero reading CN: " . $cn);
        return $cn;
    } elseif ($modo == "escrever" && is_numeric($base)) {
        $locked = flock($fp, LOCK_EX);
        if (!$locked) {
            error_log("Erro: Could not obtain lock on file: " . $arquivo);
            fclose($fp);
            return 0;
        }
        rewind($fp);
        $write_result = fwrite($fp, strval($base));
        if ($write_result === FALSE) {
            error_log("Erro: Could not write to file: " . $arquivo);
            flock($fp, LOCK_UN);
            fclose($fp);
            fclose($fp);
            return 0;
        }
        fflush($fp);
        $unlocked = flock($fp, LOCK_UN);
        if (!$unlocked) {
            error_log("Erro: Could not release file lock: " . $arquivo);
        }
        fclose($fp);
        error_log("ProximoNumero he wrote CN: " . $base);
        return 1;
    } else {
        fclose($fp);
        return 0;
    }
}

        function BuscarCopias($inventario)
        {
            global $xWxis, $db_path, $wxisUrl, $Wxis;

            if ($inventario != "") {
                $Prefijo = "IN_" . $inventario;
            } else {
                $Prefijo = 'ORDER_' . $order . '_' . $suggestion . '_' . $bidding;
            }

            $IsisScript = $xWxis . "ifp.xis";
            $query = "&base=copies&cipar=$db_path" . "par/copies.par&Opcion=diccionario&prefijo=$Prefijo&campo=1";
            $contenido = array();
            include("../common/wxis_llamar.php");
            foreach ($contenido as $linea) {
                if (trim($linea) != "") {
                    $pre = trim(substr($linea, 0, strlen($Prefijo)));
                    if ($pre == $Prefijo) {
                        $l = explode('|', $linea);
                        return $l[1];
                        break;
                    }
                }
            }
            return 0;
        }

        function LeerFst($base)
        {
            global $tag_ctl, $pref_ctl, $arrHttp, $db_path, $AI, $lang_db, $msgstr, $error;
            // GET THE FST TO FIND THE CONTROL NUMBER OF A BIBLIOGRAPHIC DATABASE
            $archivo = $db_path . $base . "/data/" . $base . ".fst";
            if (!file_exists($archivo)) {
                echo "missing file " . $base . "/data/" . $base . ".fst";
                die;
            }
            $fp = file($archivo);
            $tag_ctl = "";
            $pref_ctl = "CN_";
            foreach ($fp as $linea) {
                $linea = trim($linea);
                $ix = strpos($linea, "\"CN_\"");
                if ($ix === false) {
                    $ix = strpos($linea, '|CN_|');
                }
                if ($ix === false) {
                } else {
                    $ix = strpos($linea, " ");
                    $tag_ctl = trim(substr($linea, 0, $ix));
                    break;
                }
            }
            // Si no se ha definido el tag para el número de control en la fdt, se produce un error
            if ($tag_ctl == "") {
                $error = "missingctl";
            }
        }
        ?>