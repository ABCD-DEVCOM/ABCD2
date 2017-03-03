</select>
   <INPUT TYPE=HIDDEN VALUE="<?php echo $arrHttp["LastKey"]?>" NAME="LastKey">
   <br>
 </td>
 <td width=10>&nbsp;</td>
 <td class=textbody03 ><?php echo $msgstr["otrotermino_1"]?>
 <input type=text name="IR_A" size=10>
 <?php echo $msgstr["otrotermino_2"]?>&nbsp;&nbsp;
 <strong><a href="javascript:EjecutarBusqueda(this,3)" class=boton><?php echo $msgstr["continuar"]?></a></strong>&nbsp;&nbsp;.
<?php
if (!isset($arrHttp["toolbar"])){
// Si existe $arrHttp["Target"] no se realiza la búsqueda directamente
	if (!isset($arrHttp["Target"])) echo "<p>".$msgstr["finsel_1"]."&nbsp;&nbsp; <strong><a href=\"javascript:EjecutarBusqueda(this,1)\" class=boton>".$msgstr["buscar"]."</a></strong> &nbsp;&nbsp;".$msgstr["finsel_2"];

    echo "<p><strong><a href=\"javascript:EjecutarBusqueda(this,2)\" class=boton>".$msgstr["ptersel"]."</a></strong> &nbsp;&nbsp; ".$msgstr["pterselmsg"];
}
?>
            </td>
          </tr>
          <tr>
            <td align=center>&nbsp;&nbsp;<strong><a href="javascript:EjecutarBusqueda(this,4)" class=boton><?php echo $msgstr["masterms"]?></a>&nbsp;&nbsp;
            </td>
          </tr>
        </table>
      </td>
  </table>

</form>
</div>
</div>
<?php include("../common/footer.php")?>


