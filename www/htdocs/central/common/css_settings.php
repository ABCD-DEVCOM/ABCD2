<?php

/*
* 2022-01-18 rogercgui added new user-configurable classes
*/


if (isset($def["BODY_BACKGROUND"]) or 
	isset($def["HEADING"]) or 
	isset($def["USERINFO"]) or 
	isset($def["SECTIONINFO"]) or 
	isset($def["HELPER"]) or 
	isset($def["FOOTER"])){

	echo "<style>\n";
	
	if (isset($def["BODY_BACKGROUND"])){
		echo "
		BODY {
		background-color: ".$def["BODY_BACKGROUND"].";
		}\n";
	}

	if (isset($def["COLOR_LINK"])){
		echo "
		a,
		a.menuButton span {
		color: ".$def["COLOR_LINK"].";
		}\n";
	}

	if (isset($def["HEADING"])){
		echo "
		.heading, 
		nav.heading-nav ul li, 
		nav.heading-nav a, 
		nav.heading-nav select,
		.bt-cat {
		background-color: ".$def["HEADING"].";
		}\n";
	}

	if (isset($def["TOOLBAR"])){
		echo "
		div.toolbar-dataentry,
		body.toolbar-dataentry {
		background-color: ".$def["TOOLBAR"].";
		}\n";
	}

	if (isset($def["USERINFO_FONTCOLOR"])){
		echo "
		.userInfo, 
		.userInfo A, 
		.language, 
		.language A, 
		.institutionalInfo H1, 
		.institutionalInfo H2 {
		color: ".$def["USERINFO_FONTCOLOR"].";
		}

		.institutionalInfo H1, 
		.institutionalInfo H2 {
			color: ".$def["USERINFO_FONTCOLOR"].";
		}

		.heading H1{
			color: ".$def["USERINFO_FONTCOLOR"].";
		}\n";
	}
	if (isset($def["SECTIONINFO"])){
		echo ".sectionInfo {
		background: ".$def["SECTIONINFO"].";
		}\n";
	}
	if (isset($def["SECTIONINFO_FONTCOLOR"])){
		echo ".sectionInfo .sectionInfo A{
		color: ".$def["SECTIONINFO_FONTCOLOR"].";
		}
		.breadcrumb {
		color: ".$def["SECTIONINFO_FONTCOLOR"].";
		}
		.breadcrumb A{
		color: ".$def["SECTIONINFO_FONTCOLOR"].";
		}
		.actions A{
		color: ".$def["SECTIONINFO_FONTCOLOR"].";
		}
		 .actions A{
		color: ".$def["SECTIONINFO_FONTCOLOR"].";
		}\n";
	}
	if (isset($def["HELPER"])){
		echo ".helper {
		background-color: ".$def["HELPER"].";
		}\n";
	}
	if (isset($def["HELPER_FONTCOLOR"])){
		echo ".helper {
		color: ".$def["HELPER_FONTCOLOR"].";
		}\n";
		echo ".helper A{
		color: ".$def["HELPER_FONTCOLOR"].";
		}\n";
	}
	if (isset($def["FOOTER"])){
		echo ".footer {
		background-color: ".$def["FOOTER"].";
		}\n";
	}
	if (isset($def["FOOTER_FONTCOLOR"])){
		echo ".footer{
		color: ".$def["FOOTER_FONTCOLOR"].";
		}\n";
		echo ".footer A{
		color: ".$def["FOOTER_FONTCOLOR"].";
		}\n";
	}
	echo "</style>\n";
}


?>
