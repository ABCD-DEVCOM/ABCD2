<?PHP

#
#   FILE:  OAIServer.php
#
#   Copyright 2002-2010 Edward Almasy and Internet Scout
#   http://scout.wisc.edu
#

class OAIServer {

    # ---- PUBLIC INTERFACE --------------------------------------------------

    # object constructor
    function OAIServer($RepDescr, &$ItemFactory, $SetsSupported = FALSE, $OaisqSupported = FALSE)
    {
        # save repository description
        $this->RepDescr = $RepDescr;

        # save supported option settings
        $this->SetsSupported = $SetsSupported;
        $this->OaisqSupported = $OaisqSupported;

        # normalize repository description values
        $this->RepDescr["IDPrefix"] =
                    preg_replace("/[^0-9a-z]/i", "", $this->RepDescr["IDPrefix"]);

        # save item factory
        $this->ItemFactory =& $ItemFactory;

        # load OAI request type and arguments
        $this->LoadArguments();

        # set default indent size
        $this->IndentSize = 4;

        # start with empty list of formats
        $this->FormatDescrs = array();
    }

    # add metadata format to export
    function AddFormat($Name, $TagName, $SchemaNamespace, $SchemaDefinition,
            $SchemaVersion, $NamespaceList, $ElementList, $QualifierList)
    {
        # find highest current format ID
        $HighestFormatId = 0;
        foreach ($this->FormatDescrs as $FormatName => $FormatDescr)
        {
            if ($FormatDescr["FormatId"] > $HighestFormatId)
            {
                $HighestFormatId = $FormatDescr["FormatId"];
            }
        }

        # set new format ID to next value
        $this->FormatDescrs[$Name]["FormatId"] = $HighestFormatId + 1;

        # store values
        $this->FormatDescrs[$Name]["TagName"] = $TagName;
        $this->FormatDescrs[$Name]["SchemaNamespace"] = $SchemaNamespace;
        $this->FormatDescrs[$Name]["SchemaDefinition"] = $SchemaDefinition;
        $this->FormatDescrs[$Name]["SchemaVersion"] = $SchemaVersion;
        $this->FormatDescrs[$Name]["ElementList"] = $ElementList;
        $this->FormatDescrs[$Name]["QualifierList"] = $QualifierList;
        $this->FormatDescrs[$Name]["NamespaceList"] = $NamespaceList;

        # start out with empty mappings list
        if (!isset($this->FieldMappings[$Name]))
        {
            $this->FieldMappings[$Name] = array();
        }
    }

    # return list of formats
    function FormatList()
    {
        $FList = array();
        foreach ($this->FormatDescrs as $FormatName => $FormatDescr)
        {
            $FList[$FormatDescr["FormatId"]] = $FormatName;
        }
        return $FList;
    }

    # return list of elements for a given format
    function FormatElementList($FormatName)
    {
        return $this->FormatDescrs[$FormatName]["ElementList"];
    }

    # return list of qualifiers for a given format
    function FormatQualifierList($FormatName)
    {
        return $this->FormatDescrs[$FormatName]["QualifierList"];
    }

    # get/set mapping of local field to OAI field
    function GetFieldMapping($FormatName, $LocalFieldName)
    {
        # return stored value
        if (isset($this->FieldMappings[$FormatName][$LocalFieldName]))
        {
            return $this->FieldMappings[$FormatName][$LocalFieldName];
        }
        else
        {
            return NULL;
        }
    }
    function SetFieldMapping($FormatName, $LocalFieldName, $OAIFieldName)
    {
        $this->FieldMappings[$FormatName][$LocalFieldName] = $OAIFieldName;
    }

    # get/set mapping of local qualifier to OAI qualifier
    function GetQualifierMapping($FormatName, $LocalQualifierName)
    {
        # return stored value
        if (isset($this->QualifierMappings[$FormatName][$LocalQualifierName]))
        {
            return $this->QualifierMappings[$FormatName][$LocalQualifierName];
        }
        else
        {
            return NULL;
        }
    }
    function SetQualifierMapping($FormatName, $LocalQualifierName, $OAIQualifierName)
    {
        $this->QualifierMappings[$FormatName][$LocalQualifierName] = $OAIQualifierName;
    }

