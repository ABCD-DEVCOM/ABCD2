<?php

/**
 * 20230305 rogercgui Adds the variable $actparfolder;
 * 20230914 Fixes bugs related to file overwriting, incorrect format, and .lang file logic.
 */


include("conf_opac_top.php");
$wiki_help = "OPAC-ABCD_configuraci%C3%B3n#Bases_de_datos_disponibles";
include "../../common/inc_div-helper.php";

//foreach ($_REQUEST as $var=>$value) echo "$var=>$value<br>";  die;
?>

<script>
    var idPage = "db_configuration";
</script>

<div class="middle form row m-0">
    <div class="formContent col-2 m-2">
        <?php include("conf_opac_menu.php"); ?>
    </div>
    <div class="formContent col-9 m-2">


        <h3><?php echo $msgstr["databases"] ?></h3>


        <?php
        // Função para verificar se um valor está presente em bases.dat do OPAC
        function isInDbopac($valor, $dbopacData)
        {
            foreach ($dbopacData as $dbopacLinha) {
                list($dbopacValor) = explode('|', $dbopacLinha);
                if ($valor === $dbopacValor) {
                    return true;
                }
            }
            return false;
        }

        // Ler o conteúdo de bases.dat (master) e bases.dat (OPAC)
        $file_conf_opac = $db_path . 'opac_conf/' . $lang . '/bases.dat';
        $masterData = file($db_path . 'bases.dat', FILE_IGNORE_NEW_LINES);
        $dbopacData = file_exists($file_conf_opac) ? file($file_conf_opac, FILE_IGNORE_NEW_LINES) : [];


        // Processar o envio do formulário
        if (isset($_POST['submit'])) {
            // Inicializar um array para armazenar os dados atualizados de bases.dat do OPAC
            $updatedDbopacData = array();
            $uniqueLangValues = array();

            foreach ($masterData as $linha) {
                if (trim($linha) == '') continue;
                list($valor, $HumanNameDb) = explode('|', $linha);
                $dbName = str_replace(array('.def', '.par'), '', $valor);
                $checkboxName = 'checkbox_' . $dbName;
                $textInputName = 'text_' . $dbName;
                $textInputDescName = 'text_desc_' . $dbName;

                // Verificar se o checkbox foi marcado
                if (isset($_POST[$checkboxName])) {
                    $textInputValue = $_POST[$textInputName] ?? '';
                    $updatedDbopacData[] = "$dbName|$textInputValue";

                    // Criar o diretório opac/$lang se não existir
                    $opacDir = $db_path . $dbName . '/opac/' . $lang . '/';
                    if (!is_dir($opacDir)) {
                        mkdir($opacDir, 0777, true);
                    }

                    // Salvar a descrição completa em um arquivo de texto
                    $defFile = $opacDir . $dbName . '.def';
                    if (!file_exists($defFile)) {
                        file_put_contents($defFile, $_POST[$textInputDescName] ?? '');

                        // --- LÓGICA PARA CRIAR ARQUIVOS ADICIONAIS SOMENTE SE NÃO EXISTIREM ---

                        // Cria o arquivo base_de_dados_formatos.dat
                        $formato_file_opac = $opacDir . $dbName . "_formatos.dat";
                        if (!file_exists($formato_file_opac)) {
                            $formato_file_original = $db_path . $dbName . "/pfts/$lang/formatos.dat";
                            $fp_opac_formatos = fopen($formato_file_opac, "w");
                            if (file_exists($formato_file_original)) {
                                $fp_formatos = file($formato_file_original);
                                $first_line = true; // Flag para garantir que o primeiro formato seja Y
                                foreach ($fp_formatos as $linha_formato) {
                                    $l = explode('|', trim($linha_formato));
                                    $output_line = trim($l[0]) . "|" . trim($l[1]);

                                    if ($first_line) {
                                        $output_line .= "|Y";
                                        $first_line = false;
                                    } else {
                                        $output_line .= "|N";
                                    }
                                    fwrite($fp_opac_formatos, $output_line . "\n");
                                }
                            } else {
                                fwrite($fp_opac_formatos, "default|Default|Y\n");
                            }
                            fclose($fp_opac_formatos);
                        }

                        // Cria o arquivo base_de_dados_libre.tab
                        $libre_file = $opacDir . $dbName . "_libre.tab";
                        if (!file_exists($libre_file)) {
                            $fp_libre = fopen($libre_file, "w");
                            fwrite($fp_libre, "Free search|TW_");
                            fclose($fp_libre);
                        }

                        // =================================================================================
                        // INÍCIO DA FUNCIONALIDADE ADICIONADA (NO LOCAL CORRETO)
                        // ATUALIZA O .PAR APENAS QUANDO A BASE É CONFIGURADA PELA PRIMEIRA VEZ
                        // =================================================================================
                        $par_file = $db_path . "par/" . $dbName . ".par";
                        if (file_exists($formato_file_opac)) {
                            $formatos = file($formato_file_opac, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

                            $par_content = array();
                            if (file_exists($par_file)) {
                                $par_lines = file($par_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                                foreach ($par_lines as $line) {
                                    if (strpos($line, "=") !== false) {
                                        list($key, $value) = explode("=", $line, 2);
                                        $par_content[trim($key)] = trim($value);
                                    }
                                }
                            }

                            // Adiciona as novas entradas de formato PFT
                            foreach ($formatos as $formato_linha) {
                                $formato_parts = explode('|', $formato_linha);
                                $pft_name = trim($formato_parts[0]);
                                if (!empty($pft_name)) {
                                    $par_key = $pft_name . ".pft";
                                    $par_value = "%path_database%" . $dbName . "/pfts/%lang%/" . $pft_name . ".pft";
                                    $par_content[$par_key] = $par_value;
                                }
                            }

                            $par_content["select_record.pft"] = "%path_database%opac_conf/%lang%/select_record.pft";

                            $new_par_file_content = "";
                            foreach ($par_content as $key => $value) {
                                $new_par_file_content .= $key . "=" . $value . "\n";
                            }

                            file_put_contents($par_file, $new_par_file_content);
                        }
                        // =================================================================================
                        // FIM DA FUNCIONALIDADE ADICIONADA
                        // =================================================================================
                    }
                }
            }

            // Gravar os dados atualizados no arquivo bases.dat do OPAC
            file_put_contents($file_conf_opac, implode(PHP_EOL, $updatedDbopacData));

            // Lógica original para salvar arquivos .lang
            $uniqueLangValues = array();
            $uniqueSuffixes = array();
            foreach ($_POST as $postField => $postValue) {
                if (strpos($postField, 'langdb_') === 0) {
                    $parts = explode('_', $postField);
                    if (count($parts) === 3) {
                        $langValue = $postValue;
                        $prefix = $parts[1];
                        $suffix = $parts[2];
                        $alphaInputDb = 'langdb_' . $prefix . '_' . $suffix;

                        if (isset($_POST[$alphaInputDb])) {
                            $uniqueLangValues[$suffix][] = $langValue;
                            $uniqueSuffixes[] = $suffix;
                        }
                    }
                }
            }

            $uniqueSuffixes = array_unique($uniqueSuffixes);
            foreach ($uniqueSuffixes as $suffix) {
                $uniqueLangValues[$suffix] = array_unique($uniqueLangValues[$suffix]);
                $file_db_alpha_opac = $db_path . $suffix . '/opac/' . $lang . '/' . $suffix . '.lang';
                file_put_contents($file_db_alpha_opac, implode(PHP_EOL, $uniqueLangValues[$suffix]));
            }

            echo '<div class="alert success">' . $msgstr["updated"] . '<pre>' . $file_conf_opac . '</pre></div>';

            // Recarregar os dados de dbopac.dat após a atualização
            $dbopacData = file_exists($file_conf_opac) ? file($file_conf_opac, FILE_IGNORE_NEW_LINES) : [];
        }

        $alpha = array();
        if (is_dir($db_path . "opac_conf/alpha/" . $charset)) {
            $handle = opendir($db_path . "opac_conf/alpha/" . $charset);
            while (false !== ($entry = readdir($handle))) {
                if (!is_file($db_path . "opac_conf/alpha/$charset/$entry")) continue;
                $alpha[$entry] = $entry;
            }
        }

        // Exibir o formulário
        ?>

        <form method="POST">
            <input type="hidden" name="lang" value="<?php echo $lang; ?>">
            <?php foreach ($masterData as $linha) {
                $linha = trim($linha);
                if (empty($linha)) continue;
                list($valor, $HumanNameDb) = explode('|', $linha);
                $valor = str_replace(array('.def', '.par'), '', $valor);

                if ((substr($HumanNameDb, 0, 3) != "Acq") and (substr($HumanNameDb, 0, 4) != "Circ") and (substr($HumanNameDb, 0, 3) != "Sys")) {
                    $isChecked = isInDbopac($valor, $dbopacData);

                    echo '<h3><input class="m-1 p-2" type="checkbox" name="checkbox_' . $valor . '" value="' . $valor . '" ' . ($isChecked ? 'checked' : '') . '>';
                    echo '<label class="w-3 p-2" >' . $HumanNameDb . '</label></h3>';
            ?>
                    <div class="w-10" style="display: flex;">
                        <div class="w-4 p-3">

                            <?php
                            echo "<label title=" . $file_conf_opac . ">" . $msgstr["db_name"] . "</label>";
                            echo '<input class="w-10"  type="text" name="text_' . $valor . '" value="';

                            $opacHumanName = '';
                            foreach ($dbopacData as $dbopacLinha) {
                                list($dbopacValor, $dbopacHumanName) = explode('|', $dbopacLinha);
                                if ($valor === $dbopacValor) {
                                    $opacHumanName = $dbopacHumanName;
                                    break;
                                }
                            }

                            echo htmlspecialchars($opacHumanName) . '">';
                            ?>
                        </div>

                        <div class="w-4 p-3">


                            <?php
                            $defFile = $db_path . $valor . '/opac/' . $lang . '/' . $valor . '.def';
                            echo "<label title=" . $defFile . ">" . $msgstr["db_desc"] . "</label>";

                            $defContents = '';
                            if (file_exists($defFile)) {
                                $defContents = file_get_contents($defFile);
                            }

                            echo '<input class="w-10"  type="text" name="text_desc_' . $valor . '" value="' . htmlspecialchars($defContents) . '">';

                            $ix_lang = 0;
                            $langdb = array();
                            if (file_exists($db_path . $valor . '/opac/' . $lang . '/' . $valor . '.lang')) {
                                $fp_lang = file($db_path . $valor . '/opac/' . $lang . '/' . $valor . '.lang');
                                foreach ($fp_lang as $value_lang) {
                                    if (trim($value_lang) != "") {
                                        $fll = explode('|', $value_lang);
                                        foreach ($fll as $xfll) {
                                            $xfll = trim($xfll);
                                            $langdb[$xfll] = $xfll;
                                        }
                                    }
                                }
                            }
                            ?>
                        </div>
                    </div>

            <?php

                    echo "<label>" . $msgstr["avail_db_lang"] . " " . $valor . '</label><br>';
                    foreach ($alpha as $value) {
                        $ix_lang = $ix_lang + 1;
                        $ix_00 = strrpos($value, ".");
                        $value = substr($value, 0, $ix_00);
                        echo '<input class="m-2" type="checkbox" name="langdb_' . $value . '_' . $valor . '" value="' . $value . '"';
                        if (isset($langdb[$value])) echo " checked";
                        echo ">" . $value;
                        if ($ix_lang > 3) {
                            $ix_lang = 0;
                        }
                    }

                    echo '<br><br><hr>';
                }
            }
            ?>
            <input class="bt bt-green" type="submit" name="submit" value="Salvar">
        </form>
    </div>
</div>