<?PHP

class ISISItem implements OAIItem {

    # ---- PUBLIC INTERFACE --------------------------------------------------

    # object constructor
    function ISISItem($ItemId, $datestamp = NULL, $SearchInfo = NULL)
    {
        # save ID for later use
        $this->Id = $ItemId;
        $this->datestamp = $datestamp;
        $id_parts = explode('@', $ItemId);
        $this->DBName = $id_parts[0];

        $this->Resource = new ISISDb($this->DBName);
    }

    function GetId() {          
        return str_replace('@', '-', $this->Id);
    }

    function GetDatestamp()
    {
        if ($this->datestamp == NULL) {  $this->datestamp = date("Y-m-d");  }
        if (date('Y-m-d', strtotime($this->datestamp)) != $this->datestamp) {
                $this->datestamp = date('Y-m-d', strtotime($this->datestamp));
        }
        return $this->datestamp;        
    }

    function GetMetadata($MetadataFormat)  
    {       
        global $DATABASES;

        $mapping_file = $DATABASES[$this->DBName]['mapping'];
        $key_length = $DATABASES[$this->DBName]['isis_key_length'];
        $id_field = $DATABASES[$this->DBName]['identifier_field'];

        $record_xml = $this->Resource->getrecord(
                array('database' => $DATABASES[$this->DBName]['database'], 'expression' => $this->Id . "/($id_field)", 'metadata_format' => $MetadataFormat, 
                      'mapping_file' => $mapping_file), $key_length);

        // add CDATA to elements when work with isisxml style=1
        if ($MetadataFormat == 'isis') {
            $record_xml = preg_replace("/<v([0-9]+)>/","<v$1><![CDATA[",$record_xml);
            $record_xml = preg_replace("/<\/v([0-9]+)/","]]></v$1",$record_xml);

        // fix oai-dc root element and add CDATA on resuls when using I2X to mapping fields to oai-dc
        }elseif ($MetadataFormat == 'oai_dc' && preg_match('/\.i2x/', $mapping_file )) {
            $record_xml = preg_replace('/<oai-dc mfn=\"[0-9]+\">/','<oai-dc xsi:schemaLocation="http://www.openarchives.org/OAI/2.0/oai_dc/ http://www.openarchives.org/OAI/2.0/oai_dc.xsd" xmlns:oai-dc="http://www.openarchives.org/OAI/2.0/oai_dc/" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">',$record_xml);

            $record_xml = preg_replace("/<dc:([a-z]+)>/","<dc:$1><![CDATA[",$record_xml);
            $record_xml = preg_replace("/<\/dc:([a-z]+)/","]]></dc:$1",$record_xml);

        }

        return $record_xml;

    }

    function GetValue($ElementName)
    {
        # retrieve value
        $ReturnValue = $this->Resource->GetByFieldId($ElementName);

        # strip out any HTML tags if text value
        if (is_string($ReturnValue))
        {
            $ReturnValue = strip_tags($ReturnValue);
        }

        # format correctly if standardized date
        if ($this->GetQualifier($ElementName) == "W3C-DTF")
        {
            $Timestamp = strtotime($ReturnValue);
            $ReturnValue = date('Y-m-d\TH:i:s', $Timestamp)
                    .substr_replace(date('O', $Timestamp), ':', 3, 0);
        }

        # return value to caller
        return $ReturnValue;
    }

    function GetQualifier($ElementName)
    {
        $ReturnValue = NULL;
        $Qualifier = $this->Resource->GetQualifierByFieldId($ElementName, TRUE);
        if (is_array($Qualifier))
        {
            foreach ($Qualifier as $ItemId => $QualObj)
            {
                if (is_object($QualObj))
                {
                    $ReturnValue[$ItemId] = $QualObj->Name();
                }
            }
        }
        else
        {
            if (isset($Qualifier) && is_object($Qualifier))
            {
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
        return $this->SearchInfo;
    }

    function Status()
    {
        return $this->LastStatus;
    }


    # ---- PRIVATE INTERFACE -------------------------------------------------

    var $Id;
    var $DBName;
    var $Resource;
    var $LastStatus;
    var $SearchInfo;

    # normalize value for use as an OAI set spec
    function NormalizeForSetSpec($Name)
    {
        return preg_replace("/[^a-zA-Z0-9\-_.!~*'()]/", "", $Name);
    }
}


?>
