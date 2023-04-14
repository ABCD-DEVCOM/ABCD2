<?php

function LeerNumeroClasificacion($base){
global $db_path,$lang_db,$prefix_nc,$prefix_in;
	$prefix_nc="";
	$archivo=$db_path.$base."/loans/".$_SESSION["lang"]."/loans_conf.tab";
	if (!file_exists($archivo)) $archivo=$db_path.$base."/loans/".$lang_db."/loans_conf.tab";
	$fp=file_exists($archivo);
	if ($fp){
		$fp=file($archivo);
		foreach ($fp as $value){
			$ix=strpos($value," ");
			$tag=trim(substr($value,0,$ix));
			switch($tag){
				case "IN": $prefix_in=trim(substr($value,$ix));
					break;
				case "NC":
					$prefix_nc=trim(substr($value,$ix));
					break;
			}
		}
	}
}

if (file_exists($db_path."loans.dat"))
	echo "<script>search_in='IN='\n";
else
    echo "<script>search_in=''\n";
echo "</script>\n";

?>

<script>
kardex=""

function ValidarFecha(){
	msg=""
	valor=Trim(document.inventorysearch.date.value)
	if (valor!=""){
		var expreg = /^(\d{4})([0][1-9]|[1][0-2])([0][1-9]|[12][0-9]|3[01])$/;
   		if (!expreg.test(valor) )  {
            msg="<?php echo $msgstr["js_inv_dateformat"]?>"
        }else{
   			var today = "<?php echo date("Ymd")?>";
   			if (valor<today) msg="<?php echo $msgstr["js_inv_date"]?>"
   		}
   		if(msg!=""){
   			alert(msg)
   			return false
   		}
	}
	return true
}

function DateToIso(From,To){
		if (Trim(From)=="") {
			To.value=""
			return
		}
        d=new Array()
		d[0]=""
		d[1]=""
		d[2]=""
        if (From.indexOf('-')>1){
			d=From.split('-')
		}else{
			if (From.indexOf('/')>1){
				d=From.split('/')
			}else{
				iso=From
				return
			}
		}
		<?php echo "dateformat=\"$config_date_format\"\n" ?>

		if (dateformat=="d/m/Y"){
			iso=d[2]+d[1]+d[0]
		}else{
			iso=d[2]+d[0]+d[1]
		}
		To.value=iso
	}


function CambiarBase(){
	bd_sel=document.inventorysearch.db_inven.selectedIndex
	bd_a=document.inventorysearch.db_inven.options[bd_sel].value
	b=bd_a.split('|')
	kardex=b[5].toUpperCase()
	if (kardex=="KARDEX"){
       document.getElementById('kardex').style.visibility = 'visible';
       document.getElementById('kardex').style.display = 'block';
	}else{
       document.getElementById('kardex').style.visibility = 'none';
       document.getElementById('kardex').style.display = 'none';
	}
}

function EnviarForma(){
	if (ASK_LPN=="Y"){
		ret=ValidarFecha()
		if (ret==false)
			return
	}
	loan_policy="<?php echo $LOAN_POLICY?>"
	if (Trim(document.inventorysearch.inventory_sel.value)=="" || Trim(document.inventorysearch.usuario.value)=="" ){
		alert("<?php echo $msgstr["falta"]." ".$msgstr["inventory"]." / ".$msgstr["usercode"]?>")
		return
	}
	if (kardex=="KARDEX"){
		if (Trim(document.inventorysearch.year.value)=="" || Trim(document.inventorysearch.numero.value)=="" ){
			alert("Debe especificar el a�o, el n�mero y opcionalmente el volumen")
			return
		}
	}
    INV=escape(document.inventorysearch.inventory_sel.value)
    if (loan_policy=="BY_USER")
    document.inventorysearch.action="ask_policy.php"
    document.inventorysearch.inventory.value=INV
    document.inventorysearch.submit()
}

function AbrirIndiceAlfabetico(xI,Prefijo,Subc,Separa,db,cipar,tag,postings,Repetible,Formato){
		Ctrl_activo=xI
		lang="en"
	    Separa="&delimitador="+Separa
	    library=""
		<?php if (isset($_SESSION["library"]))  echo "library='".$_SESSION["library"]."_'\n";?>
	    Prefijo=Separa+"&tagfst="+tag+"&prefijo="+Prefijo+library
	    ancho=200
		url_indice="capturaclaves.php?opcion=autoridades&base="+db+"&cipar="+cipar+"&Tag="+tag+Prefijo+"&postings="+postings+"&lang="+lang+"&repetible="+Repetible+"&Formato="+Formato
		msgwin=window.open(url_indice,"Indice","width=480, height=425,left=200,scrollbars")
		msgwin.focus()
}

