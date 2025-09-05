<?php
// Increases the maximum execution time to 10 minutes (600 seconds).
set_time_limit(600);

/**
 * ==============================================================================
 * ABCD - V3.0 Software Update Manager (Interactive)
 * ==============================================================================
 *
 * DESCRIPTION:
 * This script presents an interface for the administrator, displaying the
 * information from the last Github release and allowing you to choose between a
 * partial (default, secure) or complete update (surpasses everything except
 * the config.php).
 *
 * @version 3.0.0
 * @author Roger Craveiro Guilherme
 */


// --- General Settings ---
define('GITHUB_REPOSITORY', 'ABCD-DEVCOM/ABCD');
require_once(__DIR__ . '/version.php');
define('LOCAL_VERSION', ABCD_VERSION);
define('USER_CONFIG_FILE', 'htdocs/central/config.php');

const UPDATE_MAP = [
    'www/htdocs/central'              => 'htdocs',
    'www/htdocs/assets'               => 'htdocs',
    'www/htdocs/opac'                 => 'htdocs',
    'www/bases-examples_Windows/lang' => 'bases'
];


// --- SECURITY ---
function isAdmin()
{
    // Exemplo: session_start(); if(isset($_SESSION['profile']) && $_SESSION['profile']=='ADMIN') return true;
    return true;
}


// --- Main logic ---
if (ob_get_level() == 0) ob_start();

function logMessage($message, $type = 'info')
{
    $color = '#fff';
    if ($type === 'success') $color = '#28a745';
    if ($type === 'error') $color = '#dc3545';
    if ($type === 'warning') $color = '#ffc107';
    echo '<p class="log-line" style="color: ' . $color . ';">[' . date('H:i:s') . '] ' . htmlspecialchars($message) . '</p>';
    ob_flush();
    flush();
}

function getLatestReleaseInfo()
{
    $api_url = 'https://api.github.com/repos/' . GITHUB_REPOSITORY . '/releases';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['User-Agent: ABCD-Update-Manager']);
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        throw new Exception('Curl Communication Error: ' . curl_error($ch));
    }
    curl_close($ch);

    $all_releases = json_decode($response, true);

    // --- Improved error verification logic ---
    // If the answer contains the 'Message' key, it is an API error (eg request limit)
    if (isset($all_releases['message'])) {
        throw new Exception('Erro da API do GitHub: ' . $all_releases['message']);
    }

    // If the answer is not an array or is empty, there are no releases
    if (!$all_releases || !is_array($all_releases) || empty($all_releases)) {
        throw new Exception('No release found or invalid response of the repository.');
    }

    // If everything worked out, the first item returns (the most recent)
    return $all_releases[0];
}

function recursiveDelete($dir)
{
    if (!is_dir($dir)) return;
    $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS), RecursiveIteratorIterator::CHILD_FIRST);
    foreach ($files as $fileinfo) {
        $todo = ($fileinfo->isDir() ? 'rmdir' : 'unlink');
        $todo($fileinfo->getRealPath());
    }
    rmdir($dir);
}
function recursiveCopy($src, $dst)
{
    if (!is_dir($dst)) mkdir($dst, 0755, true);
    $len = strlen($src);
    $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($src, RecursiveDirectoryIterator::SKIP_DOTS), RecursiveIteratorIterator::SELF_FIRST);
    foreach ($files as $fileinfo) {
        $subPath = substr($fileinfo->getPathname(), $len);
        $target = $dst . $subPath;
        if ($fileinfo->isDir()) {
            if (!is_dir($target)) mkdir($target, 0755, true);
        } else {
            $parentDir = dirname($target);
            if (!is_dir($parentDir)) {
                mkdir($parentDir, 0755, true);
            }
            copy($fileinfo->getRealPath(), $target);
        }
    }
}
function cleanup($dir)
{
    if (is_dir($dir)) {
        recursiveDelete($dir);
    }
}


/**
 * Update process orchestrator
 */
