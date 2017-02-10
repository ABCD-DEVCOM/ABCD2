<div class="heading">
	<div class="institutionalInfo">
		<h1><img src=<?php if (isset($logo))
								echo $logo;
							else
								echo "../images/logoabcd.jpg";
					  ?>
					  ><?php echo $institution_name?></h1>
	</div>
	<div class="userInfo">
		<span><?php echo $_SESSION["nombre"]?></span>,
		<?php echo $_SESSION["profile"]?> |
		<?php  $dd=explode("/",$db_path);
               if (isset($dd[count($dd)-2])){
			   		$da=$dd[count($dd)-2];
			   		echo " (".$da.") ";
				}
		?> |
<?php

if (isset($_SESSION["newindow"]) or isset($arrHttp["newindow"])){	echo "<a href='javascript:top.location.href=\"../dataentry/logout.php\";top.close()' xclass=\"button_logout\"><span>[logout]</span></a>";}else{	echo "<a href=\"../dataentry/logout.php\" xclass=\"button_logout\"><span>[logout]</span></a>";}
?>
	</div>
	<div class="spacer">&#160;</div>
</div>

