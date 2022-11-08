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
                                        <th><?php echo $msgstr["operation"]; ?></th>
                                        <th><?php echo $msgstr["publication"]; ?></th>
                                        <th><?php echo $msgstr["reserveddate"]; ?></th>
                                        <th><?php echo $msgstr["avaiblefrom"]; ?></th>
                                        <th><?php echo $msgstr["avaibleuntil"]; ?></th>
                                        <th><?php echo $msgstr["library"]; ?></th>
                                    </tr>
                                    <?php

            foreach ($dataarr["waits"] as $reserve) {
                $CN_item = $reserve["CN"];
                $DB_item= $reserve["cdb"];
            ?>
                                    <tr>
                                        <td>
                                            <p><span class="badge text-bg-primary"> <?php echo $reserve["recordId"] ?></span></p>
                                                <button type="button"  class="btn btn-danger" id="renew"
                                                OnClick="CancelReservation('<?php echo $reserve["!id"] ?>')" data-bs-toggle="modal" data-bs-target="#abcdModal"><?php echo $msgstr["cancel"]; ?></button>
                                        </td>
                                        <td>
                                            <p><?php getInfoBiblio($CN_item, $DB_item);?></p>

                                        </td>
                                        <td><?php echo fechaAsString($reserve["date"]) ?></td>
                                        <td><?php echo fechaAsString($reserve["confirmedDate"]) ?></td>
                                        <td><?php echo fechaAsString($reserve["expirationDate"]) ?></td>
                                        <td><?php echo $reserve["location"] ?></td>
                                    </tr>
           

                                    <?php
}
        ?>
                                </table>
</div>

                            <?php }?>
                            
<form name="formreservation" id="formreservation" method="POST" action="../cancelreservation.php" target="CheckOK">
  <input type="hidden" id="waitid" name="waitid"/>
  <input type="hidden" id="userid" name="userid"/>
</form>