</select>
   <INPUT TYPE=hidden VALUE="<?php echo $arrHttp["LastKey"]?>" NAME="LastKey">
   <br>
 </td>
 <td width=10>&nbsp;</td>
 <td class=textbody03 ><?php echo $msgstr["otrotermino_1"]?>
 <input type=text name="IR_A" size=10 >
 <?php echo $msgstr["otrotermino_2"]?>
 <a href="javascript:EjecutarBusqueda(this,3)" class=boton>&nbsp;&nbsp;<?php echo $msgstr["continuar"]?>&nbsp;&nbsp;</a>.
<?php if (!isset($arrHttp["Target"])){
	echo " <p>".$msgstr["finsel_1"]." <a href=\"javascript:EjecutarBusqueda(this,1)\" class=boton>&nbsp;&nbsp;".$msgstr["buscar"]."&nbsp;&nbsp;</a> ".$msgstr["finsel_2"];
}
if ($arrHttp["campo"]!="" and  !isset($arrHttp["Target"])) {
    echo "<p><a href=\"javascript:EjecutarBusqueda(this,2)\" class=boton>&nbsp;&nbsp;".$msgstr["ptersel"]."&nbsp;&nbsp;</a> ".$msgstr["pterselmsg"];
}
?>
            </td>
          </tr>
          <tr>
            <td align=center><a href="javascript:EjecutarBusqueda(this,4)" class=boton>&nbsp;&nbsp;<?php echo $msgstr["masterms"]?>&nbsp;&nbsp;</a>
            </td>
          </tr>
        </table>
      </td>
  </table>
</div>
</form>
<?php include ("../common/footer.php")?>
</body>
</html>
