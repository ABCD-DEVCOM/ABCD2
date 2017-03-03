<?php
session_start();

$termId = $_POST['term'];
$qualifierList = implode(",",$_POST['ql']);

$sessionTerm = split("\|\|\|",$_SESSION["terms"][$termId]);

/* partes do termo armazenados na sessao */
$id = $sessionTerm[0];
$name = trim($sessionTerm[1]);
$options = $sessionTerm[2];
$explode = $sessionTerm[4];

$_SESSION["terms"][$termId] = $id . "|||" . $name . "|||" . $options . "|||" . $qualifierList . "|||" . $explode;

?>

<html>
    <head>
        <script type="text/javascript">
            window.close();
        </script>
    </head>
</html>