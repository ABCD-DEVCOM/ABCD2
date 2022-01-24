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
				<span class="institutionName">
					<a href="
					<?php 
					if (isset($def["INSTITUTION_URL"])) {
						echo $def["INSTITUTION_URL"];
					} else {
						echo "//abcd-community.org";
					}
					?>" target="_blank">

					<?php 
						function randomName() {
						    $names = array(
						        'Automatisaci&oacute;n de Bibliot&eacute;cas y Centros de Documentaci&oacute;n',
						        'Automation des Biblioth&eacute;ques et Centres de Documentacion',
						        'Automatiza&ccedil;&atilde;o das Bibliotecas e dos Centros de Documenta&ccedil;&atilde;o',
						        'Automatisering van Bibliotheken en Centra voor Documentatie',
						        // and so on

						    );
						    return $names[rand ( 0 , count($names) -1)];
						}

					if (isset($def["INSTITUTION_NAME"])) {
						echo $def["INSTITUTION_NAME"]; 
					} else {
						echo "ABCD | ".randomName();
					}?>
				</a>
				</span>				

				<?php 

				if(isset($def["TEXT1"])){
					$text1 = $def["TEXT1"];

				} else {
					$text1 = "ONLY FOR TESTING - NOT FOR DISTRIBUTION";
				}


				if ((isset($def["URL1"])) && (isset($def["TEXT1"]))) {
					$url1 = $def["URL1"];
					echo "<span><small><a href=".$def["URL1"]." target=_blank>".$def["TEXT1"]."</a></small></span>";					

				} elseif (isset($def["URL1"])) {
					echo "<span><small><a href=".$def["URL1"]." target=_blank>".$def["URL1"]."</a></small></span>";	
				} else {
					$url1 = "";
				}




				if(isset($def["URL2"])){
					$url2 = $def["URL2"];
				} else {
					$url2 = "URL2";
				}

				if(isset($def["TEXT2"])){
					$text2 = $def["TEXT2"];
				} else {
					$text2 = "TEXT2";
				}

?>
				<span><small><a href="http://www.abcdwiki.net/" target="_blank">Wiki</a>  -  v2.2.0-beta-0 + ... &rarr; 2022-01-22</small></span>
			</div>

                <div class="distributorLogo">
                    <a  href="<?php 
                    if (isset($def["RESPONSIBLE_URL"])) {
                        	echo $def["RESPONSIBLE_URL"];
                        } else {
 							echo "//abcd-community.org";   
                        }
                    ?>" target="_blank" target="_blank"> 

                    <?php 
                     if ((isset($def["RESPONSIBLE_NAME"])) && (!empty($def["RESPONSIBLE_NAME"]))) {
                    	$responsible = $def["RESPONSIBLE_NAME"];
                	} else {
                    	$responsible = "ABCD Community";
                	}

                    if ((isset($def["RESPONSIBLE_LOGO"])) && (!empty($def["RESPONSIBLE_LOGO"]))) {
                    	echo "<img src='/assets/images/uploads/".$def["RESPONSIBLE_LOGO"]."' title='".$responsible."'>";
                    } else {
                    	echo "<img src='/assets/images/distributorLogo.png' title='ABCD Community'>";
                    }
                    ?>

                        
                    </a>
                </div>

			<div class="spacer">&#160;</div>
		</div>

</body>
</html>