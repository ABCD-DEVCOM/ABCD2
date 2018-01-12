<?php
session_start(); 

// desplegar la categoría del usuario para solicitarla
$askCategory = true;
$referer = false;
if (isset($_GET['resize'])) {
  if ($_GET['resize'] == 'yes') {
      echo "<script language=\"JavaScript\" type=\"text/javascript\"> 
      window.resizeTo(1300,720); 
      </script>";     
      $referer = true;
  }
}

$js = false;
if (isset($_GET['js'])) { 
  if ($_GET['js'] == 'yes') {
      $js = true;
  }
}

if (isset($_GET['referer'])) {
  $referer = true;
}
unset($_SESSION["verifica"]);
if (isset ($_GET['lang'])) {
  if ($_GET['lang'] != "") {
    $lang = $_GET['lang'];
  }
} else {
  include("../../central/config.php");
}

$_SESSION["lang"] = $lang;
include_once("lib/library.php");
//include_once("lib/decoding_urls.php");

$combos = load_combos($lang);


$aditional_info = load_aditional_info($lang);



// To load automatically some inputs  
$id = isset($_GET['id']) ? trim($_GET['id']) : "";
$name = isset($_GET['name']) ? urldecode((trim($_GET['name']))) : "";
$email = isset($_GET['email']) ? trim($_GET['email']) : "";
$phone = isset($_GET['phone']) ? trim($_GET['phone']) : "";
$category = isset($_GET['category']) ? trim($_GET['category']) : "";
$level = isset($_GET['level']) ? trim($_GET['level']) : "";
$mfn = isset($_GET['mfn']) ? trim($_GET['mfn']) : "";

//$email_apoderado = isset($_GET['email_apoderado']) ? trim($_GET['email_apoderado']) : "";

$labels = load_labels($lang, $id, $name, $email, $phone);


if (!$combos || !$labels) { 
  die ("<center><h3>Error to load .par files</h3><h5>Check paths in config files</h5></center>");
}


// variable fields 
$variable_fields = array();
if (isset($_GET['level'])) {
  if (trim($_GET['level']) != '') {
    if ( isset($_GET['tag010'])) {
      $tag10 = utf8_encode(trim($_GET['tag010']));      
      $variable_fields['tag010'] = $tag10;
    }
    $variable_fields['tag012'] = isset($_GET['tag012']) ? utf8_encode(trim($_GET['tag012'])) : "";
    $variable_fields['tag016'] = isset($_GET['tag016']) ? utf8_encode(trim($_GET['tag016'])) : "";
    $variable_fields['tag018'] = isset($_GET['tag018']) ? utf8_encode(trim($_GET['tag018'])) : "";
    $variable_fields['tag030'] = isset($_GET['tag030']) ? utf8_encode(trim($_GET['tag030'])) : "";
    $variable_fields['tag031'] = isset($_GET['tag031']) ? utf8_encode(trim($_GET['tag031'])) : "";
    $variable_fields['tag032'] = isset($_GET['tag032']) ? utf8_encode(trim($_GET['tag032'])) : "";
    $variable_fields['tag020'] = isset($_GET['tag020']) ? utf8_encode(trim($_GET['tag020'])) : "";
    $variable_fields['tag021'] = isset($_GET['tag021']) ? utf8_encode(trim($_GET['tag021'])) : "";
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
    $variable_fields['referer']='';

  
    if (isset($_GET['sa'])) {
      if (trim($_GET['sa'])=="sa") {
        $variable_fields['referer']="sa";
      }
    } else {
      if (strpos($_SERVER["HTTP_REFERER"], "/iah/") !== FALSE) {
        $variable_fields['referer'] = "iah";
      }
      else if (isset($_GET['referer'])) {
        if ($_GET['referer'] != "") {
          $variable_fields['referer'] = "iah";
        }
      }
    }
    $referer = $variable_fields['referer'];     
  }
}