    function GetResponse()
    {
        # call appropriate method based on request type
        switch (strtoupper($this->Args["verb"]))
        {
            case "IDENTIFY":
                $Response = $this->ProcessIdentify();
                break;

            case "GETRECORD":
                $Response = $this->ProcessGetRecord();
                break;

            case "LISTIDENTIFIERS":
                $Response = $this->ProcessListRecords(FALSE);
                break;

            case "LISTRECORDS":
                $Response = $this->ProcessListRecords(TRUE);
                break;

            case "LISTMETADATAFORMATS":
                $Response = $this->ProcessListMetadataFormats();
                break;

            case "LISTSETS":
                $Response = $this->ProcessListSets();
                break;

            default:
                # return "bad argument" response
                $Response = $this->GetResponseBeginTags();
                $Response .= $this->GetRequestTag();
                $Response .= $this->GetErrorTag("badVerb", "Bad or unknown request type.");
                $Response .= $this->GetResponseEndTags();
                break;
        }

        # return generated response to caller
        return $Response;
    }


    # ---- PRIVATE INTERFACE -------------------------------------------------

    private $Args;
    private $RepDescr;
    private $ItemFactory;
    private $FormatDescrs;
    private $FormatFields;
    private $FieldMappings;
    private $QualifierMappings;
    private $IndentSize;
    private $SetsSupported;
    private $OaisqSupported;


    # ---- response generation methods

    private function ProcessIdentify()
    {
        # initialize response
        $Response = $this->GetResponseBeginTags();

        # add request info tag
        $Response .= $this->GetRequestTag("Identify");

        # open response type tag
        $Response .= $this->FormatTag("Identify");

        # add repository info tags
        $Response .= $this->FormatTag("repositoryName", $this->RepDescr["Name"]);
        $Response .= $this->FormatTag("baseURL", $this->RepDescr["BaseURL"]);
        $Response .= $this->FormatTag("protocolVersion", "2.0");
        $Response .= $this->FormatTag("applicationVersion", $this->RepDescr["AppVersion"]);

        foreach ($this->RepDescr["AdminEmail"] as $AdminEmail)
        {
            $Response .= $this->FormatTag("adminEmail", $AdminEmail);
        }
        $Response .= $this->FormatTag("earliestDatestamp", $this->RepDescr["EarliestDate"]);
        $Response .= $this->FormatTag("deletedRecord", "no");
        $Response .= $this->FormatTag("granularity",
                                      (strtoupper($this->RepDescr["DateGranularity"]) == "DATETIME")
                                          ? "YYYY-MM-DDThh:mm:ssZ" : "YYYY-MM-DD");

        # add repository description section
        $Response .= $this->FormatTag("description");
        $Attribs = array(
                "xmlns" => "http://www.openarchives.org/OAI/2.0/oai-identifier",
                "xmlns:xsi" => "http://www.w3.org/2001/XMLSchema-instance",
                "xsi:schemaLocation" => "http://www.openarchives.org/OAI/2.0/oai-identifier http://www.openarchives.org/OAI/2.0/oai-identifier.xsd",
                );
        $Response .= $this->FormatTag("oai-identifier", NULL, $Attribs);
        $Response .= $this->FormatTag("scheme", "oai");
        $Response .= $this->FormatTag("repositoryIdentifier", $this->RepDescr["IDDomain"]);
        $Response .= $this->FormatTag("delimiter", ":");
        $Response .= $this->FormatTag("sampleIdentifier", $this->EncodeIdentifier("12345"));
        $Response .= $this->FormatTag();
        $Response .= $this->FormatTag();

        # close response type tag
        $Response .= $this->FormatTag();

        # close out response
        $Response .= $this->GetResponseEndTags();

        # return response to caller
        return $Response;
    }

