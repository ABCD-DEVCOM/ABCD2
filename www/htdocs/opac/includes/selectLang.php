<?php
function selectLang()
{
    global $lang, $db_path;

    // Define $lang2 com fallback
    $lang2 = $_REQUEST['lang'] ?? $lang;

    // Garante que $lang seja uma das pastas disponíveis
    if (!file_exists($db_path . "opac_conf/$lang2/lang.tab")) {
        $lang2 = "en"; // ou outro idioma padrão
    }
?>

    <form name="changelanguage" method="get" style="display:none;">
        <input type="hidden" name="lang" value="<?php echo $lang2; ?>">
    </form>

    <div id="menu-wrapper">
        <div id="right">
            <div id="language">
                <select class="form-select bg-white text-dark" name="lang" onchange="ChangeLanguage()" id="lang">
                    <?php
                    $fp = file($db_path . "opac_conf/$lang2/lang.tab");
                    foreach ($fp as $value) {
                        if (trim($value) != "") {
                            $a = explode("=", $value);
                            $code = trim($a[0]);
                            $label = trim($a[1]);
                            $selected = ($lang2 == $code) ? "selected" : "";
                            echo "<option value=\"$code\" $selected>$label</option>";
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
    </div>

<?php
}
?>