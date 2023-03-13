<?php
/*
This is the page with the logic to display the main form of ODDS
Modifications:
20221210 fho4abcd Full rewrite (use msgstr,....)
20230223 fho4abcd Check for existence of config.php
*/
session_start(); 
//The check for logged in is not done here (also no timeout etc)
include("../central/common/get_post.php");
$arrHttp["base"]="odds";
if (isset($arrHttp["lang"]) and $arrHttp["lang"]!=""){
	$_SESSION["lang"]=$arrHttp["lang"];
	$lang=$arrHttp["lang"];
}else{
	if (!isset($_SESSION["lang"])) $_SESSION["lang"]=$lang;
}

include("../central/config_inc_check.php");
include("../central/config.php");
$lang=$_SESSION["lang"];

include("../central/lang/admin.php");
include("../central/lang/odds.php");// note that the labels in this file may be used in other translations
include("../central/common/header.php");
$commentbox='';
$red_star="<font color=red>*</font>";// red star to indicate mandatory fields
$module_odds="Y";
/*
** This function is used by the get and post methods
** Note that some parameters in Get have a readable name while the POST equivalents use tagxxx names
*/
$variable_fields = array();
$variable_fields['referer']="";
if ( $_SERVER['REQUEST_METHOD']==="POST") {
    $level      = isset($arrHttp['tag006']) ? trim($arrHttp['tag006']) : "";
    $commentbox = isset($arrHttp['tag068']) ? trim($arrHttp['tag068']) : "";
    $odds_name  = isset($arrHttp['tag510']) ? trim($arrHttp['tag510']) : "";
    $phone      = isset($arrHttp['tag512']) ? trim($arrHttp['tag512']) : "";
    $category   = isset($arrHttp['tag520']) ? trim($arrHttp['tag520']) : "";
    $email      = isset($arrHttp['tag528']) ? trim($arrHttp['tag528']) : "";
    $id         = isset($arrHttp['tag630']) ? trim($arrHttp['tag630']) : "";
    $mfn        = isset($arrHttp['tag999']) ? trim($arrHttp['tag999']) : "";
    if ($level != '') {
        $variable_fields['tag010'] = isset($arrHttp['tag010']) ? $arrHttp['tag010'] : "";
        $variable_fields['tag012'] = isset($arrHttp['tag012']) ? $arrHttp['tag012'] : "";
        $variable_fields['tag016'] = isset($arrHttp['tag016']) ? $arrHttp['tag016'] : "";
        $variable_fields['tag018'] = isset($arrHttp['tag018']) ? $arrHttp['tag018'] : "";
        $variable_fields['tag020'] = isset($arrHttp['tag020']) ? $arrHttp['tag020'] : "";
        $variable_fields['tag021'] = isset($arrHttp['tag021']) ? $arrHttp['tag021'] : "";
        $variable_fields['tag030'] = isset($arrHttp['tag030']) ? $arrHttp['tag030'] : "";
        $variable_fields['tag031'] = isset($arrHttp['tag031']) ? $arrHttp['tag031'] : "";
        $variable_fields['tag032'] = isset($arrHttp['tag032']) ? $arrHttp['tag032'] : "";
        $variable_fields['tag053'] = isset($arrHttp['tag053']) ? $arrHttp['tag053'] : "";
        $variable_fields['tag064'] = isset($arrHttp['tag064']) ? $arrHttp['tag064'] : "";
        $variable_fields['tag065'] = isset($arrHttp['tag065']) ? $arrHttp['tag065'] : "";
        $variable_fields['tag086'] = isset($arrHttp['tag086']) ? $arrHttp['tag086'] : "";
        $variable_fields['tag116'] = isset($arrHttp['tag116']) ? $arrHttp['tag116'] : "";
        $variable_fields['tag117'] = isset($arrHttp['tag117']) ? $arrHttp['tag117'] : "";
        $variable_fields['tag118'] = isset($arrHttp['tag118']) ? $arrHttp['tag118'] : "";
        $variable_fields['tag217'] = isset($arrHttp['tag217']) ? $arrHttp['tag217'] : "";
        $variable_fields['tag218'] = isset($arrHttp['tag218']) ? $arrHttp['tag218'] : "";
        $variable_fields['tag590'] = isset($arrHttp['tag590']) ? $arrHttp['tag590'] : "";
        $variable_fields['tag900'] = isset($arrHttp['tag900']) ? $arrHttp['tag900'] : "";
        $variable_fields['tag900_other'] = isset($arrHttp['tag900_other']) ? $arrHttp['tag900_other'] : "";
    }
}else {
    $level      = isset($_GET['level']) ? trim($_GET['level']) : "";
    // commentbox not used here
    $odds_name  = isset($_GET['name']) ? utf8_decode((trim($_GET['name']))) : "";
    $phone      = isset($_GET['phone']) ? trim($_GET['phone']) : "";
    $category   = isset($_GET['category']) ? trim($_GET['category']) : "";
    $email      = isset($_GET['email']) ? trim($_GET['email']) : "";
    $id         = isset($_GET['id']) ? trim($_GET['id']) : "";
    $mfn        = isset($_GET['mfn']) ? trim($_GET['mfn']) : "";
    // variable fields 
    if ($level != '') {
        $variable_fields['tag010'] = isset($_GET['tag010']) ? utf8_encode(trim($_GET['tag010'])) : "";
        $variable_fields['tag012'] = isset($_GET['tag012']) ? utf8_encode(trim($_GET['tag012'])) : "";
        $variable_fields['tag016'] = isset($_GET['tag016']) ? utf8_encode(trim($_GET['tag016'])) : "";
        $variable_fields['tag018'] = isset($_GET['tag018']) ? utf8_encode(trim($_GET['tag018'])) : "";
        $variable_fields['tag020'] = isset($_GET['tag020']) ? utf8_encode(trim($_GET['tag020'])) : "";
        $variable_fields['tag021'] = isset($_GET['tag021']) ? utf8_encode(trim($_GET['tag021'])) : "";
        $variable_fields['tag030'] = isset($_GET['tag030']) ? utf8_encode(trim($_GET['tag030'])) : "";
        $variable_fields['tag031'] = isset($_GET['tag031']) ? utf8_encode(trim($_GET['tag031'])) : "";
        $variable_fields['tag032'] = isset($_GET['tag032']) ? utf8_encode(trim($_GET['tag032'])) : "";
        $variable_fields['tag053'] = isset($_GET['tag053']) ? utf8_encode(trim($_GET['tag053'])) : "";
        $variable_fields['tag064'] = isset($_GET['tag064']) ? utf8_encode(trim($_GET['tag064'])) : "";
        $variable_fields['tag065'] = isset($_GET['tag065']) ? utf8_encode(trim($_GET['tag065'])) : "";
        $variable_fields['tag086'] = isset($_GET['tag086']) ? utf8_encode(trim($_GET['tag086'])) : "";
        $variable_fields['tag116'] = isset($_GET['tag116']) ? utf8_encode(trim($_GET['tag116'])) : "";
        $variable_fields['tag117'] = isset($_GET['tag117']) ? utf8_encode(trim($_GET['tag117'])) : "";
        $variable_fields['tag118'] = isset($_GET['tag118']) ? utf8_encode(trim($_GET['tag118'])) : "";
        $variable_fields['tag217'] = isset($_GET['tag217']) ? utf8_encode(trim($_GET['tag217'])) : "";
        $variable_fields['tag218'] = isset($_GET['tag218']) ? utf8_encode(trim($_GET['tag218'])) : "";
        $variable_fields['tag590'] = isset($_GET['tag590']) ? utf8_encode(trim($_GET['tag590'])) : "";
        $variable_fields['tag900'] = isset($_GET['tag900']) ? utf8_encode(trim($_GET['tag900'])) : "";
        $variable_fields['tag900_other'] = isset($_GET['tag900_other']) ? utf8_encode(trim($_GET['tag900_other'])) : "";
        if (isset($_GET['sa'])) {
            if (trim($_GET['sa'])=="sa") {
                $variable_fields['referer']="sa";
            }
        } else {
            if (strpos($_SERVER["HTTP_REFERER"], "/iah/") !== FALSE) {
                $variable_fields['referer'] = "iah";
            }
            else if (isset($_GET['referer']) && $_GET['referer'] != "") {
                $variable_fields['referer'] = "iah";
            }
        }
    }
}
$referer = $variable_fields['referer'];     
?>
<body>
<script type="text/javascript" src="/assets/js/jquery-1.4.2.min.js"></script>
<script language="javascript">
// Function to trim in javascript
function jstrim (myString) {
    return myString.replace(/^\s+/g,'').replace(/\s+$/g,'')
}  
//---------------------------------------------
// Three functions to hide show an input field
function check(last) {
    var el = document.getElementById("select_source");
    var str = el.options[el.selectedIndex].value;
    if(str == last) {
        show();
    }else {
        hide();
    }
}

