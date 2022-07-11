<?php
include("../../central/common/header.php");
require_once "../../central/config.php";
require_once "../../central/lang/lang.php";

$query = "";
include "../../central/common/get_post.php";

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
        $mxl = $converter_path . " " . $db_path . "trans/data/trans \"pft=if v20='" . $userid . "' then if v1='P' then v10,'|',v30,' ',v35,'|',v40,' ',v45,'|',mfn,'|',v80,'|',if p(v200) then (v200,'+-+'), fi,'|+~+', fi fi\" now";
       
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
                if (isset($vectorAbrev['cantrenewals'])) $vectorAbrev['cantrenewals'] += count($splittxtren) - 1;
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
//Search the suspml database
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

// Reservas
//Search the reserve database
        $mxr = $converter_path . " " . $db_path . "reserve/data/reserve \"pft=if v10='" . $userid . "' then if v1<>'1' then if v1<>'4' then mfn,'|',v30,' ',v31,'|',v60,'|','+~+', fi fi fi\" now";
        exec($mxr, $outmxr, $banderamxr);
        $textoutmx = "";
        for ($i = 0; $i < count($outmxr); $i++) {
            $textoutmx .= substr($outmxr[$i], 0);
        }
        $splittxt = explode("+~+", $textoutmx);
        $waitslist = array();
        for ($i = 0; $i < (count($splittxt) - 1); $i++) {
            $values = explode("|", $splittxt[$i]);
            $days = $values[1] - $values[0];
            $waitslist[] = array("date" => $values[1], "confirmedDate" => $values[2], "recordId" => "reserve " . $values[0], "location" => "-", "!id" => $values[0]);
        }
        if (count($waitslist) > 0) {
            $vectorAbrev['waits'] = $waitslist;
        }


    return $vectorAbrev;

}

function getRecordStatus() {
    global $empwebservicequerylocation, $empwebserviceobjectsdb, $userid, $EmpWeb, $converter_path, $db_path, $lang;

    if ($EmpWeb == "1") {
//USING the Emweb Module

        $proxyhost = isset($_POST['proxyhost']) ? $_POST['proxyhost'] : '';
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

        $params = array('queryParam' => array("query" => array('recordId' => $_SESSION["recordId"])), 'database' => $empwebserviceobjectsdb);
        $result = $client->call('searchObjects', $params, 'http://kalio.net/empweb/engine/query/v1', '');

        $resumen = $result["queryResult"]["databaseResult"]["result"]["modsCollection"]["mods"];

        $vectorAbrev["id"] = $_SESSION["recordId"];
        $vectorAbrev["title"] = $resumen["titleInfo"]["title"];
        $vectorAbrev["publisher"] = $resumen["originInfo"]["publisher"];
        $vectorAbrev["year"] = $resumen["originInfo"]["dateIssued"];

        if ($resumen["extension"]["holdingsInfo"]["copies"]["copy"]["copyId"] != "") {
            $vectorAbrev["copies"]["info"] = 1;
        } else {
            $vectorAbrev["copies"]["info"] = count($resumen["extension"]["holdingsInfo"]["copies"]["copy"]);

            $opciones = array();
            foreach ((array) $resumen["extension"]["holdingsInfo"]["copies"]["copy"] as $elemento) {
                if ($elemento["volumeId"]) {
                    array_push($opciones, $elemento["volumeId"]);
                }

            }

            //Opciones para vol�men
            if (count($opciones) > 0) {
                $vectorAbrev["copies"]["options"] = $opciones;
            }
        }

        $buffer = "";

        // Autores heterogeneo
        if ($resumen["name"]["namePart"] != "") {
            $buffer = $resumen["name"]["namePart"];
        } else {

            for ($i = 0; $i < count($resumen["name"]); $i++) {
                $buffer .= $resumen["name"][$i]["namePart"] . " / ";
            }
        }

        $vectorAbrev["authors"] = $buffer;

        //Copias heterogeneas

        //print_r($resumen);

        if ($resumen["extension"]["holdingsInfo"]["copies"]["copy"]["copyLocation"] != "") {
            $vectorAbrev["library"] = $resumen["extension"]["holdingsInfo"]["copies"]["copy"]["copyLocation"];
            $vectorAbrev["objectType"][0] = $resumen["extension"]["holdingsInfo"]["copies"]["copy"]["objectCategory"];
        } elseif ($resumen["extension"]["holdingsInfo"]["copies"]["copy"][0]["copyLocation"] != "") {
            $vectorAbrev["library"] = $resumen["extension"]["holdingsInfo"]["copies"]["copy"][0]["copyLocation"];

            $miscopias = $resumen["extension"]["holdingsInfo"]["copies"]["copy"];
            $i = 0;
            foreach ($miscopias as $copia) {
                $vectorAbrev["objectType"][$i++] = $copia["objectCategory"];
            }
        }
    } else {
//USING the Central Module
        $vectorAbrev["id"] = $_SESSION["recordId"];
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

    }
    return $vectorAbrev;
}
?>

