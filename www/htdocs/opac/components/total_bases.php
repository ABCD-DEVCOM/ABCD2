<?php
if (isset($total_base) and count($total_base)>0){
    ?>
	<div style='border:1px solid #CCCCCC; border-radius:4px; margin-top:10px ; padding: 10px'>
        <span class=tituloBase><?php echo $msgstr["total_recup"];?>: <?php echo $total_registros;?></span>
	<?php
        if (count($total_base)>1){
		foreach ($total_base as $base=>$total){
			echo "<br><a href=\"javascript:ProximaBase('$base')\">";
			echo $bd_list[$base]["titulo"]."</a>: ".$total;
		}
	}
?>    
	</div>
<?php
}