<?php
/* modifications
2021-02-25 fh04abcd removed empty line before php tag. (shown before DOCTYPE=non-html). Deleted old comment
*/
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
?>