function hide(){
    document.getElementById('tag900_other').style.visibility='hidden';
}
function show(){
    document.getElementById('tag900_other').style.visibility='visible';
}

//---------------------------------------------
// Functions to check the validity of elements
function getTextOfLabel(el) {
   var idVal = el.id;
   labels = document.getElementsByTagName('label');
   for( var i = 0; i < labels.length; i++ ) {
      if (labels[i].htmlFor == idVal)
           return labels[i].textContent;
   }
   return "getTextOfLabel:notfound";
}
function func_email(value,label) {
    const re = /^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i;
    if (!value.match(re)) {
        return "<?php echo $msgstr['odds_valid_mail'].': <b>'?>"+label+"</b><br>";
    }
    return ""
}
function func_pages_initial(value,label) {
    // this function checks the value of the current element with fixed element tag021
    // if current is tag021 itself no error will be generated (=correct)
    tag021element=document.getElementById("tag021");
    if ( tag021element!=null ) {
        tag021label=getTextOfLabel(tag021element);
        tag021value=tag021element.value;
        if (parseInt(value)>parseInt(tag021value)) {
            return "<?php echo $msgstr['odds_page_init'].': <b>'?>"+label+"</b> &rarr; <b>"+tag021label+"</b><br>";
        }
    }
    return ""
}
function func_required(value,label) {
    if (value=="" || value===undefined) {
        return "<?php echo $msgstr['odds_setvalue'].': <b>'?>"+label+"</b><br>";
    }
    return ""
}
function func_uint(value,label) {
    const re = /^[0-9]+$/;
    if (value!==undefined && value!="" && !value.match(/^[0-9]+$/)) {
        return "<?php echo $msgstr['odds_int'].': <b>'?>"+label+"</b><br>";
    }
    return ""
}
function func_year(value,label) {
    const re = /^[0-9]+$/;
    if (value!==undefined && value!="" && (!value.match(re)||value.length != 4)) {
        return "<?php echo $msgstr['odds_year'].': <b>'?>"+label+"</b><br>";
    }
    return ""
}
function func_years_validate_majority(value,label) {
    current_year = new Date().getFullYear()
    if (value>current_year) {
        return "<?php echo $msgstr['odds_year_major'].': <b>'?>"+label+"</b><br>";
    }
    return ""
}
function func_years_validate_minority(value,label) {
    var old_year  = 1850;
    if (value<old_year) {
        return "<?php echo $msgstr['odds_year_old'].': <b>'?>"+label+"</b><br>";
    }
    return ""
}
function processInputs(formname){
    inputs=document.forms[formname].getElementsByTagName("input");
    if (inputs<0) return "";
    var odds_errors="";
    for ( var i=0; i<inputs.length; i++) {
        input=inputs[i];
        input_val=inputs[i].value;
        var chkvals_str=input.dataset.jv;/*Get data-jv by dataset object: by name after data- (next dashes are in camelCase)*/
        if (chkvals_str!==undefined){
            label=getTextOfLabel(document.getElementById(input.id));
            chkvals_arr = chkvals_str.trim().split(/\s+/);
            // Process the given checks one by one. A failure stops the checks for this element
            for ( var j=0; j<chkvals_arr.length; j++) {
                chkval=chkvals_arr[j];
                if (chkval=="required") {
                    retstr=func_required(input_val, label);
                    if (retstr!='') {odds_errors+=retstr;break;}
                } else if (chkval=="email") {
                    retstr=func_email(input_val, label);
                    if (retstr!='') {odds_errors+=retstr;break;}
                } else if (chkval=="pages_initial") {
                    retstr=func_pages_initial(input_val, label);
                    if (retstr!='') {odds_errors+=retstr;break;}
                } else if (chkval=="pages_end") {
                    /* no action: already done by pages_initial */
                } else if (chkval=="uint") {
                    retstr=func_uint(input_val, label);
                    if (retstr!='') {odds_errors+=retstr;break;}
                } else if (chkval=="year") {
                    retstr=func_year(input_val, label);
                    if (retstr!='') {odds_errors+=retstr;break;}
                } else if (chkval=="years_validate_majority") {
                    retstr=func_years_validate_majority(input_val, label);
                    if (retstr!='') {odds_errors+=retstr;break;}
                } else if (chkval=="years_validate_minority") {
                    retstr=func_years_validate_minority(input_val, label);
                    if (retstr!='') {odds_errors+=retstr;break;}
                } else {
                    retstr="<?php echo $msgstr['odds_unkn_chkfunc'].': <b>'?>"+chkval+"</b>"+
                        "<?php echo ' '.$msgstr['odds_specjv'].' ' ?>"+
                        "<?php echo ' '.$msgstr['odds_forattr'].': <b>'?>"+label+"</b><br>";
                    odds_errors+=retstr;break;
                }
            }
        }
    }
    return odds_errors;
}
//-------------------------------------------------
// Main function to check elements and submit if OK
function checkAndSubmit() {
    var referer_elem = document.getElementById('referer');
    var referer_elemvalue='notset';
    var odds_errors="";
    const min_odds_length=3;

    document.getElementById('common_error').style.display = 'none';

    // check required values for dropdown. necessary as we do not use the standard submit button id=""
    var categoryElement=document.getElementById("category");
    var categoryIndex=categoryElement.selectedIndex;
    if (categoryIndex<0 || categoryElement.options[categoryIndex].value=="") {
        label=getTextOfLabel(categoryElement);
        odds_errors+="<?php echo $msgstr['odds_setvalue'].': <b>'?>"+label+"</b><br>";
    }
    var levelElement=document.getElementById("level");
    var levelIndex=levelElement.selectedIndex;
    if (levelIndex<0 || levelElement.options[levelIndex].value=="") {
        label=getTextOfLabel(levelElement);
        odds_errors+="<?php echo $msgstr['odds_setvalue'].': <b>'?>"+label+"</b><br>";
    }

    // Check values of all <input> attributes
    odds_errors+=processInputs("forma1");

    // check error due to combination of entries
    var tag012element=document.getElementById('tag012')
    var tag020element=document.getElementById('tag020')
    var tag021element=document.getElementById('tag021')
    if ( tag012element != null && tag020element != null) {
        var init_page = tag020element.value;
        var title = tag012element.value;
        if ( (jstrim(title) != "") && (jstrim(init_page) != "")) {
            var tag012label=getTextOfLabel(tag012element);
            var tag020label=getTextOfLabel(tag020element);
            odds_errors+="<?php echo $msgstr['error_any1'].': <b>'?>"+tag020label+"</b> ";
            odds_errors+="<?php echo $msgstr['error_any2'].': <b>'?>"+tag012label+"</b><br>";
        }
    }  
    if ( tag020element != null && tag021element != null) {
        var init_page = jstrim(tag020element.value);
        var end_page  = jstrim(tag021element.value);
        if ( (init_page=="" && end_page!="") || (init_page!="" && end_page=="")) {
            var tag020label=getTextOfLabel(tag020element);
            var tag021label=getTextOfLabel(tag021element);
            odds_errors+="<?php echo $msgstr['error_both1'].' <b>'?>"+tag020label+"</b> ";
            odds_errors+="<?php echo $msgstr['error_both2'].' <b>'?>"+tag021label+"</b> ";
            odds_errors+="<?php echo $msgstr['error_both3']?>"+"<br>";
        }
    }  
    if ( odds_errors!="") {
        // in case of errors: redisplay the form with the errors text, so the user can correct them
        // search the element that will receive the error text
        document.getElementById("odds_errors").value = odds_errors;
        document.forma1.submit();
    } else {
        // process the form 
        document.forma1.action="process_odds.php";
        document.forma1.submit();
    }
}
</script>
<?php
	include("../central/common/institutional_info.php");
