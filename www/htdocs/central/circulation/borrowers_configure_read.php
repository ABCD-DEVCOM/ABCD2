<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      borrowers_configure_read.php
 * @desc:      Read the configuration of the borrowers (users) database
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

///////

function LeerPft_Borrowers($pft_name){
global $arrHttp,$db_path,$lang_db,$bd;$msgstr;
	$pft="";
	$archivo=$db_path.$bd."/loans/".$_SESSION["lang"]."/$pft_name";
	if (!file_exists($archivo)) $archivo=$db_path.$bd."/loans/".$lang_db."/$pft_name";
	$fp=file_exists($archivo);
	if ($fp){
		$fp=file($archivo);
		foreach ($fp as $value){
			$pft.=$value;
		}

	}
    return $pft;

}

$bd="users";
///pft para leer el prefijo para localizar el usuario en la base de datos de usuarios
$uskey="";
$archivo=$db_path.$bd."/loans/".$_SESSION["lang"]."/loans_uskey.tab";
if (!file_exists($archivo)) $archivo=$db_path.$bd."/loans/".$lang_db."/loans_uskey.tab";
if (!file_exists($archivo)){	echo $msgstr["missing"]. " ".$archivo;
	die;}
$fp=file($archivo);
$ix=0;
$uskey="CO_";
$usname="NO_";
$uspft="v30";
foreach ($fp as $value){	$ix++;
	$value=trim($value);
	switch ($ix){		case 1:
			$uskey=$value;
			break;
		case 2:
			$usname=$value;
			break;
		case 3:
			$uspft=$value;
			break;	}}
$pft_uskey=LeerPft_Borrowers("loans_uskey.pft");     // pft para leer el código de usuario
$pft_ustype=LeerPft_Borrowers("loans_ustype.pft");   // pft para leer el tipo de usuario
$pft_usvig=LeerPft_Borrowers("loans_usvig.pft");     // pft para leer la vigencia del usuario
$pft_usdisp=LeerPft_Borrowers("loans_usdisp.pft");   // pft para desplegar la información del usuario
?>