<?php
    // The 'include' below define our paths and current language
    include('../php/include.php');

    $q = 'salud';
    if(isset($_GET['q'])) {
        $q = $_GET['q'];
    } else if(count($argc) > 0) {
        foreach ($argv as $arg) {
            if(preg_match('/^(q)=([a-zA-Z0-9 ]+)$/', $arg, $matches)
                    || preg_match('/^(lang)=([a-z][a-z])$/', $arg, $matches)){
                $$matches[1] = $matches[2];
            }
        }
    }
    $localPath['xml'] = $def['DATABASE_PATH'] . "xml/" . $lang . "/";

    ob_implicit_flush(true);
    header('Content-Type: text/plain; charset=utf-8');

    // The metasearch XML file location
    $metaiah_file = $localPath['xml'] . 'metaiah.xml';

    print("= Metaiah test script =\n\n");

    printf("* query term: %s\n", $q);
    printf("* current language: %s\n", $lang);

    print("\n");
    if( file_exists($metaiah_file) ) {
        $metaiah_xml = simplexml_load_file($metaiah_file);
        
        foreach( $metaiah_xml->sourceList->group as $group ) {
            printf("== Searching on '%s' ==\n", $group['label']);

            foreach( $group->item as $item ) {
                printf("=== %s ===\n", $item['label']);
                printf("# id: %s\n", $item['id']);

                $searchParam = $metaiah_xml->search->xpath(
                        "item[@source='{$item['id']}']/@search-parameters");
                $searchParam = $searchParam[0];

                printf("# search parameter: '%s'\n", $searchParam);


                $search_url = html_entity_decode($item['base-search-url'])
                     . '&' . $searchParam . $q;

                printf("# Using URL: %s\n", $search_url);

                $start = time();
                $service_response = simplexml_load_file($search_url);
                printf("# Ellapsed time: %ss\n", time() - $start );


                if($service_response === false) {
                    print("# Server response: Failed!\n");
                } else {
                    $possible_xpaths = array('//Isis_Total/occ',
                                             '//Isis_Total',
                                             '//total-hits',
                                             '//total');
                    $total = array();
                    for($i=0; $i<count($possible_xpaths) && count($total)==0; $i++){
                        $total = $service_response->xpath($possible_xpaths[$i]);
                    }

                    $total = array_shift($total);
                    printf("# Server response total documents: %s\n", $total);
                }
                
                print("\n");
            }
            print("\n");
        }
    }
?>