function AbrirIndice(Tipo,xI){
	Ctrl_activo=xI
	lang="<?php echo $_SESSION["lang"]?>"
	library=""
	<?php if (isset($_SESSION["library"]))  echo "library='_".$_SESSION["library"]."'\n";?>
	<?php if (isset($LOAN_POLICY) and $LOAN_POLICY=="BY_USER")
    				echo "Repetible=0\n";
    	              else
    	            echo "Repetible=1\n";
 	?>
	switch (Tipo){
		case "S":
			bd_sel=document.inventorysearch.db_inven.selectedIndex
			if (bd_sel<=0){
				alert("debe seleccionar una base de datos")
				return
			}
			bd_a=document.inventorysearch.db_inven.options[bd_sel].value
			b=bd_a.split('|')
			bd=b[0]
			switch (bd){
				case "loanobjects":
					Separa=""
					ancho=200
					if (search_in==""){
		    			Prefijo=Separa+"&prefijo=IN_"
						url_indice="capturaclaves.php?opcion=autoridades&base=loanobjects&cipar=loanobjects.par"+Prefijo+"&postings=1"+"&lang="+lang+"&repetible=0&Formato=@autoridades.pft"
					}else{
						ix=document.inventorysearch.db_inven.selectedIndex
						sel=document.inventorysearch.db_inven.options[ix].value
						s=sel.split('|')
						bd=s[0]
						pref="IN_"
						Prefijo=Separa+"&prefijo="
						url_indice="capturaclaves.php?opcion=autoridades&base="+bd+"&cipar="+bd+".par"+Prefijo+"&postings=1"+"&lang="+lang+"&repetible="+Repetible+"&Formato=@autoridades.pft"
					}
					break;
				default:

					prefijo=b[2]
					formato=b[3]
					AbrirIndiceAlfabetico(xI,prefijo,"","",bd,bd+".par","3",1,Repetible,formato)
					break
			}
			break
		case "I":
			Separa=""
			ancho=200

			if (search_in==""){
    			Prefijo=Separa+"&prefijo=IN_"

				url_indice="capturaclaves.php?opcion=autoridades&base=loanobjects&cipar=loanobjects.par"+Prefijo+"&postings=1"+"&lang="+lang+"&repetible="+Repetible+"&Formato=@autoridades.pft"
			}else{
				ix=document.inventorysearch.db_inven.selectedIndex
				sel=document.inventorysearch.db_inven.options[ix].value
				s=sel.split('|')
				bd=s[0]
				pref="IN_"+pref
				Prefijo=Separa+"&prefijo="+pref
				url_indice="capturaclaves.php?opcion=autoridades&base="+bd+"&cipar="+bd+".par"+Prefijo+"&postings=1"+"&lang="+lang+"&repetible="+Repetible+"&Formato=@autoridades.pft"
			}
			break
		case "U":
<?php
// The prefix and format are read to extract the user code.
// O prefixo e o formato são lidos para extrair o código do usuário.

			$us_tab=LeerPft("loans_uskey.tab","users");
			$t=explode("\n",$us_tab);
			$codigo=LeerPft("loans_uskey.pft","users");
?>
			Separa=""
			Formato="<?php if (isset($t[2]))  echo trim($t[2]); else echo 'v30';?>,`$$$`,<?php echo str_replace("'","`",trim($codigo))?>"
    		Prefijo=Separa+"&prefijo=<?php if (isset($t[1])) echo trim($t[1]); else echo 'NO_';?>"
    		ancho=200
			url_indice="capturaclaves.php?opcion=autoridades&base=users&cipar=users.par"+Prefijo+"&postings=1"+"&lang="+lang+"&repetible=0&Formato="+Formato
			break
	}
	msgwin=window.open(url_indice,"Indice","width=480, height=450,left=300,scrollbars")
	msgwin.focus()
}
ASK_LPN="<?php echo $ASK_LPN?>"


function EnviarForma_status(Proceso){
		if (Trim(document.inventorysearch.usuario.value)=="" ){
		alert("<?php echo $msgstr["falta"]." ".$msgstr["usercode"]?>")
		return
	} else {
	document.inventorysearch.submit()
	}
}
</script>

<?php
$encabezado="";

echo "<body onLoad=javascript:document.inventorysearch.inventory_sel.focus()>\n";

$link_u="";
if (isset($arrHttp["usuario"]) and $arrHttp["usuario"]!="") $link_u="&usuario=".$arrHttp["usuario"];
?>


<form name="inventorysearch" action="panel_loans.php" method="post" onsubmit="javascript:return false">
	<input type="hidden" name="loan_policy" value="<?php echo $LOAN_POLICY;?>">
	<input type="hidden" name="Opcion" value="prestar">
	<input type="hidden" name="lang" value="<?php echo $lang;?>">
	<input type="hidden" name="inventory">

	
<div>

<?php
//Read bases.dat to find the databases connected with the circulation module, if not, working with copies databases

