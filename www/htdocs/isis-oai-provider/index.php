<?php

if(isset($_REQUEST['debug'])) {
	ini_set('display_errors', 1);
} else {
	ini_set('display_errors', 0);
}

define('APPLICATION_PATH', dirname(__FILE__));

if(isset($_REQUEST['verb'])) {
	require_once(APPLICATION_PATH . '/oai.php');
} else{

   $base_url =  "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'];
   $base_url = str_replace("index.php", "", $base_url);
?>

<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<title>ISIS-OAI-PROVIDER Harvesting Interface</title>
	<link rel="stylesheet" type="text/css" href="css/layout.css">	
	<link rel="shortcut icon" href="images/favicon.ico"/>
</head>
<script type="text/javascript" src="js/functions.js"></script>
<body marginheight="0" topmargin="0" leftmargin="0">
<div id="header">
	<div id="title">
		ISIS-OAI-PROVIDER Harvesting Interface
	</div>
</div>
<FORM name="sendQuery" method="post" action="#">
<div id="main_group">
	<input type="hidden" name="oaiURL" value="<?php echo $base_url; ?>"/> 
	<div id="group_title">OAI URL</div>
	<div id="group_content"><?php echo $base_url; ?></div>			
</div>	
<div>
	<table width="100%" cellpadding="0" cellspacing="0">
		<tr>
			<td width="30%" valign="top">
			<div id="left">			
				<div id="group">
					<div id="group_title">verbs</div>
					<div id="group_content">
						<div id="menu_item"><a href="javascript: setForm('Identify'); showVerb('Identify');">Identify</a></div>
						<div id="menu_item"><a href="javascript: setForm('ListMetadataFormats'); showVerb('ListMetadataFormats');">ListMetadataFormats</a></div>						
						<div id="menu_item"><a href="javascript: setForm('ListSets'); showVerb('ListSets');">ListSets</a></div>
						<div id="menu_item"><a href="javascript: setForm('ListIdentifiers'); showVerb('ListIdentifiers');">ListIdentifiers</a></div>						
						<div id="menu_item"><a href="javascript: setForm('ListRecords'); showVerb('ListRecords');">ListRecords</a></div>
						<div id="menu_item"><a href="javascript: setForm('GetRecord'); showVerb('GetRecord');">GetRecord</a></div>																								
					</div>			
				</div>
				<div id="group">
					<div id="group_title">verb description</div>
						<div id="group_content">
							<div id="Identify" name="Identify" style="display: none;">
								<p>This verb returns the main protocol information.</p>
								<p>
								<b>Compulsory parameters</b>
								<ul><li>verb</li></ul>
								</p>
							</div>
							<div id="ListMetadataFormats" name="ListMetadataFormats" style="display: none;">
								<p>It describes the metadata formats used in the protocol.</p>
								<p>
								<b>Compulsory parameters</b>
								<ul>
									<li>verb</li>
									</ul>
								</p>							
							</div>
							<div id="ListIdentifiers" name="ListIdentifiers" style="display: none;">
								<p>It retrieves a list with the single identifier of each document published.</p>
								<p>
								<b>Compulsory parameters</b>
								<ul>
									<li>verb</li>
									<li>metadataPrefix</li>								
								</ul>
								</p>
								<p>
								<b>Optional parameters</b>
								<ul>
									<li>from</li>
									<li>until</li>
									<li>set</li>								
								</ul>
								<p>
								<b>Exclusive parameter</b>
								<ul>
									<li>resumptionToken</li>
								</ul>
								</p>									
							</div>
							<div id="ListSets" name="ListSets" style="display: none;">
								<p>Retrieves a list of all databases available on this repository.</p>
								<p>
								<b>Compulsory parameters</b>
								<ul>
									<li>verb</li>
								</ul>
								</p>	
								<p>
								<b>Exclusive parameter</b>
								<ul>
									<li>resumptionToken</li>
								</ul>
								</p>									
														
							</div>
							<div id="ListRecords" name="ListRecords" style="display: none;">
								<p>Retrieves the list of documents.</p>
								<p>
								<b>Compulsory parameters</b>
								<ul>
									<li>verb</li>
									<li>metadataPrefix</li>								
								</ul>
								</p>
								<p>
								<b>Optional parameters</b>
								<ul>
									<li>from</li>
									<li>until</li>
									<li>set</li>								
								</ul>
								<p>
								<b>Exclusive parameter</b>
								<ul>
									<li>resumptionToken</li>
								</ul>
								</p>															
							</div>
							<div id="GetRecord" name="GetRecord" style="display: none;">
								<p>Retrieve the metadata of a specific record.</p>
								<p>
								<b>Compulsory parameters</b>
								<ul>
									<li>verb</li>
									<li>metadataPrefix</li>						
									<li>identifier</li>								
								</ul>
								</p>							
							</div>																														
						</div>			
					</div>		
				</div>
			</td>
			<td width="70%" valign="top">
			<div id="right">
				<div id="group">
					<div id="group_title">setup parameters</div>
					<div id="group_content">
							<table>
								<tr>
									<td>verb</td>
									<td><input type="text" name="verb" disabled="disabled"/></td>
									<td></td>
								</tr>							
								<tr>
									<td>MetadataPrefix</td>
									<td><input type="text" name="MetadataPrefix" maxlength="15"/></td>
									<td>oai_dc | isis</td>
								</tr>
								<tr>
									<td>set</td>
									<td><input type="text" name="set" size="9" maxlength="9"/></td>
									<td>database name</td>
								</tr>	
								<tr>
									<td>identifier</td>
									<td><input type="text" name="identifier" size="34" maxlength="34"/></td>
									<td></td>
								</tr>	
								<tr>
									<td>from</td>
									<td><input type="text" name="from" size="10" maxlength="10"/></td>
									<td>YYYY-MM-DD</td>
								</tr>		
								<tr>
									<td>until</td>
									<td><input type="text" name="until" size="10" maxlength="10"/></td>
									<td>YYYY-MM-DD</td>									
								</tr>	
								<tr>
									<td>resumptionToken</td>
									<td><input type="text" name="resumptionToken" size="34"/></td>
									<td></td>									
								</tr>	
							</table>
							<p align="center">
								<a href="#" onclick="javascript: submitForm();" class="btn">execute</a>
							</p>		
					</div>			
				</div>
				<div id="group">
					<div id="group_title">output</div>
					<div id="group_content">
						<div id="output">
							Harvested URL:</br>
							<input type="text" name="outputURL" size="100"/></br>
							Result:</br>
							<iframe name="oai_output" width="99%" height="300px"/>
						</div>
					</div>			
				</div>	
			</div>
			</td>
		</tr>
	</table>	
</div>
</FORM>
</body>
</html>

<?php } // END IF verb ?>
