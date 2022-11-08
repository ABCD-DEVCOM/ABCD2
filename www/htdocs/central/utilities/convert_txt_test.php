<?php
/* Modifications
20210525 fho4abcd Created
*/
include("../common/get_post.php");
$file=$arrHttp["file"];
$encoding=$arrHttp["encoding"];
$targetcode=$arrHttp["targetcode"];
include("../config.php");
$charset=$targetcode;
include("../common/header.php");
?>
<body>
<div class="sectionInfo">
    <div class="breadcrumb" style="width:100%">
    <?php echo $targetcode;?><br>
    <?php echo $file?>
    </div>
	<div class="spacer">&#160;</div>
</div>

<div class="middle form">
<hr>
<?php
$contents = file_get_contents($file);
$contents=@mb_convert_encoding($contents,$targetcode,$encoding);
if ($contents===false ) {
    $contents_error= error_get_last();
    if ($contents_error!="") {
        echo "<br><font color=red>".$contents_error["message"]."</font>";
    }
    die;
}

echo nl2br($contents);
?>
<hr>
</div>
</body>
</html>

