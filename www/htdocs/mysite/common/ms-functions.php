<?php 
//foreach ($arrHttp as $var => $value) echo "$var = $value<br>";

function fechaAsString($fecha) {
    global $msgstr;
    if (strlen($fecha) >= 8) {
        $tp = mktime(intval(substr($fecha, 8, 2)), intval(substr($fecha, 10, 2)), intval(substr($fecha, 12, 2)), intval(substr($fecha, 4, 2)), intval(substr($fecha, 6, 2)), intval(substr($fecha, 0, 4)));
        return date("Y-m-d H:i:s", $tp);
    } else {
        return "<font color='red'>" . $msgstr["datenull"] . "</font>";
    }
}

function getUserStatus() {
    global $empwebservicequerylocation, $empwebserviceusersdb, $userid, $EmpWeb, $converter_path, $db_path, $vectorAbrev, $lang;

//Search the trans database
    $mxl = $converter_path . " " . $db_path . "trans/data/trans \"pft=if v20='" . $userid . "' then if v1='P' then v10,'|',v30,' ',v35,'|',v40,' ',v45,'|',mfn,'|',v80,'|',v100^a,' 'v100^b,'<br>'v100^d,'|',if p(v200) then (v200,'+-+'), fi,'|+~+', fi fi\" now";
    //echo "<h1>".$mxl."</h1>";
    exec($mxl, $outmxl, $banderamxl);
    $textoutmx = "";
    for ($i = 0; $i < count($outmxl); $i++) {
        $textoutmx .= substr($outmxl[$i], 0);
    }
    $splittxt = explode("+~+", $textoutmx);
    $loanslist = array();
    for ($i = 0; $i < (count($splittxt) - 1); $i++) {
        $values = explode("|", $splittxt[$i]);
//Get the document type
        $objtype = "";
        $fp = file($db_path . "circulation/def/" . $lang . "/items.tab");
        foreach ($fp as $value) {
            $value = trim($value);
            $val = explode('|', $value);
            if (trim($val[0]) == trim($values[4])) {
                $objtype = $val[1];
            }
        }
        if ($objtype == "") {
            $objtype = $values[4];
        }

        $sdate = $values[1];
        $edate = $values[2];
//get the renewals
        if ($values[6] != "") {
            $splittxtren = explode("+-+", $values[6]);
            if (isset($vectorAbrev['cantrenewals'])) {
                $vectorAbrev['cantrenewals'] += count($splittxtren) - 1;
            }

            $last = $splittxtren[(count($splittxtren) - 2)];
            $listalast = explode("^", $last);
            foreach ($listalast as $one) {
                if ((substr($one, 1) != "") and ($one[0] == 'a')) {
                    $sdate = substr($one, 1);
                }

                if ((substr($one, 1) != "") and ($one[0] == 'b')) {
                    $sdate .= " " . substr($one, 1);
                }

                if ((substr($one, 1) != "") and ($one[0] == 'c')) {
                    $edate = substr($one, 1);
                }

                if ((substr($one, 1) != "") and ($one[0] == 'd')) {
                    $edate .= " " . substr($one, 1);
                }

            }
        }
        $loanslist[] = array("startDate" => $sdate, "endDate" => $edate, "copyId" => $values[0], "recordId" => "trans " . $values[3], "location" => "-", "titleobj" => $values[5],"profile" => array("objectCategory" => $objtype));
    }
    if (count($loanslist) > 0) {
        $vectorAbrev['loans'] = $loanslist;
    }


    // Suspensiones
    // Search the suspml database
    $mxs = $converter_path . " " . $db_path . "suspml/data/suspml \"pft=if v20='" . $userid . "' then if v1='S' then if v10='0' then v30,'|',v60,'|',v100,'+~+', fi fi fi\" now";
    exec($mxs, $outmxs, $banderamxs);
    $textoutmx = "";
    for ($i = 0; $i < count($outmxs); $i++) {
        $textoutmx .= substr($outmxs[$i], 0);
    }
    $splittxt = explode("+~+", $textoutmx);
    $suspensionslist = array();
    for ($i = 0; $i < (count($splittxt) - 1); $i++) {
        $values = explode("|", $splittxt[$i]);
        $days = $values[1] - $values[0];
        $suspensionslist[] = array("startDate" => $values[0], "endDate" => $values[1], "obs" => $values[2], "daysSuspended" => $days, "location" => "-");
    }
    if (count($suspensionslist) > 0) {
        $vectorAbrev['suspensions'] = $suspensionslist;
    }


    //Multas
    //Search the suspml database
    $mxm = $converter_path . " " . $db_path . "suspml/data/suspml \"pft=if v20='" . $userid . "' then if v1='M' then if v10='0' then v30,'|',v50,'|',v100,'+~+', fi fi fi\" now";
    exec($mxm, $outmxm, $banderamxm);
    $textoutmx = "";
    for ($i = 0; $i < count($outmxm); $i++) {
        $textoutmx .= substr($outmxm[$i], 0);
    }
    $splittxt = explode("+~+", $textoutmx);
    $finelist = array();
    for ($i = 0; $i < (count($splittxt) - 1); $i++) {
        $values = explode("|", $splittxt[$i]);
        $days = $values[1] - $values[0];
        $finelist[] = array("date" => $values[0], "amount" => $values[1], "obs" => $values[2], "type" => "-");
    }
    if (count($finelist) > 0) {
        $vectorAbrev['fines'] = $finelist;
    }


    //Reservas

    //Search the reserve database
    $mxr = $converter_path . " " . $db_path . "reserve/data/reserve \"pft=if v10='" . $userid . "' then if v1='0' then if v1<>'4' then mfn,'|',v30,' ',v31,'|',v60,'|',v15,'|',v20,'|',v40,'|','+~+', fi fi fi\" now";
    
    exec($mxr, $outmxr);
    $textoutmx = "";
    for ($i = 0; $i < count($outmxr); $i++) {
        $textoutmx .= substr($outmxr[$i], 0);
    }
    $splittxt = explode("+~+", $textoutmx);
    $waitslist = array();
    for ($i = 0; $i < (count($splittxt) - 1); $i++) {
        $values = explode("|", $splittxt[$i]);
        $days = substr($values[1], 0, 8) - substr($values[0], 0, 8);
        
        $waitslist[] = array("date" => $values[1], "confirmedDate" => $values[2], "recordId" => "reserve " . $values[0], "location" => "-", "!id" => $values[0],"cdb" => $values[3],"CN" => $values[4], "expirationDate" => $values[5]);
    }
    if (count($waitslist) > 0) {
        $vectorAbrev['waits'] = $waitslist;
    }

    return $vectorAbrev;

}