?>
  <!DOCTYPE html>
  <html>
      <head>
      <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
      <title>ODDS</title>
      <meta content="ODDS" name="title">
      <meta content="ODDS" name="description"> 
      <link href="../css/odds.css" rel="stylesheet" type="text/css">  
      <script type="text/javascript" src="js/jquery.min.js"></script>
      <script type="text/javascript" src="js/odds.js"></script>
      <script type="text/javascript" src="js/JV.js"></script>
      <script type="text/javascript">
       function checkSAR() {   
          document.getElementById('common_error').style.display = 'none';
          //alert(document.getElementById('referer').value);
          if (document.getElementById('referer').value =='sar') {
              if (  document.getElementById('tag020') != null && document.getElementById('tag012') != null) { 
                var init_page = document.getElementById('tag020').value;
                var title = document.getElementById('tag012').value;
                if ( (trim(title) == "") && (trim(init_page) == "")) {
                    document.getElementById('common_error').style.display = 'block';
                    document.getElementById('tag012').focus();
                    return false;
                } else {
                    document.getElementById('common_error').style.display = 'none';
                    return true;
                    /*
                    document.forma1.action="process_odds.php";
                    document.forma1.submit();
                    */
                }
            }  
          }
        }
        function  show_controls(object, lang_param) {
          if (document.getElementById("level").selectedIndex == 0) {
            document.getElementById("button_submit").disabled=true;    
          }


            var jsdata = <?php echo json_encode($variable_fields); ?>;
            if (object.value == "") {                  
                
                $('[id^="jv_error"]').hide();
                $('#optionals').html('');
            }
            else {
              
                if (document.getElementById("button_submit") != null) {
                  document.getElementById("button_submit").disabled = false;
                }
              
                $.ajax({
                    url: 'lib/show_controls.php',
                    data: {
                        content : object.value,
                        lang : lang_param,
                        jsdata: jsdata
                    },
                    cache: false,
                    type: 'post',
                    success: function (data) {
                        $('#optionals').html('');
                        $('[id^="jv_error"]').hide();
                        $.each($.parseJSON(data), function(key,value) {
                            //alert(value);
                            $('#optionals').append(value);
                        });
                        // recorrer para setear valores!
                        $("[data-jv]").keyup(function() {
                            check_field(this);
                        });
                        $("[data-jv]").bind("input", function() {
                            check_field(this);
                        })
                    }
                });
            }       
          }
        $('input[readonly]').focus(function(){
          this.blur();
        });
      </script>
    </head>
  
<body> 
<?php   
  include("lib/header.php");  
?>  

