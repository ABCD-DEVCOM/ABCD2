<?php
$people = array("Peter", "Joe", "Glenn", "Cleveland");

reset($people);

foreach ($people as $key=>$val)
  {
  echo "$key => $val<br>";
  }
?>