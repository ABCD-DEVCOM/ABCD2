<?php
error_reporting(0);
session_start();
if (isset($_SESSION["lang"]))
global $server_url;
include("../config.php");
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
         }, 1000);
</script>

</div>
</div>
<?php include("footer.php")?>
</body>
</html>
