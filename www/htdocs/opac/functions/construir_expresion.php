<?php

function construir_expresion()
{
    $expresion = "";

    if (isset($_REQUEST['Sub_Expresion']) && isset($_REQUEST['prefijo'])) {

        $sub_expresion = trim($_REQUEST['Sub_Expresion']); // Remove espaços extras

        $busqueda_decode = mb_convert_encoding($sub_expresion, 'ISO-8859-1', 'UTF-8');

        $termos = explode(" ", $busqueda_decode);

        $total_termos = count($termos);

        if (isset($_REQUEST['alcance'])) {
            $operador = $_REQUEST['alcance'];
        } else {
            $operador = "*";
        }


        switch ($_REQUEST["Opcion"]) {
            case "directa":
                $expresion = urldecode($_REQUEST["Expresion"]);
                if (isset($_REQUEST["titulo_c"]))
                    $_REQUEST["titulo_c"] = urldecode($_REQUEST["titulo_c"]);
                $afinarBusqueda = "N";
                break;
            case "detalle":
                if (isset($_REQUEST["prefijo"]) and $_REQUEST["prefijo"] != "") $Prefijo = $_REQUEST["prefijo"];
                $EX[] = str_replace($Prefijo, '', $_REQUEST["Sub_Expresion"]);
                $CA[] = $Prefijo;
                $_REQUEST["Campos"] = $Prefijo;
                if (substr($_REQUEST["Sub_Expresion"], 0, strlen($Prefijo)) != $Prefijo) {
                    $expresion = $Prefijo . $_REQUEST["Sub_Expresion"];
                } else {
                    $expresion = $_REQUEST["Sub_Expresion"];
                }
                $_REQUEST["Sub_Expresion"] = str_replace($_REQUEST["prefijo"], '', $_REQUEST["Sub_Expresion"]);
                $expresion = "\"" . $expresion . "\"";
                break;
            case "avanzada":
            case "buscar_diccionario":
                if ($_REQUEST["Opcion"] == "avanzada") {
                    $EX = explode('~~~', urldecode($_REQUEST["Sub_Expresion"]));
                    $CA = explode('~~~', $_REQUEST["Campos"]);
                    if (isset($_REQUEST["Operadores"])) {
                        $_REQUEST["Operadores"] .= " ~~~ ";
                        $OP = explode('~~~', $_REQUEST["Operadores"]);
                    } else {
                        $OP = array();
                    }
                    if (isset($_REQUEST["Seleccionados"])) {
                        if (isset($_REQUEST["Diccio"])) {
                            $EX[$_REQUEST["Diccio"]] = $_REQUEST["Seleccionados"];
                            $OP[] = "";
                            $CA[] = $_REQUEST["prefijo"];
                        } else {
                            $EX[count($EX) - 1] = $_REQUEST["Seleccionados"];
                            $OP[] = "";
                            $CA[] = $_REQUEST["prefijo"];
                        }
                    }
                } else {
                    if (isset($_REQUEST['base']) and $_REQUEST['base'] != "")
                        $fav = file($db_path . $_REQUEST['base'] . "/opac/" . $lang . "/" . $_REQUEST['base'] . "_avanzada.tab");
                    else
                        $fav = file($db_path . "opac_conf/" . $lang . "/avanzada.tab");
                    $ix = -1;
                    $exp_bb = "";

                    foreach ($fav as $value) {
                        $value = trim($value);
                        if ($value != "") {
                            $ix = $ix + 1;
                            $v = explode('|', $value);
                            $OP[$ix] = " ";
                            $CA[$ix] = $v[1];
                            if ($_REQUEST["prefijo"] == $v[1])
                                if (isset($_REQUEST["Seleccionados"]))
                                    $EX[$ix] = $_REQUEST["Seleccionados"];
                                else
                                    $EX[$ix] = " ";
                            else
                                $EX[$ix] = " ";
                            if ($exp_bb == "")
                                $exp_bb = $EX[$ix];
                            else
                                $exp_bb .= '~~~' . $EX[$ix];
                        }
                    }
                    $_REQUEST["Sub_Expresion"] = $exp_bb;
                }

                $expresion = "";
                $EB = array();
                $EBO = array();
                $IB = -1;
                for ($ix = 0; $ix < count($EX); $ix++) {
                    $booleano = "";
                    if ($ix <> 0) if (isset($OP[$ix - 1])) $booleano = $OP[$ix - 1];
                    if (trim($EX[$ix]) != "") {
                        if (strpos($EX[$ix], '"') === false) {
                            if (trim($CA[$ix]) == "TW_") {
                                $expre = explode(' ', $EX[$ix]);
                            } else {
                                $expre = explode('"', $EX[$ix]);
                                $expre = explode(' ', $EX[$ix]);
                            }
                        } else {
                            $expre = explode('"', $EX[$ix]);
                        }
                        $sub_expre = "";
                        foreach ($expre as $exp) {
                            $exp = rtrim($exp);
                            if ($exp != "") {
                                $exp = '"' . trim((string)$CA[$ix]) . $exp . '"';
                                if ($sub_expre == "") {
                                    $sub_expre = $exp;
                                } else {
                                    $sub_expre .= " " . $_REQUEST["alcance"] . " " . $exp;
                                }
                            }
                        }
                        if ($sub_expre != "") {
                            $IB = $IB + 1;
                            $EB[$IB] = "(" . $sub_expre . ")";
                            $EBO[$IB] = $OP[$ix];
                        }
                    }
                }
                $expresion = "";
                for ($ix = 0; $ix <= $IB; $ix++) {
                    if ($ix == 0) {
                        $expresion = $EB[$ix];
                    } else {
                        $expresion .= " " . $EBO[$ix - 1] . " " . $EB[$ix];
                    }
                }
                break;
            default:
                if (!empty($_REQUEST['prefijo'])) {
                    $prefixo = $_REQUEST['prefijo'];
                } else {
                    $prefixo = "TW_";
                }

                foreach ($termos as $indice => $termo) {
                    $expresion .= $prefixo . $termo;
                    //$expresion .= 'TW_maria"*"TW_oliveira"*"TW_eduardo"*"TW_alunos"';
                    if ($indice < $total_termos - 1) { // Verifica se não é o último termo
                        $expresion .= " " . $operador . " ";
                    }
                }
        }
    } else {

        $expresion = $_REQUEST["Expresion"];
        // $expresion = "TW_" . $_REQUEST["Expresion"];
    }



    // Remove aspas duplas
    $expresion = str_replace('"', '', $expresion);

    return $expresion;
}
