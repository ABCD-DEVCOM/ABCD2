<?php

if ( !isset($lang) )
{
	$lang = "pt";
}

if ( $lang == "es" )
{
	$msg["lang1"] = "pt";
	$msg["lang1.show"] = "português";
	$msg["lang2"] = "en";
	$msg["lang2.show"] = "english";
	$msg["captionFormXML"] = "";
	$msg["captionFormXML"] = "update-x para ficheros XML";
	$msg["examples"] = "ejemplos: ";
	$msg["enter"] = "entrar";
	$msg["captionFormXISIS"] = "update-x para bases de datos X-ISIS";
	$msg["captionFormSchemaToStruct"] = "generación del XML parámetro del update-x equivalente al schema de entrada de datos";
	$msg["generate"] = "generar";
}

if ( $lang == "pt" )
{
	$msg["lang1"] = "es";
	$msg["lang1.show"] = "español";
	$msg["lang2"] = "en";
	$msg["lang2.show"] = "english";
	$msg["captionFormXML"] = "update-x para arquivo XML";
	$msg["examples"] = "exemplos: ";
	$msg["enter"] = "entrar";
	$msg["captionFormXISIS"] = "update-x para base de dados X-ISIS";
	$msg["captionFormSchemaToStruct"] = "geração do XML parâmetro do update-x equivalente ao schema de entrada de dados";
	$msg["generate"] = "gerar";
}

if ( $lang == "en" )
{
	$msg["lang1"] = "es";
	$msg["lang1.show"] = "español";
	$msg["lang2"] = "pt";
	$msg["lang2.show"] = "português";
	$msg["captionFormXML"] = "update-x for XML file";
	$msg["examples"] = "examples: ";
	$msg["enter"] = "enter";
	$msg["captionFormXISIS"] = "update-x for X-ISIS database";
	$msg["captionFormSchemaToStruct"] = "generate the update-x XML parameter equivalent to the data entry schema";
	$msg["generate"] = "generate";
}

if ( $lang == "fr" )
{
	$msg["lang1"] = "pt";
	$msg["lang1.show"] = "português";
	$msg["lang2"] = "en";
	$msg["lang2.show"] = "english";
	$msg["captionFormXML"] = "";
	$msg["captionFormXML"] = "update-x para ficheros XML";
	$msg["examples"] = "ejemplos: ";
	$msg["enter"] = "entrar";
	$msg["captionFormXISIS"] = "update-x para bases de datos X-ISIS";
	$msg["captionFormSchemaToStruct"] = "generación del XML parámetro del update-x equivalente al schema de entrada de datos";
	$msg["generate"] = "generar";
}

?>

<html>
<head>
	<title>update-x</title>
	<link rel="stylesheet" href="index.css" type="text/css">
</head>

<body>

<dl>
	<dd>
		<span class="language">
			<a href="index.php?lang=<?php print($msg["lang1"]); ?>"><?php print($msg["lang1.show"]); ?></a>
			<a href="index.php?lang=<?php print($msg["lang2"]); ?>"><?php print($msg["lang2.show"]); ?></a>
		</span>
		<span class="pageTitle">
			update-x
		</span>
	</dd>
	<dd>
		<dl>
			<dd>
				<form name="formXML" action="php/show.php" method="get">
					<span class="captionFormXML">
						<?php print($msg["captionFormXML"]); ?>
					</span>
					<table class="formBox" cellpadding="3" cellspacing="0">
						<tr>
							<td align="right">ini:</td>
							<td><input type="text" name="ini" size="60" maxlength="300"></td>
						</tr>
						<tr>
							<td align="right">edit:</td>
							<td><input type="text" name="edit" size="60" maxlength="300"></td>
						</tr>
						<tr>
							<td align="right">lang:</td>
							<td><input type="text" name="lang" size="5" maxlength="300" value="<?php print($lang); ?>"></td>
						</tr>
						<tr>
							<td align="right">user:</td>
							<td><input type="text" name="user" size="15" maxlength="300"></td>
						</tr>
						<tr>
							<td align="right"></td>
							<td><input type="submit" name="submitXML" value="<?php print($msg["enter"]); ?>"></td>
						</tr>
					</table>	
					<table>
						<tr>
							<td align="right"><?php print($msg["examples"]); ?></td>
							<td>
								<a href="php/show.php?ini=../test/test.ini&lang=<?php print($lang); ?>">test</a>
								<a href="php/show.php?ini=../test/test1/test.ini&lang=<?php print($lang); ?>">test1</a>
								<a href="php/show.php?ini=../test/test4/test.ini&lang=<?php print($lang); ?>&user=test4">test4</a>
								<a href="php/show.php?ini=../test/test6/test.ini&lang=<?php print($lang); ?>&user=test6">test6</a>
							</td>
						</tr>
					</table>	
				</form>
			</dd>
			<dd>
				<form name="formXISIS" action="php/documents.php" method="get">
					<span class="captionFormXISIS">
						<?php print($msg["captionFormXISIS"]); ?>
					</span>
					<table class="formBox" cellpadding="3" cellspacing="0">
						<tr>
							<td align="right">ini:</td>
							<td><input type="text" name="ini" size="60" maxlength="300"></td>
						</tr>
						<tr>
							<td align="right">database:</td>
							<td><input type="text" name="database" size="60" maxlength="300"></td>
						</tr>
						<tr>
							<td align="right">restriction:</td>
							<td><input type="text" name="restriction" size="30" maxlength="300"></td>
						</tr>
						<tr>
							<td align="right">lang:</td>
							<td><input type="text" name="lang" size="5" maxlength="300" value="<?php print($lang); ?>"></td>
						</tr>
						<tr>
							<td align="right">user:</td>
							<td><input type="text" name="user" size="15" maxlength="300"></td>
						</tr>
						<tr>
							<td align="right"></td>
							<td><input type="submit" name="submitXISIS" value="<?php print($msg["enter"]); ?>"></td>
						</tr>
					</table>	
					<table>
						<tr>
							<td align="right"><?php print($msg["examples"]); ?></td>
							<td>
								<a href="php/documents.php?ini=../test/test2/test.ini&lang=<?php print($lang); ?>&user=test2">test2</a>
								<a href="php/documents.php?ini=../test/test3/test.ini&lang=<?php print($lang); ?>&user=test3">test3</a>
								<a href="php/documents.php?ini=../test/test5/test.ini&lang=<?php print($lang); ?>&user=test5">test5</a>
								<a href="php/documents.php?ini=../test/test7/test.ini&lang=<?php print($lang); ?>&user=test7">test7</a>
							</td>
						</tr>
					</table>
				</form>
			</dd>
			<dd>
				<form action="php/schema-to-struct.php" method="post" name="formSchemaToStruct">
					<input type="hidden" name="ini" value="../test/test.ini"/>
					<span class="captionFormSchemaToStruct">
						<?php print($msg["captionFormSchemaToStruct"]); ?>
					</span>
					<table class="formBox" cellpadding="3" cellspacing="0">
						<tr>
							<td align="right">schema:</td>
							<td><input type="text" name="schema" size="60" maxlength="300"/></td>
						</tr>
						<tr>
							<td align="right"></td>
							<td><input type="submit" name="submitSchemaToStruct" value="<?php print($msg["generate"]); ?>"/></td>
						</tr>
					</table>
				</form>
			</dd>
		</dl>
	</dd>
</dl>
</body>
</html>
