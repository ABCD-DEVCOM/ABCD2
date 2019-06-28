	<!-- BEGIN HEADER -->
    <div class="header">
      <div class="container">
<!--        <a class="site-logo" href="/site/"><img src="/site/php/assets/logo/logo_mweka.png" alt="CAWM"></a> -->
        <a class="site-logo" href="/site/"><img src="/site/php/assets/logo/logoabcd.png" alt="CAWM"></a>

        <a href="javascript:void(0);" class="mobi-toggler"><i class="fa fa-bars"></i></a>

<!--link rel="shortcut icon" href="favicon.ico"-->
<!--script type="text/javascript">var lang = '<?php echo $checked['lang'];?>';</script>
<script type="text/javascript" src="<?php echo $def['DIRECTORY'];?>js/functions.js"></script>
<script type="text/javascript" src="<?php echo $def['DIRECTORY'];?>js/showHide.js"></script>
<script type="text/javascript" src="<?php echo $def['DIRECTORY'];?>js/metasearch.js"></script>
<script type="text/javascript" src="<?php echo $def['DIRECTORY'];?>js/jquery-1.3.1.min.js"></script-->
<!--link rel="shortcut icon" href="<?php echo $def['DIRECTORY'];?>favicon.ico"/-->
<!--link rel="stylesheet" href="<?php echo $def['DIRECTORY'];?>css/public/print.css" type="text/css" media="print"/-->
<!--link rel="stylesheet" href="<?php echo $def['DIRECTORY'];?>css/public/skins/<?php echo SKIN_NAME;?>/style-<?php echo $checked['lang'];?>.css" type="text/css" media="screen"/-->


        <!-- BEGIN NAVIGATION -->
        <div class="header-navigation" style="width:80%">
          <ul>
		  <?php



			include("../../central/config.php");
			//Read the list of sources/databases
            $fp = file($db_path."site/html/en/34.html");
            $string = utf8_encode(substr($fp[0],strpos($fp[0],'<li>'),-11));                                          
            $string = substr($string,strpos($string,'<span>'),-5);
            $links = $string;
			$links = explode(',',$links);
			
			//Networks Links
			$fp = file($db_path."site/html/en/33.html");
            $string = utf8_encode(substr($fp[0],strpos($fp[0],'<li>'),-11));                                          
            $string = substr($string,strpos($string,'<span>'),-5);
            $networks = $string;
			$networks = explode(',',$networks);
		  ?>
            <li><a href="/site/">Library</a></li>
			<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" data-target="#" href="#">Local Databases</a>
				<ul class="dropdown-menu">
					<?php
					foreach($links as $link){
						$link = str_ireplace('<span>','',$link);
						$link = str_ireplace('</span>','',$link);
						echo '<li class="local_db">'.$link.'</li>';
					}
					?>
				</ul>
			</li>
			<?php
			/*
			<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" data-target="#" href="#">Networks</a>
				<ul class="dropdown-menu">
					<?php
					foreach($networks as $link){
						$link = str_ireplace('<span>','',$link);
						$link = str_ireplace('</span>','',$link);
						echo '<li class="">'.$link.'</li>';
					}
					?>
				</ul>
			</li>
			*/
			?>
			<li class="pull-right"><a href="/indexmysite.php">Log In</a></li>
            <!-- BEGIN TOP SEARCH -->
            <!--li class="menu-search pull-right">
              <span class="sep"></span>
              <i class="fa fa-search search-btn"></i>
              <div class="search-box">
                <form method="POST" action="/site/metaiah/search.php">
                  <div class="input-group">
                    <input type="text" placeholder="Search" name="expression" class="form-control">
                    <span class="input-group-btn">
                      <button class="btn btn-primary" type="submit">Search</button>
                    </span>
                  </div>
                </form>
              </div> 
            </li-->
            <!-- END TOP SEARCH -->
          </ul>
        </div>
        <!-- END NAVIGATION -->
      </div>
    </div>
    <!-- Header END -->