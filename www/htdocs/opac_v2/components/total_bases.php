<div class="py-3">
<?php
if (isset($total_base) and count($total_base)>0){
    ?>

    <h5><?php echo $msgstr["total_recup"];?>: <?php echo $total_registros;?></h5>
	<?php
        if (count($total_base)>1){
		foreach ($total_base as $base=>$total){
			echo '<h6><a class="btn btn-light" href="javascript:ProximaBase(\''.$base.'\')">';
			echo $bd_list[$base]["titulo"].' <span class="badge text-bg-primary">'.$total.'</span></a></h6>';
		}
	}
}
?>
</div>