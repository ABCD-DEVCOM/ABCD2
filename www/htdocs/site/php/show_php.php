<?php

$var = array_merge($_POST, $_GET);
$query = "?";

foreach($var as $key => $value)
{
    $query .= $key . "=" . $value . "&";
}


if(strpos($url,"http://") === false){
  include($url);
}else{
  include($url.$query);
}

?>
