<?
/**
 * @desc Class for Upload files
 * @package 
 * @version 1.2
 * @author  Domingos Teruel <domingosteruel@terra.com.br>
 * @since 09 de junho de 2004
 * @copyright  BIREME - SCI - 2004
 * @public  
 */
class upload 
{
    /**
     * @var string
     * @desc name of file
     */ 
    var $the_file;
    /**
     * @var string
     * @desc the temp name of file uoloaded
     */
    var $the_temp_file;
    /**
     * @var string
     * @desc directory of uploaded files
     */
    var $upload_dir;
    /**
     * @var bool
     * @desc replace the file case exist
     */
    var $replace = 'y';
    /**
     * @var bool
     * @desc check the name file
     */    
    var $do_filename_check = 'y';
    /**
     * @var integer
     * @desc length max of the name of file
     */
    var $max_length_filename = 100;
    /**
     * @var string
     * @desc extensions allowed to upload
     */
    var $extensions;
    var $ext_string;
    /**
     * @var string
     * @desc http error message
     */
    var $http_error;
    /**
     * @var string
     * @desc messages process of upload
     */
    var $message = array();
    /**
     * @desc constructor
     */
    function upload() {        
        $this->setInit();        
        $this->setUploadDir($_REQUEST["idnews"]);
        $this->message[] = $this->error_text(10); 
        echo $this->the_temp_file;       
    }
    /**
     * @desc init the process of upload
     */
    function setInit()
    {
        global $BVS_LANG,$BVS_CONF;
        $this->extensions = $BVS_CONF['allow_ext'];
        $this->ext_string = $BVS_LANG['allow_ext_str'];
        //$this->upload_dir = $BVS_CONF["upload_dir"] . "/";
    }
    /**
     * @desc metodo que verifica se existe o diret�rio do id passado
     *          se nao existir ele cria
     * @param int $id
     * @return bool
     */
    function setUploadDir($id)
    {
        global $BVS_CONF;
        
        if(is_dir($BVS_CONF["upload_dir"] . "/" . $id . "/") == true)
        {
            $this->upload_dir = $BVS_CONF["upload_dir"] . "/" . $id . "/";
        }else {
            if( mkdir($this->upload_dir = $BVS_CONF["upload_dir"] . "/" . $id,0700) )
            {
                $this->upload_dir = $BVS_CONF["upload_dir"] . "/" . $id . "/";
            }
        }
    }
    /**
      * @desc some error (HTTP)reporting, change the messages or remove options if you like.
      * @param int the number of erro
      * @return string the message of erro
      */
    function error_text($err_num) {
        switch ($this->language) {
            case "de":
            // add you translations here
            break;
            default:
            // start http errors
            $error[0] = "File: <b>".$this->the_file."</b> successfully uploaded!";
            $error[1] = "The uploaded file exceeds the max. upload filesize directive in the server configuration.";
            $error[2] = "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the html form.";
            $error[3] = "The uploaded file was only partially uploaded";
            $error[4] = "No file was uploaded";
            // end  http errors
            $error[10] = "Please select a file for upload.";
            $error[11] = "Only files with the following extensions are allowed: <b>".$this->ext_string."</b>";
            $error[12] = "Sorry, the filename contains invalid characters. Use only alphanumerical chars and separate parts of the name (if needed) with an underscore. A valid filename ends with one dot followed by the extension.";
            $error[13] = "The filename exceeds the maximum length of ".$this->max_length_filename." characters.";
            $error[14] = "Sorry, the upload directory doesn't exist!";
            $error[15] = "Uploading <b>".$this->the_file."...Error!</b> Sorry, a file with this name already exitst.";
            
        }
        return $error[$err_num];
    }
    /**
     * @desc view the messages erro
     * @return string
     */
    function show_error_string() {
        $msg_string = "";
        foreach ($this->message as $value) {
            $msg_string .= $value."<br>n";
        }
        return $msg_string;
    }
    /**
     * @desc method for upload file
     * @return bool
     */
    function doUpload() {
        if ($this->check_file_name()) {
            if ($this->validateExtension()) {
                if (is_uploaded_file($this->the_temp_file)) {
                    if ($this->move_upload($this->the_temp_file, $this->the_file)) {
                        $this->message[] = $this->error_text($this->http_error);
                        return true;
                    }
                } else {
                    $this->message[] = $this->error_text($this->http_error);
                    user_error($this->error_text($this->http_error),E_USER_ERROR);
                    return false;
                }
            } else {
                $this->show_extensions();
                $this->message[] = $this->error_text(11);
                user_error($this->error_text(11),E_USER_ERROR);
                return false;
            }
        } else {
            return false;
        }
    }
    /**
     * @desc this method verify if filename is allowed
     * @param string name of file
     * @return bool
     */
    function check_file_name() 
    {
        if ($this->the_file != "") {
            if (strlen($this->the_file) > $this->max_length_filename) {
                $this->message[] = $this->error_text(13);
                return false;
            } else {
                if ($this->do_filename_check == "y") {
                    if (ereg("^[a-zA-z0-9_]*.[a-zA-az]{3,4}$", $this->the_file)) {
                        return true;
                    } else {
                        $this->message[] = $this->error_text(12);
                        user_error($this->error_text(12),E_USER_ERROR);
                        return false;
                    }
                } else {
                    return true;
                }
            }
        } else {
            $this->message[] = $this->error_text(10);
            user_error($this->error_text(10),E_USER_ERROR);
            return false;
        }
    }
    /**
     * @desc this method verify the extesion is allowed in this system
     * @param string name of file
     * @return bool
     */
    function validateExtension() 
    {
        $extension = strtolower(strrchr($this->the_file,"."));
        $ext_array = $this->extensions;
        if (in_array($extension, $ext_array)) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * @desc this method is only used for detailed error reporting
     */
    function show_extensions() 
    {
        $this->ext_string = implode(" ", $this->extensions);
    }
    /**
     * @desc this method move the file from tem dir to upload dir
     * @return bool
     */
    function move_upload() 
    {
        umask(0);
        if ($this->existing_file()) {
            $newfile = $this->upload_dir.$this->the_file;
            if ($this->check_dir()) {
                if (move_uploaded_file($this->the_temp_file, $newfile)) {
                    if ($this->replace == "y") {
                        system("chmod 0777 $newfile");
                    } else {
                        system("chmod 0755 $newfile");
                    }
                    return true;
                } else {
                    return false;
                }
            } else {
                $this->message[] = $this->error_text(14);
                user_error($this->error_text(14),E_USER_ERROR);
                return false;
            }
        } else {
            $this->message[] = $this->error_text(15);
            user_error($this->error_text(15),E_USER_ERROR);
            return false;
        }
    }
    /**
     * @desc verify the path uplod dir is a dir
     * @param string path to upload dir
     * @return bool
     */
    function check_dir() 
    {
        if (!is_dir($this->upload_dir)) {
            return false;
        } else {
            return true;
        }
    }
    /**
     * @desc method that verifies if the file exists to be increased
     * @param bool replace is allowed?
     * @param string upload_dir the path of upload dir
     * @param  string name of file
     * @return bool
     */
    function existing_file() 
    {
        if ($this->replace == "y") {
            return true;
        } else {
            if (file_exists($this->upload_dir.$this->the_file)) {
                return false;
            } else {
                return true;
            }
        }
    }
}
?>