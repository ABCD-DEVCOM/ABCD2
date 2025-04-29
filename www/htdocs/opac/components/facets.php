<?php

function facetas()
{
    global $db_path, $lang, $msgstr, $actparfolder, $xWxis, $busqueda, $Expresion, $primera_base, $ABCD_scripts_path, $IsisScript, $expresion, $base;

    $facetas = "S";

    include("includes/leer_bases.php");

    if (isset($facetas) and $facetas == "S") {

        if (isset($_REQUEST['base']) && $_REQUEST['base'] != "") {
            $bases_para_processar = [$_REQUEST['base']];
        } else {
            $bases_para_processar = array_keys($bd_list);
        }

        // Build the expression only once for all facets
        $expresionOriginal = construir_expresion();
        $expresionSemAcento = removeacentos($expresionOriginal);
        $expresionClean = str_replace(['(', ')', '+and+'], ['', '', ') and ('], $expresionSemAcento);

        foreach ($bases_para_processar as $base_atual) {
            $db_facetas = $db_path . $base_atual . "/opac/" . $_REQUEST["lang"] . "/" . $base_atual . "_facetas.dat";

            if (!file_exists($db_facetas)) {
                continue;
            }

            $conteudo = file($db_facetas, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

            if (empty($conteudo)) {
                continue;
            }

            echo "<h5 class='mt-4 mb-3 border-bottom pb-2'>" . $bd_list[$base_atual]['descripcion'] . "</h5>";

            foreach ($conteudo as $linha) {
                list($cabecalho, $formato, $pref, $ordem) = array_pad(explode("|", $linha), 4, 'Q');

                $arrHttp["base"] = $base_atual;
                $arrHttp["cipar"] = $base_atual . ".par";
                $arrHttp["Opcion"] = "buscar";
                $Formato = trim($formato);

                $query_param = "&cipar=" . $db_path . "par/" . $arrHttp["cipar"];
                $query_param .= "&Expresion=" . $expresionOriginal;
                $query_param .= "&Opcion=" . $arrHttp["Opcion"];
                $query_param .= "&base=" . $base_atual;
                $query_param .= "&from=1";
                $query_param .= "&Formato=" . $Formato;

                $IsisScript = $xWxis . "opac/facetas.xis";
                $query = $query_param;

                include($ABCD_scripts_path . "central/common/wxis_llamar.php");

                $ocorrencias = [];

                foreach ($contenido as $value) {
                    $value_tratado = trim($value);
                    if (!empty($value_tratado)) {
                        $ocorrencias[$value_tratado] = ($ocorrencias[$value_tratado] ?? 0) + 1;
                    }
                }

                if (!empty($ocorrencias)) {
                    if (strtoupper(trim($ordem)) === 'A') {
                        ksort($ocorrencias);
                    } else {
                        arsort($ocorrencias);
                    }

                    echo "<div class='faceta-box mt-3'>";
                    echo "<h6 class='text-primary mb-2'>" . trim($cabecalho) . "</h6>";
                    echo '<ul class="list-group shadow-sm border rounded" style="max-height: 300px; overflow-y: auto; scrollbar-width: thin;">';

                    foreach ($ocorrencias as $termo => $quantidade) {
                        $faceta_atual = removeacentos($pref . $termo);

                        $negrito = '';
                        if (stripos($expresionClean, $faceta_atual) !== false) {
                            $negrito = 'font-weight: bold;';
                        }

                        $termoFaceta = trim(preg_replace(['/^[^_]*_/', '/[:\/.]/'], '', $termo), " )(");

                        echo '<li class="list-group-item py-1 px-2 d-flex justify-content-between align-items-center" style="border: none; border-bottom: 1px solid #eee;">';
                        echo '<a href="javascript:RefinF(\'' . $faceta_atual . '\', \'' . $expresionClean . '\',\'' . $base_atual . '\')" style="text-decoration: none; color: inherit; ' . $negrito . '">';
                        echo '<span class="text-secondary" style="font-size: 1rem;">➕</span> ' . htmlspecialchars($termoFaceta) . ' (' . $quantidade . ')';
                        echo '</a>';
                        echo '</li>';
                    }

                    echo '</ul>';
                    echo "</div>";
                }
            }
        }
    }
}

if (function_exists('PresentarExpresion')) {
    $resultado = PresentarExpresion($base);

?>
    <h5 class="mt-4"><?php echo $msgstr["front_su_consulta"]; ?>:</h5>
    <div id="termosAtivos" class="mb-3" data-link-inicial="<?php echo htmlspecialchars($link_logo); ?>">
        <?php
        $expOriginal = $resultado;
        $expFormatada = str_replace('"', '', $expOriginal);
        $termos = preg_split('/\s+and\s+/i', $expFormatada);

        foreach ($termos as $indice => $termo) {
            $termoLimpo = strtolower(trim(preg_replace('/^[^_]*_/', '', $termo), " )("));
            echo "<button type='button' class='btn btn-outline-primary btn-sm mr-1 mb-1 termo' onclick='removerTermo(\"" . htmlspecialchars($termo) . "\")'>";
            echo removeacentos($termoLimpo);
            echo " <span aria-hidden='true'>&times;</span></button>";
        }
        ?>
    </div>

    <button type="button" class="btn btn-danger mt-3 mb-3" onclick="clearAndRedirect('<?php echo $link_logo; ?>')"><?php echo $msgstr['clean_search'] ?></button>

    <h4 class="mt-4"><?php echo $msgstr['front_afinar'] ?></h4>
    <form id="facetasForm" method="GET" class="form-inline mt-3 mb-3" onsubmit="event.preventDefault(); processarTermosLivres();">
        <input type="hidden" name="page" value="startsearch">
        <?php $expresion = construir_expresion(); ?>
        <input type="hidden" name="Expresion" id="Expresion" value="<?php echo htmlspecialchars($expresion); ?>">
        <input type="hidden" name="Opcion" value="directa">
        <?php if (isset($_REQUEST['base'])) { ?>
            <input type="hidden" name="base" id="base" value="<?php echo $_REQUEST['base']; ?>">
        <?php } ?>
        <input type="hidden" name="lang" value="<?php echo $_REQUEST['lang']; ?>">
        <?php if (isset($_REQUEST['indice_base'])) { ?>
            <input type="hidden" name="indice_base" value="<?php echo $_REQUEST['indice_base']; ?>">
        <?php } ?>
        <input type="hidden" name="modo" value="1B">
        <input type="hidden" name="resaltar" value="S">

        <div class="form-group mr-2 mb-2">
            <label for="termosLivres" class="mr-2"><?php echo $msgstr['free_terms'] ?></label>
            <input type="text" class="form-control" name="termosLivres" id="termo-busca" placeholder="<?php echo $msgstr['type_terms'] ?>">
        </div>
        <button type="submit" class="btn btn-primary"><?php echo $msgstr['add_terms'] ?></button>
    </form>

<?php
    facetas();
} else {
    echo "";
}
?>