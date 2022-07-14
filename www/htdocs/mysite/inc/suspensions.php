                        <?php if (!empty($dataarr["suspensions"])) {
                         ?> 

                            <h3 id="suspensions">
                                <?php echo $msgstr["activesuspensions"];?>
                                <span class="badge bg-warning">
                                    <?php echo count($dataarr["suspensions"]); ?>
                                </span>
                            </h3>

                            <input type="hidden" id="suspensionst" name="suspensionst" value="<?php echo count($dataarr["suspensions"]); ?>" />
        
       
                        <div class="card mb-5 table-responsive">
                            <table class="table table-striped">
                                <tr>
                                    <th><?php echo $msgstr["from"]; ?></th>
                                    <th><?php echo $msgstr["to"]; ?></th>
                                    <th><?php echo $msgstr["duration"]; ?></th>
                                    <th><?php echo $msgstr["cause"]; ?></th>
                                    <th><?php echo $msgstr["library"]; ?></th>
                                </tr>

                                <?php

                        if (count($dataarr["suspensions"]) > 0) {
                        foreach ($dataarr["suspensions"] as $suspension) {

                        ?>

                                <tr>
                                    <td><?php echo fechaAsString($suspension["startDate"], 0, 8); ?></td>
                                    <td><?php echo fechaAsString($suspension["endDate"], 0, 8); ?></td>
                                    <td><?php echo $suspension["daysSuspended"] . " " . $msgstr["days"]; ?></td>
                                    <td><?php echo $suspension["obs"]; ?></td>
                                    <td><?php echo $suspension["location"]; ?></td>
                                </tr>

                                <?php

                        }
                        }
                    

        ?>                  
                            </table>
                    </div>

                            <?php }?>
                        