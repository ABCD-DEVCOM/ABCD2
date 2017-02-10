<table width="100%" border="0" cellpadding="0" cellspacing="0" >
  <tbody>
  <tr>
    <td valign="top" class="cuerpoCuad">&nbsp;</td>
    <td colspan="2" valign="top" class="cuerpoText1">       
    <table width="780" border="0" cellspacing="0" cellpadding="1" bordercolor="#cccccc" class="textNove">
      <tbody>
      <tr>
	    <td height="12">
		<!-- SUBTITULO -->
		<i>
		<?php
		echo $labels['title']; echo "<br>";
		echo $labels['subtitle'];
		?>	
		</i>		
	    </td>
      </tr>
      <tr>
	    <td>
	    &nbsp;
	    </td>
      </tr>

	  <!-- El archivo que procesa los datos del form -->
      <tr>
	    <td>
		  <form method=post name=forma1 action=fmt.php onSubmit="javascript:return false" id=forma1>	
	      <!-- subtitle USER -->		  
	      <span class="textNove">
		  <b>
		  <?php 
		  echo $labels['subtitle_user']
		  ?> 
		  </b>
		  </span>
	      <!-- </form> -->
	    </td>
      </tr>

      <!-- Cédula -->
      <tr>
	    <td>		
	    <table border="0" class="errorRow" style="display:none" id="validation_table">
	    <tbody>
	      <tr>
	      <td width="600">
			<div id="validation"></div>
	      </td>
	      </tr>
	    </tbody>
	    </table>
	    </td>
      </tr>	  
	  
      <!-- Cédula -->
      <tr>
	    <td>		
	    <table border="0" class="textNove">
	    <tbody>
	      <tr>
	      <td width="210"><?php echo $labels['id']." :"; ?> <br>
		  <!-- <i>La cédula debe incluir el dígito de control, ej  12345678</i> -->
		  <div class = 'subtitle'><?php echo $labels['subid']; ?></div>
	      </td>
	      <td valign="top">
		  <input type="text" id="ci" name="tag630" size="10" maxlength="10"> <br>
	      </td>
	      </tr>
	    </tbody>
	    </table>
	    </td>
      </tr>

    <!-- Nombre-->
    <tr>
	<td>
	  <table border="0" class="textNove">
	    <tbody>
	      <tr>
		    <td width="210"><?php echo $labels['name']." :"; ?> <br>
		    <div class = 'subtitle'><?php echo $labels['subname'].":"; ?></div>
		    </td>
		    <td valign="top">
		      <input type="text" id="nombre" name="tag510" size="35" maxlength="35">
		    </td>
	      </tr>
	    </tbody>
	    </table>
	  </td>
	</tr>

	<!-- Categoría -->
	<tr>
	  <td>
	    <table border="0" class="textNove">
	      <tbody>
	      <tr>
		    <td width="210"><?php echo $labels['category']." :"; ?> <br>
		    </td>
		    <td>
		      <select name="tag520" id="categoria">
				  <?php					
					$first = true;
					foreach ($combos["categoria"] as $key => $value) {
						if ($first) {
							echo "<option value=\"".$key."\" selected>".$value."</option>\n";
							$first = false;
						} else {
							echo "<option value=\"".$key."\">".$value."</option>\n";
						}
					}
				  ?>			  
		      </select>
		  </td>
	      </tr>
	      </tbody>
	    </table>
	  </td>
	</tr>

	<!-- Email -->
    <tr>
	  <td>	
	    <table border="0" class="textNove">
	      <tbody>
	      <tr>
		    <td width="210">
		    <?php echo $labels['email']." :"; ?>
		    </td>
		    <td>
		      <input type="text" name="tag528" id="emailUsuario"  size="35"
