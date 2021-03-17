<?php
/* Modifications
20210312 fho4abcd show also charset if different from metaencoding
20210312 logout without [] to visually detect this script
*/
?>
<div class="heading">
	<div class="institutionalInfo">
		<h1><img src=<?php if (isset($logo))
								echo $logo;
							else
								echo "../images/logoabcd.jpg";
					  ?>
					  ><?php if (isset($institution_name)) echo $institution_name?></h1>
	</div>
	<div class="userInfo">
		<span><?php if (isset($_SESSION["nombre"])) echo $_SESSION["nombre"]?></span>,
		<?php if (isset($_SESSION["profile"])) {			 		echo $_SESSION["profile"]."|";
					$dd=explode("/",$db_path);
               		if (isset($dd[count($dd)-2])){
			   			$da=$dd[count($dd)-2];
			   			echo " (".$da.") ";
					}
			  }
              if ( $meta_encoding == $charset ) {
                  echo " | ".$meta_encoding;
              } else {
                  echo " | ".$meta_encoding." / ".$charset;
              }
		?> |
<?php

if (isset($_SESSION["newindow"]) or isset($arrHttp["newindow"])){	echo "<a href='javascript:top.location.href=\"../dataentry/logout.php\";top.close()' xclass=\"button_logout\"><span>[logout]</span></a>";}else{	echo "<a href=\"../dataentry/logout.php\" xclass=\"button_logout\"><span>logout</span></a>";
}
?>
	</div>
	<div class="spacer">&#160;</div>
</div>

