<?PHP

class ISISItem implements OAIItem
{

    // 1. DECLARAÇÃO DAS PROPRIEDADES
    var $Id;
    var $datestamp;
    var $DBName;
    var $Resource;
    var $DATABASES;
    var $SearchInfo;
    var $LastStatus;

    // object constructor
    // 2. CORREÇÃO NO CONSTRUTOR para receber o array de databases
    function __construct($ItemId, $myDBArray, $datestamp = NULL, $SearchInfo = NULL)
    {
        # O $ItemId agora vem no formato "set@mfn", ex: "marc@1"
        # O $datestamp vem separadamente dos GetItems/ListIdentifiers

        $this->Id = $ItemId; // Salva "marc@1"
        $this->datestamp = $datestamp;

        $id_parts = explode('@', $ItemId);
        $this->DBName = $id_parts[0]; // Pega o "marc"

        $this->Resource = new ISISDb($this->DBName);
        $this->DATABASES = $myDBArray;
        $this->SearchInfo = $SearchInfo;
    }

    // ... (o resto da classe permanece o mesmo) ...

    function GetId()
    {
        return str_replace('@', '-', $this->Id);
    }

    function GetDatestamp()
    {
        if ($this->datestamp == NULL) {
            $this->datestamp = date("Y-m-d");
        }
        if (date('Y-m-d', strtotime($this->datestamp)) != $this->datestamp) {
            $this->datestamp = date('Y-m-d', strtotime($this->datestamp));
        }
        return $this->datestamp;
    }

    // ... todas as outras funções da classe continuam aqui ...
    function GetMetadata($MetadataFormat)
    {
        global $DATABASES;
        $dbConfig = $this->DATABASES[$this->DBName] ?? null;

        if ($dbConfig === null) {
            return "<error>Configuração para a base '{$this->DBName}' não encontrada.</error>";
        }

        $mapping_file = $dbConfig['mapping'];
        $key_length = $dbConfig['cisis_version'];
        $id_field = $dbConfig['identifier_field'];
        $expression = $this->Id . "/(" . $id_field . ")";

        $record_xml = $this->Resource->getrecord(
            array(
                'database' => $dbConfig['database'],
                'expression' => $expression,
                'metadata_format' => $MetadataFormat,
                'mapping_file' => $mapping_file,
                'app_path' => APPLICATION_PATH
            ),
            $key_length
        );

        if ($MetadataFormat == 'isis') {
            $record_xml = preg_replace("/<v([0-9]+)>/", "<v$1><![CDATA[", $record_xml);
            $record_xml = preg_replace("/<\/v([0-9]+)/", "]]></v$1", $record_xml);
        } elseif ($MetadataFormat == 'oai_dc' && preg_match('/\.i2x/', $mapping_file)) {
            $xmlStartPosition = strpos($record_xml, '<');
            if ($xmlStartPosition !== false && $xmlStartPosition > 0) {
                $record_xml = substr($record_xml, $xmlStartPosition);
            }

            $record_xml = preg_replace(
                '/<oai_dc.*?>/s',
                '<oai_dc:dc xmlns:oai_dc="http://www.openarchives.org/OAI/2.0/oai_dc/" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.openarchives.org/OAI/2.0/oai_dc/ http://www.openarchives.org/OAI/2.0/oai_dc.xsd">',
                $record_xml,
                1
            );

            // CORREÇÃO FINAL: hífen trocado por sublinhado
            $record_xml = str_replace('</oai_dc>', '</oai_dc:dc>', $record_xml);

            $record_xml = preg_replace_callback('/<!\[CDATA\[(.*?)\]\]>/s', function ($matches) {
                $content = $matches[1];
                $lines = explode("\n", $content);
                if (isset($lines[0]) && preg_match('/^\s*[0-9\s#a-z]+\s*$/', $lines[0]) && count($lines) > 1) {
                    array_shift($lines);
                    $content = implode("\n", $lines);
                }
                if (preg_match_all('/<[a-z0-9]>(.*?)<\/[a-z0-9]>/s', $content, $subfield_matches)) {
                    return '<![CDATA[' . trim(implode(' ', $subfield_matches[1])) . ']]>';
                }
                return '<![CDATA[' . trim($content) . ']]>';
            }, $record_xml);
        }

        return $record_xml;
    }

    function GetValue($ElementName)
    {
        # retrieve value
        $ReturnValue = $this->Resource->GetByFieldId($ElementName);

        # strip out any HTML tags if text value
        if (is_string($ReturnValue)) {
            $ReturnValue = strip_tags($ReturnValue);
        }

        # format correctly if standardized date
        if ($this->GetQualifier($ElementName) == "W3C-DTF") {
            $Timestamp = strtotime($ReturnValue);
            $ReturnValue = date('Y-m-d\TH:i:s', $Timestamp)
                . substr_replace(date('O', $Timestamp), ':', 3, 0);
        }

        # return value to caller
        return $ReturnValue;
    }

    function GetQualifier($ElementName)
    {
        $ReturnValue = NULL;
        $Qualifier = $this->Resource->GetQualifierByFieldId($ElementName, TRUE);
        if (is_array($Qualifier)) {
            foreach ($Qualifier as $ItemId => $QualObj) {
                if (is_object($QualObj)) {
                    $ReturnValue[$ItemId] = $QualObj->Name();
                }
            }
        } else {
            if (isset($Qualifier) && is_object($Qualifier)) {
                $ReturnValue = $Qualifier->Name();
            }
        }
        return $ReturnValue;
    }

    function GetSets()
    {
        # start out with empty list
        $Sets = array($this->DBName);

        # return list of sets to caller
        return $Sets;
    }

    function GetSearchInfo()
    {
        return is_array($this->SearchInfo) ? $this->SearchInfo : [];
    }

    function Status()
    {
        return $this->LastStatus;
    }

    # normalize value for use as an OAI set spec
    function NormalizeForSetSpec($Name)
    {
        $NormalizedSetSpec = preg_replace("/[^a-zA-Z0-9\-_.!~*'()]/", "", $Name);
        return  $NormalizedSetSpec;
    }
}
