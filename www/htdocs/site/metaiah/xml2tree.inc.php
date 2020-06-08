<?php
/*
xml2tree.inc , the core library of the xml2tree project

This software is available under the Ricoh Public Source Code License,
available with this distribution or at www.risource.org.

version 0.1 Bill Softky June 2000
version 0.2 Bill Softky July 2000 (fixed fault in treeNode->copy() )
version 1.0 Bill Softky December 2000 (added deleteChild template arg
              [suggestion: Jesse Griffis] and  top-level xml version tag
              [suggeestion: Denis Valdenaire] )
*/

  class treeNode{
    var $parent;

    var $name;
    var $attributes;
    var $children;


    public function __construct( $newName ){
      $this->name = $newName;
      $children = array();
      $attributes = array();
    }

    // copy() does an infinitely deep copy, as does copy(-1); any non-negative
    // argument tells how deep the copy should be
    function copy($deep="-1"){
      // create new node and set everything but parent here
      $nodeCopy = new treeNode ($this->name);
      //      $nodeCopy->name = $this->name;
      $nodeCopy->attributes = $this->attributes;

      if ( $deep != 0){
    // walk through children, copying nodes if necessary
    $childCount =  count($this->children);
    for ($idx=0; $idx < $childCount ; $idx ++){
      $temp2 = &$this->children[ $idx ];
      // copy this child node if depth still sufficient

      if (gettype( $temp2 ) =="object" ){
        $nodeCopy->children[ $idx ] = $temp2->copy( $deep - 1);
        // children get parents set; top-level doesn't
        $nodeCopy->children[ $idx ]->parent = &$this;
      }
      // copy this string
      else{
        $nodeCopy->children[ $idx ] =  $temp2 ;
      }
    }
      }
      return $nodeCopy;
    }

    // default for inserting a child node is appending; any non-negative
    // integer passed in will put child as close to that location as possible.
    function insertChildNode( &$newChild , $newPlace="-1"){
      // first tell this child who its parent is
      $newChild->parent = &$this;

      $lastPlace = count ($this->children) - 1;
      // if $newPlace < 0, or $newPlace > max,
      // append new child to end of list
      if ($newPlace < 0 || $newPlace > $lastPlace){
    $this->children[ $lastPlace + 1 ] = &$newChild;
      }
      // otherwise have to insert and re-jigger all other children
      else{
    // first make an opening by starting from topmost and moving each up
    for ( $idx = $lastPlace ; $idx >= $newPlace; $idx --){
      $this->children[ $idx + 1] = &$this->children[ $idx ];
    }
    // then stuff new one into opening
    $this->children[ $newPlace] = &$newChild;
      }
    }


    // default for inserting a child node is appending; any non-negative
    // integer passed in will put child as close to that location as possible.
    function insertChildCopy( &$newChild , $newPlace="-1"){

      // first tell this child who its parent is
      // //$newChild->parent = &$this;

      $lastPlace = count ($this->children) - 1;
      // if $newPlace < 0, or $newPlace > max,
      // append new child to end of list
      if ($newPlace < 0 || $newPlace > $lastPlace){
    //    $this->children[ $lastPlace + 1 ] = $newChild;
    $this->children[ $lastPlace + 1 ] = $newChild->copy();
    $this->children[ $lastPlace + 1 ]->parent = &$this;
      }
      // otherwise have to insert and re-jigger all other children
      else{
    // first make an opening by starting from topmost and moving each up
    for ( $idx = $lastPlace ; $idx >= $newPlace; $idx --){
      $this->children[ $idx + 1] = $this->children[ $idx ];
      //      $this->children[ $idx + 1] = &$this->children[ $idx ];
    }
    // then stuff new one into opening
    //    $this->children[ $newPlace] = $newChild;


    $this->children[ $newPlace ] = $newChild->copy();
    $this->children[ $newPlace ]->parent = &$this;
      }
    }



    // default for inserting a child node is appending; any non-negative
    // integer passed in will put child as close to that location as possible.
    function insertChildText( $newChild , $newPlace="-1"){

      $lastPlace = count ($this->children) - 1;
      // if $newPlace < 0, or $newPlace > max,
      // append new child to end of list
      if ($newPlace < 0 || $newPlace > $lastPlace){
    $this->children[ $lastPlace + 1 ] = $newChild;
      }
      // otherwise have to insert and re-jigger all other children
      else{
    // first make an opening by starting from topmost and moving each up
    for ( $idx = $lastPlace ; $idx >= $newPlace; $idx --){
      $this->children[ $idx + 1] = $this->children[ $idx ];
    }
    // then stuff new one into opening
    $this->children[ $newPlace] = $newChild;
      }
    }

    // kills the child at the location designated by $killSpec (or at the nearest
    // location to it), and fills in the leftover hole(s)
    function deleteChild( $killSpec){

      if ($killSpec == "") // default to "integer" version of zero
    $killSpec = 0;

      // if killSpec is a template object, kill every child matching it
      if ( gettype( $killSpec) =="object"){
    $template = $killSpec;
    for ($idx = 0; $idx < count ($this->children); $idx++){

      // to kill a child, any existing property of template must be
      // matched by the to-be-killed child (i.e. an empty template kills
      // everything!)

      if ( $template->name &&
           $template->name != $this->children[$idx]->name){
        continue;
      }


      // each attribute in template should be matched
      if ($template->attributes){
        reset ($template->attributes);
        $myKey =  key($template->attributes);
        $nope = "";
        while ($myKey ){
          if ( $template->attributes[ $myKey ] != $this->children[$idx]->attributes[ $myKey ])
        $nope = "bad attributes";
          $myKey = next ( $template->attributes );
        }
      }

      if  (!$nope)  // if everthing matches, kill this child
        // (using integer spec, not template, on this function)
        $this->deleteChild( $idx);
    }
      }
      // if killSpec is an integer, kill the child at that location
      else if ( gettype( $killSpec) =="integer") {
    $killPlace  = $killSpec;

    $lastPlace = count ($this->children) - 1;
    if ($killPlace < 0 ){
      $killPlace = 0;
    }
    if ($killPlace > $lastPlace){
      $killPlace = $lastPlace;
    }

    // move everybody down one, starting by overwriting the
    // to-be-killed child
    for ( $idx = $killPlace ; $idx <= $lastPlace; $idx ++){
      $this->children[ $idx ] = &$this->children[ $idx + 1];
    }
    // finally get rid of the final one (now redundant)
    unset ( $this->children[ $lastPlace] );
    unset ( $this->children[ $lastPlace + 1] ); // odd, but necessary
      }
      else
    echo "OOPS! deleteChild() needs either a template or integer argument<br>\n";

    }


    function deleteAttribute( $attKey ){
      unset ($this->attributes[ $attKey ]);
    }

    // prints so that formatted XML is visible in Page Source
    function printEcho(){
      $outString = "";
      $this->printOut( $outString );
      echo $outString;
    }


    // prints so that formatted XML is visible in browser display
    function printHTML(){
      $outString = "";
      // to make indentation visible in HTML, you need spacers instead of
      // regular spaces.  So indent with some recognizable string, then replace
      // it with spacers (*after* converting angle brackets!).
      $this->printOut( $outString, "");
      // convert angle brackets and &'s
      $outString = htmlspecialchars( $outString);
      // new-line to break conversion
      $outString = nl2br( $outString );
      // create spacers from indentation placeholders
      $outString = str_replace("xxxY",
                "<spacer type=\"horizontal\" size=\"30\" >",
                $outString);
      echo $outString;
    }


    function printOut(&$xmlString,  $indent=" "){
      if ($indent[0] != " ")
        $indentInc = "xxxY";
      else
        $indentInc = "     ";
      $temp = $this->name;
      // print out (indented) tag with tag-name
      //$xmlString .=  $indent; current line
      $xmlString .=  "\n"; //new line
      $xmlString .=  $indent . "<$temp ";

      // print attributes inside tag
      $attCount =  count($this->attributes);
      if ($attCount > 0)
            reset ($this->attributes);
      while ($attCount > 0  && $myKey =  key($this->attributes) ){
            $xmlString .= "  " . $myKey . "=\"" .  htmlspecialchars(current($this->attributes)) ."\" " ;
            next ( $this->attributes );
      }
      //$xmlString .= ">\n" ; current line
      $xmlString .= ">" ; //new line

      $childCount =  count($this->children);

      for ($idx=0; $idx < $childCount ; $idx ++){
        $temp2 = $this->children[ $idx ];
        // print out this child node
        if (gettype( $temp2 ) =="object"){
          $temp2->printOut( $xmlString,  $indent . $indentInc );
        }
        // print out this child text
        else{
          //$xmlString .=  $indent . $indentInc; current line
          //$xmlString .=  $temp2."\n"; current line
          $xmlString .=  $temp2; //new line
        }
      }

      //$xmlString .=  $indent; current line
      $xmlString .= "</$temp>" . $indentInc; //new line
    }



    function printText(&$xmlString){
      // print content-text only, no tags or attributes

      $childCount =  count($this->children);
      for ($idx=0; $idx < $childCount ; $idx ++){
    $temp2 = $this->children[ $idx ];

    // print out this child node
    if (gettype( $temp2 ) =="object"){
      $temp2->printText( $xmlString );
    }
    // print out this child text
    else{
      $xmlString .=  $temp2." ";
    }
      }
    }

    // extracts references to any node with the same name and
    // attribute values as the template
    function extract( &$resultArray, $template, $depth=0 ){

      // echo "\ntemplate: " .  $template->name . "    this:" . $this->name ;

      // name in template should be matched
      if ( $template->name && $template->name != $this->name){
    $nope="bad name";
      }

      // each attributes in template should be matched
      if ($template->attributes){
    reset ($template->attributes);
    $myKey =  key($template->attributes);
    while ($myKey ){
      if ( $template->attributes[ $myKey ] != $this->attributes[ $myKey ])
        $nope = "bad attributes";
      $myKey = next ( $template->attributes );
    }
      }
      if ( !$nope ){
    //    $newIdx = count ($resultArray[ $depth ] );

    //    $resultArray[ $depth ][ $newIdx ] = &$this;
    $newIdx = count ($resultArray["depth"] );
    $resultArray["nodes"][ $newIdx ] = &$this;
    $resultArray["depth"][ $newIdx ] = $depth;
      }

      // after checking this node, descend into children
      $childCount =  count($this->children);
      for ($idx=0; $idx < $childCount ; $idx ++){
    $temp2 = &$this->children[ $idx ];

    // print out this child node
    if (gettype( $temp2 ) =="object"){
      $temp2->extract($resultArray, $template, $depth + 1);
    }

      }

    }

    // extracts only those nodes at a specific depths, and returns
    // a flat array of those nodes, rather than a 2xN array
    // i.e. ["nodes"][N] + ["depth"][N]
    function extractAtDepth( &$resultArray, $template, $targetDepth ){
      // do an ordinary extract, and weed out everything not at the
      // target depth
      $this-> extract( $tempResults, $template);

      // to keep references intact, you need to explicitly address
      // each array by index; current() only gives a copy
      for ($idx = 0; $idx < count ($tempResults["nodes"]); $idx ++){
    $tempDepth = $tempResults["depth"][ $idx];
    if ( $targetDepth == $tempDepth){
      $resultArray[] = &$tempResults["nodes"][ $idx] ;
    }
      }

    }
}


