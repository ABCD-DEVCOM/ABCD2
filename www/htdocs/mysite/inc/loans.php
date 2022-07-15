                            <?php if (!empty($dataarr["loans"])) { ?>
                            <h3 id="loans">
                                <?php echo $msgstr["actualloans"]; ?>
                                <span class="badge bg-primary">
                                    <?php echo count($dataarr["loans"]); ?>
                                </span>
                            </h3>

                 
                            <div class="card mb-5 table-responsive">
                                <table class="table table-striped">
                                    <tr>
                                        <th><?php echo $msgstr["inventory"]; ?>
                                            <input type="hidden" id="cantrenewalst" name="cantrenewalst"
                                                value="<?php if (isset($dataarr["cantrenewals"]))echo $dataarr["cantrenewals"]; ?>" />
                                        </th>
                                        <th><?php echo $msgstr["from"]; ?></th>
                                        <th><?php echo $msgstr["to"]; ?></th>
                                        <th><?php echo $msgstr["publication"]; ?></th>
                                        <th><?php echo $msgstr["library"]; ?></th>
                                        <th><?php echo $msgstr["operation"]; ?></th>
                                    </tr>
                                    <?php
                                    foreach ($dataarr["loans"] as $loan) {
                                                ?>
                                                                        <tr>
                                                                            <td>
                                                                            <p><span class="badge text-bg-primary"> <?php echo $loan["copyId"]; ?></td></span></p>
                                                                            <input type="hidden" id="loanidh<?php echo $loan["copyId"]; ?>"
                                                                                    name="loanidh<?php echo $loan["copyId"]; ?>"
                                                                                    value="<?php echo $loan["recordId"]; ?>" /></td>
                                                                            <td><?php if (substr($loan["startDate"], -1) == ' ') {
                                                    echo fechaAsString(substr($loan["startDate"], 0, -1));
                                                } else {
                                                    echo fechaAsString($loan["startDate"]);
                                                }
                                                ?></td>
                                                    <td><?php if (substr($loan["endDate"], -1) == ' ') {
                                                    echo fechaAsString(substr($loan["endDate"], 0, -1));
                                                } else {
                                                    echo fechaAsString($loan["endDate"]);
                                                }
?>
                                            <input type="hidden" id="endatet<?php echo $loan["copyId"]; ?>"
                                                name="endatet<?php echo $loan["copyId"]; ?>"
                                                value="<?php echo $loan["endDate"]; ?>" />
                                        </td>
                                        <td>
                                            <p><?php echo $loan["titleobj"]; ?></p>
                                            <a
                                                href="javascript: ajaxPublication('<?php echo "loan-" . $loan["recordId"]; ?>','<?php echo $loan["recordId"]; ?>','*');"><?php echo $loan["recordId"] . " / " . $loan["profile"]["objectCategory"]; ?>
                                            </a>
                                            <input type="hidden" id="copytypeh<?php echo $loan["copyId"]; ?>"
                                                name="copytypeh<?php echo $loan["copyId"]; ?>"
                                                value="<?php echo $loan["profile"]["objectCategory"]; ?>" />
                                        </td>
                                        <td>
                                            <?php echo $loan["location"] ?>
                                        </td>
                                        <td>
                                            <button type="button"  class="btn btn-primary" id="renew"
                                                OnClick="javascript:LoanRenovation('<?php echo $loan["copyId"] ?>','<?php echo $loan["location"] ?>')" data-bs-toggle="modal" data-bs-target="#abcdModal"><?php echo $msgstr["makerenewal"]; ?></button>
                                        </td>
                                    </tr>
                                        <?php
}
        ?>
                                </table>
                            </div>

                            <?php

    }

    ?>

                <form name="formrenovation" id="formrenovation" method="POST" action="../loanrenovation.php" target="CheckOK">
                    <input type="hidden" id="copyId" name="copyId"/>
                    <input type="hidden" id="userId" name="userId"/>
                    <input type="hidden" id="db" name="db"/>
                    <input type="hidden" id="library" name="library"/>
					<input type="hidden" id="usertype" name="usertype"/>
					<input type="hidden" id="copytype" name="copytype"/>
					<input type="hidden" id="loanid" name="loanid"/>
					<input type="hidden" id="cantrenewals" name="cantrenewals"/>
					<input type="hidden" id="suspensions" name="suspensions"/>
					<input type="hidden" id="fines" name="fines"/>
					<input type="hidden" id="endatev" name="endatev"/>
                </form>
