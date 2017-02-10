2 0 mpl,if v5<>'' and a(v6) then 'YS=',v5,v2/ fi
2 0 mpl,if v5<>'' and a(v6) then 'YSN=',v5,v2,v3/ fi
4 0 mpl,if a(v6) and v5='A' then ,if ref(mfn-1,v5)='P' or ref(mfn+1,v5)='P' then 'SELECTED_A'/ fi, fi
4 0 mpl,if p(v6) and v5='P' then 'SELECTED_A'/ fi
4 0 mpl,if a(v6) and s(ref(mfn-1,v5),v5)='PP' and (ref(mfn-1,v2)<>v2 or (ref(mfn-1,v2)=v2 and ref(mfn-1,v3)<>v3  ) ) then 'SELECTED_A'/ fi
4 0 mpl,if a(v6) and v5='P' and mfn=1 then 'SELECTED_A'/ fi
4 0 mpl,if v1='LAST' then 'SELECTED_A'/ fi
5 0 mpl,if v1*0.1='R' and (ref(mfn+1,v1*0.1)='S' or ref(mfn+1,v1)='LAST') then if instr(v7,s(v4,'F'))=0 then 'YEAR_INC'v2/ fi, fi

