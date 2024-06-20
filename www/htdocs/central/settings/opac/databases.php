<?php
/***
 * 20230305 rogercgui Adds the variable $actparfolder;
 * 
 */


include("conf_opac_top.php");
$wiki_help="OPAC-ABCD_configuraci%C3%B3n#Bases_de_datos_disponibles";
include "../../common/inc_div-helper.php";

//foreach ($_REQUEST as $var=>$value) echo "$var=>$value<br>";  die;
?>

<script>
var idPage="db_configuration";
</script>

<div class="middle form row m-0">
	<div class="formContent col-2 m-2">
		<?php include("conf_opac_menu.php");?>
	</div>
	<div class="formContent col-9 m-2">


	<h3><?php echo $msgstr["databases"]?></h3>


<?php
// Função para verificar se um valor está presente em dbopac.dat
function isInDbopac($valor, $dbopacData) {
    foreach ($dbopacData as $dbopacLinha) {
        list($dbopacValor) = explode('|', $dbopacLinha);
        if ($valor === $dbopacValor) {
            return true;
        }
    }
    return false;
}

// Ler o conteúdo de bases.dat e dbopac.dat
$file_conf_opac = $db_path.'opac_conf/'.$lang.'/bases.dat';

$masterData = file($db_path.'bases.dat', FILE_IGNORE_NEW_LINES);
$dbopacData = file($file_conf_opac, FILE_IGNORE_NEW_LINES);


// Processar o envio do formulário
if (isset($_POST['submit'])) {
    // Inicializar um array para armazenar os dados atualizados de dbopac.dat
    $updatedDbopacData = array();

    foreach ($masterData as $linha) {
        list($valor, $HumanNameDb) = explode('|', $linha);

        // Verificar se o checkbox foi marcado
        $checkboxName = 'checkbox_' . $valor;
        $checkboxChecked = isset($_POST[$checkboxName]) ? 'checked' : '';

        // Obter o valor do campo de texto
        $textInputName = 'text_' . $valor;
        $textInputValue = $_POST[$textInputName] ?? '';

        // Obter o valor do campo de texto para a descrição completa
        $textInputDescName = 'text_desc_' . $valor;
        $textInputDescValue = $_POST[$textInputDescName] ?? '';

        // Se o checkbox estiver marcado, adicione a linha ao array atualizado de dbopac.dat
        if ($checkboxChecked) {
            $updatedDbopacData[] = "$valor|$textInputValue";

        // Salvar a descrição completa em um arquivo de texto
        $defFile = $db_path . $valor . '/opac/' . $lang . '/' . $valor . '.def';

        // Verifica se o arquivo já existe
        if (!file_exists($defFile)) {
            // Se o arquivo não existe, cria o diretório se não existir
            $directory = dirname($defFile);
            if (!is_dir($directory)) {
                mkdir($directory, 0777, true);
            }
            
            // Cria o arquivo
            file_put_contents($defFile, '');
        }

    // Agora que sabemos que o arquivo existe (ou foi criado), podemos escrever nele
    file_put_contents($defFile, $textInputDescValue);


        } elseif (!$checkboxChecked && isInDbopac($valor, $dbopacData)) {
            // Se o checkbox estiver desmarcado e o valor existir em dbopac.dat, não inclua no array
            continue;
        }
    }

// Agora, vamos lidar com os campos langdb_
$uniqueLangValues = array();
$uniqueSuffixes = array();
foreach ($_POST as $postField => $postValue) {
    if (strpos($postField, 'langdb_') === 0) {
        // Extrair os valores dinâmicos do campo langdb_
        $parts = explode('_', $postField);
        if (count($parts) === 3) {
            $langValue = $postValue;
            $prefix = $parts[1];
            $suffix = $parts[2];
            $alphaInputDb = 'langdb_' . $prefix . '_' . $suffix;

            // Verificar se o checkbox foi marcado para este campo langdb_
            if (isset($_POST[$alphaInputDb])) {
                // Adicionar o valor ao array correspondente ao sufixo
                $uniqueLangValues[$suffix][] = $langValue;
                // Armazenar o sufixo para evitar duplicatas
                $uniqueSuffixes[] = $suffix;
            }
        }
    }
}

// Eliminar duplicatas e salvar nos arquivos correspondentes
$uniqueSuffixes = array_unique($uniqueSuffixes);
foreach ($uniqueSuffixes as $suffix) {
    $uniqueLangValues[$suffix] = array_unique($uniqueLangValues[$suffix]);
    $file_db_alpha_opac = $db_path . $suffix . '/opac/' . $lang . '/' . $suffix . '.lang';
    file_put_contents($file_db_alpha_opac, implode(PHP_EOL, $uniqueLangValues[$suffix]));
    //echo "<h3>" . $lang . "/$suffix.lang" . " " . $msgstr["updated"] . "</h3><br>";
}


    // Gravar os dados atualizados no arquivo dbopac.dat
    file_put_contents($file_conf_opac, implode(PHP_EOL, $updatedDbopacData));


    echo '<div class="alert success">'.$msgstr["updated"].'<pre>'.$file_conf_opac.'</pre></div>';

    // Recarregar os dados de dbopac.dat após a atualização
    $dbopacData = file($file_conf_opac, FILE_IGNORE_NEW_LINES);
}

