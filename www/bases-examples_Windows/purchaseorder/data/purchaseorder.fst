1 0 'ON_'v1
1 0  if a(v500) then 'PO_'v1 fi  /*PENDING ORDERS */
50 0 (|SN_|V50^d|%|/) 
5 0 "PV_"v5 /
5 0 (if p(v50) then 'RNBN_'v50^d,'_'v50^e/fi)   /*Número de la requisición y número de la cotización */
