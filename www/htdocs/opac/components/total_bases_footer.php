<?php
if (isset($total_base) and count($total_base)>1 and isset($multiplesBases) and $multiplesBases=="Y") {
    ?>

<div class="card  text-bg-light">
  <div class="card-body">
    <?php
	$ix=-1;
	$total_general=0;
	foreach ($total_base as $base=>$total){
		$ix=$ix+1;
		$total_general=(int)$total_general+(int)$total;
    ?>

    <p>
        <a href="javascript:ProximaBase('<?php echo $base;?>')">
            <?php echo $bd_list[$base]["titulo"];?> : <?php echo $total;?>
        </a>
    </p>
    <?php         
	}
    ?>
    <p>
        <strong>
            <?php echo $msgstr["front_total_registros"];?> : <?php echo $total_general;?>
        </strong>
    </p>
  </div>
</div>
<?php
}