    private function ProcessGetRecord()
    {
        # initialize response
        $Response = $this->GetResponseBeginTags();

        # if arguments were bad
        if (isset($this->Args["identifier"]))
        {

           $ItemId = $this->DecodeIdentifier($this->Args["identifier"]);
           #Create to show database-id
           $ItemDatabaseId= $this->DecodeDatabaseIdentifier($this->Args["identifier"]);

        }
        else
        {
            $ItemId = NULL;
        }

       if (isset($this->Args["metadataPrefix"]))
        {
            $MetadataFormat = $this->Args["metadataPrefix"];
        }
        else
        {
            $MetadataFormat = NULL;
        }
        if (($ItemId == NULL) || ($MetadataFormat == NULL) || !is_array($this->FieldMappings[$MetadataFormat]))
        {
            # add request info tag with no attributes
            $Response .= $this->GetRequestTag("GetRecord");

            # add error tag
            $Response .= $this->GetErrorTag("badArgument", "Bad argument found.");
        }
        else
        {
            # add request info tag
            $ReqArgList = array("identifier", "metadataPrefix");
            $Response .= $this->GetRequestTag("GetRecord", $ReqArgList);

            # attempt to load item corresponding to record
            $Item = $this->ItemFactory->GetItem($ItemDatabaseId);

            # if no item found
            if ($Item == NULL)
            {
                # add error tag
                $Response .= $this->GetErrorTag("idDoesNotExist", "No item found for specified ID.");
            }
            else
            {
                # open response type tag
                $Response .= $this->FormatTag("GetRecord");

                # add tags for record
                $Response .= $this->GetRecordTags($Item, $MetadataFormat);

                # close response type tag
                $Response .= $this->FormatTag();
            }
        }

        # close out response
        $Response .= $this->GetResponseEndTags();

        # return response to caller
        return $Response;
    }

