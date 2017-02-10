<?php
/**
 * @desc     Class to configure and enabl to access to database
 * @package [SECS-Web] SECS Online
 * @name Erro
 * @version 1.1
 * @author  Domingos Teruel <webmaster@dteruel.com.br>
 * @since create 22 de junho de 2004
 * @since update 28 de janeiro de 2008
 * @copyright  BIREME - PFI - 2008
 * @abstract 
 * @final
 */

class Configurator
{
/**
 * @desc Path to TITLE dababase
 * @var string
 */
var $path2Title = null;
/**
 * @desc Path to USERS database
 * @var string
 */
var $path2Users = null;
/**
 * @desc Path to FACIC database
 * @var string
 */
var $path2Facic = null;
/**
 * @desc Path to MASK dastabase
 * @var string
 */
var $path2Mask = null;
/**
 * @desc Path to HOLDINGS dababase
 * @var string
 */
var $path2Holdings = null;
/**
 * @desc URL to access the Webservice on database system
 * @var string URL
 */
var $path2Titleplus = null;
/**
 * @desc URL to access the Webservice on database system
 * @var string URL
 */
var $path2Library = null;
/**
 * @desc URL to access the Webservice on database system
 * @var string URL
 */
 var $path2TempFacic = null;
/**
 * @desc URL to access the Webservice on database system
 * @var string URL
 */
var $urlws;
/**
 * @desc timeout to connect to WebService response
 * @var int
 */
var $timeout = 1800;
	
function __construct()
{
        global $BVS_CONF;

        if(isset($BVS_CONF['URLWS']) && $BVS_CONF['URLWS'] != "") {
            $this->setUrlWs($BVS_CONF['URLWS']);
        }
        if(isset($BVS_CONF['PATH2TITLE']) && $BVS_CONF['PATH2TITLE'] != "") {
            $this->setPath2Title($BVS_CONF['PATH2TITLE']);
        }
        if(isset($BVS_CONF['PATH2MASK']) && $BVS_CONF['PATH2MASK'] != "") {
            $this->setPath2Mask($BVS_CONF['PATH2MASK']);
        }
        if(isset($BVS_CONF['PATH2USERS']) && $BVS_CONF['PATH2USERS'] != "") {
            $this->setPath2Users($BVS_CONF['PATH2USERS']);
        }
        if(isset($BVS_CONF['PATH2FACIC']) && $BVS_CONF['PATH2FACIC'] != "") {
            $this->setPath2Fasic($BVS_CONF['PATH2FACIC']);
        }
        if(isset($BVS_CONF['PATH2TITLEPLUS']) && $BVS_CONF['PATH2TITLEPLUS'] != "") {
            $this->setPath2Titleplus($BVS_CONF['PATH2TITLEPLUS']);
        }
        if(isset($BVS_CONF['PATH2HOLDINGS']) && $BVS_CONF['PATH2HOLDINGS'] != "") {
            $this->setPath2Holdings($BVS_CONF['PATH2HOLDINGS']);
        }
        if(isset($BVS_CONF['PATH2LIBRARY']) && $BVS_CONF['PATH2LIBRARY'] != "") {
            $this->setPath2Library($BVS_CONF['PATH2LIBRARY']);
        }
        if(isset($BVS_CONF['PATH2TEMPFACIC']) && $BVS_CONF['PATH2TEMPFACIC'] != "") {
            $this->setPath2TempFasic($BVS_CONF['PATH2TEMPFACIC']);
        }
}
	
	function setUrlWs($urlws) {
		$this->urlws = $urlws;		
	}
	function setPath2Mask($path2Mask){
		$this->path2Mask = $path2Mask;
	}
	function setPath2Users($path2Users){
		$this->path2Users = $path2Users;
	}
	function setPath2Fasic($path2Facic){
		$this->path2Facic = $path2Facic;
	}
	function setPath2Title($path2Title){
		$this->path2Title = $path2Title;
	}
	function setPath2Holdings($path2Holdings){
		$this->path2Holdings = $path2Holdings;
	}
	function setPath2Titleplus($path2Titleplus){
		$this->path2Titleplus = $path2Titleplus;
	}
	function setPath2Library($path2Library){
		$this->path2Library = $path2Library;
	}
	function setPath2TempFasic($path2TempFacic){
		$this->path2TempFacic = $path2TempFacic;
	}
	function getUrlWs(){		
		return $this->urlws;
	}
	function getPath2Users(){
		return $this->path2Users;
	}
	function getPath2Facic(){
		return $this->path2Facic;
	}
	function getPath2Mask(){
		return $this->path2Mask;
	}
	function getPath2Title(){
		return $this->path2Title;
	}
	function getPath2Holdings(){
		return $this->path2Holdings;
	}
	function getPath2Titleplus(){
		return $this->path2Titleplus;
	}
	function getPath2Library(){
		return $this->path2Library;
	}
	function getPath2TempFacic(){
		return $this->path2TempFacic;
	}
        function getTimeOut(){
		return $this->timeout;
	}

}

?>