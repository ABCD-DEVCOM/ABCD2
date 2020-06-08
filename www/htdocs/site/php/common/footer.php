	<!-- BEGIN BRANDS -->
      <div class="brands">
      <div class="container">
            <div class="owl-carousel owl-carousel6-brands">
              <!--a href="/site/"><img src="/site/php/assets/frontend/pages/img/brands/canon.jpg" alt="canon" title="canon"></a>
              <a href="/site/"><img src="/site/php/assets/frontend/pages/img/brands/esprit.jpg" alt="esprit" title="esprit"></a>
              <a href="/site/"><img src="/site/php/assets/frontend/pages/img/brands/gap.jpg" alt="gap" title="gap"></a>
              <a href="/site/"><img src="/site/php/assets/frontend/pages/img/brands/next.jpg" alt="next" title="next"></a>
              <a href="/site/"><img src="/site/php/assets/frontend/pages/img/brands/puma.jpg" alt="puma" title="puma"></a>
              <a href="/site/"><img src="/site/php/assets/frontend/pages/img/brands/zara.jpg" alt="zara" title="zara"></a>
              <a href="/site/"><img src="/site/php/assets/frontend/pages/img/brands/canon.jpg" alt="canon" title="canon"></a>
              <a href="/site/"><img src="/site/php/assets/frontend/pages/img/brands/esprit.jpg" alt="esprit" title="esprit"></a>
              <a href="/site/"><img src="/site/php/assets/frontend/pages/img/brands/gap.jpg" alt="gap" title="gap"></a>
              <a href="/site/"><img src="/site/php/assets/frontend/pages/img/brands/next.jpg" alt="next" title="next"></a>
              <a href="/site/"><img src="/site/php/assets/frontend/pages/img/brands/puma.jpg" alt="puma" title="puma"></a>
              <a href="/site/"><img src="/site/php/assets/frontend/pages/img/brands/zara.jpg" alt="zara" title="zara"></a-->
				<?php
					foreach($networks as $link){
						$link = str_ireplace('<span>','',$link);
						$link = str_ireplace('</span>','',$link);
						$link = str_ireplace('<li>','',$link);
						$link = str_ireplace('</li>','',$link);
						echo $link;
					}
				?>
            </div>
        </div>
    </div>
    <!-- END BRANDS -->
	
	<!-- BEGIN FOOTER -->
    <div class="footer bg-color-cawm">
      <div class="container">
        <div class="row">
          <!-- BEGIN COPYRIGHT -->
          <div class="col-md-6 col-sm-6 padding-top-10">
            <?php echo date('Y'); ?> &copy; Mwaipopo, Nsajigwa A &amp; Bavo Tengio &amp; Egbert de Smet
          </div>
          <!-- END COPYRIGHT -->
          <!-- BEGIN PAYMENTS -->
          <div class="col-md-6 col-sm-6">
            <ul class="list-unstyled list-inline pull-right">
              <li><i class="fa fa-phone"></i> +255 755 064 000</li>
			  <li><i class="fa fa-envelope"></i> P O Box 3031, Moshi</li>
              <li><i class="fa fa-envelope"></i> library@mwekawildlife.org</li>
              <li><i class="fa fa-clock"></i> Opening Hours: Mon - Fri 09:00 - 22:00 | Sat-Sun 19:00 - 22:00</li>
              <li></li>
            </ul>
          </div>
          <!-- END PAYMENTS -->
        </div>
      </div>
    </div>
    <!-- END FOOTER -->
    <!-- Load javascripts at bottom, this will reduce page load time -->
    <!-- BEGIN CORE PLUGINS (REQUIRED FOR ALL PAGES) -->
    <!--[if lt IE 9]>
    <script src="/site/php/assets/global/plugins/respond.min.js"></script>  
    <![endif]-->
    <script src="/site/php/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
    <script src="/site/php/assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
    <script src="/site/php/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>      
    <script src="/site/php/assets/frontend/layout/scripts/back-to-top.js" type="text/javascript"></script>
    <script src="/site/php/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <!-- END CORE PLUGINS -->

    <!-- BEGIN PAGE LEVEL JAVASCRIPTS (REQUIRED ONLY FOR CURRENT PAGE) -->
    <script src="/site/php/assets/global/plugins/fancybox/source/jquery.fancybox.pack.js" type="text/javascript"></script><!-- pop up -->
    <script src="/site/php/assets/global/plugins/carousel-owl-carousel/owl-carousel/owl.carousel.min.js" type="text/javascript"></script><!-- slider for products -->
    <script src='/site/php/assets/global/plugins/zoom/jquery.zoom.min.js' type="text/javascript"></script><!-- product zoom -->
    <script src="/site/php/assets/global/plugins/bootstrap-touchspin/bootstrap.touchspin.js" type="text/javascript"></script><!-- Quantity -->

    <!-- BEGIN LayerSlider -->
    <script src="/site/php/assets/global/plugins/slider-layer-slider/js/greensock.js" type="text/javascript"></script><!-- External libraries: GreenSock -->
    <script src="/site/php/assets/global/plugins/slider-layer-slider/js/layerslider.transitions.js" type="text/javascript"></script><!-- LayerSlider script files -->
    <script src="/site/php/assets/global/plugins/slider-layer-slider/js/layerslider.kreaturamedia.jquery.js" type="text/javascript"></script><!-- LayerSlider script files -->
    <script src="/site/php/assets/frontend/pages/scripts/layerslider-init.js?v3" type="text/javascript"></script>
    <!-- END LayerSlider -->

    <script src="/site/php/assets/frontend/layout/scripts/layout.js" type="text/javascript"></script>