                         <?php if (!empty($dataarr["waits"])) { ?>
                         <h3 id="reserve">
                                <?php echo $msgstr["actualreserves"]; ?>
                                <span class="badge bg-primary">
                                    <?php echo count($dataarr["waits"]); ?>
                                </span>
                            </h3>
    
                            <div class="card mb-5 table-responsive">
                                <table class="table table-striped table-responsive">
                                    <tr>
                                        <th>#</th>
                                        <th><?php echo $msgstr["publication"]; ?></th>
                                        <th><?php echo $msgstr["reserveddate"]; ?></th>
                                        <th><?php echo $msgstr["avaiblefrom"]; ?></th>
                                        <th><?php echo $msgstr["avaibleuntil"]; ?></th>
                                        <th><?php echo $msgstr["library"]; ?></th>
                                        <th><?php echo $msgstr["operation"]; ?></th>
                                    </tr>
                                    <?php

            foreach ($dataarr["waits"] as $reserve) {
                $CN_item = $reserve["CN"];
                $DB_item= $reserve["cdb"];
            ?>
                                    <tr>
                                        <td>
                                            <p><span class="badge text-bg-primary"> <?php echo $reserve["recordId"] ?></td></span></p>
                                        </td>
                                        <td><p><?php getInfoBiblio($CN_item, $DB_item);?></p></td>
                                        <td><?php echo fechaAsString($reserve["date"]) ?></td>
                                        <td><?php echo fechaAsString($reserve["confirmedDate"]) ?></td>
                                        <td><?php echo fechaAsString($reserve["expirationDate"]) ?></td>
                                        <td><?php echo $reserve["location"] ?></td>
                                        <td>
                                            <input class="btn btn-danger" type="button" value="<?php echo $msgstr["cancel"]; ?>"
                                                OnClick="javascript:CancelReservation('<?php echo $reserve["!id"] ?>')" />
                                        </td>
                                    </tr>
           

                                    <?php
}
        ?>
                                </table>
</div>

                            <?php }?>