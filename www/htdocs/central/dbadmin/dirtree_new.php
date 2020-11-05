<?php


/*
 This program is free software; you can redistribute it and/or
 modify it under the terms of the GNU General Public License
 as published by the Free Software Foundation in any version
 of the License.
 This program is non professional and distributed in the hope that it will be
 useful, but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 =============================================================================
 Application  : WEB SERVER PHP DIRECTORY TREEVIEW FILE MANAGER/EXPLORER V.1.0
 Name Program : dirtree.php, auxiliary sample calling program inidirtree.php
 Author       : Aitor Solozabal Merino (Spain)
 Email        : aitor-3@euskalnet.net
 Date         : 25-02-2005
 Type         : php program utility ( all in one )
 Description  : A file manager and directory treeview from any server path
              : (hidden) outside or inside the Web Server Root, this path
              : become the root for the treeview with features like
              : File Filter Criteria, Login Users, Download file, Upload file
              : Make dir, Remove dir, Rename dir, Erase file, Rename File.
              : The treeview include the visualization of the total number of
              : subdirs, files and bytes under every node displayed checking
              : the current File Filter Extensions Criteria
              : Developed & Tested in WAMP enviroment
              : (Windows XP SP2, Apache 1, Mysql 4, Php 4)
 Installation : Put this programs in a subfolder of the www of your web server
              : document root directory
              : Can be executed alone or with a calling external program
              : (see "how" with Sample inidirtree.php)
 Login User   : with specific privileges
              : loginuser="username" and password="userpassword"
              : privileges = restricted
              : loginuser="administrator" and password="adminpassword"
              : privileges = all
 =============================================================================
                               W A R N I N G S
 Due to storing the full information of the tree directory in SUPERGLOBAL
 $_SESSION arrays, the perfomance slow down when the number of nodes in the
 directory treeview grows up - is acceptable up to 3.000 nodes (files)
 The purpose is to manage a SUBDIR of a user, a project, a sharing zone, etc,
                  !!!!!! NOT THE FULL HARD DISK  ¡¡¡¡¡¡¡¡
 The LOGIN function is not professional, you must change it to accomodate to
 your data base of users
 =============================================================================
 The server path can be indicated inside php code or captured with html FORM
 and passed thru a SUPERGLOBAL variable $_POST or $_SESSION with a calling
 external program (see "how" with Sample inidirtree.php)
 Samples      : $_POST['Server_Path']= "c:\x-files\top secret\rockwell"
              : $_SESSION['Server_Path']= "c:\appserv\www\ftpzone"
 This path will be the ROOT for the treeview
 =============================================================================

                           Features of the 1.0 version:

 Treeview directory - showing number of subfolders, files etc under every node
 File filter extensions criteria - choose files to display and find them quickly
 Download file - open or save at the client side (with or without compresssion)
 Upload file - it does not rewrite an existing file in the server as a safe mode
 Erase file - with user confirmation
 Rename file - with user confirmation
 Make directory - with user confirmation
 Remove directory - with user confirmation. removes any subdir and file under
 Rename directory - with user confirmation
 Refresh process - to see changes made by other users
 5 modes of file size visualization (bytes, kilobytes, megabytes, lines and % )
 Turn a selected subdir into the treeview root
 Compress a selected file
 List contents of a selected compressed file
 Email a selected file - (with previous compression or not)
 Previously to use this function the SMTP parameter and  the sendmail_From
 parameter in the PHP.INI file must be set acordingly to your ISP smtp server.
 (your_ip_server could be anything). See a sample extracted from PHP.INI:
 [mail function]
 ; For Win32 only.
 SMTP = smtp.your_ip_server.com
 smtp_port = 25
 ; For Win32 only.
 sendmail_from = address@your_ip_server.com

 ------------------------------------------------------------------------------
                                T O  D O   L I S T
 ------------------------------------------------------------------------------
 1.- Full error checking to preserve and protect hidden real directory names
 2.- Rearrange font sizes conforming the display screen resolution of the client
     Variables $_SESSION['Width'] and $_SESSION['Height'] have the data pixels
 3.- Aesthetic and professional improvements in tables, forms & backgrounds(CSS)
 4.- Manage a virtual directory from a MySql database table with a SQL query
 5.- Copy or move files between subdirs in the server
 6.- Convert the full program in smaller units for a less consumption of memory
 ==============================================================================
                     FLOW DIAGRAM OF THE PROGRAM STRUCTURE
                             +-------------+
                             |    OTHER    |
      SAMPLE: INIDIRTREE.PHP |   CALLING   |
                             |   PROGRAM   |
                             +------+------+
                                    |
                                    V
                             +------+------+
+--------------------------->| DIRTREEVIEW |<----------------------------------+
| +------------------------->|   P  H  P   |                                   |
| |         +--------------->|   UTILITY   |<-------------------------------+  |
| |         |                +------+------+                                |  |
| |         |                       V                                       |  |
| |         |                  +----+----+                                  |  |
| |         |                  |  START  |                                  |  |
| |         |                  | SESSION |                                  |  |
| |         |                  +----+----+                                  |  |
| |         |                       V           +-----------------+ METHOD  |  |
| |         |                +------+------+ NO | "administrator" | "POST"  |  |
| |         |                | USERNAME ?  +--->+                 +-------->+  |
| |         |                +------+------+    | "adminpassword" |            |
| |         |                   YES V           +--------+--------+            |
| |         |             +---------+-------+     NO     |                     |
| |         |             |IS A VALID USER? +----------->+                     |
| |         |             +---------+-------+            |                     |
| |         |                   YES V                    |                     |
| |         |        +--------------+-------------+  NO  |                     |
| |         |        |IS A SESSION "AUTENTIFIED"? +----->+                     |
| |         |        +-----------------------+----+                            |
| |METHOD   | METHOD                         V YES                             |
| |"POST"   | "POST"                   +-----+------------------+              |
| |         |                      YES |   NO ACTIONS DEFINED   |              |
| |         |                     +----+          OR            |              |
| |         |                     |    |     "POST" ACTIONS     |              |
| |         |                     V    +-------------------+----+              |
| |    +----+--------+ YES +------+----------------+       |                   |
| |    + SELECT PATH +<----+IS EMPTY SERVER PATH ? |       |                   |
| |    +-------------+     +---------+-------------+       |                   |
| |          FORM                    V  NO                 |                   |
| |                        +---------+----------+          |                   |
| |                        |BUILD TREE STRUCTURE|          |NO                 |
| |          FORMS         +---------+----------+          |                   |
| |    +----------------+            V                     |                   |
| |  +-+ MAKE DIRECTORY +<-+         +-------------------->+                   |
| |  | +----------------+  |                               |                   |
| |  +-+REMOVE DIRECTORY+<-+                               |                   |
| |  | +----------------+  +  +--------------+             |                   |
| +<-+-+RENAME DIRECTORY+<-+<-+ DIR FUNCTIONS+<-+          |                   |
| |  | +----------------+  |  +--------------+  |          |                   |
| |  +-+BECAME TREE ROOT+<-+                    |          |                   |
| |  | +----------------+  |                    |          |            METHOD |
| |  +-+  UPLOAD FILE   +<-+                    |          V             "GET" |
| |    +----------------+                       |   +------+--------+          |
| |                                             +<--+ "GET" ACTIONS |          |
| |    +----------------+                       |   +------+--------+          |
| |  +-+  DOWNLOAD FILE +<-+                    |          |                   |
| |  | +----------------+  |                    |          |                   |
| |  +-+  RENAME FILE   +<-+                    |          |NO                 |
| |  | +----------------+  |  +--------------+  |          |                   |
| +<-+-+  ERASE FILE    +<-+<-+FILE FUNCTIONS+<-+          |                   |
| |  | +----------------+  |  +--------------+  |          |                   |
| |  +-+  EMAIL FILE    +<-+                    |          |                   |
| |  | +----------------+  |                    |          |                   |
| |  +-+  COMPRESS FILE +<-+                    |          |                   |
| |    +----------------+                       |          V                   |
| |                                             |  +-------+-------+           |
| |    +----------------+                       |  |    ACTIONS    |           |
| |  +-+  FILE FILTER   +<-+                    |  |EXPAND/COLLAPSE|           |
| |  | +----------------+  +  +--------------+  |  |  FULL EXPAND  |           |
| +<-+-+REFRESH TREEVIEW+<-+<-+ OTHER ACTIONS+<-+  +---+-----------+           |
|    | +----------------+  |  +--------------+         |                       |
|    +-+FILESIZE DISPLAY+<-+                           V                       |
|      +----------------+                  +-----------+-----+                 |
|                                          |DISPLAY TREEVIEW |                 |
|METHOD                                    +--------+--------+                 |
|"POST"                                             |                          |
|                                                   V                          |
|           FORM                                /---+---\                      |
|    +------------------+                      /  FINAL  \      +----------+   |
|    |   L O G O U T    |                     /  RESULT   \     |USER CLICK|   |
+<---+                  +<-------------------+   W  E  B   +--->+ON ACTIONS+-->+
     | SESSION DESTROY  |                     \  H T M L  /     |METHOD GET|
     +------------------+                      \ P A G E /      +----------+
                                                \-------/
*/
session_start();

error_reporting(E_ALL);
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^E_STRICT);
$arrHttp=Array();
if (!isset($_REQUEST["ACTION"])) $_REQUEST["ACTION"]="";
include("../common/get_post.php");
include("../config.php");
foreach ($arrHttp as $var=>$value)  echo "$var=$value<br>";  //die;

if (strpos($arrHttp["activa"],"|")===false){
    $db=$arrHttp["activa"]."**";
}   else{
		$ix=strpos($arrHttp["activa"],'^b');
		$db=substr($arrHttp["activa"],2,$ix-2);
}

if (isset($arrHttp["base"])) $_SESSION["dir_base"]=trim($arrHttp["base"]);
if ((isset($_SESSION["permiso"]["CENTRAL_ALL"]) or
    isset($_SESSION["permiso"]["CENTRAL_EXDBDIR"]) or
    isset($_SESSION["permiso"][$db."_CENTRAL_EXDBDIR"])) or
    (isset($_SESSION["permiso"][$_SESSION["dir_base"]."_CENTRAL_ALL"]) or
    isset($_SESSION["permiso"][$_SESSION["dir_base"]."CENTRAL_EXDBDIR"]))
    )
{}else{
	header("Location: ../common/error_page.php") ;
}
if (isset($arrHttp["base"]))
	$_SESSION["dir_base"]=trim($arrHttp["base"]);
else
	unset($_SESSION["dir_base"]);

$_POST["Server_Path"]=$db_path;
$_POST["Server_Path"].=trim($_SESSION["dir_base"]);
$_SESSION["Server_Path"]=$_POST["Server_Path"];
$_SESSION['Upload_Extension']="*.png,*.gif,*.jpg,*.pdf,*.xrf,*.mst,*.n01,*.n02,*.l01,*.l02,*.cnt,*.ifp,*.fmt,*.fdt,*.pft,*.fst,*.tab,*.txt,*.par,*.html,*.zip,*.iso";
$_POST['FILE_EXTENSION']="*.dat,*.def,*.iso,*.png,*.gif,*.jpg,*.pdf,*.xrf,*.mst,*.n01,*.n02,*.l01,*.l02,*.cnt,*.ifp,*.fmt,*.fdt,*.pft,*.fst,*.tab,*.txt,*.par,*.html,*.zip,";
//foreach ($arrHttp as $var=>$value) echo "$var = $value<br>"; die;
$_POST['File_Extension']=$_POST['FILE_EXTENSION'];
include("../lang/dbadmin.php");
include("../lang/soporte.php");
$lang=$_SESSION["lang"];
$_POST['username']=$_SESSION["login"];
$_POST['password']=$_SESSION["password"];
$_SESSION['autentified']=true;
global $encabezado;
$encabezado="";
if ($_REQUEST["ACTION"]!="downloadfile1"){
	include("../common/header.php");
	if (isset($arrHttp["encabezado"])){
		$encabezado="&encabezado=s";	}
	EncabezadoPagina();
	echo "<link rel=\"STYLESHEET\" type=\"text/css\" href=\"../css/".$css_name."template.css\">";
}

function EncabezadoPagina(){
global $arrHttp,$msgstr,$institution_name,$logo;	echo "<Body>";
    //if (isset($arrHttp["encabezado"]))
    	include("../common/institutional_info.php");
     echo "
		<div class=\"sectionInfo\">
		<div class=\"breadcrumb\">".
				$msgstr["expbases"]."
		</div>
		<div class=\"actions\">\n";
	//if (isset($arrHttp["encabezado"]))
			if (isset($_REQUEST["retorno"]) or !isset($arrHttp["base"]))
				$retorno="../common/inicio.php?reinicio=s";
			else
				$retorno="menu_mantenimiento.php?base=".$_REQUEST["activa"];
			echo "<a href=\"$retorno\" class=\"defaultButton backButton\">
					<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
					<span><strong>". $msgstr["back"]."</strong></span>
				</a>";
	echo "
		</div>
			<div class=\"spacer\">&#160;</div>
		</div>";

	 echo "
	 	<div class=\"helper\">
	<a href=../documentacion/ayuda.php?help=".$_SESSION["lang"]."/dirtree.html target=_blank>".$msgstr["help"]."</a>&nbsp &nbsp;
    ";
    echo "<font color=white>&nbsp; &nbsp; Script: dirtree.php</font></div>";

     echo "<div class=\"middle form\">
			<div class=\"formContent\">";}

Function BUILD_DIRECTORY_TREE($SOURCE, $PREVIOUS) {
/*
This code build the structure of the tree directory processing the output of the
dir PHP command in a recursive way, using the current file filter criteria and
storing the values in a set of arrays that must be shared among the rest of the
functions in the programs.
The first time call variable $SOURCE is the path choosen to be shown in a tree
the variable $_SESSION['Numfile'] the value of -1 and the variable $PREVIOUS=0.
*/
    $_SESSION['Numfile']++; //the first time from -1 to numfile=0
    $_SESSION['Folder_Name'] [$_SESSION['Numfile']] = BASENAME($SOURCE);
    $_SESSION['Father'] [$_SESSION['Numfile']] = $PREVIOUS;
    $_SESSION['Numbytes'][$_SESSION['Numfile']] = 0;
    $_SESSION['File_Date'][$_SESSION['Numfile']] = "";
    $_SESSION['Children_Files'] [$_SESSION['Numfile']] = 0;
    $_SESSION['Children_Subdirs'][$_SESSION['Numfile']] = 0;
    $_SESSION['Level_Tree'][$_SESSION['Numfile']] = SUBSTR_COUNT($SOURCE, DIRECTORY_SEPARATOR) - $_SESSION['Levels_Fixed_Path'];
    $_SESSION['Folder_Type'] [$_SESSION['Numfile']] = "Folder";
    $_SESSION['Opened_Folder'][$_SESSION['Numfile']] = 0;
    If (IS_FILE($SOURCE)) {
        $_SESSION['Folder_Type'] [$_SESSION['Numfile']] = "File";
        $_SESSION['Numbytes'][$_SESSION['Numfile']] = FILESIZE($SOURCE);
        $_SESSION['File_Date'][$_SESSION['Numfile']] = FILEMTIME($SOURCE);
        Return; //finish this branch and go up one level the recursion process
    }
    // ok is a directory
    $PREVIOUS = $_SESSION['Numfile'];
    // reading source path
    $DIR = DIR($SOURCE);
    While (false !== $ENTRY = $DIR->READ()) {
        If (($ENTRY != '.') && ($ENTRY != '..')) {
            // directory has children
            $NEW_DIR = $SOURCE . DIRECTORY_SEPARATOR . $ENTRY;
            If (IS_DIR($NEW_DIR) || (IS_FILE($NEW_DIR) && IS_FILE_TO_DISPLAY($ENTRY))) {
                // go down one level the recursion process
                BUILD_DIRECTORY_TREE($NEW_DIR, $PREVIOUS);
            }
        }
    }
    $DIR->CLOSE();
    Return; //finish this branch
} //end funcion

Function IS_FILE_TO_DISPLAY($NAME) {
/*
This function check the file with the current file filter criteria to decide if
the file is displayable or not.
*/
    If ($_SESSION['File_Extension'] == "") Return true;
    $EXT = "*" . STRTOUPPER(STRRCHR ($NAME, ".")) . ",";
    Return STRPOS(" " . $_SESSION['File_Extension'], $EXT);
} //end function

Function DIR_SIZES() {
/*
When the structure of the tree directory has been built this function calculate
the amount of files and bytes in every folder of the structure.
*/
    $_SESSION['Maxfilesize']=0;
    $_SESSION['Maxfoldersize']=0;
    For ($I = 1;$I <= $_SESSION['Numfile'];$I++) {
        If ($_SESSION['Folder_Type'] [$I] == "File") {
            If ($_SESSION['Father'] [$I] != 0) {
                $BACK = $I;
                While ($_SESSION['Father'] [$BACK] != 0) {
                    $_SESSION['Numbytes'][$_SESSION['Father'] [$BACK]] = $_SESSION['Numbytes'][$_SESSION['Father'] [$BACK]] + $_SESSION['Numbytes'][$I];
                    if ($_SESSION['Numbytes'][$_SESSION['Father'] [$BACK]] > $_SESSION['Maxfoldersize']) {
                        $_SESSION['Maxfoldersize'] = $_SESSION['Numbytes'][$_SESSION['Father'] [$BACK]];
                    }
                    $_SESSION['Children_Files'] [$_SESSION['Father'] [$BACK]] = $_SESSION['Children_Files'] [$_SESSION['Father'] [$BACK]] + 1;
                    $BACK = $_SESSION['Father'] [$BACK];
                }
            }
            $_SESSION['Children_Files'] [0]++;
            $_SESSION['Numbytes'][0] = $_SESSION['Numbytes'][0] + $_SESSION['Numbytes'][$I];
            if ($_SESSION['Numbytes'][$I] > $_SESSION['Maxfilesize']) {
                $_SESSION['Maxfilesize'] = $_SESSION['Numbytes'][$I];
            }
        } Else { // is a directory

            If ($_SESSION['Father'] [$I] != 0) {
                $BACK = $I;
                While ($_SESSION['Father'] [$BACK] != 0) {
                    $_SESSION['Children_Subdirs'][$_SESSION['Father'] [$BACK]] = $_SESSION['Children_Subdirs'][$_SESSION['Father'] [$BACK]] + 1;
                    $BACK = $_SESSION['Father'] [$BACK];
                }
            }
            $_SESSION['Children_Subdirs'][0]++;
        }
        If (Empty($_SESSION['Last_Level_Node'][$_SESSION['Level_Tree'][$I]])) {
            $_SESSION['Last_Level_Node'][$_SESSION['Level_Tree'][$I]] = $I;
        } Else {
            If ($_SESSION['Last_Level_Node'][$_SESSION['Level_Tree'][$I]] < $I) {
                $_SESSION['Last_Level_Node'][$_SESSION['Level_Tree'][$I]] = $I;
            }
        }
    }
} //end function

