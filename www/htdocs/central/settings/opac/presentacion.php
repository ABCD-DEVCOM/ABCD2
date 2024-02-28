<?php
include ("conf_opac_top.php");
$wiki_help="OPAC-ABCD_Apariencia#Estilos";
include "../../common/inc_div-helper.php";
?>

<script>
var idPage="apariencia";
</script>


<script src="/assets/js/jscolor.js"></script>

<style>
table tr td.inputs{ display: inline-flex; margin-right: 30px; }
table tr td.preview{ vertical-align: top; }
.sticky-element {
  position: relative;
}

.sticky-element.fixed {
  position: fixed;
  top: 25%; /* Ajuste conforme necessário */
  right: 0;
  transform: translate(0, -50%); /* Centraliza verticalmente */
  width: 40%;
}

</style>

<div class="middle form row m-0">
	<div class="formContent col-2 m-2">
			<?php include("conf_opac_menu.php");?>
	</div>
	<div class="formContent col-9 m-2">

<?php

$file_update=$db_path."opac_conf/global_style.def";

if (isset($_REQUEST["Opcion"]) and $_REQUEST["Opcion"]=="Guardar") {
	$fp=fopen($file_update,"w");
	?>

    <div class="alert success" onload="setTimeout(function () { window.location.reload(); }, 10)" >
		<?php echo $msgstr["updated"];?>
		<pre><?php echo $file_update; ?></pre>
	</div>

	<pre><code>
<?php
	foreach ($_REQUEST as $var=>$value){
		$value=trim($value);
		if ($value!=""){
			$var=trim($var);
			if (substr($var,0,4)=="cfg_"){
				if (substr($var,4)=="OpacHttp"){
					if (substr($value,strlen($value)-1,1)!="/"){
						$value.="/";
					}
				}
				echo substr($var,4)."=".$value."\n";
				fwrite($fp,substr($var,4)."=".$value."\n");
			}
		}
	}
	echo "</code></pre>";
	fclose($fp);
	
	?>

	<a class="bt bt-green" href="javascript:EnviarForma('presentacion.php')">Voltar</a>
	
    <?php exit(); ?>

    <?php } ?>

<?php

$opac_global_style_def = $db_path."/opac_conf/global_style.def";

if (file_exists($opac_global_style_def)) {
    $opac_gstyle_def = parse_ini_file($opac_global_style_def,true); 
    if (isset($opac_gstyle_def['NUM_PAGES'])) $npages=$opac_gstyle_def['NUM_PAGES'];
    if (isset($opac_gstyle_def['SIDEBAR'])) $sidebar=$opac_gstyle_def['SIDEBAR'];
    if (isset($opac_gstyle_def['TOPBAR'])) $topbar=$opac_gstyle_def['TOPBAR'];
    if (isset($opac_gstyle_def['CONTAINER']))$container=$opac_gstyle_def['CONTAINER'];
}
?>


<h3><?php echo $msgstr["parametros"]." (global_style.def)";?></h3>

<form name="parametros" method="post">
<input type="hidden" name="db_path" value="<?php echo $db_path;?>">
<input type="hidden" name="lang" value="<?php echo $_REQUEST["lang"];?>">
<input type="hidden" name="Opcion" value="Guardar">

<?php
    if (isset($_REQUEST["conf_level"])){
        echo "<input type=hidden name=conf_level value=".$_REQUEST["conf_level"].">\n";
    }
?>

<?php  if (!isset($shortIcon))$shortIcon=""; ?>

