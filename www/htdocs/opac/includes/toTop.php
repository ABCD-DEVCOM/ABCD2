<?php

function toTop() {
?>

<script>
	jQuery(function(){
		jQuery(document).on( 'scroll', function(){
			if (jQuery(window).scrollTop() > 100) {
				jQuery('.smoothscroll-top').addClass('show');
			} else {
				jQuery('.smoothscroll-top').removeClass('show');
			}
		});
		jQuery('.smoothscroll-top').on('click', scrollToTop);
	});

	function scrollToTop() {
		verticalOffset = typeof(verticalOffset) != 'undefined' ? verticalOffset : 0;
		element = jQuery('body');
		offset = element.offset();
		offsetTop = offset.top;
		jQuery('html, body').animate({scrollTop: offsetTop}, 600, 'linear').animate({scrollTop:25},200).animate({scrollTop:0},150) .animate({scrollTop:0},50);
	}
</script>

	<div class="smoothscroll-top show">
		<span class="scroll-top-inner">
			<i class="fas fa-chevron-up"></i>
		</span>
	</div>


<?php
}