$alpha=array();
if (is_dir($db_path."opac_conf/alpha/".$charset)){
	$handle=opendir($db_path."opac_conf/alpha/".$charset);
	while (false !== ($entry = readdir($handle))) {
		if (!is_file($db_path."opac_conf/alpha/$charset/$entry")) continue;
		$alpha[$entry]=$entry;
	}
}

// Exibir o formulário
?>

    <form method="POST">
        <?php foreach ($masterData as $linha) {
            list($valor, $HumanNameDb) = explode('|', $linha);


	if ((substr($HumanNameDb,0,3)!="Acq") AND (substr($HumanNameDb,0,4)!="Circ") AND (substr($HumanNameDb,0,3)!="Sys") ) {

            echo '<h3><input class="m-1 p-2" type="checkbox" name="checkbox_' . $valor . '" value="' . $valor . '" ';


            // Verificar se o valor existe em dbopac.dat e marcar o checkbox
            foreach ($dbopacData as $dbopacLinha) {
                list($dbopacValor) = explode('|', $dbopacLinha);
                if ($valor === $dbopacValor) {
                    echo 'checked';
                    break;
                }
            }

            echo '>';
            echo '<label class="w-3 p-2" >' . $HumanNameDb . '</label></h3>';
?>
    <div class="w-10" style="display: flex;" >
        <div class="w-4 p-3">

<?php
            echo "<label title=".$file_conf_opac.">".$msgstr["db_name"]."</label>";
            echo '<input class="w-10"  type="text" name="text_' . $valor . '" value="';

            // Preencher o campo de texto com o valor correspondente em dbopac.dat
            foreach ($dbopacData as $dbopacLinha) {
                list($dbopacValor, $dbopacHumanName) = explode('|', $dbopacLinha);
                if ($valor === $dbopacValor) {
                    echo $dbopacHumanName;
                    break;
                }
            }

            echo '">';
?>
        </div>

        <div class="w-4 p-3">


<?php

            // Verificar se o arquivo .def existe e preencher o campo de texto com o seu conteúdo
            $defFile = $db_path.$valor.'/opac/' . $lang . '/'.$valor . '.def';
       


            echo "<label title=".$defFile.">".$msgstr["db_desc"]."</label>";
            echo '<input class="w-10"  type="text" name="text_desc_' . $valor . '" value="';

            // Preencher o campo de texto com a descrição completa do banco de dados
            $textInputDescName = 'text_desc_' . $valor;
            $textInputDescValue = $_POST[$textInputDescName] ?? '';

            echo htmlspecialchars($textInputDescValue) . '">';

        if (file_exists($defFile)) {
            $defContents = file_get_contents($defFile);
            echo '<script>document.getElementsByName("text_desc_' . $valor . '")[0].value = ' . json_encode($defContents) . ';</script>';
        }

			$ix_lang=0;
			$langdb=array();
			if (file_exists($db_path.$valor.'/opac/'.$lang.'/'.$valor.'.lang')){
				$fp_lang=file($db_path.$valor.'/opac/'.$lang.'/'.$valor.'.lang');
				foreach ($fp_lang as $value_lang){
					if (trim($value_lang)!=""){
						$fll=explode('|',$value_lang);
						foreach ($fll as $xfll){
							$xfll=trim($xfll);
							$langdb[$xfll]=$xfll;
						}
					}
				}

			}
?>
        </div>
    </div>

<?php

            echo "<label>".$msgstr["avail_db_lang"]." ".$valor.'</label><br>';
			foreach ($alpha as $value){
				$ix_lang=$ix_lang+1;
				$ix_00=strrpos($value,".");
				$value=substr($value,0,$ix_00);
				echo '<input class="m-2" type="checkbox" name="langdb_'.$value.'_'.$valor.'" value="'.$value.'"';
				if (isset($langdb[$value])) echo " checked";
				echo ">". $value;
				if ($ix_lang>3){
					$ix_lang=0;
				}
			}

			echo '<br><br><hr>';
        } 
	}
?>
        <input class="bt bt-green" type="submit" name="submit" value="Salvar">
    </form>