Function UPLOAD ($NODE) {
global $encabezado;
/*
This is the first phase of the upload file process in this phase the file to
upload is chosen in the client computer with a form and sent to be processed in
the second phase.
*/
    Global $ACTION;
    $ACTION = "upload2";
    $UPLOAD_DIR = BUILD_PATH($NODE);
    PAGE_HEADER("DIRECTORY MANAGER - DIRTREEVIEW", "UPLOAD FILE", "", "");
    ?>
    <Table WIDTH='100%' BORDER='0' CELLPADDING='0' CELLSPACING='0'class=td>
        <Tr>
            <Td VALIGN='top' ALIGN='left'>
                <Center>
                <Font FACE='tahoma'>
    <?php
    // check if the directory exists or not with the server path added
    $REAL_UPLOAD_DIR = str_replace(DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR, DIRNAME($_SESSION['Server_Path'])) . DIRECTORY_SEPARATOR . $UPLOAD_DIR;
    If (!IS_DIR($REAL_UPLOAD_DIR)) {
        Echo "<h3>The directory where to upload doesn't exist, please verify.. </h3></font></center></TD></TR>";
        Echo "<TR><TD><a href=" . $_SERVER['PHP_SELF'] . "?ACTION=expand&NODE=" . $NODE . "&FILE_EXTENSION=" . $_SESSION['File_Extension'] . "$encabezado>   Cancel   </a></TD></TR>";
        Echo "</TABLE>";
    } Else {
        // check if the directory is writable.
        If (!IS_WRITEABLE($REAL_UPLOAD_DIR)) {
            Echo "<h3>The directory where to upload is NOT writable, please put the write attribute permissions on </h3></font></center></TD></TR>";
            Echo "<TR><TD><a href=" . $_SERVER['PHP_SELF'] . "?ACTION=expand&NODE=" . $NODE . "&FILE_EXTENSION=" . $_SESSION['File_Extension'] . "$encabezado>   Cancel   </a></TD></TR>";
            Echo "</TABLE>";
        } Else {
            Echo"<h3>Directorio actual:" . $UPLOAD_DIR . "</h3></font></center></td></tr>";
    ?>
        <Tr>
            <Td><Center>
                UPLOAD File Extensions allowed:
    <?php

            If ($_SESSION['Upload_Extension'] == "") {
                Echo "*.*";
            } Else {
                Echo $_SESSION['Upload_Extension'];
            }
    ?>

            </Td>
        </Tr>
            <tr><td><center><H3>Maximo tamaño de fichero=<?= $_SESSION['Size_Bytes'];?></H3></center></td></tr>
        <Tr>
            <Td>
            <Center>
            <Font FACE='tahoma'>
            <H3> Choose a the file to upload</H3>
            <Form NAME='FormUploadFile' METHOD='post' ENCTYPE='multipart/form-data' ACTION='<?= $_SERVER['PHP_SELF'];?>'>
                <Table ALIGN='center' BORDER='0' class=td>
                    <Input TYPE='hidden' NAME='MAX_FILE_SIZE' VALUE='<?= $_SESSION['Size_Bytes'];?>'>
                    <Tr>
                        <Td></Td><Td VALIGN='baseline'><Input TYPE='file' NAME='filetoupload' SIZE='50'></Td>
                    </Tr>
                    <Input TYPE='hidden' NAME='FILE_EXTENSION' VALUE='<?= $_SESSION['File_Extension'];?>'>
                    <Input TYPE='hidden' NAME='NODE' VALUE='<?= $NODE;?>'>
                    <Input TYPE='hidden' NAME='ACTION' VALUE='upload2'>
                    <Tr></Tr>
                    <Tr>
                        <Td><Input TYPE='button' VALUE='   Cancel   ' ONCLICK='javascript:history.back()'></Td>
                        <Td></Td>
                        <Td><Input TYPE='Submit' NAME='submit' VALUE='   Upload File  '></Td>
                    </Tr>
                    <Tr>
                        <Td><Noscript>Use your BACK ARROW button of your BROWSER NAVIGATOR to GO BACK</Noscript></Td>
                    </Tr>
                </Table>
            </Form>
            </font>
            </center>
            </Td>
        </Tr>
   </Table>
   <?php
        }
    }
    PAGE_FOOTER("", "");
    Exit;
} //end function

Function UPLOAD2($NODE) {
/*
This is the second phase of the upload file process in this phase all the
process is checked against errors.
If the things go well the process is terminated with the move of the uploaded
file to the directory chosen.
If the things go bad the process is aborted and the uploaded file is erased.
*/
    Global $ACTION;
    $UPLOAD_DIR = BUILD_PATH($NODE);
    PAGE_HEADER("DIRECTORY MANAGER - DIRTREEVIEW", "UPLOAD FILE - CKECK PHASE", "", "");
    ?>
   <Table WIDTH=100% BORDER=0 CELLPADDING=8 CELLSPACING=0 class=td>
        <Tr>
            <Td VALIGN=top ALIGN=left>
                <Center>
                <Font FACE=tahoma>
   <?php
    $ERROR_FUNCTION = false;
    // File Size in bytes (change this value to fit your need)
    Echo "<H3>Biggest File Size=" . $_SESSION['Size_Bytes'] . "</H3></font></td></tr>";
    Echo "<H3>Upload Dir=" . $UPLOAD_DIR . "</H3></font></td></tr>";
    If ($_SESSION['File_Extension'] != "") {
        Echo "<tr><td><CENTER><H5>Extensions allowed= " . $_SESSION['File_Extension'] . "</H5></td></tr>";
    }
    // check if the directory exists or not with the server path added
    $REAL_UPLOAD_DIR = str_replace(DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR, DIRNAME($_SESSION['Server_Path'])) . DIRECTORY_SEPARATOR . $UPLOAD_DIR;
    If (!IS_DIR($REAL_UPLOAD_DIR)) {
        Echo "<tr><td><CENTER><H3>The directory where to upload doesn't exist, please verify.. </H3></td></tr>";
        $ERROR_FUNCTION = true;
    } Else {
        // check if the directory is writable.
        If (!IS_WRITEABLE($REAL_UPLOAD_DIR)) {
            Echo "<tr><td><CENTER><H3>The directory where to upload is NOT writable, please put the write attribute permissions on </H3></td></tr>";
            $ERROR_FUNCTION = true;
        } Else {
            // check if no file selected.
            If (!IS_UPLOADED_FILE($_FILES['filetoupload']['tmp_name'])) {
                Echo "<tr><td><CENTER><H3>Error: Please select a file to upload!. </H3></td></tr>";
                $ERROR_FUNCTION = true;
            } Else {
                // Get the Size of the File
                $SIZE = $_FILES['filetoupload']['size'];
                // Make sure that file size is correct
                If ($SIZE > $_SESSION['Size_Bytes']) {
                    $KB = $_SESSION['Size_Bytes'] / 1024;
                    Echo "<tr><td><CENTER><H3>File Too Large. File must BE LESS THAN <b>$KB</b> KB. </H3></td></tr>";
                    $ERROR_FUNCTION = true;
                } Else {
                    // check file extension
                    If (($_SESSION['File_Extension'] != "") && (!IS_FILE_TO_DISPLAY($_FILES['filetoupload']['name']) != false)) {
                        Echo "<tr><td><CENTER><H3>***Wrong file extension. </H3></td></tr>";
                        $ERROR_FUNCTION = true;
                    } Else {
                        // $Filename will hold the value of the file name submitted from the form.
                        $FILENAME = $_FILES['filetoupload']['name'];
                        // Check if file is Already EXISTS.
                        If (File_Exists($REAL_UPLOAD_DIR . DIRECTORY_SEPARATOR . $FILENAME)) {
                            Echo "<tr><td><CENTER><H3>Sorry but the file named <b>" . $FILENAME . "</b> already exists in the server, please change the filename before UPLOAD</H3></td></tr>";
                            $ERROR_FUNCTION = true;
                        } Else {
                            // Move the File to the Directory choosen + the server path determined
                            // move_uploaded_file('filename','destination') Moves afile to a new location.
                            If (!MOVE_UPLOADED_FILE($_FILES['filetoupload']['tmp_name'], $REAL_UPLOAD_DIR . DIRECTORY_SEPARATOR . $FILENAME)) {
                                // Print error msg.
                                Echo "<tr><td><CENTER><H3>There was a problem moving your file. </H3></td></tr>";
                                $ERROR_FUNCTION = true;
                            } Else {
                                // tell the user that the file has been uploaded.
                                Echo "<tr><td><CENTER><H3>File SUCCESFULLY uploaded! </H3></td></tr>";
                            }
                        }
                    }
                }
            }
        }
    }
    ?>
       <Tr>
            <Td>
            <Center>
            <Font FACE=tahoma>
           <Form NAME="FormUploadFile2" METHOD="post" ENCTYPE="multipart/form-data" ACTION="<?= $_SERVER['PHP_SELF'];?>">
                <Table ALIGN=center BORDER=0 class=td>
                    <Tr>
                        <Input TYPE="hidden" NAME="FILE_EXTENSION" VALUE="<?= $_SESSION['File_Extension'];?>">
                        <Input TYPE="hidden" NAME="NODE" VALUE="<?= $NODE;?>">
                        <Input TYPE="hidden" NAME="ACTION" VALUE="upload3">
	<?php
    If ($ERROR_FUNCTION) {
        ?> <Td><Input TYPE="Submit" NAME="submit" VALUE="   Cancel  "></Td><?php
    } Else {
        ?> <Td><Input TYPE="Submit" NAME="submit" VALUE="   Accept  "></Td><?php
    }
    ?>
                    </Tr>
                </Table>
            </Form>
            </Td>
        </Tr>
    </Table>
   <?php
    PAGE_FOOTER("", "");
    Exit();
} //END FUNCTION

Function DOWNLOAD($NODE) {
/*
This function is the first phase of the Download File process, the client must
confirm the operation.
*/
    PAGE_HEADER("FILE MANAGER - DIRTREEVIEW", "DOWNLOAD FILE", "ORANGE", "BLACK");
    ?>
   <Table WIDTH=100% BORDER=0 CELLPADDING=8 CELLSPACING=0 class=td>
        <Tr>
            <Td VALIGN=top ALIGN=left>
                <Center>
                <Font FACE=tahoma>
                <H3>Current Filename :
    <?php
    $CURRENT_FILE = BUILD_PATH($NODE);
    Echo $CURRENT_FILE;
    ?>
            </H3></Td>
        </Tr>
        <Tr>
            <Td>
                <Center>
                <Font FACE=tahoma>
                <H3> File to DOWNLOAD: <?= $CURRENT_FILE;?></H3>
                <Form NAME='downloadfile' METHOD='post' ENCTYPE='multipart/form-data' ACTION='<?= $_SERVER['PHP_SELF'];?>'>
                    <Table ALIGN=center BORDER=0 class=td>
                        <Input TYPE='hidden' NAME='FILE_EXTENSION' VALUE='<?= $_SESSION['File_Extension'];?>'>
                        <Input TYPE='hidden' NAME='NODE' VALUE='<?= $NODE;?>'>
                        <Input TYPE='hidden' NAME='ACTION' VALUE='downloadfile1'>
                        <Tr>
                            <Td><Input TYPE="button" VALUE="    BACK   " ONCLICK="javascript:history.back()"></Td>
                            <Td></Td><Td></Td><Td></Td><Td></Td><Td></Td>
                            <Td><Input TYPE="Submit" NAME="downloadfileform" VALUE="   DOWNLOAD  "></Td>
                        </Tr>
                        <Tr>
                            <Td>When this process has been finished, click the BACK Button</Noscript></Td>
                        </Tr>
                        <Tr>
                            <Td><Noscript>Use your BACK ARROW button of your BROWSER NAVIGATOR to GO BACK</Noscript></Td>
                        </Tr>
                    </Table>
                </Form>
            </Td>
        </Tr>
   </Table>
   <?php
    PAGE_FOOTER("ORANGE", "BLACK");
    Exit;
} //end function

Function DOWNLOAD1($NODE) {
/*
This is the second phase, the function to download a file in a NODE of the tree
structure from the server to the client computer , can be opened or saved.
*/
    $FILE_NAME = $_SESSION['Folder_Name'] [$NODE];
    $CURRENT_FILE = BUILD_PATH($NODE);
    $REAL_FILE = str_replace(DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR, DIRNAME($_SESSION['Server_Path'])) . DIRECTORY_SEPARATOR . $CURRENT_FILE;
    If ((!File_Exists($REAL_FILE)) || (!IS_FILE($REAL_FILE))) {
        $ERROR_TEXT = "<td><CENTER><h3>Error: FileName not exist</h3></td>";
        $ERROR_FUNCTION = true;
    } else {
        // these lines must be the first to be executed before any other output or echo
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=$FILE_NAME");
        header("Content-Length: " . filesize($REAL_FILE));
        header("Accept-Ranges: bytes");
        header("Pragma: no-cache");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Content-transfer-encoding: binary");
        if ($fh = fopen("$REAL_FILE", "rb")) {
            if (fpassthru($fh)) {
                fclose($fh);
                $ERROR_FUNCTION = false;
            } else {
                fclose($fh);
                $ERROR_TEXT = "<td><CENTER><h3>Error: FileName can`t be downloaded</h3></td>";
                $ERROR_FUNCTION = true;
            }
        } else {
            $ERROR_TEXT = "<td><CENTER><h3>Error: FileName can`t be downloaded</h3></td>";
            $ERROR_FUNCTION = true;
        }
    }
    if ($ERROR_FUNCTION == true) {
        PAGE_HEADER("FILE MANAGER - DIRTREEVIEW", "DOWNLOAD FILE", "ORANGE", "BLACK");
        ?>
        <Table WIDTH=100% BORDER=0 CELLPADDING=8 CELLSPACING=0 class=td>
            <Tr>
                <Td VALIGN=top ALIGN=left>
                    <Center>
                    <Font FACE=tahoma>
                    <H3>FileName:
        <?php
        Echo $CURRENT_FILE . "</h3>";
        ?>
                </Td>
            </Tr>
            <Tr>
                <Td>
                <Form NAME="downloadfile1" METHOD="post" ENCTYPE="multipart/form-data" ACTION="<?= $_SERVER['PHP_SELF'];?>">
                    <Table ALIGN=center BORDER=0 class=td>
                        <Tr>
                            <Input TYPE="hidden" NAME="FILE_EXTENSION" VALUE="<?= $_SESSION['File_Extension'];?>">
                            <Input TYPE="hidden" NAME="NODE" VALUE="<?= $NODE;?>">
                            <Input TYPE="hidden" NAME="ACTION" VALUE="">
        <?php If ($ERROR_FUNCTION) {
            ECHO $ERROR_TEXT;
        ?>
                        </Tr>
                        <TR>
                            <Td><Center><Input TYPE="Submit" NAME="downloadfileform3b" VALUE="   Accept   "></Td>
        <?php }
        ?>
                        </Tr>
                    </Table>
                </Form>
                </Td>
            </Tr>
        </Table>
        <?php
        PAGE_FOOTER("ORANGE", "BLACK");
    }
    Exit;
} //end function

Function EXPAND($NODE) {
/*
This is the function to open a closed folder, it calculates the complete branch
from the NODE to the root in a backward loop way reading backward the tree to
open nodes.
*/
    $_SESSION['Opened_Folder'][$NODE] = 1;
    While ($_SESSION['Father'] [$NODE] != 0) {
        $NODE = $_SESSION['Father'][$NODE];
        $_SESSION['Opened_Folder'][$NODE] = 1;
    }
} //end funcion

Function COLLAPSE($NODE) {
/*
This is the function to close a opened folder.
*/
    $_SESSION['Opened_Folder'][$NODE] = 0;
} //end funcion

Function DISPLAY_NODE($NODE) {
/*
This function is called every time from the display_Tree function to show a row
of the tree structure, checking the status of the NODE (opened or closed).
*/
// begin row
    // number of subdirs
    COLUMN_FOLDER($NODE, "", "");
    // number of files
    COLUMN_FILES($NODE, "", "");
    // filename
    COLUMN_FILENAMES($NODE, "", "");
    // filesize
    COLUMN_SIZE($NODE, "", "");
    // filedate
    COLUMN_DATE($NODE, "", "");
// end row
} //end funcion

Function DISPLAY_TREE () {
/*
This function read the tree structure and display every node if it is opened.
*/
    For ($I = 1;$I <= $_SESSION['Numfile'];$I++) {
        // check if the NODE can be seen
        If ($_SESSION['Father'] [$I] != 0) {
            $J = $I;
            $PARENTS_OPENED = 0;
            While (($_SESSION['Father'] [$J] != 0) && ($PARENTS_OPENED == 0)) {
                $J = $_SESSION['Father'] [$J];
                If ($PARENTS_OPENED == 0) {
                    If ($_SESSION['Opened_Folder'][$J] == 0) {
                        $PARENTS_OPENED = 1;
                    }
                }
            }
            If ($PARENTS_OPENED == 0) {
                DISPLAY_NODE($I);
            }
        } Else {
            DISPLAY_NODE($I);
        }
    }
} //end funcion

Function FILTERFILE() {
/*
This funtion set the file filter criteria with a form, you can limit the
extensions of the files to be displayed/downloaded/uploaded with a file filter
criteria obtained with a form in the FilterFile function.
You can use as an sample: image group       : "*.gif,*.jpg,*.jpeg,*.png,*.tiff,"
                          text group        : "*.txt,*.nfo,*.doc,*.rtf,"
                          compressed  group : "*.zip,*.rar,*.gz,"
You can indicate the criteria in a grouped or individual way, every extension
must start with an asterisc ( * ) and dot ( . ) and finish with a comma ( , ).
Commodin characters (*) (?) are not evaluated.
Set nothing is like no filter as "*.*".
*/
    PAGE_HEADER("FILE FILTER - DIRTREEVIEW", "SET FILE FILTER CRITERIA - File Extension ( not case sensitive )", "BLACK", "WHITE");
    ?>
   <Table WIDTH=100% BORDER=0 CELLPADDING=8 CELLSPACING=0 class=td>
        <Tr>
            <Td VALIGN=top ALIGN=left>
                <Center>
                <Font FACE=tahoma>
                <H2> ! IMPORTANT ¡</H2>
                <H3> Every Extension must be separated by an asterisc(*) and dot(.) at the begining and a comma(,) at the end. </H3>
                <H3> The special characters (*) and (?) are not evaluated.</H3>
                <H3> Set Sample for image filter: *.gif,*.jpg,*.jpeg,*.tiff,</H3>
                </Font>
                <Form NAME="FORMFILEFILTER" METHOD="post" ENCTYPE="multipart/form-data" ACTION="<?= $_SERVER['PHP_SELF'];?>">
                    <Table ALIGN=center BORDER=0 class=td>
                        <Tr>
                            <Td VALIGN=baseline><H2>Extensions :</H2></Td>
                            <Td VALIGN=top><H2><Input TYPE='text' NAME='FILE_EXTENSION' SIZE=50 VALUE='<?= $_SESSION['File_Extension'];?>'></H2></Td>
                        </Tr>
                        <Input TYPE="hidden" NAME="NODE" VALUE="<?= $_SESSION['Node'];?>">
                        <Input TYPE="hidden" NAME="ACTION" VALUE="filter2">
                        <Tr></Tr>
                        <Tr></Tr>
                        <Tr>
                            <Td><Input TYPE="button" VALUE="    Cancel   " ONCLICK="javascript:history.back()"></Td>
                            <Td></Td>
                            <Td><Input TYPE="Submit" NAME="Filefilterform" VALUE="    Accept   "></Td>
                        </Tr>
                        <Tr>
                            <Td> <Noscript>Use your BACK ARROW button of your BROWSER NAVIGATOR to GO BACK</Noscript></Td>
                        </Tr>
                    </Table>
                </Form>
            </Td>
        </Tr>
   </Table>
   <?php
    PAGE_FOOTER("BLACK", "WHITE");
    Exit;
} //end function

