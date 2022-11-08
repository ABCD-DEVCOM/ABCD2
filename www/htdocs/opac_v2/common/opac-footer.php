    </main>
  </div>
</div>					
					<!--ESTO SE CAMBIO PARA PODER INSERTAR EL NUEVO FOOTER -->
					<?php
					if (file_exists($db_path . "opac_conf/" . $lang . "/footer.info")) {
						$fp = file($db_path . "opac_conf/" . $lang . "/footer.info");
						foreach ($fp as $value) {
							$value = trim($value);
							if ($value != "") {
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
						echo '<footer class="py-3 my-4 border-top pb-3 mb-3">';
						echo $footer;
						echo '</footer>';
					}
					?>
					<!-- end #footer -->



	<?php include($_SERVER['DOCUMENT_ROOT'] . "/".$opac_path."/forms.php"); ?>				
    <script src="/"<?php echo $opac_path;?>"/assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script>
  </body>
</html>					