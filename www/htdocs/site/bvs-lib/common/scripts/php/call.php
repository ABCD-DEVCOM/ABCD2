<?php

include("wxis.php");

if ( isset($HTTP_POST_VARS) )
{
	$_REQUEST = $HTTP_POST_VARS;
}

if ( $_REQUEST["task"] == " list " )
{
	print(wxis_list($_REQUEST["wxis_parameters"]));
}

if ( $_REQUEST["task"] == " search " )
{
	print(wxis_search($_REQUEST["wxis_parameters"]));
}

if ( $_REQUEST["task"] == " index " )
{
	print(wxis_index($_REQUEST["wxis_parameters"]));
}

if ( $_REQUEST["task"] == " edit " )
{
	print(wxis_edit($_REQUEST["wxis_parameters"]));
}

if ( $_REQUEST["task"] == " write " )
{
	print(wxis_write($_REQUEST["wxis_parameters"],$_REQUEST["wxis_write_content"]));
}

if ( $_REQUEST["task"] == " delete " )
{
	print(wxis_delete($_REQUEST["wxis_parameters"]));
}

if ( $_REQUEST["task"] == " control " )
{
	print(wxis_control($_REQUEST["wxis_parameters"]));
}

?>