Function BUILD_PATH($NODE) {
/*
This function rebuild the path of the node using a loop thru the full branch of
the tree.
*/
    If ($NODE != 0) {
        $I = $NODE;
        $DIR_PATH = $_SESSION['Folder_Name'] [$I];
        While ($_SESSION['Father'] [$I] != 0) {
            $DIR_PATH = $_SESSION['Folder_Name'] [$_SESSION['Father'] [$I]] . DIRECTORY_SEPARATOR . $DIR_PATH;
            $I = $_SESSION['Father'] [$I];
        }
        $DIR_PATH = $_SESSION['Folder_Name'] [0] . DIRECTORY_SEPARATOR . $DIR_PATH;
    } Else {
        $DIR_PATH = $_SESSION['Folder_Name'] [0];
    }
    Return $DIR_PATH;
} // end function

Function FILE_FUNCTIONS($NODE) {
/*
This function show the File functions options, the client must choose between a
different button options.
*/
    PAGE_HEADER("DIRECTORY MANAGER - DIRTREEVIEW", "FILE FUNCTIONS", "BLACK", "ORANGE");
    ?>
    <Table WIDTH=100% BORDER=0 CELLPADDING=8 CELLSPACING=0 BGCOLOR=ORANGE class=td>
        <Tr>
            <Td VALIGN=top ALIGN=left>
                <Center>
                <Font FACE=tahoma>
                <H2>  Choose the desired option</H2>
                <H3>Current File :
    <?php
    $CURRENT_FILE = BUILD_PATH($NODE);
    Echo $CURRENT_FILE . "</h3>";
    ?>
                <Form NAME="FILEFUNCTIONS" METHOD="post" ENCTYPE="multipart/form-data" ACTION="<?= $_SERVER['PHP_SELF'];?>">
                    <Table ALIGN=center BORDER=0 class=td>
                        <Tr>
                            <Td></Td><Td ALIGN=left VALIGN=top><P><Input TYPE="radio" VALUE="downloadfile" CHECKED NAME="ACTION"> Download</P></Td>
                        </Tr>
                        <Tr>
                            <Td></Td><Td ALIGN=left VALIGN=top><P><Input TYPE="radio" VALUE="emailfile" NAME="ACTION"> E-mail</P></Td>
                        </Tr>
    <?php
    if (STRTOUPPER(STRRCHR($CURRENT_FILE, ".")) == ".ZIP") {
        ?>
                        <Tr>
                            <Td></Td><Td ALIGN=left VALIGN=top><P><Input TYPE="radio" VALUE="listzipfile" NAME="ACTION"> List CONTENTS</P></Td>
                        </Tr>
    <?php
    }
    If ($_SESSION['privileges'] == 'all') {
        ?>
                        <Tr>
                            <Td></Td><Td ALIGN=left VALIGN=top><P><Input TYPE="radio" VALUE="renamefile" NAME="ACTION"> Rename</P></Td>
                        </Tr>
                        <Tr>
                            <Td></Td><Td ALIGN=left VALIGN=top><P><Input TYPE="radio" VALUE="erasefile" NAME="ACTION"> Erase</P></Td>
                        </Tr>
                        <!--Tr>
                            <Td></Td><Td ALIGN=left VALIGN=top><P><Input TYPE="radio" VALUE="compressfile" NAME="ACTION"> Compress (ZIP)</P></Td>
                        </Tr-->
    <?php
    }
    ?>
                        <Input TYPE="hidden" NAME="FILE_EXTENSION" VALUE="<?= $_SESSION['File_Extension'];?>">
                        <Input TYPE="hidden" NAME="NODE" VALUE="<?= $NODE;?>">
                        <Tr>
                            <Td><Input TYPE="button" VALUE="    Cancel   " ONCLICK="javascript:history.back()"></Td>
                            <Td></Td>
                            <Td><Input TYPE="Submit" NAME="FileFunctionsForm" VALUE="   Accept  "> </Td>
                        </Tr>
                        <Tr>
                            <Td> <Noscript>Use your BACK ARROW button of your BROWSER NAVIGATOR to GO BACK</Noscript></Td>
                        </Tr>
                    </Table>
                </Form>
            </Td>
        </Tr>
    </Table>
    <?php
    PAGE_FOOTER("BLACK", "ORANGE");
    Exit;
} //end function

Function DIR_FUNCTIONS($NODE) {
/*
This function show the Directory functions options, the client must choose
between a different button options.
*/
    PAGE_HEADER("DIRECTORY MANAGER - DIRTREEVIEW", "DIRECTORY FUNCTIONS", "BLACK", "blue");
    ?>
   <Table WIDTH=100% BORDER=0 CELLPADDING=8 CELLSPACING=0 BGCOLOR=darkred class=td>
        <Tr>
            <Td VALIGN=top ALIGN=left>
                <Center>
                <Font FACE=tahoma color=white>
                <H2>  Choose the desired option</H2>
                <H3>Current Folder :
    <?php
    $CURRENT_DIR = BUILD_PATH($NODE);
    Echo $CURRENT_DIR . "</h3>";
    ?>
                <Form NAME="MAKEDIR" METHOD="post" ENCTYPE="multipart/form-data" ACTION="<?= $_SERVER['PHP_SELF'];?>">
                    <Table ALIGN=center BORDER=0 class=menusec3>
                        <Tr>
                            <Td></Td><Td ALIGN=left VALIGN=top><P><Input TYPE="radio" VALUE="upload" CHECKED NAME="ACTION"> Upload a File</P></Td>
                        </Tr>
                        <Tr>
                            <Td></Td><Td ALIGN=left VALIGN=top><P><Input TYPE="radio" VALUE="makedir" NAME="ACTION"> Make a New Folder</P></Td>
                        </Tr>
                        <Tr>
                            <Td></Td><Td ALIGN=left VALIGN=top><P><Input TYPE="radio" VALUE="makeroot" NAME="ACTION"> Turn into the root of the Treeview</P></Td>
                        </Tr>
    <?php
    If ($_SESSION['privileges'] == 'all') {
        If ($_SESSION['File_Extension'] == "") {
            ?>
                                <Tr>
                                <Td></Td><Td ALIGN=left VALIGN=top><P><Input TYPE="radio" VALUE="removedir" NAME="ACTION"> Remove Folder & Subfolders</P></Td>
                                </Tr>
    <?php
        }
        ?>
                            <Tr>
                                <Td></Td><Td ALIGN=left VALIGN=top><P><Input TYPE="radio" VALUE="renamedir" NAME="ACTION"> Rename Folder</P></Td>
                            </Tr>
    <?php
    }
    ?>
                        <Input TYPE="hidden" NAME="FILE_EXTENSION" VALUE="<?= $_SESSION['File_Extension'];?>">
                        <Input TYPE="hidden" NAME="NODE" VALUE="<?= $NODE;?>">
                        <Tr>
                            <Td><Input TYPE="button" VALUE="   Cancel   " ONCLICK="javascript:history.back()"></Td>
                            <Td></Td>
                            <Td><Input TYPE="Submit" NAME="Makedirform" VALUE="   Accept  "> </Td>
                        </Tr>
                        <Tr>
                            <Td> <Noscript>Use your BACK ARROW button of your BROWSER NAVIGATOR to GO BACK</Noscript></Td>
                        </Tr>
                    </Table>
                </Form>
            </Td>
        </Tr>
   </Table>
   <?php
    PAGE_FOOTER("BLACK", "RED");
    Exit;
} //end function

Function CHANGE_ROOTDIR($NODE) {
/*
This function is to Change Root Dir process the client must confirm the
operation.
*/
    PAGE_HEADER("DIRECTORY MANAGER - DIRTREEVIEW", "TURN THE DIRECTORY IN THE ROOT TREEVIEW", "GREEN", "WHITE");
    ?>
   <Table WIDTH=100% BORDER=0 CELLPADDING=8 CELLSPACING=0 class=td>
        <Tr>
            <Td VALIGN=top ALIGN=left>
                <Center>
                <Font FACE=tahoma>
                <H3>Current Directory :
    <?php
    $CURRENT_DIR = BUILD_PATH($NODE);
    Echo $CURRENT_DIR;
    ?>
            </H3></Td>
        </Tr>
        <Tr>
            <Td>
                <Center>
                <Font FACE=tahoma>
                <H3> Directory to TURN in the ROOT of the Treeview: <?= $CURRENT_DIR;?></H3>
                <H3> Are you SURE ?</H3>
                <Form NAME="makerootdir" METHOD="post" ENCTYPE="multipart/form-data" ACTION="<?= $_SERVER['PHP_SELF'];?>">
                    <Table ALIGN=center BORDER=0 class=td>
                        <Input TYPE='hidden' NAME='FILE_EXTENSION' VALUE='<?= $_SESSION['File_Extension'];?>'>
                        <Input TYPE='hidden' NAME='NODE' VALUE='<?= $NODE;?>'>
                        <Input TYPE='hidden' NAME='ACTION' VALUE='makeroot1'>
                        <Tr>
                            <Td><Input TYPE="button" VALUE="   NO   " ONCLICK="javascript:history.back()"></Td>
                            <Td></Td><Td></Td><Td></Td><Td></Td><Td></Td>
                            <Td><Input TYPE="Submit" NAME="makerootdirform" VALUE="   YES  "></Td>
                        </Tr>
                        <Tr>
                            <Td><Noscript>Use your BACK ARROW button of your BROWSER NAVIGATOR to GO BACK</Noscript></Td>
                        </Tr>
                    </Table>
                </Form>
            </Td>
        </Tr>
   </Table>
   <?php
    PAGE_FOOTER("GREEN", "WHITE");
    Exit;
} //end function

Function MAKEDIR($NODE) {
/*
This function is the first phase of the Make Directory process the client write
the name of the new directory with a form.
*/
    PAGE_HEADER("DIRECTORY MANAGER - DIRTREEVIEW", "MAKE DIRECTORY", "RED", "WHITE");
    ?>
   <Table WIDTH=100% BORDER=0 CELLPADDING=8 CELLSPACING=0 class=td>
        <Tr>
            <Td VALIGN=top ALIGN=left>
                <Center>
                <Font FACE=tahoma>
                <H3>Current Folder Directory :
    <?php
    $CURRENT_DIR = BUILD_PATH($NODE);
    Echo $CURRENT_DIR;
    ?>
            </H3></Td>
        </Tr>
        <Tr>
            <Td>
                <Center>
                <Font FACE=tahoma>
                <H3> Choose a name for the new Sub-Directory Folder</H3>
                <Form NAME="makedir" METHOD="post" ENCTYPE="multipart/form-data" ACTION="<?= $_SERVER['PHP_SELF'];?>">
                    <Table ALIGN=center BORDER=0 class=td>
                        <Tr>
                            <Td VALIGN=baseline><H3>New Sub-Directory :<H3></Td>
                            <Td VALIGN=top><Input TYPE="text" NAME="MAKE_DIR" SIZE=50 VALUE=""></Td>
                        </Tr>
                        <Input TYPE='hidden' NAME='FILE_EXTENSION' VALUE='<?= $_SESSION['File_Extension'];?>'>
                        <Input TYPE='hidden' NAME='NODE' VALUE='<?= $NODE;?>'>
                        <Input TYPE='hidden' NAME='ACTION' VALUE='makedir1'>
                        <Tr>
                            <Td><Input TYPE="button" VALUE="    Cancel   " ONCLICK="javascript:history.back()"></Td>
                            <Td></Td><Td></Td><Td></Td><Td></Td><Td></Td><Td></Td><Td></Td>
                            <Td><Input TYPE="Submit" NAME="MakeDirform2" VALUE="   Accept  "></Td>
                        </Tr>
                        <Tr>
                            <Td><Noscript>Use your BACK ARROW button of your BROWSER NAVIGATOR to GO BACK</Noscript></Td>
                        </Tr>
                    </Table>
                </Form>
            </Td>
        </Tr>
   </Table>
   <?php
    PAGE_FOOTER("RED", "WHITE");
    Exit;
} //end function

Function MAKEDIR1($MAKE_DIR) {
/*
This function is the second phase of the Make Dir process this is the checking
phase. The client must confirm the operation.
*/
    $CURRENT_DIR = BUILD_PATH($_SESSION['Node']) . DIRECTORY_SEPARATOR . $MAKE_DIR;
    $REAL_DIR = str_replace(DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR, DIRNAME($_SESSION['Server_Path'])) . DIRECTORY_SEPARATOR . $CURRENT_DIR;
    PAGE_HEADER("DIRECTORY MANAGER - DIRTREEVIEW", "MAKE DIRECTORY", "RED", "WHITE");
    ?>
   <Table WIDTH=100% BORDER=0 CELLPADDING=8 CELLSPACING=0 class=td>
        <Tr>
            <Td VALIGN=top ALIGN=left>
                <Center>
                <Font FACE=tahoma>

                <H3>New Sub-Directory Folder:
    <?php
    Echo $CURRENT_DIR . "</h3>";
    ?>
            </Td>
        </Tr>
        <Tr>
            <Td>
            <Form NAME="makedir1" METHOD="post" ENCTYPE="multipart/form-data" ACTION="<?= $_SERVER['PHP_SELF'];?>">
               <Table ALIGN=center BORDER=0 class=td>
                    <Tr>
    <?php
    If ($MAKE_DIR != "") {
        CLEARSTATCACHE();
        If (!IS_DIR($REAL_DIR)) {
            If (MKDIR($REAL_DIR, 0750)) {
                Echo "<td><CENTER><h3>It has been created successfully</h3></td>";
                $ERROR_FUNCTION = false;
            } Else {
                Echo "<td><CENTER><h3>Error: It can`t be created</h3></td>";
                $ERROR_FUNCTION = true;
            }
        } Else {
            Echo "<td><CENTER><h3>Error: Directory exist</h3></td>";
            $ERROR_FUNCTION = true;
        }
    } Else {
        Echo "<td><CENTER><h3>Error: You have not introduced any name for the new directory</h3></td>";
        $ERROR_FUNCTION = true;
    }
    ?>
                    </Tr>
                    <Input TYPE="hidden" NAME="FILE_EXTENSION" VALUE="<?= $_SESSION['File_Extension'];?>">
                    <Input TYPE="hidden" NAME="NODE" VALUE="<?= $_SESSION['Node'];?>">
    <?php If ($ERROR_FUNCTION) {
        ?>
                    <Input TYPE="hidden" NAME="ACTION" VALUE="">
                    <Tr>
                        <Td><Center><Input TYPE="Submit" NAME="Makedirform3" VALUE="    Cancel   "></Td>
    <?php } Else {
        ?>
                    <Input TYPE="hidden" NAME="ACTION" VALUE="makedir2">
                    <Tr>
                        <Td><Center><Input TYPE="Submit" NAME="Makedirform3" VALUE="   Accept   "></Td>
    <?php }
    ?>
                    </Tr>
                </Table>
            </Form>
            </Td>
        </Tr>
   </Table>
   <?php
    PAGE_FOOTER("RED", "WHITE");
    Exit;
} //end function

Function REMOVEDIR($NODE) {
/*
This function is the first phase of the Remove Dir process the client must
confirm the operation.
*/
    PAGE_HEADER("DIRECTORY MANAGER - DIRTREEVIEW", "REMOVE DIRECTORY", "GREEN", "WHITE");
    ?>
   <Table WIDTH=100% BORDER=0 CELLPADDING=8 CELLSPACING=0 class=td>
        <Tr>
            <Td VALIGN=top ALIGN=left>
                <Center>
                <Font FACE=tahoma>
                <H3>Current Directory :
    <?php
    $CURRENT_DIR = BUILD_PATH($NODE);
    Echo $CURRENT_DIR;
    ?>
            </H3></Td>
        </Tr>
        <Tr>
            <Td>
                <Center>
                <Font FACE=tahoma>
                <H3> Directory to REMOVE: <?= $CURRENT_DIR;
    ?></H3>
                <H3> Are you SURE ?</H3>
                <Form NAME="removedir" METHOD="post" ENCTYPE="multipart/form-data" ACTION="<?= $_SERVER['PHP_SELF'];?>">
                    <Table ALIGN=center BORDER=0 class=td>
                        <Input TYPE='hidden' NAME='FILE_EXTENSION' VALUE='<?= $_SESSION['File_Extension'];?>'>
                        <Input TYPE='hidden' NAME='NODE' VALUE='<?= $NODE;?>'>
                        <Input TYPE='hidden' NAME='ACTION' VALUE='removedir1'>
                        <Tr>
                            <Td><Input TYPE="button" VALUE="   NO   " ONCLICK="javascript:history.back()"></Td>
                            <Td></Td><Td></Td><Td></Td><Td></Td><Td></Td>
                            <Td><Input TYPE="Submit" NAME="Removedirform" VALUE="   YES  "></Td>
                        </Tr>
                        <Tr>
                            <Td><Noscript>Use your BACK ARROW button of your BROWSER NAVIGATOR to GO BACK</Noscript></Td>
                        </Tr>
                    </Table>
                </Form>
            </Td>
        </Tr>
   </Table>
   <?php
    PAGE_FOOTER("GREEN", "WHITE");
    Exit;
} //end function