<h3><?php echo $msgstr["styles"];?></h3>
<?php echo $msgstr["styles_body"]?>
    <table>
        <tr>
            <th colspan="2" width="50%"><?php echo $msgstr["cfg_element"]?></th>

            <th><?php echo $msgstr["cfg_viewing"]?></th>
        </tr>
        <tr>
            <td>Topbar - Background </td>
            <td class="inputs">
                <input name="cfg_COLOR_TOPBAR_BG" id="cfg_COLOR_TOPBAR_BG"  value="<?php if (isset($opac_gstyle_def['COLOR_TOPBAR_BG'])) echo $opac_gstyle_def['COLOR_TOPBAR_BG']; else echo "#000000" ?>"  data-jscolor="{}" onInput="update(this.jscolor, '#COLOR_TOPBAR_BG')">
                <button type="button"  onclick="return resetColor('#FFFFFFFF', 'COLOR_TOPBAR_BG')" >
                    <i class="fas fa-eraser"></i>
                </button>
			</td>

			<td rowspan="100%" class="preview">
                <div id="target-element"></div>

                <div class="sticky-element" >
                <svg width="100%"  viewBox="0 0 1080 675" fill="none"  xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_24_2)" >
                        <rect width="1080" height="56" id="COLOR_TOPBAR_BG" fill="<?php echo $opac_gstyle_def['COLOR_TOPBAR_BG']; ?>" stroke="#666596" stroke-width="1"/>
                        <rect width="1080" height="619" transform="matrix(1 0 0 -1 0 675)" id="COLOR_BG" fill="<?php echo $opac_gstyle_def['COLOR_BG']; ?>"  stroke="#848FF9" stroke-width="1"/>
                        <rect x="87" y="69" width="876" height="219" rx="10" id="COLOR_SEARCHBOX_BG" fill="<?php echo $opac_gstyle_def['COLOR_SEARCHBOX_BG']; ?>"  stroke="#383A76" stroke-width="1"/>
                        <rect x="116.5" y="111.5" width="191" height="30" rx="3.5" id="COLOR_BUTTONS_LIGHT_BG" fill="<?php echo $opac_gstyle_def['COLOR_BUTTONS_LIGHT_BG']; ?>" stroke="#A6A6A6"/>
                        <rect x="150" y="121.5" width="100" height="8" rx="3.5" id="COLOR_BUTTONS_LIGHT_TXT" fill="<?php echo $opac_gstyle_def['COLOR_BUTTONS_LIGHT_TXT']; ?>" stroke="#A6A6A6"/>
                        <rect x="116.5" y="218.5" width="261" height="30" rx="3.5" id="COLOR_BUTTONS_SECONDARY_BG" fill="<?php echo $opac_gstyle_def['COLOR_BUTTONS_SECONDARY_BG']; ?>" stroke="#A6A6A6"/>
                        <rect x="394.5" y="218.5" width="261" height="30" rx="3.5" id="COLOR_BUTTONS_SECONDARY_BG2" fill="<?php echo $opac_gstyle_def['COLOR_BUTTONS_SECONDARY_BG']; ?>" stroke="#A6A6A6"/>
                        <rect x="675.5" y="218.5" width="261" height="30" rx="3.5" id="COLOR_BUTTONS_SECONDARY_BG4" fill="<?php echo $opac_gstyle_def['COLOR_BUTTONS_SECONDARY_BG']; ?>" stroke="#A6A6A6"/>
                        <rect x="326.5" y="111.5" width="397" height="30" rx="3.5" fill="#FFFEFE" stroke="black" />
                        <rect x="742.5" y="111.5" width="194" height="30" rx="3.5" id="COLOR_BUTTONS_SUBMIT_BG" fill="<?php echo $opac_gstyle_def['COLOR_BUTTONS_SUBMIT_BG']; ?>" />
                        <path d="M133.5 181C133.5 182.451 132.668 183.814 131.222 184.834C129.778 185.854 127.756 186.5 125.5 186.5C123.244 186.5 121.222 185.854 119.778 184.834C118.332 183.814 117.5 182.451 117.5 181C117.5 179.549 118.332 178.186 119.778 177.166C121.222 176.146 123.244 175.5 125.5 175.5C127.756 175.5 129.778 176.146 131.222 177.166C132.668 178.186 133.5 179.549 133.5 181Z" fill="#D9D9D9" stroke="black"/>
                        <path d="M132.5 202C132.5 203.039 131.906 204.128 130.645 205.017C129.389 205.904 127.574 206.5 125.5 206.5C123.426 206.5 121.611 205.904 120.355 205.017C119.094 204.128 118.5 203.039 118.5 202C118.5 200.961 119.094 199.872 120.355 198.983C121.611 198.096 123.426 197.5 125.5 197.5C127.574 197.5 129.389 198.096 130.645 198.983C131.906 199.872 132.5 200.961 132.5 202Z" fill="#D9D9D9" stroke="#848FF9" stroke-width="3"/>
                        <rect x="360" y="367" width="608" height="110" rx="15" id="COLOR_RESULTS_BG" fill="<?php echo $opac_gstyle_def['COLOR_RESULTS_BG']; ?>" stroke="#383A76" stroke-width="1"/>
                        <rect x="360" y="303" width="608" height="48" rx="15" fill="#fff" stroke="#383A76" stroke-width="1"/>
                        <rect x="360" y="500" width="608" height="118" rx="15" id="COLOR_RESULTS_BG2" fill="<?php echo $opac_gstyle_def['COLOR_RESULTS_BG']; ?>" stroke="#383A76" stroke-width="1"/>
                        <rect x="89" y="327" width="240" height="3"  fill="<?php echo $opac_gstyle_def['COLOR_TEXT']; ?>" id="COLOR_TEXT" />
                        <rect x="89" y="357" width="240" height="3"  fill="<?php echo $opac_gstyle_def['COLOR_LINKS']; ?>" id="COLOR_LINKS" />
                        <rect x="89" y="387" width="240" height="3"  fill="<?php echo $opac_gstyle_def['COLOR_LINKS']; ?>" id="COLOR_LINKS2" />
                        <rect x="89" y="427" width="240" height="3"  fill="<?php echo $opac_gstyle_def['COLOR_LINKS']; ?>" id="COLOR_LINKS3" />
                        <path d="M101.023 40V16.7273H105.943V35.9432H115.92V40H101.023ZM139.659 28.3636C139.659 30.9015 139.178 33.0606 138.216 34.8409C137.261 36.6212 135.958 37.9811 134.307 38.9205C132.663 39.8523 130.814 40.3182 128.761 40.3182C126.693 40.3182 124.837 39.8485 123.193 38.9091C121.549 37.9697 120.25 36.6098 119.295 34.8295C118.341 33.0492 117.864 30.8939 117.864 28.3636C117.864 25.8258 118.341 23.6667 119.295 21.8864C120.25 20.1061 121.549 18.75 123.193 17.8182C124.837 16.8788 126.693 16.4091 128.761 16.4091C130.814 16.4091 132.663 16.8788 134.307 17.8182C135.958 18.75 137.261 20.1061 138.216 21.8864C139.178 23.6667 139.659 25.8258 139.659 28.3636ZM134.67 28.3636C134.67 26.7197 134.424 25.3333 133.932 24.2045C133.447 23.0758 132.761 22.2197 131.875 21.6364C130.989 21.053 129.951 20.7614 128.761 20.7614C127.572 20.7614 126.534 21.053 125.648 21.6364C124.761 22.2197 124.072 23.0758 123.58 24.2045C123.095 25.3333 122.852 26.7197 122.852 28.3636C122.852 30.0076 123.095 31.3939 123.58 32.5227C124.072 33.6515 124.761 34.5076 125.648 35.0909C126.534 35.6742 127.572 35.9659 128.761 35.9659C129.951 35.9659 130.989 35.6742 131.875 35.0909C132.761 34.5076 133.447 33.6515 133.932 32.5227C134.424 31.3939 134.67 30.0076 134.67 28.3636ZM158.736 24.25C158.577 23.697 158.353 23.2083 158.065 22.7841C157.777 22.3523 157.425 21.9886 157.009 21.6932C156.599 21.3902 156.13 21.1591 155.599 21C155.077 20.8409 154.497 20.7614 153.861 20.7614C152.671 20.7614 151.626 21.0568 150.724 21.6477C149.83 22.2386 149.134 23.0985 148.634 24.2273C148.134 25.3485 147.884 26.7197 147.884 28.3409C147.884 29.9621 148.13 31.3409 148.622 32.4773C149.115 33.6136 149.812 34.4811 150.713 35.0795C151.615 35.6705 152.679 35.9659 153.906 35.9659C155.02 35.9659 155.971 35.7689 156.759 35.375C157.554 34.9735 158.16 34.4091 158.577 33.6818C159.001 32.9545 159.213 32.0947 159.213 31.1023L160.213 31.25H154.213V27.5455H163.952V30.4773C163.952 32.5227 163.52 34.2803 162.656 35.75C161.793 37.2121 160.603 38.3409 159.088 39.1364C157.573 39.9242 155.838 40.3182 153.884 40.3182C151.702 40.3182 149.785 39.8371 148.134 38.875C146.482 37.9053 145.194 36.5303 144.27 34.75C143.353 32.9621 142.895 30.8409 142.895 28.3864C142.895 26.5 143.168 24.8182 143.713 23.3409C144.266 21.8561 145.039 20.5985 146.031 19.5682C147.024 18.5379 148.179 17.7538 149.497 17.2159C150.815 16.678 152.243 16.4091 153.781 16.4091C155.099 16.4091 156.327 16.6023 157.463 16.9886C158.599 17.3674 159.607 17.9053 160.486 18.6023C161.372 19.2992 162.096 20.1288 162.656 21.0909C163.217 22.0455 163.577 23.0985 163.736 24.25H158.736ZM189.034 28.3636C189.034 30.9015 188.553 33.0606 187.591 34.8409C186.636 36.6212 185.333 37.9811 183.682 38.9205C182.038 39.8523 180.189 40.3182 178.136 40.3182C176.068 40.3182 174.212 39.8485 172.568 38.9091C170.924 37.9697 169.625 36.6098 168.67 34.8295C167.716 33.0492 167.239 30.8939 167.239 28.3636C167.239 25.8258 167.716 23.6667 168.67 21.8864C169.625 20.1061 170.924 18.75 172.568 17.8182C174.212 16.8788 176.068 16.4091 178.136 16.4091C180.189 16.4091 182.038 16.8788 183.682 17.8182C185.333 18.75 186.636 20.1061 187.591 21.8864C188.553 23.6667 189.034 25.8258 189.034 28.3636ZM184.045 28.3636C184.045 26.7197 183.799 25.3333 183.307 24.2045C182.822 23.0758 182.136 22.2197 181.25 21.6364C180.364 21.053 179.326 20.7614 178.136 20.7614C176.947 20.7614 175.909 21.053 175.023 21.6364C174.136 22.2197 173.447 23.0758 172.955 24.2045C172.47 25.3333 172.227 26.7197 172.227 28.3636C172.227 30.0076 172.47 31.3939 172.955 32.5227C173.447 33.6515 174.136 34.5076 175.023 35.0909C175.909 35.6742 176.947 35.9659 178.136 35.9659C179.326 35.9659 180.364 35.6742 181.25 35.0909C182.136 34.5076 182.822 33.6515 183.307 32.5227C183.799 31.3939 184.045 30.0076 184.045 28.3636Z" fill="#383A76" stroke="#ccc" stroke-width="1"/>
                        <rect x="308" y="20" width="187" height="20"   fill="<?php echo $opac_gstyle_def['COLOR_TOPBAR_TXT']; ?>" id="COLOR_TOPBAR_TXT"/>
                        <rect x="511" y="20" width="102" height="20"   fill="<?php echo $opac_gstyle_def['COLOR_TOPBAR_TXT']; ?>" id="COLOR_TOPBAR_TXT2"/>
                        <rect x="636" y="20" width="102" height="20"   fill="<?php echo $opac_gstyle_def['COLOR_TOPBAR_TXT']; ?>" id="COLOR_TOPBAR_TXT3"/>
                        <rect x="801" y="122" width="86" height="9" fill="<?php echo $opac_gstyle_def['COLOR_BUTTONS_SUBMIT_TXT']; ?>" id="COLOR_BUTTONS_SUBMIT_TXT"/>
                        <rect x="414" y="230" width="222" height="7" fill="<?php echo $opac_gstyle_def['COLOR_BUTTONS_SUBMIT_TXT']; ?>" id="COLOR_BUTTONS_SECONDARY_TXT" />
                        <rect x="136" y="230" width="222" height="7" fill="<?php echo $opac_gstyle_def['COLOR_BUTTONS_SUBMIT_TXT']; ?>" id="COLOR_BUTTONS_SECONDARY_TXT2" />
                        <rect x="693" y="230" width="222" height="7" fill="<?php echo $opac_gstyle_def['COLOR_BUTTONS_SUBMIT_TXT']; ?>" id="COLOR_BUTTONS_SECONDARY_TXT3" />
                        <rect x="801" y="318" width="126" height="19" rx="4" fill="<?php echo $opac_gstyle_def['COLOR_BUTTONS_PRIMARY_BG']; ?>" id="COLOR_BUTTONS_PRIMARY_BG"/>
                        <rect x="831" y="328" width="60" height="2" rx="4" fill="<?php echo $opac_gstyle_def['COLOR_BUTTONS_PRIMARY_TXT']; ?>" id="COLOR_BUTTONS_PRIMARY_TXT"/>
                        <rect x="1.5" y="632.5" width="1077" height="41" fill="<?php echo $opac_gstyle_def['COLOR_FOOTER_BG']; ?>" id="COLOR_FOOTER_BG" stroke="#848FF9" stroke-width="1"/>
                        <rect x="392" y="653" width="340" height="8" fill="<?php echo $opac_gstyle_def['COLOR_FOOTER_TXT']; ?>" id="COLOR_FOOTER_TXT"/>
                        <rect x="1001" y="598" width="40" height="40" rx="4" fill="<?php echo $opac_gstyle_def['COLOR_TOTOP_BG']; ?>" id="COLOR_TOTOP_BG"/>
                        <rect x="1017" y="612" width="10" height="10" rx="4" fill="<?php echo $opac_gstyle_def['COLOR_TOTOP_TXT']; ?>" id="COLOR_TOTOP_TXT"/>
                    </g>
                </svg>
                </div>
            </td>
        </tr>
        <tr>
            <td><?php echo $msgstr["cfg_color_topbar"]?></td>
            <td class="inputs">
                <input name="cfg_COLOR_TOPBAR_TXT" id="cfg_COLOR_TOPBAR_TXT" value="<?php if (isset($opac_gstyle_def['COLOR_TOPBAR_TXT'])) echo $opac_gstyle_def['COLOR_TOPBAR_TXT']; ?>"   data-jscolor="{}" onInput="update(this.jscolor, '#COLOR_TOPBAR_TXT');update(this.jscolor, '#COLOR_TOPBAR_TXT2');update(this.jscolor, '#COLOR_TOPBAR_TXT3')" >
                <button type="button" onclick="return resetColor('#000000', 'COLOR_TOPBAR_TXT')">
                    <i class="fas fa-eraser"></i>
                </button>
            </td>
        </tr>
        <tr>
            <td><?php echo $msgstr["cfg_color_links"]?></td>
            <td class="inputs">
                <input name="cfg_COLOR_LINKS" id="cfg_COLOR_LINKS" value="<?php if (isset($opac_gstyle_def['COLOR_LINKS'])) echo $opac_gstyle_def['COLOR_LINKS']; ?>"  data-jscolor="{}" onInput="update(this.jscolor, '#COLOR_LINKS'),update(this.jscolor, '#COLOR_LINKS2'),update(this.jscolor, '#COLOR_LINKS3')">
                <button type="button"onclick="return resetColor('#000000', 'COLOR_LINKS')" >
                    <i class="fas fa-eraser"></i>
                </button>
            </td>
        </tr>
        <tr>
            <td><?php echo $msgstr["cfg_color_text"]?></td>
            <td class="inputs">
                <input name="cfg_COLOR_TEXT" id="cfg_COLOR_TEXT" value="<?php if (isset($opac_gstyle_def['COLOR_TEXT'])) echo $opac_gstyle_def['COLOR_TEXT']; ?>"  data-jscolor="{}" onInput="update(this.jscolor, '#COLOR_TEXT');update(this.jscolor, '#COLOR_TEXT2');update(this.jscolor, '#COLOR_TEXT3')">
                <button type="button" onclick="return resetColor('#4D4D4DFF', 'COLOR_TEXT')" >
                    <i class="fas fa-eraser"></i>
                </button>
            </td>
        </tr>
        <tr>
            <td><?php echo $msgstr["cfg_color_bg"]?></td>
            <td class="inputs">
                <input name="cfg_COLOR_BG" id="cfg_COLOR_BG" value="<?php if (isset($opac_gstyle_def['COLOR_BG'])) echo $opac_gstyle_def['COLOR_BG']; else echo "#fcfcfd" ?>"  data-jscolor="{}" onInput="update(this.jscolor, '#COLOR_BG')">
                <button type="button"  onclick="return resetColor('#f8f9fa', 'COLOR_BG')" >
                    <i class="fas fa-eraser"></i>
                </button>
            </td>
        </tr>
        <tr>
            <td><?php echo $msgstr["cfg_bgcolor_search"]?></td>
            <td class="inputs">
                <input name="cfg_COLOR_SEARCHBOX_BG" id="cfg_COLOR_SEARCHBOX_BG" value="<?php if (isset($opac_gstyle_def['COLOR_SEARCHBOX_BG'])) echo $opac_gstyle_def['COLOR_SEARCHBOX_BG']; ?>"  data-jscolor="{}" onInput="update(this.jscolor, '#COLOR_SEARCHBOX_BG')">
                <button type="button" onclick="return resetColor('#FFFFFFFF', 'COLOR_SEARCHBOX_BG')" >
                    <i class="fas fa-eraser"></i>
                </button>
            </td>
        </tr>
        <tr>
            <td><?php echo $msgstr["cfg_submit_button_bg"]?></td>
            <td class="inputs">
                <input name="cfg_COLOR_BUTTONS_SUBMIT_BG" id="cfg_COLOR_BUTTONS_SUBMIT_BG" value="<?php if (isset($opac_gstyle_def['COLOR_BUTTONS_SUBMIT_BG'])) echo $opac_gstyle_def['COLOR_BUTTONS_SUBMIT_BG']; else echo "#198754";?>"  data-jscolor="{}" onInput="update(this.jscolor, '#COLOR_BUTTONS_SUBMIT_BG')">
                <button type="button" onclick="return resetColor('#198754', 'COLOR_BUTTONS_SUBMIT_BG')" >
                    <i class="fas fa-eraser"></i>
                </button>
            </td>
        </tr>
        <tr>
            <td><?php echo $msgstr["cfg_submit_button_text"]?></td>
            <td class="inputs">
                <input name="cfg_COLOR_BUTTONS_SUBMIT_TXT" id="cfg_COLOR_BUTTONS_SUBMIT_TXT" value="<?php if (isset($opac_gstyle_def['COLOR_BUTTONS_SUBMIT_TXT'])) echo $opac_gstyle_def['COLOR_BUTTONS_SUBMIT_TXT']; else echo "#ffffff"?>"  data-jscolor="{}" onInput="update(this.jscolor, '#COLOR_BUTTONS_SUBMIT_TXT')">
                <button type="button" onclick="return resetColor('#FFFFFFFF', 'COLOR_BUTTONS_SUBMIT_TXT')" >
                    <i class="fas fa-eraser"></i>
                </button>
            </td>
        </tr>
        <tr>
            <td><?php echo $msgstr["cfg_light_button_bg"]?></td>
            <td class="inputs">
                <input name="cfg_COLOR_BUTTONS_LIGHT_BG" id="cfg_COLOR_BUTTONS_LIGHT_BG" value="<?php if (isset($opac_gstyle_def['COLOR_BUTTONS_LIGHT_BG'])) echo $opac_gstyle_def['COLOR_BUTTONS_LIGHT_BG']; else echo "#f8f9fa"; ?>"  data-jscolor="{}" onInput="update(this.jscolor, '#COLOR_BUTTONS_LIGHT_BG')">
                <button type="button" onclick="return  resetColor('#F8F9FA', 'COLOR_BUTTONS_LIGHT_BG')" >
                    <i class="fas fa-eraser"></i>
                </button>
            </td>
        </tr>
        <tr>
            <td><?php echo $msgstr["cfg_light_button_text"]?></td>
            <td class="inputs">
                <input name="cfg_COLOR_BUTTONS_LIGHT_TXT" id="cfg_COLOR_BUTTONS_LIGHT_TXT" value="<?php if (isset($opac_gstyle_def['COLOR_BUTTONS_LIGHT_TXT'])) echo $opac_gstyle_def['COLOR_BUTTONS_LIGHT_TXT']; else echo "#000000";?>"  data-jscolor="{}" onInput="update(this.jscolor, '#COLOR_BUTTONS_LIGHT_TXT')">
                <button type="button" onclick="return  resetColor('#000000', 'COLOR_BUTTONS_LIGHT_TXT')" >
                    <i class="fas fa-eraser"></i>
                </button>
            </td>
        </tr>
        <tr>
            <td><?php echo $msgstr["cfg_primary_button_bg"]?></td>
            <td class="inputs">
                <input name="cfg_COLOR_BUTTONS_PRIMARY_BG" id="cfg_COLOR_BUTTONS_PRIMARY_BG" value="<?php if (isset($opac_gstyle_def['COLOR_BUTTONS_PRIMARY_BG'])) echo $opac_gstyle_def['COLOR_BUTTONS_PRIMARY_BG']; else echo "#0d6efd";?>"  data-jscolor="{}" onInput="update(this.jscolor, '#COLOR_BUTTONS_PRIMARY_BG')">
                <button type="button" onclick="return  resetColor('#0d6efd', 'COLOR_BUTTONS_PRIMARY_BG')" >
                    <i class="fas fa-eraser"></i>
                </button>
            </td>
        </tr>
        <tr>
            <td><?php echo $msgstr["cfg_primary_button_text"]?></td>
            <td class="inputs">
                <input name="cfg_COLOR_BUTTONS_PRIMARY_TXT" id="cfg_COLOR_BUTTONS_PRIMARY_TXT" value="<?php if (isset($opac_gstyle_def['COLOR_BUTTONS_PRIMARY_TXT'])) echo $opac_gstyle_def['COLOR_BUTTONS_PRIMARY_TXT']; else echo "#ffffff";?>"  data-jscolor="{}" onInput="update(this.jscolor, '#COLOR_BUTTONS_PRIMARY_TXT')">
                <button type="button"   onclick="return  resetColor('#FFFFFFFF', 'COLOR_BUTTONS_PRIMARY_TXT')">
                    <i class="fas fa-eraser"></i>
                </button>
            </td>
        </tr>
        <tr>
            <td><?php echo $msgstr["cfg_secondary_button_bg"]?></td>
            <td class="inputs">
                <input name="cfg_COLOR_BUTTONS_SECONDARY_BG" id="cfg_COLOR_BUTTONS_SECONDARY_BG" value="<?php if (isset($opac_gstyle_def['COLOR_BUTTONS_SECONDARY_BG'])) echo $opac_gstyle_def['COLOR_BUTTONS_SECONDARY_BG']; else echo "#6c757d";?>"  data-jscolor="{}" onInput="update(this.jscolor, '#COLOR_BUTTONS_SECONDARY_BG'),update(this.jscolor, '#COLOR_BUTTONS_SECONDARY_BG2'),update(this.jscolor, '#COLOR_BUTTONS_SECONDARY_BG3'),update(this.jscolor, '#COLOR_BUTTONS_SECONDARY_BG4')">
                <button type="button" onclick="return  resetColor('#6c757d', 'COLOR_BUTTONS_SECONDARY_BG')" >
                    <i class="fas fa-eraser"></i>
                </button>
            </td>
        </tr>
        <tr>
            <td><?php echo $msgstr["cfg_secondary_button_text"]?></td>
            <td class="inputs">
                <input name="cfg_COLOR_BUTTONS_SECONDARY_TXT" id="cfg_COLOR_BUTTONS_SECONDARY_TXT" value="<?php if (isset($opac_gstyle_def['COLOR_BUTTONS_SECONDARY_TXT'])) echo $opac_gstyle_def['COLOR_BUTTONS_SECONDARY_TXT'];  else echo "#ffffff";?>"  data-jscolor="{}" onInput="update(this.jscolor, '#COLOR_BUTTONS_SECONDARY_TXT');update(this.jscolor, '#COLOR_BUTTONS_SECONDARY_TXT2');update(this.jscolor, '#COLOR_BUTTONS_SECONDARY_TXT3')">
                <button type="button" onclick="return  resetColor('#FFFFFFFF', 'COLOR_BUTTONS_SECONDARY_TXT')" >
                    <i class="fas fa-eraser"></i>
                </button>
            </td>
        </tr>
        <tr>
            <td><?php echo $msgstr["cfg_results_bg"]?></td>
            <td class="inputs">
                <input name="cfg_COLOR_RESULTS_BG" id="cfg_COLOR_RESULTS_BG" value="<?php if (isset($opac_gstyle_def['COLOR_RESULTS_BG'])) echo $opac_gstyle_def['COLOR_RESULTS_BG']; ?>"  data-jscolor="{}"  onInput="update(this.jscolor, '#COLOR_RESULTS_BG');update(this.jscolor, '#COLOR_RESULTS_BG2')">
                <button type="button"  onclick="return  resetColor('#FFFFFFFF', 'COLOR_RESULTS_BG')">
                    <i class="fas fa-eraser"></i>
                </button>
            </td>
        </tr>
        <tr>
            <td>To Top - Background</td>
            <td class="inputs">
                <input name="cfg_COLOR_TOTOP_BG" id="cfg_COLOR_TOTOP_BG" value="<?php if (isset($opac_gstyle_def['COLOR_TOTOP_BG'])) echo $opac_gstyle_def['COLOR_TOTOP_BG']; else echo "#0d6efd";?>"  data-jscolor="{}" onInput="update(this.jscolor, '#COLOR_TOTOP_BG')">
                <button type="button"  onclick="return  resetColor('#0d6efd', 'COLOR_TOTOP_BG')">
                    <i class="fas fa-eraser"></i>
                </button>
            </td>
        </tr>
        <tr>
            <td>To Top - Icon</td>
            <td class="inputs">
                <input name="cfg_COLOR_TOTOP_TXT" id="cfg_COLOR_TOTOP_TXT" value="<?php if (isset($opac_gstyle_def['COLOR_TOTOP_TXT'])) echo $opac_gstyle_def['COLOR_TOTOP_TXT']; else echo "#0d6efd";?>"  data-jscolor="{}" onInput="update(this.jscolor, '#COLOR_TOTOP_TXT')">
                <button type="button"  onclick="return  resetColor('#FFFFFFFF', 'COLOR_TOTOP_TXT')">
                    <i class="fas fa-eraser"></i>
                </button>
            </td>
        </tr>
        <tr>
            <td>Footer - Background</td>
            <td class="inputs">
                <input name="cfg_COLOR_FOOTER_BG" id="cfg_COLOR_FOOTER_BG" value="<?php if (isset($opac_gstyle_def['COLOR_FOOTER_BG'])) echo $opac_gstyle_def['COLOR_FOOTER_BG']; ?>"  data-jscolor="{}" onInput="update(this.jscolor, '#COLOR_FOOTER_BG')">
                <button type="button"  onclick="return  resetColor('#ffffff', 'COLOR_FOOTER_BG')">
                    <i class="fas fa-eraser"></i>
                </button>
            </td>
        </tr>
        <tr>
            <td>Tooter - Text</td>
            <td class="inputs">
                <input name="cfg_COLOR_FOOTER_TXT" id="cfg_COLOR_FOOTER_TXT" value="<?php if (isset($opac_gstyle_def['COLOR_FOOTER_TXT'])) echo $opac_gstyle_def['COLOR_FOOTER_TXT']; ?>"  data-jscolor="{}" onInput="update(this.jscolor, '#COLOR_FOOTER_TXT')">
                <button type="button"  onclick="return  resetColor('#000000', 'COLOR_FOOTER_TXT')">
                    <i class="fas fa-eraser"></i>
                </button>
            </td>
        </tr>


    </table>
    <hr>
	<h3 id="layout">Layout</h3>

	<table class="table striped W-10">
    	<tr>
    		<th valign=top><?php echo $msgstr["cfg_TOPBAR"];?></th>
    		<td valign=top>
    			<?php if (!isset($topbar)) $topbar="default";?>
    			<label><input type="radio" name="cfg_TOPBAR" value="default" <?php if (isset($topbar) and $topbar=="default") echo " checked"?>> Default&nbsp; &nbsp;</label>
    			<label><input type="radio" name="cfg_TOPBAR" value="sticky-top"  <?php if (isset($topbar) and $topbar=="sticky-top") echo " checked"?>> Fixed</label>
			</td>
    	</tr>		
		<tr>
			<th  valign="top"><?php echo $msgstr["cfg_CONTAINER"];?></th>
			<td valign="top">
			    <?php if (!isset($container) ) $container="";?>
    			
				<label class="config"><input type="radio" name="cfg_CONTAINER" value="-fluid" <?php if (isset($container) and $container=="-fluid") echo " checked"?>>  Fluid <img width="320px" src="/assets/images/opac/layout-container-fluid.png"></label>
				
				<br><br><br>
    			
				<label class="config"><input type="radio" name="cfg_CONTAINER" value="<?php if (isset($container) and $container=="") echo " checked"?>"> Default  <img width="320px" src="/assets/images/opac/layout-container.png"> </label>
			</td>
		</tr>

		<tr>
			<th valign="top"><?php echo $msgstr["cfg_SIDEBAR"];?></th>
			<td valign="top">
			    <?php if (!isset($sidebar) ) $sidebar="Y";?>
    		
				<label class="config"><input type="radio" name="cfg_SIDEBAR" value="Y" <?php if (isset($sidebar) and $sidebar=="Y") echo " checked"?>> Show sidebar <img width="320px" src="/assets/images/opac/layout-sidebar.png"></label>

				<br><br><br>
    			
				<label class="config"><input type="radio" name="cfg_SIDEBAR" value="N"  <?php if (isset($sidebar) and $sidebar=="N") echo " checked"?>> Hide Sidebar <img width="320px" src="/assets/images/opac/layout-nosidebar.png"></label>

				<br><br><br>

				<label class="config"><input type="radio" name="cfg_SIDEBAR" value="SL"  <?php if (isset($sidebar) and $sidebar=="SL") echo " checked"?>> Display wide search box with sidebar <img width="320px" src="/assets/images/opac/layout-search-large.png"></label>
			</td>
		</tr>
		<tr>
			<th  valign="top"><?php echo $msgstr["cfg_NUM_PAGES"];?></th>
			<td valign="top"><input type="number" name="cfg_NUM_PAGES"  min="1" max="30" value="<?php echo $npages;?>">
        </td>
		</tr>


	</table>
	<hr> 

	