<head>

    <title>ABCD MySite-plug in</title>

    <meta http-equiv="Expires" content="-1" />
    <meta http-equiv="pragma" content="no-cache" />
    <meta name="robots" content="all" />
    <meta http-equiv="keywords" content="" />
    <meta http-equiv="description" content="" />
    <!-- Stylesheets -->



<script>
        // Define various event handlers for Dialog
        var handleSubmit = function() {

            document.getElementById('firstBox').style.display = 'none';
            document.getElementById('secondBox').style.display = 'none';
            document.getElementById('answerBox').style.display = '';
            this.submit();
        };


        var handleSubmitRenew = function() {

            document.getElementById('firstBox').style.display = 'none';
            document.getElementById('secondBox').style.display = 'none';
            document.getElementById('answerBox').style.display = '';
            this.submit();
        };


        var handleSubmitReserves = function() {

            document.getElementById('firstBox').style.display = 'none';
            document.getElementById('answerBox').style.display = '';
            this.submit();
        };



        var handleCancel = function() {
            this.cancel();
        };

        var handleSuccess = function(o) {
            var response = o.responseText;
            document.getElementById("myanswer").innerHTML = response;
        };


        var handleFailure = function(o) {
            alert("Submission failed: " + o.status);
        };



        function CambiarLenguaje() {
            if (document.cambiolang.lenguaje.selectedIndex > 0) {
                lang = document.cambiolang.lenguaje.options[document.cambiolang.lenguaje.selectedIndex].value
                self.location.href = "iniciomysite.php?reinicio=s&lang=" + lang
            }
        }


        function CancelReservation(idTrans) {
            document.forms["formreservation"].waitid.value = idTrans;
            document.forms["formreservation"].userid.value = "<?php echo $_SESSION["userid"]; ?>";
        }


        function LoanRenovation(idTrans, library) {
            console.log('RENOVA');
            document.formrenovation.copyId.value = idTrans;
            document.formrenovation.userId.value = "<?php echo $_SESSION["userid"]; ?>";
            document.formrenovation.db.value = "<?php echo $_SESSION["db"]; ?>";
            document.formrenovation.library.value = library;
            document.formrenovation.usertype.value = "<?php echo $vectorAbrev['userClass']; ?>"
            document.formrenovation.copytype.value = document.getElementById('copytypeh' + idTrans).value;
            document.formrenovation.loanid.value = document.getElementById('loanidh' + idTrans).value;
            document.formrenovation.cantrenewals.value = document.getElementById('cantrenewalst').value;
            //document.formrenovation.suspensions.value = document.getElementById('suspensionst').value;
            //document.formrenovation.fines.value = document.getElementById('finest').value;
            document.formrenovation.endatev.value = document.getElementById('endatet' + idTrans).value;
            document.formrenovation.submit()

        }


        function PlaceReserve(recordId, objectType, library) {


            document.forms["formreserves"].userId.value = "<?php echo $_SESSION["userid"]; ?>";
            document.forms["formreserves"].db.value = "<?php echo $_SESSION["db"]; ?>";
            document.forms["formreserves"].recordId.value = recordId;
            if (typeof(document.forms["formshow"].volumeId) != 'undefined') {
                document.forms["formreserves"].volumeId.value = document.forms["formshow"].volumeId.value;
            }
            document.forms["formreserves"].objectCategory.value = document.forms["formshow"].objectType.value;
            document.forms["formreserves"].library.value = library;
            document.forms["formreserves"].usertype.value = "<?php echo $vectorAbrev['userClass']; ?>";

            document.forms["formreserves"].database.value = document.forms["formshow"].database.value;
        }



        function ReloadSite() {
            document.location.reload(true);
        }


        function clearOperation() {
            document.location.href = "iniciomysite.php?action=clear";
        }

        function GoToSite() {
            document.location.href = "iniciomysite.php?action=gotosite";
        }

    </script>

    <!-- AJAX para consulta de registro -->
    <script>
    function ajaxPublication(id, recordId, database) {
        div = document.getElementById(id);
        postData = "id=" + recordId + "&database=" + database;
        makeRequest();

    }

    var div = document.getElementById('container');



    var callback = {
        success: handleSuccess,
        failure: handleFailure
    };

    var sUrl = "../queryobjectservice.php";
    </script>