maxlength="55">
		    </td>
	      </tr>
          </tbody>
	  </table>
        </td>
	</tr>

	<!-- Tel -->
	<tr>
	  <td>
	    <table border="0" class="textNove">
	      <tbody>
	      <tr>
		    <td width="210" valign="top" >
		    <?php echo $labels['phone']." :"; ?>
		    </td>
            <td valign="top">
		    <input type="text" id="tel" name="tag512" size="20" maxlength="35">		
			<div class="pre-spoiler" style="margin: 2px 0 3px 0">
				<a href ='#' style="width: 80px; font-size: 12px; font-family: trebuchet ms; color:#000000;"
				onclick="if(this.parentNode.getElementsByTagName('div')[0].style.display != ''){this.parentNode.getElementsByTagName('div')[0].style.display = '';this.value = 'Ocultar'; document.getElementById('tel_2').focus();}else{this.parentNode.getElementsByTagName('div')[0].style.display = 'none'; this.value = 'Ver más'; document.getElementById('notas').focus();}" >
				<?php echo $labels['addphone']; ?></a><div class="spoiler" style="display: none; padding: 5 0 0 0;">
				<input type="text" id="tel_2" name="tag512" size="20" maxlength="35">
			</div>
			</div>
		    </td>
			</tr>   
	      </tbody>		  
	  </table>
	</td>
	</tr>   

	<!-- Notas del solicitante -->
	<tr>
	  <td>
	    <table border="0" class="textNove">
	      <tbody>
	      <tr>
		    <td width="210" valign="top" style="padding:5 0 0 0">
		    <?php echo $labels['comments']." :"; ?>
		    </td>
            <td valign="top" style="padding:0 0 7 0">
		    <textarea  id="notas" cols="40" rows="5"  name="tag068" style="overflow:hidden; resize:none; family: Verdana; font-size: 9 pt; height: 85; font-family: Verdana; background-color: #FFFFFF; color: #000000; maxlegth='100' size='80'"></textarea> 
		    </td>
	      </tr>
	      </tbody>
	  </table>
	</td>
	</tr>   

    <!-- DATOS DE LA BUSQUEDA -->
    <tr>
      <td><span class="textNove"><b><?php echo $labels['subtitle_request']." :"; ?></b></span></td>
    </tr>	
	
	<!-- as|articulo de revista - am|capitulo de libro -->
	<tr>
	  <td>
	    <table border="0" class="textNove">
	    <tbody>
	    <tr>
	      <td width="210">
		    <?php echo $labels['level']." :"; ?><br>
	      </td>	      
	      <td>
		  <select name="tag006"  id="nivelbiblio">
			<option value="" selected><?php echo $labels['selectlevel']; ?></option>
			<?php			
			//$first = true;			
			foreach ($combos["nivelbiblio"] as $key => $value) {
				echo "<option value=\"".$key."\">".$value."</option>\n";
			}
		  ?>
		  </select>
	      </td>
	    </tr>
	    </tbody>
		</table>
	  </td>
	</tr>
	
    <!-- Autor -->    
    <tr>
	  <td>
	  <div style="display: none" id="div_autor_obra">
	  <table border="0" class="textNove">
	    <tbody>
	    <tr>
	      <td width="210"> 
	      <label id="lbl_autor_obra">Author of work</label>
	      </td>	
	      <td align="left">
		    <input type="text" id="autorObra" name="tag010" size="35"
