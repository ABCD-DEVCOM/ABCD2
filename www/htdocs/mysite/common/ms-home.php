<?php include 'ms-header.php'; ?>
<div class="container-fluid">
  <div class="row">

    <?php include 'ms-sidebar.php';?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2"><?php echo $msgstr["userstatus"];?></h1>
      </div>
        <?php
            
  
            MenuFinalUser();
        ?>
                        <?php include '../inc/suspensions.php';?>
                 
                        <?php include '../inc/fines.php';?>
                    
                        <?php include '../inc/loans.php';?>

                        <?php include '../inc/reserve.php';?>
    </main>
     
  </div>
<?php include "ms-footer.php";?>