//   ----------------------  end of class definition ---------

function startElement($parser, $name, $attrs)
{

    $parent = &$GLOBALS["currentNode"];
    $GLOBALS["currentNode"]->children[] = new treeNode( $name);
    $newIdx =   count(  $GLOBALS["currentNode"]->children ) -1;

    // reassign "currentNode" to the newly created child
    $GLOBALS["currentNode"] = &$GLOBALS["currentNode"]->children[ $newIdx ];

    // fill in attributes
    $GLOBALS["currentNode"]->attributes = $attrs;
    // let new child know about its parent
    $GLOBALS["currentNode"]->parent = &$parent;

}

function endElement($parser, $name)
{
  $GLOBALS["currentNode"] = &$GLOBALS["currentNode"]->parent;
}

function characterData($parser, $data)
{
  // chuck blank text
  $test = trim( $data );
  if ($test == "")
    return;

  // store non-blank text as a new child string
  $newIdx =   count(  $GLOBALS["currentNode"]->children ) ;
  $GLOBALS["currentNode"]->children[ $newIdx ] = $test;
}


// readXML reads $xmlFile and returns a treeNode with the contents
function readXML($xmlFile ){

  $topNode = new treeNode ($xmlFile);
  global  $currentNode;
  $GLOBALS["currentNode"] = &$topNode;

  $xml_parser = xml_parser_create();
  // use case-folding so we are sure to find the tag in $map_array
  xml_parser_set_option($xml_parser, XML_OPTION_CASE_FOLDING, false);
  xml_set_element_handler($xml_parser, "startElement", "endElement");
  xml_set_character_data_handler($xml_parser,
                 "characterData");
  //xml_set_external_entity_ref_handler($xml_parser, "externalEntityRefHandler");

  if (!($fp = fopen($xmlFile, "r"))) {
    die("could not open XML input");
  }

  while ($data = fread($fp, 4096)) {

    if (!xml_parse($xml_parser, $data, feof($fp))) {
      die(sprintf("XML error: %s at line %d",
          xml_error_string(xml_get_error_code($xml_parser)),
          xml_get_current_line_number($xml_parser)));
    }
  }
  xml_parser_free($xml_parser);


  // don't return outermost tag with filename, but just what was read from file
  return $topNode->children[0];
}



