<?php
include("common/header.php");
require_once ("config.php");
$def = parse_ini_file($db_path."abcd.def");
include("common/get_post.php");

if (isset($arrHttp["lang"])){
	$_SESSION["lang"]=$arrHttp["lang"];
	$lang=$arrHttp["lang"];
}else{
	if (!isset($_SESSION["lang"]))
    $_SESSION["lang"]=$lang;
}
require_once ("lang/mysite.php");
require_once("lang/lang.php");
if ($EmpWeb == '0') {                            //Central Loans
?>

<html>
<head>
	<!-- Stylesheets -->
		<link rel="stylesheet" rev="stylesheet" href="css/template.css" type="text/css" media="screen"/>

</head>
<body class="mysite">

<div class="headingmysite">
    <div class="institutionalInfo">
				<h1><?php echo $def["LEGEND2"]; ?></h1>
				<h2>ABCD</h2>
			</div>

			<div class="userInfo">

			</div>
			<div class="spacer">&#160;</div>

</div>
<?php
    //Search for the data in the loanobjects database 
	$Expresion="CONTROL_".$_GET["copyId"];
	$IsisScript= $xWxis."buscar_ingreso.xis";
	$Pft="v1'|',v10'~',(v959^i'!'v959^v'!'v959^l'!'v959^o'|')/";
	$query = "&base=loanobjects&cipar=$db_path"."par/loanobjects.par&Expresion=$Expresion&Pft=$Pft";
	include("common/wxis_llamar.php");
	$tcopias="";	
	foreach ($contenido as $linea){		
		if (trim($linea)!=""){	
			$splitbycopy=explode("~",$linea);
			$tcopias.=$splitbycopy[1];						
		}
	}
	$copias=explode("|",$tcopias);
	if (count($copias)>7) echo '<div style="background:#FFFFFF; width:100; height:100">';
	else echo '<div style="background:#FFFFFF; width:100; height:160px">';
	if (count($copias)==1) echo '</br><table><tr><td></td><td>'.$msgstr["centralnocopies"]."</td></tr></table>";
	else
	{	
?>

<table>
     <tr>
        <td width="85px"><b><?php echo $msgstr["inventory"]; ?></b></td>
        <td width="80px"><b><?php echo $msgstr["volume"]; ?></b></td>
        <td width="80px"><b><?php echo $msgstr["library"]; ?></b></td>
        <td width="80px"><b><?php echo $msgstr["objtype"]; ?></b></td>
        <td width="80px"><b><?php echo $msgstr["status"]; ?></b></td>
        <td width="110px"><b><?php echo $msgstr["loaneduntil"]; ?></b></td>
     </tr>
     
    <?php	       
         for ($i=0;$i<=(count($copias)-2);$i++)
         {
		 $onecopy=explode("!",$copias[$i]);
		 //Search for the record in the trans database 
	     $Expresion="TR_P_".$onecopy[0];
		 $IsisScript= $xWxis."buscar_ingreso.xis";
		 $Pft="v1'|',v10'~',v40'|',v45'|'/";
		 $query = "&base=trans&cipar=$db_path"."par/trans.par&Expresion=$Expresion&Pft=$Pft";
		 include("common/wxis_llamar.php");
		 $Copyloant="";
		 foreach ($contenido as $lineaT){	
			 if (trim($lineaT)!="") {
			 $splitbycopy=explode("~",$lineaT);
			 $Copyloant.=$splitbycopy[1];
			 }
		 }
		 $loans=explode("|",$Copyloant);
			 
     ?>

     <tr>
        <td><?php echo $onecopy[0];?></td>
        <td><?php echo $onecopy[1];?></td>
        <td><?php echo $onecopy[2];?></td>
        <td><?php echo $onecopy[3];?></td>
        <td><?php if (count($loans)==1) echo $msgstr["available"]; else echo $msgstr["notavailable"];?></td>
        <td><?php if (count($loans)>1) {echo $loans[0]; if ($loans[1]!="") echo " at ".$loans[1];}?></td>
     </tr>

    <?php
        }       	
	 ?>
</table>
<hr />
<?php
	 }//else if (count($copias)==0)
	 ?>
</div>
		<div class="footermysite">
			<div class="systemInfo">
				<strong style="color:#FFFFFF">ABCD <?php echo $def["VERSION"] ?></strong>
				<span style="color:#FFFFFF"><?php echo $def["LEGEND1"]; ?></span>
				<a href="<?php echo $def["URL1"]; ?>" target=_blank style="color:#FFFFFF"><?php echo $def["URL1"]; ?></a>
			</div>
			<div class="distributorLogo">
				<a href="<?php echo $def["URL2"]; ?>" target=_blank><span><?php echo $def["LEGEND2"]; ?></span></a>
			</div>
			<div class="spacer">&#160;</div>
		</div>	

</body>
</html>
<?php
}
else          // if EmpWeb
{
?>

<html>
<head>
	<!-- Stylesheets -->
		<link rel="stylesheet" rev="stylesheet" href="css/template.css" type="text/css" media="screen"/>

</head>
<body class="mysite">
<script>
    function callMySite(id)
    {
        var str_aux = "/central/iniciomysite.php?action=reserve&recordId="+id+"&lang=<?php echo $lang; ?>";
        janela = window.open(str_aux,"EmpWeb");

        janela.moveTo(0,0);
        janela.resizeTo(screen.width,screen.height);

    }
</script>

<div class="headingmysite">
    <div class="institutionalInfo">
				<h1>ABCD</h1>
				<h2>EmpWeb</h2>
			</div>

			<div class="userInfo">

			</div>
			<div class="spacer">&#160;</div>

</div>
<div class="middle homepage">
<?php
require_once('../isisws/nusoap.php');
require_once ("config.php");

//set_time_limit(60);

$proxyhost = isset($_POST['proxyhost']) ? $_POST['proxyhost'] : '';
//echo 'proxyhost='. $proxyhost . '<br>';
//echo 'empwebquerylocation='. $empwebservicequerylocation . '<br>';
//echo 'empwebserviceobjectsdb='. $empwebserviceobjectsdb . '<br>';
$proxyport = isset($_POST['proxyport']) ? $_POST['proxyport'] : '';
$proxyusername = isset($_POST['proxyusername']) ? $_POST['proxyusername'] : '';
$proxypassword = isset($_POST['proxypassword']) ? $_POST['proxypassword'] : '';
$useCURL = isset($_POST['usecurl']) ? $_POST['usecurl'] : '0';

$client = new nusoap_client($empwebservicequerylocation, false,
    		$proxyhost, $proxyport, $proxyusername, $proxypassword);
$err = $client->getError();
if ($err) {
	echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
	echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->getDebug(), ENT_QUOTES) . '</pre>';
	exit();
}


