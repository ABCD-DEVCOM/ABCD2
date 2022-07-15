<?php 
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      change_pass_mysite.php
 * @desc:      CHange the pass of a user in the mysite module
 * @author:    Marcos Mirabal
 * @since:     20161201
 * @version:   2.0
 *
 * == BEGIN LICENSE ==
 *
 *    This program is free software: you can redistribute it and/or modify
 *    it under the terms of the GNU Lesser General Public License as
 *    published by the Free Software Foundation, either version 3 of the
 *    License, or (at your option) any later version.
 *
 *    This program is distributed in the hope that it will be useful,
 *    but WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *    GNU Lesser General Public License for more details.
 *
 *    You should have received a copy of the GNU Lesser General Public License
 *    along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * == END LICENSE ==
*/
include("config.php");
$response="";
$OS=strtoupper(PHP_OS);
$converter_path=$cisis_path."mx";
$user=$_GET["user"];
$pass=$_GET["pass"];
$newp=$_GET["newp"];
if (isset($MD5) and $MD5==1 ){
		$newp=md5($newp);
	}

if (isset($$EmpWeb) and $EmpWeb=="N" ){
//Use the Central module
$mx=$converter_path." ".$db_path."users/data/users \"pft=if v600='".$user."' then if v610='".$pass."' then mfn,'|+~+', fi fi\" now";
exec($mx,$outmx,$banderamx);
$textoutmx="";
for ($i = 0; $i < count($outmx); $i++) {
$textoutmx.=substr($outmx[$i], 0);
}
if ($textoutmx!="")
{
	//Change the pasword
	$splittxt=explode("|",$textoutmx);
	$mfn=$splittxt[0];
	$MyNewRecord="<610>".$newp."<~610>";
	$MyRecord=str_replace ("~", '/', $MyNewRecord);
	$mx=$converter_path." ".$db_path."users/data/users \"proc='d610', '".$MyRecord."' \"  from=".$mfnc." count=1  copy=".$db_path."users/data/users now -all";
	exec($mx,$outmx,$banderamx);	
}
else $response="Invalid user or password";
}
else
{
//Use the  Empweb module
// Connecting, selecting database
$MyHost=$MyUser=$MyPass="";
if (!file_exists("bridge/config.inc.php")){
	echo "Missing  config.inc.php in the central/bridge folder"; die;
}
$def = parse_ini_file("bridge/config.inc.php");
$MyHost=$def["HOST"];
$MyUser=$def["USER"];
$MyPass=$def["PASSWD"];
$link = mysql_connect($MyHost, $MyUser, $MyPass)
    or die('Could not connect: ' . mysql_error());
mysql_select_db('university') or die('Could not select database');

// Performing SQL query
$query = "UPDATE users SET passwd='".$newp."' where login='".$user."' AND passwd='".$pass."';";
$result = mysql_query($query) or die('Query failed: ' . mysql_error());
if (mysql_affected_rows()==0) $response="Invalid user or password";	
}
echo $response;
?>