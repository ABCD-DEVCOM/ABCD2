<?php
//foreach ($_REQUEST AS $var=>$value) echo "$var=$value<br>";
if (isset($_REQUEST["conf_level"])) unset($_REQUEST["conf_level"]);
if (isset($_REQUEST["lang_init"])){
	$_SESSION["lang_init"]=$_REQUEST["lang_init"];
	unset($_REQUEST["lang_init"]);
}
$wiki_help="wiki.abcdonline.info/index.php?desde=help&title=OPAC-ABCD_Detalles_de_la_configuraci%C3%B3n#Men.C3.BA_de_configuraci.C3.B3n";
$wiki_trad="wiki.abcdonline.info/index.php?title=OPAC-ABCD_Detalles_de_la_configuraci%C3%B3n#Men.C3.BA_de_configuraci.C3.B3n";
if (isset($_REQUEST["lang"])) $lang=$_REQUEST["lang"];
if (!isset($_SESSION["showhelp"])){
	if (isset($_REQUEST["showhelp"])){
		if ($_REQUEST["showhelp"]=="Y"){
			$_SESSION["showhelp"]="Y";
		}else{
			$_SESSION["showhelp"]="N";
		}
	}else{
		$_SESSION["showhelp"]="N";
	}
}
if ($_SESSION["showhelp"]=="Y")
	$showhelp="block";
else
	$showhelp="none";
?>

<style>
nav {
  display: block;
  background:#354C6C;
  width:100%;
  float:left;
  margin-top:0px;
}
nav ul {
  margin: 0;
  padding:0;
  list-style: none;
}
.nav a {
  display:block;
  background:#354C6C;
  color: #fff;
  text-decoration: none;
  padding: 0.3em 1.8em;
  xtext-transform: uppercase;
  font-size: 75%;
  xletter-spacing: 1px;
  xtext-shadow: 0 -1px 0 #000;
  position: relative;
}
.nav{
  vertical-align: top;
  xdisplay: inline-block;
  xbox-shadow:
    1px -1px -1px 1px #000,
    -1px 1px -1px 1px #fff,
    0 0 6px 3px #fff;
  border-radius:6px;
}
.nav li {
  position: relative;
}
.nav > li {
  float: left;
  border-bottom: 4px #aaa solid;
  margin-right: 1px;
}
.nav > li > a {
  margin-bottom: 1px;
 xbox-shadow: inset 0 2em .33em -0.5em #555;
}
.nav > li:hover,
.nav > li:hover > a {
  border-bottom-color: orange;
}
.nav li:hover > a {
  color:orange;
}
.nav > li:first-child {
  border-radius: 4px 0 0 4px;
}
.nav > li:first-child > a {
  border-radius: 4px 0 0 0;
}
.nav > li:last-child {
  border-radius: 0 0 4px 0;
  margin-right: 0;
}
.nav > li:last-child > a {
  border-radius: 0 4px 0 0;
}
.nav li li a {
  xmargin-top: 1px;
  border-bottom:0.5px solid #cccccc;
  border-left:0.5px solid #cccccc;
  border-right:0.5px solid #cccccc;
}

.nav li a:first-child:nth-last-child(2):before {
  content: "";
  position: absolute;
  height: 0;
  width: 0;
  border: 5px solid xtransparent;
  top: 50% ;
  right:5px;
 }

/* submenu positioning*/
.nav ul {
  position: absolute;
  white-space: nowrap;
  border-bottom: 5px solid  orange;
  z-index: 1;
  left: -99999em;
}
.nav > li:hover > ul {
  left: auto;
  margin-top: 5px;
  min-width: 100%;
}
.nav > li li:hover > ul {
  left: 100%;
  margin-left: 1px;
  top: -1px;
}
/* arrow hover styling */
.nav > li > a:first-child:nth-last-child(2):before {
  border-top-color: #aaa;
}
.nav > li:hover > a:first-child:nth-last-child(2):before {
  border: 5px solid xtransparent;
  border-bottom-color: orange;
  margin-top:-5px
}
.nav li li > a:first-child:nth-last-child(2):before {
  border-left-color: #aaa;
  margin-top: -5px
}
.nav li li:hover > a:first-child:nth-last-child(2):before {
  border: 5px solid xtransparent;
  border-right-color: orange;
  right: 10px;
}

</style>
<script>
	function EnviarCopia(){
		if (document.copiar_a.lang_to.options[document.copiar_a.lang_to.selectedIndex].value=="<?php echo $_REQUEST["lang"]?>"){
			alert("<?php echo $msgstr["sel_o_l"]?>")
			return false
		}
		if (document.copiar_a.replace_a[0].checked || document.copiar_a.replace_a[1].checked ){
			document.copiar_a.submit()
		}else{
			alert("<?php echo $msgstr["missing"]." ".$msgstr["sustituir_archivos"];?>")
			return false
		}
	}
