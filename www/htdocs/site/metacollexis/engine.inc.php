<?php

//==============================================================================
function GoSearch($target_node, $sourceList_node, $expression = ""){
	global $selected_sources, $form, $lang;

	// cria um vetor de indice com os itens do nó sourceList 
	
	for ($grp = 0; $grp < count($sourceList_node->children); $grp++){
		
		$grpLabel  = $sourceList_node->children[$grp]->attributes["label"];
		
		for ($src = 0; $src < count($sourceList_node->children[$grp]->children); $src++ ){
			$sourceId = $sourceList_node->children[$grp]->children[$src]->attributes["id"];
			$sourceList[$sourceId] = $sourceList_node->children[$grp]->children[$src]->attributes;
			$sourceList[$sourceId]["group"] = $grpLabel;
		}	
	}
	
	inprocess('','init');	
	
	$groupCount = 0;
	$expressionLabel = $target_node->attributes["label"];
	
	$xmlSearch .= "<control expression-label=\"" . $expressionLabel .  "\"/>\n";
	
	for ($i = 0; $i < count($target_node->children); $i++){
	
			$current_source = $sourceList[$target_node->children[$i]->attributes["source"]];
			$current_source["search-parameters"] = $target_node->children[$i]->attributes["search-parameters"];

			// verifica se é grupo novo 
			if ( $current_source["group"] != $previous_source["group"]){

				$groupName = $current_source["group"];
				$groupName1 = str_replace(" ","_",$groupName);

				//caso seja formulario avancado so executa o search nos grupos selecionados		
				if ($form == 'advanced' & ! isset($selected_sources[$groupName]) ){					
					continue;
				}			
				if ( $groupCount > 0 ) $xmlSearch .= "</result-group>\n";
				
				$xmlSearch .= "<result-group label=\"" .  $groupName .  "\">\n";
				$groupCount++;
			}	
			
			$sourceName = $current_source["label"];
			$sourceName1 = ereg_replace("[ |\.]","_", $sourceName);
				
			if ($form == 'advanced' & ! isset($selected_sources[$sourceName])){   // se fonte não esta selecionada
		
			    // mesmo que a fonte não esteja habilitada executa search nos casos
				// onde o grupo $current_group = 'all' ou a fonte é única dentro do grupo 
				continue;
				/* 
				if ( $GLOBALS[$current_group] != 'all' &  count($target_node->children[$i]->children) > 1){
					continue;
				}
				*/
			}
				
			// não executa pesquisa nas fontes desabilitadas (available = no)
			if ($current_source["available"] == 'no'){
				continue;
			}
				
			$sourceLabel= $current_source["label"];				
			$sourceSearchParameters= $current_source["search-parameters"] . $expression;
			$sourceBaseBrowseUrl= $current_source["base-browse-url"];
			$sourceBaseSearchUrl= $current_source["base-search-url"];
				
			// caso seja o swish precisa ativar a consulta para o grupo e item atual no browseUrl
			if (eregi("swish", $sourceBaseSearchUrl)) {
				$sourceBaseBrowseUrl .= $sourceLabel . "=true|" . $groupName . "=true|" ;
			}	

			$urltosearch = $sourceBaseSearchUrl . "&" . $sourceSearchParameters;
	
			$urltosearch = str_replace("|","&",$urltosearch);

			$urltobrowse = $sourceBaseBrowseUrl . "&" .  $sourceSearchParameters;			
			if ( strpos($urltobrowse, 'label=') === false && $expressionLabel != ''  ){
				$urltobrowse .= "&label=" . $expressionLabel;
			}	
			if ( strpos($urltobrowse,'lang=') === false ){
				$urltobrowse .= "&lang=" . $lang;
			}	
			//$urltobrowse = encodeValues( str_replace("|","&",$urltobrowse) );
			$urltobrowse = str_replace("|","&",$urltobrowse);
			
			inprocess($sourceLabel, 'run');
			$xmlSearch .= "<source label=\"" . $sourceLabel . "\" name=\"" . $sourceName . "\" browse-url=\"" . str_replace( "&","|",$urltobrowse ) . "\">\n";
				$xmlSearch .= readData($urltosearch, true, "POST");
			$xmlSearch .= "</source>\n";	

		$previous_source = $current_source;
	}	
	$xmlSearch .= "</result-group>\n";
	return $xmlSearch;
}

?>