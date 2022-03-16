<?php
session_start();
if (!isset($_SESSION["login"])){
	echo "SESSION EXPIRED";
	die;
}


function LeerLocales(){
global $db_path,$locales,$config_date_format;
	if (file_exists($db_path."circulation/def/".$_SESSION["lang"]."/locales.tab")){
		$locales=parse_ini_file($db_path."circulation/def/".$lang_db."/locales.tab",true);
	}
}

if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../common/get_post.php");
include("../config.php");
$lang=$_SESSION["lang"];
include("../lang/dbadmin.php");
include("../lang/admin.php");
include("../lang/prestamo.php");

//foreach ($arrHttp as $var=>$value) echo "$var = $value<br>";

$currency="";
$xsel11="";
$xsel12="";
$xsel13="";
$xsel21="";
$xsel22="";
$xsel23="";
$xsel31="";
$xsel32="";
$xsel33="";
$arrHttp["base"]="users";


include("../common/header.php");

?>
<script language="JavaScript" type="text/javascript" language=javascript src=../dataentry/js/lr_trim.js></script>
<script>
function LimpiarHorario(Ctrl){
	switch (Ctrl.name){
		case "mon":
			document.forma1.mon_from.value=""
			document.forma1.mon_to.value=""
			break
		case "tue":
			document.forma1.tue_from.value=""
			document.forma1.tue_to.value=""
			break
		case "wed":
			document.forma1.wed_from.value=""
			document.forma1.wed_to.value=""
			break
		case "thu":
			document.forma1.thu_from.value=""
			document.forma1.thu_to.value=""
			break
		case "fri":
			document.forma1.fri_from.value=""
			document.forma1.fri_to.value=""
			break
		case "sat":
			document.forma1.sat_from.value=""
			document.forma1.sat_to.value=""
			break
		case "sun":
			document.forma1.sun_from.value=""
			document.forma1.sun_to.value=""
			break
	}
}

function IsValidTime(timeStr,Day) {
// Checks if time is in HH:MM:SS AM/PM format.
// The seconds and AM/PM are optional.

	var timePat = /^(\d{1,2}):(\d{2})(:(\d{2}))?(\s?(AM|am|PM|pm))?$/;

	var matchArray = timeStr.match(timePat);
	if (matchArray == null) {
		alert(Day+": <?php echo $msgstr["timeformat_inv"]?>");
		return false;
	}
	hour = matchArray[1];
	minute = matchArray[2];
	second = matchArray[4];
	ampm = matchArray[6];

	if (second=="") { second = null; }
	if (ampm=="") { ampm = null }

	if (hour < 0  || hour > 12) {
		alert(Day+": <?php echo $msgstr["hour1_12"]?>");
		return false;
	}
	if (hour <= 12 && ampm == null) {
		alert(Day+": <?php echo $msgstr["am_or_pm"]?>");
		return false;
	}
	if (minute<0 || minute > 59) {
		alert (Day+": <?php echo $msgstr["secs0_59"]?>");
		return false;
	}
	if (second != null && (second < 0 || second > 59)) {
		alert (Day+": <?php echo $msgstr["secs0_59"]?>");
		return false;
	}
	return true;
}
//  End -->


