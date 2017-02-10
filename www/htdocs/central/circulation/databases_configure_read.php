<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      databases_configure_read.php
 * @desc:      Reads the pfts which determines the configuration of an bibliographic database
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
$prefix_in="";
$prefix_cn="";
$pft_totalitems="";
$pft_in="";
$pft_cn="";
$pft_dispobj="";
$pft_storobj="";
$pft_disploan="";
$pft_typeofr="";

$archivo=$db_path.$arrHttp["db"]."/loans/".$_SESSION["lang"]."/loans_conf.tab";
if (!file_exists($archivo)) $archivo=$db_path.$arrHttp["db"]."/loans/".$lang_db."/loans_conf.tab";
if (!file_exists($archivo)){	//echo $msgstr["falta"]." ".$arrHttp["db"]."/loans/".$_SESSION["lang"]."/loans_conf.tab";
	//die;}else{
	$fp=file($archivo);
	foreach ($fp as $value){		if (trim($value)!=""){			$ix=strpos($value," ");
			$tag=trim(substr($value,0,$ix));
			switch($tag){				case "IN": $prefix_in=trim(substr($value,$ix));
					break;
				case "NC": $prefix_cn=trim(substr($value,$ix));
					break;			}
		}	}
}$pft_totalitems=LeerPft("loans_totalitems.pft");
$pft_in=LeerPft("loans_inventorynumber.pft");
$pft_nc=LeerPft("loans_cn.pft");
$pft_dispobj=LeerPft("loans_display.pft");
$pft_storobj=LeerPft("loans_store.pft");
$pft_loandisp=LeerPft("loans_show.pft");
$pft_typeofr=LeerPft("loans_typeofobject.pft");
?>