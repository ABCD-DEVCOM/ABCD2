<?php
include_once '../controllers/config.php';
if($U->isLogged()){
	if(isset($_GET['t'])){
		$t = $U->clean($_GET['t']);
		switch($t){
			case 'all':
				$U->displayBooks();
			break;
			case 'subs':
				$U->myBookViews();
			break;
			case 'downs':
				$U->myBookDownloads();
			break;
		}
	}
}