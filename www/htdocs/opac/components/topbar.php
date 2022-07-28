<?php
if (!isset($mostrar_menu) or (isset($mostrar_menu) and $mostrar_menu == "S")) {
?>
<div class="col-3">
    <select name="lang" class="form-select form-select-sm bg-primary text-white align-self-end" onchange="ChangeLanguage()" id="lang">
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

      <ul class="nav nav-pills">
        <li class="nav-item"><a href="javascript:document.inicio_menu.submit()" class="nav-link text-white" aria-current="page"><?php echo $msgstr["inicio"] ?></a></li>


        <?php
        if (file_exists($db_path . "opac_conf/" . $lang . "/menu.info")) {
            $fp = file($db_path . "opac_conf/" . $lang . "/menu.info");
            foreach ($fp as $value) {
                $value = trim($value);
                if ($value != "") {
                    $x = explode('|', $value);
                    echo '<li class="nav-item"><a class="nav-link text-white" href="' . $x[1] . '"';
                    if (isset($x[2]) and $x[2] == "Y") echo " target=_blank";
                    echo ">" . $x[0] . "</a></li>";
                }
            }
        }

        ?>
            <li class="nav-item">
                <?php 
                if (isset($_SESSION['nombre'])){ 
                echo '<a class="nav-link text-white" href="#"'.utf8_encode($_SESSION['nombre']).'</a>';
                } else {
                echo '<a class="nav-link text-white" href="/mysite?mode=opac">Sign</a>';
                }?>
            </li>

            </ul>



    <?php
}
    ?>