</head>

<body>
    <div class="heading">
        <div class="institutionalInfo">
            <h1><?php echo $institution_name ?></h1>
            <h2>ABCD</h2>
        </div>
        <div class="userInfo">
            <span><?php echo $_SESSION["nombre"] ?></span>,
            <?php echo $_SESSION["permiso"] ?> |
            <a href="logoutmysite.php" class="button_logout"><span><?php echo $msgstr["logout"] ?></span></a>
        </div>

        <div class="language">
            <form name=cambiolang> <?php echo $msgstr["lang"] ?>:
                <select name=lenguaje onchange=CambiarLenguaje()>
                    <?php
$a = $db_path . "lang/" . $_SESSION["lang"] . "/lang.tab";

if (!file_exists($a)) {
    $a = $db_path . "lang/en/lang.tab";
}

if (file_exists($a)) {
    $fp = file($a);
    $selected = "";
    foreach ($fp as $value) {
        $value = trim($value);
        if ($value != "") {
            $l = explode('=', $value);
            if ($l[0] == $_SESSION["lang"]) {
                $selected = " selected";
            }

            echo "<option value=$l[0] $selected>" . $l[1] . "</option>";
            $selected = "";
        }
    }
} else {
    echo $msgstr["flang"] . $db_path . "lang/" . $_SESSION["lang"] . "/lang.tab";
    die;
}

?>
                </select>
            </form>

        </div>

        <div class="spacer">&#160;</div>
    </div>

    <div class="sectionInfo">
        <div class="breadcrumb">


        </div>

        <div class="actions">
            &#160;
        </div>
        <div class="spacer">&#160;</div>
    </div>


    <div class="helpermysite">
        &nbsp &nbsp &nbsp;
        <a href=documentacion/ayuda.php?help=<?php if (isset($_SESSION["action"]) and $_SESSION["action"] == 'reserve') {
    echo $_SESSION["lang"] . "/mysite_reserve.html";
} else {
    echo $_SESSION["lang"] . "/mysite.html";
}
?> target=_blank>
            <?php echo $msgstr["help"] ?></a>&nbsp &nbsp;
    </div>
    <div class="middle homepage">


        <div id="dialog1">
            <div class="hd"><?php echo $msgstr["reservationcancel"] ?></div>
            <div class="bd">
                <form id="formreservation" method="POST" action="../cancelreservation.php">
                    <label for="observations"><?php echo $msgstr["observations"] ?></label>
                    <textarea name="observations"></textarea>
                    <input type="hidden" id="waitid" name="waitid" />
                    <input type="hidden" id="userid" name="userid" />
                </form>
            </div>
        </div>


        <div id="dialog2">
            <div class="hd"><?php echo $msgstr["loanrenewal"] ?></div>
            <div class="bd">
                <form id="formrenovation" name="formrenovation" method="POST" action="../loanrenovation.php">
                    <label for="observations"><?php echo $msgstr["renewalconfirm"] ?></label>
                    <input type="hidden" id="copyId" name="copyId" />
                    <input type="hidden" id="userId" name="userId" />
                    <input type="hidden" id="db" name="db" />
                    <input type="hidden" id="library" name="library" />
                    <input type="hidden" id="usertype" name="usertype" />
                    <input type="hidden" id="copytype" name="copytype" />
                    <input type="hidden" id="loanid" name="loanid" />
                    <input type="hidden" id="cantrenewals" name="cantrenewals" />
                    <input type="hidden" id="suspensions" name="suspensions" />
                    <input type="hidden" id="fines" name="fines" />
                    <input type="hidden" id="endatev" name="endatev" />
                </form>
            </div>
        </div>



        <div id="dialog3">
            <div class="hd"><?php echo $msgstr["makereservation"] ?></div>
            <div class="bd">
                <form id="formreserves" method="POST" action="../reserve.php">
                    <label for="observations"><?php echo $msgstr["reservationconfirm"] ?></label>

                    <input type="hidden" id="userId" name="userId" />
                    <input type="hidden" id="db" name="db" />
                    <input type="hidden" id="recordId" name="recordId" />
                    <input type="hidden" id="volumeId" name="volumeId" />
                    <input type="hidden" id="objectCategory" name="objectCategory" />
                    <input type="hidden" id="library" name="library" />
                    <input type="hidden" id="usertype" name="usertype" />
                    <input type="hidden" id="database" name="database" />

                </form>
            </div>
        </div>




        <?php

