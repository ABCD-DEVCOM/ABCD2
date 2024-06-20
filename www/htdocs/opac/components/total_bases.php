<?php
if (isset($total_base) and count($total_base)>0){
    ?>
	<div class="card text-bg-light my-2 custom-searchbox">
	<div class="card-body">
		<div class="row justify-content-around">
			<div class="col-auto align-self-start">
				<h6 class="text-dark"><?php echo $msgstr["front_total_recup"];?>: <?php echo $total_registros;?></h6>
			</div>
			<div class="col-auto">
			<?php
				if (count($total_base)>1){
				foreach ($total_base as $base=>$total){
				?>
					<h6 class="text-dark"><a href="javascript:ProximaBase('<?php echo $base; ?>')"><?php echo $bd_list[$base]["titulo"];?></a> <span class="badge bg-secondary"><?php echo $total;?></span></h6>
				<?php
				}
			}
		?>  </div>
			<div class="col-auto align-self-end">
				<a class="btn btn-primary"  data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
					<?php echo $msgstr["front_facetas"] ?>
				</a>
			</div>
		</div>
	</div>
	</div>
<?php }

