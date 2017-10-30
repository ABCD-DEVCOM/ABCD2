<?php

class ISISItemFactory implements OAIItemFactory {

    # ---- PRIVATE VARIABLES -----------------------------------------

    private $SetSpecs;
    private $SetFields;
    private $SetValues;
    private $RetrievalSearchParameters;
    private $SearchScores;
    private $SearchScoreScale;
    private $Databases;
//echo "databases in ISISItemfactory = $Databases<BR>"; die;

    # object constructor
    function __construct($Databases, $RetrievalSearchParameters = NULL )
    {
        # save any supplied retrieval parameters
        $this->RetrievalSearchParameters = $RetrievalSearchParameters;
        $this->Databases = $Databases;
    }

    function __ISISItemFactory($Databases, $RetrievalSearchParameters = NULL )
    {
      self:: __construct($Databases, $RetrievalSearchParameters = NULL );
    }

    function GetItem($ItemId)
	{
        $ItemId = explode("^",$ItemId);
        $isis_item = new ISISItem($ItemId[0], $datestamp = $ItemId[1]);
        return $isis_item;
	}
	   
    function GetItems($StartingDate = NULL, $EndingDate = NULL, $ListStartPoint=0){
        global $CONFIG;
    	$db = new ISISDb($setSpec);
        $ItemIds = '';
        $ItemsPerPage = $CONFIG['INFORMATION']['MAX_ITEMS_PER_PASS'];

        if ($StartingDate !== NULL){
            if ($EndingDate == NULL){
                $EndingDate = date("Y-m-d");
            }
            $date_range_exp = implode(' OR ', range_date($StartingDate, $EndingDate));
        }else{
            $date_range_exp = '';
        }
        $ListStartPoint += 1;
        foreach ($this->Databases as $database) {
            $params = array('expression' => $date_range_exp, 
                'database' => $database['database'],
                'setspec' => $database['setspec'],
                'date_prefix' => $database['prefix'],
                'id_field' => $database['identifier_field'],
                'cisis_version' => $database['cisis_version'],
                'date_field' => $database['datestamp_field'],
                'from' => $ListStartPoint,
                'count' => $ItemsPerPage,
            );
            $ItemIds .= $db->getidentifiers($params, $database['cisis_version']);
            $curItemIds = array_filter(explode("|", $ItemIds));
            $total = $db->gettotal($params, $database['cisis_version']);
            $totalFound = count($curItemIds);
            if($total < $ListStartPoint) {
                $ListStartPoint = $ListStartPoint - $total;
            } else {
                $ListStartPoint = 0;
            }
        }       

        $ItemIds = array_filter(explode("|", $ItemIds));
        $ItemIds = array_slice($ItemIds, 0, $ItemsPerPage);

        return $ItemIds;
    }

    # retrieve IDs of items that matches set spec (only needed if sets supported)
    function GetItemsInSet($setSpec, $StartingDate = NULL, $EndingDate = NULL, $ListStartPoint=0)
    {
        global $CONFIG;
     	$db = new ISISDb($setSpec);
        $ItemsPerPage = $CONFIG['INFORMATION']['MAX_ITEMS_PER_PASS'];
        if ($StartingDate !== NULL){
            if ($EndingDate == NULL){
                $EndingDate = date("Y-m-d");
            }
            $date_range_exp = implode(' OR ', range_date($StartingDate, $EndingDate));
        }else{
            $date_range_exp = '';
        }
        $ListStartPoint += 1;
        foreach ($this->Databases as $database) {
            if ($database['setSpec'] == $setSpec){
                $params = array('expression' => $date_range_exp, 
                  'database' => $database['database'],
                  'setSpec' => $database['setSpec'],
                  'date_prefix' => $database['prefix'],
                  'id_field' => $database['identifier_field'],
                  'date_field' => $database['datestamp_field'],
                  'from' => $ListStartPoint,
                  'count' => $ItemsPerPage,                  
                  'cisis_version' => $database['cisis_version'],
                );
                $ItemIds = $db->getidentifiers($params, $database['cisis_version']);
            }     
        } 
        $ItemIds = substr($ItemIds, 0, strlen($ItemIds)-1);
        $ItemIds = explode("|", $ItemIds);

        return $ItemIds;
    }

    # return array containing all set specs (with human-readable set names as keys)
    # (only used if sets supported)
    function GetListOfSets()
    {
    	$setList = array();
    	foreach ($this->Databases as $set){
    		$setSpec = $set['setSpec'];
    		$setName = $set['setName'];

    		$setList[$setName] = $setSpec;
    	}

    	return $setList;
    }

    # retrieve IDs of items that match search parameters (only used if OAI-SQ supported)
    function SearchForItems($SearchParams, $StartingDate = NULL, $EndingDate = NULL)
    {
    	
    }


}

?>