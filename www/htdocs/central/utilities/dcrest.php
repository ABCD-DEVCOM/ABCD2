<?php

global $Permiso, $arrHttp,$valortag,$nombre,$userid,$db,$vectorAbrev;
$arrHttp=Array();
//session_start();
error_reporting(E_ALL);
require_once(dirname(__FILE__)."/../config.php");
$converter_path=$cisis_path."mx";


$page="";
if (isset($_REQUEST['GET']))
	$page = $_REQUEST['GET'];
else
	if (isset($_REQUEST['POST'])) $page = $_REQUEST['POST'];

if (!(preg_match("|^[a-z_./]*$|", $page) && !preg_match("|\\.\\.|", $page))) {
	// Abort the script
	die("Invalid request");

}
$valortag = Array();
$listItems = "";
$listItemsRepo = 0;
$listItemsReal = 0;
$cantItems = 0;

 
class Repository_api
{

    public $rest_url;    
	public $bd_abcd;
	public $cant_elem;	
	public $count_records;
	
    
	public function __construct($rest_url,$bd_abcd,$count_records)
    {      		   		 
		 			 
         $this->rest_url = $this->urlComplit($rest_url);
 		 $this->bd_abcd = $bd_abcd;
		 $this->cant_elem = 0;
		 $this->count_records = $count_records;
		 
    }
    
	function urlComplit($url){
	   if(substr($url, -1) != "/")	   
	     $url .= "/";	   
	   
	   return $url;
	}
	
	function getCantElemntAg(){
	  return  $this->cant_elem;
	}
	
	// REST
    function call_api($metodo, $endpoint, $data = array(),$cant = -1){
//global $_POST;
	   
        $resultado = array();
        $request_url =  $this->rest_url. $endpoint;
        $ch = curl_init();
		

		if($ch == false)
		    return -1;
			
		$header = array(
            'Content-Type: application/json',
            "Accept: application/json"
			);
 
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_URL, $request_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
             				
		if(isset($_POST['proxy'])){	   
//var_dump($_POST);die;
			 curl_setopt($ch, CURLOPT_PROXY, $_POST['proxyhttp']);
		     curl_setopt($ch, CURLOPT_PROXYPORT,$_POST['puerto']);	
             							                          
		}  
				
      		
        //Parametros del request
        if (count($data) > 0) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

         $response = curl_exec($ch);
		  
		 /* $info = curl_getinfo($ch);
		  foreach ($info as $var => $value)	{
		    		    echo $var."=>".$value."</br>";
		  }*/
		
       if (curl_errno($ch)) {

            $fp = fopen("Mylog.txt", "a+");
            fwrite($fp, "> Error Curl [" . curl_error($ch) . "]\n");
            fclose($fp);

        } else {
             $resultado = json_decode($response, true);
							 
            if (JSON_ERROR_NONE !== json_last_error()) {

                $fp = fopen("Mylog.txt", "a+");
                fwrite($fp, "> Error JSON [" . json_last_error()."] \n");
                fclose($fp);
            }
        }

        curl_close($ch);

        return $resultado;	  
		  
		 
    }
 
    function get_TotalItems(){

	       $total = 0;
		   $cant = 0;

            $url = "communities?expand=all";
			
			 $results = $this->call_api("GET", $url);
//echo "results=$results from URL $url<BR>";
			if($results == -1)	return -1;	
					   
			foreach ($results as $var => $value)  
			          $cant += $value['countItems'];                  
    
       return $cant;
	}    
	