function runUpdateProcess($update_type)
{
    $site_root = __DIR__;
    $temp_dir = sys_get_temp_dir() . '/abcd_update_' . time();
    $backup_dir = $temp_dir . '/backup';
    $unzip_dir = $temp_dir . '/unzipped';

    mkdir($temp_dir, 0755, true);
    mkdir($backup_dir, 0755, true);
    mkdir($unzip_dir, 0755, true);

    try {
        logMessage("Starting Type Update Process: " . ucfirst($update_type));

        // --- 1. Backup and configuration reading ---
        $user_config_path = $site_root . '/' . USER_CONFIG_FILE;
        if (file_exists($user_config_path)) {
            $backup_file = $backup_dir . '/' . basename($user_config_path);
            if (!copy($user_config_path, $backup_file)) {
                throw new Exception("Failure to back up '{$user_config_path}'.");
            }
            logMessage("Backup of 'config.php' realized.");
            require_once $user_config_path;
            logMessage("User Configuration.");
        } else {
            throw new Exception("User configuration file not found in '{$user_config_path}'.");
        }
        if (!isset($ABCD_path) || !isset($db_path)) {
            throw new Exception("Way Variables'\$ABCD_path' or '\$db_path' not found in config.");
        }
        $destination_paths = ['htdocs' => rtrim($ABCD_path, '/\\'), 'bases'  => rtrim($db_path, '/\\')];

        // --- 2. GITHUB FETCH, DOWNLOAD E UNZIP ---
        $release_data = getLatestReleaseInfo();
        $remote_version = $release_data['tag_name'];
        logMessage("Installing version: {$remote_version}.");
        $zip_url = $release_data['zipball_url'];
        $zip_file_path = $temp_dir . '/update.zip';
        logMessage("Downloading package...");
        $ch_dl = curl_init();
        curl_setopt($ch_dl, CURLOPT_URL, $zip_url);
        curl_setopt($ch_dl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch_dl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch_dl, CURLOPT_USERAGENT, 'ABCD-Update-Manager');
        $zip_content = curl_exec($ch_dl);
        if (curl_errno($ch_dl)) {
            throw new Exception('Erro no Download: ' . curl_error($ch_dl));
        }
        curl_close($ch_dl);
        file_put_contents($zip_file_path, $zip_content);
        logMessage('Download completed.');
        logMessage('Unzipping files...');
        $zip = new ZipArchive;
        if ($zip->open($zip_file_path) !== TRUE) {
            throw new Exception('It was not possible to open the ZIP file.');
        }
        $zip->extractTo($unzip_dir);
        $zip->close();
        $unzipped_folders = glob($unzip_dir . '/*');
        if (!isset($unzipped_folders[0])) {
            throw new Exception('No directory found in the ZIP file.');
        }
        $source_code_dir = $unzipped_folders[0];
        logMessage('Files successfully unzipped.');

        // --- 3. Update logic (partial or complete) ---
        if ($update_type === 'parcial') {
            logMessage('Starting partial update (mapped)...');
            foreach (UPDATE_MAP as $zip_source => $destination_key) {
                $source_path = $source_code_dir . '/' . $zip_source;
                if (!isset($destination_paths[$destination_key])) {
                    logMessage("Destination key '{$destination_key}' not recognized.Jumping.", 'warning');
                    continue;
                }
                $base_destination_path = $destination_paths[$destination_key];
                $target_dir_name = basename($zip_source);
                $destination_path = $base_destination_path . '/' . $target_dir_name;
                if (file_exists($source_path)) {
                    logMessage("Updating '{$destination_path}'...");
                    if (file_exists($destination_path)) recursiveDelete($destination_path);
                    recursiveCopy($source_path, $destination_path);
                } else {
                    logMessage("Origin '{$zip_source}'not found in the package.Jumping.", 'warning');
                }
            }
        } elseif ($update_type === 'completa') {
            logMessage('Starting full update ...', 'warning');
            // ATTENTION: This logic is destructive.
            // Cleans the destination directories before copying everything.
            logMessage('Cleaning destination directories (HTDOCS and Bases)...', 'warning');
            recursiveDelete($destination_paths['htdocs']);
            recursiveDelete($destination_paths['bases']);
            logMessage('Copying all files in the new version...');
            recursiveCopy($source_code_dir . '/www/htdocs', $destination_paths['htdocs']);
            recursiveCopy($source_code_dir . '/www/bases-examples_Windows', $destination_paths['bases']); // Adapt if necessary
        }

        logMessage('Updated core files.');

        // --- 4. RESTORATION ---
        logMessage('Restoring configuration file ...');
        $backup_config_file = $backup_dir . '/' . basename(USER_CONFIG_FILE);
        if (file_exists($backup_config_file)) {
            if (copy($backup_config_file, $user_config_path)) {
                logMessage("'config.php' successfully restored in '{$user_config_path}'.");
            } else {
                throw new Exception("Critical failure to restore 'config.php'.");
            }
        }

        // --- 5. LIMPEZA ---
        logMessage('Finishing and cleaning temporary files ...');
        cleanup($temp_dir);
        logMessage('Update successfully completed! New version: ' . $remote_version, 'success');
    } catch (Exception $e) {
        logMessage('Critical error: ' . $e->getMessage(), 'error');
        logMessage('The update process failed.', 'error');
        cleanup($temp_dir);
    }
}


/**
 * Function to display the information and options page.
 */
