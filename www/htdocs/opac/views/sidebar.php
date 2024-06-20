<aside id="sidebar" class="d-md-block flex-column flex-shrink-0 p-3 sidebar collapse custom-sidebar">
	<?php
//col-md-3 col-lg-2 d-md-block bg-light sidebar collapse
	//include_once ('components/facets.php');
	//include_once ('alfabetico.php');

	if (!isset($_REQUEST["existencias"]) or trim($_REQUEST["existencias"])=="" ){

	include_once ($Web_Dir.'views/online_statment.php');

	include_once ($Web_Dir.'views/more_links.php');
		
	}
	?>
</aside>