// Llamado ppal
if (isset($_SESSION["action"]) and $_SESSION["action"] == 'reserve') {
    MenuReserves(getRecordStatus());
} else {
    $dataarr = getUserStatus();
    MenuFinalUser();
}

echo "		</div>
	</div>";
include "footermysite.php";
echo "	</body>
</html>";

function MenuFinalUser() {
    global $arrHttp, $msgstr, $db_path, $valortag, $lista_bases, $dataarr;
    ?>
        <div id="firstBox">
            <div id="firstBox1" class="mainBox" onMouseOver="this.className = 'mainBox mainBoxHighlighted';"
                onMouseOut="this.className = 'mainBox';">

                <div class="boxContent loanSection">

                    <div class="sectionIcon">
                        &#160;
                    </div>

                    <div class="sectionTitle">
                        <h4><strong>&#160;<?php echo $msgstr["generaldata"]; ?></strong></h4>
                    </div>

                    <div class="sectionButtons">
                        <!-- Aca viene esto robado del empweb --->

                        <table>
                            <tr>
                                <td rowspan="4">
                                    <img style="max-width:150px;"
                                        src="../../central/common/show_image.php?image=images/<?php echo $dataarr["photo"] ?>&base=users"
                                        alt="PICTURE" />
                                </td>
                                <td rowspan="4">&nbsp;</td>

                                <td><?php echo $msgstr["myuserid"]; ?></td>
                                <td><?php echo $dataarr["id"] ?></td>
                            </tr>

                            <tr>
                                <td><?php echo $msgstr["name"]; ?></td>
                                <td><?php echo $dataarr["name"] ?></td>
                            </tr>

                            <tr>
                                <td><?php echo $msgstr["userclass"]; ?></td>
                                <td><?php echo $dataarr["userClass"] ?></td>
                            </tr>

                            <tr>
                                <td><?php echo $msgstr["datelimit"]; ?></td>
                                <td><?php echo fechaAsString($dataarr["expirationDate"]); ?></td>
                            </tr>
                        </table>

                        <div class="spacer"> </div>

                    </div>
                </div>

            </div>

        </div>
        <div class="spacer"> </div>

        <div id="secondBox" style="height: auto;">
            <div id="secondBox1" class="mainBox" onMouseOver="this.className = 'mainBox mainBoxHighlighted';"
                onMouseOut="this.className = 'mainBox';">

                <div class="boxContent toolSection">

                    <div class="sectionIcon">
                        &#160;
                    </div>

                    <div class="sectionTitle">
                        <h4><strong>&#160;<?php echo $msgstr["userstatus"]; ?></strong></h4>
                    </div>

                    <div class="sectionButtons">

                        <h3>
                            <?php echo $msgstr["activesuspensions"]; ?>
                            <?php if (!empty($dataarr["suspensions"])) {
                            echo count($dataarr["suspensions"]);
                            ?>
                        </h3>
                        <input type="hidden" id="suspensionst" name="suspensionst" value="<?php echo sum($dataarr["suspensions"]); ?>" />


                        <?php }

                            if (!empty($dataarr["suspensions"])) {
                        ?>

                        <table width="90%">
                            <tr>
                                <td><?php echo $msgstr["from"]; ?></td>
                                <td><?php echo $msgstr["to"]; ?></td>
                                <td><?php echo $msgstr["duration"]; ?></td>
                                <td><?php echo $msgstr["cause"]; ?></td>
                                <td><?php echo $msgstr["library"]; ?></td>
                            </tr>

                            <?php

                        if (count($dataarr["suspensions"]) > 0) {
                        foreach ($dataarr["suspensions"] as $suspension) {

                        ?>

                            <tr>
                                <td><?php echo fechaAsString($suspension["startDate"], 0, 8); ?></td>
                                <td><?php echo fechaAsString($suspension["endDate"], 0, 8); ?></td>
                                <td><?php echo $suspension["daysSuspended"] . " " . $msgstr["days"]; ?></td>
                                <td><?php echo $suspension["obs"]; ?></td>
                                <td><?php echo $suspension["location"]; ?></td>
                            </tr>

                            <?php

                        }
                        }
                    

        ?>
                        </table>

                        <?php }?>


                        <span>
                            <h3>
                                <?php echo $msgstr["actualloans"]; ?>
                                <?php if (!empty($dataarr["loans"])) {
                                echo count($dataarr["loans"]);
                                }
                            ?>
                            </h3>

                            <?php

    if (!empty($dataarr["loans"])) {

        ?>

                            <table width="90%">
                                <tr>
                                    <td><?php echo $msgstr["inventory"]; ?>
                                        <input type="hidden" id="cantrenewalst" name="cantrenewalst"
                                            value="<?php if (isset($dataarr["cantrenewals"]))echo $dataarr["cantrenewals"]; ?>" />
                                    </td>
                                    <td><?php echo $msgstr["from"]; ?></td>
                                    <td><?php echo $msgstr["to"]; ?></td>
                                    <td><?php echo $msgstr["publication"]; ?></td>
                                    <td><?php echo $msgstr["library"]; ?></td>
                                    <td><?php echo $msgstr["operation"]; ?></td>
                                </tr>
                                <?php
foreach ($dataarr["loans"] as $loan) {
            ?>
                                <tr>
                                    <td><?php echo $loan["copyId"];
            //print_r($loan["profile"]);  ?><input type="hidden" id="loanidh<?php echo $loan["copyId"]; ?>"
                                            name="loanidh<?php echo $loan["copyId"]; ?>"
                                            value="<?php echo $loan["recordId"]; ?>" /></td>
                                    <td><?php if (substr($loan["startDate"], -1) == ' ') {
                echo fechaAsString(substr($loan["startDate"], 0, -1));
            } else {
                echo fechaAsString($loan["startDate"]);
            }
            ?></td>
                                    <td><?php if (substr($loan["endDate"], -1) == ' ') {
                echo fechaAsString(substr($loan["endDate"], 0, -1));
            } else {
                echo fechaAsString($loan["endDate"]);
            }
?>
                                        <input type="hidden" id="endatet<?php echo $loan["copyId"]; ?>"
                                            name="endatet<?php echo $loan["copyId"]; ?>"
                                            value="<?php echo $loan["endDate"]; ?>" />
                                    </td>
                                    <td>
                                    <a href="javascript: ajaxPublication('<?php echo "loan-" . $loan["recordId"]; ?>','<?php echo $loan["recordId"]; ?>','*');"><?php echo $loan["recordId"] . " / " . $loan["profile"]["objectCategory"]; ?>
                                    </a>
                                    <input type="hidden" id="copytypeh<?php echo $loan["copyId"]; ?>" name="copytypeh<?php echo $loan["copyId"]; ?>" value="<?php echo $loan["profile"]["objectCategory"]; ?>" />
                                    </td>
                                    <td>
                                    <?php echo $loan["location"] ?>
                                    </td>
                                    <td>
                                    <input type="button" id="renew" value="<?php echo $msgstr["makerenewal"]; ?>" OnClick="javascript:LoanRenovation('<?php echo $loan["copyId"] ?>','<?php echo $loan["location"] ?>')">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="6">
                                        <div id="<?php echo "loan-" . $loan["recordId"]; ?>"></div>
                                    </td>
                                </tr>
                                <?php
}
        ?>
                            </table>
                        </span>

                        <?php

    }

    ?>

                        <span>
                            <h3><?php echo $msgstr["actualreserves"]; ?> <?php if (!empty($dataarr["waits"])) {
        echo count($dataarr["waits"]);
    }
    ?></h3>


                            <?php

    if (!empty($dataarr["waits"])) {

        ?>

                            <table width="90%">
                                <tr>


                                    <td><?php echo $msgstr["publication"]; ?></td>
                                    <td><?php echo $msgstr["reserveddate"]; ?></td>
                                    <td><?php echo $msgstr["avaiblefrom"]; ?></td>
                                    <td><?php echo $msgstr["avaibleuntil"]; ?></td>
                                    <td><?php echo $msgstr["library"]; ?></td>
                                    <td><?php echo $msgstr["operation"]; ?></td>
                                </tr>
                                <?php
foreach ($dataarr["waits"] as $reserve) {
            //print_r($reserve);
            ?>
                                <tr>
                                    <td><a
                                            href="javascript: ajaxPublication('<?php echo "wait-" . $reserve["recordId"]; ?>','<?php echo $reserve["recordId"]; ?>','*');"><?php echo $reserve["recordId"] . " / " . $reserve["profile"]["objectCategory"]; ?></a>
                                    </td>
                                    <!--<?php echo $reserve["recordId"] ?></td>-->
                                    <td><?php echo fechaAsString($reserve["date"]) ?></td>
                                    <td><?php echo fechaAsString($reserve["confirmedDate"]) ?></td>
                                    <td><?php echo fechaAsString($reserve["expirationDate"]) ?></td>
                                    <td><?php echo $reserve["location"] ?></td>
                                    <td>
                                        <input type="button" value="<?php echo $msgstr["cancel"]; ?>"
                                            OnClick="javascript:CancelReservation('<?php echo $reserve["!id"] ?>')" />
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="6">
                                        <div id="<?php echo "wait-" . $reserve["recordId"]; ?>"></div>
                                    </td>
                                </tr>

                                <?php
}
        ?>
                            </table>
                        </span>

                        <?php }?>


                        <span>
                            <h3><?php echo $msgstr["fines"]; ?> <?php if (!empty($dataarr["fines"])) {
        echo count($dataarr["fines"]);
   
    ?></h3>
                            <input type="hidden" id="finest" name="finest"
                                value="<?php echo count($dataarr["fines"]); ?>" />
                            <?php
 }
    if (!empty($dataarr["fines"])) {

        ?>

                            <table width="90%">
                                <tr>
                                    <td><?php echo $msgstr["from"]; ?></td>
                                    <td><?php echo $msgstr["amount"]; ?></td>
                                    <td><?php echo $msgstr["type"]; ?></td>
                                    <td><?php echo $msgstr["observations"]; ?></td>

                                </tr>
                                <?php
foreach ($dataarr["fines"] as $fine) {
            //print_r($reserve);
            ?>
                                <tr>
                                    <td><?php echo fechaAsString($fine["date"]) ?></td>
                                    <td><?php echo $fine["amount"] ?></td>
                                    <td><?php echo $fine["type"] ?></td>
                                    <td><?php echo $fine["obs"] ?></td>

                                </tr>
                                <?php
}
        ?>
                            </table>
                        </span>

                        <?php }?>
                        <div class="spacer"> </div>

                    </div>

                </div>

            </div>


        </div>
        <div style="height:30px"> </div>

        <div id="answerBox" style="height:250px">
            <div id="answerBox1" class="mainBox" onMouseOver="this.className = 'mainBox mainBoxHighlighted';"
                onMouseOut="this.className = 'mainBox';">

                <div class="boxContent helpSection">

                    <div class="sectionIcon">
                        &#160;
                    </div>

                    <div class="sectionTitle">
                        <h4><strong>&#160;<?php echo $msgstr["result"]; ?></strong></h4>
                    </div>

                    <div class="sectionButtons">
                        <div id="myanswer">
                            <img src="images/loading.gif" />
                        </div>
                        <input type="button" value="<?php echo $msgstr["gomysite"]; ?>"
                            OnClick="javascript:ReloadSite();" />
                    </div>

                </div>

 
            </div>
        </div>
        <div style="height:30px"> </div>
        <script>
        document.getElementById('answerBox').style.display = 'none';
        </script>

        <?php }

