<div class="row">
    <div class="col-md-6 offset-md-3">
        <input type="hidden" name="desde" id="desde" value="<?php echo $desde; ?>">
        <input type="hidden" name="pagina" value="<?php echo $prox_p; ?>">
        <?php echo $paramsHidden; ?>

        <nav aria-label="Page navigation">
            <ul class="pagination">
                <!-- First -->
                <li class="page-item">
                    <a class="page-link" href="javascript:ProximaPagina(1,1)">
                        <i class="fas fa-angle-double-left" title="<?php echo $msgstr['front_primera_pag']; ?>"></i>
                    </a>
                </li>

                <!-- Prev -->
                <li class="page-item">
                    <a class="page-link" href="javascript:ProximaPagina(<?php echo $paginaAnterior; ?>,<?php echo $pgAnterior; ?>)">
                        <i class="fas fa-chevron-left" title="<?php echo $msgstr['front_anterior']; ?>"></i>
                    </a>
                </li>

                <!-- Pages -->
                <?php foreach ($listaPaginas as $item): ?>
                    <li class="page-item<?php echo $item['active'] ? ' active' : ''; ?>">
                        <a class="page-link" href="javascript:ProximaPagina(<?php echo $item['pagina']; ?>,<?php echo $item['pg']; ?>)">
                            <?php echo $item['pagina']; ?>
                        </a>
                    </li>
                <?php endforeach; ?>

                <!-- Next -->
                <li class="page-item">
                    <a class="page-link" href="javascript:ProximaPagina(<?php echo $paginaPosterior; ?>,<?php echo $pgPosterior; ?>)">
                        <i class="fas fa-chevron-right" title="<?php echo $msgstr['front_proximo']; ?>"></i>
                    </a>
                </li>

                <!-- Last -->
                <li class="page-item">
                    <a class="page-link" href="javascript:ProximaPagina(<?php echo $paginas; ?>,<?php echo $pgUltima; ?>)">
                        <i class="fas fa-angle-double-right" title="<?php echo $msgstr['front_ultima_pag']; ?>"></i>
                    </a>
                </li>
            </ul>
        </nav>

        <input type="hidden" name="count" value="<?php echo $_REQUEST['count'] ?? ''; ?>">
    </div>
</div>

<div class="row justify-content-around mb-3 custom-searchbox">
    <div class="col-3">
        <h6 class="text-dark"><?php echo $bd_list[$base]['descripcion']; ?></h6>
    </div>
    <div class="col-3">
        <p><?php echo $msgstr['front_pagina'] . ' ' . $paginaAtual . ' ' . $msgstr['front_de'] . ' ' . $paginas; ?></p>
    </div>
    <div class="col-3">
        <?php echo $select_formato; ?>
    </div>
</div>

<?php if (isset($_REQUEST["prefijoindice"])): ?>
    <input class="btn btn-secondary" type="button" id="search-submit" value="<?php echo $msgstr['front_index_back']; ?>" onclick="javascript:document.indice.submit()">
<?php endif; ?>
