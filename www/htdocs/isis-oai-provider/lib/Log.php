<?php

define('LOG_SEPARATOR', ";");

class Log
{
    /**
     * @var String 
     * @desc Path do diretorio de logs com permissao de gravacao para usuario web
     */    
    var $directory;
    /**
     * @var String
     * @desc Nome do arquivo de log
     */  
    var $fileName;  
    
    var $fields  = Array();
    /**
     * @var Array
     * @desc Campos de informacao do log
     */  
    
    /**
     * @desc constructor
     */
    function log()
    {
        $this->setDirectory();
        if (defined('LOG_FILE')) {
            $this->setFileName(LOG_FILE);
        }

    }    
    /**
     * @desc metodo que seta o diretorio onde os logs deveram ser escritos
     * @param string LOG_DIR constante definida como o path para o dir de logs
     */ 
    function setDirectory() 
    {
        if (!defined('LOG_DIR')) {
            define('LOG_DIR', realpath( dirname(__FILE__) . "/../logs") . "/");
        }
        if ( is_dir(LOG_DIR) ){
            $this->directory = LOG_DIR;
        }else{
            if ( $this->mkdirs(LOG_DIR,0775) ){
                $this->directory = LOG_DIR;
            }else{
                $this->logError("Unable to create directory " . LOG_DIR);
            }   
        }   
    }
    /**
     * @desc metodo que define o nome do arquivo e log
     * @param string $fileName nome do arquivo de log
     */
    function setFileName($fileName)
    {
        $this->fileName = $fileName;
    }
    /**
     * @desc cria arquivo no diretorio especificado ou abre arquivo se ja tiver sido criado
     * @param string
     */
    function openFileWriter()
    {
        if ( is_file($this->directory . $this->fileName) ){
            $fp = @fopen ($this->directory . $this->fileName, "a+b");
        }else{
            $fp = @fopen ($this->directory . $this->fileName, "a+b");
            $head = "date" . LOG_SEPARATOR . implode(LOG_SEPARATOR, array_keys($this->fields)) . "\r\n";
            @chmod($this->directory . $this->fileName,0764);
            @fwrite($fp, $head);
        }
        
        if ($fp){
            return $fp;
        }else{
            $this->logError("Unable to open log file " . LOG_DIR . $this->fileName);
        }
    }
    /**
     * @desc grava no arquivo de log
     */  
    function writeLog()
    {

        $fp = $this->openFileWriter($this->directory,$this->fileName);
        $logLine = implode(LOG_SEPARATOR, $this->fields);

        $logInfo = date("Y-m-d H:i:s") . LOG_SEPARATOR . $logLine ."\r\n";
        if (!@fwrite($fp, $logInfo)){
            $this->logError("Unable to write log file " . LOG_DIR . $this->fileName);
        }else{
            fclose($fp);
        }   
    }

    /**
     * @desc le arquivo e coloca em um array
     */
    function readLog(){
        $text = file($this->directory.$this->fileName);
        //recupera array retirado do arquivo
        foreach ($text as $num_linha=>$linha) {
            $leitura.= $linha;
        }
        echo '<textarea name="textareaLog" rows="30" cols="120">'.$leitura.'</textarea>';
    }

    /**
     * @desc adiciona log de erro
     */
    function logError($message)
    {   

        $fp = @fopen ($this->directory . "logerror.txt", "a+b");
        if ( !$fp ){
            error_log ("Unable to open log file for update " . LOG_DIR . "logerror.txt");
        }else{  
            if ( !fwrite($fp, date("Y-m-d H:i:s") . LOG_SEPARATOR . $message . "\r\n") ){  
                error_log ("Unable to write in log file " . $this->directory . "logerror.txt");
            }else{
                error_log ("Log error message: " . $message);
            }
        }
        return;
    }
    

    function mkdirs($strPath, $mode = "0775")
    {
        if ( is_dir($strPath) ) {
            return true;
        }   
        $pStrPath = dirname($strPath);
        if ( ! $this->mkdirs($pStrPath, $mode) ){
             return false;
        }    
        $old_umask = umask(0);
        $mk = @mkdir($strPath, $mode);
        umask($old_umask);
        return $mk;
    }

    /**
     * @desc log de acessos ao ADM
     */
    function logAccess()
    {
        $this->setFileName("access_log.txt");
        $ip   = getenv(REMOTE_ADDR); //guarda o endereco ip do host
        $host = gethostbyaddr($ip); //guarda o mome do host
        $text = "[".date('d/m/Y h:i:s')."] - $host;$ip;$data\n";
        $this->writeFile($text);
    }
}
?>