</script>
<?php
if (!isset($_REQUEST["db_path"])){
	$_REQUEST["db_path"]=$db_path;
	$_REQUEST["db_path_desc"]="$db_path";
}
if (isset($_REQUEST["db_path"])) {
	$_SESSION["db_path"]=$_REQUEST["db_path"];
	$_SESSION["db_path_desc"]=$_REQUEST["db_path"];
}
if (isset($_REQUEST["lang"])) $_SESSION["lang"]=$_REQUEST["lang"];


//foreach ($_REQUEST AS $var=>$value) echo "$var=$value<br>"; die;

?>
<form name=form_lang method=post>
<nav>
  <div style=width:65%;background:red>
  <ul class="nav">
  <?php
	if (isset($_SESSION["lang_init"]))
		$l_init=$_SESSION["lang_init"];
	else
		$l_init=$_REQUEST["lang"];
	echo "<li><a href=\"index.php?lang=".$l_init."\">LogOut</a></li>";?>
    <li><a href="#">General</a>
      <ul>
        <li><a href="javascript:EnviarForma('diagnostico.php')"><?php echo $msgstr["check_conf"];?></a></li>
        <li><a href="javascript:EnviarForma('parametros.php')"><?php echo $msgstr["parametros"];?></a></li>
        <li><a href="javascript:EnviarForma('lenguajes.php')"><?php echo $msgstr["available_languages"];?></a></li>
        <li><a href="javascript:EnviarForma('databases.php')"><?php echo $msgstr["databases"];?></a></li>
        <li><a href="javascript:EnviarForma('record_toolbar.php')"><?php echo $msgstr["rtb"];?></a></li>
        <li><a href=#><?php echo $msgstr["meta_schema"]?> </a>
          <ul>
            <li><a href="javascript:EnviarForma('marc_scheme.php')"><?php echo $msgstr["xml_marc"];?></a></li>
            <li><a href="javascript:EnviarForma('dc_scheme.php')"><?php echo $msgstr["xml_dc"];?></a></li>
          </ul>
        </li>
      </ul>
    </li>