function MenuReserves($vector)
{
    global $arrHttp, $msgstr, $db_path, $valortag, $lista_bases, $dataarr, $EmpWeb;
    ?>

        <div id="firstBox" style="height:520px">
            <div id="firstBox1" class="mainBox" onMouseOver="this.className = 'mainBox mainBoxHighlighted';"
                onMouseOut="this.className = 'mainBox';">

                <div class="boxContent loanSection">

                    <div class="sectionIcon">
                        &#160;
                    </div>

                    <div class="sectionTitle">
                        <h4><strong>&#160;<?php echo $msgstr["publicationdata"]; ?></strong></h4>
                    </div>

                    <div class="sectionButtons">
                        <form name="formshow">
                            <h3>
                                <table>
                                    <tr>
                                        <td width="180px"><?php echo $msgstr["recordid"]; ?></td>
                                        <td><?php echo $vector["id"] ?></td>
                                    </tr>

                                    <tr>
                                        <td>&#160;</td>
                                        <td><input type="hidden" id="database" name="database"
                                                value="<?php echo $vector["database"]; ?>" /></td>
                                    </tr>

                                    <tr>
                                        <td><?php echo $msgstr["title"]; ?></td>
                                        <td><?php echo $vector["title"] ?></td>
                                    </tr>
                                    <tr>
                                        <td>&#160;</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo $msgstr["authors"]; ?></td>
                                        <td><?php echo $vector["authors"] ?></td>
                                    </tr>
                                    <tr>
                                        <td>&#160;</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo $msgstr["editor"]; ?></td>
                                        <td><?php echo $vector["publisher"] ?></td>
                                    </tr>
                                    <tr>
                                        <td>&#160;</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo $msgstr["year"]; ?></td>
                                        <td><?php echo $vector["year"] ?></td>
                                    </tr>
                                    <tr>
                                        <td>&#160;</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo $msgstr["categrecord"]; ?></td>
                                        <td>
                                            <select name="objectType">
                                                <?php
foreach ($vector["objectType"] as $elemento) {
        echo "<option value='$elemento'>$elemento</option>";
    }
    ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>&#160;</td>
                                        <td></td>
                                    </tr>

                                    <tr>
                                        <td><?php echo $msgstr["numberofcopies"]; ?></td>
                                        <td><?php echo $vector["copies"]["info"] ?></td>
                                    </tr>

                                    <?php

    if (!empty($vector["copies"]["options"])) {
        ?>
                                    <tr>
                                        <td>&#160;</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <font color="red"><?php echo $msgstr["selectthevolume"]; ?></font>
                                        </td>
                                        <td>
                                            <select name="volumeId">
                                                <?php
foreach ($vector["copies"]["options"] as $elemento) {
            echo "<option value='$elemento'>$elemento</option>";
        }
        ?>
                                            </select>
                                        </td>
                                    </tr>

                                    <?php

    }
    ?>
                                    <tr>
                                        <td>&#160;</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo $msgstr["librarylegend"]; ?></td>
                                        <td><?php if (!empty($vector["library"])) {
        echo $vector["library"];
    }
    ?></td>
                                    </tr>


                                </table>
                            </h3>

                            <?php
if (!empty($vector["objectType"]) && !empty($vector["objectType"])) {
        ?>
                            <input type="button" value="<?php echo $msgstr["makereservation"]; ?>"
                                OnClick="javascript:PlaceReserve(<?php echo "'" . $vector["id"] . "','" . $vector["objectType"] . "','" . $vector["library"] . "'" ?>);" />
                            <?php
} else {?>
                            <div class="inputAlert"><?php echo $msgstr["alertnocateg"]; ?></div>
                            <br />
                            <?php
}?>

                            <input type="button" value="<?php echo $msgstr["gomysite"]; ?>" OnClick="<?php if ($EmpWeb == "Y") {
        echo 'javascript:clearOperation();';
    } else {
        echo 'javascript:GoToSite()';
    }
    ?>" />

                            <div class="spacer"> </div>


                        </form>
                    </div>
                </div>

            </div>
        </div>
        <div style="height:30px"> </div>
        <div id="answerBox" style="height:250px">
            <div id="answerBox1" class="mainBox" onMouseOver="this.className = 'mainBox mainBoxHighlighted';"
                onMouseOut="this.className = 'mainBox';">

                <div class="boxContent helpSection">

                    <div class="sectionIcon">
                        &#160;
                    </div>

                    <div class="sectionTitle">
                        <h4><strong>&#160;<?php echo $msgstr["result"]; ?></strong></h4>
                    </div>

                    <div class="sectionButtons">
                        <div id="myanswer">
                            <img src="images/loading.gif" />
                        </div>
                        <input type="button" value="<?php echo $msgstr["gomysite"]; ?>" OnClick="<?php if ($EmpWeb == "1") {
        echo 'javascript:clearOperation();';
    } else {
        echo 'javascript:GoToSite()';
    }
    ?>" />
                    </div>

                </div>

            </div>
        </div>
        <div style="height:30px"> </div>
        <script>
        document.getElementById('answerBox').style.display = 'none';
        </script>

        <?php }?>