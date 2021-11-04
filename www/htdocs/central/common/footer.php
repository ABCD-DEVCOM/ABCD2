<?php
/* Modifications
20210428 fho4abcd System info has latest release & date (not dynamic, so must be fixed every release)
20210610 fho4abcd update date. Remove wiki (done by URL1 and all pages
20210626 fho4abcd MOve logo from css to php +span to title.
*/
        require_once (dirname(__FILE__)."/../config.php");
        $def = parse_ini_file($db_path."abcd.def");
        //print_r($def);
        ?>

		<div class="footer">
			<div class="systemInfo">
				<span><b>ABCD v2.2.0-beta-0</b> + ... &rarr; 2021-11-04</span>
				<span><?php if (isset($def["LEGEND1"])) echo $def["LEGEND1"]; ?></span>
				<?php if(isset($def["URL1"])){
					echo "<a href=".$def["URL1"]." target=_blank>". $def["URL1"]."</a>";
				}
				if(isset($def["URL3"])){
					echo "<a href=".$def["URL3"]." target=_blank>". $def["LEGEND3"]."</a>";
				}
				?>
			</div>
			<?php
			if (!isset($def["LEGEND2"])) $def["LEGEND2"]=$def["LEGEND1"];
			if (isset($def["URL2"])){
                ?>
                <div class="distributorLogo">
                    <a  href=<?php echo $def["URL2"]." target=_blank"?>>
                        <img src='/assets/images/distributorLogo.png' 
                        title='<?php if (isset($def["LEGEND2"])) echo $def["LEGEND2"]?>'>
                    </a>
                </div>
                <?php
			}
			?>
			<div class="spacer">&#160;</div>
		</div>

</body>
</html>