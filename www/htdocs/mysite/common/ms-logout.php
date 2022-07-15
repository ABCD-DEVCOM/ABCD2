<?php
session_start();
require_once "../../central/config.php";


if (isset($_SESSION["HOME"]))
	$retorno=$_SESSION["HOME"];
else
	$retorno="/mysite";
$_SESSION=array();
unset($_SESSION);
session_unset();
session_destroy();
?>
<script>
	top.window.location.href="<?php echo $retorno?>";
</script>

      <script>
       
            function WriteCookie() {
               var now = new Date();
               now.setMonth( now.getMonth() - 1 );
               cookievalue = escape(document.myform.customer.value) + ";"

               document.cookie="name=" + cookievalue;
               document.cookie = "expires=" + now.toUTCString() + ";"
               document.write("Setting Cookies : " + "name=" + cookievalue );
            }
         
      </script>