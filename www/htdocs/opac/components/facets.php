<?php

function facetas()
{
    global $db_path, $lang, $msgstr, $actparfolder, $xWxis, $busqueda, $Expresion, $primera_base, $ABCD_scripts_path, $IsisScript, $expresion, $base;

    $facetas = "S";

    include("includes/leer_bases.php");

    if (isset($facetas) and $facetas == "S") {
        $archivo = "";


        if ( (isset($_REQUEST['base'])) &&  ($_REQUEST['base']!="") ) {
        $db_facetas = $db_path . $_REQUEST['base'] . "/opac/" . $_REQUEST["lang"] . "/" . $_REQUEST['base'] . "_facetas.dat";
        $bd_orig = $_REQUEST['base'];
    }else {
        $db_facetas="";
        $bd_orig= $bd_list[$v[0]]["nombre"];
    }


        if ((file_exists($db_facetas)) && (isset($_REQUEST['base']))) {
            $archivo = $db_facetas;
        } else {
            if (file_exists($db_path . "opac_conf/" . $_REQUEST["lang"] . "/facetas.dat")) {
                $archivo = $db_path . "opac_conf/" . $_REQUEST["lang"] . "/" . "facetas.dat";
            }
        }
    }


    $conteudo = file($archivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($conteudo as $linha) {
        list($cabecalho, $formato, $pref) = explode("|", $linha);

        // Gera o cabeçalho <h4>
        echo "<div class='faceta-box'>";
        echo "<hr><h6>" . trim($cabecalho) . "</h6>";

        $bd_ref = $bd_orig;

        $arrHttp["base"] = $bd_ref;
        $arrHttp["cipar"] = $bd_ref . ".par";

        $expresion = construir_expresion();
        $expresion = removeacentos($expresion);

        //ECHO $expresion;

        $arrHttp["Opcion"] = "buscar";
        $Formato = trim($formato);

        $query_param = "&cipar=" . $db_path . "par/" . $arrHttp["cipar"];
        //$query_param.="&prefijo=".$prefixo;
        $query_param .= "&Expresion=" . $expresion;
        $query_param .= "&Opcion=" . $arrHttp["Opcion"];
        $query_param .= "&base=" . $arrHttp["base"];
        $query_param .= "&from=1";
        $query_param .= "&Formato=" . $Formato;

        $query = $query_param;


        $IsisScript = $xWxis . "opac/facetas.xis";

        include($ABCD_scripts_path . "central/common/wxis_llamar.php");

        $ocurrencias = [];

        foreach ($contenido as $value) {
            $value_tratado = trim($value); // Remove espaços em branco do início e do fim

            if (!empty($value_tratado)) { // Verifica se o valor não está vazio após o tratamento
                if (isset($ocurrencias[$value_tratado])) {
                    $ocurrencias[$value_tratado]++;
                } else {
                    $ocurrencias[$value_tratado] = 1;
                }
            }
        }

        arsort($ocurrencias);
        echo '<ul class="list-group">';



        foreach ($ocurrencias as $termo => $quantidade) {


            $expresion = str_replace('(', '', $expresion);
            $expresion = str_replace(')', '', $expresion);
            $expresion = str_replace('+and+', ') and (', $expresion);
            //$expresion = str_replace(' ', '+', $expresion);

            //$faceta_atual = str_replace(' ', '+', $pref . $termo);
            $faceta_atual = $pref . $termo;
            $faceta_atual = removeacentos($faceta_atual);

            // Determinar se o link da faceta deve ser negrito
            $negrito = '';
            if (strpos($expresion, $faceta_atual) !== false) {
                $negrito = 'style="font-weight: bold;"';
            }


            echo '<li class="list-group-item">
                <label>
                    <a href="javascript:RefinF(\'' . $faceta_atual . '\', \'' . $expresion . '\')" ' . $negrito . '>+ ' . $termo . " (" . $quantidade . ")</a>
                </label>
              </li>";
        }
        echo '</ul>';
        echo "</div>";
    }
}


if (function_exists('PresentarExpresion')) {
    $resultado = PresentarExpresion($base); // Chama a função se ela existir

?>
    <h5><?php echo $msgstr["front_su_consulta"]; ?>:</h5>
    <div id="termosAtivos" class="mb-3" data-link-inicial="<?php echo htmlspecialchars($link_logo); ?>">
        <?php
        $expOriginal = $resultado;
        //$expOriginal = isset($_REQUEST['Expresion']) ? $_REQUEST['Expresion'] : '';
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
    <br>

    <button type="button" class="btn btn-outline-danger mt-3 ml-2" onclick="clearAndRedirect('<?php echo $link_logo; ?>')">Limpar Pesquisa</button>



    <h4 class="mt-4">Refinar sua busca</h4>
    <form id="facetasForm" method="GET" class="form-inline mt-3 mb-3" onsubmit="event.preventDefault(); processarTermosLivres();">
        <input type="hidden" name="page" value="startsearch">


        <?php $expresion = construir_expresion(); ?>

        <input type="hidden" name="Expresion" id="Expresion" value="<?php echo htmlspecialchars($expresion); ?>">

        <input type="hidden" name="Opcion" value="directa">
        <?php if (isset($_REQUEST['base'])) { ?>
            <input type="hidden" name="base" value="<?php echo $_REQUEST['base']; ?>">
         <?php } ?>
        <input type="hidden" name="lang" value="<?php echo $_REQUEST['lang']; ?>">
        <?php if (isset($_REQUEST['indice_base'])) { ?>
            <input type="hidden" name="indice_base" value="<?php echo $_REQUEST['indice_base']; ?>">
        <?php } ?>
        <input type="hidden" name="modo" value="1B">
        <input type="hidden" name="resaltar" value="S">

        <div class="form-group mr-2 mb-3">
            <label for="termosLivres" class="mr-2">Termos livres:</label>
            <input type="text" class="form-control" name="termosLivres" id="termosLivres" placeholder="Digite termos separados por espaço">
        </div>
        <button type="submit" class="btn btn-primary">Adicionar à busca</button>
    </form>

<?php
    facetas();
} else {
    echo "";
    // Ou então, logar o erro, lançar uma exceção, etc.
}

?>