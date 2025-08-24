<?php

class ISISItemFactory implements OAIItemFactory
{
    private $Databases;
    private $RetrievalSearchParameters;

    function __construct($Databases, $RetrievalSearchParameters = NULL)
    {
        $this->RetrievalSearchParameters = $RetrievalSearchParameters;
        $this->Databases = $Databases;
    }

    function GetItem($ItemId)
    {
        $ItemIdParts = explode("^", $ItemId);
        $id = $ItemIdParts[0];
        $datestamp = $ItemIdParts[1] ?? null;

        return new ISISItem($id, $this->Databases, $datestamp);
    }

    function GetItemsInSet($setSpec, $StartingDate = NULL, $EndingDate = NULL, $ListStartPoint = 0)
    {
        global $CONFIG;

        if (!isset($this->Databases[$setSpec])) {
            return [];
        }

        $db = new ISISDb($setSpec);
        $ItemsPerPage = (int)($CONFIG['INFORMATION']['MAX_ITEMS_PER_PASS'] ?? 20);
        $date_range_exp = '';
        $database = $this->Databases[$setSpec];

        // CORREÇÃO: Monta a expressão de busca completa aqui no PHP
        if ($StartingDate !== NULL) {
            if ($EndingDate == NULL) {
                $EndingDate = date("Y-m-d");
            }
            $dates = range_date($StartingDate, $EndingDate);
            $prefix = $database['prefix'];
            // Adiciona o prefixo a cada data
            $prefixed_dates = array_map(function ($date) use ($prefix) {
                return $prefix . $date;
            }, $dates);
            $date_range_exp = implode(' OR ', $prefixed_dates);
        }

        $ListStartPoint = is_numeric($ListStartPoint) ? (int)$ListStartPoint : 0;

        $params = array(
            'expression' => $date_range_exp, // Envia a expressão pronta
            'database' => $database['database'],
            'setSpec' => $database['setSpec'],
            'date_field' => $database['datestamp_field'],
            'from' => $ListStartPoint + 1,
            'count' => $ItemsPerPage
        );

        $itemIdsString = $db->getidentifiers($params, $database['cisis_version']);

        if (empty($itemIdsString)) return [];

        $itemIds = rtrim($itemIdsString, "|");
        return array_filter(explode("|", $itemIds));
    }

    // --- Demais funções da classe (sem alterações) ---

    function GetItems($StartingDate = NULL, $EndingDate = NULL, $ListStartPoint = 0)
    {
        // Esta função pode ser implementada no futuro para buscar em todos os sets
        return [];
    }

    function GetListOfSets()
    {
        $setList = array();
        foreach ($this->Databases as $key => $set) {
            $setList[$set['setName']] = $key;
        }
        return $setList;
    }

    function SearchForItems($SearchParams, $StartingDate = NULL, $EndingDate = NULL)
    {
        return [];
    }
}
