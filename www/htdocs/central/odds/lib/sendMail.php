<?php

	function _iso_to_date($date) {
		$year = substr($date, 0, 4);
		$month = substr($date, 4, 2);
		$day = substr($date, 6, 2);
		return "$day/$month/$year";
	}	

	/** 
	 * Load template to body success mail
	 */	
	function _read_success($title, $name, $date, $notes, $uploadFiles) {
		$pathToFile = "http://".$_SERVER['HTTP_HOST'].'/bases/odds/';
		include("../../config.php"); 
		// pipe is the separator character between files
		$files = explode("|", $uploadFiles);

		// load suitable template to email body
		if (count($files) == 1) {
			$template = utf8_decode(file_get_contents($db_path."odds/def/$lang/odds_success_mail_single_file.tab"));
		} else if (count($files) > 1) {
			$template = utf8_decode(file_get_contents($db_path."odds/def/$lang/odds_success_mail_multiple_file.tab"));
		} else {
			die("<hr> >> lib/sendMail :: Error in _read_success function!<hr>");
		}

		$b = explode("\n", $template);
		$template = trim($b[1]);		
		
		// replaces in template's text
		$template = str_replace("|name|", $name, $template);
		$template = str_replace("|date|", _iso_to_date($date), $template);
		$template = str_replace("|request_data|", $title, $template);		
		$template = str_replace("|number_of_days|", "10", $template);
		
		// processing upload files
		// many files have been uploaded
		if (count($files) > 1) {
			$filesString = "<ul>";
			foreach ($files as $uf) {
				if (trim($uf)!="") {					
					$fileToLink = trim($uf);
					$filesString .= "<li><a target='_blank' href='". $pathToFile . $fileToLink ."'>". trim($uf) ."</a></li>";
				}				 
			}
			$filesString .= "</ul>";
			$template = str_replace("|url|", $filesString, $template);
		// single file have been uploaded
		} else if (count($files) == 1) {			
			$fileToLink = trim($files[0]);			
			$template = str_replace("|url|", "<a target='_blank' href='". $pathToFile . $fileToLink."'>". trim($fileToLink) ."</a>", $template);			
		} else {
			die ("Reply cannot be send due to missing files");
		}		
		return trim($template);
	}

	// Load template to cancel mail
	function _read_cancel($title, $name, $date, $notes) {
		include("../../config.php");
		$template = utf8_decode(file_get_contents($db_path."odds/def/$lang/odds_cancel_mail.tab"));	
		$b = explode("\n", $template);
		$template = trim($b[1]);		
		// replaces				
		$template = str_replace("|name|", $name, $template);
		$template = str_replace("|date|", _iso_to_date($date), $template);
		$template = str_replace("|request_data|", $title, $template);
		$template = str_replace("|notes|", $notes, $template);
		return $template;
	}

	// send mail using BLAT or smtp server in Linux systems
	function _sendMail($template, $subject, $to) {
		include_once("senderMailLinux.php");
		include_once("library.php");
		$to = str_replace(", ",",",$to);
		//TEST :: echo ">> OS: ".getOs();
		if (getOs() == "UNIX") {			
			send($to, $subject, $template);
		} else {
			exec('blat  -body "'.$template.'" -subject "'.$subject.'" -to '.$to.'  -sender biblioteca@aeu.org.uy -from biblioteca@aeu.org.uy -embed  logo.jpg  -html', $res);
		}
	}
	
	// read subject form template file
	function _read_subject($status) {	
		include("../../config.php");
		if ($status == 2) {
			$content = utf8_decode(file_get_contents($db_path."odds/def/$lang/odds_success_mail_single_file.tab"));
		} else if ($status == 3) {
			$content = utf8_decode(file_get_contents($db_path."odds/def/$lang/odds_cancel_mail.tab"));
		}
		$a = explode("subject = ", $content);
		$b = explode("\n", $a[1]);
		return  trim($b[0]);
	}	

	/* ------------ MAIN  ------------------------------------------ */	
	if (trim($_GET['status']) != "" ) {
		$subject_notification =_read_subject(trim($_GET['status']));
		
		if (!isset($_GET['email'])) {
			die("E-mail address missing");
		} else {
			$to = $_GET['email'];
			if (isset($_GET['email_apoderado'])) {
				if (trim($_GET['email_apoderado'])!="") {
					$to .= ", ". $_GET['email_apoderado'];
				}
			}
		}
		// TEST
		//$to = "gsignorele@gmail.com";	
		//var_dump($to);

		// status = 2 - success mail will be send
		if (trim($_GET['status']) == 2) {			
		  	$successTemplate = _read_success(trim(str_replace("/", " ", $_GET['title'])), $_GET['name'], $_GET['fecha'], $_GET['notes'], $_GET['uploadFiles']);		  	
  			_sendMail($successTemplate, $subject_notification, $to);
  			echo "<b><font  face='Verdana' size='2' color='#364c6c'> E-mail sent</font></b>";
  						
		// status = 3 - cancel mail will be send
		} elseif (trim($_GET['status']) == 3) {			
			$cancelTemplate = _read_cancel($_GET['title'], $_GET['name'], $_GET['fecha'], $_GET['notes']);			
  			_sendMail($cancelTemplate, $subject_notification, $to);
  			echo "<b><font  face='Verdana' size='2' color='#364c6c'> E-mail sent</font></b>";
		}
	}
/* -------------------------------------------------------------------*/

?>