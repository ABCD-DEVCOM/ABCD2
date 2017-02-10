<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../common/get_post.php");
include("../config.php");
$lang=$_SESSION["lang"];
include("../lang/dbadmin.php");
include("../lang/acquisitions.php");
include("../config.php");
include("../common/header.php");

echo "<script src=../dataentry/js/lr_trim.js></script>";
echo "<body>\n";
if (isset($arrHttp["encabezado"])) {
	include("../common/institutional_info.php");
	$encabezado="&encabezado=s";
}

echo "<a href=\"menu_mantenimiento.php?base=&encabezado=s\" class=\"defaultButton backButton\">";
echo "<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
					<span><strong> back </strong></span>
				</a>";
?>


<br>
<br>
<br>

<div class="middle form">
<form action="" method="post" enctype="multipart/form-data">
 <br> <label for="archivo">Choose File:</label>
  <input type="file" name="archivo" id="archivo" />
  <br><br>
  <label>Select the type of operation</label>
  <select name="OpISO">
  <option>append</option>
  <option>create</option>
  </select>
 <?php
 include("../common/get_post.php");
  $base=$arrHttp["base"];
 
  echo " <input type=\"hidden\" value=\"$base\" name=\"base\"/>";
  ?>
  <input type="submit" value="Enviar"/>
  </form>

<?

		$base=$_POST['base'];
$bd=$db_path.$base;
			
if( !isset($_FILES['archivo']) )
{
  echo '<div class=\"middle form\"><br>No file choosen yet<br/></div>';
  
}
else
{

  $nombre = $_FILES['archivo']['name'];
  $nombre_tmp = $_FILES['archivo']['tmp_name'];
  $tipo = $_FILES['archivo']['type'];
  $tamano = $_FILES['archivo']['size'];

     $limite = 5000 * 1024;

  
    if( $_FILES['archivo']['error'] > 0 )
	{
      echo 'Error: ' . $_FILES['archivo']['error'] . '<br/>';
    }
	else
	{
	echo "<h3>File upload information</h3>";
      echo 'Name: ' . $nombre . '<br/>';
      echo 'Type: ' . $tipo . '<br/>';
      echo 'Size: ' . ($tamano / 1024) . ' Kb<br/>';
      echo 'saved in: ' . $nombre_tmp;

      if( file_exists( 'subidas/'.$nombre) )
	  {
        echo '<br/>The file: ' . $nombre. " already exists";
      }
	  else
	  {
   move_uploaded_file($nombre_tmp,
          "../../../bases/wrk/" . $nombre);
		  
		  echo "<br/>Saved in: " . "../../../bases/wrk/" . $nombre;
		  $OK="OK";
      }
    }
	
  }
		  
		  
	
  if(isset($OK))
  {
  echo "<h3>Proccess information</h3>";
echo "File upload OK, importing ".$nombre."...";
	 $op=$_POST['OpISO'];
	
	 $strINV=$mx_path."mx.exe "."iso="."../../../bases/wrk/".$nombre." ".$op."=".$bd."/data/".$base." -all now";
	 exec($strINV, $output,$t);
	 $straux="";
for($i=0;$i<count($output);$i++)
{
$straux.=$output[$i]."<br>";
}
echo "<br>MX query: ".$strINV;
echo "<br>Proccess output: ".$straux; 
if($t==0)
echo "<br>Process OK!";
else
echo "<br>Process NOT executed!";
if($base=="")
{
echo"<br>NO database selected";
}
}
//echo "<br>"."<a href='menu_mantenimiento.php?base=&encabezado=s'>Maintenance Menu</a>"."<br>";
?>
<?php if (isset($arrHttp["encabezado"])) echo "<input type=hidden name=encabezado value=s>"?>
<?
include("../common/footer.php");
echo "</body></html>";
?>
</div>
