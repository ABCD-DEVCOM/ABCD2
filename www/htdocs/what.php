<?php



        if ($_REQUEST["action"]=="getall")
        {
            include ("central/common/footer.php");

        }

       else
       {
        require_once ("central/config.php");
        $def = parse_ini_file($db_path."abcd.def");


         foreach ($def as $key=>$value)
          {
            echo $key."=".$value."<br>";
          }
       }
?>
