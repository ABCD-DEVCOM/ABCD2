<?php
$path="../";
include("tope.php");?>

<?php
$fp=file($path."data/bases.dat");
foreach ($fp as $value){
	$val=trim($value);
	if ($val!=""){
		$v=explode('|',$val);
		$bd=$v[0];
		if ($bd==$_REQUEST["base"]){
			$desc=$v[1];
			$desc_bd="";
			$fr_01=file($path."data/$bd.def");
			foreach ($fr_01 as $bd_text){
				if (trim($bd_text)!=""){
					$desc_bd.=$bd_text;
				}
			}
?>

        <div class="post">
          <h2 class="title">Búsqueda libre</h2>
          <h2 class="title"><a href="buscar.php?Opcion=palabras&Expresion=$&base=<?php echo $bd?>"><?php echo $desc?></a></h2>

          <div class="entry">
            <p><?php echo $desc_bd?></p>
          	<h3>Buscar </h3>
            <form method="post" action="buscar.php">
            	<input type=hidden name=base value=<?php echo $bd?>>
                <input type="text" id="search-text" name="Expresion" value="" />
                <input type="submit" id="search-submit" value="Buscar" />
                <a href=diccionario.php?prefijo=TW_&campo=Diccionario+general&Opcion=detalle&base=<?php echo $bd?> class=button>Ver diccionario</a>
                <input type="hidden" name=Opcion value=palabras>
                <input type="hidden" name="prefijo" value=TW_>
                <br>
                <table>
                	<tr>
                		<td>
                			los resultados deben incluir:
                		</td>
                		<td>
                			<input type=radio name=Incluir value=or checked>Alguna de las palabras
                		</td>
                	</tr>
                	<tr>
                		<td></td>
                		<td>
                			<input type=radio name=Incluir value=and>Todas las palabras
                		</td>
                	</tr>
                </table>

                <p class="byline"><br>
            	<a href="<?php echo $path?>php/otras_busquedas.php?base=<?php echo $bd?>" class="comments">Otras búsquedas</a>
          	</p>
            </form>
            <p>
          </div>
        </div>

<?php
		break;
		}
	}
}?>
      </div>
      <!-- end div#content -->

  <!-- end div#page -->
<?php include("footer.php")?>
</body>
</html>
