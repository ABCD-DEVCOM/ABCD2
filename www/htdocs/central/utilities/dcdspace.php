<?php
/* Modifications
20210718 fho4abcd div-helper,html,translations
20211215 fho4abcd Backbutton by included file
20220717 fho4abcd Use $actparfolder as location for .par files
20221002 fho4abcd Improve layout (code and html)
*/
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
set_time_limit(0);
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../common/get_post.php");
include("../config.php");
$lang=$_SESSION["lang"];

include("../lang/admin.php");
include("../lang/dbadmin.php");
include("../lang/soporte.php");
include("../lang/importdoc.php");
include("../common/header.php");
$converter_path=$cisis_path."mx";
$base_ant=$arrHttp["base"];
$encabezado="&encabezado=s";
$backtoscript="../dbadmin/menu_mantenimiento.php"; // The default return script

?>
<body>
<script src='../dbadmin/jquery.js'></script>
<script src='../dataentry/js/lr_trim.js'></script>
<?php

include("../common/institutional_info.php");
?>
<div class=sectionInfo>
    <div class=breadcrumb><?php echo $msgstr["dspace_bread"].": ". $base_ant?>
    </div>
    <div class=actions>
    <?php include "../common/inc_back.php";?>
    <?php include "../common/inc_home.php";?>
    </div>
	<div class="spacer">&#160;</div>
	</div>
    <?php include "../common/inc_div-helper.php"; ?>

<script type="text/javascript">
function ListElemt(porc,cantR,cantM){ 
    if(porc == -1){   
		 $("#outter").css("display", "none");
		 $("#info").css("display", "none");
		 $("#bstt").css("display", "none");		 
	} else{
         $("#inner").width(porc);
         $("#inner").html(" "+porc); 		 
    }
    calporc = (cantR*100)/cantM;
    if(calporc > 10.0 && calporc < 30.0) $("#inner").css("background-color", "#80CBC4");
    else if(calporc > 30.0 && calporc < 50.0) $("#inner").css("background-color", "#4DB6AC");
         else if(calporc > 50.0 && calporc < 70.0) $("#inner").css("background-color", "#26A69A");
              else if(calporc > 70.0 && calporc < 90.0) $("#inner").css("background-color", "#00897B");
                   else if(calporc > 90.0) $("#inner").css("background-color", "#00695C");

    $("#info").html(cantR+" <?php echo $msgstr["de"]." " ?> "+cantM);
} 

function F5(cantElemnt){ 
	if(cantElemnt == -1)
	   $('#cant').html("<?php echo TotalItems()?>");
	else
	   $('#cant').replaceWith(cantElemnt);
} 

function OnlyNum(e){
    tecla = (document.all) ? e.keyCode : e.which;

    //Tecla de retroceso para borrar, siempre la permite
    if (tecla==8){
        return true;
    }
        
    // Patron de entrada, en este caso solo acepta numeros
    patron =/[0-9]/;
    tecla_final = String.fromCharCode(tecla);
    return patron.test(tecla_final);
}   
  
$(document).ready(function(){
    F5(-1);
    $("#proxy").click(function () {
        if( $(this).is(':checked') ){
             $("#proxyhttp").removeAttr('disabled');
			 $("#puerto").removeAttr('disabled');			 
        } else {       
              $("#proxyhttp").attr('disabled','disabled');
			  $("#puerto").attr('disabled','disabled');
        }
        $("#proxyhttp").val('');
	    $("#puerto").val('');
	});	

	$("#bstt").click(function () {
		return false;
    });
	$("#submit").click(function () {
        if($("#proxy").is(':checked') ){
		   if($("#proxyhttp").val() == "" ){
                alert("<?php echo $msgstr["errproxy"]?>");
			    $("#proxyhttp").focus();
			return false;
           }
           if($("#puerto").val() == "" ){
             	alert("<?php echo $msgstr["errpuerto"]?>");
			    $("#puerto").focus();
			return false;
           }		   
		}
		if($("#url").val() == "" ){
             alert("<?php echo $msgstr["dspace_errurl"]?>");
			$("#url").focus();
			return false;
        }
		var myVArray = [ '#v1', '#v2', '#v3', '#v4', '#v5', '#v7', '#v8', '#v9', '#v11', '#v97', '#v98', '#v111' ];
        var aux = 1;
		$.each( myVArray, function( key2, value2 ) {		   
		   if($(value2).val() == ""){
			  	alert("<?php echo $msgstr["errdc"]?>");
				$(value2).focus();
				aux = -1;
			}
		});       
		$.each( myVArray, function( key, value ) {
			    $.each( myVArray, function( key1, value1 ) {
                    if(key != key1){				
                        if($(value).val() == $(value1).val() && $(value).val() != ""){
                            alert("<?php echo $msgstr["errdcigual"]?>, "+$(value).val()+"-"+$(value1).val());
                            $(value).val("");
                            $(value1).val("");
                            $(value1).focus();
                            aux = -1;	 
                        }
                    }
			    });
			});
		
        if( aux == -1) return false;
        var pattern = /^(http|https)\:\/\/[a-z0-9\.-]+\.[a-z]{2,4}/gi;		  
        if($("#url").val().match(pattern)){ 
            return true;
		}
        else {
		    alert("<?php echo $msgstr["dspace_errurlcorrecta"]?>");
			$("#url").focus().val("");
			return false;
        }        
	});
});

</script>	
<div class="middle form">
<div class="formContent" align=center>
<h3><?php echo $msgstr["dspace_title"]?></h3>
<form action="" method="post" name="form1" target="_self" id="form1" accept-charset=utf-8>
    <input type="hidden" value="<?php echo $base_ant?>" name="base"/>
    <i><?php echo $msgstr["cantdatabase"]." ".$base_ant?></i> &rarr; <label id="cant"></label>