function Guardar(){

//Validación de la abreviatura de la moneda
	if (Trim(document.forma1.currency.value)==""){
		alert("<?php echo $msgstr["ab_mlocal"]?>")
		return
	}

//Validación de los días laborables y el horario

	if (document.forma1.mon.checked){
		Day="<?php echo $msgstr["mon"]?>"
		ix=document.forma1.smon_from.selectedIndex
    	strTime=document.forma1.mon_from.value+" "+document.forma1.smon_from.options[ix].value
    	if (!IsValidTime(strTime,Day)) return
    	ix=document.forma1.smon_to.selectedIndex
    	strTime=document.forma1.mon_to.value+" "+document.forma1.smon_to.options[ix].value
    	if (!IsValidTime(strTime,Day)) return
    }

	if (document.forma1.tue.checked){
	    Day="<?php echo $msgstr["tue"]?>"
	    ix=document.forma1.stue_from.selectedIndex
	    strTime=document.forma1.tue_from.value+" "+document.forma1.stue_from.options[ix].value
	    if (!IsValidTime(strTime,Day)) return
	    ix=document.forma1.stue_to.selectedIndex
	    strTime=document.forma1.tue_to.value+" "+document.forma1.stue_to.options[ix].value
	    if (!IsValidTime(strTime,Day)) return
	 }

	if (document.forma1.wed.checked){
	    Day="<?php echo $msgstr["wed"]?>"
	    ix=document.forma1.swed_from.selectedIndex
	    strTime=document.forma1.wed_from.value+" "+document.forma1.swed_from.options[ix].value
	    if (!IsValidTime(strTime,Day)) return
	    ix=document.forma1.swed_to.selectedIndex
	    strTime=document.forma1.wed_to.value+" "+document.forma1.swed_to.options[ix].value
	    if (!IsValidTime(strTime,Day)) return
	}

    if (document.forma1.thu.checked){
	    Day="<?php echo $msgstr["thu"]?>"
	    ix=document.forma1.sthu_from.selectedIndex
	    strTime=document.forma1.thu_from.value+" "+document.forma1.sthu_from.options[ix].value
	    if (!IsValidTime(strTime,Day)) return
	    ix=document.forma1.sthu_to.selectedIndex
	    strTime=document.forma1.thu_to.value+" "+document.forma1.sthu_to.options[ix].value
	    if (!IsValidTime(strTime,Day)) return
	}

    if (document.forma1.fri.checked){
	    Day="<?php echo $msgstr["fri"]?>"
	    ix=document.forma1.sfri_from.selectedIndex
	    strTime=document.forma1.fri_from.value+" "+document.forma1.sfri_from.options[ix].value
	    if (!IsValidTime(strTime,Day)) return
	    ix=document.forma1.sfri_to.selectedIndex
	    strTime=document.forma1.fri_to.value+" "+document.forma1.sfri_to.options[ix].value
	    if (!IsValidTime(strTime,Day)) return
   	}

   	if (document.forma1.sat.checked){
	    Day="<?php echo $msgstr["sat"]?>"
	    ix=document.forma1.ssat_from.selectedIndex
	    strTime=document.forma1.sat_from.value+" "+document.forma1.ssat_from.options[ix].value
	    if (!IsValidTime(strTime,Day)) return
	    ix=document.forma1.ssat_to.selectedIndex
	    strTime=document.forma1.sat_to.value+" "+document.forma1.ssat_to.options[ix].value
	    if (!IsValidTime(strTime,Day)) return
	}

	if (document.forma1.sun.checked){
	    Day="<?php echo $msgstr["sun"]?>"
	    ix=document.forma1.ssun_from.selectedIndex
	    strTime=document.forma1.sun_from.value+" "+document.forma1.ssun_from.options[ix].value
	    if (!IsValidTime(strTime,Day)) return
	    ix=document.forma1.ssun_to.selectedIndex
	    strTime=document.forma1.sun_to.value+" "+document.forma1.ssun_to.options[ix].value
	    if (!IsValidTime(strTime,Day)) return
	}
    document.forma1.submit()

}

