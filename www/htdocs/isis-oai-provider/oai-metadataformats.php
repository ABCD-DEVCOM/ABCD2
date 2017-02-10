<?php

// Define array for available MetadataFormats 

$METADATAFORMATS['oai_dc'] = array( 'TagName' => 'oai_dc:dc', 
						'SchemaNamespace' => 'http://www.openarchives.org/OAI/2.0/oai_dc/',
						'SchemaDefinition' => 'http://www.openarchives.org/OAI/2.0/oai_dc.xsd',
						'SchemaVersion' => '',
						'NamespaceList' => '',
						'Namespaces' => array(
								'oai_dc' => 'http://www.openarchives.org/OAI/2.0/oai_dc/',
								'dc' => 'http://purl.org/dc/elements/1.1/',
							),
						);


$METADATAFORMATS['isis']  = array( 'TagName' => 'isis', 
                        'SchemaNamespace' => 'http://reddes.bvsalud.org/OAI/1.0/isis/',
                        'SchemaDefinition' => 'http://reddes.bvsalud.org/OAI/1.0/isis.xsd',
                        'SchemaVersion' => '',
                        'NamespaceList' => '',
                        'Namespaces' => array(
                                'isis' => 'http://reddes.bvsalud.org/OAI/1.0/isis/',
                            ),
                        );

?>