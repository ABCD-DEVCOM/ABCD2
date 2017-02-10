
<?php

function isLdapUser($username,$password, $ldap){
        global $ldap_dn,$ldap_pass,$ldap_search_context;
        
		
        ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION,3);
        ldap_set_option($ldap, LDAP_OPT_REFERRALS,0);
        $attrib = array('dn'); 
       		
		$r=ldap_bind($ldap,$ldap_dn,$ldap_pass);
		
        $ldapget = @ldap_search($ldap,$ldap_search_context,"(uid=$username*)",$attrib);
        $ldapcat = @ldap_get_entries($ldap,$ldapget);
        $candidato = $ldapcat[0]["dn"];	

        if (@ldap_bind($ldap,$candidato,$password)) 
               return true;

        return false;		   
		 
        /*$puerto_ldap = 389;
		$username = 'guest3';
		$attrib = array('cn','sn','givenname','email','dn'); 
		
		$conexion_ldap = ldap_connect("ldap://zflexldap.com", $puerto_ldap);
		
		ldap_set_option($conexion_ldap, LDAP_OPT_PROTOCOL_VERSION,3);
        ldap_set_option($conexion_ldap, LDAP_OPT_REFERRALS,0);
		
		$dn = "cn=ro_admin,ou=sysadmins,dc=zflexsoftware,dc=com";		
		$r=ldap_bind($conexion_ldap,$dn,"zflexpass");
		
		   
	    $ldapget = @ldap_search($conexion_ldap,"ou=guests,dc=zflexsoftware,dc=com","(uid=$username*)",$attrib);
        $ldapcat = @ldap_get_entries($conexion_ldap,$ldapget);
        $candidato = $ldapcat[0]["dn"];
		
	  
	    if (@ldap_bind($conexion_ldap,$candidato,"guest3password")) 
               echo true;exit;
      
		
	
      echo false;exit;*/
	
 }
 
function Auth($username, $password, $adGroupName = false){
    global $ldap_host,$ldap_dn,$ldap_port;  				
	
    $ldap = ldap_connect($ldap_host,$ldap_port);    	
	
    if (!$ldap)
        throw new Exception("Cant connect ldap server, Check in your browser that you have connection to the ldap server", 1);
    
     return isLdapUser($username, $password, $ldap);    
	
}

function Info($username, $password, $adGroupName = false,$attrib){
    global $ldap_host,$ldap_dn,$ldap_port,$ldap_pass,$ldap_search_context;;   	
				
    $ldap = ldap_connect($ldap_host,$ldap_port);    	
	
    if (!$ldap)
        throw new Exception("Cant connect ldap server", 1);	
        
        ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION,3);
        ldap_set_option($ldap, LDAP_OPT_REFERRALS,0);
              		
		$r=ldap_bind($ldap,$ldap_dn,$ldap_pass);
		
        $ldapget = @ldap_search($ldap,$ldap_search_context,"(uid=$username*)",$attrib);
        $ldapcat = @ldap_get_entries($ldap,$ldapget);
       
	   
	   return $ldapcat;
	
}

function Exist($username){
    global $ldap_host,$ldap_port,$ldap_pass,$ldap_dn,$ldap_search_context;
    
    $exist = false;
    $candidato ="";	
    $ldap = ldap_connect($ldap_host,$ldap_port);  
    if (!$ldap)
        throw new Exception("Cant connect ldap server", 1);
		
    ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION,3);
    ldap_set_option($ldap, LDAP_OPT_REFERRALS,0);
 
    
   	
	$attrib = array('dn');	  		
    $r=ldap_bind($ldap,$ldap_dn,$ldap_pass);  
		   
	 $ldapget = @ldap_search($ldap,$ldap_search_context,"(uid=$username*)",$attrib);
     $ldapcat = @ldap_get_entries($ldap,$ldapget);
     $candidato = $ldapcat[0]["dn"];	
	 if($candidato != "")$exist = true; 
	
	return $exist;   		
	
       

}