    private function ProcessListRecords($IncludeMetadata)
    {
        global $CONFIG; 
        
        # set request type
        if ($IncludeMetadata)
        {
            $Request = "ListRecords";
        }
        else
        {
            $Request = "ListIdentifiers";
        }

        # initialize response
        $Response = $this->GetResponseBeginTags();

        # if resumption token supplied
        if (isset($this->Args["resumptionToken"]))
        {
            # set expected argument lists
            $ReqArgList = array("resumptionToken");
            $OptArgList = NULL;

            # parse into list parameters
            $Args = $this->DecodeResumptionToken($this->Args["resumptionToken"]);
        }
        else
        {
            # set expected argument lists
            $ReqArgList = array("metadataPrefix");
            $OptArgList = array("from", "until", "set");

            # get list parameters from incoming arguments
            $Args = $this->Args;

            # set list starting point to beginning
            $Args["ListStartPoint"] = 0;
        }

        # if resumption token was supplied and was bad
        if ($Args == NULL)
        {
            # add request info tag
            $Response .= $this->GetRequestTag($Request, $ReqArgList, $OptArgList);

            # add error tag indicating bad resumption token
            $Response .= $this->GetErrorTag("badResumptionToken", "Bad resumption token.");

            # if other parameter also supplied
            if (count($this->Args) > 2)
            {
                # add error tag indicating exclusive argument error
                $Response .= $this->GetErrorTag("badArgument", "Resumption token is exclusive argument.");
            }
        }
        # else if resumption token supplied and other arguments also supplied
        elseif (isset($this->Args["resumptionToken"]) && (count($this->Args) > 2))
        {
            # add error tag indicating exclusive argument error
            $Response .= $this->GetRequestTag();
            $Response .= $this->GetErrorTag("badArgument", "Resumption token is exclusive argument.");
        }
        # else if metadata format was not specified
        elseif (empty($Args["metadataPrefix"]))
        {
            # add request info tag with no attributes
            $Response .= $this->GetRequestTag($Request);

            # add error tag indicating bad argument
            $Response .= $this->GetErrorTag("badArgument", "No metadata format specified.");
        }
        # else if from or until date is specified but bad
        elseif ((isset($Args["from"]) && $this->DateIsInvalid($Args["from"]))
                || (isset($Args["until"]) && $this->DateIsInvalid($Args["until"])))
        {
            # add request info tag with no attributes
            $Response .= $this->GetRequestTag($Request);

            # add error tag indicating bad argument
            $Response .= $this->GetErrorTag("badArgument", "Bad date format.");
        }
        # else if until date is earlier than from date
        elseif ((isset($Args["from"]) && (isset($Args["until"]) )
                 && $Args["until"]<$Args["from"]))
        {
            # add request info tag with no attributes
            $Response .= $this->GetRequestTag($Request);

            # add error tag indicating invalid until date
            $Response .= $this->GetErrorTag("badArgument", "Invalid until date.");
        }
        else
        {
            # add request info tag
            $Response .= $this->GetRequestTag($Request, $ReqArgList, $OptArgList);

            # if set requested and we do not support sets
            if (isset($Args["set"]) && ($this->SetsSupported != TRUE))
            {
                # add error tag indicating that we don't support sets
                $Response .= $this->GetErrorTag("noSetHierarchy", "This repository does not support sets.");
            }
            # else if requested metadata format is not supported
            elseif (empty($this->FormatDescrs[$Args["metadataPrefix"]]))
            {
                # add error tag indicating that format is not supported
                $Response .= $this->GetErrorTag("cannotDisseminateFormat", "Metadata format \"".$Args["metadataPrefix"]."\" not supported by this repository.");
            }
            else
            {
                # if set requested
                if (isset($Args["set"]))
                {

                    # if OAI-SQ supported and set represents OAI-SQ query
                    if ($this->OaisqSupported && $this->IsOaisqQuery($Args["set"]))
                    {
                        # parse OAI-SQ search parameters out of set name
                        $SearchParams = $this->ParseOaisqQuery($Args["set"], $Args["metadataPrefix"]);

                        # if search parameters found
                        if (count($SearchParams))
                        {
                            # perform search for items that match OAI-SQ request
                            $ItemIds = $this->ItemFactory->SearchForItems(
                                $SearchParams,
                                (isset($Args["from"]) ? $Args["from"] : NULL),
                                (isset($Args["until"]) ? $Args["until"] : NULL));
                        }
                        else
                        {
                            # no items match
                            $ItemIds = array();
                        }
                    }
                    else
                    {
                        # get list of items in set that matches incoming criteria
                        $ItemIds = $this->ItemFactory->GetItemsInSet(
                            $Args["set"],
                            (isset($Args["from"]) ? $Args["from"] : NULL),
                            (isset($Args["until"]) ? $Args["until"] : NULL),
                            (isset($Args["ListStartPoint"]) ? $Args["ListStartPoint"] : NULL));
                    }
                }
                else
                {
                    # get list of items that matches incoming criteria
                    $ItemIds = $this->ItemFactory->GetItems(
                        (isset($Args["from"]) ? $Args["from"] : NULL),
                        (isset($Args["until"]) ? $Args["until"] : NULL),
                        (isset($Args["ListStartPoint"]) ? $Args["ListStartPoint"] : NULL));

                }

                # if no items found
                if (count($ItemIds) == 0)
                {
                    # add error tag indicating that no records found that match spec
                    $Response .= $this->GetErrorTag("noRecordsMatch", "No records were found that match the specified parameters.");
                }
                else
                {
                    # open response type tag
                    $Response .= $this->FormatTag($Request);

                    # initialize count of processed items
                    $ListIndex = 0;

                    # stop processing if we have processed max number of items in a pass
                    $MaxItemsPerPass = $CONFIG['INFORMATION']['MAX_ITEMS_PER_PASS'];

                    # for each item
                    foreach ($ItemIds as $ItemId)
                    {
                        # retrieve item
                        $Item = $this->ItemFactory->GetItem($ItemId);

                        # add record for item
                        $Response .= $this->GetRecordTags($Item, $Args["metadataPrefix"], $IncludeMetadata);

                        # increment count of processed items
                        $ListIndex++;

                        if (($ListIndex - $Args["ListStartPoint"]) >= $MaxItemsPerPass) {  break;  }
                    }
                    # if items left unprocessed
                    if ($MaxItemsPerPass == count($ItemIds))
                    {
                        $resumptionNewStartPoint = $Args["ListStartPoint"] + $MaxItemsPerPass;
                        # add resumption token tag
                        $Token = $this->EncodeResumptionToken((isset($Args["from"]) ? $Args["from"] : NULL),
                                                              (isset($Args["until"]) ? $Args["until"] : NULL),
                                                              (isset($Args["metadataPrefix"]) ? $Args["metadataPrefix"] : NULL),
                                                              (isset($Args["set"]) ? $Args["set"] : NULL),
                                                              ($resumptionNewStartPoint));
                        $Response .= $this->FormatTag("resumptionToken", $Token);
                    }
                    else
                    {
                        # if we started with a resumption token tag
                        if (isset($this->Args["resumptionToken"]))
                        {
                            # add empty resumption token tag to indicate end of set
                            $Response .= $this->FormatTag("resumptionToken", "");
                        }
                    }

                    # close response type tag
                  $Response .= $this->FormatTag();
                }
            }
        }

        # close out response
        $Response .= $this->GetResponseEndTags();

        # return response to caller
        return $Response;
    }

