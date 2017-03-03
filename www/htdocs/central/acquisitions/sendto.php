<?php
if (isset($index)){?>
<strong><?php echo $msgstr["sendto"]?>:&nbsp; &nbsp;
		<a href='javascript:SendTo("D")'><?php echo $msgstr["doc"]?></a> &nbsp; | &nbsp;
		<a href='javascript:SendTo("W")'><?php echo $msgstr["xls"]?></a></strong> &nbsp;  &nbsp;  &nbsp;

<script>

function SendTo(SendTo){
	index="<?php echo $index?>"
	tit="<?php echo $tit?>"
	Expresion="<?php echo $Expresion?>"	base="<?php echo $arrHttp["base"]?>"
	sort="<?php echo $arrHttp["sort"]?>"
	msgwin=window.open("sendto_ex.php?base="+base+"&sort="+sort+"&Opcion="+SendTo+"&index="+index+"&tit="+tit+"&Expresion="+Expresion,"sendto")
	msgwin.focus()}
</script>
<?}?>

