<?php
error_reporting(0);
session_start();
if (isset($_SESSION["lang"]))

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
echo "<br><br><dd><h1>".$msgstr["sessionexpired"]."</h1>";
?>

</center>
</div>
</div>
<?php include("footer.php")?>
</body>
</html>