<div class="middle homepage">
  <div class="mainBox" onmouseover="this.className = 'mainBox mainBoxHighlighted';" onmouseout="this.className = 'mainBox';">
    <div class="boxTop">
      <div class="btLeft">&#160;</div>
      <div class="btRight">&#160;</div>
    </div>    
    <div class="boxContent toolSection ">      
      <div class='welcome'><?php echo $labels['welcome'];?></div> 
      <div style="display: block; background-image: url(lib/odds_title_back.png); height: 32px; width: 760px; color: #ffffff; font-size:150%; font-weight: bold;  padding-left: 5px;font-family: Verdana, Arial, Helvetica, sans-serif; margin: 0 0 5px; 0 "><?php echo $labels['title'];  ?></div>
      
      <div class = 'subtitle'>
          <?php       
            echo $labels['subtitle'];
           ?>
      </div>    

      <!-- El archivo que procesa los datos del form -->
      <form method = "post" name="forma1" id="forma1" class='textNove' >
        <!-- subtitle USER -->      
      <div class="textNove_data">
        <?php 
          echo $labels['subtitle_user']
        ?>        
      </div>
      <!-- MFN -->
      <input type="hidden" name="tag999" id="tag999" value= "<?php echo $mfn; ?>" >

      <!-- Id -->
      <label class='lbl' id="lbl_id"><?php echo $labels['id']." :"; ?> </label>
      <input type="text" value="<?php echo $id; ?>" id="ci" name="tag630" size="10" maxlength="10" <?php if (trim($id)!='')  { echo ' readonly'; echo ' STYLE="background-color:#eeeeee"';} ?>  data-jv="required(<?php echo $lang; ?>) min_length_3(<?php echo $lang; ?>)">
      <div class = 'subtitle_blank'><?php echo $labels['subid']; ?></div>

      <!-- Name -->
      <label class='lbl'  id="lbl_name"><?php echo $labels['name']." :"; ?> </label>
      <input type="text"  value="<?php echo $name; ?>"  id="name" name="tag510" size="35" maxlength="35" <?php if (trim($name)!='')  { echo 'readonly'; echo ' STYLE="background-color:#eeeeee"';} ?> data-jv="required(<?php echo $lang; ?>)">
      <div class = 'subtitle_blank'><?php echo $labels['subname']; ?></div>

      <!-- additional box -->
      <div class='aditional_box'>
      <?php
        echo "<strong>";
        echo $aditional_info[0];
        echo "</strong>";
        echo "<br/>";
        echo $aditional_info[1];
      ?>
      </div>

      <!-- user category -->
      <?php
      if ($askCategory) {
      ?>
      <label class='lbl' id="lbl_category"><?php echo $labels['category']." :"; ?> </label>
      <select name="tag520" id="category" <?php if (trim($category)!='') { echo ' STYLE="background-color:#eeeeee"'; } ?>> 
        <?php
              $selected = false;
              if ($category != "") {
                $options = "";
                foreach ($combos["categoria"] as $key => $value) {                  
                  if ($category == $key) {         
                      $options .= "<option value=\"".$key."\" selected>".$value."</option>\n";                    
                      $selected = true;
                  } else {
                    if  (trim($category)!='')  
                      $options .= "<option disabled value=\"".$key."\">".$value."</option>\n";                 
                  }                  
                }                
                $otros = false;                
                if (!$selected) { 
                    $options = str_replace("disabled value=\"XX\"", "selectd value=\"XX\"", $options);
                    $otros = true;
                    $selected = true;
                }
                if ($category=='XX') {
                  $otros = true;
                }
                echo $options;
              } else {
                $first = true;
                foreach ($combos["categoria"] as $key => $value) {
                  if ($first) {
                    echo "<option value=\"".$key."\" selected>".$value."</option>\n";
                    $first = false;
                  } else {
                    echo "<option value=\"".$key."\">".$value."</option>\n";
                  }
                }
              }  
              echo "</select>";
            } else {              
                echo "<input type='hidden' name='tag520' id='category' value='".$category."'/>";
            }
        ?>  
      <div class = 'subtitle_blank'></div>
      

      <!-- Email -->
      <label class='lbl'  id="lbl_email"><?php echo $labels['email']." :"; ?> </label>
      <input type="text" value="<?php echo $email; /*show_emails($email, $email_apoderado); */?>" id="email" name="tag528" size="35" maxlength="35" <?php if (trim($email)!='')  { echo 'readonly'; echo ' STYLE="background-color:#eeeeee"'; } ?> data-jv="required(<?php echo $lang; ?>) email(<?php echo $lang; ?>)">      
      <div class = 'subtitle_blank'></div>

      <!-- Apoderado -->
      <?php 
      /*
      if ($email_apoderado != "") {
        echo "<label class='lbl'  id='lbl_email_apoderado'>".$labels['email_apoderado']." :</label>";
        echo "<input  type='checkbox' id='email_apoderado_chk' name='email_apoderado_chk' value='yes' />";
        echo "<input  type='hidden' id='email_apoderado' name='tag828' value='". $email_apoderado. "' />";
        echo "<div class = 'subtitle_blank'></div>";
      }
      */
      ?>
      
      <!-- Phone -->
      <label class='lbl'  id="lbl_tel"><?php echo $labels['phone']." :"; ?></label>
      <input type="text" value="<?php echo $phone; ?>" id="phone" name="tag512" size="15" maxlength="15" >
      <div class = 'subtitle_blank'></div>

      <!-- DATA-->
      <div class="textNove_data"><?php echo $labels['subtitle_request']." :"; ?></div>
      
      <?php 
        if (!isset($variable_fields['referer'])) {             
          echo "<div class = 'subtitle_blank_ancho'>";
          echo $labels['subtitle_request_minimal']; 
          echo "</div>";
        } 
      ?>      

      <!-- level -->
      <label class='lbl'  id="lbl_level"><?php echo $labels['level']." :"; ?> </label>      
      <?php 

      if ($variable_fields['referer'] != "") {
        $readonly = ' STYLE="background-color:#eeeeee"  readonly="true" ';
      } else {
        $readonly = '';
      }      
      ?>
      <select <?php  echo $readonly; ?> name="tag006" id="level" onchange="show_controls(this, '<?php echo $lang; ?>')">
            <option value="" selected><?php echo $labels['selectlevel']; ?></option>
            <?php
            // level is loaded
            if ($level != "") {
              foreach ($combos["nivelbiblio"] as $key => $value) {
                  if ($level == $key) {
                    echo "<option selected value=\"".$key."\">".$value."</option>\n";
                  } else {
                    if ($variable_fields['referer'] != "") {
                      echo "<option disabled value=\"".$key."\">".$value."</option>\n";
                    } else {
                      echo "<option  value=\"".$key."\">".$value."</option>\n";
                    }
                  }
              }
              ?>
              <script type='text/javascript'>
                show_controls(document.getElementById("level"), '<?php echo $lang; ?>')
                //document.getElementById("button_submit").disabled = false;
              </script>
              <?php            
            } else {
              foreach ($combos["nivelbiblio"] as $key => $value) {
                echo "<option value=\"".$key."\">".$value."</option>\n";
              }
              ?>
              <script type='text/javascript'>                
                if (document.getElementById("button_submit") != null) {                  
                  //document.getElementById("button_submit").disabled = true;
                }
              </script>
              <?php
            }
            ?>
      </select>
      
      <?php     
        if (!isset($variable_fields['referer'])) { 
          echo "<span class = 'subtitle_blank'>";
          echo $labels['help_select'];       
          echo "</span>";
        } 
      ?>
    <div class = 'subtitle_blank'></div>
    <div id='optionals'></div>

    <div class = 'subtitle_blank'></div>
    <!-- Comments -->
    <label class='lbl_comments' id="lbl_comments"><?php echo $labels['comments']." :"; ?></label>
    <textarea  id="comments" cols="40" rows="5"  name="tag068" style="overflow:hidden; resize:none; family: Verdana; font-size: 9 pt; height: 85; font-family: Verdana; background-color: #FFFFFF; color: #000000; maxlegth='100' size='80'"></textarea> 
    <div class = 'subtitle_blank'></div>  


    <div id='common_error' style="margin: 0 0 0 345px; color:red; display:none">
      <?php echo $labels['error_sar'];?>
    </div>

    <!-- Send --> 
    <p class="form-submit">

          <input type="submit" class="send-button" value="<?php  echo $labels['send_button'] ?>" id="button_submit" onClick="return checkSAR();" />
          <img src="http://static02.olx-st.com/images/spinner.gif" id="spinner" class="spinner" alt="Loading..." width="16" height="16" style="display: none">          
          
          <input onClick="javascript:cleanForm()" type="button" class="send-button" value="<?php  echo $labels['clean_button'] ?>"  />
          
          <?php 
            if ($referer) {
              if ($js) {
                echo '<input type="hidden" name="js" id="js" value="yes"  />';
                echo '<input onclick="javascript:onClick=self.close()" type="button" class="send-button" value="'.$labels['cancel_button'].'"  />';
              }
              if ($referer == 'sa') { 
                echo '<input type="hidden" name="referer" id="referer" value="sar"  />';
              } else {
                echo '<input type="hidden" name="referer" id="referer" value="yes"  />';
              }
            }
          ?>    
    </p>    