function Test(){
	if (document.forma1.Mfn.value==""){
		alert("<?php echo $msgstr["test_mfn_err"]?>")
		return
	}
    msgwin_t=window.open("","TestPft","")
    msgwin_t.focus()
	document.forma1.action="borrowers_configure_test.php"
	document.forma1.target="TestPft";
	document.forma1.submit()
}
</script>
</script>
<?php
$encabezado="";
include("../common/institutional_info.php");
?>

		<div class="sectionInfo">
			<div class="breadcrumb">
				<?php echo $msgstr["local"];?>
			</div>
			<div class="actions">

			<?php 
				include "../common/inc_home.php";

				$backtoscript="configure_menu.php?encabezado=s";
				include "../common/inc_back.php";

 				$savescript="javascript:Guardar()";
 				include "../common/inc_save.php";
 			?>

			</div>
			<div class="spacer">&#160;</div>
		</div>

		<?php
			$ayuda="/circulation/locales.html";
			include "../common/inc_div-helper.php" 
		?>



		<div class="middle form">
			<div class="formContent">

			<form name="forma1" action="locales_update.php" method="post">
			<input type="hidden" name="base" value="<?php echo $arrHttp["base"];?>">

			<?php

			// Se lee la tabla con los valores locales
			$locales["currency"]="";
			$locales["fine"]="";
			$locales["date1"]="";
			$locales["date2"]="";
			for ($i=0;$i<7;$i++){
				$locales[$i]["from"]="";
				$locales[$i]["to"]="";
				$locales[$i]["f_ampn"]="";
				$locales[$i]["t_ampn"]="";
			}
			$archivo=$db_path."circulation/def/".$_SESSION["lang"]."/locales.tab";
			if (!file_exists($archivo)) $archivo=$db_path."circulation/def/".$lang_db."/locales.tab";
			if (file_exists($archivo)){
				$locales=parse_ini_file($archivo,true,INI_SCANNER_RAW);
			}

			for ($i=0;$i<7;$i++){
				
				if (!isset($locales[$i]["from"])){
				   $locales[$i]["from"]="";
				}
				
				if (!isset($locales[$i]["to"])) {     
					$locales[$i]["to"]="";
				}
				
				if (!isset($locales[$i]["f_ampm"])) {
					$locales[$i]["f_ampm"]="";
				}
				
				if (!isset($locales[$i]["t_ampm"])) {
					$locales[$i]["t_ampm"]="";
				}		

			}

	// /bases/circulations/lang/currencies.tab
	//Function Displays currencies.tab
	function currencies() {
	    global $msgstr,$db_path, $locales;
	    if (file_exists($db_path."/circulation/def/".$_SESSION["lang"]."/currencies.tab")){
	            $fp = file($db_path."/circulation/def/".$_SESSION["lang"]."/currencies.tab");
	            echo $fp;
	       } else {
	           if (file_exists($db_path."/circulation/def/en/currencies.tab"))
	           $fp = file($db_path."/circulation/def/en/currencies.tab");
	        echo $fp;
	       }
	    if (isset($fp)){
	        echo '<option value="">'.$msgstr["select"].'</option>';
	        foreach ($fp as $value){
	            if (trim($value)!=""){
	                $pp=explode('|',$value);

	                $ver_sortkey=$locales["currency"];

	               if (trim($pp[0]) == $ver_sortkey) {
	                   $selected = 'selected';
	               } else {
	                   $selected = "";
	               }
	               echo '<option value="' . trim($pp[0]) . '" '.$selected.'>'.$pp[1].'('.trim($pp[0]).')</option>';
	            }
	        }
	    }

	}
