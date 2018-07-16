<?php

  //SOAP request as RAW data
//  $HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
//  $HTTP_RAW_POST_DATA = $server->service(file_get_contents("php://input") ) ;
//echo "HTTP_RAW_POST =". $HTTP_RAW_POST_DATA. "<BR>";
  //Parse SOAP request using normal PHP parser.
  $post_data = trim(file_get_contents("php://input"));
//  echo "<BR>POSTDATA=$post_data<BR>";
  $parser = xml_parser_create('');
  xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, 'UTF-8');
  xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
  xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
//  xml_parse_into_struct($parser, trim($HTTP_RAW_POST_DATA), $xml_values);
  xml_parse_into_struct($parser, $post_data , $xml_values);
//  echo "<BR>xmlvalues="; var_dump($xml_values); echo "<BR>";
  xml_parser_free($parser);

  //Read ini file to start mysql connection
  $vectorini = parse_ini_file(dirname(__FILE__)."/config.inc.php");

  //Start log if config.ini sets
  if ($vectorini['DEBUG'])
  {
    $handle = fopen($vectorini['LOGFILE'],"a+");
    $variable = print_r($xml_values,true);
    logline($handle,"Incoming SOAP - ".$variable);
  }

  //Connect with mysql
//  $link = mysql_connect($vectorini['HOST'].":".$vectorini['PORT'], $vectorini['USER'], $vectorini['PASSWD']);
  $link = mysqli_connect($vectorini['HOST'].":".$vectorini['PORT'], $vectorini['USER'], $vectorini['PASSWD'],$vectorini['DATABASE']);
//echo "connection = " . $vectorini['HOST'] . $vectorini['PORT'] . $vectorini['USER'] . $vectorini['PASSWD'] . $vectorini['DATABASE'] . "<BR>";
//  mysql_select_db($vectorini['DATABASE']);


  // Error case
  if (!$link) {

      if ($vectorini['DEBUG'])
      {
       logline($handle,'Mysql error initial connection - '.mysql_error());
       fclose($handle);
      }
      die('Could not connect: ' . mysql_error());
  }

//    echo "<BR>IDvalue= "; var_dump($xml_values[3]['value']); echo "<BR>";
//var_dump($xml_values); die;
  // Determine SOAP service
//  if (strpos($xml_values[2]['tag'],'searchUsersById')!==false)
  if (isset($xml_values[2]) AND strpos($xml_values[2]['tag'],'searchUsersById')!==false)
  {
    // Search users by id

    createResponseForUserById($xml_values[3]['value'],$link,$handle,$vectorini);
  }
  else if (strpos(isset($xml_value[2]) AND $xml_values[2]['tag'],'searchUsers')!==false)
  {
    // Search users by name
    if ($xml_values[5]['tag']!='login')
    {
       createResponseForUserByName($xml_values[5]['value'],$link,$handle,$vectorini);
    }
    else
    {
       logline($handle,"Ingresa por login");
       createResponseForUserByLogin($xml_values[5]['value'],$link,$handle,$vectorini);
    }
  }


 //Close links
 if ($vectorini['DEBUG'])
 {
  fclose($handle);
 }
 mysqli_close($link);



// Search users by an unique id and returns a SOAP response
// configured specially for Empweb

function createResponseForUserById ($id, $link, $log, $vectorini)
{

 //Aca se produce un caso especial, para los reportes llega un set de ids separados por coma
 //Normalmente si es uno solo, devuelve un solo id

 if (strpos($id,",")!==false)
 {
    //Hay mas de un ID, vamos a aplicar el OR
    $vectorids=explode(",",$id);
    $myquery = $vectorini["QUERYBYID"];
    $myquery = str_replace("<id>",$vectorids[0],$myquery);


    for ($i=1;$i<sizeof($vectorids);$i++)
    {
        if (strlen($vectorids[$i])>0)
        {
          $myoquery = $vectorini["QUERYBYIDFORREPORTS"];
          $myquery .= str_replace("<idx>",$vectorids[$i],$myoquery);
        }
    }

 }
 else
 {
   if (strpos($id,"$")!==false)
   {
     $myquery = $vectorini["QUERYBYIDLIKE"];
     $id=str_replace("$","",$id);
   }
   else
   {
    $myquery = $vectorini["QUERYBYID"];
   }

   $myquery = str_replace("<id>",$id,$myquery);
 }

 if ($vectorini['DEBUG'])
 {
   logline($log,'Mysql statement:'.$myquery);
 }

 $result = mysqli_query($link, $myquery);

 //if ($result = mysqli_query($link, $myquery)) {
 //   printf("Select returned %d rows.\n", mysqli_num_rows($result));
 //}
 //echo "<BR>resULT=";
 //var_dump($result);
 //echo "end of result<BR>";
  if (!$result)
  {
     if ($vectorini['DEBUG'])
     {
       logline($log,'Mysql error:'.mysqli_error());
     }
  }

  createSOAPResponseId($result,$vectorini);

}

// Search users by name unifying the $ operator for any SQL database as LIKE %

function createResponseForUserByName ($lastname, $link, $log, $vectorini)
{

 if (substr($lastname,strlen($lastname)-1,1)=='$')
 {
     $myquery = $vectorini["QUERYBYNAMELIKE"];
     $myname = substr($lastname,0,strlen($lastname)-1);
 }
 else
 {
    $myquery = $vectorini["QUERYBYNAMEEXACT"];
    $myname = $lastname;
 }

 $myname=utf8_decode($myname);

 $myquery = str_replace("<name>",$myname,$myquery);

 if ($vectorini['DEBUG'])
 {
   logline($log,'Mysql statement:'.$myquery);
 }


 $result = mysql_query($myquery);
 if (!$result)
 {
     if ($vectorini['DEBUG'])
     {
       logline($log,'Mysql error:'.mysql_error());
     }
  }

 createSOAPResponseName($result,$vectorini);

}


function createResponseForUserByLogin ($login, $link, $log, $vectorini)
{

 $myquery = $vectorini["QUERYBYLOGIN"];
 $myquery = str_replace("<login>",$login,$myquery);

 if ($vectorini['DEBUG'])
 {
   logline($log,'Mysql statement:'.$myquery);
 }


 $result = mysql_query($myquery);
 if (!$result)
 {
     if ($vectorini['DEBUG'])
     {
       logline($log,'Mysql error:'.mysql_error());
     }
  }

 createSOAPResponseName($result,$vectorini);

}




function logline ($log,$content)
{
    fwrite($log,date("Y-m-d -- H:i:s",time())." - ".$content."\n");
}


function createSOAPResponseId($result,$vectorini)
{
//echo "result at end = ";
//var_dump($result);
     header('content-type:text/xml');
     include_once('headersoap.php');
     include_once('headerusersbyid.php');
     while ($row = mysqli_fetch_array($result)) { include('userrow.php'); }
     include_once ('footeruserbyid.php');
     include_once ('footersoap.php');


}

function createSOAPResponseName($result,$vectorini)
{
     header('content-type:text/xml');
     include_once('headersoap.php');
     include_once('headerusersbyname.php');
     while ($row = mysql_fetch_array($result)) { include('userrow.php'); }
     include_once ('footeruserbyname.php');
     include_once ('footersoap.php');


}
?>
