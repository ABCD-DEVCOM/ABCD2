<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      copies_linkdb.php
 * @desc:      Reads if a database is linked or not to the copies database
 * @author:    Guilda Ascencio
 * @since:     20091203
 * @version:   1.0
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
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../common/get_post.php");
include("../config.php");
$lang=$_SESSION["lang"];
include("../lang/dbadmin.php");
include("../lang/acquisitions.php");

//foreach ($arrHttp as $var=>$value)  echo "$var=$value<br>";
//READ BASES.DAT TO READ IF THE DATABASE IS LINKED WITH COPIES DATABASE
$base=$arrHttp["base"];
$fp=file($db_path."bases.dat");
$copies_link="";
foreach ($fp as $value){	$value=trim($value);	$v=explode('|',$value);
	if ($v[0]==$base){		if ($v[2]=="Y") $copies_link=" checked";
		break;	}}
		echo($db_path.$base);
exec("/var/www/abcd/www/cgi-bin/retag ".$db_path.$base."/".data."/".$base, $output,$t);
$straux=$output[0];
echo("<script> alert('Database unlocked successfully!');
window.history.back();

</script>");

?>
