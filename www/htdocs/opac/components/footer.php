	</div>
</div>

</main>

<!-- end #content -->

				</div>
				<a name="final">
					</div>

					<!--ESTO SE CAMBIO PARA PODER INSERTAR EL NUEVO FOOTER -->
					<?php
					if (file_exists($db_path . "opac_conf/" . $lang . "/footer.info")) {
						$fp = file($db_path . "opac_conf/" . $lang . "/footer.info");
						foreach ($fp as $value) {
							$value = trim($value);
							if ($value != "") {
								if (substr($value, 0, 6) == "[LINK]") {
									$home_link = substr($value, 6);
									$hl = explode('|||', $home_link);
									$home_link = $hl[0];
									if (isset($hl[1]))
										$height_link = $hl[1];
									else
										$height_link = 800;
									$footer = "LINK";
								}
								if (substr($value, 0, 6) == "[TEXT]") {
									$home_text = substr($value, 6);
									$footer = "TEXT";
								}

								if (substr($value, 0, 6) == "[HTML]") {
									$home_text = substr($value, 6);
									$footer = "HTML";
								}
							}
						}
						switch ($footer) {
							case "LINK":

					?>
					<div>
						<iframe src="<?php echo $home_link ?>" frameborder="0" scrolling="no" width=100% height="<?php echo $height_link ?>" />
						</iframe>
					</div>
					<?php break;
							case "TEXT":
								$fp = file($db_path . "opac_conf/" . $lang . "/footer.info");
								foreach ($fp as $v) {
									echo str_replace("[TEXT]", "", $v);
								}
								break;
							case "HTML":
								$fp = file($db_path . "opac_conf/" . $lang . "/footer.info");
								foreach ($fp as $v) {
									echo str_replace("[HTML]", "", $v);
								}
								break;
						}
					} else {
						echo "<footer id=\"footer\">\n";
						echo $footer;
						echo "</footer>\n";
					}
					?>
					<!-- end #footer -->
					
					</body>


					</html>


	<script type='text/javascript' src="<?php echo $OpacHttp;?>assets/js/slick.min.js?<?php echo time(); ?>"></script>

<script>

console.log('OPAC ABCD Version: 1.1.0-beta 20230326');

jQuery(function(){
    jQuery(document).on( 'scroll', function(){
        if (jQuery(window).scrollTop() > 100) {
            jQuery('.smoothscroll-top').addClass('show');
        } else {
            jQuery('.smoothscroll-top').removeClass('show');
        }
    });
    jQuery('.smoothscroll-top').on('click', scrollToTop);
});

function scrollToTop() {
    verticalOffset = typeof(verticalOffset) != 'undefined' ? verticalOffset : 0;
    element = jQuery('body');
    offset = element.offset();
    offsetTop = offset.top;
    jQuery('html, body').animate({scrollTop: offsetTop}, 600, 'linear').animate({scrollTop:25},200).animate({scrollTop:0},150) .animate({scrollTop:0},50);
}

</script>
</section>

        <div class="smoothscroll-top show">
            <span class="scroll-top-inner">
                <i class="fas fa-chevron-up"></i>
            </span>
        </div>


<?php include("forms.php");?>