	function get_listing($path = "/", $page = ""){
       
        global $listItemsRepo,$listItemsReal,$msgstr;
		$list = array();
        $list['list'] = array();
		$rang = 1;
		$ini = 0;
		$pivo = TotalItems();
		
      	$cantItem = $this->get_TotalItems();		
		
		if($this->count_records != 0 && $this->count_records <= $cantItem)
		  $cantItem = $this->count_records;
		
	    if($this->count_records > $cantItem){
		   ?>
				<script type="text/javascript">
                    alert("<?php echo $msgstr["errorcant"]?>");
                    window.location.href = "dcdspace.php?base="+"<?php echo $this->bd_abcd?>";					  
                </script>
		    <?php ;		
		}
		else{
		
			$listItemsRepo = $cantItem;
			
					?>
					<script language=javascript>
					ListElemt("<?php echo round(($listItemsReal/$listItemsRepo)*100,1)."%"?>","<?php echo $listItemsReal?>","<?php echo $listItemsRepo?>")
					</script>
					<?php ;
			
			 if($cantItem == -1)	
				return -1;			
			
			$cantIt = $cantItem/$rang;
			if($cantIt != intval($cantIt))
					$cantIt = intval( $cantIt + 1 );
				
		  
			for($i = 0;$i < $cantIt;$i++){
			
				$results = $this->call_api("GET", "items?expand=bitstreams&limit=$rang&offset=$ini");
				
				$z = 0;
				while($results == null && $z < 3){
				  $results = $this->call_api("GET", "items?expand=bitstreams&limit=$rang&offset=$ini");
				  $z += $z + 1;
				}
				   
				$listItemsReal += count($results);
				
				foreach ($results as $var => $item) {
				
						$auxidItem = "";
						  if(isset($item['id'])) $auxidItem = $item['id'];
						else
						  if(isset($item['uuid'])) $auxidItem = $item['uuid'];						
						$idItem = $auxidItem;				
						$creator = "";
						$contributor = "";
						$subject = "";
						$description = "";
						$publisher = "";					
						$date = "";					
						$type = "";
						$format = "";
						$identifier = "";
						$source = "";
						$language =  "";
						$relation = "";
						$coverage = "";
						$rights = "";					
						$url = "";	
						
										
			
					$itemAll = $this->call_api("GET", "items/$idItem?expand=metadata,bitstreams");			
					 
					foreach ($itemAll['metadata'] as $metadata) {
							
							if ($metadata['key'] == "dc.contributor.author") {
									
									 if($creator != "")
										 $creator .="; ".$metadata['value'];
										else
											$creator = $metadata['value'];
								   
								
							}
							
							if ($metadata['key'] == "dc.subject") {
							   
									   if($subject != "")
										  $subject .="; ".$metadata['value'];
										else
										  $subject = $metadata['value'];
							}
							
							if ($metadata['key'] == "dc.description" || $metadata['key'] == "dc.description.abstract") {
								  $description = $metadata['value'];
							}
							
							if ($metadata['key'] == "dc.publisher") {
								$publisher = $metadata['value'];
							}
							
							if ($metadata['key'] == "dc.contributor.advisor") {
									
									 if($contributor != "")
										 $contributor .="; ".$metadata['value'];
										else
											$contributor = $metadata['value'];
								   
								
							}
												
							if ($metadata['key'] == "dc.date.issued") {
								$date = $metadata['value'];
							}
							
							if ($metadata['key'] == "dc.type") {
								$type = $metadata['value'];
							}
							
							if ($metadata['key'] == "dc.format") {
								$format = $metadata['value'];
							}
							
							if ($metadata['key'] == "dc.identifier.uri") {
								$identifier = $metadata['value'];
							}
							
							if ($metadata['key'] == "dc.source") {
								$source = $metadata['value'];
							}
							
							if ($metadata['key'] == "dc.language") {
								$language = $metadata['value'];
							}
							
							if ($metadata['key'] == "dc.relation") {
								$relation = $metadata['value'];
							}
							
							if ($metadata['key'] == "dc.coverage") {
								$coverage = $metadata['value'];
							}
							
														
							if ($metadata['key'] == "dc.rights") {
								$rights = $metadata['value'];
							}
																	
							if ($metadata['key'] == "dc.relation") {
								$url = $metadata['value'];
							}					
							
												
							
						}
					
					foreach ($itemAll['bitstreams'] as $bitstreams) {
							$aux = "";							
							if(isset($bitstreams['id'])) $aux = $bitstreams['id'];
							 else
							if(isset($bitstreams['uuid'])) $aux = $bitstreams['uuid'];							
							$url = $this->rest_url."bitstreams/".$aux."/retrieve" ;
						
						}
						
						
						 $list['list'][] = array(
						   'id' => $idItem,
						   'title' => str_replace( "?", "'", mb_convert_encoding($itemAll['name'], "latin1", "utf-8") ),
							'creator' => mb_convert_encoding($creator, "latin1", "utf-8"),
							'subject' =>  strtoupper( mb_convert_encoding($subject, "latin1", "utf-8")),
							'description' =>  strtoupper( mb_convert_encoding($description, "latin1", "utf-8")),						
							'publisher' => mb_convert_encoding($publisher, "latin1", "utf-8"),
							'contributor' => mb_convert_encoding($contributor, "latin1", "utf-8"),
							'date' => mb_convert_encoding($date, "latin1", "utf-8"),
							'type' => mb_convert_encoding($type, "latin1", "utf-8"),
							'format' => mb_convert_encoding($format, "latin1", "utf-8"),
							'identifier' => mb_convert_encoding($identifier, "latin1", "utf-8"),
							'source' => mb_convert_encoding($source, "latin1", "utf-8"),
							'language' => mb_convert_encoding($language, "latin1", "utf-8"),
							'relation' => mb_convert_encoding($relation, "latin1", "utf-8"),
							'coverage' => mb_convert_encoding($coverage, "latin1", "utf-8"),
							'rights' => mb_convert_encoding($rights, "latin1", "utf-8"),
							'url' => $url,
							'dateadd' => date("Ymd H:i:s"));
												  
				}
				  
				  $this->Catalog($list,$pivo+1);
				  $list = array();
				  $pivo = $pivo + $rang;
				  $ini = $ini + $rang;
			}
		
        }
    }