    private function ProcessListMetadataFormats()
    {
        # initialize response
        $Response = $this->GetResponseBeginTags();

        # if arguments were bad
        $Arg = isset($this->Args["identifier"]) ? $this->Args["identifier"] : NULL;
        $ItemId = $this->DecodeIdentifier($Arg);
        if (isset($this->Args["identifier"]) && ($ItemId == NULL))
        {
            # add error tag
            $Response .= $this->GetRequestTag();
            $Response .= $this->GetErrorTag("idDoesNotExist", "Identifier unknown or illegal.");
        }
        else
        {
            # add request info tag
            $OptArgList = array("identifier");
            $Response .= $this->GetRequestTag("ListMetadataFormats", NULL, $OptArgList);

            # open response type tag
            $Response .= $this->FormatTag("ListMetadataFormats");

            # for each supported format
            foreach ($this->FormatDescrs as $FormatName => $FormatDescr)
            {
                # open format tag
                $Response .= $this->FormatTag("metadataFormat");

                # add tags describing format
                $Response .= $this->FormatTag("metadataPrefix", $FormatName);
                if (isset($FormatDescr["SchemaDefinition"]))
                {
                    $Response .= $this->FormatTag("schema",
                            $FormatDescr["SchemaDefinition"]);
                }
                if (isset($FormatDescr["SchemaNamespace"]))
                {
                    $Response .= $this->FormatTag("metadataNamespace",
                            $FormatDescr["SchemaNamespace"]);
                }

                # close format tag
                $Response .= $this->FormatTag();
            }

            # close response type tag
            $Response .= $this->FormatTag();
        }

        # close out response
        $Response .= $this->GetResponseEndTags();

        # return response to caller
        return $Response;
    }

    private function ProcessListSets()
    {
        global $databases;

        # initialize response
        $Response = $this->GetResponseBeginTags();

        # add request info tag
        $OptArgList = array("resumptionToken");
        $Response .= $this->GetRequestTag("ListSets", NULL, $OptArgList);

        # retrieve list of supported sets
        $SetList = $this->SetsSupported ? $this->ItemFactory->GetListOfSets() : array();

        # if sets not supported or we have no sets
        if ((!$this->SetsSupported) || (!count($SetList) && !$this->OaisqSupported))
        {
            # add error tag indicating that we do not support sets
            $Response .= $this->GetErrorTag("noSetHierarchy", "This repository does not support sets.");
        }
        else
        {
            # open response type tag
            $Response .= $this->FormatTag("ListSets");

            # if OAI-SQ is enabled
            if ($this->OaisqSupported)
            {
                # add OAI-SQ to list of sets
                $SetList["OAI-SQ"] = "OAI-SQ";
                $SetList["OAI-SQ-F"] = "OAI-SQ-F";
            }

            # for each supported set
            foreach ($SetList as $SetName => $SetSpec)
            {
                # open set tag
                $Response .= $this->FormatTag("set");

                # add set spec and set name
                $Response .= $this->FormatTag("setSpec", $SetSpec);
                $Response .= $this->FormatTag("setName", $SetName);
                $Response .= $this->FormatTag("setDescription", $databases[$SetSpec]["description"]);

                # close set tag
                $Response .= $this->FormatTag();
            }

            # close response type tag
            $Response .= $this->FormatTag();
        }

        # close out response
        $Response .= $this->GetResponseEndTags();

        # return response to caller
        return $Response;
    }


    # ---- common private methods

    private function GetResponseBeginTags()
    {
        # start with XML declaration
        $Tags = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n";

        # add OAI-PMH root element begin tag
        $Tags .= "<OAI-PMH xmlns=\"http://www.openarchives.org/OAI/2.0/\"\n"
                ."        xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"\n"
                ."        xsi:schemaLocation=\"http://www.openarchives.org/OAI/2.0/\n"
                ."            http://www.openarchives.org/OAI/2.0/OAI-PMH.xsd\">\n";

        # add response timestamp
        $Tags .= "    <responseDate>".date("Y-m-d\\TH:i:s\\Z")."</responseDate>\n";

        # return tags to caller
        return $Tags;
    }

    private function GetResponseEndTags()
    {
        # close out OAI-PMH root element
        $Tags = "</OAI-PMH>\n";

        # return tags to caller
        return $Tags;
    }