maxlength="256">
	      </td>
	  </tr>
	  </tbody>
	  </table>
	</td>
	</div>
    </tr>
    
    <!-- Titulo -->
    <tr>
      <td>
      <div style="display: none" id="div_titulo_obra">
	  <table border="0" class="textNove">
	  <tbody>
	  <tr>
	    <td width="210"> 
	    <label id="lbl_titulo_obra">Title of work</label>
	    </td>
	    <td align="left">
	      <input type="text" name="tag012" id="tituloObra" size="35" maxlength="256">
	    </td>
	  </tr>
	  </tbody>
	</table>
	</div>
    </td>
   </tr>

   <tr>
	  <td>
	  <div style="display: none" id="div_autor_especifico">
	  <table border="0" class="textNove">
	    <tbody>
	    <tr>
	      <td width="210"> 
	      <label id="lbl_autor_especifico">Specific author</label>
	      </td>	
	      <td align="left">
		    <input type="text" id="autorEspecifico" name="tag010" size="35" maxlength="256">
	      </td>
	  </tr>
	  </tbody>
	  </table>
	</td>
	</div>
    </tr>

    <!-- Titulo libro, tesis, revista -->
    <tr>
    <td>
    <div style="display: none" id="div_titulo_especifico">
	<table border="0" class="textNove">
	  <tbody>
	  <tr>
	    <td width="210">
	    <label id="lbl_titulo_especifico">Specific title</label>
	    </td>
	    <td align="left">
	      <input type="text" name="tag018" id="tituloEspecifico" size="35" maxlength="256">
	    </td>
	  </tr>
	  </tbody>
	</table>
	</div>
    </td>
   </tr> 

    <!-- pag inicial y final -->
    <tr>
	<td>
      <div style="display: none" id="div_paginas">
	  <table border="0" class="textNove">
	    <tbody>
	    <tr>	
	      <td width="210">
		  <label id="lbl_pagina_inicial">First Page</label>
	      </td>
	      <td align="left" width="88">
		  <input type="text" id="pagInicial" name="tag020" size="5" maxlength="6">
	      </td>
	      <td width="130">
		  <label id="lbl_pagina_final">Last Page</label>
	      </td>
	      <td align="left">
		    <input type="text" name="tag021" id="pagFinal"  size="5"
maxlength="6">
	      </td>
	    </tr>
      </tbody>
	  </table>	  
	  </div>
	  </td>
      </tr>
	  
    <!-- Año, edicion -->
    <tr>
    <td>
    <div style="display: none" id="div_ano_edicion">
	<table border="0" class="textNove">
	  <tbody>
	  <tr>
	    <td width="210">
	    <label id="lbl_ano">Year</label>
	    </td>
	    <td align="left" width="88">
	      <input type="text" id="ano"  name="tag064" size="5" maxlength="6">
	    </td>
	    <td width="130">
	    <label id="lbl_edicion">Edition</label>
	    </td>
	    <td align="left">
	    <input type="text" name="tag065" id="edicion" size="5" maxlength="6">
	    </td>
	  </tr>
	  </tbody>
	</table>
	</div>
    </td>
   </tr>   

    <!-- volumen numero SOLO REVISTA -->    
    <tr>
      <td>
        <div style="display: none" id="div_volumen_numero">
        <table border="0" class="textNove">
          <tbody
          <tr>
            <td width="210">
			<label id="lbl_volumen">Journal Volume</label>
            </td>
            <td align="left" width="88">
              <input type="text" name="tag031" id="volumenRevista" size="5" maxlength="5">
            </td>
            <td width="130">
			<label id="lbl_numero">Journal number</label>
            </td>
            <td align="left">
              <input type="text" id="numeroRevista"  name="tag032" size="5" maxlength="5">
            </td>
          </tr>
          </tbody>
        </table>
        </div>
      </td>
    </tr>    
    <!-- Botones para enviar -->
    <tr>
      <td align="center" class="txt1">	    
		<table border=0>
		  <tr>
		    <td align=center style="padding: 10 20 0 0"><a
href="javascript:enviarForm()"><img src='../dataentry/img/barSave.png' border=0
alt="Send request></a></td>
			<td align=center style="padding: 10 20 0 0"><a
href="javascript:cancelarEnvio()"><img src='../dataentry/img/barCancelEdit.png'
border=0 alt="Clean form"></a></td>
		  </tr>
		</table>
		<input type=hidden name=IsisScript value=ingreso.xis>
		<!-- <input type=hidden name=base value=odds> -->
		<!-- <input type=hidden name=cipar value=odds.par> -->
		<input type=hidden name=Opcion value="crear"> 
		<input type=hidden name=ValorCapturado value="">
		<input type=hidden name=check_select value="">
		<!-- <input type=hidden name=Mfn value="New"> -->
		<input type=hidden name=ver value=S>
		<input type=hidden name=Formato value='odds'>		
		<input type=hidden name=tag094 value='0'>
		</form> 
      </td>
    </tr>
    </tbody>
    </table>

</td></tr>
</tbody>
</table>
