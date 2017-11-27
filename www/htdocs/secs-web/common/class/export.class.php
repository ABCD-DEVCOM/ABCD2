<?php
/**
 * @desc        Classe de controle de base de dados
 * @package     [secsWeb] SeCS
 * @version     1.0
 * @author      Bruno Neofiti <bruno.neofiti@bireme.org>
 * @since       julho de 2009
 * @copyright   (c)BIREME - PFI - 2009
 * @public
*/

/*
 * @return URL or Exception
 */
function displayExport(){

    try{

        $pathFile = exportTitle($_GET["export"], $_GET["ibictID"], $_GET["numberRegisters"], $_GET["formatType"], $_GET["registerID"], $_GET["searchExpr"], $_GET["indexes"] );
        $fileName = basename($pathFile);

        switch ($_GET['export']) {
            case 'titWithoutCollection':
                    $newfileName = $_GET["filename"].".iso";
                    break;
            case 'sendToSeCS':
                    $newfileName = $_GET["filename"].".001";
                    break;
            case 'sendToSeCS-step2':
                    $newfileName = $_GET["filename"].".002";
                    break;
            case 'titFormatIBICT':
                    $newfileName = $_GET["filename"].".lst";
                    break;
            case 'titFormatIBICT-step2':
                    $newfileName = $_GET["filename"].".lst";
                    break;
            case 'titWithCollection':
                    $newfileName = $_GET["filename"].".iso";
                    break;
        }

    }
    catch(Exception $error)
    {
        return $error->getMessage();
    }

    $exportFile = "http://".$_SERVER['HTTP_HOST']."/secs-web/saveFile.php?pathFile=".$pathFile."&newFile=".$newfileName;
    return $exportFile;


}


