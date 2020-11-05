<?php
function SlideShow($imagen,$titulo,$ficha){

	echo "<script type=\"text/javascript\">

\n";

$ix=-1;
foreach ($imagen as $key => $i){	$ix=$ix+1;	echo "image[$ix]=\"$i\"\n";
	echo "link[$ix]=\"$i\"\n";
	$caption="<strong>".$titulo[$ix]."</strong>";
	$cuenta=$ix+1;
	echo "titulo[$ix]=\"$caption<br>\"\n";
	$caption=str_replace("\n","",$ficha[$ix]);
	echo "ficha[$ix]=\"$caption\"\n";}?>

</script>

<table style="border:none;background-color:transparent;" align=center border=0>
<tr>
<td align=center>
<div id ="mydiv"></div>
<a name="link" id="link"  target="_blank"><img name="slide" id="slide" alt="my images" height=500  src=""/></a>
</td>
</tr>
<tr>
<td align="center">

<p><br>

<script>
tope=image.length
document.writeln('<a href="javascript:AnteriorImagen()">Anterior</a>&nbsp;')
for (i=0;i<tope;i++){	j=i+1	document.writeln('<a href="javascript:swapImage('+i+')">'+j+'</a>&nbsp;')}
document.writeln('<a href="javascript:ProximaImagen()">Próximo</a>&nbsp;')
</script>
</td>
</tr>
</table>
<div id=galeria></div>



<?php
}
?>