    private function GetRequestTag($RequestType = NULL, $ReqArgList = NULL, $OptArgList = NULL)
    {
        # build attribute array
        $AttributeList = array();
        if ($RequestType !== NULL)
        {
            $AttributeList["verb"] = $RequestType;
        }
        if ($ReqArgList != NULL)
        {
            foreach ($ReqArgList as $ArgName)
            {
                if (isset($this->Args[$ArgName]))
                {
                    $AttributeList[$ArgName] = $this->Args[$ArgName];
                }
            }
        }
        if ($OptArgList != NULL)
        {
            foreach ($OptArgList as $ArgName)
            {
                if (isset($this->Args[$ArgName]))
                {
                    $AttributeList[$ArgName] = $this->Args[$ArgName];
                }
            }
        }

        # generate formatted tag
        $Tag = $this->FormatTag("request",
                                $this->RepDescr["BaseURL"],
                                $AttributeList);

        # return tag to caller
        return $Tag;
    }

    private function GetErrorTag($ErrorCode, $ErrorMessage)
    {
        return $this->FormatTag("error", $ErrorMessage, array("code" => $ErrorCode));
    }

    private function GetRecordTags($Item, $MetadataFormat, $IncludeMetadata = TRUE)
    {
        # if more than identifiers requested
        if ($IncludeMetadata)
        {
            # open record tag
            $Tags = $this->FormatTag("record");
        }
        else
        {
            # just initialize tag string with empty value
            $Tags = "";
        }

        # add header with identifier, datestamp, and set tags
        $Tags .= $this->FormatTag("header");
        $Tags .= $this->FormatTag("identifier",
                                  $this->EncodeIdentifier($Item->GetId()));
        $Tags .= $this->FormatTag("datestamp", $Item->GetDatestamp());
        $Sets = $Item->GetSets();
        foreach ($Sets as $Set)
        {
            $Tags .= $this->FormatTag("setSpec", $Set);
        }
        $Tags .= $this->FormatTag();

        # if more than identifiers requested
        if ($IncludeMetadata)
        {
            # open metadata tag
            $Tags .= $this->FormatTag("metadata");
            $Tags .= $Item->GetMetadata($MetadataFormat);

            // DELETED HANDLE OF OAI FIELDS

            # close metadata format tag
            $Tags .= $this->FormatTag();

            # close metadata tag
            $Tags .= $this->FormatTag();

            # if there is additional search info about this item
            $SearchInfo = $Item->GetSearchInfo();
            if (count($SearchInfo))
            {
                # open about and search info tags
                $Tags .= $this->FormatTag("about");
                $Attribs = array(
                        "xmlns" => "http://scout.wisc.edu/XML/searchInfo/",
                        "xmlns:xsi" => "http://www.w3.org/2001/XMLSchema-instance",
                        "xsi:schemaLocation" => "http://scout.wisc.edu/XML/searchInfo/ http://scout.wisc.edu/XML/searchInfo.xsd",
                        );
                $Tags .= $this->FormatTag("searchInfo", NULL, $Attribs);

                # for each piece of additional info
                foreach ($SearchInfo as $InfoName => $InfoValue)
                {
                    # add tag for info
                    $Tags .= $this->FormatTag($InfoName,
                            utf8_encode(htmlspecialchars(preg_replace("/[\\x00-\\x1F]+/", "", $InfoValue))));
                }

                # close about and search info tags
                $Tags .= $this->FormatTag();
                $Tags .= $this->FormatTag();
            }
        }

        # if more than identifiers requested
        /* FIX: uncomented will close ListRecords element
        if ($IncludeMetadata)
        {
            # close record tag
            $Tags .= $this->FormatTag();
        }
        */

        # return tags to caller
        return $Tags;
    }

    private function EncodeIdentifier($ItemId)
    {
        # return encoded value to caller
        return "oai:".$this->RepDescr["IDDomain"]
                .":".$this->RepDescr["IDPrefix"]."-".$ItemId;
    }

    private function DecodeIdentifier($Identifier)
    {
        # assume that decode will fail
        $Id = NULL;

        # split ID into component pieces
        $Pieces = explode(":", $Identifier);

        # if pieces look okay
        if (($Pieces[0] == "oai") && ($Pieces[1] == $this->RepDescr["IDDomain"]))
        {
            # split final piece
            $Pieces = explode("-", $Pieces[2]);

            # if identifier prefix looks okay
            if ($Pieces[0] == $this->RepDescr["IDPrefix"])
            {
                # decoded value is final piece
                $Id = $Pieces[2];
            }
        }

        # return decoded value to caller
        return $Id;
    }

