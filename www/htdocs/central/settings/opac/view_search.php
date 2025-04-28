<?php
include("conf_opac_top.php");
$wiki_help = "OPAC-ABCD DCXML";
include "../../common/inc_div-helper.php";

?>

<script>
    var idPage = "db_configuration";
</script>

<?php
$arquivo = $db_path . "/opac_conf/logs/log_opac.txt";
$linhas = file_exists($arquivo) ? file($arquivo) : [];
?>

<div class="middle form row m-0">
    <div class="formContent col-2 m-2">
        <?php include("conf_opac_menu.php"); ?>
    </div>
    <div class="formContent col-9 m-2">


        <div class="container">
            <h3>Log de Pesquisas</h3>
            <table class="table striped ">
                <thead>
                    <tr>
                        <th width="200">Data/Hora</th>
                        <th width="200">IP</th>
                            <th>Termo Pesquisado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($linhas as $linha):
                        $dados = explode("\t", trim($linha));
                    ?>
                        <tr>
                            <td><?= $dados[0] ?? '' ?></td>
                            <td><?= $dados[1] ?? '' ?></td>
                            <td><?= htmlspecialchars($dados[2] ?? '') ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include("../../common/footer.php"); ?>