<?php

class sessionManager
{
   	
    function _construct()
    {
    }

    function sessionManager()
    {
            session_start();
    }
   		
    function checkLogin($milogin, $password, $selLibrary)
    {

        $misusuarios = new users();
        $usuario = $misusuarios->searchByLogin($milogin);

        if (is_null($usuario)) {
            return "Error1";
        }elseif($selLibrary == ""){
             return "Error3";
        }else{

            if ($usuario->getPassword() == md5($password)) {

                $dataModelLib = new library();
                $libraryName = $dataModelLib->searchByParam($selLibrary, "2");
                $allRoles = $usuario->getRole();
                $userRole = array($allRoles[0]->contenido);
                for ($i=1; $i<count($allRoles); $i++) {
                    array_push($userRole, $allRoles[$i]->contenido);
                }
                
                list($allAvailableLibrariesName, $allAvailableLibrariesDir) = getAllLibraries();

                if ($allRoles[0]->contenido == "Administrator"){

                    $_SESSION["optLibrary"] = $allAvailableLibrariesName;
                    $_SESSION["optLibraryDir"] = $allAvailableLibrariesDir;
                    
                }else{
                    
                    $allLibraryDir = $usuario->getLibDir();
                    $allLibrariesDir = array($allLibraryDir[0]->contenido);
                    for ($i=1; $i<count($allLibraryDir); $i++){
                        array_push($allLibrariesDir, $allLibraryDir[$i]->contenido);
                    }
                    $key = array_search($selLibrary, $allLibrariesDir);

                    $keyName = array_search($allLibrariesDir[0], $allAvailableLibrariesDir);
                    $allLibrariesName = array($allAvailableLibrariesName[$keyName]);
                    for ($i=1; $i<count($allLibrariesDir); $i++){
                         $keyName = array_search($allLibrariesDir[$i], $allAvailableLibrariesDir);
                         array_push($allLibrariesName, $allAvailableLibrariesName[$keyName]);
                    }
                    
                    switch (is_numeric($key)) {
                        case true:
                            $_SESSION["optLibrary"] = $allLibrariesName; 
                            $_SESSION["optLibraryDir"] = $allLibrariesDir;
                            break;
                        case false:
                            return "Error2";
                            break;
                    }
                    
                }
                
                $_SESSION["library"] = $libraryName; //nome da biblioteca em uso
                $_SESSION["libraryDir"] = $selLibrary; //diretorio em uso, e´ a sigla da biblioteca
                $_SESSION["role"] = $allRoles[0]->contenido; //perfil do usuario
                $_SESSION["optRole"] = $userRole; //todos os perfils disponivel para o usuario
                $_SESSION["identified"] = "1";
                $_SESSION["logged"] = $usuario->getuserName();
                $_SESSION["mfn"] = $usuario->getuserId();
                $_SESSION["centerCode"] = $usuario->getCenterCode();
                $_SESSION["ticket"] = time();
                //die;
                if($_GET["lang"]){
                        $_SESSION["lang"]=$_GET["lang"];
                }else{
                        $_SESSION["lang"]=$usuario->getLang();
                }
                return "OK";

            }else{
                return "Error1";
            }
        }
    }
   		
    function destroySession()
    {
            session_start();
            $_SESSION = array();
            session_destroy();
    }

    function checkNormalSession()
    {
        if (isset($_SESSION["id"]))
            return true;
        else
            return false;
    }

    function checkAdministratorSession()
    {
        if (isset($_SESSION["id"]) && isset($_SESSION["administrator"]) && $_SESSION["administrator"]=='1' )
            return true;
        else
            return false;
    }
   	
}

?>