$params = array('queryParam'=>array("query"=> array('recordId'=>$_GET["copyId"])), 'database' =>$empwebserviceobjectsdb);
$result = $client->call('searchObjects', $params, 'http://kalio.net/empweb/engine/query/v1' , '');

//print_r($result);
//die;

$miscopias = $result[queryResult][databaseResult][result][modsCollection][mods][extension][holdingsInfo][copies][copy];
//echo "miscopias = ";
//print_r($miscopias);
//var_dump($miscopias);
//die;
if (is_array($miscopias))
{

    if ($miscopias[copyId]!='')
    {
        $copias[0] = $miscopias;
    }
    else
    {
        $copias = $miscopias;
    }


    for ($i=0;$i<=sizeof($copias)-1;$i++)
    {
      echo "Copy = ". $copias[$i][copyId]." - ".$copias[$i][copyLocation]." - ".$copias[$i][objectCategory]."<br>";

      $params = array('copyId'=>$copias[$i][copyId], 'database' => $empwebserviceobjectsdb);
      $result =  $client->call('getCopyStatus', $params, 'http://kalio.net/empweb/engine/query/v1' , '');

      print_r ($result[copyStatus][loans][loan][userId]);
      //die;
      if (sizeof($result[copyStatus][loans])>0)
      {
        $copias[$i][loanfrom]=$result[copyStatus][loans][loan][startDate];
        $value = substr($result[copyStatus][loans][loan][endDate],6,2)."/".substr($result[copyStatus][loans][loan][endDate],4,2)."/".substr($result[copyStatus][loans][loan][endDate],0,4);
        $copias[$i][status]=$msgstr["notavailable"];
        $copias[$i][loanto]= $value;
      }
      else
      {
        $copias[$i][status]=$msgstr["available"];
      }
    }
}

?>

<table>
     <tr>
        <th><?php echo $msgstr["inventory"]; ?></th>
        <th><?php echo $msgstr["volume"]; ?></th>
        <th><?php echo $msgstr["library"]; ?></th>
        <th><?php echo $msgstr["objtype"]; ?></th>
        <th><?php echo $msgstr["status"]; ?></th>
        <th><?php echo $msgstr["loaneduntil"]; ?></th>
     </tr>

    <?php
       if (is_array($copias)>0)
       {
         for ($i=0;$i<=sizeof($copias)-1;$i++)
         {
     ?>

     <tr>
        <td><?php  echo $copias[$i][copyId]; ?></td>
        <td><?php  echo $copias[$i][volumeId]; ?></td>
        <td><?php  echo $copias[$i][copyLocation]; ?></td>
        <td><?php  echo $copias[$i][objectCategory]; ?></td>
        <td><?php  echo $copias[$i][status]; ?></td>
        <td><?php  echo $copias[$i][loanto]; ?></td>
     </tr>

    <?php
        }
       } //else echo 'NO COPIES IN LOANS SYSTEM';
     ?>


</table>

<br/>

<hr />
<br/>
<?php
  if (is_array($copias))
  {
?>
<div style="text-align: center">
    <input type="button" value="<?php echo $msgstr["makereservation"]; ?>" onClick="javascript:callMySite('<?php echo $_REQUEST["copyId"] ?>')"/>
    <input type="button" value="<?php echo $msgstr["close"]; ?>" onClick="javascript:self.close()"/>
</div>
<?php
 }



?>



</div>
		<div class="footermysite">
			<div class="systemInfo">
				<strong>ABCD <?php echo $def["VERSION"] ?></strong>
				<span><?php echo $def["LEGEND1"]; ?></span>
				<a href="<?php echo $def["URL1"]; ?>" target=_blank><?php echo $def["URL1"]; ?></a>
			</div>
			<div class="distributorLogo">
				<a href="<?php echo $def["URL2"]; ?>" target=_blank><span><?php echo $def["LEGEND2"]; ?></span></a>
			</div>
			<div class="spacer">&#160;</div>
		</div>	

</body>
</html>
<?php
}
?>
