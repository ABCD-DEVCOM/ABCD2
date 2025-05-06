<?php
// Function to obtain the client's real IP
function get_client_ip()
{
    $keys = [
        'HTTP_CLIENT_IP',
        'HTTP_X_FORWARDED_FOR',
        'REMOTE_ADDR'
    ];
    foreach ($keys as $key) {
        if (!empty($_SERVER[$key])) {
            return $_SERVER[$key];
        }
    }
    return 'IP_desconhecido';
}

// Validation function against dangerous standards
function is_malicious($str)
{
    $patterns = [
        '/<script\b/i',
        '/(and|or)\s+\d+=\d+/i',
        '/[\'"`]\s*(or|and)?\s*\d+=\d+/i',
        '/[\'"`]\s*--/',
        '/<.*?>/',
        '/\b(select|union|insert|delete|update|drop|eval|alert)\b/i'
    ];
    foreach ($patterns as $pattern) {
        if (preg_match($pattern, $str)) return true;
    }
    return false;
}


// Function that validates entries
function validate_inputs($inputs, $source = 'INPUT')
{
    $ip = get_client_ip();
    foreach ($inputs as $key => $value) {
        if (is_array($value)) {
            foreach ($value as $subval) {
                if (is_malicious($subval)) {
                    error_log("⚠️ Blocked IP attack $ip: $source [$key] => $subval");
                    die("Invalid input detected.<br><h1> Registered IP: $ip");
                }
            }
        } else {
            if (is_malicious($value)) {
                error_log("⚠️ Blocked IP attack $ip: $source [$key] => $value");
                die("Invalid input detected. <h1> Registered IP: $ip");
            }
        }
    }
}

// Apply validation
validate_inputs($_GET, 'GET');
validate_inputs($_POST, 'POST');
validate_inputs($_REQUEST, 'REQUEST');