function exportTitle($exportType =null, $ibictID=null, $numberRegisters=null ,$formatType=null, $registerID=null, $searchExpr=null, $indexes=null){

        $strInitialPosition = stripos($_SERVER["SERVER_SOFTWARE"],"Win32");
        $serverOS = substr($_SERVER["SERVER_SOFTWARE"], $strInitialPosition, "5");
        if($serverOS == "Win32"){
            //Variaveis para Windows
            $pathMX = BVS_DIR."\\cgi-bin\\ansi\\mx.exe";
            $pathMXCP = BVS_DIR."\\cgi-bin\\ansi\\mxcp.exe";
            $pathTitleDB = BVS_DIR."\\bases\\secs-web\\title";
            $pathTitleISO = BVS_TEMP_DIR."\\title-".$_SESSION["centerCode"].date("Ymd-Gi");
            $pathHldgDB = BVS_DIR."\\bases\\secs-web\\".$_SESSION["libraryDir"]."\\holdings";
            $pathTempTitle = BVS_TEMP_DIR."\\temptitle-".$_SESSION["centerCode"].date("Ymd-Gi");
            $pathTempHldg = BVS_TEMP_DIR."\\tempholdings-".$_SESSION["centerCode"].date("Ymd-Gi");
            $titleFST = BVS_DIR."\\bases\\secs-web\\title.fst";
            $tempTitleFST = BVS_TEMP_DIR."\\temptitle-".$_SESSION["centerCode"].date("Ymd-Gi").".fst";
            $hldgFST = BVS_DIR."\\bases\\secs-web\\main\\holdings.fst";
            $tempHldgFST = BVS_TEMP_DIR."\\tempholdings-".$_SESSION["centerCode"].date("Ymd-Gi").".fst";
            $goTempDirectory = BVS_TEMP_DIR;
            $pathISOTitle = BVS_TEMP_DIR."\\exported-".$_SESSION["centerCode"].date("Ymd-Gi");
            $newFile = BVS_TEMP_DIR."\\".$_SESSION["centerCode"].date("Ymd-Gi");

        }else{
            //Variaveis para Linux
            $pathMX = BVS_DIR."/cgi-bin/ansi/mx";
            $pathMXCP = BVS_DIR."/cgi-bin/ansi/mxcp";
            $pathTitleDB = BVS_DIR."/bases/secs-web/title";
            $pathTitleISO = BVS_TEMP_DIR."/title-".$_SESSION["centerCode"].date("Ymd-Gi");
            $pathHldgDB = BVS_DIR."/bases/secs-web/".$_SESSION["libraryDir"]."/holdings";
            $pathTempTitle = BVS_TEMP_DIR."/temptitle-".$_SESSION["centerCode"].date("Ymd-Gi");
            $pathTempHldg = BVS_TEMP_DIR."/tempholdings-".$_SESSION["centerCode"].date("Ymd-Gi");
            $titleFST = BVS_DIR."/bases/secs-web/title.fst";
            $tempTitleFST = BVS_TEMP_DIR."/temptitle.fst";
            $hldgFST = BVS_DIR."/bases/secs-web/main/holdings.fst";
            $tempHldgFST = BVS_TEMP_DIR."/tempholdings-".$_SESSION["centerCode"].date("Ymd-Gi").".fst";
            $goTempDirectory = BVS_DIR;
            $pathISOTitle = BVS_TEMP_DIR."/exported-".$_SESSION["centerCode"].date("Ymd-Gi");
            $newFile = BVS_TEMP_DIR.$_SESSION["centerCode"].date("Ymd-Gi");
        }

    switch($exportType) {
        case "titWithoutCollection":

            if($numberRegisters == "allRegisters"){
                
                if($searchExpr != "" && $searchExpr != "null"){
                    $createTitleDB = $pathMX." ".$pathTitleDB." ".$indexes."=".$searchExpr." create=".$pathTempTitle." -all now";
                    exec($createTitleDB);
                    $pathTitleDB = $pathTempTitle;
                }
                $executeCommand = $pathMX." ".$pathTitleDB." iso=".$pathTitleISO." -all now";
                
            }else{
                $findMfn = $pathMX." ".$pathTitleDB." pft=\" if v30='".$registerID."' then mfn fi\" -all now";
                $mfn = exec($findMfn);
                $executeCommand = $pathMX." ".$pathTitleDB." from=".$mfn." count=1 iso=".$pathTitleISO." -all now";

            }
            sortTitleByField37();
            $file = exec($executeCommand);
            if($serverOS != "Win32"){
                $convert2unix = "unix2dos ".$pathTitleISO;
                exec($convert2unix);
            }
            return $pathTitleISO;
            break;
        
        case "titWithCollection":

            if($formatType == "secsFormat"){
                //cria as bases temptitle e tempholdings
                if($numberRegisters == "allRegisters"){
                    $createTitleDB = $pathMX." ".$pathTitleDB." create=".$pathTempTitle." -all now";
                    $createHldgDb = $pathMX." ".$pathHldgDB." create=".$pathTempHldg." -all now";
                }else{
                    $findTitleMfn = $pathMX." ".$pathTitleDB." pft=\" if v30='".$registerID."' then mfn fi\" -all now";
                    $mfnTitle = exec($findTitleMfn);
                    $createTitleDB = $pathMX." ".$pathTitleDB." from=".$mfnTitle." count=1 create=".$pathTempTitle." -all now";
                    $findHldgMfn = $pathMX." ".$pathHldgDB." pft=\" if v30='".$registerID."' then mfn fi\" -all now";
                    $mfnHldg = exec($findHldgMfn);
                    $createHldgDb = $pathMX." ".$pathHldgDB." from=".$mfnHldg." count=1 create=".$pathTempHldg." -all now";

                }
                exec($createTitleDB);
                exec($createHldgDb);
                copy($titleFST, $tempTitleFST); //copia facic.fst para novo diretorio
                copy($hldgFST, $tempHldgFST);
                $invertTitleDb = $pathMX." ".$pathTempTitle." fst=@".$pathTempTitle.".fst fullinv/ansi=".$pathTempTitle." -all now";
                $invertHldgDb = $pathMX." ".$pathTempHldg." fst=@".$pathTempHldg.".fst fullinv/ansi=".$pathTempHldg." -all now";
                exec($invertTitleDb);
                exec($invertHldgDb);
                //faz um join de temptitle e tempholdings
                $atualDirectory = getcwd();
                chdir($goTempDirectory);
                $joinHldgTitle = $pathMX." ".$pathTempTitle." \"join=tempholdings,970='TIT='v30\" \"proc='d32001'\" -all now copy=".$pathTempTitle;
                exec($joinHldgTitle);
                chdir($atualDirectory);
                $executeCommand = $pathMX." ".$pathTempTitle." iso=".$pathISOTitle." -all now";
            }
            $file = exec($executeCommand);
            sortTitleByField37();
            return $pathISOTitle;
            break;

        case "sendToSeCS":

            list($field30Hlds, $field37Hlds, $field970Hlds) = getAllHoldings();
            //list($field37Title) = getField37Title();

            if($field30Hlds[0] != ""){

                $content = "";
                for ($i=0; $i<count($field30Hlds); $i++) {
                    //&& $field37Title[$i] != ""
                    if($field970Hlds[$i] != ""){
                        $content .= $_SESSION["centerCode"]."|".$field30Hlds[$i]."|".$field970Hlds[$i]."|\r\n";
                    }
                }

                if($content != ""){
                    
                    $file = $newFile.".001";
                    if (!$openFile = fopen($file, "a")) {
                        throw new Exception("Open File Error $file");
                        return "no content";
                    }
                    if (!fwrite($openFile, $content)) {
                        throw new Exception("Writing File Error $file");
                        return "no content";
                    }
                    fclose($openFile);
                    return $file;

                }else{
                    throw new Exception("no content");
                    return "no content";
                }


            }else{
                throw new Exception("Empty database");
                return "Empty database";
            }
            break;

        case "sendToSeCS-step2":
            
            list($field30, $field910, $field911, $field912, $field913, $field914, $field915) = getAllIssues();
            if($field30[0] != ""){

                $content = "";
                for ($i=0; $i<count($field30); $i++) {
                    $content .= $_SESSION["centerCode"]."|".$field30[$i]."|".$field910[$i]."|".$field911[$i]."|".$field912[$i]."|".$field913[$i]."|".$field914[$i]."|".$field915[$i]."\r\n";
                }
                if($content != ""){
                    //$file = BVS_DIR."/temp/".$_SESSION["centerCode"].date("Ymd-Gi").".002";
                    $file = $newFile.".002";

                    if (!$openFile = fopen($file, "a")) {
                        throw new Exception("Open File Error $file");
                        return "no content";
                    }
                    if (!fwrite($openFile, $content)) {
                        throw new Exception("Writing File Error $file");
                        return "no content";
                    }

                    fclose($openFile);
                    return $file;

                }else{
                    throw new Exception("no content");
                    return "no content";
                }

            }else{
                throw new Exception("Empty database");
                return "no content";
            }
            break;
        
        case "titFormatIBICT":

            list($field30Hlds, $field37Hlds, $field970Hlds) = getAllHoldings();
            list($field20Title) = getAllTitles();
            if($field970Hlds[0] != ""){
                $content = "";
                for ($i=0; $i<count($field970Hlds); $i++) {
                    if($field20Title[$i] != "" && $field970Hlds[$i] != "" ){
                        $content .= "!REC-ID\r\n!C010!".$ibictID."\r\n";
                        $content .= "!C020!".$field20Title[$i]."\r\n";
                        $content .= "!C030!".$field970Hlds[$i]."\r\n";
                    }
                }
                if($content != ""){
                    //$file = BVS_DIR."/temp/".$_SESSION["centerCode"]."C".date("Ymd-Gi")."";
                    $file = $newFile.".col";

                    if (!$openFile = fopen($file, "a")) {
                        throw new Exception("Open File Error $file");
                        return "no content";
                    }
                    if (!fwrite($openFile, $content)) {
                        throw new Exception("Writing File Error $file");
                        return "no content";
                    }
                    fclose($openFile);
                    return $file;
                }


            }else{
                throw new Exception("Empty database");
                return "no content";
            }
            break;

        case "titFormatIBICT-step2":

            list($field20, $field100, $field400) = getAllTitles();
            if($field400[0] != ""){
                $content = "";
                for ($i=0; $i<count($field400); $i++) {
                    $content .= "!REC-ID\r\n!S001!".$ibictID."\r\n";
                    if($field100[$i]){ $content .= "!S200!".$field100[$i]."\r\n"; }
                    if($field400[$i]){ $content .= "!S440!".$field400[$i]."\r\n"; }
                }

                if($content != ""){
                    //$file = BVS_DIR."/temp/".$_SESSION["centerCode"]."C".date("Ymd-Gi")."";
                    $file = $newFile.".col";

                    if (!$openFile = fopen($file, "a")) {
                        throw new Exception("Open File Error $file");
                        return "no content";
                    }
                    if (!fwrite($openFile, $content)) {
                        throw new Exception("Writing File Error $file");
                        return "no content";
                    }
                    fclose($openFile);
                    return $file;
                }

            }else{
                throw new Exception("Empty database");
                return "no content";
            }
            break;

    }
}

?>
