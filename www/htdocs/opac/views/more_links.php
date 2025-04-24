<?php
/**
 * This script displays links added in the file opac_conf/[lang]/side_bar.info
 * 20230313 rogercgui File created
 */

if (file_exists($db_path . "opac_conf/" . $lang . "/side_bar.info")) {
    $fp = file($db_path . "opac_conf/" . $lang . "/side_bar.info");
    $sec_name = "";

    echo '<div class="row border-top border-secondary bg-dark-subtle text-black py-4 mx-0">'; // Iniciar a linha Bootstrap

    foreach ($fp as $value) {
        $value = trim($value);
        if ($value != "") {
            if (substr($value, 0, 9) == "[SECCION]") {
                if ($sec_name != "") {
                    echo '</div></div></div>'; // Fechar o card anterior e a coluna
                }
                $sec_name = substr($value, 9);
                echo '<div class="col-md-4 mb-3"><div class="card bg-white rounded-0"><div class="card-body">'; // Iniciar novo card e coluna
                echo '<h6 class="card-title text-dark">' . $sec_name . '</h6>'; // Título da seção no card
                echo '<ul class="list-group list-group-flush">'; // Iniciar list-group dentro do card
            } else {
                $l = explode('|', $value);
                echo '<li class="list-group-item"><a href="' . $l[1] . '" class="card-link custom-links"';
                if (isset($l[2]) && $l[2] == "Y") {
                    echo ' target="_blank"';
                }
                echo '>' . $l[0] . '</a></li>';
            }
        }
    }
    echo '</ul></div></div></div></div>'; // Fechar o último list-group, card, coluna e linha
}
?>