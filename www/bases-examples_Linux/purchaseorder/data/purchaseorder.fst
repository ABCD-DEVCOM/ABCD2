1 0 'ON_'v1
1 0  if a(v500) then 'PO_'v1 fi  /*PENDING ORDERS */
2 0 (|DA_|v2|%|/) 
5 0 "PV_"v5 /
5 4 (v5|%|/) 
5 0 (if p(v50) then 'RNBN_'v50^d,'_'v50^e/fi)   /*Número de la requisición y número de la cotización */
50 0 (|DI_|v50^a|%|/) 
50 4 (v50^a|%|/) 
50 0 (|PR_|v50^c|%|/) 
50 0 (|SN_|v50^d|%|/) 
480 0 (|DR_|v480|%|/) 