function getUserStatus_H() {
    global $empwebservicequerylocation, $empwebserviceusersdb, $userid, $EmpWeb, $converter_path, $db_path, $vectorAbrev, $lang;

//Search the trans database
    $mxl = $converter_path . " " . $db_path . "trans/data/trans \"pft=if v20='" . $userid . "' then if v1='X' then v10,'|',v30,' ',v35,'|',v40,' ',v45,'|',mfn,'|',v80,'|',if p(v200) then (v200,'+-+'), fi,'|+~+', fi fi\" now";
    //echo "<h1>".$mxl."</h1>";
    exec($mxl, $outmxl, $banderamxl);
    $textoutmx = "";
    for ($i = 0; $i < count($outmxl); $i++) {
        $textoutmx .= substr($outmxl[$i], 0);
    }
    $splittxt = explode("+~+", $textoutmx);
    $loanslist = array();
    for ($i = 0; $i < (count($splittxt) - 1); $i++) {
        $values = explode("|", $splittxt[$i]);
//Get the document type
        $objtype = "";
        $fp = file($db_path . "circulation/def/" . $lang . "/items.tab");
        foreach ($fp as $value) {
            $value = trim($value);
            $val = explode('|', $value);
            if (trim($val[0]) == trim($values[4])) {
                $objtype = $val[1];
            }
        }
        if ($objtype == "") {
            $objtype = $values[4];
        }

        $sdate = $values[1];
        $edate = $values[2];
//get the renewals
        if ($values[5] != "") {
            $splittxtren = explode("+-+", $values[5]);
            if (isset($vectorAbrev['cantrenewals'])) {
                $vectorAbrev['cantrenewals'] += count($splittxtren) - 1;
            }

            $last = $splittxtren[(count($splittxtren) - 2)];
            $listalast = explode("^", $last);
            foreach ($listalast as $one) {
                if ((substr($one, 1) != "") and ($one[0] == 'a')) {
                    $sdate = substr($one, 1);
                }

                if ((substr($one, 1) != "") and ($one[0] == 'b')) {
                    $sdate .= " " . substr($one, 1);
                }

                if ((substr($one, 1) != "") and ($one[0] == 'c')) {
                    $edate = substr($one, 1);
                }

                if ((substr($one, 1) != "") and ($one[0] == 'd')) {
                    $edate .= " " . substr($one, 1);
                }

            }
        }
        $loanslist[] = array("startDate" => $sdate, "endDate" => $edate, "copyId" => $values[0], "recordId" => "trans " . $values[3], "location" => "-", "profile" => array("objectCategory" => $objtype));
    }
    if (count($loanslist) > 0) {
        $vectorAbrev['loans'] = $loanslist;
    }

    // Suspensiones
    // Search the suspml database
    $mxs = $converter_path . " " . $db_path . "suspml/data/suspml \"pft=if v20='" . $userid . "' then if v1='S' then if v10='0' then v30,'|',v60,'|',v100,'+~+', fi fi fi\" now";
    exec($mxs, $outmxs, $banderamxs);
    $textoutmx = "";
    for ($i = 0; $i < count($outmxs); $i++) {
        $textoutmx .= substr($outmxs[$i], 0);
    }
    $splittxt = explode("+~+", $textoutmx);
    $suspensionslist = array();
    for ($i = 0; $i < (count($splittxt) - 1); $i++) {
        $values = explode("|", $splittxt[$i]);
        $days = $values[1] - $values[0];
        $suspensionslist[] = array("startDate" => $values[0], "endDate" => $values[1], "obs" => $values[2], "daysSuspended" => $days, "location" => "-");
    }
    if (count($suspensionslist) > 0) {
        $vectorAbrev['suspensions'] = $suspensionslist;
    }

    //Multas
    //Search the suspml database
    $mxm = $converter_path . " " . $db_path . "suspml/data/suspml \"pft=if v20='" . $userid . "' then if v1='M' then if v10='0' then v30,'|',v50,'|',v100,'+~+', fi fi fi\" now";
    exec($mxm, $outmxm, $banderamxm);
    $textoutmx = "";
    for ($i = 0; $i < count($outmxm); $i++) {
        $textoutmx .= substr($outmxm[$i], 0);
    }
    $splittxt = explode("+~+", $textoutmx);
    $finelist = array();
    for ($i = 0; $i < (count($splittxt) - 1); $i++) {
        $values = explode("|", $splittxt[$i]);
        $days = $values[1] - $values[0];
        $finelist[] = array("date" => $values[0], "amount" => $values[1], "obs" => $values[2], "type" => "-");
    }
    if (count($finelist) > 0) {
        $vectorAbrev['fines'] = $finelist;
    }

    //Reservas

    //Search the reserve database
    $mxr = $converter_path . " " . $db_path . "reserve/data/reserve \"pft=if v10='" . $userid . "' then if v1<>'1' then if v1<>'4' then mfn,'|',v30,' ',v31,'|',v60,'|',v15,'|',v20,'|',v40,'|','+~+', fi fi fi\" now";

    exec($mxr, $outmxr);
    $textoutmx = "";
    for ($i = 0; $i < count($outmxr); $i++) {
        $textoutmx .= substr($outmxr[$i], 0);
    }
    $splittxt = explode("+~+", $textoutmx);
    $waitslist = array();
    for ($i = 0; $i < (count($splittxt) - 1); $i++) {
        $values = explode("|", $splittxt[$i]);
        $days = substr($values[1], 0, 8) - substr($values[0], 0, 8);

        $waitslist[] = array("date" => $values[1], "confirmedDate" => $values[2], "recordId" => "reserve " . $values[0], "location" => "-", "!id" => $values[0], "cdb" => $values[3], "CN" => $values[4], "expirationDate" => $values[5]);
    }
    if (count($waitslist) > 0) {
        $vectorAbrev['waits'] = $waitslist;
    }

    return $vectorAbrev;

}


