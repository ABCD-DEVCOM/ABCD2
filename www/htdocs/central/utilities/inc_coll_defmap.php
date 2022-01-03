<?php
/*
20211230 fho4abcd extracted from docfile_config
*/
// Define default array for Dublin Core metadata elements + ABCD elements and their initial map
// Map defined here to ensure availability
$defTagMap=array();
array_push($defTagMap,array("term"=>"title", "label"=>$msgstr['dd_term_title'], "field"=>"v1"));
array_push($defTagMap,array("term"=>"creator", "label"=>$msgstr['dd_term_creator'], "field"=>"v2"));
array_push($defTagMap,array("term"=>"subject", "label"=>$msgstr['dd_term_subject'], "field"=>"v3"));
array_push($defTagMap,array("term"=>"description", "label"=>$msgstr['dd_term_description'], "field"=>"v4"));
array_push($defTagMap,array("term"=>"publisher", "label"=>$msgstr['dd_term_publisher'], "field"=>"v5"));
array_push($defTagMap,array("term"=>"contributor", "label"=>$msgstr['dd_term_contributor'], "field"=>"v6"));
array_push($defTagMap,array("term"=>"date", "label"=>$msgstr['dd_term_date'], "field"=>"v7"));
array_push($defTagMap,array("term"=>"type", "label"=>$msgstr['dd_term_type'], "field"=>"v8"));
array_push($defTagMap,array("term"=>"format", "label"=>$msgstr['dd_term_format'], "field"=>"v9"));
array_push($defTagMap,array("term"=>"identifier", "label"=>$msgstr['dd_term_identifier'], "field"=>"v10"));
array_push($defTagMap,array("term"=>"source", "label"=>$msgstr['dd_term_source'], "field"=>"v11"));
array_push($defTagMap,array("term"=>"language", "label"=>$msgstr['dd_term_language'], "field"=>"v12"));
array_push($defTagMap,array("term"=>"relation", "label"=>$msgstr['dd_term_relation'], "field"=>"v13"));
array_push($defTagMap,array("term"=>"coverage", "label"=>$msgstr['dd_term_coverage'], "field"=>"v14"));
array_push($defTagMap,array("term"=>"rights", "label"=>$msgstr['dd_term_rights'], "field"=>"v15"));
$defTagMapCntDC=count($defTagMap);
array_push($defTagMap,array("term"=>"htmlSrcURL", "label"=>$msgstr['dd_term_htmlSrcURL'], "field"=>"v95"));
array_push($defTagMap,array("term"=>"sections", "label"=>$msgstr['dd_term_section'], "field"=>"v97"));
array_push($defTagMap,array("term"=>"url", "label"=>$msgstr['dd_term_url'], "field"=>"v98"));
array_push($defTagMap,array("term"=>"doctext", "label"=>$msgstr['dd_term_doctext'], "field"=>"v99"));
array_push($defTagMap,array("term"=>"idpartmax", "label"=>$msgstr['dd_term_idpartmax'], "field"=>"v109"));
array_push($defTagMap,array("term"=>"idpart", "label"=>$msgstr['dd_term_idpart'], "field"=>"v110"));
array_push($defTagMap,array("term"=>"id", "label"=>$msgstr['dd_term_id'], "field"=>"v111"));
array_push($defTagMap,array("term"=>"dateadded", "label"=>$msgstr['dd_term_dateadded'], "field"=>"v112"));
array_push($defTagMap,array("term"=>"htmlfilesize", "label"=>$msgstr['dd_term_htmlfilesize'], "field"=>"v997"));
$defTagMapCnt=count($defTagMap);
$defTagMapCntABCD=$defTagMapCnt-$defTagMapCntDC;
