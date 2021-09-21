<?php
/* Modifications
20210312 fho4abcd show also charset if different from metaencoding
20210312 logout without [] to visually detect this script
20210415 fho4abcd Show db characterset if available, otherwise meta characterset. No longer show difference
*/
?>
<div class=heading>
	<div class="institutionalInfo">
		<img src=<?php if (isset($logo))
								echo $logo;
							else
								echo "../../assets/images/logoabcd.png";
					  ?>>
					  <h1><?php if (isset($institution_name)) echo $institution_name;?></h1>
    </div>
		<div class="heading-database">
		<?php	
			if ($central=="Y") {
						if ($_SESSION["MODULO"]=="catalog")  {
		?>
							<form name="admin" action="../dataentry/inicio_main.php" method="post">
							<input type=hidden name=encabezado value=s>
							<input type=hidden name=retorno value="../common/inicio.php">
							<input type=hidden name=modulo value=catalog>
							<input type=hidden name=screen_width>
							<?php if (isset($arrHttp["newindow"]))
							echo "<input type=hidden name=newindow value=Y>\n";?>

								<select class="heading-database" name=base  id="selbase" class="textEntry singleTextEntry" onchange="doReload(this.value)">
									<option value=""><?php echo $msgstr["seleccionar"]?></option>
									<?php
									$i=-1;
									foreach ($lista_bases as $key => $value) {
										$xselected="";
										$value=trim($value);
										$t=explode('|',$value);
										if (isset($Permiso["db_".$key]) or isset($_SESSION["permiso"]["db_ALL"]) or isset($_SESSION["permiso"]["CENTRAL_ALL"])){
											if (isset($arrHttp["base"]) and $arrHttp["base"]==$key or count($lista_bases)==1) $xselected=" selected";
											echo "<option value=\"$key|adm|$value\" $xselected>".$t[0]."\n";
										}
									}
									?>
								</select>
							</form>
			

		<?php
					} 

		}


		if ($verify_selbase=="Y") {

			if ($_SESSION["mfn_admin"]=="1") {

		?>

			<form name=OpcionesMenu>
			<input type=hidden name=base value="">
			<input type=hidden name=cipar value="">
			<input type=hidden name=marc value="">
			<input type=hidden name=tlit value="">
			<input type=hidden name=nreg value="">
			<input type=hidden name=lang value="">

			<select class="heading-database" name="baseSel" onchange="CambiarBase()" onclick="VerificarEdicion()">
			<option value=""></option>
			<?php
			$i=-1;
			$hascopies="";
			foreach ($lista_bases as $key => $value) {
				$xselected="";
				$t=explode('|',$value);
				if (isset($_SESSION["permiso"]["db_".$key]) or isset($_SESSION["permiso"]["db_ALL"]) or isset($_SESSION["permiso"]["CENTRAL_ALL"]) or  isset($_SESSION["permiso"][$key."_CENTRAL_ALL"])){
					if (isset($arrHttp["base_activa"])){
						if ($key==$arrHttp["base_activa"]) 	{
							$xselected=" selected";
							if (isset($t[1])) $hascopies=$t[1];
						}

					}
					if (!isset($t[1])) $t[1]="";
					echo "<option value=\"$key|adm|".$t[1]."\" $xselected>".$t[0]."\n";
				}
			}
			echo "</select>" ;
			if ($hascopies=="Y" and (isset($_SESSION["permiso"]["CENTRAL_ADDCO"]) or isset($_SESSION["permiso"]["CENTRAL_ALL"]) or  isset($_SESSION["permiso"][$arrHttp["base"]."_CENTRAL_ALL"]) or isset($_SESSION["permiso"][$arrHttp["base"]."_CENTRAL_ADDCO"]))){
				echo "\n<script>top.db_copies='Y'\n</script>\n";
			}
			?>
			</form>
		<?php } } ?>
		</div>



    <nav class="heading-nav">
    <ul>
			 <?php
				$central="";
				$circulation="";
				$acquisitions="";

			foreach ($_SESSION["permiso"] as $key=>$value){
				$p=explode("_",$key);
				if (isset($p[1]) and $p[1]=="CENTRAL") $central="Y";
				if (substr($key,0,8)=="CENTRAL_")  $central="Y";
				if (substr($key,0,5)=="CIRC_")  $circulation="Y";
				if (substr($key,0,4)=="ACQ_")  $acquisitions="Y";
			}

			if ($circulation=="Y" or $acquisitions=="Y" or $central=="Y"){
			if ($central=="Y") {
			if ($_SESSION["MODULO"]=="catalog") $style_cat="active";
		  	?>			
            <li>
            	<form>
            		<button class="bt-mod bt-cat <?php echo $style_cat;?>" type="submit" name=modulo value="catalog" onclick="Modulo();" title="<?php echo $msgstr["modulo"]." ".$msgstr["catalogacion"];?>"></button>
            	</form>
            </li>
		  	<?php
		  	}
		   	if ($circulation=="Y") {
		  		if ($_SESSION["MODULO"]=="loan") $style_loan="active";
		  	?>
            <li>
            	<form>
            		<button class="bt-mod bt-loan <?php echo $style_loan;?>" type="submit" name=modulo value="loan" onclick="Modulo();" title="<?php echo $msgstr["modulo"]." ".$msgstr["prestamo"];?>"></button>
            	</form>
            </li>
		  	<?php
		  	}
		  	if ($acquisitions=="Y") {
		  		if ($_SESSION["MODULO"]=="acquisitions") $style_acq="active";
		  	?>
            <li>
  	<?php
  	}
}
?>
            	<form>
            		<button class="bt-mod bt-acq <?php echo $style_acq;?>" type="submit" name=modulo value="acquisitions" onclick="Modulo();" title="<?php echo $msgstr["modulo"]." ".$msgstr["acquisitions"];?>"></button>
            	</form>
            </li>
            <li><a href="#"><img src="../../assets/images/svg/ic_fluent_globe_28_regular.svg"></a>
            <!-- First Tier Drop Down -->
            <ul>
				<form name=cambiolang class="lang">
				        <?php
				        include "../common/inc_get-langtab.php";
				        $a=get_langtab();
				        $fp=file($a);
				        $selected="";
				        foreach ($fp as $value){
				            $value=trim($value);
				            if ($value!=""){
				                $l=explode('=',$value);
				                if ($l[0]!="lang"){
				                    
				                    echo "<li><button name=\"lang\" type=\"submit\" value='".$l[0]."' onclick=\"CambiarLenguaje()\" >".$msgstr[$l[0]]."</button></li>";
				                    
				                }
				            }
				        }
				        ?>
				</form>
            </ul>        
            </li>
            <li>
            	<a class="bt-charset" href="#">
            		<?php
		              if ( isset( $charset )) {
		                  echo $charset;
		              } else {
		                  echo $meta_encoding;
		              }
		            ?>	
            	</a>
            </li>
            <li><a href="#"><img src="../../assets/images/svg/ic_fluent_person_28_regular.svg"></a>
            <!-- First Tier Drop Down -->
            <ul>
                <li><a href="#"><?php echo $_SESSION["nombre"]?> (<?php echo $_SESSION["profile"]?>)</a></li>
                <li><a href="#"><?php  $dd=explode("/",$db_path);
               if (isset($dd[count($dd)-2]) and $dd[count($dd)-2]!=""){
			   		$da=$dd[count($dd)-2];
			   		echo $da;
				}else{
					echo $db_path;
				}?></a></li>
            </ul>        
            </li>
            
            <li>
            	<a class="bt-exit" href="../dataentry/logout.php"><img src="../../assets/images/svg/ic_fluent_sign_out_24_regular.svg"></a>
            </li>
        </ul>
    </nav>

</div>