$sel_base="N";
if (file_exists($db_path."loans.dat")){
	$fp=file($db_path."loans.dat");
	$sel_base="S";
?>

		<h4 for="dataBases"><?php echo $msgstr["basedatos"]?></h4>
		<select name="db_inven" onchange="CambiarBase()" class="w-10">
		<option></option>
<?php
	$xselected=" selected";
	$cuenta=0;
	foreach ($fp as $value){
		if (trim($value)!=""){
			$cuenta=$cuenta+1;
			$value=trim($value);
			$v=explode('|',$value);
			//SE LEE EL PREFIJO PARA OBTENER EL NUMERO DE INVENTARIO DE LA BASE DE DATOS
			$value=$v[0].'|'.$v[1];
			LeerNumeroClasificacion($v[0]);
			$pft_ni=LeerPft("loans_inventorynumber.pft",$v[0]);

			$signa=LeerPft("loans_cn.pft",$v[0]);
            if (isset($_SESSION["library"])) $prefix_in=$prefix_in;
			$value.="|".$prefix_in."|ifp|".urlencode($signa);
			$value.='|';
			if (isset($v[2])){
				$value.=$v[2];
			}

			if (isset($_SESSION["loans_dbinven"])){

				if ($_SESSION["loans_dbinven"]==$v[0])
					$xselected=" selected";
				else
					$xselected="";
			}
			echo "<option value='$value' $xselected>".$v[1]."</option>\n";
			$xselected="";
		}
	}

?>
		</select>


<?php }?>

	<h4 for="searchExpr"><?php echo $msgstr["usercode"]?></h4>
	<div class="w-10">
			<button type="button" name="list" title="<?php echo $msgstr["list"]?>" class="bt-blue col-2 p-2 m-0" onclick="javascript:AbrirIndice('U',document.inventorysearch.usuario)"/><i class="fa fa-search"></i> </button>
			<input type="text" class="col-7 p-2 m-0" name="usuario" id="usuario" 
			<?php
			if (isset($arrHttp["usuario"]) and $arrHttp["usuario"]!="")
			echo "value=\"".$arrHttp["usuario"]."\"";
			?> onclick="document.inventorysearch.usuario.value=''"/>


			<button type="button" name="buscar" title="Pesquisar" class="bt-green col-2 p-2  m-0" onclick="javascript:EnviarForma_status('U')"><i class="fas fa-arrow-right"></i></button>
	</div>
	

	<h4 for="searchExpr"><?php echo $msgstr["inventory"];?></h4>
	<div class="w-10">
		
		<?php 
		if (isset($LOAN_POLICY) and $LOAN_POLICY=="BY_USER"  ){
			echo "<input class=\"w-10\" type=text name=\"inventory_sel\" id=\"inventory_sel\" value=\"";
			if (isset($arrHttp["inventory_sel"])) echo $arrHttp["inventory_sel"];
				echo "\">\n";
			  }else{
			?>	
				<textarea name="inventory_sel" id="inventory_sel" rows="5" class="w-10"></textarea>
	 		<?php  
			}
			?>
	    <button type="button" name="list" title="<?php echo $msgstr["list"];?>" class="bt-block w-10 bt-blue" onclick="javascript:AbrirIndice('<?php if ($sel_base=="S") echo "S"; else echo "I";?>',document.inventorysearch.inventory_sel);return false"/><i class="fa fa-search"></i> <?php echo $msgstr["list"];?></button>

	</div>

	<div  class="w-10">
<?php
if (isset($ASK_LPN) AND $ASK_LPN=="Y"){
			echo "
			<label for=date>".$msgstr["date"]. "<!-- calendar attaches to existing form element -->
					<input type=text name=date id=date"."_c Xreadonly=\"1\"  value=\"\" size=10";
			echo " onChange='Javascript:DateToIso(this.value,document.inventorysearch.date)'";
			echo "/>

                <i class=\"far fa-calendar-alt\" title=\"Date selector\" id=\"f_date\" style=\"cursor: pointer;\"></i>
				
				<script type=\"text/javascript\">
				   Calendar.setup({
       					inputField     :    \"date"."_c\",     // id of the input field
						ifFormat       :    \"";
						if (($config_date_format=="DD/MM/YY") or ($config_date_format=="d/m/Y")) {    // format of the input field
						   	echo "%d/%m/%Y";
						} else {
							echo "%m/%d/%Y";
						}	
						echo "\",
						    button         :    \"f_date\",  // trigger for the calendar (button ID)
						   	align          :    '',           // alignment (defaults to \"Bl\")
							singleClick    :    true
					});
				</script>";
			    echo" &nbsp;&nbsp; <strong> or </strong>
					<label for=lappso><strong>".$msgstr["days"]."</strong><input type=text name=lpn size=4>\n";

		}
?>
	</div>

	<h4 for="searchExpr"><?php echo $msgstr["comments"]?></h4>
	<div  class="w-10">
		<input type="text" name="comments"  maxlength="100" class="w-10">
		<button type="submit" name="prestar" title="<?php echo $msgstr["loan"]?>" class=" bt-green w-10" onclick="javascript:EnviarForma()"/> <?php echo $msgstr["loan"]?> <i class="fas fa-arrow-right"></i></button>
        <small><?php echo $msgstr["clic_en"]." <i>[".$msgstr["loan"]."]</i> ".$msgstr["para_c"]?></small>
	</div>
</form>

	</div>

<?php

if (isset($cuenta) and $cuenta==1){
	echo "<script>
	        document.inventorysearch.db_inven.selectedIndex=2
	     </script";
}

if (file_exists($db_path."loans.dat")){
	$fp=file($db_path."loans.dat");
	$sel_base="S";
?>
<script>CambiarBase()</script>
<?php } ?>