// parseXMLstring reads $xmlContent and returns a treeNode with the contents
function parseXMLstring( $xmlContent ){
  $topNode = new treeNode ($xmlContent);
  global  $currentNode;
  $GLOBALS["currentNode"] = &$topNode;

  $xml_parser = xml_parser_create('ISO-8859-1');
  // use case-folding so we are sure to find the tag in $map_array
  xml_parser_set_option($xml_parser, XML_OPTION_CASE_FOLDING, false);
  xml_parser_set_option($xml_parser, XML_OPTION_TARGET_ENCODING, 'ISO-8859-1');
  xml_set_element_handler($xml_parser, "startElement", "endElement");
  xml_set_character_data_handler($xml_parser,
                 "characterData");
  //xml_set_external_entity_ref_handler($xml_parser, "externalEntityRefHandler");

  if ( $xmlContent == "" ) {
    die("parseXMLstring can't parse an empty string!");
  }

  /*
   * O XML Parser do PHP 5 apresenta problemas com entradas ISO-8859-1. Segundo a
   * documenta��o, deveria haver uma detec��o autom�tica, por�m, todo documento
   * de entrada e assumido como UTF-8.
   */
  $xmlContent = utf8_encode($xmlContent);

  // parse all xml in one fell swoop
  if (!xml_parse($xml_parser, $xmlContent,true)) {
      throw new ErrorException(
              xml_error_string(xml_get_error_code($xml_parser)),
              xml_get_error_code($xml_parser),  99,  'xml',
              xml_get_current_line_number($xml_parser)
          );
    return FALSE;
  }

  xml_parser_free($xml_parser);

  // don't return outermost tag with filename, but just what was read from file
  return $topNode->children[0];
}





function writeXML($outFileName, $topOutNode){
  $stringToWrite = "<?xml version='1.0' encoding='iso-8859-1' ?>\n";
  $topOutNode->printOut( $stringToWrite );

  $fpSave = fopen( $outFileName, "w");
  fwrite($fpSave, $stringToWrite);
  fclose( $fpSave);
}

?>