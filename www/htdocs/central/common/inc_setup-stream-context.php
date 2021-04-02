<?php
/*
2021-04-02 fho4abcd Created
Function  : Setup of context options (for e.g. file_get_contents)
            Context is used when operations in the server are executed via http/https.
            This setup allows self-signed certificates in server internal calls.
Usage     : <?php include "../common/inc_setup-stream-context.php" ?>
            $result=file_get_contents($wxisUrl,false,$context);

    Input : $postdata: The URL for the request NO DEFAULT
    Output: $context : contains the created context.

The http options specify method, header and content of the request
The ssl options are for https communication and do not harm if http is used
*/
$contextoptsarray =
    array('http' => array( 'method'  => 'POST',
                           'header'  => 'Content-type: application/x-www-form-urlencoded',
                           'content' => $postdata,
                         ),
          'ssl'  => array( 'verify_peer'       => true, // default true
                           'verify_peer_name'  => false,// default true. false required for ss certs
                           'allow_self_signed' => true, // default false.true required for ss certs
                          )
          );
$context = stream_context_create($contextoptsarray);
?>
