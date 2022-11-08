800 0 mpu,if v1:'P' then (if p(v800^n) then 'NI=',v800^n /fi) fi
800 0 mpu,if v1:'P' then (v800^c,| V|v800^v,| E|v800^l/) fi
20 0 mpu,if p(v1)  then if p(v20) then v20 else v35 fi,c20,v1 fi
10 0 mpu,if a(v1) then "!A"v10/v10/ fi
20 0 mpu,if a(v1) then if p(v20) then "!C"v20/v20 else "!C"v35/v35 fi fi
30 0 mpu,"!B"v30/v30/"!B"v60/v60
30 8 '|~B|',mpu,(v30|%|/)
35 0 mpu,"!D"v35/v35
40 0 mpu,"!T"v40/v40
45 0 mpu,if a(v1) then (|!K|v45/)/(v45/) fi
47 0 mpu,if a(v1) then (|!E|v47/)/(v47/) fi
49 0 mpu,if a(v1) then (|!F|v49/)/(v49/) fi
90 0 mpu,if p(v90) then '!LSUSPENDIDO'/'SUSPENDIDO' FI
120 0 mpu,(|!G|v120/)/(v120/)
130 0 mpu,(|!Q|v130/)/(v130/)
210 0 mpu,(|!I|v210/)/(v210/)
300 0 mpu,(|!Z|v300|%|/)/(v300/)
801 0 mpu,if v1:'P' then (|!H|v800^*,|, |v800^b/)(v800^*,|, |v800^b/) fi
802 4 mpu,if v1:'P' then (v800^t/) fi
803 0 mpu,if v1:'P' then (|!J|v800^c/),(v800^c/) fi
800 0 ("FP="v800^p.4/"FP="v800^p.6/"FP="v800^p/)
860 0 (|FP=|v860.4/,|FP=|v860.6/,|FP=|v860/)
805 0 mpu,if v1:'P' then "FV="v800^h.4/"FV="v800^h.6/"FV="v800^h/ fi
870 0 mpu,if v1:'X' then if a(v870) then "FD="v800^h.4/"FD="v800^h.6/"FD="v800^h/ else "FD="v870.4/"FD="v870.6/"FD="v870/ fi fi