function DELETE_RECURSIVE_FOLDERS($dirname) {
/*
Recursive function to delete all subfolders and files under the node selected.
*/
    if (is_dir($dirname)) {
        $dir_handle = opendir($dirname);
        while ($file = readdir($dir_handle)) {
            if ($file != "." && $file != "..") {
                if (!is_dir($dirname . DIRECTORY_SEPARATOR . $file)) {
                    IF (!unlink ($dirname . DIRECTORY_SEPARATOR . $file)) {
                        RETURN false;
                    }
                } else {
                    IF (!DELETE_RECURSIVE_FOLDERS($dirname . DIRECTORY_SEPARATOR . $file)) {
                        RETURN false;
                    }
                }
            }
        }
        closedir($dir_handle);
        if (rmdir($dirname)) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
} //end function

Function REMOVEDIR1() {
/*
This is the last phase of the Remove Directory process, must be a confirmation
to refresh the tree when the process is finished.
*/
    PAGE_HEADER("REMOVE DIRECTORY - DIRTREEVIEW", "DIR FUNCTION EXECUTED", "GREEN", "WHITE");
    $TEMP_PATH = BUILD_PATH($_SESSION['Node']);
    $REAL_PATH = str_replace(DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR, DIRNAME($_SESSION['Server_Path'])) . DIRECTORY_SEPARATOR . $TEMP_PATH;
    IF (!DELETE_RECURSIVE_FOLDERS($REAL_PATH)) {
        Echo "ERROR: borrando directorio";
    }
    ?>
   <Table WIDTH=100% BORDER=0 CELLPADDING=8 CELLSPACING=0 class=td>
        <Tr>
            <Td VALIGN=top ALIGN=left>
                <Center>
                <Font FACE=tahoma>
                <H2> ! IMPORTANT ¡</H2>
                <H3> Dir function REMOVE DIRECTORY has been executed </H3>
                <H3> Click on the CONTINUE button to REFRESH the DIRECTORY TREEVIEW.</H3>
                </Font>
                <Form NAME="REMOVEDIR" METHOD="post" ENCTYPE="multipart/form-data" ACTION="<?= $_SERVER['PHP_SELF'];?>">
                    <Table ALIGN=center BORDER=0 class=td>
                         <Tr>
                        <Input TYPE='hidden' NAME='FILE_EXTENSION' VALUE='<?= $_SESSION['File_Extension'];?>'>
                        <Input TYPE='hidden' NAME='NODE' VALUE=0>
                        <Input TYPE='hidden' NAME='ACTION' VALUE=''>
                        </Tr>
                        <Tr>
                             <Td><Input TYPE="Submit" NAME="REMOVEDIR" VALUE="    CONTINUE   "></Td>
                        </Tr>
                    </Table>
                </Form>
            </Td>
        </Tr>
   </Table>
   <?php
    PAGE_FOOTER("GREEN", "WHITE");
    Exit;
} //end function

Function RENAMEDIR($NODE) {
/*
This function is the first phase of the Rename Dir process, the client write
the new name for the selected directory with a form.
*/
    PAGE_HEADER("DIRECTORY MANAGER - DIRTREEVIEW", "RENAME DIRECTORY", "PURPLE", "WHITE");
    ?>
   <Table WIDTH=100% BORDER=0 CELLPADDING=8 CELLSPACING=0 class=td>
        <Tr>
            <Td VALIGN=top ALIGN=left>
                <Center>
                <Font FACE=tahoma>
                <H3>Current Directory :
    <?php
    $CURRENT_DIR = BUILD_PATH($NODE);
    Echo $CURRENT_DIR;

    ?>
            </H3></Td>
        </Tr>
        <Tr>
            <Td>
                <Center>
                <Font FACE=tahoma>
                <H3> Choose a new name for this directory</H3>
                <Form NAME="renamedir" METHOD="post" ENCTYPE="multipart/form-data" ACTION="<?= $_SERVER['PHP_SELF'];?>">
                    <Table ALIGN=center BORDER=0 class=td>
                        <Tr>
                            <Td VALIGN=baseline><H3>New name for this Directory :<H3></Td>
                            <Td VALIGN=top><Input TYPE="text" NAME="RENAME_DIR" SIZE=50 VALUE='<?= $_SESSION['Folder_Name'] [$NODE];?>'</Td>
                        </Tr>
                        <Input TYPE='hidden' NAME='FILE_EXTENSION' VALUE='<?= $_SESSION['File_Extension'];?>'>
                        <Input TYPE='hidden' NAME='NODE' VALUE='<?= $NODE;?>'>
                        <Input TYPE='hidden' NAME='ACTION' VALUE='renamedir1'>
                        <Tr>
                            <Td><Input TYPE="button" VALUE="    Cancel   " ONCLICK="javascript:history.back()"></Td>
                            <Td></Td>
                            <Td><Input TYPE="Submit" NAME="RenameDirform2" VALUE="   Accept  "></Td>
                        </Tr>
                        <Tr>
                            <Td><Noscript>Use your BACK ARROW button of your BROWSER NAVIGATOR to GO BACK</Noscript></Td>
                        </Tr>
                    </Table>
                </Form>
            </Td>
        </Tr>
   </Table>
   <?php
    PAGE_FOOTER("PURPLE", "WHITE");
    Exit;
} //end function

Function RENAMEDIR1($RENAME_DIR) {
/*
This function is the second phase of the Rename Dir process, this is the
checking phase.
*/
    $CURRENT_DIR = BUILD_PATH($_SESSION['Node']);
    $REAL_DIR = str_replace(DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR, DIRNAME($_SESSION['Server_Path'])) . DIRECTORY_SEPARATOR . $CURRENT_DIR; // the real full filename of the directory
    PAGE_HEADER("DIRECTORY MANAGER - DIRTREEVIEW", "RENAME DIRECTORY", "PURPLE", "WHITE");

    ?>
   <Table WIDTH=100% BORDER=0 CELLPADDING=8 CELLSPACING=0 class=td>
        <Tr>
            <Td VALIGN=top ALIGN=left>
                <Center>
                <Font FACE=tahoma>
                <H3>Old Name Directory:
    <?php
    Echo $_SESSION['Folder_Name'] [$_SESSION['Node']] . "</h3>";

    ?>
                <H3>New Name Directory:
    <?php
    Echo $RENAME_DIR . "</h3>";

    ?>
            </Td>
        </Tr>
        <Tr>
            <Td>
            <Form NAME="renamedir1" METHOD="post" ENCTYPE="multipart/form-data" ACTION="<?= $_SERVER['PHP_SELF'];?>">
               <Table ALIGN=center BORDER=0 class=td>
                    <Tr>
    <?php
    If ($RENAME_DIR != "") {
        CLEARSTATCACHE();
        If (IS_DIR($REAL_DIR)) {
            If (!IS_DIR(str_replace(DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR, DIRNAME($REAL_DIR)) . DIRECTORY_SEPARATOR . $RENAME_DIR)) {
                If (RENAME($REAL_DIR, str_replace(DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR, DIRNAME($REAL_DIR)) . DIRECTORY_SEPARATOR . $RENAME_DIR)) {
                    Echo "<td><CENTER><h3>The Directory has been renamed successfully</h3></td>";
                    $_SESSION['Folder_Name'] [$_SESSION['Node']] = $RENAME_DIR;
                    $ERROR_FUNCTION = false;
                } Else {
                    Echo "<td><CENTER><h3>Error: The Old Name Directory can`t be renamed</h3></td>";
                    $ERROR_FUNCTION = true;
                }
            }
        } Else {
            Echo "<td><CENTER><h3>Error: Old Name Directory not exist</h3></td>";
            $ERROR_FUNCTION = true;
        }
    } Else {
        Echo "<td><CENTER><h3>Error: You have not introduced any new name for the this directory</h3></td>";
        $ERROR_FUNCTION = true;
    }
    ?>
                    </Tr>
                    <Input TYPE="hidden" NAME="FILE_EXTENSION" VALUE="<?= $_SESSION['File_Extension'];?>">
                    <Input TYPE="hidden" NAME="NODE" VALUE="<?= $_SESSION['Node'];?>">
    <?php If ($ERROR_FUNCTION) {
        ?>
                    <Input TYPE="hidden" NAME="ACTION" VALUE="">
                    <Tr>
                        <Td><Center><Input TYPE="Submit" NAME="Renamedirform3a" VALUE="    Cancel   "></Td>
    <?php } Else {
        ?>
                    <Input TYPE="hidden" NAME="ACTION" VALUE="renamedir2">
                    <Tr>
                        <Td><Center><Input TYPE="Submit" NAME="Renamedirform3b" VALUE="   Accept   "></Td>
    <?php }
    ?>
                    </Tr>
                </Table>
            </Form>
            </Td>
        </Tr>
   </Table>
   <?php
    PAGE_FOOTER("PURPLE", "WHITE");
    Exit;
} //end function

Function ERASEFILE($NODE) {
/*
This function is the first phase of the Erase File process, the client must
confirm the operation.
*/
    PAGE_HEADER("FILE MANAGER - DIRTREEVIEW", "ERASE FILE", "ORANGE", "BLACK");
    ?>
   <Table WIDTH=100% BORDER=0 CELLPADDING=8 CELLSPACING=0 class=td>
        <Tr>
            <Td VALIGN=top ALIGN=left>
                <Center>
                <Font FACE=tahoma>
                <H3>Current Filename :
    <?php
    $CURRENT_FILE = BUILD_PATH($NODE);
    Echo $CURRENT_FILE;

    ?>
            </H3></Td>
        </Tr>
        <Tr>
            <Td>
                <Center>
                <Font FACE=tahoma>
                <H3> File to ERASE: <?= $CURRENT_FILE;?></H3>
                <H3> Are you SURE ?</H3>
                <Form NAME="erasefile" METHOD="post" ENCTYPE="multipart/form-data" ACTION="<?= $_SERVER['PHP_SELF'];?>">
                    <Table ALIGN=center BORDER=0 class=td>
                        <Input TYPE='hidden' NAME='FILE_EXTENSION' VALUE='<?= $_SESSION['File_Extension'];?>'>
                        <Input TYPE='hidden' NAME='NODE' VALUE='<?= $NODE;?>'>
                        <Input TYPE='hidden' NAME='ACTION' VALUE='erasefile1'>
                        <Tr>
                            <Td><Input TYPE="button" VALUE="    NO   " ONCLICK="javascript:history.back()"></Td>
                            <Td></Td><Td></Td><Td></Td><Td></Td><Td></Td>
                            <Td><Input TYPE="Submit" NAME="erasefileform" VALUE="   YES  "></Td>
                        </Tr>
                        <Tr>
                            <Td><Noscript>Use your BACK ARROW button of your BROWSER NAVIGATOR to GO BACK</Noscript></Td>
                        </Tr>
                    </Table>
                </Form>
            </Td>
        </Tr>
   </Table>
   <?php
    PAGE_FOOTER("ORANGE", "BLACK");
    Exit;
} //end function

Function ERASEFILE1($NODE) {
/*
This function is the second phase of the Erase File process, this is the
checking phase.
*/
    $CURRENT_FILE = BUILD_PATH($NODE);
    $REAL_FILE = str_replace(DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR, DIRNAME($_SESSION['Server_Path'])) . DIRECTORY_SEPARATOR . $CURRENT_FILE; // the real full filename of the directory
    PAGE_HEADER("FILE MANAGER - DIRTREEVIEW", "ERASE FILE", "ORANGE", "BLACK");
    ?>
   <Table WIDTH=100% BORDER=0 CELLPADDING=8 CELLSPACING=0 class=td>
        <Tr>
            <Td VALIGN=top ALIGN=left>
                <Center>
                <Font FACE=tahoma>
                <H3>FileName:
    <?php
    Echo $CURRENT_FILE . "</h3>";
    ?>
            </Td>
        </Tr>
        <Tr>
            <Td>
            <Form NAME="erasefile1" METHOD="post" ENCTYPE="multipart/form-data" ACTION="<?= $_SERVER['PHP_SELF'];?>">
               <Table ALIGN=center BORDER=0 class=td>
                    <Tr>
    <?php
    $ERROR_FUNCTION = false;
    CLEARSTATCACHE();
    If (IS_FILE($REAL_FILE)) {
        If (UNLINK($REAL_FILE)) {
            Echo "<td><CENTER><h3>The File has been erased successfully</h3></td>";
            $ERROR_FUNCTION = false;
        } Else {
            Echo "<td><CENTER><h3>Error: FileName can`t be erased</h3></td>";
            $ERROR_FUNCTION = true;
        }
    } Else {
        Echo "<td><CENTER><h3>Error: FileName not exist</h3></td>";
        $ERROR_FUNCTION = true;
    }
    ?>
                    </Tr>
                    <Input TYPE="hidden" NAME="FILE_EXTENSION" VALUE="<?= $_SESSION['File_Extension'];?>">
                    <Input TYPE="hidden" NAME="NODE" VALUE="<?= $NODE;?>">
    <?php If ($ERROR_FUNCTION) {
        ?>
                    <Input TYPE="hidden" NAME="ACTION" VALUE="">
                    <Tr>
                        <Td><Center><Input TYPE="Submit" NAME="erasefileform3a" VALUE="    Cancel   "></Td>
    <?php } Else {
        ?>
                    <Input TYPE="hidden" NAME="ACTION" VALUE="">
                    <Tr>
                        <Td><Center><Input TYPE="Submit" NAME="erasefileform3b" VALUE="   Accept   "></Td>
    <?php }
    ?>
                    </Tr>
                </Table>
            </Form>
            </Td>
        </Tr>
   </Table>
   <?php
    PAGE_FOOTER("ORANGE", "BLACK");
    Exit;
} //end function

Function COMPRESSFILE($NODE) {
/*
This function is the first phase of the Compress (ZIP) File process, the client
must confirm the operation.
*/
    PAGE_HEADER("FILE MANAGER - DIRTREEVIEW", "COMPRESS (ZIP) FILE", "YELLOW", "BLACK");
    ?>
   <Table WIDTH=100% BORDER=0 CELLPADDING=8 CELLSPACING=0 class=td>
        <Tr>
            <Td VALIGN=top ALIGN=left>
                <Center>
                <Font FACE=tahoma>
                <H3>Current Filename :
    <?php
    $CURRENT_FILE = BUILD_PATH($NODE);
    Echo $CURRENT_FILE;
    ?>
            </H3></Td>
        </Tr>
        <Tr>
            <Td>
                <Center>
                <Font FACE=tahoma>
                <H3> File to COMPRESS ( ZIP ): <?= $CURRENT_FILE;?></H3>
                <H3> Are you SURE ?</H3>
                <Form NAME="compressfile" METHOD="post" ENCTYPE="multipart/form-data" ACTION="<?= $_SERVER['PHP_SELF'];?>">
                    <Table ALIGN=center BORDER=0 class=td>
                        <Input TYPE='hidden' NAME='FILE_EXTENSION' VALUE='<?= $_SESSION['File_Extension'];?>'>
                        <Input TYPE='hidden' NAME='NODE' VALUE='<?= $NODE;?>'>
                        <Input TYPE='hidden' NAME='ACTION' VALUE='compressfile1'>
                        <Tr>
                            <Td><Input TYPE="button" VALUE="    NO   " ONCLICK="javascript:history.back()"></Td>
                            <Td></Td><Td></Td><Td></Td><Td></Td><Td></Td>
                            <Td><Input TYPE="Submit" NAME="compressfileform" VALUE="   YES  "></Td>
                        </Tr>
                        <Tr>
                            <Td><Noscript>Use your BACK ARROW button of your BROWSER NAVIGATOR to GO BACK</Noscript></Td>
                        </Tr>
                    </Table>
                </Form>
            </Td>
        </Tr>
   </Table>
   <?php
    PAGE_FOOTER("YELLOW", "BLACK");
    Exit;
} //end function

Function COMPRESSFILE1($NODE) {
/*
This function is the second phase of the Compress (ZIP) File process, this is
the checking phase.
*/
    $CURRENT_FILE = BUILD_PATH($NODE);
    $REAL_FILE = str_replace(DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR, DIRNAME($_SESSION['Server_Path'])) . DIRECTORY_SEPARATOR . $CURRENT_FILE; // the real full filename of the directory
    PAGE_HEADER("FILE MANAGER - DIRTREEVIEW", "COMPRESS (ZIP) FILE", "YELLOW", "BLACK");
    ?>
   <Table WIDTH=100% BORDER=0 CELLPADDING=8 CELLSPACING=0 class=td>
        <Tr>
            <Td VALIGN=top ALIGN=left>
                <Center>
                <Font FACE=tahoma>
                <H3>FileName:
    <?php
    Echo $CURRENT_FILE . "</h3>";
    ?>
            </Td>
        </Tr>
        <Tr>
            <Td>
            <Form NAME="compressfile1" METHOD="post" ENCTYPE="multipart/form-data" ACTION="<?= $_SERVER['PHP_SELF'];?>">
               <Table ALIGN=center BORDER=0 class=td>
                    <Tr>
    <?php
    $ERROR_FUNCTION = false;
    CLEARSTATCACHE();
    If (IS_FILE($REAL_FILE)) {
        $ZIP_FILE = DIRNAME($REAL_FILE) . DIRECTORY_SEPARATOR . SUBSTR(BASENAME($REAL_FILE), 0, STRRPOS(BASENAME($REAL_FILE), ".")) . ".zip";
        if ($ZIP_FILE != $REAL_FILE) {
            IF (IS_FILE($ZIP_FILE)) {
                UNLINK($ZIP_FILE);
            }
            $FILE_TO_ZIP[1] = $REAL_FILE;
            //include_once("dirtreezip1.inc.php");
            $ziper = new zipfile();
            $ziper->addFiles($FILE_TO_ZIP);
            $ziper->output($ZIP_FILE);
            If (IS_FILE($ZIP_FILE)) {
                Echo "<td><CENTER><h3>The File has been compressed successfully</h3></td>";
                UNLINK($REAL_FILE);
                $ERROR_FUNCTION = false;
            } Else {
                Echo "<td><CENTER><h3>Error: FileName can`t be compressed</h3></td>";
                $ERROR_FUNCTION = true;
            }
        } Else {
            Echo "<td><CENTER><h3>Error: FileName not exist</h3></td>";
            $ERROR_FUNCTION = true;
        }
    }
    ?>
                    </Tr>
                    <Input TYPE="hidden" NAME="FILE_EXTENSION" VALUE="<?= $_SESSION['File_Extension'];?>">
                    <Input TYPE="hidden" NAME="NODE" VALUE="<?= $NODE;?>">
    <?php If ($ERROR_FUNCTION) {
        ?>
                    <Input TYPE="hidden" NAME="ACTION" VALUE="">
                    <Tr>
                        <Td><Center><Input TYPE="Submit" NAME="compressfileform3a" VALUE="    Cancel   "></Td>
    <?php } Else {
        ?>
                    <Input TYPE="hidden" NAME="ACTION" VALUE="">
                    <Tr>
                        <Td><Center><Input TYPE="Submit" NAME="compressfileform3b" VALUE="   Accept   "></Td>
    <?php }
    ?>
                    </Tr>
                </Table>
            </Form>
            </Td>
        </Tr>
   </Table>
   <?php
    PAGE_FOOTER("YELLOW", "BLACK");
    Exit;
} //end function

Function RENAMEFILE($NODE) {
/*
This function is the first phase of the Rename File process, the client write
the new name for the selected file with a form
*/
    PAGE_HEADER("FILE MANAGER - DIRTREEVIEW", "RENAME FILE", "TEAL", "WHITE");
    ?>
   <Table WIDTH=100% BORDER=0 CELLPADDING=8 CELLSPACING=0 class=td>
        <Tr>
            <Td VALIGN=top ALIGN=left>
                <Center>
                <Font FACE=tahoma>
                <H3>Current Filename :
    <?php
    $CURRENT_FILE = BUILD_PATH($NODE);
    Echo $CURRENT_FILE;
    ?>
            </H3></Td>
        </Tr>
        <Tr>
            <Td>
                <Center>
                <Font FACE=tahoma>
                <H3> Choose a new name for this file</H3>
                <Form NAME="renamefile" METHOD="post" ENCTYPE="multipart/form-data" ACTION="<?= $_SERVER['PHP_SELF'];?>">
                    <Table ALIGN=center BORDER=0 class=td>
                        <Tr>
                            <Td VALIGN=baseline><H3>New name for this File :<H3></Td>
                            <Td VALIGN=top><Input TYPE="text" NAME="RENAME_FILE" SIZE=50 VALUE='<?= $_SESSION['Folder_Name'] [$NODE];?>'></Td>
                        </Tr>
                        <Input TYPE='hidden' NAME='FILE_EXTENSION' VALUE='<?= $_SESSION['File_Extension'];?>'>
                        <Input TYPE='hidden' NAME='NODE' VALUE='<?= $NODE;?>'>
                        <Input TYPE='hidden' NAME='ACTION' VALUE='renamefile1'>
                        <Tr>
                            <Td><Input TYPE="button" VALUE="    Cancel   " ONCLICK="javascript:history.back()"></Td>
                            <Td></Td>
                            <Td><Input TYPE="Submit" NAME="RenameFileform2" VALUE="   Accept  "></Td>
                        </Tr>
                        <Tr>
                            <Td><Noscript>Use your BACK ARROW button of your BROWSER NAVIGATOR to GO BACK</Noscript></Td>
                        </Tr>
                    </Table>
                </Form>
            </Td>
        </Tr>
   </Table>
   <?php
    PAGE_FOOTER("TEAL", "WHITE");
    Exit;
} //end function

Function RENAMEFILE1($RENAME_FILE) {
/*
This function is the second phase of the Rename File process, this is the
checking phase.
*/
    $CURRENT_FILE = BUILD_PATH($_SESSION['Node']);
    $REAL_FILE = str_replace(DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR, DIRNAME($_SESSION['Server_Path'])) . DIRECTORY_SEPARATOR . $CURRENT_FILE; // the real full filename of the directory
    PAGE_HEADER("FILE MANAGER - DIRTREEVIEW", "RENAME FILE", "TEAL", "WHITE");
    ?>
   <Table WIDTH=100% BORDER=0 CELLPADDING=8 CELLSPACING=0 class=td>
        <Tr>
            <Td VALIGN=top ALIGN=left>
                <Center>
                <Font FACE=tahoma>
                <H3>Old FileName:
    <?php
    Echo $_SESSION['Folder_Name'] [$_SESSION['Node']] . "</h3>";
    ?>
                <H3>New FileName:
    <?php
    Echo $RENAME_FILE . "</h3>";
    ?>
            </Td>
        </Tr>
        <Tr>
            <Td>
            <Form NAME="renamefile1" METHOD="post" ENCTYPE="multipart/form-data" ACTION="<?= $_SERVER['PHP_SELF'];
    ?>">
               <Table ALIGN=center BORDER=0 class=td>
                    <Tr>
    <?php
    $ERROR_FUNCTION = false;
    If ($RENAME_FILE != "") {
        CLEARSTATCACHE();
        If (IS_FILE($REAL_FILE)) {
            If (!IS_FILE(str_replace(DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR, DIRNAME($REAL_FILE)) . DIRECTORY_SEPARATOR . $RENAME_FILE)) {
                If (RENAME($REAL_FILE, str_replace(DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR, DIRNAME($REAL_FILE)) . DIRECTORY_SEPARATOR . $RENAME_FILE)) {
                    Echo "<td><CENTER><h3>The File has been renamed successfully</h3></td>";
                    $_SESSION['Folder_Name'] [$_SESSION['Node']] = $RENAME_FILE;
                    $ERROR_FUNCTION = false;
                } Else {
                    Echo "<td><CENTER><h3>Error: The Old FileName can`t be renamed</h3></td>";
                    $ERROR_FUNCTION = true;
                }
            }
        } Else {
            Echo "<td><CENTER><h3>Error: Old FileName not exist</h3></td>";
            $ERROR_FUNCTION = true;
        }
    } Else {
        Echo "<td><CENTER><h3>Error: You have not introduced any new name for the this file</h3></td>";
        $ERROR_FUNCTION = true;
    }
    ?>
                    </Tr>
                    <Input TYPE="hidden" NAME="FILE_EXTENSION" VALUE="<?= $_SESSION['File_Extension'];?>">
                    <Input TYPE="hidden" NAME="NODE" VALUE="<?= $_SESSION['Node'];?>">
    <?php If ($ERROR_FUNCTION) {
        ?>
                    <Input TYPE="hidden" NAME="ACTION" VALUE="">
                    <Tr>
                        <Td><Center><Input TYPE="Submit" NAME="Renamefileform3a" VALUE="    Cancel    "></Td>
    <?php } Else {
        ?>
                    <Input TYPE="hidden" NAME="ACTION" VALUE="renamefile2">
                    <Tr>
                        <Td><Center><Input TYPE="Submit" NAME="Renamefileform3b" VALUE="   Accept   "></Td>
    <?php }
    ?>
                    </Tr>
                </Table>
            </Form>
            </Td>
        </Tr>
   </Table>
   <?php
    PAGE_FOOTER("TEAL", "WHITE");
    Exit;
} //end function

Function EMAILFILE($NODE) {
/*
This function is the first phase of the Email File process from a NODE of the
tree structure, with previous compression or not), previously to use this
function the SMTP parameter and  the sendmail_From parameter in PHP.INI must be
set acordingly to your ISPs smtp mail server.(your_ip_server could be anything).
sample extracted from PHP.INI
[mail function]
; For Win32 only.
SMTP = smtp.your_ip_server.com
smtp_port = 25
; For Win32 only.
sendmail_from = address@your_ip_server.com
*/
    $FILE_NAME = $_SESSION['Folder_Name'] [$NODE];
    $CURRENT_FILE = BUILD_PATH($NODE);
    $REALFILE = str_replace(DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR, DIRNAME($_SESSION['Server_Path'])) . DIRECTORY_SEPARATOR . $CURRENT_FILE;
    $borde = 0;
    $bordercolor = "BLACK";
    $bodycolor = "CYAN";
    PAGEMAIL_HEADER("FILE MANAGER - DIRTREEVIEW", "EMAIL FUNCTION", "BLUE", "WHITE");
    ?>
<TABLE bgcolor=<?=$bodycolor;
    ?> WIDTH=100% BORDER=0 CELLPADDING=0 CELLSPACING=0 class=td>
  <tr>
    <TD>
        <center>
        <FONT COLOR='<?=$bordercolor;?>'>
        <H3>
            SEND THE ARCHIVE <br>
            "<?=STRTOUPPER($CURRENT_FILE);?>" <br>
            AS EMAIL ATTACHED FILE<br>
        </H3>
        <BR>
        <H4>
            Please fill the fields correctly<br>
        </H4>
        <br>
        </font>
        </center>
    </TD>
  </tr>
  <tr>
    <td>
    <center>
    <form name="emailform" method="post" ACTION="<?= $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data">
        <table width=100% border="<?=$borde;?>" bordercolor="<?=$bordercolor;?>" cellpadding="0" cellspacing="0" bgcolor="<?=$bodycolor;?>" class=td>
           <tr>
                <td>&nbsp</td>

                            <Td VALIGN=top><P><center>Compress File before Send <Input TYPE="radio" VALUE="compress" CHECKED NAME="ACTIONEMAIL"> YES <Input TYPE="radio" VALUE="nocompress" NAME="ACTIONEMAIL"> NO</center></P></Td>

                <td>&nbsp</td>
            </tr>
            <tr>
                <td>&nbsp</td>
                <td>
                    <center><input type="text" name="your_name" size="61" value="Your Name" onfocus="switchvalue(this,'Your Name');" onblur="switchvalue(this,'Your Name');">
                </td>
                <td>&nbsp</td>
            </tr>
            <tr>
                <td>&nbsp</td>
                <td >
                    <center><input type="text" name="your_email" size="61" value="Your E-mail" onfocus="switchvalue(this,'Your E-mail');" onblur="switchvalue(this,'Your E-mail');">
                </td>
                <td>&nbsp</td>
            </tr>
            <tr>
                <td>&nbsp</td>
                <td >
                    <center><input type="text" name="target_name" size="61" value="Target Name" onfocus="switchvalue(this,'Target Name');" onblur="switchvalue(this,'Target Name');">
                </td>
                <td>&nbsp</td>
            </tr>
            <tr>
                <td>&nbsp</td>
                <td >
                    <center><input type="text" name="target_email" size="61" value="Target E-mail" onfocus="switchvalue(this,'Target E-mail');" onblur="switchvalue(this,'Target E-mail');">
                </td>
                <td>&nbsp</td>
            </tr>
                <td>&nbsp</td>
                <td>
                    <center><input type="text" name="matter" size="61" value="the matter of the message" onfocus="switchvalue(this,'the matter of the message');" onblur="switchvalue(this,'the matter of the message');">
                </td>
                <td>&nbsp</td>
            <tr>
                <Td>&nbsp</Td>
                <Td>&nbsp</Td>
                <Td>&nbsp</Td>
            </tr>
            <TR>
                <td>&nbsp</td>
                <td valign="top" rowspan="5">
                    <center><textarea name="email_message" cols="46" rows="7" onfocus="switchvalue(this,'Your Message');" onblur="switchvalue(this,'Your Message');">Your Message</textarea>
                </td>
                <td>&nbsp</td>
            </TR>
            <input type="hidden" name="attached" value="<?=$REALFILE?>">
            <Input TYPE="hidden" NAME="FILE_EXTENSION" VALUE="<?= $_SESSION['File_Extension'];?>">
            <Input TYPE="hidden" NAME="NODE" VALUE="<?= $NODE;?>">
            <Input TYPE="hidden" NAME="ACTION" VALUE="emailfile1">
            <tr></tr>
            <tr></tr>
            <tr></tr>
            <tr></tr>
            <Tr>
                <Td align=right><Input TYPE="button" VALUE="    Cancel   " ONCLICK="javascript:history.back()"></Td>
                <Td>&nbsp</Td>
                <Td align=left><Input TYPE="Submit" NAME="send" VALUE="   SEND   "></Td>
            </Tr>
            <Tr>
                <Td><Noscript>Use your BACK ARROW button of your BROWSER NAVIGATOR to GO BACK</Noscript></Td>
            </Tr>
            <tr>
                <Td>&nbsp</Td>
                <Td>&nbsp</Td>
                <Td>&nbsp</Td>
            </tr>
        </table>
    </form>
    </center>
    </td>
  </tr>
</TABLE>
<?php
    PAGE_FOOTER("BLUE", "WHITE");
    Exit;
} //END FUNCTION

function IS_VALID_EMAIL($mail) {
/*
This function validate the characters in the contents of the email message.
*/
    return eregi('^[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+' . '@' . '[-!#$%&\'*+\\/0-9=?A-Z^_`a-z{|}~]+\.' . '[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+$', $mail);
} //END FUNCTION

Function EMAILFILE1($NODE) {
/*
This function is the second phase of the EMAIL File process, this is the
checking phase and mail process, previously to use this function the SMTP
variable in PHP.INI must be set acordingly to your ISPs smtp mail server, an
smtp server something like "smtp.your_ip_server.com"
(you_ip_server could be anything).
*/
    $CURRENT_FILE = BUILD_PATH($NODE);
    $REAL_FILE = str_replace(DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR, DIRNAME($_SESSION['Server_Path'])) . DIRECTORY_SEPARATOR . $CURRENT_FILE; // the real full filename of the directory
    PAGEMAIL_HEADER("FILE MANAGER - DIRTREEVIEW", "EMAIL FUNCTION", "BLUE", "WHITE");
    ?>
   <Table WIDTH=100% BORDER=0 CELLPADDING=8 CELLSPACING=0 class=td>
        <Tr>
            <Td VALIGN=top ALIGN=left>
                <Center>
                <Font FACE=tahoma>
                <H3>FileName:
    <?php
    Echo $CURRENT_FILE . "</h3>";
    ?>
            </Td>
        </Tr>
        <Tr>
            <Td>
            <Form NAME="emailfile1" METHOD="post" ENCTYPE="multipart/form-data" ACTION="<?= $_SERVER['PHP_SELF'];?>">
               <Table ALIGN=center BORDER=0 class=td>
                    <Tr>
    <?php
    $ERROR_FUNCTION = false;
    IF (EMPTY($_POST['attached'])) {
        Echo "<td><CENTER><h3>No file to send</h3></td>";
        $ERROR_FUNCTION = true;
    } else {
        CLEARSTATCACHE();
        If (!IS_FILE($_POST['attached'])) {
            Echo "<td><CENTER><h3>The File has been erased or moved</h3></td>";
            $ERROR_FUNCTION = true;
        } else {
            If (!IS_VALID_EMAIL($_POST['target_email'])) {
                Echo "<td><CENTER><h3>The data fields has errors</h3></td>";
                $ERROR_FUNCTION = true;
            } Else {
                $prioridad = "3";
                $headers = "From: ";
                $headers .= $_POST['your_name'];
                $headers .= " <";
                $headers .= $_POST['your_email'];
                $headers .= ">\n";
                $headers .= "Reply-To: ";
                $headers .= $_POST['your_name'];
                $headers .= " <";
                $headers .= $_POST['your_email'];
                $headers .= ">\n";
                $headers .= "MIME-Version: 1.0\n";
                $headers .= "Content-Type: multipart/mixed; boundary=\"MIME_BOUNDRY\"\n";
                $headers .= "X-Sender: DIRTREEVIEW 1.0 <";
                $headers .= $_POST['your_email'];
                $headers .= ">\n";
                $headers .= "X-Mailer: DIRTREEVIEW 1.0\n";
                $headers .= "X-Priority: ";
                $headers .= $prioridad;
                $headers .= "\n";
                $headers .= "Return-Path: <";
                $headers .= $_POST['target_email'];
                $headers .= ">\n";
                $headers .= "This is a multi-part message in MIME format.\n";
                $FILE_TO_EMAIL = $_POST['attached'];
                IF ($_POST['ACTIONEMAIL'] == "compress") {
                    CLEARSTATCACHE();
                    If (IS_FILE($REAL_FILE)) {
                        $ZIP_FILE = DIRNAME($REAL_FILE) . DIRECTORY_SEPARATOR . SUBSTR(BASENAME($REAL_FILE), 0, STRRPOS(BASENAME($REAL_FILE), ".")) . ".zip";
                        if ($ZIP_FILE != $REAL_FILE) {
                            IF (IS_FILE($ZIP_FILE)) {
                                UNLINK($ZIP_FILE);
                            }
                            $FILE_TO_ZIP[1] = $REAL_FILE;
                            //include_once("dirtreezip1.inc.php");
                            $ziper = new zipfile();
                            $ziper->addFiles($FILE_TO_ZIP);
                            $ziper->output($ZIP_FILE);
                            IF (IS_FILE($ZIP_FILE)) {
                                $FILE_TO_EMAIL = $ZIP_FILE;
                            }
                        }
                    }
                }
                $fp = fopen($FILE_TO_EMAIL, "r");
                $str = fread($fp, filesize($FILE_TO_EMAIL));
                $str = chunk_split(base64_encode($str));
                $fp = fclose($fp);
                $blankline=" \r\n";
                $tmp_message = "Hi " . $_POST['target_name'];
                $tmp_message .= $blankline;
                $tmp_message .= $blankline;
                $tmp_message .= "I'am " . $_POST['your_name'] . " and I send you this message and the attached file";
                $tmp_message .= $blankline;
                $tmp_message .= $blankline;
                $tmp_message .= "Message";
                $tmp_message .= $blankline;
                $tmp_message .= $blankline;
                $tmp_message .= "=======";
                $tmp_message .= $blankline;
                $tmp_message .= $blankline;
                $tmp_message .= $_POST['email_message'];

                $message = "--MIME_BOUNDRY\n";
                $message .= "Content-Type: text/plain; charset=\"iso-8859-1\"\n";
                $message .= "Content-Transfer-Encoding: quoted-printable\n";
                $message .= "\n";
                $message .= $tmp_message;
                $message .= "\n";

                $message .= "--MIME_BOUNDRY\n";
                $message .= "Content-Type: application/octet-stream; name=";
                $message .= basename($FILE_TO_EMAIL);
                $message .= "\n";
                $message .= "Content-disposition: attachment\n";
                $message .= "Content-Transfer-Encoding: base64\n";
                $message .= "\n";
                $message .= $str;
                $message .= "\n";
                $message .= "\n";
                $message .= "--MIME_BOUNDRY--\n";

                if (!mail($_POST['target_email'], $_POST['matter'], $message, $headers)) {
                    echo "<td><CENTER><h3>ERROR : email has not been sent, please try it again</h3></td>";
                    $ERROR_FUNCTION = true;
                } else {
                    echo "<td><CENTER><h3>The file " . $FILE_TO_EMAIL . " has been sent succesfully</h3></td>";
                }
                IF ($_POST['ACTIONEMAIL'] == "compress") {
                    if ($ZIP_FILE != $REAL_FILE) {
                        IF (IS_FILE($ZIP_FILE)) {
                            UNLINK($ZIP_FILE);
                        }
                    }
                    unset($_POST['ACTIONEMAIL']);
                }
            }
        }
    }
    ?>
                    </Tr>
                    <Input TYPE="hidden" NAME="FILE_EXTENSION" VALUE="<?= $_SESSION['File_Extension'];?>">
                    <Input TYPE="hidden" NAME="NODE" VALUE="<?= $NODE;?>">
    <?php If ($ERROR_FUNCTION) {
    ?>
                    <Input TYPE="hidden" NAME="ACTION" VALUE="">
                    <Tr>
                        <Td><Center><Input TYPE="Submit" NAME="emailfileform3a" VALUE="    Cancel   "></Td>
    <?php } Else {
    ?>
                    <Input TYPE="hidden" NAME="ACTION" VALUE="">
                    <Tr>
                        <Td><Center><Input TYPE="Submit" NAME="emailfileform3b" VALUE="    Accept   "></Td>
    <?php }
    ?>
                    </Tr>
                </Table>
            </Form>
            </Td>
        </Tr>
   </Table>
   <?php
    PAGE_FOOTER("BLUE", "WHITE");
    Exit;
} //end function

/*
Zip file creation CLASS.
Makes zip files.
Last Modification and Extension By :
Hasin Hayder
HomePage : www.hasinme.info
Email : countdraculla@gmail.com
Originally Based on :
http://www.zend.com/codex.php?id=535&single=1
By Eric Mueller <eric@themepark.com>
http://www.zend.com/codex.php?id=470&single=1
by Denis125 <webmaster@atlant.ru>
a patch from Peter Listiak <mlady@users.sourceforge.net> for last modified date
and time of the compressed file.
Official ZIP file format: http://www.pkware.com/appnote.txt
@access  public
*/
class zipfile{
    var $datasec      = array();
    var $ctrl_dir     = array();
    var $eof_ctrl_dir = "\x50\x4b\x05\x06\x00\x00\x00\x00";
    var $old_offset   = 0;
    /**
     * Converts an Unix timestamp to a four byte DOS date and time format (date
     * in high two bytes, time in low two bytes allowing magnitude comparison).
     * @param  integer  the current Unix timestamp
     * @return integer  the current date in a four byte DOS format
     * @access private
     */
    function unix2DosTime($unixtime = 0) {
        $timearray = ($unixtime == 0) ? getdate() : getdate($unixtime);
        if ($timearray['year'] < 1980) {
        	$timearray['year']    = 1980;
        	$timearray['mon']     = 1;
        	$timearray['mday']    = 1;
        	$timearray['hours']   = 0;
        	$timearray['minutes'] = 0;
        	$timearray['seconds'] = 0;
        } // end if
        return (($timearray['year'] - 1980) << 25) | ($timearray['mon'] << 21) | ($timearray['mday'] << 16) |
                ($timearray['hours'] << 11) | ($timearray['minutes'] << 5) | ($timearray['seconds'] >> 1);
    } // end of the 'unix2DosTime()' method
    /**
     * Adds "file" to archive
     * @param  string   file contents
     * @param  string   name of the file in the archive (may contains the path)
     * @param  integer  the current timestamp
     * @access public
     */
    function addFile($data, $name, $time = 0){
        //$name     = str_replace(chr(92).chr(92), DIRECTORY_SEPARATOR, $name);
        $dtime    = dechex($this->unix2DosTime($time));
        $hexdtime = '\x' . $dtime[6] . $dtime[7]
                  . '\x' . $dtime[4] . $dtime[5]
                  . '\x' . $dtime[2] . $dtime[3]
                  . '\x' . $dtime[0] . $dtime[1];
        eval('$hexdtime = "' . $hexdtime . '";');
        $fr   = "\x50\x4b\x03\x04";
        $fr   .= "\x14\x00";            // ver needed to extract
        $fr   .= "\x00\x00";            // gen purpose bit flag
        $fr   .= "\x08\x00";            // compression method
        $fr   .= $hexdtime;             // last mod time and date
        // "local file header" segment
        $unc_len = strlen($data);
        $crc     = crc32($data);
        $zdata   = gzcompress($data);
        $zdata   = substr(substr($zdata, 0, strlen($zdata) - 4), 2); // fix crc bug
        $c_len   = strlen($zdata);
        $fr      .= pack('V', $crc);             // crc32
        $fr      .= pack('V', $c_len);           // compressed filesize
        $fr      .= pack('V', $unc_len);         // uncompressed filesize
        $fr      .= pack('v', strlen($name));    // length of filename
        $fr      .= pack('v', 0);                // extra field length
        $fr      .= $name;
        // "file data" segment
        $fr .= $zdata;
        // "data descriptor" segment (optional but necessary if archive is not
        // served as file)
        $fr .= pack('V', $crc);                 // crc32
        $fr .= pack('V', $c_len);               // compressed filesize
        $fr .= pack('V', $unc_len);             // uncompressed filesize
        // add this entry to array
        $this -> datasec[] = $fr;
        // now add to central directory record
        $cdrec = "\x50\x4b\x01\x02";
        $cdrec .= "\x00\x00";                // version made by
        $cdrec .= "\x14\x00";                // version needed to extract
        $cdrec .= "\x00\x00";                // gen purpose bit flag
        $cdrec .= "\x08\x00";                // compression method
        $cdrec .= $hexdtime;                 // last mod time & date
        $cdrec .= pack('V', $crc);           // crc32
        $cdrec .= pack('V', $c_len);         // compressed filesize
        $cdrec .= pack('V', $unc_len);       // uncompressed filesize
        $cdrec .= pack('v', strlen($name) ); // length of filename
        $cdrec .= pack('v', 0 );             // extra field length
        $cdrec .= pack('v', 0 );             // file comment length
        $cdrec .= pack('v', 0 );             // disk number start
        $cdrec .= pack('v', 0 );             // internal file attributes
        $cdrec .= pack('V', 32 );            // external file attributes - 'archive' bit set
        $cdrec .= pack('V', $this -> old_offset ); // relative offset of local header
        $this -> old_offset += strlen($fr);
        $cdrec .= $name;
        // optional extra field, file comment goes here
        // save to central directory
        $this -> ctrl_dir[] = $cdrec;
    } // end of the 'addFile()' method
    /**
     * Dumps out file
     * @return  string  the zipped file
     * @access public
     */
    function file(){
        $data    = implode('', $this -> datasec);
        $ctrldir = implode('', $this -> ctrl_dir);
        return
            $data .
            $ctrldir .
            $this -> eof_ctrl_dir .
            pack('v', sizeof($this -> ctrl_dir)) .  // total # of entries "on this disk"
            pack('v', sizeof($this -> ctrl_dir)) .  // total # of entries overall
            pack('V', strlen($ctrldir)) .           // size of central dir
            pack('V', strlen($data)) .              // offset to start of central dir
            "\x00\x00";                             // .zip file comment length
    } // end of the 'file()' method
    /**
     * A Wrapper of original addFile Function
     * Created By Hasin Hayder at 29th Jan, 1:29 AM
     * @param array An Array of files with relative/absolute path to be added in Zip File
     * @access public
     */
    function addFiles($files /*Only Pass Array*/) {
        foreach($files as $file){
		      if (is_file($file)) {
			     $data = implode("",file($file));
	             $this->addFile($data,basename($file));
              }
        }
    }
    /**
     * A Wrapper of original file Function
     * Created By Hasin Hayder at 29th Jan, 1:29 AM
     * @param string Output file name
     * @access public
     */
    function output($file) {
        $fp=fopen($file,"w");
        fwrite($fp,$this->file());
        fclose($fp);
    }

} // end of the 'zipfile' class

// the next two functions are based on
/**
* zip.php
*    begin                : Saturday', Mar 08', 2003
*    copyright            : ('C) 2002-03 Bugada Andrea
*    email                : phpATM@free.fr
*    $Id: zip.php, v1.12 2003/03/09 11:53:50 bugada Exp $
*/
function MSDOS_TIME_TO_UNIX($DOSdate, $DOStime) {
    $year = (($DOSdate &65024) >> 9) + 1980;
    $month = ($DOSdate &480) >> 5;
    $day = ($DOSdate &31);
    $hours = ($DOStime &63488) >> 11;
    $minutes = ($DOStime &2016) >> 5;
    $seconds = ($DOStime &31) * 2;
    return mktime($hours, $minutes, $seconds, $month, $day, $year);
} //end function

function LIST_ZIP($NODE) {
global $encabezado;
    $CURRENT_FILE = BUILD_PATH($NODE);
    $REAL_FILE = str_replace(DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR, DIRNAME($_SESSION['Server_Path'])) . DIRECTORY_SEPARATOR . $CURRENT_FILE; // the real full filename of the directory
    IF (EMPTY($BGC)) {
        $BGC = "BLACK";
    }
    IF (EMPTY($FGC)) {
        $FGC = "YELLOW";
    }
    $fp = @fopen($REAL_FILE, 'rb');
    if (!$fp) {
        return;
    }
    fseek($fp, -22, SEEK_END);
    // Get central directory field values
    $headersignature = 0;
    do {
        // Search header
        $data = fread($fp, 22);
        list($headersignature, $numberentries, $centraldirsize, $centraldiroffset) =
        array_values(unpack('Vheadersignature/x6/vnumberentries/Vcentraldirsize/Vcentraldiroffset', $data));
        fseek($fp, -23, SEEK_CUR);
    } while (($headersignature != 0x06054b50) && (ftell($fp) > 0));
    // Go to start of central directory
    fseek($fp, $centraldiroffset, SEEK_SET);
    // Read central dir entries
    PAGE_HEADER("FILE FUNCTIONS - DIRTREEVIEW", "LIST ZIP CONTENTS OF " . STRTOUPPER(basename($REAL_FILE)), $BGC, $FGC);
    echo "<p><CENTER><table border='' bgcolor=$BGC cellpadding='0' cellspacing='0' class=td>";
    echo "
    <tr bgcolor=$BGC>
        <td>&nbsp</td>
       <td>
          <H3><b><font color=$FGC>FileName</font></b></H3>
       </td>
       <td ALIGN=RIGHT>
          <H3><b><font color=$FGC>Size</font></b></H3>
       </td>
       <td>&nbsp</td>
       <td>&nbsp</td>
       <td>&nbsp</td>
       <td>
          <H3><b><font color=$FGC>Date:Time</font></b></H3>
       </td>
        <td>&nbsp</td>
    </tr>";
    for ($i = 1; $i <= $numberentries; $i++) {
        // Read central dir entry
        $data = fread($fp, 46);
        list($arcfiletime, $arcfiledate, $arcfilesize, $arcfilenamelen, $arcfileattr) =
        array_values(unpack("x12/varcfiletime/varcfiledate/x8/Varcfilesize/Varcfilenamelen/x6/varcfileattr", $data));
        $filenamelen = fread($fp, $arcfilenamelen);
        $arcfiledatetime = MSDOS_TIME_TO_UNIX($arcfiledate, $arcfiletime);
        echo "<tr BGCOLOR=$FGC>";
        ECHO "<td>&nbsp</td>";
        // Print FileName
        if ($arcfileattr == 16) {
            echo "<td><font color='$BGC'>";
            echo "<b>" . $filenamelen . "</b>";
            echo "</td></font>";
        } else {
            echo "<td ><font color='$BGC'>";
            echo "...." . basename($filenamelen);
            echo "</font></td>";
        }
        // Print FileSize column
        if ($arcfileattr == 16) {
            echo "<td><font color='$BGC'>";
            echo "<B>Folder</B>";
            echo "</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td>";
        } else {
            echo "<td align=right><font color='$BGC'>";
            If ($arcfilesize > 0) {
                IF (!ISSET($_SESSION['Display_Size'])) {
                    $_SESSION['Display_Size'] = "";
                }
                switch ($_SESSION['Display_Size']) {
                    case 2:
                        ECHO NUMBER_FORMAT(($arcfilesize / (1024 * 1024)), 2, ',', '.');
                        $DES_BYTES = "mb";
                        break;
                    case 1:
                        ECHO NUMBER_FORMAT(($arcfilesize / 1024), 1, ',', '.') ;
                        $DES_BYTES = "kb";
                        break;
                    default:
                        Echo NUMBER_FORMAT($arcfilesize, 0, ',', '.');
                        $DES_BYTES = "bytes";
                } // switch
            } Else {
                Echo "&nbsp";
                $DES_BYTES = "";
            }
            echo "</Td>";
            echo "<Td>&nbsp</Td>";
            echo "<td ALIGN=left><Font COLOR=$BGC>$DES_BYTES</Td>";
            echo "<Td ALIGN=right><Font COLOR=$BGC>&nbsp</Td>";
        }
        echo '</td></font>';
        // Print FileDate column
        echo "<td><font color=$BGC>";
        if ($arcfileattr == 16) {
            echo "<B>" . date("d/m/y H:i", $arcfiledatetime) . "</B>";
        } ELSE {
            echo date("d/m/y H:i", $arcfiledatetime);
        }
        echo '</td></font>';
        ECHO "<td>&nbsp</td>";
        echo '</tr>';
    }
    echo "
    <tr bgcolor=$BGC>
        <td VALIGN=middle COLSPAN=8><CENTER>
            <a href=" . $_SERVER['PHP_SELF'] . "?ACTION=expand&NODE=" . $NODE . "&FILE_EXTENSION=" . $_SESSION['File_Extension'] . "$encabezado><B><Font COLOR=$FGC><H3>BACK</H3>
            </Font></B></A>
        </Td>
    </tr>";
    echo '</table></p>';
    fclose($fp);
    PAGE_FOOTER($BGC, $FGC);
    exit;
} //END FUNCTION

Function PAGEMAIL_HEADER($TITLE, $SUBTITLE, $BGC, $FGC) {
global $encabezado;
/*
This function write the header of the email form web html page.
(little javascript is included).
*/
    IF (EMPTY($BGC)) {
        $BGC = "BLUE";
    }
    IF (EMPTY($FGC)) {
        $FGC = "WHITE";
    }
    ?>
    <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
    <Html>
        <Head>
            <Title>
                <?=$TITLE;?>
            </Title>
            <script type="text/javascript">
                function switchvalue(one,two) {
                    if (one.value==two) {
                        one.value='';
                    }else{
                        if (one.value=='') {
                            one.value=two;
                        }
                    }
                }
            </script>
            <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
            <meta name="author" content="Dirtreeview - www.euskalnet.net/aitor-solozabal">
        </Head>
        <Body >
            <Table WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" class=td>
                <Tr ALIGN="center" BGCOLOR="<?=$BGC;?>" class=td>
                    <Td HEIGHT="30" VALIGN="middle" ><B><Font FACE="tahoma" COLOR="<?=$FGC;?>"><?=$SUBTITLE;?></Font></B></Td>
                </Tr>
            </Table>
     <?php
} //end function

Function PAGE_HEADER($TITLE, $SUBTITLE, $BGC, $FGC) {
global $arrHttp,$msgstr;
/*
This function write the header of the any form web html page.
*/
    IF (EMPTY($BGC)) {
        $BGC = "BLUE";
    }
    IF (EMPTY($FGC)) {
        $FGC = "WHITE";
    }
 //   EncabezadoPagina()
    ?>
 <!--   <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
    <Html>
        <Head>
            <Title>
                <?=$TITLE;?>
            </Title>
            <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
            <meta name="author" content="Dirtreeview - www.euskalnet.net/aitor-solozabal">
        </Head>
        <Body> -->

            <Table WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" class=td>
                <Tr ALIGN="center">
                    <Td HEIGHT="30" VALIGN="middle" BGCOLOR="<?=$BGC;?>">
                    <B><Font FACE="tahoma" COLOR="<?=$FGC;?>"><?=$SUBTITLE;?></Font></B>
                    </Td>
                </Tr>
            </Table>
     <?php
} //end function

Function PAGEDIR_HEADER($TITLE, $SUBTITLE, $BGC, $FGC) {

/*
This function write the header of the dirtreeview web html page.
*/
    IF (EMPTY($BGC)) {
        $BGC = "BLUE";
    }
    IF (EMPTY($FGC)) {
        $FGC = "WHITE";
    }
//EncabezadoPagina();
} //end function

Function TABLEDIR_HEADER($BGC, $FGC) {
global $encabezado;
/*
This function write the header of the dirtreeview table inside the web html page
*/
    IF (EMPTY($BGC)) {
        $BGC = "WHITE";
    }
    IF (EMPTY($FGC)) {
        $FGC = "BLACK";
    }
    ?>

    <Table width="100%" ALIGN="center" CELLPADDING="0" CELLSPACING="0"  class=td >
        <Tr BGCOLOR="<?=$BGC;?>">
            <Td><Img SRC="img/dirtree/tree_space.gif"></Td>
            <Td VALIGN=middle>
                <Img SRC="img/dirtree/tree_space.gif">
                <Img SRC="img/dirtree/tree_space.gif" alt="Developed with PHP under Apache Server">
                <Img SRC="img/dirtree/tree_space.gif">
            </Td>
            <Td><Img SRC="img/dirtree/tree_space.gif"></Td>
            <Td Align='center'>Display<?php echo "<br>".$_SESSION['Width'] . "x" . $_SESSION['Height'];?></Td>
            <Td><Img SRC="img/dirtree/tree_space.gif"></Td>
            <Td Align='center'>Max File Size<br><?php echo NUMBER_FORMAT($_SESSION['Maxfilesize'], 0, ',', '.');?></Td>
            <Td><Img SRC="img/dirtree/tree_space.gif"></Td>
            <Td>
                <Font SIZE="2" COLOR="<?=$FGC;?>"><B>DIRECTORY TREEVIEW</B></Font>
                <Br>
                <font color="<?=$FGC;?>">User: <?=$_SESSION['login'];?> --> Privileges: <?= $_SESSION['privileges'];?></Font>
            </td>
            <td valign="middle">
              <!--  <A HREF=<?=$_SERVER['PHP_SELF'];?>?ACTION=logout>
                <Img SRC="img/dirtree/tree_refresh1.gif" alt="Exit - Logout" BORDER="0" height="40">
                <font color="<?=$FGC;?>"> LOGOUT </A>] -->
            </Td>
            <Td><Img SRC="img/dirtree/tree_space.gif"></Td>
        </Tr>
    </Table>
    <Table ALIGN="center" CELLPADDING="0" CELLSPACING="0" BGCOLOR="<?php $BGC;?>" class=td>
        <Tr>
            <Td VALIGN="top"><font size=1>
                <A HREF=<?=$_SERVER['PHP_SELF'];?>?ACTION=refresh&NODE=<?= $_SESSION['Last_Node'];?>&FILE_EXTENSION=<?= $_SESSION['File_Extension'].$encabezado;?>>
                <Img SRC="img/dirtree/tree_refresh0.gif" alt="Rebuild the Treeview" BORDER=0>
                <Font SIZE="1" COLOR="<?=$FGC;?>"><B>Refresh</A>
                <A HREF=<?= $_SERVER['PHP_SELF'];?>?ACTION=filter&NODE=<?= $_SESSION['Last_Node'];?>&FILE_EXTENSION=<?= $_SESSION['File_Extension'].$encabezado;?>>
                <Img SRC="img/dirtree/tree_filter.gif" alt="File Filter Extension Criteria" BORDER=0>
                <Font SIZE="1" COLOR="<?=$FGC;  ?>"><B>File Filter =</A>
    <?php
    If ($_SESSION['File_Extension'] == "") {
        Echo "*.*";
    } Else {
        Echo $_SESSION['File_Extension'];
    }
    ?>
            </Td>
        </Tr>
     </Table>
    <?php
} //end function

