<?php
/* Modifications
20240624 fho4abcd Exit at end of script, improve html, timeout from 1->2 seconds
*/
error_reporting(0);
session_start();
include("../config.php");// sets server_url
include("get_post.php");

include("../lang/admin.php");
include("header.php");
include("institutional_info.php"); 

?>
<body>
<div class="middle form">
	<div class="formContent">
	<center>
<?php

echo "Return to ".$server_url;
echo "<br><br><dd><h1>".$msgstr["sessionexpired"]."</h1>";
?>

</center>
<script type="text/javascript">
	setTimeout(function(){
            top.location.href = '<?php echo $server_url ?>';
         }, 2000);
</script>

</div>
</div>
<?php
include("footer.php");
exit();
?>