    private function DecodeDatabaseIdentifier($Identifier)
    {
        # assume that decode will fail
        $Id = NULL;

        # split ID into component pieces
        $Pieces = explode(":", $Identifier);

        # if pieces look okay
        if (($Pieces[0] == "oai") && ($Pieces[1] == $this->RepDescr["IDDomain"]))
        {
            # split final piece
            $Pieces = explode("-", $Pieces[2]);

            # if identifier prefix looks okay
            if ($Pieces[0] == $this->RepDescr["IDPrefix"])
            {
                $id_prefix = array_shift($Pieces);     //get and remove first element of array (prefix)
                $id_value = array_pop($Pieces);        //get and remove last element of array  (identifier)
                $database_name = implode('-',$Pieces); //databasename

                # decoded value is final piece  (database_name + id + datestamp)
                //$IdDB = $Pieces[1]."@".$Pieces[2] . '^' . date("Y-m-d") ;
                $IdDB = $database_name."@". $id_value . '^' . date("Y-m-d") ;
            }
        }

        # return decoded value to caller
        return $IdDB;
    }

    private function EncodeResumptionToken($StartingDate, $EndingDate, $MetadataFormat, $SetSpec, $ListStartPoint)
    {
        # concatenate values to create token
        $Token = $StartingDate."-_-".$EndingDate."-_-".$MetadataFormat."-_-"
                .$SetSpec."-_-".$ListStartPoint;

        # return token to caller
        return $Token;
    }

    private function DecodeResumptionToken($ResumptionToken)
    {
        # split into component pieces
        $Pieces = preg_split("/-_-/", $ResumptionToken);

        # if we were unable to split token
        if (count($Pieces) != 5)
        {
            # return NULL list
            $Args = NULL;
        }
        else
        {
            # assign component pieces to list parameters
            if (strlen($Pieces[0]) > 0) {  $Args["from"] = $Pieces[0];  }
            if (strlen($Pieces[1]) > 0) {  $Args["until"] = $Pieces[1];  }
            if (strlen($Pieces[2]) > 0) {  $Args["metadataPrefix"] = $Pieces[2];  }
            if (strlen($Pieces[3]) > 0) {  $Args["set"] = $Pieces[3];  }
            if (strlen($Pieces[4]) > 0) {  $Args["ListStartPoint"] = $Pieces[4];  }
        }

        # return list parameter array to caller
        return $Args;
    }

    private function DateIsInvalid($Date)
    {
        # if date is null or matches required format
        if (empty($Date) || preg_match("/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/", $Date))
        {
            # date is okay
            return FALSE;
        }
        else
        {
            # date is not okay
            return TRUE;
        }
    }

    private function FormatTag($Name = NULL, $Content = NULL, $Attributes = NULL, $NewIndentLevel = NULL)
    {
        static $IndentLevel = 1;
        static $OpenTagStack = array();

        # reset indent level if requested
        if ($NewIndentLevel !== NULL)
        {
            $IndentLevel = $NewIndentLevel;
        }

        # if tag name supplied
        if ($Name !== NULL)
        {
            # start out with appropriate indent
            $Tag = str_repeat(" ", ($IndentLevel * $this->IndentSize));

            # open begin tag
            $Tag .= "<".$Name;

            # if attributes supplied
            if ($Attributes !== NULL)
            {
                # add attributes
                foreach ($Attributes as $AttributeName => $AttributeValue)
                {
                    $Tag .= " ".$AttributeName."=\"".$AttributeValue."\"";
                }
            }

            # if content supplied
            if ($Content !== NULL)
            {
                # close begin tag
                $Tag .= ">";

                # add content
                $Tag .= htmlspecialchars($Content);

                # add end tag
                $Tag .= "</".$Name.">\n";
            }
            else
            {
                # close begin tag
                $Tag .= ">\n";

                # increase indent level
                $IndentLevel++;

                # add tag to open tag stack
                array_push($OpenTagStack, $Name);
            }
        }
        else
        {
            # decrease indent level
            if ($IndentLevel > 0) {  $IndentLevel--;  }

            # pop last entry off of open tag stack
            $LastName = array_pop($OpenTagStack);

            # start out with appropriate indent
            $Tag = str_repeat(" ", ($IndentLevel * $this->IndentSize));

            # add end tag to match last open tag
        if ($LastName !== NULL){    $Tag .= "</".$LastName.">\n";   }
        }

        # return formatted tag to caller
        return $Tag;
    }