Function TABLEDIR_SUBHEADER($BGC, $FGC) {
global $encabezado;
/*
This function write the subheader of the dirtreeview table in the web html page.
*/
    IF (EMPTY($BGC)) {
        $BGC = "MAROON";
    }
    IF (EMPTY($FGC)) {
        $FGC = "WHITE";
    }
    ?>
    <Table ALIGN="center" CELLSPACING="0" CELLPADDING="0" class=td border=0>
        <Tr BGCOLOR="<?=$BGC;?>" ALIGN="center" VALIGN="top">
            <Td><B><I><Font COLOR="<?=$FGC;?>">FOLDERS</Td>
            <Td>&nbsp</Td>
            <Td><B><I><Font COLOR="<?=$FGC;?>">FILES</Td>
            <Td>&nbsp</Td>
            <Td><B><I><Font COLOR="<?=$FGC;?>">FILENAMES</Td>
            <Td>&nbsp</Td>
            <Td COLSPAN=4><a alt="Show Bytes, Kbytes, Mbytes" href=<?=$_SERVER['PHP_SELF'].$encabezado;?>&ACTION=size><B><I><Font COLOR="<?=$FGC;?>">SIZE</a></Td>
            <Td>&nbsp</Td>
            <Td>&nbsp</Td>
            <Td><B><I><Font COLOR="<?=$FGC;?>">LAST DATE</Td>
            <Td>&nbsp</Td>
        </Tr>
        <Br>
    <?php
} //end function

