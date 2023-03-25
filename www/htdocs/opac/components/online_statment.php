<?php
/**
 * This script enables the screen for the renewal of Borrowed Items.
 * 
 * 20230313 rogercgui File created
 */

 $primeravez="S";

    if ($ONLINESTATMENT=="Y"){
    	//foreach ($_REQUEST as $var=>$value) echo "$var=$value<br>";
?>
		<h6><?php echo $msgstr["ecta"]?></h6>

        
		<form name="estado_de_cuenta" action="opac_statment_call.php" method="post" onsubmit="ValidarUsuario();return false">
		    <?php 
				if (isset($_REQUEST["db_path"])) echo "<input type=hidden name=db_path value=\"".$_REQUEST["db_path"]."\">\n";
				if (isset($lang)) echo "<input type=hidden name=lang value=\"".$lang."\">\n";
			?>
			<input type="hidden" name="vienede" value="ecta_web">
    
        <div class="row g-3">

            <div class="col-md-8">
                <input class="form-control type="text" name="usuario" id="search-user" value="" placeholder=" <?php echo $msgstr["user_id"]?>" />
            </div>
            
            <div class="col-md-4">
		        <input class="btn btn-success" type="submit" id="search-user-submit" value="<?php echo $msgstr["send"]?>" border=0 />
            </div>
        </div>
        
        </form>
		<hr>
<?php } ?>