?>


	<div class="col-2">
		<label><?php echo $msgstr["currency"];?></label>
		<select name="currency"  >
			<?php echo currencies();?>
		</select>
	</div>
	<br>
	<div class="col-2">
		<label><?php echo $msgstr["fine"];?></label>
		<input type="text" size="10" name="fine" value="<?php echo $locales["fine"];?>">
	</div>
	<br>
	<div class="col-2">
		<label><?php echo $msgstr["dateformat"];?></label>
		<input type="text" size="10" disabled value="<?php echo $config_date_format;?>">
	</div>
	<br>
		<label><?php echo $msgstr["workingdays"];?> / <?php echo $msgstr["workinghours"];?> (<?php echo $msgstr["ejem"].": ".$msgstr["from"]." 8:30am &nbsp;".$msgstr["to"]." 6:30 pm;";?>)</label>



	<br><br>
	<div>
		<input type="checkbox" name="mon" value="mon" onclick="LimpiarHorario(this)" <?php if (trim($locales["1"]["from"])!="" and trim($locales["1"]["to"]!="")) echo "checked"; ?> > <?php echo $msgstr["mon"];?><br>
		
		<?php echo $msgstr["from"];?> <input type="text" name="mon_from" size=4 value="<?php echo $locales["1"]["from"];?>">
			<select name="smon_from">
				<option value="am" <?php if ($locales["1"]["f_ampm"]=="am") echo " selected";?> >am</option>
				<option value="pm" <?php if ($locales["1"]["f_ampm"]=="pm") echo " selected";?> >pm</option>
			</select>

		<?php echo $msgstr["to"];?>:
		<input type="text" name="mon_to" size="4" value="<?php echo $locales["1"]["to"];?>">
			<select name="smon_to">
				<option value="am" <?php if ($locales["1"]["t_ampm"]=="am") echo " selected";?> >am</option>
				<option value="pm" <?php if ($locales["1"]["t_ampm"]=="pm") echo " selected";?> >pm</option>
		</select>

	</div>
	<br>

	<div>
		<input type="checkbox" name="tue" value="tue" onclick="LimpiarHorario(this)" <?php if (trim($locales["2"]["from"])!="" and trim($locales["2"]["to"]!="")) echo "checked"; ?> > <?php echo $msgstr["tue"];?><br>
		
		<?php echo $msgstr["from"];?> <input type="text" name="tue_from" size=4 value="<?php echo $locales["2"]["from"];?>">
			<select name="stue_from">
				<option value="am" <?php if ($locales["2"]["f_ampm"]=="am") echo " selected";?> >am</option>
				<option value="pm" <?php if ($locales["2"]["f_ampm"]=="pm") echo " selected";?> >pm</option>
			</select>

		<?php echo $msgstr["to"];?>:
		<input type="text" name="tue_to" size="4" value="<?php echo $locales["2"]["to"];?>">
			<select name="stue_to">
				<option value="am" <?php if ($locales["2"]["t_ampm"]=="am") echo " selected";?> >am</option>
				<option value="pm" <?php if ($locales["2"]["t_ampm"]=="pm") echo " selected";?> >pm</option>
		</select>

	</div>
	<br>


	<div>
		<input type="checkbox" name="wed" value="wed" onclick="LimpiarHorario(this)" <?php if (trim($locales["3"]["from"])!="" and trim($locales["3"]["to"]!="")) echo "checked"; ?> > <?php echo $msgstr["wed"];?><br>
		
		<?php echo $msgstr["from"];?> <input type="text" name="wed_from" size=4 value="<?php echo $locales["3"]["from"];?>">
			<select name="swed_from">
				<option value="am" <?php if ($locales["3"]["f_ampm"]=="am") echo " selected";?> >am</option>
				<option value="pm" <?php if ($locales["3"]["f_ampm"]=="pm") echo " selected";?> >pm</option>
			</select>

		<?php echo $msgstr["to"];?>:
		<input type="text" name="wed_to" size="4" value="<?php echo $locales["3"]["to"];?>">
			<select name="swed_to">
				<option value="am" <?php if ($locales["3"]["t_ampm"]=="am") echo " selected";?> >am</option>
				<option value="pm" <?php if ($locales["3"]["t_ampm"]=="pm") echo " selected";?> >pm</option>
		</select>

	</div>
	<br>

	<div>
		<input type="checkbox" name="thu" value="thu" onclick="LimpiarHorario(this)" <?php if (trim($locales["4"]["from"])!="" and trim($locales["4"]["to"]!="")) echo "checked"; ?> > <?php echo $msgstr["thu"];?><br>
		
		<?php echo $msgstr["from"];?> <input type="text" name="thu_from" size=4 value="<?php echo $locales["4"]["from"];?>">
			<select name="sthu_from">
				<option value="am" <?php if ($locales["4"]["f_ampm"]=="am") echo " selected";?> >am</option>
				<option value="pm" <?php if ($locales["4"]["f_ampm"]=="pm") echo " selected";?> >pm</option>
			</select>

		<?php echo $msgstr["to"];?>:
		<input type="text" name="thu_to" size="4" value="<?php echo $locales["4"]["to"];?>">
			<select name="sthu_to">
				<option value="am" <?php if ($locales["4"]["t_ampm"]=="am") echo " selected";?> >am</option>
				<option value="pm" <?php if ($locales["4"]["t_ampm"]=="pm") echo " selected";?> >pm</option>
		</select>

	</div>
	<br>

	<div>
		<input type="checkbox" name="fri" value="fri" onclick="LimpiarHorario(this)" <?php if (trim($locales["5"]["from"])!="" and trim($locales["5"]["to"]!="")) echo "checked"; ?> > <?php echo $msgstr["fri"];?><br>
		
		<?php echo $msgstr["from"];?> <input type="text" name="fri_from" size=4 value="<?php echo $locales["5"]["from"];?>">
			<select name="sfri_from">
				<option value="am" <?php if ($locales["5"]["f_ampm"]=="am") echo " selected";?> >am</option>
				<option value="pm" <?php if ($locales["5"]["f_ampm"]=="pm") echo " selected";?> >pm</option>
			</select>

		<?php echo $msgstr["to"];?>:
		<input type="text" name="fri_to" size="4" value="<?php echo $locales["5"]["to"];?>">
			<select name="sfri_to">
				<option value="am" <?php if ($locales["5"]["t_ampm"]=="am") echo " selected";?> >am</option>
				<option value="pm" <?php if ($locales["5"]["t_ampm"]=="pm") echo " selected";?> >pm</option>
		</select>

	</div>
	<br>

	<div>
		<input type="checkbox" name="sat" value="sat" onclick="LimpiarHorario(this)" <?php if (trim($locales["6"]["from"])!="" and trim($locales["6"]["to"]!="")) echo "checked"; ?> > <?php echo $msgstr["sat"];?><br>
		
		<?php echo $msgstr["from"];?> <input type="text" name="sat_from" size=4 value="<?php echo $locales["6"]["from"];?>">
			<select name="ssat_from">
				<option value="am" <?php if ($locales["6"]["f_ampm"]=="am") echo " selected";?> >am</option>
				<option value="pm" <?php if ($locales["6"]["f_ampm"]=="pm") echo " selected";?> >pm</option>
			</select>

		<?php echo $msgstr["to"];?>:
		<input type="text" name="sat_to" size="4" value="<?php echo $locales["6"]["to"];?>">
			<select name="ssat_to">
				<option value="am" <?php if ($locales["6"]["t_ampm"]=="am") echo " selected";?> >am</option>
				<option value="pm" <?php if ($locales["6"]["t_ampm"]=="pm") echo " selected";?> >pm</option>
		</select>

	</div>
	<br>

	<div>
		<input type="checkbox" name="sun" value="sun" onclick="LimpiarHorario(this)" <?php if (trim($locales["0"]["from"])!="" and trim($locales["0"]["to"]!="")) echo "checked"; ?> > <?php echo $msgstr["sun"];?><br>
		
		<?php echo $msgstr["from"];?> <input type="text" name="sun_from" size=4 value="<?php echo $locales["0"]["from"];?>">
			<select name="ssun_from">
				<option value="am" <?php if ($locales["0"]["f_ampm"]=="am") echo " selected";?> >am</option>
				<option value="pm" <?php if ($locales["0"]["f_ampm"]=="pm") echo " selected";?> >pm</option>
			</select>

		<?php echo $msgstr["to"];?>:
		<input type="text" name="sun_to" size="4" value="<?php echo $locales["0"]["to"];?>">
			<select name="ssun_to">
				<option value="am" <?php if ($locales["0"]["t_ampm"]=="am") echo " selected";?> >am</option>
				<option value="pm" <?php if ($locales["0"]["t_ampm"]=="pm") echo " selected";?> >pm</option>
		</select>

	</div>

	<br>

</div>
</div>

<?php include("../common/footer.php");?>