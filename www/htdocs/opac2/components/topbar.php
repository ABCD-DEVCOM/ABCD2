<?php
if (!isset($mostrar_menu) or (isset($mostrar_menu) and $mostrar_menu == "S")) {
?>

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

                <?php 
                if (isset($_SESSION['nombre'])){ 
                ?>    

<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle text-white" data-bs-toggle="dropdown" data-bs-placement="left" href="#" role="button" aria-expanded="false">
            <?php if(isset($_SESSION["photo"])) { ?>
            <img src="/central/common/show_image.php?image=images/<?php echo $_SESSION["photo"];?>&base=users" alt="mdo" width="32" height="32" class="rounded-circle">
            <?php } else { ?>
            <img src="/central/common/show_image.php?image=images/default-user-image.png&base=users" alt="mdo" width="32" height="32" class="rounded-circle">
            <?php } ?>
    </a>
    <ul class="dropdown-menu dropdown-menu-end">
      <li><a class="dropdown-item" href="#"><?php echo utf8_encode($_SESSION['nombre']);?></a></li>
      <li>        <select name="lang" class="form-select form-select-sm  align-self-end" onchange="ChangeLanguage()" id="lang">
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
        </select></li>
       <li><hr class="dropdown-divider"></li>
      <li><a class="dropdown-item" href="/mysite/common/index.php#reserves">Reserves</a></li>
      <li><a class="dropdown-item" href="/mysite/common/index.php#loans">Loans</a></li>
      <li><hr class="dropdown-divider"></li>
      <li><a class="dropdown-item" href="/mysite/common/index.php#">My Account</a></li>
      <li><a class="dropdown-item" href="/opac/common/opac-logout.php">Log Out</a></li>
    </ul>
  </li>
            </ul>

                <?php
                } else {
?>   
    <ul class="nav nav-pills">

        <li class="nav-item">
          <a href="/mysite?mode=opac" class="nav-link text-white"  aria-expanded="false">
            Sign
          </a>
        </li>
            <li><select name="lang" class="form-select form-select-sm bg-primary text-white align-self-end" onchange="ChangeLanguage()" id="lang">
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
        </select></li>
    </ul>

        <?php } ?>
    <?php } ?>
