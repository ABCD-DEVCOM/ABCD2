<?php
// oai-databases.php

$DATABASES_CONFIG = [
    'marc' => [
        'name' => 'marc',
        'description' => 'MARC',
        // IMPORTANT: Adjust the path for your installation.
        'database' => IS_WINDOWS ? 'C:/xampp/htdocs/ABCD2/www/bases-examples_Windows/marc/data/marc' : '/ABCD2/www/bases-examples_Linux/marc/data/marc',
        'mapping' => 'marc.i2x',
        'prefix' => 'oai_date_',
        'cisis_version' => 'ansi/',
        'identifier_field' => '1',
        'datestamp_field' => '980'
    ],
    'dubcore' => [
        'name' => 'dubcore',
        'description' => 'DublinCore repository',
        // IMPORTANT: Adjust the path for your installation.
        'database' => IS_WINDOWS ? 'C:/xampp/htdocs/ABCD2/www/bases-examples_Windows/dubcore/data/dubcore' : '/ABCD2/www/bases-examples_Linux/dubcore/data/dubcore',
        'mapping' => 'dubcore.i2x',
        'prefix' => 'oai_date_',
        'cisis_version' => IS_WINDOWS ? 'utf8/bigisis/' : 'utf8/bigisis/',
        'identifier_field' => '111',
        'datestamp_field' => '507'
    ]
];
