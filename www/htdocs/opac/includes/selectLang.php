<?php

function selectLang() {
    global $lang, $db_path;
?>
    <div id="menu-wrapper">
        <div id="right">
            <div id="language">

                <select class="form-select bg-white text-dark" name="lang" onchange="ChangeLanguage()" id="lang">
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
    </div>
<?php
}