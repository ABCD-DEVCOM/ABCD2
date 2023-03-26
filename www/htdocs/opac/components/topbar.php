<header class="navbar navbar-primary sticky-top p-1 mb-3 d-flex shadow bg-white">
  <div class="container">
    <a id="logo" name="inicio" href="<?php echo $link_logo ?>?lang=<?php echo $lang; ?>" class="navbar-brand p-0 me-0 me-lg-2">
	<?php if (isset($logo)) { ?>
    	<img class="p-2" style="max-height:70px;" src="<?php echo $logo ?>" title="<?php echo $TituloEncabezado;?>">
    <?php } else { ?>	
		<span class="fs-4"><?php echo $TituloEncabezado;?></span>
	<?php } ?>	
    </a>

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

            if (file_exists("opac_dbpath.dat")) echo '<li class="nav-item"><a  class="nav-link" href="../index.php">Cambiar carpeta bases</a></li>';

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

    	<?php
	if (!file_exists($db_path . "opac_conf/$lang/lang.tab")) {
		echo $msgstr["missing"] . " " . $db_path . "opac_conf/$lang/lang.tab";
		die;
	}
	?>
  </div>
</header>