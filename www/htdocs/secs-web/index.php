<?php

/**
 * @file:	index.php
 * @desc:	Main file, System Controller 
 * @author:	Ana Katia Camilo <katia.camilo@bireme.org>
 * @author:	Bruno Neofiti <bruno.neofiti@bireme.org>
 * @author:	Domingos Teruel <domingos.teruel@bireme.org>
 * @since:      2008-01-11
 * @copyright:  (c) 2008 BIREME/PAHO/WHO - PFI
 ******************************************************************************/

 $ver= phpversion();
$ver=explode('.',$ver);
$vp=intval($ver[0],10);

	if($vp>5){
	if((isset($_GET["m"]) && $_GET["m"]=="title") && (isset($_GET["edit"]) && $_GET["edit"]=="validation") && isset($_POST["gravar"]) && !isset($_POST["mfn"])){
	include("../central/config.php");
//	$mx=$mx_path."mx ".$db_path."secs-web/title from=1 to=9999 pft=v30";
        $mx=$mx_path . " ".$db_path."secs-web/title +control";
	exec($mx,$out,$f);
        // var_dump($out);
 $maxmfn=explode(" RC ",$out[2]);
// var_dump($maxmfn);
 $maxmfn=explode(" ",$maxmfn[0]);
// var_dump($maxmfn);
 $v30=intval($maxmfn[3])-1;
// echo "v30=$v30<BR>"; die;
	
//$dospuntos=explode("..",$out[0]);
//$arr_v30=array();
//for($i=0;$i<count($dospuntos);$i++)
//{
//	if($dospuntos[$i] !="" && $dospuntos[$i]!=" ")
//	{
//		$arr_v30[]=$dospuntos[$i];
//	}
//}
//$last_v30= intval($arr_v30[count($arr_v30)-1],10);
//$v30=$last_v30+1;

$arr= $_POST["field"];
$Nro=1234;
$str="<IsisScript name=new>
<parm name=cipar><pft>'title.*=".$db_path."secs-web/title.*',/
'htm.pft=title\data\title.pft'</pft></parm>
<do task=update>
<parm name=db>title</parm>
<parm name=fst><pft>cat('title.fst')</pft></parm>
<parm name=mfn>New</parm>
<field action=define tag=1102>Isis_Status</field>
<update>
<field action=add tag=1>".$Nro."</field>
<field action=add tag=3>LOCAL</field>
<field action=add tag=5>S</field>
<field action=add tag=6>s</field>
<field action=add tag=10>MAIN</field>
<field action=add tag=20>".$arr['nationalCode']."</field>
<field action=add tag=30>".$v30."</field>
<field action=add tag=37>".$arr['recordIdentification']."</field>
<field action=add tag=40>SECS</field>
<field action=add tag=50>".$arr['publicationStatus']."</field>
<field action=add tag=99>75</field>
<field action=add tag=100>".$arr['publicationTitle']."</field>
<field action=add tag=140>".$arr['nameOfIssuingBody'][0]."</field>
<field action=add tag=150>".$arr['abbreviatedTitle']."</field>
<field action=add tag=180>".$arr['abbreviatedTitleMedline'][0]."</field>
<field action=add tag=301>".$arr['initialDate']."</field>
<field action=add tag=302>".$arr['initialVolume']."</field>
<field action=add tag=303>".$arr['initialNumber']."</field>
<field action=add tag=310>".$arr['country']."</field>
<field action=add tag=330>".$arr['publicationLevel']."</field>
<field action=add tag=340>B</field>
<field action=add tag=350>".$arr['languageAbstract'][0]."</field>
<field action=add tag=360>".$arr['languageText'][0]."</field>
<field action=add tag=380>".$arr['frequency']."</field>
<field action=add tag=400>".$arr['issn'][0]."</field>
<field action=add tag=445>".$arr['languageText'][0]."</field>
<field action=add tag=445>".$arr['userVHL'][0]."</field>
<field action=add tag=450>".$arr['indexingCoverage'][0]."</field>
<field action=add tag=460>1A</field>
<field action=add tag=480>".$arr['publisher']."</field>
<field action=add tag=490>".$arr['place']."</field>
<field action=add tag=610>".$arr['titleContinuationOf']."</field>
<field action=add tag=800>".$arr['1A']."</field>
<field action=add tag=840>".$arr['descriptors'][0]."</field>
<field action=add tag=888>".$arr['abbreviatedTitleMedline'][0]."</field>
<field action=add tag=910>".$arr['notesBVS']."</field>
<field action=add tag=999>".$arr['urlPortal'][0]."</field>
<field action=replace tag=100 split=occ><pft>(v100/)</pft></field>
<write>Unlock</write>
<display>
<pft>if val(v1102) = 0 then '<b>Created!</b><hr>' fi </pft>
<pft>if val(v1102) = 1 then '<b>Sorry, no registries created!</b><hr>' fi </pft>
</display>
</update>
</do>
</IsisScript>";
$new_name="new_".time().".xis";
$IsisScript=$Wxis." IsisScript=".$db_path."secs-web/$new_name";
@ $fp = fopen($db_path."secs-web/$new_name", "w");

@  flock($fp, 2);

   fwrite($fp, $str);
  flock($fp, 3);
  fclose($fp);
exec($IsisScript,$salida,$bandera);
$url=explode("cgi-bin",$wxisUrl);
$url=$url[0]."secs-web/?m=title";
unlink($db_path."secs-web/$new_name");
echo "<script>document.location.href='".$url."'</script>";
exit;


	}
	else if(isset($_POST["mfn"]) && $_GET["m"]=="title")//means user is editing
	{
		include("../central/config.php");
	$mfn=$_POST["mfn"];
	$edit_name="edit_".time().".xis";
    $IsisScript=$Wxis." IsisScript=".$db_path."secs-web/$edit_name";
	$arr= $_POST["field"];
	$Nro=1234;
	$mx=$mx_path."mx ".$db_path."secs-web/title from=1 to=9999 pft=v30";
        $mx=$mx_path . " ".$db_path."secs-web/title +control";
	exec($mx,$out,$f);
 $maxmfn=explode(" RC ",$out[2]);
 $maxmfn=explode(" ",$maxmfn[0]);
 $v30=intval($maxmfn[3])-1;

			$str="<IsisScript name=edit>
			<parm name=cipar><pft>'title.*=".$db_path."secs-web/title.*',/
'htm.pft=title\data\title.pft'</pft></parm>
			<do task=update>
<parm name=db>".$db_path."secs-web/title</parm>
<parm name=lockid>abcd</parm>
<parm name=mfn>".$mfn."</parm>
<parm name=fst><pft>cat('".$db_path."secs-web/title.fst')</pft></parm>
<field action=define tag=1101>Isis_Lock</field>
<field action=define tag=1102>Isis_Status</field>
<update>
<write>Lock</write>
<field action=delete tag=1>all</field>
<field action=delete tag=3>all</field>
<field action=delete tag=5>all</field>
<field action=delete tag=6>all</field>
<field action=delete tag=10>all</field>
<field action=delete tag=20>all</field>
<field action=delete tag=30>all</field>
<field action=delete tag=37>all</field>
<field action=delete tag=40>all</field>
<field action=delete tag=50>all</field>
<field action=delete tag=99>all</field>
<field action=delete tag=140>all</field>
<field action=delete tag=100>all</field>
<field action=delete tag=150>all</field>
<field action=delete tag=180>all</field>
<field action=delete tag=301>all</field>
<field action=delete tag=302>all</field>
<field action=delete tag=303>all</field>
<field action=delete tag=310>all</field>
<field action=delete tag=330>all</field>
<field action=delete tag=340>all</field>
<field action=delete tag=350>all</field>
<field action=delete tag=360>all</field>
<field action=delete tag=380>all</field>
<field action=delete tag=400>all</field>
<field action=delete tag=445>all</field>
<field action=delete tag=450>all</field>
<field action=delete tag=460>all</field>
<field action=delete tag=480>all</field>
<field action=delete tag=490>all</field>
<field action=delete tag=610>all</field>
<field action=delete tag=800>all</field>
<field action=delete tag=840>all</field>
<field action=delete tag=888>all</field>
<field action=delete tag=910>all</field>
<field action=delete tag=999>all</field>
<field action=add tag=1>".$Nro."</field>
<field action=add tag=3>LOCAL</field>
<field action=add tag=5>S</field>
<field action=add tag=6>s</field>
<field action=add tag=10>MAIN</field>
<field action=add tag=20>".$arr['nationalCode']."</field>
<field action=add tag=30>".$v30."</field>
<field action=add tag=37>".$arr['recordIdentification']."</field>
<field action=add tag=40>SECS</field>
<field action=add tag=50>".$arr['publicationStatus']."</field>
<field action=add tag=99>75</field>
<field action=add tag=100>".$arr['publicationTitle']."</field>
<field action=add tag=140>".$arr['nameOfIssuingBody'][0]."</field>
<field action=add tag=150>".$arr['abbreviatedTitle']."</field>
<field action=add tag=180>".$arr['abbreviatedTitleMedline'][0]."</field>
<field action=add tag=301>".$arr['initialDate']."</field>
<field action=add tag=302>".$arr['initialVolume']."</field>
<field action=add tag=303>".$arr['initialNumber']."</field>
<field action=add tag=310>".$arr['country']."</field>
<field action=add tag=330>".$arr['publicationLevel']."</field>
<field action=add tag=340>B</field>
<field action=add tag=350>".$arr['languageAbstract'][0]."</field>
<field action=add tag=360>".$arr['languageText'][0]."</field>
<field action=add tag=380>".$arr['frequency']."</field>
<field action=add tag=400>".$arr['issn'][0]."</field>
<field action=add tag=445>".$arr['languageText'][0]."</field>
<field action=add tag=445>".$arr['userVHL'][0]."</field>
<field action=add tag=450>".$arr['indexingCoverage'][0]."</field>
<field action=add tag=460>1A</field>
<field action=add tag=480>".$arr['publisher']."</field>
<field action=add tag=490>".$arr['place']."</field>
<field action=add tag=610>".$arr['titleContinuationOf']."</field>
<field action=add tag=800>".$arr['1A']."</field>
<field action=add tag=840>".$arr['descriptors'][0]."</field>
<field action=add tag=888>".$arr['abbreviatedTitleMedline'][0]."</field>
<field action=add tag=910>".$arr['notesBVS']."</field>
<field action=add tag=999>".$arr['urlPortal'][0]."</field>
<write>Unlock</write>
<display><pft>if val(v1102)=0 then
'<b>Update successful!</b>' fi</pft></display>
</update>
</do>
</IsisScript>
";

@ $fp = fopen($db_path."secs-web/$edit_name", "w");

@  flock($fp, 2);

   fwrite($fp, $str);
  flock($fp, 3);
  fclose($fp);
exec($IsisScript,$salida,$bandera);
$url=explode("cgi-bin",$wxisUrl);
$url=$url[0]."secs-web/?m=title";
unlink($db_path."secs-web/$edit_name");
echo "<script>document.location.href='".$url."'</script>";
exit;
	
	}
	//start mask 
	
	if(isset($_GET["m"]) && $_GET["m"]=="mask" && $_GET["edit"]=="save" && !isset($_POST["mfn"]))
	{
	include("../central/config.php");
		$field=$_POST["field"];
		$volumeType=$field["volumeType"];
		$strvolumeType="";
		foreach($volumeType as $vt)
		{
			$strvolumeType.="<field action=add tag=841>".$vt."</field>";
		}
		$notes=$field["notes"];
		$strnotes="";
		foreach($notes as $note)
		{
			$strnotes.="<field action=add tag=900>".$note."</field>";
		}	
	$str_new_mask="<IsisScript name=newmask>
<parm name=cipar><pft>'mask.*=".$db_path."secs-web/mask.*',/
'htm.pft=mask\data\mask.pft'</pft></parm>
<do task=update>
<parm name=db>mask</parm>
<parm name=fst><pft>cat('mask.fst')</pft></parm>
<parm name=mfn>New</parm>
<field action=define tag=1102>Isis_Status</field>
<update>
<field action=add tag=1>".$field["database"]."</field>
<field action=add tag=5>".$field["typeLiterature"]."</field>
<field action=add tag=6>".$field["levelTreatment"]."</field>
<field action=add tag=10>".$field["codeCenter"]."</field>
<field action=add tag=801>".$field["nameMask"]."</field>".
$strvolumeType."
<field action=add tag=940>".$field['creationDate']."</field>
<field action=add tag=950>".$field['documentalistCreation']."</field>
".$strnotes."
<write>Unlock</write>
<display>
<pft>if val(v1102) = 0 then '<b>Created!</b><hr>' fi </pft>
<pft>if val(v1102) = 1 then '<b>Sorry, no registries created!</b><hr>' fi </pft>
</display>
</update>
</do>
</IsisScript>";
	$new_mask_name="new_mask_".time().".xis";
    $IsisScriptNewMask=$Wxis." IsisScript=".$db_path."secs-web/$new_mask_name";
	@ $fp = fopen($db_path."secs-web/$new_mask_name", "w");

@  flock($fp, 2);

   fwrite($fp, $str_new_mask);
  flock($fp, 3);
  fclose($fp);
exec($IsisScriptNewMask,$salida,$bandera);
$url=explode("cgi-bin",$wxisUrl);
$url=$url[0]."secs-web/?m=mask";
unlink($db_path."secs-web/$new_mask_name");
echo "<script>document.location.href='".$url."'</script>";
exit;
	
	}
 if(isset($_GET["m"]) && $_GET["m"]=="mask" && $_GET["edit"]=="save" && isset($_POST["mfn"]))//means user us editing a mask
{
	
	include("../central/config.php");
		$field=$_POST["field"];
		$volumeType=$field["volumeType"];
		$strvolumeType="";
		foreach($volumeType as $vt)
		{
			$strvolumeType.="<field action=add tag=841>".$vt."</field>";
		}
		$notes=$field["notes"];
		$strnotes="";
		foreach($notes as $note)
		{
			$strnotes.="<field action=add tag=900>".$note."</field>";
		}
		$mfn=$_POST["mfn"];
$str_edit_mask="<IsisScript name=edit_mask>
			<parm name=cipar><pft>'mask.*=".$db_path."secs-web/mask.*',/
'htm.pft=mask\data\mask.pft'</pft></parm>
			<do task=update>
<parm name=db>".$db_path."secs-web/mask</parm>
<parm name=lockid>abcd</parm>
<parm name=mfn>".$mfn."</parm>
<parm name=fst><pft>cat('".$db_path."secs-web/mask.fst')</pft></parm>
<field action=define tag=1101>Isis_Lock</field>
<field action=define tag=1102>Isis_Status</field>
<update>
<write>Lock</write>
<field action=delete tag=1>all</field>
<field action=delete tag=5>all</field>
<field action=delete tag=6>all</field>
<field action=delete tag=10>all</field>
<field action=delete tag=801>all</field>
<field action=delete tag=940>all</field>
<field action=delete tag=950>all</field>
<field action=delete tag=900>all</field>
<field action=add tag=1>".$field["database"]."</field>
<field action=add tag=5>".$field["typeLiterature"]."</field>
<field action=add tag=6>".$field["levelTreatment"]."</field>
<field action=add tag=10>".$field["codeCenter"]."</field>
<field action=add tag=801>".$field["nameMask"]."</field>"."
<field action=add tag=940>".$field['creationDate']."</field>
<field action=add tag=950>".$field['documentalistCreation']."</field>
".$strnotes."
<write>Unlock</write>
<display><pft>if val(v1102)=0 then
'<b>Update successful!</b>' fi</pft></display>
</update>
</do>
</IsisScript>
";
	$edit_mask_name="edit_mask_".time().".xis";
    $IsisScriptEditMask=$Wxis." IsisScript=".$db_path."secs-web/$edit_mask_name";
	@ $fp = fopen($db_path."secs-web/$edit_mask_name", "w");

@  flock($fp, 2);

   fwrite($fp, $str_edit_mask);
  flock($fp, 3);
  fclose($fp);
exec($IsisScriptEditMask,$salida,$bandera);
$url=explode("cgi-bin",$wxisUrl);
$url=$url[0]."secs-web/?m=mask";
unlink($db_path."secs-web/$edit_mask_name");
echo "<script>document.location.href='".$url."'</script>";
exit;	
}	
	
	//end mask
}
//start titlePlus
if(isset($_GET["m"]) && $_GET["m"]=="titleplus" && isset($_GET["title"])&& $_GET["edit"]="save" && isset($_POST["mfn"]))//user is editing titlePlus
{
	include("../central/config.php");
	$mfn=$_POST["mfn"];
	$lib="main";
	$field=$_POST["field"];
	$v907=$field["locationRoom"];
		$str907="";
		foreach($v907 as $vt)
		{
			$str907.="<field action=add tag=907>".$vt."</field>";
		}
		
	$v908=$field["estMap"];
		$str908="";
		foreach($v908 as $vt)
		{
			$str908.="<field action=add tag=908>".$vt."</field>";
		}	
		
	$str_edit_titleplus="<IsisScript name=edit_title_plus>
			<parm name=cipar><pft>'titlePlus.*=".$db_path."secs-web/$lib/titlePlus.*',/
'htm.pft=v100'</pft></parm>
			<do task=update>
<parm name=db>".$db_path."secs-web/$lib/titlePlus</parm>
<parm name=lockid>abcd</parm>
<parm name=mfn>".$mfn."</parm>
<parm name=fst><pft>cat('".$db_path."secs-web/$lib/titlePlus.fst')</pft></parm>
<field action=define tag=1101>Isis_Lock</field>
<field action=define tag=1102>Isis_Status</field>
<update>
<write>Lock</write>
<field action=delete tag=10>all</field>
<field action=delete tag=301>all</field>
<field action=delete tag=302>all</field>
<field action=delete tag=303>all</field>
<field action=delete tag=901>all</field>
<field action=delete tag=902>all</field>
<field action=delete tag=903>all</field>
<field action=delete tag=906>all</field>
<field action=delete tag=946>all</field>
<field action=delete tag=904>all</field>
<field action=delete tag=906>all</field>
<field action=delete tag=905>all</field>
<field action=delete tag=907>all</field>
<field action=delete tag=908>all</field>
<field action=delete tag=909>all</field>
<field action=delete tag=910>all</field>
<field action=delete tag=911>all</field>
<field action=delete tag=912>all</field>
<field action=delete tag=940>all</field>
<field action=delete tag=941>all</field>
<field action=delete tag=950>all</field>
<field action=delete tag=951>all</field>

<field action=add tag=10>".$field["centerCode"]."</field>
<field action=add tag=901>".$field["acquisitionMethod"]."</field>"."
<field action=add tag=902>".$field['acquisitionControl']."</field>
<field action=add tag=903>".$field['receivedExchange']."</field>
<field action=add tag=904>".$field['providerNotes']."</field>
<field action=add tag=946>".$field['acquisitionPriority']."</field>
".$str907.
$str908."
<field action=add tag=905>".$field['provider']."</field>
<field action=add tag=906>".$_POST['expirationSubs']."</field>
<field action=add tag=909>".$_POST['ownClassif']."</field>
<field action=add tag=910>".$_POST['ownDesc']."</field>
<field action=add tag=911>".$_POST['admNotes']."</field>
<field action=add tag=912>".$_POST['donorNotes']."</field>
<field action=add tag=913>".$_POST['acquisitionHistory'][0]."</field>
<field action=add tag=940>".$_POST['creatDate']."</field>
<field action=add tag=941>".$_POST['initialDate']."</field>
<field action=add tag=950>admsecs</field>
<field action=add tag=951>admsecs</field>
<write>Unlock</write>
<display><pft>if val(v1102)=0 then
'<b>Update successful!</b>' fi</pft></display>
</update>
</do>
</IsisScript>
";
$edit_titleplus_name="edit_titleplus_".time().".xis";
    $IsisScriptEditTitleplus=$Wxis." IsisScript=".$db_path."secs-web/$lib/$edit_titleplus_name";
	@ $fp = fopen($db_path."secs-web/$lib/$edit_titleplus_name", "w");

@  flock($fp, 2);

   fwrite($fp, $str_edit_titleplus);
  flock($fp, 3);
  fclose($fp);
exec($IsisScriptEditTitleplus,$salida,$bandera);
$url=explode("cgi-bin",$wxisUrl);
$url=$url[0]."secs-web/?m=titleplus";
unlink($db_path."secs-web/$lib/$edit_titleplus_name");
echo "<script>document.location.href='".$url."'</script>";
exit;	
	
}