function getInfoBiblio($CN_item,$DB_item) {
    global $converter_path, $lang,$db_path;
    $mx_tit = $converter_path . " " . $db_path . $DB_item . "/data/" . $DB_item . " \"CN_" . $CN_item . "\" \"pft=v245^a,': 'v245^b\"  now";
    exec($mx_tit, $outmx_tit);
    echo $outmx_tit[3];
}

function getRecordStatus() {
    global $empwebservicequerylocation, $empwebserviceobjectsdb, $userid, $EmpWeb, $converter_path, $db_path, $lang;

    //USING the Central Module
        $vectorAbrev["id"] = $vectorAbrev["recordId"];

        //Get the record info

        //CN
        $CnTag = "";
        $fp = file($db_path . $_SESSION["cdb"] . "/data/" . $_SESSION["cdb"] . ".fst");
        $fieldstags = "";
        $PftQuery = "";
        $flagt = 0;
        foreach ($fp as $value) {
            $value = trim($value);
            $b4 = strlen($value);
            $cadmod = str_replace("CN_", "", $value);
            $aftr = strlen($cadmod);
            if ($b4 > $aftr) {
                $val = explode(' ', $value);
                $pos = strpos($fieldstags, $val[0]);
                if ($pos === false) {
                    $posp = strpos($val[2], '^');
                    if ($posp === false) {
                        $fieldstags .= $val[0] . '|';
                    } else {
                        $flagt = 1;
                        $ptxt = explode('^', $val[2]);
                        $posv = strpos(strtolower($ptxt[0]), 'v');
                        $abuscar = substr(strtolower($ptxt[0]), $posv);
                        $abuscar .= '^' . $ptxt[1][0];
                        $posbuc = strpos($fieldstags, $abuscar);
                        if ($posbuc === false) {
                            $fieldstags .= $abuscar . '|';
                        }

                    }}}}

        $CNtags = explode('|', $fieldstags);
        foreach ($CNtags as $onecn) {
            if ($onecn != '') {
                if ($flagt == 1) {
                    $PftQuery .= $onecn . ",'|',";
                } else {
                    $PftQuery .= 'v' . $onecn . ",'|',";
                }
            }
        }

        if ($flagt == 1) {
            $PftQuery = substr($PftQuery, 0, -4);
        }

        $cntxt = explode(",'|',", $PftQuery);
        $CnTag = $cntxt[0];

        //Title
        $fieldstags = "";
        $PftQuery = "";
        $flagt = 0;
        foreach ($fp as $value) {
            $value = trim($value);
            $b4 = strlen($value);
            $cadmod = str_replace("TI_", "", $value);
            $aftr = strlen($cadmod);
            if ($b4 > $aftr) {
                $val = explode(' ', $value);
                $pos = strpos($fieldstags, $val[0]);
                if ($pos === false) {
                    $posp = strpos($val[2], '^');
                    if ($posp === false) {
                        $fieldstags .= $val[0] . '|';
                    } else {
                        $flagt = 1;
                        $ptxt = explode('^', $val[2]);
                        $posv = strpos(strtolower($ptxt[0]), 'v');
                        $abuscar = substr(strtolower($ptxt[0]), $posv);
                        $abuscar .= '^' . $ptxt[1][0];
                        $posbuc = strpos($fieldstags, $abuscar);
                        if ($posbuc === false) {
                            $fieldstags .= $abuscar . '|';
                        }

                    }}}}

        $Titstags = explode('|', $fieldstags);
        foreach ($Titstags as $tit) {
            if ($tit != '') {
                if ($flagt == 1) {
                    $PftQuery .= $tit . ",'|',";
                } else {
                    $PftQuery .= 'v' . $tit . ",'|',";
                }
            }

        }
        if ($flagt == 1) {
            $PftQuery = substr($PftQuery, 0, -4);
        }

        $mxti = $converter_path . " " . $db_path . $_SESSION["cdb"] . "/data/" . $_SESSION["cdb"] . " \"pft=if " . $CnTag . "='" . $vectorAbrev["id"] . "' then " . $PftQuery . " fi\" now";
        exec($mxti, $outmxti, $banderamxti);
        $textoutmx = "";
        for ($i = 0; $i < count($outmxti); $i++) {
            $textoutmx .= substr($outmxti[$i], 0);
        }
        $splittxttit = explode("|", $textoutmx);
        foreach ($splittxttit as $onetit) {
            if ($onetit != '') {
                $vectorAbrev["title"] .= $onetit . " ";
            }

        }

        //Author
        $fieldstags = "";
        $PftQuery = "";
        $flagt = 0;
        foreach ($fp as $value) {
            $value = trim($value);
            $b4 = strlen($value);
            $cadmod = str_replace("AU_", "", $value);
            $aftr = strlen($cadmod);
            if ($b4 > $aftr) {
                $val = explode(' ', $value);
                $pos = strpos($fieldstags, $val[0]);
                if ($pos === false) {
                    $posp = strpos($val[2], '^');
                    if ($posp === false) {
                        $fieldstags .= $val[0] . '|';
                    } else {
                        $flagt = 1;
                        $ptxt = explode('^', $val[2]);
                        $posv = strpos(strtolower($ptxt[0]), 'v');
                        $abuscar = substr(strtolower($ptxt[0]), $posv);
                        $abuscar .= '^' . $ptxt[1][0];
                        $posbuc = strpos($fieldstags, $abuscar);
                        if ($posbuc === false) {
                            $fieldstags .= $abuscar . '|';
                        }

                    }}}}

        $Titstags = explode('|', $fieldstags);
        foreach ($Titstags as $tit) {
            if ($tit != '') {
                if ($flagt == 1) {
                    $PftQuery .= $tit . ",'|',";
                } else {
                    $PftQuery .= 'v' . $tit . ",'|',";
                }
            }

        }
        if ($flagt == 1) {
            $PftQuery = substr($PftQuery, 0, -4);
        }

        $mxau = $converter_path . " " . $db_path . $_SESSION["cdb"] . "/data/" . $_SESSION["cdb"] . " \"pft=if " . $CnTag . "='" . $vectorAbrev["id"] . "' then " . $PftQuery . " fi\" now";
        exec($mxau, $outmxau, $banderamxau);
        $textoutmx = "";
        for ($i = 0; $i < count($outmxau); $i++) {
            $textoutmx .= substr($outmxau[$i], 0);
        }
        $splittxttit = explode("|", $textoutmx);
        foreach ($splittxttit as $onetit) {
            if ($onetit != '') {
                $vectorAbrev["authors"] .= $onetit . " ";
            }

        }

        //Publisher
        $fieldstags = "";
        $PftQuery = "";
        $flagt = 0;
        foreach ($fp as $value) {
            $value = trim($value);
            $b4 = strlen($value);
            $cadmod = str_replace("ED_", "", $value);
            $aftr = strlen($cadmod);
            if ($b4 > $aftr) {
                $val = explode(' ', $value);
                $pos = strpos($fieldstags, $val[0]);
                if ($pos === false) {
                    $posp = strpos($val[2], '^');
                    if ($posp === false) {
                        $fieldstags .= $val[0] . '|';
                    } else {
                        $flagt = 1;
                        $ptxt = explode('^', $val[2]);
                        $posv = strpos(strtolower($ptxt[0]), 'v');
                        $abuscar = substr(strtolower($ptxt[0]), $posv);
                        $abuscar .= '^' . $ptxt[1][0];
                        $posbuc = strpos($fieldstags, $abuscar);
                        if ($posbuc === false) {
                            $fieldstags .= $abuscar . '|';
                        }

                    }}}}

        $Titstags = explode('|', $fieldstags);
        foreach ($Titstags as $tit) {
            if ($tit != '') {
                if ($flagt == 1) {
                    $PftQuery .= $tit . ",'|',";
                } else {
                    $PftQuery .= 'v' . $tit . ",'|',";
                }
            }

        }
        if ($flagt == 1) {
            $PftQuery = substr($PftQuery, 0, -4);
        }

        $mxed = $converter_path . " " . $db_path . $_SESSION["cdb"] . "/data/" . $_SESSION["cdb"] . " \"pft=if " . $CnTag . "='" . $vectorAbrev["id"] . "' then " . $PftQuery . " fi\" now";
        exec($mxed, $outmxed, $banderamxed);
        $textoutmx = "";
        for ($i = 0; $i < count($outmxed); $i++) {
            $textoutmx .= substr($outmxed[$i], 0);
        }
        $splittxttit = explode("|", $textoutmx);
        foreach ($splittxttit as $onetit) {
            if ($onetit != '') {
                $vectorAbrev["publisher"] .= $onetit . " ";
            }

        }

        //Copies amount
        $vectorAbrev["copies"]["info"] = 1;

        //Type

        //Get the type from the loanobjects database
        $mxlo = $converter_path . " " . $db_path . "loanobjects/data/loanobjects \"pft=if v1='" . $vectorAbrev["id"] . "' then if v10='" . $_SESSION["cdb"] . "' then (v959^o,'|'), fi fi\" now";
        exec($mxlo, $outmxlo, $banderamxlo);
        $textoutmx = "";
        for ($i = 0; $i < count($outmxlo); $i++) {
            $textoutmx .= substr($outmxlo[$i], 0);
        }
        $splittxtlo = explode("|", $textoutmx);
        $objtype = "";
        $fp = file($db_path . "circulation/def/" . $lang . "/items.tab");
        foreach ($fp as $value) {
            $value = trim($value);
            $val = explode('|', $value);
            foreach ($splittxtlo as $onetype) {
                if (trim($val[0]) == trim($onetype)) {
                    $posot = strpos($objtype, $val[1]);
                    if ($posot === false) {
                        $objtype .= $val[1] . '|';
                    }

                }
            }
        }
        $listobjs = array();
        $splittxto = explode("|", $objtype);
        foreach ($splittxto as $oneobj) {
            if ($oneobj != '') {
                $listobjs[] = $oneobj;
            }
        }

        $vectorAbrev["objectType"] = $listobjs;

        //Database
        $vectorAbrev["database"] = $_SESSION["cdb"];

    return $vectorAbrev;
}