<?php if(!(isset($_POST["submit"]) && $_POST["submit"])){?>
    <table  size="100">
        <tr>
            <td><?php echo $msgstr["eliminRegist"]; ?></td>
            <td align="right">
                <input type="checkbox" name="eliminRegist" id="eliminRegist" value="1" />
            </td>	 
        </tr>
        <tr>
            <td><?php echo $msgstr["dspace_url"]; ?></td>
            <td colspan=2><input  size="35" type="text" title="<?php echo $msgstr['dspace_errurl'];?>" name="url" id="url" value=""></td>
        </tr>
        <tr>
            <td><?php echo $msgstr["dspace_count"]; ?></td>
            <td><input  size="6" type="text" name="count" id="count" value="" onkeypress="return OnlyNum(event)"></td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td> <?php echo $msgstr["proxy"]; ?></td>
            <td><input type="checkbox" name="proxy" id="proxy" value="1" /></td>	 
        </tr>
        <tr>
            <td></td>
            <td><?php echo $msgstr["proxyhttp"]; ?></td>
            <td><input  size="35" type="text" placeholder="https://proxy.com" name="proxyhttp" id="proxyhttp" value="http://proxy.com" disabled>
            </td>
        </tr>
        <tr>
            <td></td>
            <td><?php echo $msgstr["puerto"]; ?></td>
            <td><input  size="35" type="text" placeholder="8080" name="puerto" id="puerto" value="8080" disabled>
            </td>
        </tr>
    </table>	 
    <?php //$_POST["submit"]=true;
}
if (isset($_POST["submit"])){	 ?>	
    <h3><label id="info"></label></h3>		 
    <div id="outter"  align=left style="height:25px;width:715px;border:solid 1px #000">
        <div id="inner" style="height:25px;width:0%;border-right:solid 1px #000;background-color:lightblue">&nbsp;
        </div>
    </div>
    <div>
        <button id="bstt" class="b"><?php echo $msgstr["detener"]; ?></button>
        <br><br>
    </div>
    <div align=center style="width:700px;">
        <div id="content"  align=left>					  
            <div style="overflow-y: auto; height:200px; width:700px;">
                <?php include("dcrest.php"); ?>
                <script language=javascript>F5(<?php echo TotalItems(); ?>)</script>
            </div>
        </div>
    </div>
<?php
     echo $cantItems;
}  
if (!(isset($_POST["submit"]) && $_POST["submit"])) { ?> 
    <table  cellspacing=1 cellpadding=4 >
        <tr>
            <td colspan="10" style="color:green"><?php echo $msgstr["dspace_match"];?></td>
        </tr><tr>
            <td>DC:Title</td>
            <td style='padding-right:20px'><input type="text" name="title" size="2" value="v1" id="v1"/></td>
            <td>DC:Creator</td>
            <td style='padding-right:20px'><input type="text" name="creator" size="2" value="v2" id="v2"/></td>
            <td>DC:Subject</td>
            <td style='padding-right:20px'><input type="text" name="subject" size="2" value="v3" id="v3"/></td>
            <td>DC:Description</td>
            <td style='padding-right:20px'><input type="text" name="description" size="2" value="v4" id="v4"/></td>
            <td>DC:Publisher</td>
            <td style='padding-right:20px'><input type="text" name="publisher" size="2" value="v5" id="v5"/></td>
        </tr><tr>
            <td>DC:Date</td>
            <td><input type="text" name="date" size="2" value="v7" id="v7"/></td>
            <td>DC:Type</td>
            <td><input type="text" name="type" size="2" value="v8" id="v8"/></td>
            <td>DC:Format</td>
            <td><input type="text" name="format" size="2" value="v9" id="v9"/></td>
            <td>DC:Source</td>
            <td><input type="text" name="source" size="2" value="v11" id="v11"/></td>
            <td>DC:URL</td>
            <td><input type="text" name="link" size="2" value="v98" id="v98"/></td>
        </tr>
        <tr>
            <td>Sections</td>
            <td><input type="text" name="sections" size="2" value="v97" id="v97"/></td>
            <td>Identifier</td>
            <td><input type="text" name="id" size="2" value="v111" id="v111"/></td>
        </tr>	
        <tr><td colspan=10 style="color:darkred" align=center><b><?php echo $msgstr["dd_map_fdt"];?></td></tr>
    </table>

    <div>
        <button class="bt bt-blue" type=submit name=submit id=submit value=start><?php echo $msgstr["ejecutar"]?></button>
        <?php if (isset($arrHttp["encabezado"])) echo "<input type=hidden name=encabezado value=s>";
        ?>
    </div>
<?php
} 
?>
</form>
</div>
</div>
<?php
include("../common/footer.php");
?>
<?php
/* ===================== php functions =========*/
function TotalItems(){
    global $arrHttp,$OS,$xWxis,$wxisUrl,$db_path,$Wxis,$msgstr,$base_ant,$actparfolder;
     
    $IsisScript=$xWxis."administrar.xis";
    $query = "&base=".$base_ant."&cipar=$db_path".$actparfolder.$base_ant.".par&Opcion=status";
    include("../common/wxis_llamar.php");
	$ix=-1;
	foreach($contenido as $linea) {
		$ix=$ix+1;
		if ($ix>0) {
			if (trim($linea)!=""){
				$a=explode(":",$linea);
				if (isset($a[1])) $tag[$a[0]]=$a[1];
			}
		}
	}
    if (!isset($tag["MAXMFN"])) $tag["MAXMFN"]=0;	
	return  (int) $tag["MAXMFN"];
}
?>  

