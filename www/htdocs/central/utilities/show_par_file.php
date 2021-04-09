<?php
/*
** 20210405 fho4abcd Created
** Function: Lists the content of file given by parameter 'par_file'
**           No check if file exists: done by caller
** Example : show_parfile.php?par_file=/var/www/abcd22/www/bases/par/fredstest_unicode.par
*/
include("../common/get_post.php");
include("../config.php");
include("../common/header.php");
$par_file=$arrHttp["par_file"];
?>
<div class="sectionInfo">
<h3 align="center"><?php echo "Database parameter file = <br>".$par_file;?></h3>

<div class="middle form">
<div  style='margin-left: 10px'>
<br>
<?php
$handle = fopen($par_file, "r");
if ($handle) {
    while (($buffer = fgets($handle)) !== false) {
        echo $buffer."<br>";
    }
    fclose($handle);
}
?>
</div>
</div>