<script type='text/javascript'>
        if (document.getElementById("level").selectedIndex == 0) {
            document.getElementById("button_submit").disabled=true;    
        }
</script>
    

    <!-- Hidden fields -->    
    <input type=hidden name=IsisScript value=ingreso.xis />
    <input type=hidden name=Opcion value="crear" /> 
    <input type=hidden name=lang value="<?php  echo $lang; ?>" /> 
    <input type=hidden name=ValorCapturado value="" />
    <input type=hidden name=check_select value="" />
    <input type=hidden name=ver value=S />
    <input type=hidden name=Formato value='odds' />
    <input type=hidden name=tag094 value='0' /> 
    </form>     
    &nbsp;<br/>&nbsp;<br/>&nbsp;&nbsp;<br/>&nbsp;<br/>&nbsp;
    </div>      
    <div class="spacer">&nbsp;</div>
    <div class="boxBottom">
      <div class="bbLeft">&#160;</div>
      <div class="bbRight">&#160;</div>
    </div>
  </div>
</div>
<?php     
  if (isset($variable_fields['referer'])) {
    if ($variable_fields['referer'] == "iah") {
?>

      <script type='text/javascript'>      

        $(document).ready(function() {
          $("[data-jv]").keyup(function() {
              check_field(this);        
          })        
        
          $("[data-jv]").bind("input", function(){
            check_field(this);
          })         

        });
        if (document.getElementById("tag018") != null)
          document.getElementById("tag018").readOnly = "";        
      </script>
<?php   
    }
  }
include("../common/footer.php");   
  //include("lib/footer.php");
?>  
</body></html>