function displayUpdateInfoPage()
{
    try {
        $release_data = getLatestReleaseInfo();
        $remote_version = $release_data['tag_name'];
        $update_available = version_compare($remote_version, LOCAL_VERSION, '>');

        if (!$update_available) {
            echo '<div class="info-box success">Your version (' . LOCAL_VERSION . ') is already updated!</div>';
            return;
        }

?>
        <div class="info-box">
            <h2>New version available!</h2>
            <p>A new update is ready to be installed.</p>
            <table class="release-info">
                <tr>
                    <td>Current version:</td>
                    <td><?php echo LOCAL_VERSION; ?></td>
                </tr>
                <tr>
                    <td>New version:</td>
                    <td><strong><?php echo htmlspecialchars($release_data['name']); ?> (<?php echo $remote_version; ?>)</strong></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <strong>Version Notes:</strong>
                        <pre class="release-notes"><?php echo htmlspecialchars($release_data['body']); ?></pre>
                    </td>
                </tr>
            </table>

            <form method="POST" action="" onsubmit="return confirm('Você tem certeza que deseja iniciar a atualização?');">
                <input type="hidden" name="action" value="run_update">
                <h3>Choose the type of update:</h3>

                <div class="radio-option">
                    <label>
                        <input type="radio" name="update_type" value="parcial" checked>
                        <strong>Partial update (recommended)</strong>
                        <p>Updates only the system core files (central, assets, Opac, etc.), preserving all their databases and customizations.It is the safest option.</p>
                    </label>
                </div>

                <div class="radio-option warning">
                    <label>
                        <input type="radio" name="update_type" value="completa">
                        <strong>Complete update (destructive)</strong>
                        <p><strong>Attention:</strong> This option will completely delete the `htdocs directories and` bases` before installing the new version.Use only if your installation is corrupted.The `config.php` file will be preserved.</p>
                    </label>
                </div>

                <button type="submit" class="button-update">Start updating</button>
            </form>
        </div>
<?php

    } catch (Exception $e) {
        echo '<div class="info-box error"><strong>Error when checking updates:</strong><br>' . htmlspecialchars($e->getMessage()) . '</div>';
    }
}


// --- Main execution router ---
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>ABCD Update Manager</title>
    <style>
        div.all {
            background-color: #212529;
            color: #e9ecef;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            line-height: 1.6;
            top: 0;
        }

        .container {
            max-width: 800px;
            margin: 0px auto;
            padding: 20px;
            border: 1px solid #495057;
            border-radius: 3px;
            background-color: #343a40;
        }

        h1,
        h2,
        h3 {
            color: #ffc107;
            border-bottom: 1px solid #495057;
            padding-bottom: 10px;
        }

        .log-container {
            background-color: #212529;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
            max-height: 400px;
            overflow-y: auto;
        }

        .log-line {
            margin: 2px 10px;
            font-family: 'Courier New', Courier, monospace;
        }

        .info-box {
            background-color: #495057;
            padding: 20px;
            border-radius: 5px;
        }

        .info-box.success {
            background-color: #28a745;
            color: #fff;
        }

        .info-box.error {
            background-color: #dc3545;
            color: #fff;
        }

        .release-info {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
        }

        table.release-info td {
            padding: 10px;
            border: 1px solid #343a40;
        }

        pre.release-notes {
            white-space: pre-wrap;
            word-wrap: break-word;
            background-color: #212529;
            color: #e9ecef;
            padding: 10px;
            border-radius: 4px;
            max-height: 200px;
            overflow-y: auto;
        }

        .radio-option {
            border: 1px solid #495057;
            padding: 15px;
            margin-top: 10px;
            border-radius: 5px;
        }

        .radio-option.warning {
            border-color: #dc3545;
        }

        .radio-option p {
            margin: 5px 0 0 25px;
            font-size: 0.9em;
            color: #adb5bd;
        }

        .button-update {
            background-color: #ffc107;
            color: #212529;
            border: none;
            padding: 15px 30px;
            font-size: 1.2em;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
            width: 100%;
        }

        .button-update:hover {
            background-color: #e0a800;
        }
    </style>
</head>

<?php

session_start();
if (!isset($_SESSION["permiso"])) {
    header("Location: central/common/error_page.php");
}
if (!isset($_SESSION["lang"]))  $_SESSION["lang"] = "en";
$lang = $_SESSION["lang"];
include("central/common/get_post.php");
include("central/config.php");
include("central/common/inc_nodb_lang.php");

// ARCHIVOS DE LENGUAJE
include("central/lang/admin.php");
include("central/lang/dbadmin.php");
include("central/lang/prestamo.php");

include("central/common/header.php");
include("central/common/institutional_info.php");

?>

<div class=sectionInfo>
    <div class=breadcrumb><?php echo $msgstr["configure"] . " ABCD"; ?>
    </div>
    <div class="actions">
        <?php include "central/common/inc_back.php"; ?>
    </div>
    <div class="spacer">&#160;</div>
</div>
<div class="all">
    <div class="container">
        <h1>ABCD Update Manager</h1>

        <?php
        if (!isAdmin()) {
            echo '<div class="info-box error">Denied access: You are not allowed to run this script.</div>';
        } else {
            // Router: decides to show the info page or execute the update
            if (isset($_POST['action']) && $_POST['action'] === 'run_update') {
                echo '<h2>Log de Atualização</h2><div class="log-container">';
                $update_type = isset($_POST['update_type']) ? $_POST['update_type'] : 'parcial';
                runUpdateProcess($update_type);
                echo '</div>';
            } else {
                displayUpdateInfoPage();
            }
        }
        ?>
    </div>
</div>
<?php include("central/common/footer.php");?>

<?php ob_end_flush(); ?>