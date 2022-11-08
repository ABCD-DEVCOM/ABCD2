<?php
/* Modifications
20210310 fho4abcd Corrected php tag on last line
*/
if (isset($index)){
?>
		<a class="bt-tool" href='javascript:SendTo("D")' title="<?php echo $msgstr["sendto"]?> <?php echo $msgstr["doc"]?>">
			<img style="width: 24px;" src="../../assets/svg/common/word_48x1.svg">	
		</a>
		<a class="bt-tool" href='javascript:SendTo("W")' title="<?php echo $msgstr["sendto"]?> <?php echo $msgstr["xls"]?>">
			<img style="width: 24px;" src="../../assets/svg/common/excel_48x1.svg">	
			
		</a>
<script>

function SendTo(SendTo){
	index="<?php echo $index?>"
	tit="<?php echo $tit?>"
	Expresion="<?php echo $Expresion?>"
	base="<?php echo $arrHttp["base"]?>"
	sort="<?php echo $arrHttp["sort"]?>"
	msgwin=window.open("sendto_ex.php?base="+base+"&sort="+sort+"&Opcion="+SendTo+"&index="+index+"&tit="+tit+"&Expresion="+Expresion,"sendto")
	msgwin.focus()
}
</script>
<?php } ?>