1 0 if v1='P' or v1='X' then "TR_"v1,"_"v10/ fi   /*Libros prestados o devueltos por número de inventario */ 
2 0 if v1='P' or v1='X' then "TRU_"v1,"_"v20/ fi   /*Libros prestados o devueltos por usuario */ 
90 0 if v1='P' or v1='X' then "TC_"v1,"_"v90/ fi   /*Libros prestados o devueltos por No. de clasificación */ 
90 0 if v1='P' or v1='X' then "ON_"v1,"_"v95/ fi   /*Libros prestados o devueltos por No. del objeto */ 
10 0 "NI="v10/v10 
20 0 "CU_"v20/v20 
30 0 "DA_"v30.4/"DA_"v30.6/"DA_"v30 
1 0 "TM_"V1 
