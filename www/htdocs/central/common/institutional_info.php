<?php
/* Modifications
20210312 fho4abcd show also charset if different from metaencoding
20210312 logout without [] to visually detect this script
20210415 fho4abcd Show db characterset if available, otherwise meta characterset. No longer show difference
*/
?>
<div class="heading">
	<div class="institutionalInfo">
		<img src=<?php if (isset($logo))
								echo $logo;
							else
								echo "../images/logoabcd.png";
					  ?>
					  />
					  <h1>
					  	<?php if (isset($institution_name)) echo $institution_name;?>
					  </h1>
	</div>
	<div class="userInfo">
		<span><?php if (isset($_SESSION["nombre"])) echo $_SESSION["nombre"]?></span>,
		<?php if (isset($_SESSION["profile"])) {
			 		echo $_SESSION["profile"]."|";
					$dd=explode("/",$db_path);
               		if (isset($dd[count($dd)-2])){
			   			$da=$dd[count($dd)-2];
			   			echo " (".$da.") ";
					}
			  }
              if ( isset( $charset )) {
                  echo " | ".$charset;
              } else {
                  echo " | ".$meta_encoding;
              }
		?> |
<?php

if (isset($_SESSION["newindow"]) or isset($arrHttp["newindow"])){
	echo "<a href='javascript:top.location.href=\"../dataentry/logout.php\";top.close()' xclass=\"button_logout\"><span>[logout]</span></a>";
}else{
	echo "<a href=\"../dataentry/logout.php\" xclass=\"button_logout\"><span>logout</span></a>";
}
?>
	</div>
	<div class="spacer">&#160;</div>
</div>