//end titlePlus




/**
 * Main include file of the system, it contains all the parameters required for
 * the operation of this system..
 */
 require_once("./common/ini/config.ini.php");
 /**
	* this code creates a registry with mx if its > PHP5 @author Marino Borrero <marinoborrero@gmail.com>
 */

//User not logged in System
if(!isset($_SESSION["identified"]) || $_SESSION["identified"]!=1 ) 
{
    list($libraryName, $libraryCode) = getAllLibraries();
    $smarty->assign("collectionLibrary",$libraryName);
    $smarty->assign("codesLibrary",$libraryCode);

    //User trying to log-in
    if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(isset($_GET["action"]) && !preg_match("=/=",$_GET["action"]) ) {
        if ($_REQUEST["field"]["action"]=="do")
        {
        $misession = new sessionManager();
        $checkUserPwd = $misession->checkLogin($_REQUEST["field"]["username"],$_REQUEST["field"]["password"],$_REQUEST["field"]["selLibrary"]);
        switch ($checkUserPwd) {
            case "OK":
                unset($_GET["action"]);
                $page = 'index';
                $smartyTemplate = "homepage";
                $listRequest = "homepage";
                $smarty->assign("totalMaskRecords",totalDb("mask"));
                $smarty->assign("totalTitleRecords",totalDb("title"));
                $smarty->assign("totalTitlePlusRecords",totalDb("titleplus"));
                break;
            case "Error1":
                unset($_SESSION);
                $page = 'index';
                user_error($BVS_LANG["errorLogIn"],E_USER_ERROR);
                break;
            case "Error2":
                unset($_SESSION);
                $page = 'index';
                user_error($BVS_LANG["errorWrongLibrary"],E_USER_ERROR);
                break;
            case "Error3":
                unset($_SESSION);
                $page = 'index';
                user_error($BVS_LANG["errorSelectLibrary"],E_USER_ERROR);
                break;
        }
        }
    }
    }else{
        //User not logged in System, show login page
        $page = 'index';
        $smartyTemplate = "login";
        $listRequest = "login";
    }
}else{
//From here users logged in the system

//User doing logoff
if ($_GET['action'] == "signoff") {
    unset($_SESSION);
    session_destroy();
    $page = 'index';
    $smartyTemplate = "login";
    $listRequest = "login";
    list($libraryName, $libraryCode) = getAllLibraries();
    $smarty->assign("collectionLibrary",$libraryName);
    $smarty->assign("codesLibrary",$libraryCode);

}else{

    //Preventing passing variable by URL, if not logged
    if($_SERVER['REQUEST_METHOD'] == "GET"){
        $tentLogin = $_GET["action"];
        $tentAcesBase =  $_GET["m"];
        if (!preg_match("/^[a-z_.\/]*$/i", $tentAcesBase) && preg_match("/\\.\\./i", $tentAcesBase)) {
            user_error($BVS_LANG["error404"],E_USER_ERROR);
        }elseif(!preg_match("/^[a-z_.\/]*$/i", $tentLogin) && preg_match("/\\.\\./i", $tentLogin)){
            user_error($BVS_LANG["error404"],E_USER_ERROR);
        }
    }

    $listRequest = $_GET["m"]; 
    $page = "index";

    //Set witch dataModel to use
    if(isset($_GET["m"]) && !preg_match("=/=",$_GET["m"])){
        switch ($_GET["m"]) {
            case "mask":
                if($_SESSION["role"] == "Administrator")
                    $dataModel = new mask();
                else
                    die($BVS_LANG["error404"]);
                break;
            case "title":
                $dataModel = new title();
                break;
            case "users":
                $dataModel = new user();
            break;
            case "facic":
                $dataModel = new facicOperations();
                break;
            case "titleplus":
                if($_SESSION["role"] == "Editor" || $_SESSION["role"] == "Administrator")
                    $dataModel = new titleplus();
                else
                    die($BVS_LANG["error404"]);
                break;
            case "library":
                $dataModel = new library();
                break;
            case "report":
                $dataModel = false;
                break;
            case "maintenance":
                $dataModel = false;
                break;
            case "export":
                $dataModel = false;
                break;
            default:
            die($BVS_LANG["error404"]);
        }
    }else{
        $dataModel = array();
    }

    //Setting total records value based in permission
    if($_GET["m"] == ""){
        switch ($_SESSION["role"]) {
            case "Administrator":
                $smarty->assign("totalMaskRecords",totalDb("mask"));
                $smarty->assign("totalTitleRecords",totalDb("title"));
                $smarty->assign("totalTitlePlusRecords",totalDb("titleplus"));
                break;
            case "AdministratorOnly":
                $smarty->assign("totalMaskRecords",totalDb("mask"));
                $smarty->assign("totalTitleRecords",totalDb("title"));
                break;
            case "Editor":
                $smarty->assign("totalTitleRecords",totalDb("title"));
                $smarty->assign("totalTitlePlusRecords",totalDb("titleplus"));
                break;
            case "Operator":
                $smarty->assign("totalMaskRecords",totalDb("mask"));
                $smarty->assign("totalTitleRecords",totalDb("title"));
                $smarty->assign("totalTitlePlusRecords",totalDb("titleplus"));
                break;
        }
    }


    // CHECKING ACTION
    if (!isset($_GET["edit"]) && !isset($_GET["delete"]) && $_GET['hldg']=='execute'){
            $myAction = 'holdings';
    } elseif (isset($_GET["edit"]) && !preg_match("=/=",$_GET["edit"])) {
        if ($_GET['edit'] == 'validation'){
            //$myAction = 'validation';
            $formValidation = validation($_GET["m"]);
            //var_dump($formValidation);
            if($formValidation == false){
               foreach ($errorField as $key => $value) {
                        print_r ("erro no campo " .$errorField[$key]." <br>");
               }
            }else{
                $myAction = 'save';
            }
            //die(" fimm");
        } elseif ($_GET['edit'] == 'save' && $_REQUEST["gravar"]!="false") {
            $myAction = 'save';
        } else {
            if ($_GET["edit"]=="save"){
                $myAction = 'save?';
            } else {
                $myAction = 'edit?';
            }
        }

    } elseif (isset($_GET["delete"])){
        $myAction = 'delete';
    } elseif (isset($_GET["action"]) && !preg_match("=/=",$_GET["action"]) && $_GET["action"] != "signin") {
         switch ($_GET["action"]){
            case 'delete':
                $myAction = 'confirm_delete';
                break;
            case 'exist':
                $myAction = 'exist';
                break;
            default:
                $myAction = 'new';
                break;
            }
    } elseif (isset($_GET["export"]) && !preg_match("=/=",$_GET["export"])){
        $myAction = 'export';
    }elseif (isset($_GET["m"]) && !preg_match("=/=",$_GET["m"])) {
        if (isset($_GET["delete"])){
            $myAction = 'delete';
        } else {
            $myAction = 'list';
        }

    } elseif (isset($_GET["delete"]) == "delete"){
        $myAction = 'delete';
    } else {
        $myAction = 'no_action';
    }

    switch ($myAction){
        case 'holdings':
            $hldgModule = new hldgModule($_SESSION['centerCode'], BVS_ROOT_DIR."/".HLDGMODULE, $configurator->getPath2Facic(), $configurator->getPath2Holdings(), $configurator->getPath2Title(), HLDGMODULE_TAG, BVS_DIR."/cgi-bin/", BVS_TEMP_DIR);
            $call = $hldgModule->execute($_REQUEST["title"], HLDGMODULE_DEBUG);
            echo '<!-- [action]holdings[/action] -->'.'<!--'.$call.'-->';
            die();
            break;
        case 'exist':
            if ($dataModel->searchByTitle($_GET["title"])){
                echo 'EXIST';
            } else {
                echo 'DOES_NOT_EXIST';
            }
            die();
            break;
        case 'save':
            // part 1
            if(is_array($_REQUEST["field"])){
                $r = $dataModel->createRecord($_REQUEST["field"]);

                if(is_int((int)$_REQUEST["mfn"]) && $_REQUEST["mfn"] != 0) {
                    $dataModel->saveRecord($_REQUEST["mfn"]);  //Updating a register
                    $thisMfn = $_REQUEST["mfn"];
                }else{
                    $thisMfn = $dataModel->saveRecord("New"); //Saving new register
                }
                if($listRequest == "mask"){
                sortMaskByAlphabet();
                }
            }else{
                user_error($BVS_LANG["error404"],E_USER_ERROR);
            }
            // part 2
// esse condição parece não acontecer nunca.
// Verificar necessidade.
//            if($listRequest == "titleplus"){
//                $titleSearch = new titleplus();
//                $titleFound = $titleSearch->searchByTitle($_GET["title"]); //search titlePlus by title
//                if ($titleFound){
//                    echo "<h1>passei por aqui<h1/>";
//                    $editRequest = $titleFound->registro->mfn; //if search is ok, add mfn from search to edit in titleplus
//                    $_GET["edit"] = $editRequest;
//                }else{
//                    $_GET["edit"] = "";
//                    $_GET["action"] = "new";
//                }
//            }
            $smarty->assign("formRequest",$listRequest);

            if($listRequest == "mask" || $listRequest == "facic") {
                $smarty->assign("collectionMask",$dataModel->getAllNameMask());
            }
            $smarty->assign("dataRecord",$dataModel->getRecordByMFN($editRequest));

            if ($listRequest == "facic"){
                if ($_REQUEST["recid"]){
                    echo "<!-- [request]";
                    var_dump($_REQUEST);
                    echo "[/request] -->";
                    echo "<!-- [recid]".$_REQUEST["recid"]."[/recid] -->";
                    echo "<!-- [mfn]".$thisMfn."[/mfn] -->";
                    echo '<!-- [action]save[/action] -->';
                }

                /*
                 * hldgModule can be executed in two situations:
                 * 1) After each update or delete action on a record of FACIC
                 * 2) After several update or delete actions on FACIC
                 *
                 * hldgModule is executed only when  $_REQUEST['hldg']=='execute'
                 */
                if ($_REQUEST["title"] && $_REQUEST['hldg']=='execute'){
                    $hldgModule = new hldgModule($_SESSION['centerCode'], BVS_ROOT_DIR."/".HLDGMODULE, $configurator->getPath2Facic(), $configurator->getPath2Holdings(), $configurator->getPath2Title(), HLDGMODULE_TAG, BVS_DIR."/cgi-bin/", BVS_TEMP_DIR);
                    $call = $hldgModule->execute($_REQUEST["title"], HLDGMODULE_DEBUG);
                    echo '<!-- [action]holdings[/action] -->';
                }
            }
            break;

        case 'new':
            if($listRequest == "mask" ) {
                $smarty->assign("collectionMask",$dataModel->getAllNameMask());
                $smarty->assign("mfnMask",$dataModel->getAllMfnMask());
            }
            $smarty->assign("formRequest",$listRequest);
            $smarty->assign("dataRecord",array());
            break;

        case 'list':

            $smartyTemplate = "list";
            if(isset($_REQUEST["searchExpr"]) && $_REQUEST["searchExpr"] != "") {
                $smarty->assign("searcExpr",$_REQUEST["searchExpr"]);
            }
            if($dataModel != false){
                //search in Database to show a List(YUI datatable)
                $smarty->assign("dataSource", $dataModel->getRecords());
                $smarty->assign("totalRecords", $dataModel->getTotalRecords());
            }
            exportTitle($_GET["export"]);

            //FACIC
            if ($listRequest == 'facic'){
                $mask = new mask();
                $collectionMask = $dataModel->getAllNameMask();
                $smarty->assign("collectionMask",$collectionMask);
                $futureIssues = new futureIssues();
                $yCurrent = $_REQUEST['initialDate'];
                if ( $dataModel->getTotalRecords() == 0){
                    if ($_REQUEST["maskId"]){
                        $maskId = $_REQUEST["maskId"];

                    }
                } else {
                    $last = $dataModel->lastFacicData();
                    $yCurrent = $last[911];
                    $test = array_search($last[910],$collectionMask);
                    if ( $collectionMask[$test] == $last[910]  ){
                        $maskId = $last[910];
                    } else {
                        $maskId = '';
                    }
                }
                $smarty->assign("currentMask",$maskId);

                $x='var initialVolume = "'.$_REQUEST["initialVolume"].'";'."\n";
                $x.='var initialNumber = "'.$_REQUEST["initialNumber"].'";'."\n";
                $x .= 'var collectionMask = new Array('.count($collectionMask).');' . "\n" ;
                for ($i=0;$i<count($collectionMask);$i++){
                    $x .= 'collectionMask['.$i.'] = "'.str_replace(chr(92),chr(92).chr(92),$collectionMask[$i]).'";'."\n" ;
                }
                for ($y=$yCurrent;$y < date("Y"); $y++){
                    $yearList[] = $y;
                }
                $smarty->assign("x",$x);
                $smarty->assign("yearList",$yearList);
            }
            break;

        case 'confirm_delete':
            if ($_POST["recid"]){
            echo "<!-- [recid]".$_POST["recid"]."[/recid] -->";

            } else {
            user_warning($BVS_LANG["confirmDelete"]);
            }
            break;

        case 'delete':
            $dataModel->deleteRecord($_GET["delete"]);
            if ($_GET["m"] == 'titleplus'){
                if ($_REQUEST["title"]){
                    $facicList = new facicOperations();
                    $facicList->multipleDelete($_REQUEST["title"]);
                }
            }
            if ($_GET["m"] == 'facic'){
                
                /*
                 * The implementation of this section is made when the user
                 * does "save" for the records marked as D in the list of FACIC
                 * getting unnecessary reload the list
                 */
                if ($_REQUEST["recid"]){
                   /*
                    * echo obligatory, used as a return of execution and
                    * used in facic.list.tpl.php
                    */
                    echo "<!-- [request]";
                    var_dump($_REQUEST);
                    echo "[/request] -->";
                    echo "<!-- [recid]".$_REQUEST["recid"]."[/recid] -->";
                    echo "<!-- [mfn]deleted[/mfn] -->";
                    echo '<!-- [action]delete[/action] -->';
                }
                if ($_REQUEST["title"] && $_REQUEST['hldg']=='execute'){
                    $hldgModule = new hldgModule($_SESSION['centerCode'],BVS_ROOT_DIR."/".HLDGMODULE, $configurator->getPath2Facic(), $configurator->getPath2Holdings(), $configurator->getPath2Title(), HLDGMODULE_TAG, BVS_DIR."/cgi-bin/", BVS_TEMP_DIR);
                    $call = $hldgModule->execute($_REQUEST["title"], HLDGMODULE_DEBUG);
                    echo '<!-- [action]holdings[/action] -->';
                }
            } else {
                
                /*
                 * For other databases, the list of its records is reloaded
                 * after the implementation of delete
                 */
                $smartyTemplate = "list";
                //search in Database to show a List(YUI datatable)
                if(isset($_GET["m"]) && !preg_match("=/=",$_GET["m"]) && $_GET["m"]!=""){
                    if(isset($_REQUEST["searchExpr"]) && $_REQUEST["searchExpr"] != "") {
                        $smarty->assign("searcExpr",$_REQUEST["searchExpr"]);
                    }
                    $smarty->assign("dataSource",$dataModel->getRecords());
                    $smarty->assign("totalRecords",$dataModel->getTotalRecords());
                }
            }
            break;
        case 'no_action':
            //Logged user - no action
            unset($_GET["action"]);
            $page = 'index';
            $smartyTemplate = "homepage";
            $listRequest = "homepage";
            break;
        case 'save?':
            // part 1 - Open a form to edit a record
            $smartyTemplate = "form";
            $editRequest = $_POST["mfn"];

            // part 2
/*
 * Para atualizar um registro TitlePlus já existente.
 */
            if($listRequest == "titleplus") {
                $titleSearch = new titleplus();
                $titleFound = $titleSearch->searchByTitle($_GET["title"]);
                if ($titleFound) {
                    $editRequest = $titleFound->registro->mfn;
                    if(is_array($_REQUEST["field"])) {
                        $dataModel->createRecord($_REQUEST["field"]);
                        if(is_int((int)$_REQUEST["mfn"]) && $_REQUEST["mfn"] != 0) {
                            $dataModel->saveRecord($_REQUEST["mfn"]);  //Updating a register
                        }
                    }
                }else {
/*
 * Para criar um novo registro TitlePlus apartir da planilha da Title.
 */
                    if(is_array($_REQUEST["field"])) {
                        $dataModel->createRecord($_REQUEST["field"]);
                        $dataModel->saveRecord("New");  //new register
                    }
                }
            }
            $smarty->assign("formRequest",$listRequest);

            if($listRequest == "mask" || $listRequest == "facic") {
                $smarty->assign("collectionMask",$dataModel->getAllNameMask());
            }
            $smarty->assign("dataRecord",$dataModel->getRecordByMFN($editRequest));
            break;
        case 'edit?':
            
            $smartyTemplate = "form";
            $editRequest = $_GET["edit"];

            if($listRequest == "titleplus"){
                $titleSearch = new titleplus();
                $titleFound = $titleSearch->searchByTitle($_GET["title"]);

                if ($titleFound){
                    $editRequest = $titleFound->registro->mfn;
                    $_GET["edit"] = $editRequest;
                }else{
                    $_GET["edit"] = "";
                    $_GET["action"] = "new";
                }
            }

            $smarty->assign("formRequest",$listRequest);
            if($listRequest == "mask" || $listRequest == "facic") {
                $smarty->assign("collectionMask",$dataModel->getAllNameMask());
            }
            $smarty->assign("dataRecord",$dataModel->getRecordByMFN($editRequest));
            break;

         case 'export':

            $openExportedFile = displayExport();
            if($openExportedFile == "no content"){
                //user_error($openExportedFile, E_USER_ERROR);
            }else{
                header("Location: ".$openExportedFile);
            }
            break;
    }


    // Add a Title in $titleCode - to use in Issues and TitlePlus
    if(isset($_GET["title"]) && !preg_match("=/=",$_GET["title"])) {
        $smarty->assign("titleCode",$_GET["title"]);
    }

    switch ($listRequest) {
    case "users":
        //After save own profile, user redirect to homepage
        if($_SESSION["role"] != "Administrator" && $smartyTemplate == "list"){
            $listRequest = "homepage";
            $smartyTemplate = "homepage";
            $_GET["m"] = "";
        }
        list($libraryName, $libraryCode) = getAllLibraries();
        $smarty->assign("collectionLibrary",$libraryName);
        $smarty->assign("codesLibrary",$libraryCode);

        break;
    case "titleplus":
        if($smartyTemplate == "form"){
        $TITLE_CONTENT = titPlusHeaderInfo($listRequest, $smartyTemplate, $_GET["title"]);
        $smarty->assign("OBJECTS_TITLE",$TITLE_CONTENT);
        }
        break;
    case "report":
        list($libraryName, $libraryCode) = getAllLibraries();
        $smarty->assign("collectionLibrary",$libraryName);
        $smarty->assign("codesLibrary",$libraryCode);
        $smarty->assign("listRequestReport","report");
        $smartyTemplate = "homepage";
        break;
    case "maintenance":
        list($libraryName, $libraryCode) = getAllLibraries();
        $smarty->assign("collectionLibrary",$libraryName);
        $smarty->assign("codesLibrary",$libraryCode);
        $smarty->assign("listRequestReport","report");
        $smartyTemplate = "homepage";
        break;
    }
		
}
}

// Register main Smarty Template variables, $smartyTemplate and $listRequest
$smarty->assign("smartyTemplate",$smartyTemplate);
$smarty->assign("listRequest",$listRequest);
$vars = array();
$smarty->assign("OBJECTS",$vars);
$smarty->assign("BVS_CONF",$BVS_CONF);
$smarty->assign("BVS_LANG",$BVS_LANG);
// Displays the template assembled
$smarty->assign("today",date("Ymd"));
$smarty->display($page.'.tpl.php');

?>