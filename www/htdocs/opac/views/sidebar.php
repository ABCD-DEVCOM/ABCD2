

<!-- Sidebar de facetas -->
<aside id="sidebar" class="collapse d-md-block col-12 col-md-3 flex-shrink-0 p-3 custom-sidebar">
	<h5 class="card-title">
		<?php
		if (!isset($_REQUEST["existencias"]) or trim($_REQUEST["existencias"]) == "") {
			include_once('components/facets.php');
			include_once($Web_Dir . 'views/online_statment.php');
		}
		?>
</aside>