<?php

/**************** Modifications ****************

2022-03-23 rogercgui change the folder /par to the variable $actparfolder


 ***********************************************/
$mostrar_menu = "N";
//include("../../central/config_opac.php");

$desde = 1;
$count = "1";


$base = $_GET['base'];

$key = "c_=" . $_GET['base'] . "_=" . $_GET['k'];
$list = explode("|", $key);

$Pref_key = "CN_";
$key = $Pref_key . removeacentos($_GET['k']);

$archivo = $db_path . $base . "/opac/" . $lang . "/" . $_GET['base'] . "_formatos.dat";
$fp = file($archivo);
$primeravez = "S";
foreach ($fp as $ff) {
    $ff = trim($ff);
    if ($ff != "") {
        $ff_arr = explode('|', $ff);
        if (isset($ff_arr[2]) and $ff_arr[2] == "Y") {
            $fconsolidado = $ff_arr[0];
            break;
        } else {
            if ($primeravez == "S") {
                $primeravez = "N";
                $fconsolidado = $ff_arr[0];
            }
        }
    }
}
$query = "&base=" . $base . "&cipar=$db_path" . $actparfolder . $base . ".par&key=$key&Formato=@$fconsolidado.pft&lang=" . $lang;


$resultado = wxisLlamar($base, $query, $xWxis . "opac/permalink.xis");
?>

<!-- Modal Bootstrap -->
<div class="modal fade" id="registroModal" tabindex="-1" aria-labelledby="registroModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center justify-content-between text-bg-light">
                <div class="d-flex align-items-center">
                    <h5 class="modal-title me-3" id="registroModalLabel">Registro bibliográfico </h5>
                    <button id="btnCopiar" type="button" class="btn btn-outline-primary btn-sm" onclick="copiarLink()">
                        <i class="far fa-clipboard"></i> Copiar link direto
                    </button>

                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>

            <div class="modal-body text-bg-light">
                <?php
                foreach ($resultado as $salida) {
                    $salida = trim($salida);
                    if (substr($salida, 0, 8) == "[TOTAL:]") continue;
                    echo $salida;
                }
                ?>
            </div>
        </div>
    </div>
</div>