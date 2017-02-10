<?php
session_start();
include("get_post.php");
include("header.php");
include("../config.php");
include("../lang/admin.php");
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
