<?php
/* Modifications
20240624 fho4abcd Created with 2 functions to process gizmo databases
*/
/*--------------------------------------------------------------
** Function  : Show picklist of gizmo's as part of a form
** Usage     : include "inc_select_gizmo.php";
**             select_gizmo($option)
** Parameters: - $option=0  : Show picklist without blank line. Select name=gizmo0
**               $option>0  : Show picklist with blank line. Select name=gizmo$option
** Returns   : 0 : no errors occured.
*/
function select_gizmo($option) {
    global $msgstr,$base,$db_path;
	?>
	<select name='gizmo<?php echo $option?>'>
		<?php
		if ($option!="0") echo "<option value=''></option>";
		$fulldbpath=$db_path.$base."/data";
		$handle=opendir($fulldbpath);
		$extension="mst";
		while ($file = readdir($handle)) {
			$path_parts = pathinfo($file);
			if ($path_parts['extension']==$extension || $path_parts['extension']==strtoupper($extension)) {
				$gizmo=$path_parts['filename'];
				if ($gizmo!=$base && $gizmo!=strtoupper($base)){
					echo "<option value='$gizmo'>$gizmo</option>";
				}
			}
		}
		?>
	</select>
	<?php
	return(0);
}
/*--------------------------------------------------------------
** Function  : Count gizmo's in the current databas
** Usage     : include "inc_select_gizmo.php";
**             count_gizmo($numgizmos)
** Parameters: - $numgizos  : Number of gizmos found
** Returns   : 0 : no errors occured.
*/
function count_gizmo(&$numgizmos) {
    global $msgstr,$base,$db_path;
	$numgizmos=0;
	$fulldbpath=$db_path.$base."/data";
	$handle=opendir($fulldbpath);
	$extension="mst";
	while ($file = readdir($handle)) {
		$path_parts = pathinfo($file);
	if (isset($path_parts['extension']) && in_array(strtolower($path_parts['extension']), array($extension, strtoupper($extension)))) {
			$gizmo=$path_parts['filename'];
			if ($gizmo!=$base && $gizmo!=strtoupper($base)){
				$numgizmos++;
			}
		}
	}
}