Function COLUMN_FOLDER($NODE, $BGC, $FGC) {
/*
This function write the data in the column folder of the dirtreeview table.
*/
    IF (EMPTY($BGC)) {
        $BGC = "ANTIQUEWHITE";
    }
    IF (EMPTY($FGC)) {
        $FGC = "RED";
    }
    ?>
    <Tr>
        <Td BGCOLOR="<?=$BGC;?>" ALIGN="right" VALIGN="top"><Font COLOR="<?=$FGC;?>">
    <?php
    If ($_SESSION['Children_Subdirs'][$NODE] != 0) {
        // number of subdirs
        echo $_SESSION['Children_Subdirs'][$NODE];
    } Else {
        Echo "&nbsp";
    }
    ?>
        </Td>
        <Td BGCOLOR="<?=$BGC;
    ?>">&nbsp</Td>
    <?php
} //end function

Function COLUMN_FILES($NODE, $BGC, $FGC) {
/*
This function write the data in the column files of the dirtreeview table.
*/
    IF (EMPTY($BGC)) {
        $BGC = "PALEGREEN";
    }
    IF (EMPTY($FGC)) {
        $FGC = "BLUE";
    }
    ?>
   <Td BGCOLOR="<?=$BGC;?>" ALIGN="right" VALIGN="top"><Font COLOR="<?=$FGC;?>">
   <?php
    If ($_SESSION['Children_Files'] [$NODE] != 0) {
        // number of files
        Echo $_SESSION['Children_Files'] [$NODE];
    } Else {
        Echo "&nbsp";
    }
    ?>
   </Td>
   <Td BGCOLOR="<?=$BGC;?>">&nbsp</Td>
   <?php
} //end function

