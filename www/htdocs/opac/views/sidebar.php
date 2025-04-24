<aside id="sidebar" class="col-3 d-md-block flex-column flex-shrink-0 p-3 sidebar collapse custom-sidebar">
	
<h5 class="card-title">

	<?php

	if (!isset($_REQUEST["existencias"]) or trim($_REQUEST["existencias"])=="" ){

	include_once ('components/facets.php');
	
	include_once ($Web_Dir.'views/online_statment.php');


		
	}
	?>
</aside>