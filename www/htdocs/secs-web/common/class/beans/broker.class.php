<?php
/* Class that replace IsisBrokerOld
 * IsisBroker access the database directly (calling a .xis file)
 * Don't use webservice (NuSOAP)
 *
 * Still have one problem, many functions are repeated
 * they are cantidate to delete then in future version
 */
class IsisBroker
{
	var $client;  //candidato a apagar
	var $error;  //candidato a apagar
	var $path2WS;  //candidato a apagar

	function __construct()
	{
            global $configurator; //candidato a apagar
	}

	function setWebService($path2WS){
		$this->path2WS = $path2WS;
	}

	function getWebService(){
            return $this->path2WS;
	}

	function getError()
	{
            return $this->error;  //candidato a apagar
	}

        function listar($xmlparameters)
	{
            $result = IsisMfnRange($xmlparameters);
            return ($result);
	}

	function writeNewRecord($xmlparameters,$registro)
	{
            $result = IsisWrite($xmlparameters,utf8_decode($registro->asXML()));
            $mark = 'record mfn="';
            $p = strpos($result, $mark);
            if ($p){
                    $p = $p + strlen($mark);
                    $mfn = substr($result, $p);
                    $p = strpos($mfn, '"');
                    $mfn = substr($mfn, 0,$p);
            }
            return $mfn;
	}

	function updateRecord($xmlparameters,$registro)
	{
            $result = IsisWrite($xmlparameters,utf8_decode($registro->asXML()));
	}

	function updateRecordFacic($xmlparameters,$registro)
	{
            $result = IsisWrite($xmlparameters,utf8_decode($registro->asXML()));
	}

	function deleteRecord($xmlparameters)
	{
            $result = IsisDelete($xmlparameters);
	}

    function multipleDelete($xmlparameters)
	{
            $result = IsisMultDelete($xmlparameters);
	}

	function search($xmlparameters)
	{
            $result = IsisSearch($xmlparameters);
            return ($result);

	}

	function searchFacic($xmlparameters)
	{
            $result = IsisSearch($xmlparameters);
            return ($result);
	}

	function IsisSearchSort($xmlparameters)
	{
            $result = IsisSearchSort($xmlparameters);
            return ($result);
	}

	function keyrange($xmlparameters)
	{
            $result = IsisSearch($xmlparameters);
            return ($result);
	}

	function keyrange_mfnrange($xmlparameters)
	{
            $result = IsisKeyrangeMfnrange($xmlparameters);
            return ($result);
	}

	function index($xmlparameters)
        {
            $result = IsisIndex($xmlparameters);
            return ($result);
	}

        function nextID($path){
            
            $lockDir = $path.'.lock';
            $filename = $path.'.txt';
            $cont = '';
            $error = 0;
            
            if(!mkdir($lockDir)){ return CREATE_LOCK_ERROR; }

            $file = fopen($filename, 'r');

            if($file){
                $cont = fread($file, filesize($filename));
                if(!$cont){
                    $error = FILE_READ_ERROR;
                }
                if(!fclose($file)){
                    $error = FILE_READ_ERROR;
                } else {
                    $contUpdated = (int)$cont + 1;

                    $file = fopen($filename, 'w');

                    if(!$file) {
                        $error = PERMISSION_ERROR;
                    }
                    if(!fwrite($file, $contUpdated)){
                        $error = PERMISSION_ERROR;
                    }
                    if(!fclose($file)){
                        $error = PERMISSION_ERROR;
                    }
                }
            }
            else {
                $error = FILE_READ_ERROR;
            }
            if(!rmdir($lockDir)){ return DELETE_LOCK_DIR; }
            if ($error) {
                return $error;
            }
            else {
                return $cont;
            }
        }




}



?>