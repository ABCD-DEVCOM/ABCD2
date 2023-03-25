<?php
if (!isset($mostrar_menu) or (isset($mostrar_menu) and $mostrar_menu == "S")) {
?>
      <ul id="menu-wrapper"  class="nav nav-pills">
 
        <li class="nav-item"><a href="javascript:document.inicio_menu.submit()" class="nav-link" aria-current="page"><?php echo $msgstr["inicio"] ?></a></li>
           <?php

                if (file_exists($db_path . "opac_conf/" . $lang . "/menu.info")) {
                    $fp = file($db_path . "opac_conf/" . $lang . "/menu.info");
                    foreach ($fp as $value) {
                        $value = trim($value);
                        if ($value != "") {
                            $x = explode('|', $value);
                            echo "<li class=\"nav-item\"><a class=\"nav-link\" href=\"" . $x[1] . "\"";
                            if (isset($x[2]) and $x[2] == "Y") echo " target=_blank";
                            echo ">" . $x[0] . "</a></li>";
                        }
                    }
                }
        
        ?>


      </ul>

    <nav id="menu-wrapper">
        <div id="right">
            <div id="language">

                <select class="form-select" name="lang" onchange="ChangeLanguage()" id="lang">
                    <?php
                    $fp = file($db_path . "opac_conf/$lang/lang.tab");
                    foreach ($fp as $value) {
                        if (trim($value) != "") {
                            $a = explode("=", $value);
                            echo "<option value=" . $a[0];
                            if ($lang == $a[0]) echo " selected";
                            echo ">" . trim($a[1]) . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <!-- end #menu -->
        </div>


    <?php
}
    ?>
    </nav>