Function COLUMN_FILENAMES_ROOT($BGC, $FGC) {global $encabezado;
/*
This function write the data in the column filenames exclusively for the first
row of the dirtreeview table. (root dir).
*/
    IF (EMPTY($BGC)) {
        $BGC = "LIGHTSKYBLUE";
    }
    IF (EMPTY($FGC)) {
        $FGC = "BLUE";
    }
    ?>
    <Td BGCOLOR="<?=$BGC;
    ?>" NOWRAP><Font COLOR="<?=$FGC;?>">
    <A HREF=<?= $_SERVER['PHP_SELF'];?>?ACTION=collapseall&NODE=0&FILE_EXTENSION=<?= $_SESSION['File_Extension'].$encabezado;?>>
    <Img SRC="img/dirtree/tree_minus_end.gif" alt="Collapse All" HEIGHT="18" WIDTH="18" BORDER="0" VSPACE="0" HSPACE="0" ALIGN="left"></A>
    <A HREF=<?= $_SERVER['PHP_SELF'];?>?ACTION=dirfunction&NODE=0&FILE_EXTENSION=<?= $_SESSION['File_Extension'].$encabezado;?>>
    <Img SRC="img/dirtree/tree_upload.gif" alt="Directory Functions" HEIGHT="18" WIDTH="18" BORDER="0" VSPACE="0" HSPACE="0" ALIGN="left"></A>
    <A HREF=<?= $_SERVER['PHP_SELF'];?>?ACTION=expandall&NODE=0&FILE_EXTENSION=<?= $_SESSION['File_Extension'].$encabezado;?>>
    <Img SRC="img/dirtree/tree_root.gif" alt="Expand All" BORDER="0" HEIGHT="20" WIDTH="20" VSPACE="0" HSPACE="0" ALIGN="left">
    <b><?= BASENAME($_SESSION['Server_Path']);?></b></A>
    </Td>
    <Td BGCOLOR="<?=$BGC;?>">&nbsp</Td>
    <?php
} //end function

Function COLUMN_FILENAMES($NODE, $BGC, $FGC) {
global $encabezado;
/*
This function write the data in the column filenames of the dirtreeview table.
*/
    IF (EMPTY($BGC)) {
        $BGC = "LIGHTCYAN";
    }
    IF (EMPTY($FGC)) {
        $FGC = "BLUE";
    }
    $_SESSION['Last_Node'] = $NODE;
    Echo "<td bgcolor='" . $BGC . "' nowrap><font color='" . $FGC . "'>";
    Echo "<img SRC='img/dirtree/tree_space.gif' height='18' width='18' border='0' vspace='0' hspace='0' align='left'>";
    For ($I = 0;$I <= $_SESSION['Level_Tree'][$NODE];$I++) {
        $LEVEL_NODE[$I] = 0; //initialization of the needed levels
    }
    $J = $NODE;
    $I = $NODE;
    Do {
        While (($I < $_SESSION['Numfile']) && ($_SESSION['Level_Tree'][$I] >= $_SESSION['Level_Tree'][$J])) {
            $I++;
        }
        $DIFERENCIA = ($_SESSION['Level_Tree'][$J] - ($_SESSION['Level_Tree'][$I] + 1));
        For ($K = 1;$K <= $DIFERENCIA;$K++) {
            $LEVEL_NODE[$_SESSION['Level_Tree'][$J] - $K] = 1;
        }
        $J = $I;
        $I = $I + 1;
    } While (($I <= $_SESSION['Numfile']) && ($_SESSION['Level_Tree'][$I-1] > 1));
    For ($I = 1;$I < $_SESSION['Level_Tree'][$NODE];$I++) {
        If (($LEVEL_NODE[$I] == 1) || ($NODE > $_SESSION['Last_Level_Node'][$I])) {
            Echo "<img SRC='img/dirtree/tree_space.gif' height='18' width='18' border='0' vspace='0' hspace='0' align='left'>";
        } Else {
            Echo "<img SRC='img/dirtree/tree_vertline.gif' height='18' width='18' border='0' vspace='0' hspace='0' align='left'>";
        }
    }
    If ($_SESSION['Folder_Type'] [$NODE] == "File") { // it is a file
        // add an ACTION to download the file
        Echo "<a href=" . $_SERVER['PHP_SELF'] . "?ACTION=filefunction&NODE=" . $NODE . "&FILE_EXTENSION=" . $_SESSION['File_Extension'] . "$encabezado>";
        If ($NODE == $_SESSION['Numfile']) {
            Echo "<img SRC='img/dirtree/tree_end.gif' height='18' width='18' border='0' vspace='0' hspace='0' align='left'>";
        } Else {
            If ($_SESSION['Level_Tree'][$NODE + 1] < $_SESSION['Level_Tree'][$NODE]) {
                Echo "<img SRC='img/dirtree/tree_end.gif' height='18' width='18' border='0' vspace='0' hspace='0' align='left'>";
            } Else {
                Echo "<img SRC='img/dirtree/tree_split.gif' height='18' width='18' border='0' vspace='0' hspace='0' align='left'>";
            }
        }
        Echo "<img SRC='img/dirtree/tree_download.gif' alt=" . "File Functions" . " height='18' width='18' border='0' vspace='0' hspace='0' align='left'>";
        //agregado


    } Else { // it is not a file then it is a directory
        If ($NODE == $_SESSION['Numfile']) {
            Echo "<img SRC='img/dirtree/tree_end.gif' height='18' width='18' border='0' vspace='0' hspace='0' align='left'>";
            Echo "</a>";
            Echo "<a href=" . $_SERVER['PHP_SELF'] . "?ACTION=dirfunction&NODE=" . $NODE . "&FILE_EXTENSION=" . $_SESSION['File_Extension'] . "$encabezado>";
            Echo "<img SRC='img/dirtree/tree_upload.gif' alt=" . "Dir Functions" . " height='18' width='18' border='0' vspace='0' hspace='0' align='left'>";
        } Else {
            If ($_SESSION['Father'] [$NODE + 1] == $NODE) { // has childs
                If ($_SESSION['Opened_Folder'][$NODE] == 0) { // closed NODE (folder)
                    Echo "<a href=" . $_SERVER['PHP_SELF'] . "?ACTION=expand&NODE=" . $NODE . "&FILE_EXTENSION=" . $_SESSION['File_Extension'] . "$encabezado>";
                    If ($NODE == $_SESSION['Last_Level_Node'][$_SESSION['Level_Tree'][$NODE]]) {
                        Echo "<img SRC='img/dirtree/tree_plus_end.gif' alt='Expand' height='18' width='18' border='0' vspace='0' hspace='0' align='left'>";
                    } Else {
                        $I = $NODE + 1;
                        While ($I <= $_SESSION['Numfile']) {
                            If ($_SESSION['Level_Tree'][$I] < $_SESSION['Level_Tree'][$NODE]) {
                                Echo "<img SRC='img/dirtree/tree_plus_end.gif' alt='Expand' height='18' width='18' border='0' vspace='0' hspace='0' align='left'>";
                                Break;
                            } Else {
                                If ($_SESSION['Level_Tree'][$I] == $_SESSION['Level_Tree'][$NODE]) {
                                    Echo "<img SRC='img/dirtree/tree_plus.gif' alt='Expand' height='18' width='18' border='0' vspace='0' hspace='0' align='left'>";
                                    Break;
                                }
                            }
                            $I++;
                        }
                    }
                    If ($_SESSION['Children_Files'] [$NODE] != 0) {
                        Echo "<img SRC='img/dirtree/tree_haschild.gif' height='18' width='18' border='0' vspace='0' hspace='0' align='left'>";
                    } Else {
                        Echo "<img SRC='img/dirtree/tree_closed.gif' height='18' width='18' border='0' vspace='0' hspace='0' align='left'>";
                    }
                } Else { // opened NODE (folder)
                    Echo "<a href=" . $_SERVER['PHP_SELF'] . "?ACTION=collapse&NODE=" . $NODE . "&FILE_EXTENSION=" . $_SESSION['File_Extension'] . ">";
                    If ($NODE == $_SESSION['Last_Level_Node'][$_SESSION['Level_Tree'][$NODE]]) {
                        Echo "<img SRC='img/dirtree/tree_minus_end.gif' alt='Collapse' height='18' width='18' border='0' vspace='0' hspace='0' align='left'>";
                    } Else {
                        $I = $NODE + 1;
                        While ($I <= $_SESSION['Numfile']) {
                            If ($_SESSION['Level_Tree'][$I] < $_SESSION['Level_Tree'][$NODE]) {
                                Echo "<img SRC='img/dirtree/tree_minus_end.gif' alt='Collapse' height='18' width='18' border='0' vspace='0' hspace='0' align='left'>";
                                Break;
                            } Else {
                                If ($_SESSION['Level_Tree'][$I] == $_SESSION['Level_Tree'][$NODE]) {
                                    Echo "<img SRC='img/dirtree/tree_minus.gif' alt='Collapse' height='18' width='18' border='0' vspace='0' hspace='0' align='left'>";
                                    Break;
                                }
                            }
                            $I++;
                        }
                    }
                    Echo "</a>";
                    Echo "<a href=" . $_SERVER['PHP_SELF'] . "?ACTION=dirfunction&NODE=" . $NODE . "&FILE_EXTENSION=" . $_SESSION['File_Extension'] . "$encabezado>";
                    Echo "<img SRC='img/dirtree/tree_upload.gif' alt=" . "Dir Functions" . " height='18' width='18' border='0' vspace='0' hspace='0' align='left'>";
                }
            } Else { // has no childs
                If ($_SESSION['Level_Tree'][$NODE + 1] < $_SESSION['Level_Tree'][$NODE]) {
                    Echo "<img SRC='img/dirtree/tree_end.gif' height='18' width='18' border='0' vspace='0' hspace='0' align='left'>";
                } Else {
                    Echo "<img SRC='img/dirtree/tree_split.gif' height='18' width='18' border='0' vspace='0' hspace='0' align='left'>";
                }
                Echo "</a>";
                Echo "<a href=" . $_SERVER['PHP_SELF'] . "?ACTION=dirfunction&NODE=" . $NODE . "&FILE_EXTENSION=" . $_SESSION['File_Extension'] . "$encabezado>";
                Echo "<img SRC='img/dirtree/tree_upload.gif' alt=" . "Dir Functions" . " height='18' width='18' border='0' vspace='0' hspace='0' align='left'>";
            }
        }
    }
    // after the levels were indented , continue with the current node name
    Echo "</a>";
    If ($_SESSION['Folder_Type'] [$NODE] == "File") {
    	$nombre=$_SESSION['Folder_Name'] [$NODE];
    	$found=false;
    	$comp=array(".cnt",".mst",".xrf",".ifp",".n01",".n02",".l01",".l02",".php","isisuc.tab","isisac.tab",".exe",".gif",".zip");
    	foreach ($comp as $value){
    		if (strpos(strtoupper($nombre),strtoupper($value))===false){
    		}else{
    			$found=true;
    		}
    	}
    	if ($nombre=="mx") $found=true;
    	if (!$found) {
    		$CURRENT_FILE = BUILD_PATH($NODE);
    		/*echo $CURRENT_FILE;
    		$c=explode(DIRECTORY_SEPARATOR,$CURRENT_FILE);
    		$CURRENT_FILE="";
    		for ($icf=1;$icf<count($c);$icf++)
    			if ($CURRENT_FILE=="")
    				$CURRENT_FILE=$c[$icf];
    			else
    				$CURRENT_FILE.='/'.$c[$icf]; */
    		if ($_SESSION['Father'][$NODE]>0) $nombre=$_SESSION['Folder_Name'] [$_SESSION['Father'][$NODE]]."/".$nombre;
			echo "<a href=\"javascript:VerArchivo('".urlencode(str_replace("\\","/",$CURRENT_FILE))."')\"><img SRC='img/dirtree/preview.gif' alt=preview  border='0' vspace='0' hspace='0' align='left'></a>";
		}else{
			Echo "<img SRC='img/dirtree/n_preview.gif'  border='0' vspace='0' hspace='0' align='left'>";
		}
	}
	Echo "<img SRC='img/dirtree/tree_space.gif' height='18' width='9' border='0' vspace='0' hspace='0' align='left'>";
    Echo $_SESSION['Folder_Name'] [$NODE];
    Echo "</td>";
    Echo "<td bgcolor=" . $BGC . ">&nbsp</td>";
} //end function

Function COLUMN_SIZE($NODE, $BGC, $FGC) {
global $encabezado;
/*
This function write the data in the column size of the dirtreeview table.
There are 5 modes of visualization depends on the value of the SUPERGLOBAL
variable $_SESSION['Display_Size']
*/
    IF (EMPTY($BGC)) {
        $BGC = "#cdf8f8";
    }
    IF (EMPTY($FGC)) {
        $FGC = "BLUE";
    }
    ?>
   <Td BGCOLOR="<?=$BGC;?>">&nbsp</Td>
   <Td BGCOLOR="<?=$BGC;?>" ALIGN="right" VALIGN="top" valign=center><Font COLOR="<?=$FGC;?>">
   <?php
    // filesize
    $DATO=$_SESSION['Numbytes'][$NODE];
    If ($DATO > 0) {
        switch ($_SESSION['Display_Size']) {
            case 4:
                 if ($_SESSION['Folder_Type'][$NODE]=="File"){
                    if ($_SESSION['Maxfilesize']>0){
                        $Y = (($DATO * 100) / $_SESSION['Numbytes'][0]);
                        ECHO "</Font><Font COLOR='RED'>";
                    }
                }else{
                    if ($_SESSION['Maxfoldersize']>0){
                        $Y = (($DATO * 100) / $_SESSION['Numbytes'][0]);
                        ECHO "</Font><Font COLOR='BLACK'>";
                    }
                }
                ECHO NUMBER_FORMAT($Y, 4, ',', '.')."</FONT>";
                $DES_BYTES = "%";
                break;
            case 3:
                if ($_SESSION['Folder_Type'][$NODE]=="File"){
                    if ($_SESSION['Maxfilesize']>0){
                        $Y = INTVAL((($DATO * ((800/$_SESSION['Width'])*40)) / $_SESSION['Maxfilesize']));
                        ECHO "</Font><Font COLOR='RED'>";
                    }
                }else{
                    if ($_SESSION['Maxfoldersize']>0){
                        $Y = INTVAL((($DATO * ((800/$_SESSION['Width'])*40)) / $_SESSION['Maxfoldersize']));
                        ECHO "</Font><Font COLOR='BLACK'>";
                    }
                }
                IF ($NODE!=0){
                    ECHO STR_REPEAT(chr(124), $Y)."</FONT>";
                }ELSE{
                    ECHO "&nbsp"."</FONT>";
                }
                $DES_BYTES = "";
                break;
            case 2:
                ECHO NUMBER_FORMAT(($DATO / (1024 * 1024)), 2, ',', '.');
                $DES_BYTES = "mb";
                break;
            case 1:
                ECHO NUMBER_FORMAT(($DATO / 1024), 1, ',', '.') ;
                $DES_BYTES = "kb";
                break;
            default:
                Echo NUMBER_FORMAT($DATO, 0, ',', '.');
                $DES_BYTES = "bytes";
        } // switch
    } Else {
        Echo "&nbsp";
        $DES_BYTES = "";
    }
    ?>
   </Td>
   <Td BGCOLOR="<?=$BGC;
    ?>">&nbsp</Td>
   <Td BGCOLOR="<?=$BGC;?>" ALIGN="left" valign=top><Font COLOR="<?=$FGC;?>"><?=$DES_BYTES;?></Td>
   <Td BGCOLOR="<?=$BGC;?>" ALIGN="right"><Font COLOR="<?=$FGC;?>">&nbsp</Td>
   <?php
} //end function

Function COLUMN_DATE($NODE, $BGC, $FGC) {
/*
This function write the data in the column filedate of the dirtreeview table.
*/
    IF (EMPTY($BGC)) {
        $BGC = "ANTIQUEWHITE";
    }
    IF (EMPTY($FGC)) {
        $FGC = "RED";
    }
    ?>
        <Td BGCOLOR="<?=$BGC;?>">&nbsp</Td>
        <Td BGCOLOR="<?=$BGC;?>" ALIGN="right" VALIGN="top"><Font COLOR="<?=$FGC;?>">
   <?php
    If ($NODE != 0 ) {
        //file date
       if (is_long($_SESSION['File_Date'][$NODE]))
	   	echo (DATE("d/m/y H:i", $_SESSION['File_Date'][$NODE])) ;
    } Else {
        Echo "&nbsp";
    }
    ?>
        </Td>
        <Td BGCOLOR="<?=$BGC;
    ?>">&nbsp</Td>
   </Tr>
   <?php
} //end function

Function TABLEDIR_FOOTER($BGC, $FGC) {
/*
This function write the data in the footer of the dirtreeview table.
*/
    IF (EMPTY($BGC)) {
        $BGC = "MAROON";
    }
    IF (EMPTY($FGC)) {
        $FGC = "WHITE";
    }
    ?>
        <Tr BGCOLOR="<?=$BGC;?>" ALIGN="center" VALIGN="top">
            <Td COLSPAN="14"><B><I><Font COLOR="<?=$FGC;?>">This page has been created in <?= NUMBER_FORMAT($_SESSION['Total_Time'], 2, ',', '.');?> seconds</Td>
        </Tr>
    </Table>
    <Br>
    <?php
} //end function

Function PAGE_FOOTER($BGC, $FGC) {
//Modificado Guilda Ascencio
global $arrHttp;

/*
This function write the data in the footer of any web html page.
*/

    IF (EMPTY($BGC)) {
        $BGC = "BLUE";
    }
    IF (EMPTY($FGC)) {
        $FGC = "WHITE";
    }
//Modificado Guilda Ascencio
	echo "</div></div>\n";
	if (isset($arrHttp["encabezado"])) include("../common/footer.php");
	echo "
    </Body>
</Html>";
} //end function

Function LOGIN($TEXTO) {
/*
This function build the form to capture the data for the user access.
*/
    PAGE_HEADER("DIRTREEVIEW", "LOGIN ACCESS PROCESS", "#006699", "WHITE");
    ?>
   <Table WIDTH="100%" BORDER="0" CELLPADDING="0" CELLSPACING="0" bgcolor="olive" class=td>
        <Tr>
            <Td VALIGN="top" ALIGN="left">
                <Center>
                <Font FACE="tahoma">
                <H3><?= $TEXTO ?></H3>
                <Form METHOD="post" ACTION="<?= $_SERVER['PHP_SELF'];?>">
                    <Table ALIGN="center" BORDER="0" class=td>
                        <Tr>
                            <Td align="left" VALIGN="baseline"><H3>Username :</H3></Td>
                            <Td align="left" VALIGN="top"><Input TYPE="text" NAME="username" SIZE="50" VALUE=""></Td>
                        </Tr>
                         <Tr>
                            <Td align="left" VALIGN="baseline"><H3>Password :</H3></Td>
                            <Td align="left" VALIGN="top"><Input TYPE="password" NAME="password" SIZE="50" VALUE=""></Td>
                        </Tr>
                        <Tr>
                            <td></td><Td><Center><Input TYPE="Submit" NAME="login" VALUE="   LOGIN  "></center></Td>
                        </Tr>
                    </Table>
                </Form>
                </FONT>
                </CENTER>
            </Td>
        </Tr>
   </Table>
   <?php
    PAGE_FOOTER("#006699", "WHITE");
    Exit;
} //end function
Function LOGOUT() {
/*
This function build the form to logout of the session "autentified".
*/

    PAGE_HEADER("LOGOUT - DIRTREEVIEW", "START A NEW SESSION", "", "");
    ?>
   <Table WIDTH="100%" BORDER="0" CELLPADDING="0" CELLSPACING="0" class=td>
        <Tr>
            <Td VALIGN="top" ALIGN="left">
                <Center>
                <Font FACE="tahoma">
                <H2> ! IMPORTANT ¡</H2>
                <H3> The current session has been Cancelled </H3>
                <H3> Click on the LOGOUT button to CONTINUE and start a new session.</H3>
                <Form NAME="LOGOUT" METHOD="post" ENCTYPE="multipart/form-data" ACTION="<?= $_SERVER['PHP_SELF'];?>">
                <?php //SESSION_DESTROY();?>
                    <Table ALIGN="center" BORDER="0" class=td>
                         <Tr></Tr>
                        <Tr>
                             <Td><Input TYPE="Submit" NAME="LOGOUT" VALUE="    LOGOUT   "></Td>
                        </Tr>
                    </Table>
                </Form>
                </Font>
                </CENTER>
            </Td>
        </Tr>
   </Table>
   <?php
    PAGE_FOOTER("", "");
    Exit;
} //end function

