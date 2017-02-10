<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      autoincrement.php
 * @desc:      Calculate the next number to be assigned in the autoincrement field
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
// se determina el número siguiente del campo autoincremente
$cn="";
$archivo=$db_path.$arrHttp["base"]."/data/control_number.cn";
if (!file_exists($archivo)){	$cn=false;
	return;}
$perms=fileperms($archivo);
if (is_writable($archivo)){
//se protege el archivo con el número secuencial
	chmod($archivo,0555);
// se lee el último número asignado y se le agrega 1
	$fp=file($archivo);
	$cn=implode("",$fp);
	$cn=$cn+1;
// se remueve el archivo .bak y se renombre el archivo .cn a .bak
	if (file_exists($db_path.$arrHttp["base"]."/data/control_number.bak"))
		unlink($db_path.$arrHttp["base"]."/data/control_number.bak");
	$res=rename($archivo,$db_path.$arrHttp["base"]."/data/control_number.bak");
	chmod($db_path.$arrHttp["base"]."/data/control_number.bak",$perms);
	$fp=fopen($archivo,"w");
    fwrite($fp,$cn);
   	fclose($fp);
    chmod($archivo,$perms);
    if (isset($max_cn_length)) $cn=str_pad($cn, $max_cn_length, '0', STR_PAD_LEFT);
 }else{ 	$cn=false; }

?>
