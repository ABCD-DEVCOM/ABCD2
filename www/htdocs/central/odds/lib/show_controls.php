<?php

// 
function _remove_comments($text) {
    //Old way 
    //$string = preg_replace("%(#|;|(//)).*%","",$string);
    //$string = preg_replace("%/\*(?:(?!\*/).)*\*/%s","",$string);   
    $text = preg_replace('!/\*.*?\*/!s', '', $text);
    $text = preg_replace('/\n\s*\n/', "\n", $text);
    return $text;
}

function _build_input($db_path, $value, $values, $lang_param, $data_passed=array()) {
    if (count($values) < 3 && count($values) > 4) {
        die("Cannot read controls to show! Bibliographic level: $value - odds_show_controls.tab File <br/>");
    } else {        
        $input = "";        
        $input_name = $values[0];
        $input_label = $values[1];
        $input_label = str_replace('*', '<font color="red">*</font>', $input_label);
        $input_length = isset($values[3]) ? trim($values[3]) : '';

        // from IAH ??? 
        $readonly = "";
        $referer = '';
        if (isset($data_passed['referer'])) {
            if ($data_passed['referer'] != "") {
                if ($data_passed['referer'] == "iah") {
                    $referer = 'iah';
                } else if ($data_passed['referer'] == "sa") {
                    $referer = 'sa';
                }
            }
        }
        if ($input_name == "tag900") {
            $input .= _add_source($db_path, $lang_param, $input_label, $input_length, $referer);
        } else {
            // font red
            $input_type = isset($values[2]) ? trim($values[2]) : ''; 
            $input_validate = isset($values[4]) ? trim($values[4]) : '';
            $validate_entry = "";
            if ($input_validate !='') {
                $validates = preg_split('/\s+/', $input_validate);
                $validate_entry = "";                            foreach ($validates as $val) {
                    $validate_entry .= trim($val). "($lang_param) ";
                }
                $validate_entry = trim($validate_entry);
            }
            $input  = "<label class='lbl' id='lbl_".$input_name."'>". utf8_decode($input_label) ."</label>\n";
            $input_value = "";
            if ($data_passed[$input_name]) {
                $input_value = $data_passed[$input_name];
            }
            //if ($referer == 'iah') {
                if ($input_value) {
                    //$readonly = 'readonly="readonly"  STYLE="background-color:#eeeeee"';                  
                    $readonly = ' readonly="true" STYLE="background-color:#eeeeee"'; 
                }  
            //}
            $input .= "<input value='".utf8_decode($input_value)."' type='".$input_type."' id='".$input_name."' name='".$input_name."' size='". $input_length ."' maxlength='". $input_length ."' ".$readonly; 
            
            if ($validate_entry != '') {
                $input .= "data-jv='". $validate_entry ."'>\n";
            } else {    
                $input .= " />\n";
            }
            $input .= "<div class = 'subtitle_blank'></div>\n";

            $input_label = str_replace('*', '<font color="red">*</font>', $input_label);
        }
        return $input;
    } 
}

function _add_source($db_path, $lang_param, $source_label, $input_length, $referer) {     
    $file_contents = trim(file_get_contents($db_path ."odds/def/".$lang_param. "/source.tab"));
    $file_contents = _remove_comments($file_contents);

    $a_tmp = explode("\n", $file_contents);    
    $k = 0;
    for ($j=0; $j < count($a_tmp); $j++){
        if (trim($a_tmp[$j]) != "") {
            $a[$k] = $a_tmp[$j];
            $k++;
        }
    }
    $source = "<label class='lbl' id='lbl_source'>$source_label</label>\n";
    $readonly = '';
    if ($referer == 'iah' || $referer == 'sa') {
        $readonly = 'STYLE="background-color:#eeeeee"'; 
    }
    $aux_last = explode('|',  $a[(count($a)-1)]); 
    $last_value = $aux_last[0];
    
    $source .= "<select ".$readonly." id=\"select_other\" name=\"tag900\" onChange=\"check('".$last_value."')\"> \n";

    if ($referer == 'sa') {
        foreach ($a as $values) {
            $line = explode("|", $values);
            if (trim($line[0]) == 'SAR') {
                $source .= "<option selected value=\"".trim($line[0])."\">". trim($line[1])."</option>\n";
            } else {
                $source .= "<option disabled value=\"".trim($line[0])."\">". trim($line[1])."</option>\n";
            }            
            if ($i == count($a)) {
                $source .= "<input id='other' name=\"tag900_other\" type='text' size='".$input_length."' maxlength='".$input_length."' style='visibility:hidden' >\n";
            }            
        }      
    }
    else if ($referer == 'iah') {
        foreach ($a as $values) {
            $line = explode("|", $values);
            if (trim($line[0]) == 'BAEU') {
                $source .= "<option selected value=\"".trim($line[0])."\">". trim($line[1])."</option>\n";
            } else {
                $source .= "<option disabled value=\"".trim($line[0])."\">". trim($line[1])."</option>\n";
            }
            //if (substr(0,7,trim($line[0])) == "others_") {
            if ($i == count($a)) {
                $source .= "<input id='other' name=\"tag900_other\" type='text' size='".$input_length."' maxlength='".$input_length."' style='visibility:hidden' >\n";
            }
            // }
        }
    } else {
        $first = true;        
        $i =1;
        foreach ($a as $values) {
            $line = explode("|", $values);            
            if ($first) {
                $source .= "<option selected value=\"".trim($line[0])."\">". trim($line[1])."</option>\n";
                $first = false;
            } else {
                $source .= "<option value=\"".trim($line[0])."\">". trim($line[1])."</option>\n";
            }            
            if ($i == count($a)) {
                $source .= "<input id='other' name=\"tag900_other\" type='text' size='".$input_length."' maxlength='".$input_length."' style='visibility:hidden' >\n";
            }           
            $i++;
        }
    }
    $source .= "</select>";
    return $source;
}


function read_config($value, $lang_param, $data_passed=array()) {    
    $inputs = "";
    include("../../config.php");    
    if (trim($lang_param) == "") {
        $lang_param = $lang;
    }
    $file_contents = trim(file_get_contents($db_path ."/odds/def/$lang_param/odds_show_controls.tab"));

    $file_contents = _remove_comments($file_contents);

    $labels_to_show = explode("\"$value\"", $file_contents, 2);    
    if (count($labels_to_show) < 2) {
        die("Cannot read controls to show! - odds_show_controls.tab File <br/>");
    }
    $labels_to_show = explode("\"", $labels_to_show[1]);
    $lines = explode("\n", trim($labels_to_show[0]));    
    foreach ($lines as $line) {
        $values = explode("|", $line);
        if (count($values) == 4 || count($values) == 5) {
            $values = array_map('trim', $values);
            $inputs .= _build_input($db_path, $value, $values, $lang_param, $data_passed);
        }
    }       
    return $inputs;
}
$value = $_POST['content'];
$lang = $_POST['lang'];
$data_passed = $_POST['jsdata'];
$inputs = read_config($value, $lang, $data_passed);
$labels = array ('html' => $inputs);
$encoded_labels = array_map("utf8_encode", $labels);
echo json_encode($encoded_labels);


// DEBUG 
/*
$value = "as";
$lang = "es";
$inputs = read_config($value, $lang);
var_dump($inputs);
*/

?>
