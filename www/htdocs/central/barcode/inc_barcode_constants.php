<?php
/*
20220320 fho4abcd Created. Contains common used variables for the label/barcode functionality
*/
$labeltablename="listoflabels.tab";
$labeltable=$base."/def/".$lang."/".$labeltablename;// for display in messages
$labeltablefull=$db_path.$labeltable;
$labeltablearr=array();

// The config file name is <prefix><name><suffix>
$configfileprefix=$base."/pfts/".$lang."/";
$configfilesuffix=".conf";
// The pft filename is <prefix><name><suffix>
// The suffix is controlled in conf data
$pftfileprefix=$base."/pfts/".$lang."/";