<?php
if (file_exists($db_path."opac_conf/".$_REQUEST["lang"]."/bases.dat") and file_exists($db_path."opac_conf/".$_REQUEST["lang"]."/lang.tab")){
?>
    <li><a href="#"><?php echo $msgstr["db_configuration"] ?></a>
<?php
	echo "<ul>";

	if (!file_exists($db_path."opac_conf/".$_REQUEST["lang"]."/bases.dat")){		echo "<font color=red>".$msgstr["missing"]."opac_conf/".$_REQUEST["lang"]."/bases.dat";
	}else{
		$fp=file($db_path."opac_conf/".$_REQUEST["lang"]."/bases.dat");
		$cuenta=0;
		foreach ($fp as $value){
			if (trim($value)!=""){
				$cuenta=$cuenta+1;
				$x=explode('|',$value);
				//echo "<li><a href=\"javascript:SeleccionarBase('".$x[0]."')\">".$x[1]."</li>\n";
				echo "<li><a href=#>".$x[1]." (".$x[0].")</a>\n";
				$base=$x[0];
				echo "<ul>";
				?>
            	<li><a href="javascript:SeleccionarProceso('busqueda_libre.php','<?php echo $base?>')"><?php echo $msgstr["free_search"];?></a></li>
				<li><a href="javascript:SeleccionarProceso('busqueda_avanzada.php','<?php echo $base?>')"><?php echo $msgstr["buscar_a"];?></a></li>
				<li><a href="javascript:SeleccionarProceso('formatos_salida.php','<?php echo $base?>')"><?php echo $msgstr["select_formato"];?></a></li>
				<li><a href="javascript:SeleccionarProceso('dbn_par.php','<?php echo $base?>')"><?php echo $msgstr["dbn_par"];?></a></li>
				<li><a href="javascript:SeleccionarProceso('facetas_cnf.php','<?php echo $base?>')"><?php echo $msgstr["facetas"];?></a></li>


				<li><a href=#><?php echo $msgstr["conf_a"]?></a>
				<ul>
				<li><a href="javascript:SeleccionarProceso('alpha_ix.php','<?php echo $base?>')"><?php echo $msgstr["indice_alfa"];?></a></li>
				<li><a href="javascript:SeleccionarProceso('autoridades.php','<?php echo $base?>')"><?php echo $msgstr["aut_opac"];?></a></li>
				<li><a href="javascript:SeleccionarProceso('tipos_registro.php','<?php echo $base?>')"><?php echo $msgstr["tipos_registro"];?></a></li>
				<li><a href="javascript:SeleccionarProceso('busqueda_avanzada_tr.php','<?php echo $base?>')"><?php echo $msgstr["buscar_a"]." - ". $msgstr["tipos_registro"];?></a></li>
				<li><a href="javascript:SeleccionarProceso('presentacion_base.php','<?php echo $base?>')"><?php echo $msgstr["base_home"];?></a></li>
				 </ul></li>
				 </ul></li>

<?php		}
		}
		if ($cuenta>1){
			echo "<li><a href=#><strong>".$msgstr["metasearch"]."</strong></a>";
			echo "<ul>";
		?>
  			<li><a href="javascript:SeleccionarProceso('busqueda_libre.php','META')"><?php echo $msgstr["free_search"];?></a></li>
			<li><a href="javascript:SeleccionarProceso('busqueda_avanzada.php','META')"><?php echo $msgstr["buscar_a"];?></a></li>
    		<li><a href="javascript:SeleccionarProceso('facetas_cnf.php','META')"><?php echo $msgstr["facetas"];?></a></li>
    		<li><a href="javascript:SeleccionarProceso('alpha_ix.php','META')"><?php echo $msgstr["indice_alfa"];?></a></li>
    		</ul></li>
<?php }
}
?>

</li>
</ul>

    <li><a href="#"><?php echo $msgstr["loan_conf"]?></a>
    <ul>
		<li><a href="javascript:EnviarForma('statment_cnf.php')"><?php echo $msgstr["ONLINESTATMENT"]?></a></li>
		<li><a href="javascript:EnviarForma('renovation_cnf.php')"><?php echo $msgstr["WEBRENOVATION"]?></a></li>
		<li><a href="javascript:EnviarForma('reservations_cnf.php')"><?php echo $msgstr["WEBRESERVATION"]?></a></li>
	</ul>
    </li>

    <li><a href="#"><?php echo $msgstr["apariencia"];?></a>
      <ul>
			<li><a href="javascript:EnviarForma('pagina_inicio.php')"><?php echo $msgstr["first_page"]?></a></li>
			<li><a href="javascript:EnviarForma('footer_cfg.php')"><?php echo $msgstr["footer"]?></a></li>
			<li><a href="javascript:EnviarForma('sidebar_menu.php')"><?php echo $msgstr["sidebar_menu"]?></a></li>
			<li><a href="javascript:EnviarForma('horizontal_menu.php')"><?php echo $msgstr["horizontal_menu"]?></a></li>
			<li><a href="javascript:EnviarForma('presentacion.php')"><?php echo $msgstr["pagina_presentacion"];?></a></li>
			<li><a href="javascript:EnviarForma('opac_msgs.php')"><?php echo $msgstr["sys_msg"];?></a></li>
	</ul>
    </li>

  </ul>
 <?php }?>
  </div>


	<div id=right>

		<div id="language"><?php echo $msgstr["lang"];?>

			<select name=lang onchange=document.form_lang.submit() id=lang >
				<?php
					$archivo=$db_path."opac_conf/$lang/lang.tab";
					if (file_exists($archivo)){
						$fp=file($archivo);
						foreach ($fp as $value){
							if (trim($value)!=""){
								$a=explode("=",$value);
								echo "<option value=".$a[0];
								if ($lang==$a[0]) echo " selected";
								echo ">".trim($a[1])."</option>";
							}
						}
						unset($fp);
					}else{
						echo "<option value=$lang selected>$lang</option>";
					}

				?>
			</select>

		</div>
		<!--div id="back">
			<a href="<?php if (isset($url_back)) echo $url_back; else echo 'menu.php?';?>lang=<?php echo $_REQUEST["lang"];
			 if (isset($_REQUEST["conf_level"]) and $_REQUEST["conf_level"]=="advanced") echo '&conf_level='.$_REQUEST["conf_level"]
			 ?>"><img src=../images_config/defaultButton_back.png alt=<?php echo $msgstr["back"];?> title=<?php echo $msgstr["back"];?>></a>
		</div-->
		</div>
		</DIV>
		</nav>
        </form>
</div>
<form name=opciones_menu method=post>
<?php if (isset($_REQUEST["conf_level"])){
	echo "<input type=hidden name=conf_level value=".$_REQUEST["conf_level"].">\n";
}?>
<input type=hidden name=base>
<input type=hidden name=lang value=<?php echo $_REQUEST["lang"]?>>
<input type=hidden name=db_path value=<?php echo $_REQUEST["db_path"]?>>
</form>