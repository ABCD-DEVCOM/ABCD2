        <?php
        if (isset($_REQUEST['action'])) {
            $t_action=$_REQUEST['action']; 
        } else {
            $t_action=""; 
        }

        ?>
        
        <div class="bg-light col-md-3 col-lg-2">
            <nav class="col-md-12 col-lg-12  bg-light sidebar">
                <div class="position-sticky pt-3">
                    <ul class="nav d-flex flex-nowrap d-lg-inline-block ">
                        <li class="nav-item">
                            <a class="nav-link <?php if  (($t_action=='free') or ($t_action=='')) echo "active";?>" href="/<?php echo $opac_path;?>/?action=free">
                                <span data-feather="shopping-cart" class="align-text-bottom"></span>
                                <?php echo $msgstr["free_search"];?>
                            </a>
                        </li>
                        <?php
		if (!isset($BusquedaAvanzada) or isset($BusquedaAvanzada) and $BusquedaAvanzada=="S"){
	?>
                        <li class="nav-item">
                            <a class="nav-link <?php if ($t_action=='advanced') echo "active ";?>" aria-current="page" href="/<?php echo $opac_path;?>/?action=advanced">
                                <span data-feather="home" class="align-text-bottom"></span>
                                <?php echo $msgstr["buscar_a"]?>
                            </a>
                        </li>
                        <?php } ?>
                        <li class="nav-item">
                            <a class="nav-link <?php if ($t_action=='diccionary') echo "active";?>" href="javascript:DiccionarioLibre(0)" >
                                <span data-feather="diccionario" class="align-text-bottom"></span>
                                <?php echo $msgstr["diccionario"]?>
                            </a>
                        </li>
                        <?php
	if (!isset($_REQUEST["submenu"]) or $_REQUEST["submenu"]!="N"){
		$archivo="";
		if (isset($modo)){
			if ($modo=="integrado"){
				$archivo=$db_path."/opac_conf/".$lang."/indice.ix";
			}else{
				$archivo=$db_path.$_REQUEST["base"]."/opac/".$lang."/".$_REQUEST["base"].".ix";
			}
		}
		if (file_exists($archivo)){
		?>
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="showhide('sub_menu')">
                                <span data-feather="file" class="align-text-bottom"></span>
                                <?php echo $msgstr["indice_alfa"];?>
                            </a>
                        </li>

                        <?php
		}
	}
?>
                    </ul>

                </div>
            </nav>
        </div>