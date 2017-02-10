4 0 mpl,if v5='A' then ,if ref(mfn-1,v5)='P' or ref(mfn+1,v5)='P' then 'BREAK'/ fi, fi, /* ausencia antes ou depois de presenca */
4 0 mpl,if v5='P' and mfn=1 then 'BREAK'/ fi, , /* mfn=1 e presente */
4 0 mpl,if mfn>1 then if s(ref(mfn-1,v5),v5)='PP' and (ref(mfn-1,v2)<>v2 or (ref(mfn-1,v2)=v2 and ref(mfn-1,v6)<>v6  ) ) then 'BREAK'/ fi, fi, /* mudanca de ano */
4 0 mpl,if v1='LAST' then 'BREAK'/ fi, /* ultimo registro e presente */
5 0 mpl,if ref(mfn+1,v1)='LAST' then 'INCOMPLETO_'v2/ fi,
1 0 mpl,if v5='A' or p(v6) then |INCOMPLETO_|v2/ fi
1 0 mpl,if v5='A' or p(v6) then |VOL_INCOMPLETO_|v2,v3/ fi
5 0 mpl,if ref(mfn+1,v1)='LAST' then 'VOL_INCOMPLETO_'v2,v3/ fi,
5 0 mpl,if ref(mfn+1,v1)='LAST' then 'LAST_VOL_'v2,v3/ fi,
4 0 mpl,if mfn>1 then if s(ref(mfn-1,v5),v5)='PP' and (ref(mfn-1,v2)<>v2 or (ref(mfn-1,v2)=v2 and ref(mfn-1,v3)<>v3  ) ) then 'VOL_BREAK'/ fi, fi, /* mudanca de ano */
