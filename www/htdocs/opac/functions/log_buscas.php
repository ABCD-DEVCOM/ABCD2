<?php
function registrar_log_busca($termo) {
    global $db_path;
    $ip = $_SERVER['REMOTE_ADDR'];
    $data = date("Y-m-d H:i:s");
    $linha = "$data\t$ip\t$termo\n";

    $arquivo = $db_path . "/opac_conf/logs/log_opac.txt";
    file_put_contents($arquivo, $linha, FILE_APPEND | LOCK_EX);
}
