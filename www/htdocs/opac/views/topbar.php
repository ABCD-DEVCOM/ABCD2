<header id="header" class="navbar navbar-primary custom-top-link <?php if ($topbar=="sticky-top") echo "sticky-top";?> p-1 mb-3 d-flex shadow bg-white">
  <div class="container<?php echo $container;?>">
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
          <li class="nav-item">
            <a href="javascript:clearAndRedirect('<?php echo $link_logo ?>')" class="nav-link text-dark custom-top-link" aria-current="page">
              <?php echo $msgstr["front_inicio"] ?>
            </a>
          </li>

           <?php
                if (file_exists($db_path . "opac_conf/" . $lang . "/menu.info")) {
                    $fp = file($db_path . "opac_conf/" . $lang . "/menu.info");
                    foreach ($fp as $value) {
                        $value = trim($value);
                        if ($value != "") {
                            $x = explode('|', $value);
                            echo "<li class=\"nav-item\"><a class=\"nav-link  text-dark custom-top-link\" href=\"" . $x[1] . "\"";
                            if (isset($x[2]) and $x[2] == "Y") echo " target=_blank";
                            echo ">" . $x[0] . "</a></li>";
                        }
                    }
                }

            if (file_exists("opac_dbpath.dat")) echo '<li class="nav-item"><a  class="nav-link  text-dark" href="../index.php">Cambiar carpeta bases</a></li>';

        ?>


      </ul>
 
      <?php darkMode ();?>
      <?php fontSize()?>
      <?php selectLang()?>

    <?php } ?>
    
   

    	<?php
	if (!file_exists($db_path . "opac_conf/".$lang."/lang.tab")) {
		echo $msgstr["front_missing"] . " " . $db_path . "opac_conf/".$lang."/lang.tab";
		die;
	}
	?>
  </div>

</header>

