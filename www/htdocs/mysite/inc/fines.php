                            <?php if (!empty($dataarr["fines"])) {  ?>
                            <h3 id="fines">
                                <?php echo $msgstr["fines"];?> 
                                <span class="badge bg-warning">
                                    <?php echo count($dataarr["fines"]); ?>
                                </span>
                            </h3>
                        

                                <input type="hidden" id="finest" name="finest" value="<?php echo count($dataarr["fines"]); ?>" />
                                
                                <?php
                                }
                                if (!empty($dataarr["fines"])) {

                                ?>
                            <div class="card mb-5 table-responsive">
                                <table class="table table-striped ">
                                    <tr>
                                        <th><?php echo $msgstr["from"]; ?></th>
                                        <th><?php echo $msgstr["amount"]; ?></th>
                                        <th><?php echo $msgstr["type"]; ?></th>
                                        <th><?php echo $msgstr["observations"]; ?></th>

                                    </tr>
                                    <?php
                                        foreach ($dataarr["fines"] as $fine) {
                                          //print_r($reserve);
                                    ?>
                                    <tr>
                                        <td><?php echo fechaAsString($fine["date"]) ?></td>
                                        <td><?php echo $fine["amount"] ?></td>
                                        <td><?php echo $fine["type"] ?></td>
                                        <td><?php echo $fine["obs"] ?></td>

                                    </tr>
                                    <?php
}
        ?>
                                </table>
                            </div>

                            <?php }
                            ?>