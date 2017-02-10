<?php

/* como manejar LOCKS!?
		if (isset($arrHttp["lock"]) and $arrHttp["lock"]=="S"){
			$query.="&lock=S";

		}
		*/
		include("../config.php");
		$IsisScript=$xWxis."actualizar.xis";
        $ValorCapturado=urlencode("<630>ernesto creada nueva ocurrencia ". date("Ymd h:i:s")."</630>");
		$query = "&base=odds&cipar=/kunden/homepages/9/d502990860/htdocs/ABCD/bases/demo_nocopies/par/odds.par&Mfn=1&login=ABCD&Opcion=actualizar&ValorCapturado=$ValorCapturado";
		putenv('REQUEST_METHOD=GET');
		putenv('QUERY_STRING='."?xx=".$query);
		$contenido="";
		exec("\"".$Wxis."\" IsisScript=$IsisScript",$contenido);

//solo test
		var_dump($contenido);
		$IsisScript=$xWxis."leer_all.xis";
		$query = "&base=odds&cipar=/kunden/homepages/9/d502990860/htdocs/ABCD/bases/demo_nocopies/par/odds.par&Mfn=1&count=1";
		putenv('REQUEST_METHOD=GET');
		putenv('QUERY_STRING='."?xx=".$query);
		$contenido="";
		exec("\"".$Wxis."\" IsisScript=$IsisScript",$contenido);
		foreach ($contenido as $value) echo "$value<br>";
		die();




?>

