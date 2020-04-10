<?php
/**
 * @desc  generate a randon string
 * @param string $size Size of generated string
 * @param boolean $with_numbers option to use numbers
 * @param boolean $with_tiny_letters option to use tiny letters
 * @param boolean $with_capital_letters option to use capital letters
 * @access public
 **/
function string_generator($size=10, $with_numbers=true, $with_tiny_letters=true, $with_capital_letters=true)
{
    global $string_g;

    $string_g = "";
    $sizeof_lchar = 0;
    $letter = "";
    $letter_tiny = "abcdefghijklmnopqrstuvwxyz";
    $letter_capital = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $letter_number = "0123456789";

    if($with_tiny_letters == true)
    {
        $sizeof_lchar += 26;
        if (isset($letter))
        {
            $letter .= $letter_tiny;
        } else {
            $letter = $letter_tiny;
        }
    }

    if($with_capital_letters == true)
    {
        $sizeof_lchar += 26;
        if (isset($letter))
        {
            $letter .= $letter_capital;
        } else {
            $letter = $letter_capital;
        }
    }

    if($with_numbers == true)
    {
        $sizeof_lchar += 10;
        if (isset($letter))
        {
            $letter .= $letter_number;
        } else {
            $letter = $letter_number;
        }
    }
    if($sizeof_lchar > 0)
    {
        srand((double)microtime()*date("YmdGis"));
        for($cnt = 0; $cnt < $size; $cnt++)
        {
            $char_select = rand(0, $sizeof_lchar - 1);
            $string_g .= $letter[$char_select];
        }
    }
    return $string_g;
}
/**
 * @desc Function array_combine exist only PHP > 5
 * 		  use to combine two arrays with keys
 * @param array
 * @param array
 * @return array
 */
if(!(function_exists("array_combine"))) {
    function array_combine($a, $b)
    {
        $result = array();
        /*while(($key = each($a)) && ($val = each($b)))
        {
            $result[$key[1]] = $val[1];
        }*/
		for($i=0;$i<count($a);$i++)
		{
			$result[$a[$i]]=$b[$i];
		}

        return($result);
    }
}
/**
 * Name:     facicAllTitle
 * Input:  - title     (required) - identifier of title of  the facic data
 * Purpose:  Print the Title name relateda one collection of facic
  * @author Bruno Neofiti <bruno.neofiti@bireme.org>
 * @param integer $title 
 * @return string 
 */
function facicAllTitle($titleID,$fieldName)
{
    global $BVS_CONF, $configurator, $isisBroker, $FACIC_TAG_NAME;
    $xmlparameters = "<parameters>\n";
    $xmlparameters .= "<database>".$configurator->getPath2title()."</database>\n";
    //Used when has search
    $xmlparameters .= "<search>I=$titleID</search>\n";
    $xmlparameters .= "<from>1</from>\n";
    $xmlparameters .= "<count>1</count>\n";
    $xmlparameters .= "<gizmo>GIZMO_XML</gizmo>\n";
    $xmlparameters .= "<xml_header>yes</xml_header>\n";
    $xmlparameters .= "<reverse>Off</reverse>\n";
    $xmlparameters .= "</parameters>\n";
    if(isset($_REQUEST["title"]) && $_REQUEST["title"] != "") {
        $rawxml = $isisBroker->search($xmlparameters);
    }else{
        user_error("Pesquisa Invalida, Sem Título para pesquisar");
    }

    $posicion1 = strpos($rawxml,"<record");
    $posicion2 = strpos($rawxml,"</record>");

    $recordList = null;
    $i=0;
    while ($posicion1>0)
    {
        $elemento = substr($rawxml,$posicion1,$posicion2-$posicion1+9);
        $record = new Record();
        $record->unserializeFromString($elemento);
        $tempField = $record->campos;
        $tempRecord = array();

        foreach($tempField as $key=>$val) {
            if(array_key_exists($tempField[$key]->tag,$tempRecord)) {
                $varTemp = $tempRecord[$tempField[$key]->tag];
                $tempRecord[$tempField[$key]->tag] = array_merge($varTemp,$tempField[$key]->contenido);
            }else {
                $tempRecord += array($tempField[$key]->tag => $tempField[$key]->contenido);
            }
        }
        $tempRecord += array("mfn" => $record->getMfn());
        ksort($tempRecord);
        $recordList[] = $tempRecord;
        //array_push($recordList,$tempRecord);
        $tempRecord = null;
        $rawxml = substr($rawxml,$posicion2+1);
        $posicion1 = strpos($rawxml,"<record");
        $posicion2 = strpos($rawxml,"</record>");

    }
    if($fieldName == "ISSN"){
        return $recordList[0][400];
    }elseif($fieldName == "pubTitle"){
        return $recordList[0][100];
    }elseif($fieldName == "abrTitle"){
        return $recordList[0][150];
    }elseif($fieldName == "issnOnline"){
        return $recordList[0][890];
    }else{
        return $recordList[0];
    }
}