    function Catalog($items,$numbCont){
	   
	 
	
	   $variablesD = array();
	   $tag = "";
	   
	  
       foreach ($items['list'] as  $value) {
	   
	     $this->cant_elem += 1;
		
		  if($_POST['id'] != "")
		  {
		    $tag = str_replace("v", "tag", $_POST['id']);
			$variablesD[$tag]= $numbCont++;
		  }
		  else
		      $variablesD["tag111"]= $numbCont++;
		
         
		if($value['title'] != ""){	
		 
		    if($_POST['title'] != "")
		    {
		      $tag = str_replace("v", "tag", $_POST['title']);
			  $variablesD[$tag]= $value['title'];
		    }
		    else
  		      $variablesD["tag1"]= $value['title'];
		}
				 
		if($value['creator'] != ""){	
		 
		    if($_POST['creator'] != "")
		    {
		      $tag = str_replace("v", "tag", $_POST['creator']);
			  $variablesD[$tag]= $value['creator'];
		    }
		    else
  		      $variablesD["tag2"]= $value['creator'];
		}
		
		if($value['subject'] != ""){	
		 
		    if($_POST['subject'] != "")
		    {
		      $tag = str_replace("v", "tag", $_POST['subject']);
			  $variablesD[$tag]= $value['subject'];
		    }
		    else
  		      $variablesD["tag3"]= $value['subject'];
		}
		
		if($value['description'] != ""){	
		 
		    if($_POST['description'] != "")
		    {
		      $tag = str_replace("v", "tag", $_POST['description']);
			  $variablesD[$tag]= $value['description'];
		    }
		    else
  		      $variablesD["tag4"]= $value['description'];
		}
		
		if($value['publisher'] != ""){	
		 
		    if($_POST['publisher'] != "")
		    {
		      $tag = str_replace("v", "tag", $_POST['publisher']);
			  $variablesD[$tag]= $value['publisher'];
		    }
		    else
  		      $variablesD["tag5"]= $value['publisher'];
		}
				
		if($value['contributor'] != ""){	
		    $variablesD["tag6"]= $value['contributor'];
		}
		
		if($value['date'] != ""){	
		 
		    if($_POST['date'] != "")
		    {
		      $tag = str_replace("v", "tag", $_POST['date']);
			  $variablesD[$tag]= $value['date'];
		    }
		    else
  		      $variablesD["tag7"]= $value['date'];
		}
		
		if($value['type'] != ""){	
		 
		    if($_POST['type'] != "")
		    {
		      $tag = str_replace("v", "tag", $_POST['type']);
			  $variablesD[$tag]= $value['type'];
		    }
		    else
  		      $variablesD["tag8"]= $value['type'];
		}
		
		if($value['format'] != ""){	
		 
		    if($_POST['format'] != "")
		    {
		      $tag = str_replace("v", "tag", $_POST['format']);
			  $variablesD[$tag]= $value['format'];
		    }
		    else
  		      $variablesD["tag9"]= $value['format'];
		}
		
		if($value['source'] != ""){	
		 
		    if($_POST['source'] != "")
		    {
		      $tag = str_replace("v", "tag", $_POST['source']);
			  $variablesD[$tag]= $value['source'];
		    }
		    else
  		      $variablesD["tag11"]= $value['source'];
		}
		
		if($value['language'] != ""){	
		    $variablesD["tag12"]= $value['language'];
		}
		
		if($value['relation'] != ""){	
		    $variablesD["tag13"]= $value['relation'];
		}
		
		if($value['coverage'] != ""){	
		    $variablesD["tag14"]= $value['coverage'];
		}
		
		if($value['rights'] != ""){	
		    $variablesD["tag15"]= $value['rights'];
		}
		
		if($value['url'] != ""){	
		 
		    if($_POST['link'] != "")
		    {
		      $tag = str_replace("v", "tag", $_POST['link']);
			  $variablesD[$tag]= $value['url'];
		    }
		    else
  		      $variablesD["tag98"]= $value['url'];
		}
		
		if($value['dateadd'] != ""){	
		    $variablesD["tag112"]= $value['dateadd'];
		}		
		
				
        /*foreach ($variablesD as $var => $value)		    
		       $listItems =  $listItems.str_replace("tag", "v", $var)." = $value<br>";               			   
       		   $listItems = $listItems."<br>";	   
	     */	
		 
        $this->AddItemsBD($variablesD,"crear","New");
		
	   }	     
	  
				
	}

