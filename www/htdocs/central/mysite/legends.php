<?php

    // Esto va a tomar keys de msgs de clases de empweb que son resueltos en GUI
    // y no hay como tomar ese legend desde aquí porque simplemente no llega
    // asi es que pasan a msgs y se analiza que llega, y se devuelve en el idioma apropiado
    // las reglas de Groovy en cambio que mandan un msg(idioma,str) no son procesadas por acá



    //Primero obtengo el vector de idioma apropiado


    if (((strpos($resultbuff,"net.kalio.empweb.engine.rules.HasFineOrSuspension_max_reservations_when_suspended_limit_reached",0)>0)||
        (strpos($resultbuff,"net.kalio.empweb.engine.rules.HasFineOrSuspension_max_loans_when_suspended_limit_reached",0)>0))
        && strlen($legend)==0)
    {
        utf8_decode($legend=$msgstr["user_suspended"]);

    }


    if ((strpos($resultbuff,"net.kalio.empweb.engine.rules.HasFineOrSuspension_max_reservations_when_fined_limit_reached",0)>0)
        && strlen($legend)==0)
    {
        utf8_decode($legend=$msgstr["user_fined"]);

    }



    if (strpos($resultbuff,"net.kalio.empweb.engine.rules.GetUser_user_registration_expired",0)>0 && strlen($legend)==0)
    {
        //No llega un mensaje típico, sino que patina medio silently para el cliente

        utf8_decode($legend=$msgstr["user_expired"]);

    }

?>