<input type="submit" class="bt-green mt-5" value="<?php echo $msgstr["save"];?>">
</form>
</div>
</div>


<script>
    // Here we can adjust defaults for all color pickers on page:
    jscolor.presets.default = {
        format:'hexa', 
        borderRadius:0,
        position: 'left',
        palette: [
            '#000000', '#3498DB', '#9B59B6', '#27AE60', '#F39C12', '#E74C3C', '#2C3E50', '#7F8C8D', '#E67E22', '#16A085',
            '#ffffff', '#34495E', '#D35400', '#feaec9', '#ffc80d', '#eee3af', '#b5e61d', '#99d9ea', '#7092be', '#c8bfe7',
        ],
    };

    function update(picker, selector) {
        document.querySelector(selector).style.fill = picker.toRGBAString();
    };

    function resetColor(defaultColor, id) {
    const svgFill = '#' + id;
    const inputValue = '#cfg_' + id;
    const elements = document.querySelectorAll('rect[id^="'+id+'"]');
    
    elements.forEach(element => {
        if (element.id !== id) {
        document.querySelector('#' + element.id).style.fill = defaultColor;
        }
    });

    document.querySelector(svgFill).style.fill = defaultColor;
    document.querySelector(inputValue).jscolor.fromString(defaultColor);
    };

    window.addEventListener('scroll', function() {
    var stickyElement = document.querySelector('.sticky-element');
    var targetElement = document.getElementById('target-element');
    var stopElement = document.getElementById('layout');
    var targetElementPosition = targetElement.getBoundingClientRect().top;
    var resetElementPosition = stopElement.getBoundingClientRect().top;

    if (targetElementPosition <= 0) {
        stickyElement.classList.add('fixed');
    } else {
        stickyElement.classList.remove('fixed');
    }

    if (resetElementPosition <= 300) {
        stickyElement.classList.remove('fixed');
    }
    });

</script>

<?php include ("../../common/footer.php"); ?>