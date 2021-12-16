<?php
/* Modifications
20210718 fho4abcd div-helper,html,translations
20211215 fho4abcd Backbutton by included file
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
	} 
	 else{
         $("#inner").width(porc);
         $("#inner").html(" "+porc); 		 
	 }

	 calporc = (cantR*100)/cantM;
   
   if(calporc > 10.0 && calporc < 30.0)
      $("#inner").css("background-color", "#80CBC4");
      else
	    if(calporc > 30.0 && calporc < 50.0)
		    $("#inner").css("background-color", "#4DB6AC");
			else
	       if(calporc > 50.0 && calporc < 70.0)
		      $("#inner").css("background-color", "#26A69A");
			  else
	         if(calporc > 70.0 && calporc < 90.0)
		        $("#inner").css("background-color", "#00897B");
				else
	         if(calporc > 90.0)
		        $("#inner").css("background-color", "#00695C");
  
 $("#info").html(cantR+" <?php echo $msgstr["de"]." / " ?> "+cantM);
 
	 
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
  
$(document).ready(function()
{
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
			        if(key != key1)
					{				
					 if($(value).val() == $(value1).val() && $(value).val() != "")
					  {
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
       else
         {
		    alert("<?php echo $msgstr["dspace_errurlcorrecta"]?>");
			$("#url").focus().val("");
			return false;
		 }        

	});

});

</script>	
<div class="middle form">
	<div class="formContent">
<form action="" method="post" name="form1" target="_self" id="form1" >

<?php
  echo "<h3>".$msgstr["dspace_title"]."</h3>";   
  echo " <input type=\"hidden\" value=\"$base_ant\" name=\"base\"/>";
  echo "<i>".$msgstr["cantdatabase"]." ".$base_ant."</i> ";
?>

<?php
function TotalItems(){
 global $arrHttp,$OS,$xWxis,$wxisUrl,$db_path,$Wxis,$msgstr,$base_ant;
 
$IsisScript=$xWxis."administrar.xis";
$query = "&base=".$base_ant."&cipar=$db_path"."par/".$base_ant.".par&Opcion=status";
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
if (!isset($tag["MAXMFN"])) 
	$tag["MAXMFN"]=0;	
	return  (int) $tag["MAXMFN"];

}
?>  
 <label id="cant"></label>
  <table name="admin" id="admin" border="0" >
    <tr>
	   <?php  if(!(isset($_POST["submit"]) && $_POST["submit"])){  ?>
	  <td>
      	<table  size="100">
	    <tr><td>
		<table border="0" width="100%"> 
		<tr>
		 <td align="left"> 
		  <label><?php echo $msgstr["eliminRegist"]; ?>  
		  </label>	  
		 </td>
		  <td align="right">
			<input type="checkbox" name="eliminRegist" id="eliminRegist" value="1" />
		  </td>	 
		 </tr>
		</table>
		</tr></td>
        <tr><td align="right">&nbsp;</td></tr>
	  <tr>
	   <td  align="right"> 
		  <label><?php echo $msgstr["dspace_url"]; ?>
			 <input  size="35" type="text" title="<?php echo $msgstr['dspace_errurl'];?>" name="url" id="url" value="">
		  </label>  
	   </td>
	  </tr>
	  <tr><td align="right">&nbsp;</td></tr>
	  <tr>
	   <td  align="right"> 
		  <label><?php echo $msgstr["dspace_count"]; ?>
			 <input  size="35" type="text" name="count" id="count" value="" onkeypress="return OnlyNum(event)">
		  </label>  
	   </td>
	  </tr>
      <tr><td align="right">&nbsp;</td></tr>
	    <tr>
	    <td>
		<table border="0" width="100%"> 
		<tr>
		 <td align="left"> 
		  <label><?php echo $msgstr["proxy"]; ?>   
		  </label>	  
		 </td>
		  <td align="right">
			<input type="checkbox" name="proxy" id="proxy" value="1" />
		  </td>	 
		 </tr>
		</table>
		</td>
	   </tr>
	   <tr><td align="right">&nbsp;</td></tr>
		  <tr>
			<td  align="right"> 
			  <label><?php echo $msgstr["proxyhttp"]; ?>
			 <input  size="35" type="text" placeholder="https://proxy.com" name="proxyhttp" id="proxyhttp" value="http://proxy.com" disabled>
			  </label>  
		   </td>
		  </tr>
		  <tr><td align="right">&nbsp;</td></tr>
		  <tr>
			<td  align="right"> 
			  <label><?php echo $msgstr["puerto"]; ?>
				 <input  size="35" type="text" placeholder="8080" name="puerto" id="puerto" value="8080" disabled>
			  </label>  
		   </td>
		  </tr>
		 
	   </table>	 
	 </td> 
	   
	  
	     <?php //$_POST["submit"]=true;
		     }  ?> 
	  <td>
	    
	     <?php  if (isset($_POST["submit"])){	 ?>	
                   <h3><label id="info"></label></h3>		 
                   <div id="outter" style="heigt:25px;width:615px;border:solid 1px #000">
				   <div id="inner" style="heigt:25px;width:0%;border-right:solid 1px #000;background-color:lightblue">&nbsp;
				   </div></div>
	               <button id="bstt" class="b"><?php echo $msgstr["detener"]; ?></button>
		 <?php 	 } ?> 	
				
		  <table width="500px" height="100%" style="position: relative;top: 0px;" border="0">
		    <tr>
				<td>&nbsp;&nbsp;</td>
				<td>
				   <div id="content" >					  
					 <div style="overflow-y: auto; height:200px; width:600px;">
					 <?php 
					 if (isset($_POST["submit"])) {   
//                                         var_dump($_POST);die;					 
					 include("dcrest.php"); 
					                     ?>
                                         <script language=javascript>F5(<?php echo TotalItems(); ?>)</script>
                                         <?php 
						 }
						     ?>	
							 
					 </div>
				   </div>
				</td>
			</tr>
		  </table> 
	  </td>
	</tr> 
	
  </table > 
<tr><td align="right">&nbsp;</td></tr>  

 <?php   
if (!(isset($_POST["submit"]) && $_POST["submit"])) { ?> 
 
<table >
  <tr>
     <td width="10">&nbsp;</td>
    <td colspan="10" style="font-size:14px"><?php echo $msgstr["dspace_match"];?></td>
	  <tr>
    <td width="10">&nbsp;</td>
    <td width="59" align="left" style="font-size:14px"><label>DC:Title</label></td>
    <td width="60" align="left" style="font-size:14px"><input type="text" name="title" size="2" value="v1" id="v1"/></td>
    <td width="71" align="left" style="font-size:14px"><label>DC:Creator</label></td>
    <td width="71" align="left" style="font-size:14px"><input type="text" name="creator" size="2" value="v2" id="v2"/></td>
    <td width="71" align="left" style="font-size:14px"><label>DC:Subject</label></td>
    <td width="72" align="left" style="font-size:14px"><input type="text" name="subject" size="2" value="v3" id="v3"/></td>
    <td width="79" align="left" style="font-size:14px"><label>DC:Description</label></td>
    <td width="80" align="left" style="font-size:14px"><input type="text" name="description" size="2" value="v4" id="v4"/></td>
    <td width="70" align="left" style="font-size:14px"><label>DC:Publisher</label></td>
    <td width="71" align="left" style="font-size:14px"><input type="text" name="publisher" size="2" value="v5" id="v5"/></td>
	  </tr>
	  <tr>
	    <td>&nbsp;</td>
	    <td align="left" style="font-size:14px">&nbsp;</td>
	    <td align="left" style="font-size:14px">&nbsp;</td>
	    <td align="left" style="font-size:14px">&nbsp;</td>
	    <td align="left" style="font-size:14px">&nbsp;</td>
	    <td align="left" style="font-size:14px">&nbsp;</td>
	    <td align="left" style="font-size:14px">&nbsp;</td>
	    <td align="left" style="font-size:14px">&nbsp;</td>
	    <td align="left" style="font-size:14px">&nbsp;</td>
	    <td align="left" style="font-size:14px">&nbsp;</td>
	    <td align="left" style="font-size:14px">&nbsp;</td>
	    </tr>
	  <tr>
	  <td width="10">&nbsp;</td>
	 <td width="59" align="left" style="font-size:14px"><label>DC:Date</label></td>
     <td width="60" align="left" style="font-size:14px"><input type="text" name="date" size="2" value="v7" id="v7"/></td>
     <td width="71" align="left" style="font-size:14px"><label>DC:Type</label></td>
     <td width="71" align="left" style="font-size:14px"><input type="text" name="type" size="2" value="v8" id="v8"/></td>
     <td width="71" align="left" style="font-size:14px"><label>DC:Format</label></td>
     <td width="72" align="left" style="font-size:14px"><input type="text" name="format" size="2" value="v9" id="v9"/></td>
     <td width="79" align="left" style="font-size:14px"><label>DC:Source</label></td>
     <td width="80" align="left" style="font-size:14px"><input type="text" name="source" size="2" value="v11" id="v11"/></td>
     <td width="70" align="left" style="font-size:14px"><label>DC:URL</label></td>
     <td width="71" align="left" style="font-size:14px"><input type="text" name="link" size="2" value="v98" id="v98"/></td>
	    </tr>
	  <tr>
	    <td>&nbsp;</td>
	    <td align="left" style="font-size:14px">&nbsp;</td>
	    <td align="left" style="font-size:14px">&nbsp;</td>
	    <td align="left" style="font-size:14px">&nbsp;</td>
	    <td align="left" style="font-size:14px">&nbsp;</td>
	    <td align="left" style="font-size:14px">&nbsp;</td>
	    <td align="left" style="font-size:14px">&nbsp;</td>
	    <td align="left" style="font-size:14px">&nbsp;</td>
	    <td align="left" style="font-size:14px">&nbsp;</td>
	    <td align="left" style="font-size:14px">&nbsp;</td>
	    <td align="left" style="font-size:14px">&nbsp;</td>
	    </tr>
	  <tr>
	    <td>&nbsp;</td>
		<td align="left" style="font-size:14px"><label>Sections</label></td>
	    <td align="left" style="font-size:14px"><input type="text" name="sections" size="2" value="v97" id="v97"/></td>
	    <td align="left" style="font-size:14px"><label>Identifier</label></td>
	    <td align="left" style="font-size:14px"><input type="text" name="id" size="2" value="v111" id="v111"/></td>
	    <td align="left" style="font-size:14px">&nbsp;</td>
	    <td align="left" style="font-size:14px">&nbsp;</td>
	    <td align="left" style="font-size:14px">&nbsp;</td>
	    <td align="left" style="font-size:14px">&nbsp;</td>
	    </tr>	
		<tr>
	    <td>&nbsp;</td>
	    <td align="left" style="font-size:14px">&nbsp;</td>
	    <td align="left" style="font-size:14px">&nbsp;</td>
	    <td align="left" style="font-size:14px">&nbsp;</td>
	    <td align="left" style="font-size:14px">&nbsp;</td>
	    <td align="left" style="font-size:14px">&nbsp;</td>
	    <td align="left" style="font-size:14px">&nbsp;</td>
	    <td align="left" style="font-size:14px">&nbsp;</td>
	    <td align="left" style="font-size:14px">&nbsp;</td>
	    <td align="left" style="font-size:14px">&nbsp;</td>
	    <td align="left" style="font-size:14px">&nbsp;</td>
	    </tr>
    </tr>
</table>


<table width="750px" border="0">
  <tr>
	    <td width="22">&nbsp;</td>
		<td><?php echo "<input type=submit name=submit id=submit value=".$msgstr["ejecutar"].">"; 
		   
		    if (isset($arrHttp["encabezado"])) {
		          echo "<input type=hidden name=encabezado value=s>";
        }	?>
		</td>     
  </tr>
  <tr><td >&nbsp;</td></tr>
</table>

 <?php  }	 ?> 

    <?php 
		if (isset($_POST["submit"])) {
			 echo $cantItems;
			}
	?>

</form>
</div>
</div>
<?php
 include("../common/footer.php");
?>
