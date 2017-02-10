mx seq=doaj.csv gizmo=c2cp,5/12 "proc='Gsplit=5=;'" "proc='Gsplit=8=;" "proc='Gsplit=12=;'" create=doajnew now -all
mx doajnew fst=@doaj.fst fullinv/ansi=doajnew