?>
<link href="/assets/css/odds.css" rel="stylesheet" type="text/css">
<div class="sectionInfo">
    <div class="breadcrumb">
	<?php echo $msgstr["odds_form"]?>
    </div>
    <div class="actions">
    <!-- we do not set a back button: might go to ABCD without being logged-in -->
    </div>
		<div class="spacer">&#160;</div>
	</div>
<?php
include "../central/common/inc_div-helper.php";
// Load help file info
include_once("inc_odds_info.php");
$helpinfo = load_info($lang);

// load categories and bibliographic types from .tab files into a $combos entry
include_once("inc_odds_combos.php");
$combos = load_combos($lang);

// functions to process the complex odds_show_controls.tab
include "inc_odds_show_controls.php";
////echo "<hr>".$_SERVER['REQUEST_METHOD']."<hr>";
$optional_inputs="";
$retval=read_odds_show_controls($lang, $level,$variable_fields, $optional_inputs);
////echo "<hr>arrhttp<br>";var_dump($arrHttp);
////echo "<hr>get<br>";var_dump($_GET);
// Show error messages from js
if (isset($arrHttp["odds_errors"])) {
    ?>
    <div style=color:red><?php echo $arrHttp["odds_errors"]?><br></div>
    <?php
}
$odds_errors="";
?>
<div class="middle homepage">
    <div class="mainBox" onmouseover="this.className = 'mainBox mainBoxHighlighted';" onmouseout="this.className = 'mainBox';">
        <div class="boxTop">
          <div class="btLeft">&#160;</div>
          <div class="btRight">&#160;</div>
        </div>    
        <div class="boxContent toolSection ">      
        <div class='welcome'>
            <?php
            $value=$msgstr["welcome"];
            $value = str_replace("[year]", date("Y"), $value);				
            $value = str_replace("[day]", date("j"), $value);
            $value = str_replace("[month]", date("F"), $value);
            echo $value
            ?>
        </div> 
        <div style="display: block; background-image: url(odds_title_back.png); height: 32px; width: 760px; color: #ffffff; font-size:150%; font-weight: bold;  padding-left: 5px;font-family: Verdana, Arial, Helvetica, sans-serif; margin: 0 0 5px; 0 ">
            <?php echo $msgstr['title'];  ?>
        </div>
      
        <div class = 'subtitle'><?php echo $msgstr['subtitle'];?></div>    

        <!-- El archivo que procesa los datos del form -->
        <form method = "post" name="forma1" id="forma1" class='textNove' enctype=”multipart/form-data”>

        <!-- subtitle USER -->      
        <div class="textNove_data"><?php echo $msgstr['subtitle_user']?></div>

        <!-- MFN -->
        <input type="hidden" name="tag999" id="tag999" value= "<?php echo $mfn; ?>" >

        <!-- Id -->
        <label  class='lbl' for="id"><?php echo $msgstr['odds_id']." ".$red_star; ?> </label>
        <input  type="text" value="<?php echo $id; ?>"
                id="id" name="tag630" size="10" maxlength="10" data-jv="required uint">
        <div class = 'subtitle_blank'><?php echo $msgstr['subid']; ?></div>

        <!-- Name -->
        <label  class='lbl'  for="name"><?php echo $msgstr['name']." ".$red_star; ?> </label>
        <input  type="text"  value="<?php echo $odds_name; ?>"
                id="name" name="tag510" size="35" maxlength="35" data-jv="required">
        <div class = 'subtitle_blank'><?php echo $msgstr['subname']; ?></div>

        <!-- additional box -->
        <div class='aditional_box'>
            <?php
            for ($i=0;$i<sizeof($helpinfo);$i++){
                echo $helpinfo[$i];
            } 
            ?>
        </div>

        <!-- user category -->
        <label class='lbl' for="category"><?php echo $msgstr['category']." ".$red_star; ?> </label>
        <select name="tag520" id="category" > 
        <?php
            $selected = false;
            $options = "";
            if ($category == "") {
                echo "<option value='' selected>".$msgstr['odds_selectlevel']."</option>\n";
            }
            foreach ($combos["categoria"] as $key => $value) {
                if ($category == $key) {
                    $options .= "<option value='".$key."' selected>".$value."</option>\n";
                    $selected = true;
                } else {
                    $options .= "<option value='".$key."'>".$value."</option>\n";
                }
            }                
            if (!$selected and $category!='') {
                /* This is the case where an unknown category is supplied in the url*/
                $options .= "<option value='XX' selected>"."XX"."</option>\n";
                $selected = true;
            }
            echo $options;
        ?>
        </select>
        <div class = 'subtitle_blank'></div>

        <!-- Email -->
        <label class='lbl'  for="email"><?php echo $msgstr['email']." ".$red_star; ?> </label>
        <input  type="text" value="<?php echo $email;?>"
                id="email" name="tag528" size="35" maxlength="35" data-jv="email">
        <div class = 'subtitle_blank'></div>
      
        <!-- Phone -->
        <label class='lbl'  for="phone"><?php echo $msgstr['phone']; ?></label>
        <input  type="text" value="<?php echo $phone; ?>"
                id="phone" name="tag512" size="15" maxlength="15" >
        <div class = 'subtitle_blank'></div>

        <!-- DATA-->
        <div class="textNove_data"><?php echo $msgstr['subtitle_request']; ?></div>
        <div class = 'subtitle_blank_ancho'><?php echo $msgstr['subtitle_request_minimal']; ?></div> 

        <!-- level -->
        <label class='lbl'  for="level"><?php echo $msgstr['level']." ".$red_star; ?> </label>      

        <select name="tag006" id="level" onchange='this.form.submit()'>
            <?php
            if ($level == "") {
                echo "<option value='' selected>".$msgstr['odds_selectlevel']."</option>\n";
                foreach ($combos["nivelbiblio"] as $key => $value) {
                    echo "<option value=\"".$key."\">".$value."</option>\n";
                }
            } else {
                // level is loaded
                foreach ($combos["nivelbiblio"] as $key => $value) {
                    if ($level == $key) {
                        echo "<option selected value=\"".$key."\">".$value."</option>\n";
                    } else {
                        echo "<option  value=\"".$key."\">".$value."</option>\n";
                    }
                }
            }
            ?>
        </select>
        <div class = 'subtitle_blank'></div>
        <div id='optionals'></div>
        <?php
        // Here we have to show the optional parameters, dependent on the level
        // This includes a dropdown for ""reference source"
        echo $optional_inputs;
        ?>
        <div class = 'subtitle_blank'></div>
        <!-- Comments -->
        <label class='lbl_comments' for="comments"><?php echo $msgstr['comments']." :"; ?></label>
        <textarea  id="comments" cols="40" rows="5"  name="tag068"
            style="overflow:hidden; resize:none; family: Verdana; font-size: 9 pt; height: 85; font-family: Verdana; background-color: #FFFFFF; color: #000000; maxlegth='100' size='80'"
            ><?php echo $commentbox?></textarea> 
        <div class = 'subtitle_blank'></div>  


        <div id='common_error' style="margin: 0 0 0 345px; color:red; display:none">
          <?php echo $msgstr['error_sar'];?>
        </div>

        <!-- Send --> 
        <p class="form-submit">
            <button class="bt-green" type="button" id="button_submit"
                title="<?php echo $msgstr["send_button"]?>" onclick='javascript:checkAndSubmit();'>
                <i class="fa fa-save"></i> <?php echo $msgstr["send_button"]?></button>
        </p>    

        <!-- Hidden fields -->    
        <?php 
        if ($referer) {
            echo '<input type="hidden" name="referer" id="referer" value="'.$referer.'"  />';
        }
        ?>    
        <input type=hidden name=odds_errors id='odds_errors' type=text value="<?php echo $odds_errors?>" /> 
        </form>     
    </div>      
  </div>
</div>
<?php     
include("../central/common/footer.php");   
