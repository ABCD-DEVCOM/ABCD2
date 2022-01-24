<?php

/*
* 2022-01-18 rogercgui added new user-configurable classes
* 2022-01-21 rogercgui added "else" by class
*/

echo "<style>\n";
	
	if ((isset($def["BODY_BACKGROUND"])) && (!empty($def["BODY_BACKGROUND"]))) {
		echo "
		BODY {
		background-color: ".$def["BODY_BACKGROUND"].";
		}\n";
	} else {
		echo "
		BODY {
		background-color: #ffffff;
		}\n";
	}

	if ((isset($def["COLOR_LINK"])) && (!empty($def["COLOR_LINK"]))) {
		echo "
		a,
		a.menuButton span {
		color: ".$def["COLOR_LINK"].";
		}\n";
	} else {
		echo "
		a,
		a.menuButton span {
		color: #336699;
		}\n";		
	}

	if ((isset($def["HEADING"])) && (!empty($def["HEADING"]))) {
		echo "
		.heading, 
		nav.heading-nav ul li, 
		nav.heading-nav a, 
		nav.heading-nav select,
		.bt-cat,
		.bt-loan,
		.bt-acq,
		.modal {
		background-color: ".$def["HEADING"].";
		}\n";
	} else {
		echo "
		.heading, 
		nav.heading-nav ul li, 
		nav.heading-nav a, 
		nav.heading-nav select,
		.bt-cat,
		.bt-loan,
		.bt-acq,
		.modal {
		background-color: #003366;
		}\n";		
	}

	if ((isset($def["TOOLBAR"])) && (!empty($def["TOOLBAR"])))  {
		echo "
		div.toolbar-dataentry,
		body.toolbar-dataentry {
		background-color: ".$def["TOOLBAR"].";
		}\n";
	} else {
		echo "
		div.toolbar-dataentry,
		body.toolbar-dataentry {
		background-color: #f8f8f8;
		}\n";		
	}

	if ((isset($def["USERINFO_FONTCOLOR"])) && (!empty($def["USERINFO_FONTCOLOR"]))) {
		echo "
		.userInfo, 
		.userInfo A, 
		.language, 
		.language A, 
		.institutionalInfo H1, 
		.institutionalInfo H2,
		.institutionalInfo H1, 
		.institutionalInfo H2 {
			color: ".$def["USERINFO_FONTCOLOR"].";d
		}\n";
	} else {
		echo "
		.userInfo, 
		.userInfo A, 
		.language, 
		.language A, 
		.institutionalInfo H1, 
		.institutionalInfo H2,
		.institutionalInfo H1, 
		.institutionalInfo H2 {
			color: #ffffff;
		}\n";		
	}


	if ((isset($def["SECTIONINFO"])) && (!empty($def["SECTIONINFO"]))){
		echo "
		.sectionInfo,
		#myDiv,
		.button_browse, 
		a.button_browse, 
		.submit,
		.button_browse.show,
		.bt-cat.active,
		.bt-loan.active,
		.bt-acq.active  {
		background-color: ".$def["SECTIONINFO"].";
		}\n";
	} else {
		echo "
		.sectionInfo,
		#myDiv,
		.button_browse, 
		a.button_browse, 
		.submit,
		.button_browse.show,
		.bt-cat.active,
		.bt-loan.active,
		.bt-acq.active  {
		background-color: #336699;
		}\n";		
	}
	

	if ((isset($def["SECTIONINFO_FONTCOLOR"])) && (!empty($def["SECTIONINFO_FONTCOLOR"]))) {
		echo "
		.sectionInfo .sectionInfo a,
		.breadcrumb,
		.breadcrumb a,
		.actions a,
		.actions a{
		color: ".$def["SECTIONINFO_FONTCOLOR"].";
		}\n";
	} else {
		echo "
		.sectionInfo .sectionInfo a,
		.breadcrumb,
		.breadcrumb a,
		.actions a,
		.actions a {
		color: #ffffff;
		}\n";		
	}

	if ((isset($def["HELPER"])) && (!empty($def["HELPER"]))){
		echo ".helper {
		background-color: ".$def["HELPER"].";
		}\n";
	}

	if ((isset($def["HELPER_FONTCOLOR"])) && (!empty($def["HELPER_FONTCOLOR"]))) {
		echo "
		.helper,
		.helper a{
		color: ".$def["HELPER_FONTCOLOR"].";
		}\n";
	} else {
		echo "
		.helper,
		.helper a{
		color: #666666;
		}\n";		
	}

	if ((isset($def["FOOTER"])) && (!empty($def["FOOTER"]))) {
		echo ".footer {
		background-color: ".$def["FOOTER"].";
		}\n";
	} else {
		echo ".footer {
		background-color: #003366;
		}\n";
	}

	if ((isset($def["FOOTER_FONTCOLOR"])) && (!empty($def["FOOTER_FONTCOLOR"]))) {
		echo "
		.footer,
		.footer a{
		color: ".$def["FOOTER_FONTCOLOR"].";
		}\n";
	} else {
		echo "
		.footer,
		.footer a{
		color: #f8f8f8;
		}\n";
	}
	echo "</style>\n";
?>
