<?php

        require_once (dirname(__FILE__)."/../config.php");
        $def = parse_ini_file($db_path."abcd.def");
        //print_r($def);
        ?>


		<div class="footermysite">
			<div class="systemInfo">
                <strong>ABCD <?php echo $def["VERSION"] ?></strong>
				<span><?php echo $def["LEGEND1"]; ?></span>
				<a href="<?php echo $def["URL1"]; ?>" target=_blank><?php echo $def["URL1"]; ?></a>
			</div>
			<div class="distributorLogo">
					<a href="<?php echo $def["URL2"]; ?>" target=_blank><span><?php echo $def["LEGEND2"]; ?></span></a>
			</div>
			<div class="spacer">&#160;</div>
		</div>