function titPlus2Title($titleID)
{
    global $BVS_CONF, $configurator, $isisBroker, $TITLEPLUS_TAG_NAME;
    $xmlparameters = "<parameters>\n";
    $xmlparameters .= "<database>".$configurator->getPath2titlePlus()."</database>\n";
    //Used when has search
    $xmlparameters .= "<search>".$titleID."</search>\n";
    $xmlparameters .= "<from>1</from>\n";
    $xmlparameters .= "<count>1</count>\n";
    $xmlparameters .= "<gizmo>GIZMO_XML</gizmo>\n";
    $xmlparameters .= "<xml_header>yes</xml_header>\n";
    $xmlparameters .= "<reverse>Off</reverse>\n";
    $xmlparameters .= "</parameters>\n";
    if(isset($_REQUEST["title"]) && $_REQUEST["title"] != "") {
        $rawxml = $isisBroker->search($xmlparameters);
    }else{
        user_error("Pesquisa Invalida, Sem Título para pesquisar");
    }

    $posicion1 = strpos($rawxml,"<record");
    $posicion2 = strpos($rawxml,"</record>");

    $recordList = null;
    $i=0;
    while ($posicion1>0)
    {
        $elemento = substr($rawxml,$posicion1,$posicion2-$posicion1+9);
        $record = new Record();
        $record->unserializeFromString($elemento);
        $tempField = $record->campos;
        $tempRecord = array();

        foreach($tempField as $key=>$val) {
            if(array_key_exists($tempField[$key]->tag,$tempRecord)) {
                $varTemp = $tempRecord[$tempField[$key]->tag];
                $tempRecord[$tempField[$key]->tag] = array_merge($varTemp,$tempField[$key]->contenido);
            }else {
                $tempRecord += array($tempField[$key]->tag => $tempField[$key]->contenido);
            }
        }
        $tempRecord += array("mfn" => $record->getMfn());
        ksort($tempRecord);
        $recordList[] = $tempRecord;
        //array_push($recordList,$tempRecord);
        $tempRecord = null;
        $rawxml = substr($rawxml,$posicion2+1);
        $posicion1 = strpos($rawxml,"<record");
        $posicion2 = strpos($rawxml,"</record>");

    }

    return $recordList[0];
}

/**
 * Name:     facicTitle
 * Input:  - title     (required) - identifier of title of  the facic data
 * Purpose:  Print the Title name relateda one collection of facic
  * @author Domingos Teruel <domingos.teruel@terra.com.br>
 * @param integer $title 
 * @return string 
 */
