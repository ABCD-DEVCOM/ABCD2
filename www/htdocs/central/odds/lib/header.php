	<script languaje=javascript>
		function CambiarLenguaje() {			
			if (document.getElementById('cambialenguaje').selectedIndex > 0 ) {
				lang=document.getElementById('cambialenguaje').options[document.getElementById('cambialenguaje').selectedIndex].value;	
				self.location.href="<?php echo $filename ?>?lang="+lang;				
			}
		}	
	</script>	
<?php
include_once("lib/library.php");
$header_messages = load_header_messages($lang);
$a = explode( "/", $_SERVER['PHP_SELF']);
$filename = $a[count($a)-1];
//die($filename);
?>

<div class="heading">
	<div class="institutionalInfo">
		<h1><img src=../images/logoabcd.jpg><?php echo $header_messages['institution_name']; ?></h1>
	</div>
	<div class="userInfo">
		<span><!-- NOMBRE DE USUARIO NO APLICA --></span>		
	</div>
	<div class="spacer">&#160;</div>
</div>

<div class="language">
	<form name=cambiolang class = "language"> &nbsp; &nbsp; <?php echo$header_messages['lang']; ?>
		<select name=cambialenguaje id = 'cambialenguaje' style="width:140;font-size:10pt;font-family:arial narrow" onchange=CambiarLenguaje()>
			<option value=""></option>
			<?php
				if ($lang == 'es') {
					echo "<option value=en>Inglés</option>";
					echo "<option value=es selected>Español</option>";
					
				// ¡por defecto INGLÉS!
				} else {
					echo "<option value=en selected>English</option>";
					echo "<option value=es>Spanish</option>";				
				}
			?>
		</select>
	</form>	
</div>

<div class="sectionInfo">
	<div class="breadcrumb">
		<h3><?php echo $header_messages['module_name']; ?></h3>
	</div>
	<div class="spacer">&#160;</div>
</div>

<div class="helper">
	<a href="../documentacion/ayuda.php?help=en/homepage.html" target="_blank"><?php echo $header_messages['help']; ?></a>&nbsp &nbsp;
	<a href=../documentacion/edit.php?archivo=en/homepage.html target=_blank><?php echo $header_messages['edit_help_file']; ?></a>
	<font color=white>&nbsp; &nbsp; Script: 
		<?php 
			$a = explode("/", $_SERVER['PHP_SELF']); 
			echo $a[(count($a)-1)];	
		?> 
	</font>	
	<div class="spacer">&#160;</div>
</div>