	function InitializeBD(){
	
	    global $arrHttp,$OS,$xWxis,$wxisUrl,$db_path,$Wxis,$msgstr;
		$db = $this->bd_abcd;
		$arrHttp["base"] = $db;
		
		$query = "&base=".$db."&cipar=$db_path"."par/".$db.".par"."&Opcion="."inicializar";
		$arrHttp["IsisScript"]="administrar.xis";
		$IsisScript=$xWxis.$arrHttp["IsisScript"];
		
		include("../common/wxis_llamar.php");
		foreach ($contenido as $linea){
		
			if ($linea=="OK"){
				//Reset the  base/data/control_number.cn
				@unlink($db_path.$db."/data/control_number.cn"); 			
				$fp=fopen($db_path.$db."/data/control_number.cn","w");
				fwrite($fp,"0");
				fclose($fp);			
				
			}
		}
		
			
			
	}
	
	function AddItemsBD($variablesD,$opcion,$mfn){
		
	    $listItems = "";
		$tabla = Array();

		global $lang,$vars,$cipar,$from,$base,$ValorCapturado,$arrHttp,$ver,$valortag,$fdt,$tagisis,$cn,$msgstr,$tm,$lang_db,$MD5;
		global $xtl,$dataentry,$xnr,$Mfn,$FdtHtml,$xWxis,$variables,$db_path,$Wxis,$default_values,$rec_validation,$wxisUrl,$validar,$tm;
		global $max_cn_length,$listItemsReal,$listItemsRepo;

			$variables_org=$variablesD;
			$ValorCapturado="";
			$VC="";
			
			
			$base = $this->bd_abcd;			
			$cipar = $base.".par";
			
					
			if (isset($variablesD)){
			  		
			
				foreach ($variablesD as $key => $lin){
					
					$listItems =  $listItems.str_replace("tag", "v", $key)." = $lin<br>";               			   
       		        		
					
					
					$key=trim(substr($key,3));
					$k=$key;
					$ixPos=strpos($key,"_");
					if (!$ixPos===false) {
						$key=substr($key,0,$ixPos-1);
					}
					if (trim($key)!=""){
						if (strlen($key)==1) $key="000".$key;
						if (strlen($key)==2) $key="00".$key;
						if (strlen($key)==3) $key="0".$key;
						$lin=stripslashes($lin);
						$campo=array();
						if ($dataentry!="xA")
								$campo=explode("\n",$lin);
							else
						        $campo[]=str_replace("\n","",$lin);
						foreach($campo as $lin){
							$VC.=$k." ".$lin."\n";
							$ValorCapturado.=$key.$lin."\n";
							
						}
					}
				}
			}
			
			$listItems = $listItems."<br>";
            echo $listItems;
	        ob_flush();
            flush();
			?>
                        <script language=javascript>
                        ListElemt("<?php echo round(($listItemsReal/$listItemsRepo)*100,1)."%"?>","<?php echo $listItemsReal?>","<?php echo $listItemsRepo?>")
                        </script>
                        <?php ;
			
			$valc=explode("\n",$ValorCapturado);
			
			$ValorCapturado="";
			$Eliminar="";
			foreach ($valc as $v){
				$v=trim($v);
				
				if (trim(substr($v,0,4))!=""){
				   $Eliminar.="d".substr($v,0,4);
				  
				   if (trim(substr($v,4))!="")
						 $ValorCapturado.="<".substr($v,0,4)." 0>".substr($v,4)."</".substr($v,0,4).">";
				}
			}
			
			$x=isset($default_values);
			$fatal_cn="";
			$fatal="";
			$error="";
			
					unset($validar);
							
					$file_val="";
					
					if ($file_val=="" or !file_exists($file_val)){
						$file_val=$db_path.$base."/def/".$lang."/".$base.".val";
						if (!file_exists($file_val))  $file_val=$db_path.$base."/def/".$lang_db."/".$base.".val";
					}
					
					
			
				$ValorCapturado=urlencode($Eliminar.$ValorCapturado);
			
			
			
			$IsisScript=$xWxis."actualizar.xis";
			
			if (file_exists($db_path."$base/data/stw.tab"))
				$stw="&stw=".$db_path."$base/data/stw.tab";
			else
				if (file_exists($db_path."stw.tab"))
					$stw="&stw=".$db_path."stw.tab";
				else
					$stw="";
					
		 
			
			 $query = "&base=".$base."&cipar=$db_path"."par/".$cipar."&login=abcd&Mfn=" .$mfn."&Opcion=".$opcion."$stw&ValorCapturado=".$ValorCapturado;
			 include("../common/wxis_llamar.php");
			
		   	}
  
}        //end of class Repository_api

/*
-Primer parametro URL
-Segundo parametro nombre de la base dato
-tercer parametro nombre del ???
*/

     
ob_flush();
flush();

$count_records = 0;
 if(isset($_POST['count']))
  if($_POST['count'] != "")
   {
     $count_records = $_POST['count'];
   }

     $repo = new Repository_api($_POST["url"],$base_ant,$count_records);

    
	 if(isset($_POST['eliminRegist']))
		$repo->InitializeBD();
		
		   
		//echo $repo->get_TotalItems(); 
		  
		$test = $repo->get_listing();   
				  
		 if($test == -1)
			  echo "The handler was NOT successfully created";
		 else{
		 if($repo->getCantElemntAg() != 0)
		 $cantItems = "Items retrieved : <label style=\"color: #FF0000\"> ". $repo->getCantElemntAg()." </label>";
	     else
         $cantItems = 0;
		 ?>
		 <script language=javascript>
		 ListElemt("<?php echo -1 ?>","<?php echo $listItemsReal ?>","<?php echo $listItemsRepo ?>")
		 </script>
		 <?php ;
	     }?>