function facicTitle($titleID)
{
    global $BVS_CONF, $configurator, $isisBroker, $FACIC_TAG_NAME;
    $xmlparameters = "<parameters>\n";
    $xmlparameters .= "<database>".$configurator->getPath2title()."</database>\n";
    //Used when has search
    $xmlparameters .= "<search>I=$titleID</search>\n";
    $xmlparameters .= "<from>1</from>\n";
    $xmlparameters .= "<count>1</count>\n";
    $xmlparameters .= "<gizmo>GIZMO_XML</gizmo>\n";
    $xmlparameters .= "<xml_header>yes</xml_header>\n";
    $xmlparameters .= "<reverse>Off</reverse>\n";
    $xmlparameters .= "</parameters>\n";
    if(isset($_REQUEST["title"]) && $_REQUEST["title"] != "") {
        $rawxml = $isisBroker->search($xmlparameters);
    }else{
        user_error("Pesquisa Invalida, Sem Título para pesquisar ZZZ");
    }

    $posicion1 = strpos($rawxml,"<record");
    $posicion2 = strpos($rawxml,"</record>");

    $recordList = null;
    $i=0;
    while ($posicion1>0)
    {
        $elemento = substr($rawxml,$posicion1,$posicion2-$posicion1+9);
        $record = new Record();
        $record->unserializeFromString($elemento);
        $tempField = $record->campos;
        $tempRecord = array();

        foreach($tempField as $key=>$val) {
            if(array_key_exists($tempField[$key]->tag,$tempRecord)) {
                $varTemp = $tempRecord[$tempField[$key]->tag];
                $tempRecord[$tempField[$key]->tag] = array_merge($varTemp,$tempField[$key]->contenido);
            }else {
                $tempRecord += array($tempField[$key]->tag => $tempField[$key]->contenido);
            }
        }
        $tempRecord += array("mfn" => $record->getMfn());
        ksort($tempRecord);
        $recordList[] = $tempRecord;
        //array_push($recordList,$tempRecord);
        $tempRecord = null;
        $rawxml = substr($rawxml,$posicion2+1);
        $posicion1 = strpos($rawxml,"<record");
        $posicion2 = strpos($rawxml,"</record>");

    }

    return $recordList[0][100];
}
function user_notice($successMessage){
    global $smarty;
    $smarty->assign("sMessage",array("message" => $successMessage,
    "success" => true));
}
function user_warning($warningMessage){
    global $smarty;
    $smarty->assign("sMessage",array("message" => $warningMessage,
    "warning" => "true",
    "success" => false));
}
/**
 * @return void
 * @param int        $errno       numero do erro
 * @param string     $errmsg      mensagem de erro
 * @param string     $filename    nome do arquivo
 * @param int        $linenum     n�mero da linha
 * @param array      $vars        diversas vari�veis do sistema ($_SERVER
 * @desc funcao que servira de callBack
*/
function erros($errno, $errmsg, $filename, $linenum, $vars) {
    $erro = new Erro($errno, $errmsg, $filename, $linenum, $vars);
}
/**
 * @desc Funcao que reduz uma string passada de acordo com a qtd de caracteres
 * @param string $str string a ser reduzida
 * @param int $char Qtd de caracteres a serem retirados
 * @return string
 */
function makeShorterText($str, $char)
{
    $str = preg_replace('/\s+/', " ", $str);
    $arrStr = explode(" ", $str);
    $shortStr = "";
    $num = count($arrStr);
    if ($num > $char) {
        for ($j = 0; $j <= $char; $j++) {
            $shortStr .= $arrStr[$j]." ";
        }
        $shortStr .= "...";
    }else {
        $shortStr = $str;
    }
    return $shortStr;
}

function append_to_log($logstr)
{
    $timestamp = date("M d H:i:s");
    $path = BVS_LOG;
    $logfile = "/isisws.log";
    $log_append_str = "$timestamp " .$logstr;
    //echo $path.$logfile;
    if(file_exists($path.$logfile) && is_writeable($path.$logfile))
    {
        $fp = fopen($path.$logfile, 'a');
        fputs($fp, "$log_append_str/n");
        fclose($fp);
    }
    else if(!file_exists($path.$logfile) && is_writeable($path))
    {
        touch($path.$logfile);
        chmod($path.$logfile, 0600);
        $fp = fopen($path.$logfile, 'a');
        fputs($fp, "$log_append_strrn/n");
        fclose($fp);
    }
    else
    {
        trigger_error("Unable to write to file..",E_WARNING);
    }
}

