<?php
// oai-config.php

// --- OPERATING SYSTEM DETECTION ---
define('IS_WINDOWS', strtoupper(substr(PHP_OS, 0, 3)) === 'WIN');

// --- BASIC PATHS FOR EACH ENVIRONMENT ---
// Change these paths to match your installation
$database_path_win = "C:/xampp/htdocs/ABCD2/www/bases-examples_Windows/";
$database_path_lin = "/var/opt/ABCD/bases/";

// --- GLOBAL CONFIGURATION ARRAY ---
$CONFIG = [
    'ENVIRONMENT' => [
        'DATABASE_PATH' => IS_WINDOWS ? $database_path_win : $database_path_lin,
        'DIRECTORY' => '/isis-oai-provider',
        'EXE_EXTENSION' => IS_WINDOWS ? '.exe' : '',
        'CGI-BIN_DIRECTORY' => '/cgi-bin/'
    ],
    'INFORMATION' => [
        'NAME' => 'ABCD',
        'EMAIL' => 'contact@abcd-community.org',
        'IDPREFIX' => 'org',
        'IDDOMAIN' => 'abcd-community',
        'EARLIESTDATESTAMP' => '2025-01-01',
        'MAX_ITEMS_PER_PASS' => 20
    ],
    // NEW LANGUAGE SECTION
    'LANGUAGES' => [
        'default' => 'en',
        'available' => [
            'pt-br' => 'Português (BR)',
            'en' => 'English'
            // Add new languages here, ex: 'es' => 'Español'
        ]
    ]
];