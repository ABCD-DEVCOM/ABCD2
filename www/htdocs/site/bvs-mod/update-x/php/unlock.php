<?php

require("include.php");
require("update-x.php");

$UPDATE_X_vars["selectedId"] = UPDATE_X_getParameter($selectedId,$UPDATE_X_ini,"form","selectedId");
$writeParam["database"] = $UPDATE_X_vars["database"];
$writeParam["mfn"] = $UPDATE_X_vars["selectedId"];
$writeParam["lockid"] = $UPDATE_X_vars["user"];
$writeParam["expire"] = INCLUDE_optionalVar($UPDATE_X_ini["VARS"]["expire"],"18000");
$xml = wxis_write(INCLUDE_wxisParameterList($writeParam),"");

?>
<html>
<body onload="window.close();"></body>
</html>