Function INIT_DIR() {
/*
This function build the form to choose the root dir for the treeview process.
*/
    PAGE_HEADER("DIRTREEVIEW", "SET THE SERVER DIRECTORY TO USE", "#006699", "WHITE");
    ?>
   <Table WIDTH="100%" BORDER="0" CELLPADDING="0" CELLSPACING="0" bgcolor="olive" class=td>
        <Tr>
            <Td VALIGN="top" ALIGN="left">
                <Center>
                <Font FACE="tahoma">
                <H3> Set the name of the server Directory</H3>
                <Form METHOD="post" ACTION="dirtree.php">
                <input type=hidden name=base value=<?php echo $_REQUEST["base"] ?>>
                    <Table ALIGN="center" BORDER="0" class=td>
                        <Tr>
                            <Td align="left" VALIGN="baseline"><H3>Directory :</H3></Td>
                            <Td align="left" VALIGN="top"><Input TYPE="text" NAME="Server_Path" SIZE="50" VALUE=$db_path."bases"></Td>
                        </Tr>
                        <Tr>
                            <Td></Td><Td><Center><Input TYPE="Submit" NAME="INIDIR" VALUE="   Accept  "></Td>
                        </Tr>
                    </Table>
                </Form>
                </FONT>
                </CENTER>
            </Td>
        </Tr>
   </Table>
   <?php
    PAGE_FOOTER("#006699", "WHITE");
    Exit;
} //end function

Function INIT_VARIABLES() {
/*
This function if for initialitation of SUPERGLOBALS variables.
*/
    Unset($_SESSION['Numfile']); // variable number with the total number of NODEs in the structure
    Unset($_SESSION['Last_Node']); // variable number with the last NODE displayed
    Unset($_SESSION['Levels_Fixed_Path']); // variable number for the levels involved in the server path
    Unset($_SESSION['File_Extension']); // variable string for file filter criteria
    Unset($_SESSION['Total_Time']); // variable number for the totaltime benchmark
    Unset($_SESSION['MaxFileSize']); // variable number for the maximum file size
    Unset($_SESSION['Maxfoldersize']); // variable number for the maximum file folder
    Unset($_SESSION['Size_Bytes']);//variable number of maximum file size to upload
    Unset($_SESSION['Father']); // array of numbers for the parents of the every NODE
    Unset($_SESSION['Children_Files']); // array of numbers with the amount of children files of every folder NODE
    Unset($_SESSION['Children_Subdirs']); // array of numbers with the amount of children subdirs of every folder NODE
    Unset($_SESSION['Level_Tree']); // array of numbers with the level in the estructure of every NODE
    Unset($_SESSION['Last_Level_Node']); // array of numbers for the last NODE in every level
    Unset($_SESSION['Folder_Name']); // array of strings for the name of every NODE
    Unset($_SESSION['Folder_Type']); // array of strings for the type of every NODE
    Unset($_SESSION['Opened_Folder']); // array for status of the every NODE in the structure
    Unset($_SESSION['File_Date']); // array of last dates of every file NODE
    Unset($_SESSION['Numbytes']); // array of numbers for the filesize in bytes of every NODE
} //end function

Function SCREEN_RESOLUTION() {
global $arrHttp,$db_path;
/*
This function build a hidden web html page with javascript included to obtain
the display screen resolution in pixels.
*/
    if (isset($_GET['ACTION'])) {
      $ACTION=$_GET['ACTION'];
    }
    if (!isset($ACTION)) $ACTION="";
    if ((!isset($_SESSION['Width'])) && (!isset($_SESSION['Height'])) || ($ACTION=="refresh")) {
        if ($ACTION=="refresh"){
          unset($_SESSION['Width']);
          unset($_SESSION['Height']);
        }
        if ((isset($_GET['width'])) && (isset($_GET['height']))) {
            // output the geometry variables
            // echo "screen width is: ". $_GET['width'] ."<br />\n";
            // echo "screen height is: ". $_GET['height'] ."<br />\n";
            // echo "Browser: ". $_SERVER['HTTP_USER_AGENT'] . "<br />";
            $_SESSION['Width'] = $_GET['width'];
            $_SESSION['Height'] = $_GET['height'];
        } else {
            // pass the geometry variables
            // (preserve the original query string
            // -- post variables will need to handled differently)
            ?>
            <HTML>
            <TITLE>client screen resolution</TITLE>
            <HEAD>
            <?php
            $encabezado="";
            if (isset($arrHttp["encabezado"])) $encabezado="&encabezado=s";
            echo "<script language='javascript'>\n";
            echo "location.href=\"${_SERVER['PHP_SELF']}?width=\" + screen.width + \"&height=\" + screen.height+ \"".$encabezado."\"\n";
            echo "</script>\n";
            ?>
            </HEAD>
            </HTML>
            <?php
            exit;
        }
    }
} //end function

/*
 +------------------------------------------------------------------------+
 |                                                                        |
 |                   *****************************                        |
 |                   *  M A I N   P R O G R A M  *                        |
 |                   *****************************                        |
 |         see flow diagram at the beginning of this code list            |
 +------------------------------------------------------------------------+
*/
// ELIMINADO POR MI
//SESSION_START();

/*If (Isset($_POST['username'])) {
    // credentials must be checked the first time
    // can be developed a version with a MySql user database with permissions etc
    If ((($_POST['username'] == 'username') && ($_POST['password'] == 'userpassword')) || (($_POST['username'] == 'administrator') && ($_POST['password'] == 'adminpassword'))) {
        $_SESSION['autentified'] = true;
        $_SESSION['user'] = $_POST['username'];
        If ($_SESSION['user'] == 'username') {
//            $_SESSION['privileges'] = 'restricted';
			$_SESSION['privileges'] = 'all';
        } Else {
            $_SESSION['privileges'] = 'all';
        }
    } Else {
        LOGIN ("Username or Password incorrect, try it again...");
        Exit;
    }
}
*/
//MODIFICADO POR MI
$_SESSION['privileges'] = 'all';
If (!Isset($_SESSION['autentified'])) {
   LOGIN("Set the username and password to login");
    Exit;
} else {
    SCREEN_RESOLUTION();
}
If (Isset($_GET['ACTION'])) {
    $ACTION = $_GET['ACTION'];
} Else {
    If (Isset($_POST['ACTION'])) {
        $ACTION = $_POST['ACTION'];
    } Else {
        $ACTION = "";
    }
}

//when $ACTION=="refresh" the function SCREEN_RESOLUTION must be executed to check the display resolution and after that the variable $ACTION is empty again
If (($ACTION == "") || ($ACTION == "filter2") || ($ACTION == "renamefile2") || ($ACTION == "renamedir2") || ($ACTION == "makedir2") || ($ACTION == "makeroot1") || ($ACTION == "upload3")) {
    // RELOAD THE DIR STRUCTURE AGAIN
    // ************************************************************************************************

	If (!Isset($_SESSION['Server_Path'])) {
        If (!Isset($_POST['Server_Path'])) {
            if ($_SESSION['privileges'] == 'all') {
                //administrator
                INIT_DIR();
                Exit();
            } else {
                //normal user
                $_SESSION['Server_Path'] = dirname(realpath($_SERVER['SCRIPT_FILENAME']));
            }
        } Else {
            $_SESSION['Server_Path'] = $_POST['Server_Path'];
        }
    } Else {
        if ($ACTION == "makeroot1") {
            if ($_POST['NODE'] != 0) {
                $I = $_POST['NODE'];
                $DIR_PATH = $_SESSION['Folder_Name'][$I];
                While ($_SESSION['Father'][$I] != 0) {
                    $DIR_PATH = $_SESSION['Folder_Name'][$_SESSION['Father'][$I]] . DIRECTORY_SEPARATOR . $DIR_PATH;
                    $I = $_SESSION['Folder_Name'][$I];
                }
                $DIR_PATH = $_SESSION['Folder_Name'][0] . DIRECTORY_SEPARATOR . $DIR_PATH;
            } Else {
                $DIR_PATH = $_SESSION['Folder_Name'][0];
            }
            $_SESSION['Server_Path'] = DIRNAME($_SESSION['Server_Path']) . DIRECTORY_SEPARATOR . $DIR_PATH;
        }
    }
    $_SESSION['Server_Path'] = STR_REPLACE (CHR(92), DIRECTORY_SEPARATOR, $_SESSION['Server_Path']); //slash unix/windows
    $_SESSION['Server_Path'] = STR_REPLACE (CHR(47), DIRECTORY_SEPARATOR, $_SESSION['Server_Path']);
    $_SESSION['Server_Path'] = str_replace(DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR, $_SESSION['Server_Path']);
    // ************************************************************************************************
    If (!IS_DIR($_SESSION['Server_Path'])) {
        PAGE_HEADER("DIRECTORY TREEVIEW", "ERROR BUSCANDO DIRECTORIO", "", "");
        ?>
                <Form METHOD='post' ACTION='<?= $_SERVER['PHP_SELF'];?>' >
                    <Table ALIGN=center BORDER=0 class=td>
                        <Tr></Tr>
                        <Tr>
                            <Td><Center><H3>Server Path Directory (' <?=$_SESSION['Server_Path'];Unset($_SESSION['Server_Path']);?> ') not exist or not valid, please check </Td>
                        </Tr>
                        <Tr>
                            <Input TYPE="hidden" NAME="ACTION" VALUE="">
                            <Td><Center><Input TYPE="Submit" NAME="INIDIR" VALUE="   Accept  "></Td>
                        </Tr>
                    </Table>
                </Form>
      <?php
        PAGE_FOOTER("", "");
       // SESSION_DESTROY();
        Exit;
    }
    $_SESSION['autentified'] = "refresh"; // set the variable with some value to consecutive calls to dirtree program
    // set variables to measure the time for benchmarck
    // start program chronometer
    $MTIME = MICROTIME();
    $MTIME = EXPLODE(" ", $MTIME);
    $MTIME = $MTIME[1] + $MTIME[0];
    $STARTTIME = $MTIME;
    INIT_VARIABLES();
    // initial values for main variables
    $_SESSION['Numfile'] = -1;
    $_SESSION['Last_Node'] = 0;
    $_SESSION['Levels_Fixed_Path'] = 0;
    $_SESSION['Levels_Fixed_Path'] = SUBSTR_COUNT($_SESSION['Server_Path'], DIRECTORY_SEPARATOR); //level number of the server path
    If (($ACTION == "filter2") || ($ACTION == "makeroot1")) {
        $ACTION = "";
        $_SESSION['Node'] = 0;
    }
    // when come back again recursively from
    // the subroutines (filefilter y upload) with the POST method
    // or the links in the screen with the GET method
    If (Isset($_POST['FILE_EXTENSION'])) {
        $_SESSION['File_Extension'] = STRTOUPPER($_POST['FILE_EXTENSION']);
    } Else {
        If (Isset($_GET['FILE_EXTENSION'])) {
            $_SESSION['File_Extension'] = STRTOUPPER($_GET['FILE_EXTENSION']);
        } Else {
            $_SESSION['File_Extension'] = "";
        }
    }
    // procedure to reading the structure of the hard disc directory using DIR PHP command
    // (could be a DataBase Table using a Query in the next version todo list)
    BUILD_DIRECTORY_TREE($_SESSION['Server_Path'], 0);
    // initialization of php file system functions
    CLEARSTATCACHE();
    // procedure to calculate the total bytes of a folder
    // while checking the $_SESSION['File_Extension'] variable
    DIR_SIZES();
    //STORE_SUPERGLOBAL
    $_SESSION['Display_Size'] = 0; // 0=bytes, 1=kb, 2=mb
    //
} Else {
    // set variables to measure the time for benchmarck
    // start program chronometer
    $MTIME = MICROTIME();
    $MTIME = EXPLODE(" ", $MTIME);
    $MTIME = $MTIME[1] + $MTIME[0];
    $STARTTIME = $MTIME;
    If (!IS_DIR($_SESSION['Server_Path'])) {
        Unset($_SESSION['Server_Path']);
        PAGE_HEADER("DIRECTORY TREEVIEW", "ERROR BUSCANDO DIRECTORIO", "", "");
        ?>
                <Form METHOD="post" ACTION="<?= $_SERVER['PHP_SELF'];?>">
                    <Table ALIGN=center BORDER=0 class=td>
                        <Tr></Tr>
                        <Tr>
                            <Td><Center><H3>Server Path Directory ("<?= $_SESSION['Server_Path'];?> ") not exist or not valid, please check </Td>>
                        </Tr>
                        <Tr>
                            <Td><Center><Input TYPE="Submit" NAME="INIDIR" VALUE="   Accept  "></Td>
                        </Tr>
                    </Table>
                </Form>
      <?php
        PAGE_FOOTER("", "");
        Exit;
    }
    If (Isset($_POST['NODE'])) {
        $_SESSION['Last_Node'] = $_POST['NODE'];
        $_SESSION['Node'] = $_POST['NODE'];
    } Else {
        If (Isset($_GET['NODE'])) {
            $_SESSION['Last_Node'] = $_GET['NODE'];
            $_SESSION['Node'] = $_GET['NODE'];
        } Else {
            $_SESSION['Last_Node'] = 0;
            $_SESSION['Node'] = 0;
        }
    }
}
/*
 =============================================================================
                                    Action CARROUSEL
 =============================================================================
*/
if ($ACTION!="downloadfile1"){
?>
<script>
function VerArchivo(Arch){
	msgwin=window.open("leerarchivotxt.php?archivo="+Arch,"","")
	msgwin.focus()
}
</script>
<?
}
Switch ($ACTION) {
    Case "expand"       : EXPAND($_SESSION['Node']); Break;
    Case "expandall"    : For ($I = 1 ; ($I <= $_SESSION['Numfile']) ; $I++) {$_SESSION['Opened_Folder'][$I] = 1;} Break;
    Case "collapse"     : COLLAPSE($_SESSION['Node']); Break;
    Case "collapseall"  : For ($I = 1;$I <= $_SESSION['Numfile'];$I++) {$_SESSION['Opened_Folder'][$I] = 0;} Break;
    Case "downloadfile" : $ACTION = ""; DOWNLOAD($_SESSION['Node']); Break;
    Case "downloadfile1": $ACTION = ""; DOWNLOAD1($_SESSION['Node']); Break;
    Case "dirfunction"  : $ACTION = ""; DIR_FUNCTIONS($_SESSION['Node']); Break; //select a Dir Function to process
    Case "filefunction" : $ACTION = ""; FILE_FUNCTIONS($_SESSION['Node']); Break; //select a File Function to process
    Case "makedir"      : $ACTION = ""; MAKEDIR($_SESSION['Node']); Break; //write the name of the new directory
    Case "makedir1"     : $ACTION = ""; If (Isset($_POST['MAKE_DIR'])) {MAKEDIR1($_POST['MAKE_DIR']);} Break; //to create the new directory
    Case "makedir2"     : $ACTION = ""; EXPAND($_SESSION['Node']); Break; // if the full process gone well
    Case "renamedir"    : $ACTION = ""; RENAMEDIR($_SESSION['Node']); Break; //write the name of the new directory
    Case "renamedir1"   : $ACTION = ""; If (Isset($_POST['RENAME_DIR'])) {RENAMEDIR1($_POST['RENAME_DIR']);} Break; //to rename the directory
    Case "renamedir2"   : $ACTION = ""; EXPAND($_SESSION['Node']); Break; // if the full process gone well
    Case "removedir"    : $ACTION = ""; REMOVEDIR($_SESSION['Node']); Break; // confirm the operation
    Case "removedir1"   : $ACTION = ""; REMOVEDIR1(); Break; // erase dir and subdirs
    Case "renamefile"   : $ACTION = ""; RENAMEFILE($_SESSION['Node']); Break; // write the new filename
    Case "renamefile1"  : $ACTION = ""; If (Isset($_POST['RENAME_FILE'])) {RENAMEFILE1($_POST['RENAME_FILE']);} Break; //to rename the file
    Case "renamefile2"  : $ACTION = ""; EXPAND($_SESSION['Node']); Break; // if the full process gone well
    Case "upload"       : $ACTION = ""; $_SESSION['Size_Bytes'] = 15000000; UPLOAD($_SESSION['Node']); Break; // first: choose the file to upload
    Case "upload2"      : $ACTION = ""; $_SESSION['Size_Bytes'] = 15000000; UPLOAD2($_SESSION['Node']); Break; // SECOND: CHECK the full process
    Case "upload3"      : $ACTION = ""; EXPAND($_SESSION['Node']); Break; // third : has been uploaded successfully
    Case "filter"       : $ACTION = ""; FILTERFILE(); Break; // choose the file filter extension criteria
    Case "logout"       : $ACTION = ""; LOGOUT(); Break; // to exit and start session with other user
    Case "emailfile"    : $ACTION = ""; EMAILFILE($_SESSION['Node']); Break;
    Case "emailfile1"   : $ACTION = ""; EMAILFILE1($_SESSION['Node']); Break;
    Case "erasefile"    : $ACTION = ""; ERASEFILE($_SESSION['Node']); Break;
    Case "erasefile1"   : $ACTION = ""; ERASEFILE1($_SESSION['Node']); Break;
    Case "compressfile" : $ACTION = ""; COMPRESSFILE($_SESSION['Node']); Break;
    Case "compressfile1": $ACTION = ""; COMPRESSFILE1($_SESSION['Node']); Break;
    Case "makeroot"     : $ACTION = ""; CHANGE_ROOTDIR($_SESSION['Node']); Break;
    Case "listzipfile"  : $ACTION = ""; LIST_ZIP($_SESSION['Node']); Break;
    Case "size"         : $ACTION = ""; $_SESSION['Display_Size']++; if ($_SESSION['Display_Size'] > 4) {$_SESSION['Display_Size'] = 0;}  Break;
    Default             : $_SESSION['Node'] = 0; $_SESSION['Opened_Folder'][0] = 1;
}
//BUILDING THE FINAL RESULT - THE WEB HTML PAGE
PAGEDIR_HEADER("DIRTREEVIEW", "DIRTREEVIEW - FILE MANAGER", "", ""); // finally create html code to build the page
TABLEDIR_HEADER("#cccccc", ""); // table above the treeview
TABLEDIR_SUBHEADER("", ""); // building the table to show the treeview
// following lines to display the first row only for the root
COLUMN_FOLDER(0, "", "");
COLUMN_FILES(0, "", "");
COLUMN_FILENAMES_ROOT("", "");
COLUMN_SIZE(0, "", "");
COLUMN_DATE(0, "", "");
DISPLAY_TREE(); // calling the function to show the dir treeview.
// finish the benchmark
$MTIME = MICROTIME();
$MTIME = EXPLODE(" ", $MTIME);
$MTIME = $MTIME[1] + $MTIME[0];
$ENDTIME = $MTIME;
$_SESSION['Total_Time'] = ($ENDTIME - $STARTTIME);
TABLEDIR_FOOTER("black", "yellow"); //table below the treeview
PAGE_FOOTER("", ""); //finish the web page
?>
