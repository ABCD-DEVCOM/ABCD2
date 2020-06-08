<?php
session_start();

$termId = $_POST['term'];
$explode = $_POST['explode'];

$sessionTerm = explode("\",$_SESSION["terms"][$termId]);

/* partes do termo armazenados na sessao */
$id = $sessionTerm[0];
$name = trim($sessionTerm[1]);
$options = $sessionTerm[2];
$qualifier = $sessionTerm[3];

$_SESSION["terms"][$termId] = $id . "|||" . $name . "|||" . $options . "|||" . $qualifier . "|||" . $explode;


?>

<html>
    <head>
        <script type="text/javascript">
            window.close();
        </script>
    </head>
</html>