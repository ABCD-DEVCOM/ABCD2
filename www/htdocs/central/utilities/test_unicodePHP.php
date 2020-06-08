<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
  </head>
  <body>
    <h1>Check Unicode on a web server with php</h1>

    <p>If your filenames requires characters with diacritics or any Unicode characters and not only the strict latin characters (26 letters + 10 numbers + some symbols and punctuation marks), the web server should be checked and fixed.</p>

    <h2>Checks</h2>

    <h3>First character check.</h3>
    <pre class="prettyprint">
    $filename = 'éfilé.jpg';
    if (basename($filename) != $filename) {
        echo sprintf('An error occurs when testing function "basename(\'%s\') : %s".', $filename, basename($filename));
    } else {
        echo 'Success!';
    }
    </pre>
    <?php
        $success = 0;
        $filename = 'éfilé.jpg';
        if (basename($filename) != $filename) {
            echo sprintf('An error occurs when testing function "basename(\'%s\') : %s".', $filename, basename($filename));
        } else {
            echo 'Success!';
            ++$success;
        }
    ?>

    <h3>Command line via web check (comparaison with a trivial function).</h3>
    <pre class="prettyprint">
    // @see http://www.php.net/manual/function.escapeshellarg.php#111919
    function escapeshellarg_unicode($string)
    {
        return "'" . str_replace("'", "'\\''", $string) . "'";
    }
    $filename = "File~1 -À-é-ï-ô-ů-ȳ-Ø-ß-ñ-Ч-Ł-'.Test.png";
    if (escapeshellarg($filename) != escapeshellarg_unicode($filename)) {
        echo sprintf('An error occurs when testing function "escapeshellarg(\'%s\')": %s', $filename, escapeshellarg_unicode($filename));
    } else {
        echo 'Success!';
    }
    </pre>
    <?php
        // @see http://www.php.net/manual/function.escapeshellarg.php#111919
        function escapeshellarg_unicode($string)
        {
            return "'" . str_replace("'", "'\\''", $string) . "'";
        }
        $filename = "File~1 -À-é-ï-ô-ů-ȳ-Ø-ß-ñ-Ч-Ł-'.Test.png";
        if (escapeshellarg($filename) != escapeshellarg_unicode($filename)) {
            echo sprintf('An error occurs when testing function "escapeshellarg(\'%s\')": %s', $filename, escapeshellarg_unicode($filename));
        } else {
            echo 'Success!';
            ++$success;
        }
    ?>

    <h2>Fix for Apache (here for Debian and derivative distribution)</h2>
    <?php if ($success !== 2): ?>
    <p>Your server is not fully compatible with Unicode. The following fix (or another one) is required.</p>
    <?php else: ?>
    <p>Your server is fully compatible with Unicode. The following fix is not required.</p>
    <?php endif; ?>
    <br />
    <p>Two solutions are possible, and they require to config the file /etc/apache2/envvars, where it is indicated:</p>
    <pre class="prettyprint">
        ## The locale used by some modules like mod_dav
        export LANG=C
        ## Uncomment the following line to use the system default locale instead:
        #. /etc/default/locale
    </pre>
    <ul>
    <li>First solution is to uncomment the line as specified and to add a generic value for numbers to avoid other issues:</li>
    <pre class="prettyprint">
    . /etc/default/locale
    export LC_NUMERIC=C
    </pre>
    <li>The second solution is more generic: don‘t uncomment the line, but replace "export LANG=C" by "C.UTF-8":</li>
    <pre class="prettyprint">
    #export LANG=C
    export LANG="C.UTF-8"
    </pre>
    </ul>
    <p>Don‘t forget to relaunch the server between two tests.</p>
    <pre class="prettyprint">
        sudo systemctl restart apache2
    </pre>
    <p>In fact, the default locale of Apache is "C" for historic and geographic reasons (USA based), so it should be changed to any UTF-8 compliant locale, for example the default locale of Debian, "en_US.UTF-8". Apache does not apply it by default, so it should be fixed.</p>
    <p>Ideally, the default locale of Apache should be the generic "C.UTF-8", but it is not possible, because American people wouldn't understand why they would lose their "en_US.UTF-8".</p>
    <br />
    <script src="https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js"></script>
  </body>
</html>
