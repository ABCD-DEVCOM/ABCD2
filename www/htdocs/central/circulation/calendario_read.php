<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      calendario_read.php
 * @desc:      Reads the calendar
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
$feriados=array();
$ixmes=-1;
$file=$db_path."circulation/def/".$_SESSION["lang"]."/feriados.tab";
if (!file_exists($file)) $file=$db_path."circulation/def/".$lang_db."/feriados.tab";
if (file_exists($file)){
	$fp = file($file);
    foreach ($fp as $value){    	$ixmes=$ixmes+1;
    	if ($ixmes>0) $feriados[$ixmes]=$value;
    }
}

?>