/**
 * Funcao que conta o numero de registros na base de dados
 * @param string $database: Nome da base de dados
 * @return string
 */
function totalDB($database)
{
    global $BVS_CONF, $configurator, $isisBroker ;

    switch ($database) {
        case "mask":
            $dbPath = $configurator->getPath2Mask();
            break;
        case "title":
            $dbPath = $configurator->getPath2Title();
            break;
        case "titleplus":
            $dbPath = $configurator->getPath2TitlePlus();
            break;
        default:
    }

    $xmlparameters = "<parameters>\n";
    $xmlparameters .= "<database>".$dbPath."</database>\n";
    $xmlparameters .= "<search>$</search>\n";
    $xmlparameters .= "<from>1</from>\n";
    $xmlparameters .= "<to>99999</to>\n";
    $xmlparameters .= "<count>1</count>\n";
    $xmlparameters .= "<gizmo>GIZMO_XML</gizmo>\n";
    $xmlparameters .= "<xml_header>yes</xml_header>\n";
    $xmlparameters .= "<reverse>Off</reverse>\n";
    $xmlparameters .= "</parameters>\n";

    $rawxml = $isisBroker->search($xmlparameters);
    $posicion1 = strpos($rawxml,"<record");
    $posicion2 = strpos($rawxml,"</record>");

    $recordList = null;
    $i=0;
    while ($posicion1>0)
    {
        $elemento = substr($rawxml,$posicion1,$posicion2-$posicion1+9);
        $record = new Record();
        $record->unserializeFromString($elemento);
        $tempField = $record->campos;
        $tempRecord = array();

        foreach($tempField as $key=>$val) {
            if(array_key_exists($tempField[$key]->tag,$tempRecord)) {
                $varTemp = $tempRecord[$tempField[$key]->tag];
                $tempRecord[$tempField[$key]->tag] = array_merge($varTemp,utf8_decode($tempField[$key]->contenido));
            }else {
                $tempRecord += array($tempField[$key]->tag => utf8_decode($tempField[$key]->contenido));
            }
        }
        $tempRecord += array("mfn" => $record->getMfn());
        ksort($tempRecord);
        $recordList[] = $tempRecord;
        $tempRecord = null;
        $rawxml = substr($rawxml,$posicion2+1);
        $posicion1 = strpos($rawxml,"<record");
        $posicion2 = strpos($rawxml,"</record>");

    }

    if($recordList[0][1002] == ""){
        return "0";
    }else{
        return $recordList[0][1002];
    }

    

}


    
/**
 * Funcao que recebe o xml do IsisScript e processa os dados
 * gerando um array com todos os campos, subcampos e repetitivos
 *
 * @param xml $xmlstr
 */
function xmlIsisToArrayField($xmlstr)
{
    $xml = new SimpleXMLElement($xmlstr);

    $record = array();
    $tmp_record = array();
    $_temp = array();

    foreach($xml->record->field as $field)
    {
        $fieldNames = $field->attributes();

        if(count($field->subfield) > 0) {
            $subfield = "";
            foreach ($field->subfield as $k => $v)
            {
                $subfieldAtt = $v->attributes();
                $subfield .= "^{$subfieldAtt["id"]}$v";
            }
            $tmp_record[]["{$fieldNames["tag"]}"] = array(trim($subfield),trim("{$field[0]}"));
        }else{
            $tmp_record[]["{$fieldNames["tag"]}"] = array(trim("{$field[0]}"));
        }
    }
    foreach ($tmp_record as $i => $content){
        foreach ($content as $tag => $val) {
            if(!(key_exists($tag,$_temp))) {
                $xi = 0;
            }
            $_temp[$xi]= $val[1] . $val[0];
            $xi++;
        }        
        $record[]["$tag"] = $_temp;
        $_temp = array();
    }
    return $record;
}




?>