    private function LoadArguments()
    {
        # if request type available via POST variables
        if (isset($_POST["verb"]))
        {
            # retrieve arguments from POST variables
            $this->Args = $_POST;
        }
        # else if request type available via GET variables
        elseif (isset($_GET["verb"]))
        {
            # retrieve arguments from GET variables
            $this->Args = $_GET;
        }
        else
        {
            # ERROR OUT
            # ???
        }

        # clear out ApplicationFramework  page specifier if set
        if (isset($this->Args["P"])) {  unset($this->Args["P"]);  }
    }

    # ---- methods to support OAI-SQ

    private function IsOaisqQuery($SetString)
    {
        return ((strpos($SetString, "OAI-SQ|") === 0)
                || (strpos($SetString, "OAI-SQ!") === 0)
                || (strpos($SetString, "OAI-SQ-F|") === 0)
                || (strpos($SetString, "OAI-SQ-F!") === 0)
        ) ? TRUE : FALSE;
    }

    private function TranslateOaisqEscapes($Pieces)
    {
        # for each piece
    for ($Index = 0;  $Index < count($Pieces);  $Index++)
    {
        # replace escaped chars with equivalents
        $Pieces[$Index] = preg_replace_callback(
                "/~[a-fA-F0-9]{2,2}/",
            create_function(
            '$Matches',
            'for ($Index = 0;  $Index < count($Matches);  $Index++)'
                .'{'
                .'    $Replacements = chr(intval(substr($Matches[$Index], 1, 2), 16));'
                .'}'
                .'return $Replacements;'
            ),
            $Pieces[$Index]);
    }

    # return translated array of pieces to caller
    return $Pieces;
    }

    private function ParseOaisqQuery($SetString, $FormatName)
    {
        # if OAI-SQ fielded search requested
        if (strpos($SetString, "OAI-SQ-F") === 0)
        {
            # split set string into field names and values
            $Pieces = explode(substr($SetString, 8, 1), $SetString);

            # discard first piece (OAI-SQ designator)
            array_shift($Pieces);

        # if set string contains escaped characters
        if (preg_match("/~[a-fA-F0-9]{2,2}/", $SetString))
        {
            $Pieces = $this->TranslateOaisqEscapes($Pieces);
        }

            # for every two pieces
            $SearchParams = array();
            $NumPairedPieces = round(count($Pieces) / 2) * 2;
            for ($Index = 0;  $Index < $NumPairedPieces;  $Index += 2)
            {
                # retrieve local field mapping
                $LocalFieldName = array_search($Pieces[$Index], $this->FieldMappings[$FormatName]);

                # if local field mapping found
                if (strlen($LocalFieldName))
                {
                    # add mapped values to search parameters
                    $SearchParams[$LocalFieldName] = $Pieces[$Index + 1];
                }
            }
        }
        else
        {
            # split set string to trim off query designator
            $Pieces = explode(substr($SetString, 6, 1), $SetString, 2);

        # if set string contains escaped characters
        if (preg_match("/~[a-fA-F0-9]{2,2}/", $SetString))
        {
            $Pieces = $this->TranslateOaisqEscapes($Pieces);
        }

            # remainder of set string is keyword search string
            $SearchParams["X-KEYWORD-X"] = $Pieces[1];
        }

        # return array of search parameters to caller
        return $SearchParams;
    }
}

interface OAIItemFactory {

    function GetItem($ItemId);
    function GetItems($StartingDate = NULL, $EndingDate = NULL);

    # retrieve IDs of items that matches set spec (only needed if sets supported)
    function GetItemsInSet($SetSpec, $StartingDate = NULL, $EndingDate = NULL);

    # return array containing all set specs (with human-readable set names as keys)
    # (only used if sets supported)
    function GetListOfSets();

    # retrieve IDs of items that match search parameters (only used if OAI-SQ supported)
    function SearchForItems($SearchParams, $StartingDate = NULL, $EndingDate = NULL);
}

interface OAIItem {

    function GetId();
    function GetDatestamp();
    function GetValue($ElementName);
    function GetQualifier($ElementName);
    function GetSets();
    function GetSearchInfo();
    function Status();
}


?>
