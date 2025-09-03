<?php

/**
 * Check if there is a new version of ABCD available on Github.
 * Use a cache to avoid excessive checks in the API.
 *
 * @param string $local_version A versão atual instalada (ex: "v2.3.0").
 * @return array An array with 'update_available' (bool) and 'new_version' (string).
 */
function checkForABCDUpdate($local_version)
{
    // Repository for the test.Remember to change to ABCD-Devcom/ABCD in production.
    $repo_url = 'https://api.github.com/repos/ABCD-DEVCOM/ABCD2/releases';
    $cache_file = __DIR__ . '/version_cache.json';
    $cache_lifetime = 43200; // 12 hours in seconds

    // Try to read the cache first
    if (file_exists($cache_file) && (time() - filemtime($cache_file) < $cache_lifetime)) {
        $cached_data = json_decode(file_get_contents($cache_file), true);
        if ($cached_data && isset($cached_data['tag_name'])) {
            $remote_version = $cached_data['tag_name'];
        }
    }

    // If there is no cache or he is expired, search in the API
    if (!isset($remote_version)) {
        $options = [
            'http' => [
                'method' => 'GET',
                'header' => "User-Agent: ABCD-Version-Checker\r\n" .
                    "Accept: application/vnd.github.v3+json\r\n"
            ]
        ];
        $context = stream_context_create($options);
        $response = @file_get_contents($repo_url, false, $context);

        if ($response) {
            $data = json_decode($response, true);

            // We verify if the answer is a list (array) and if it is not empty.
            if ($data && is_array($data) && !empty($data)) {

                // The latest version is the first item on the list.
                $latest_release = $data[0];

                // Look for 'tag_name' within the first item.
                if (isset($latest_release['tag_name'])) {
                    $remote_version = $latest_release['tag_name'];

                    // Save the result in the cache for the next time
                    file_put_contents($cache_file, json_encode(['tag_name' => $remote_version]));
                }
            }
        }
    }

    // If, after everything, you can't get the remote version, it ends.
    if (!isset($remote_version)) {
        return ['update_available' => false, 'new_version' => ''];
    }

    // Compares the versions
    $update_available = version_compare($remote_version, $local_version, '>');

    return [
        'update_available' => $update_available,
        'new_version'      => $remote_version
    ];
}
