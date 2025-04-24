<?php

function removeacentos($trocaracentos)
{
$ACENTOS = array("À", "Á", "Â", "Ã", "à", "á", "â", "ã");
$SEMACENTOS = array("A", "A", "A", "A", "A", "A", "A", "A");
$trocaracentos = str_replace($ACENTOS, $SEMACENTOS, $trocaracentos);

$ACENTOS = array("È", "É", "Ê", "Ë", "è", "é", "ê", "ë");
$SEMACENTOS = array("E", "E", "E", "E", "E", "E", "E", "E");
$trocaracentos = str_replace($ACENTOS, $SEMACENTOS, $trocaracentos);

$ACENTOS = array("Ì", "Í", "Î", "Ï", "ì", "í", "î", "ï");
$SEMACENTOS = array("I", "I", "I", "I", "I", "I", "I", "I");
$trocaracentos = str_replace($ACENTOS, $SEMACENTOS, $trocaracentos);

$ACENTOS = array("Ò", "Ó", "Ô", "Ö", "Õ", "ò", "ó", "ô", "ö", "õ");
$SEMACENTOS = array("O", "O", "O", "O", "O", "O", "O", "O", "O", "O");
$trocaracentos = str_replace($ACENTOS, $SEMACENTOS, $trocaracentos);

$ACENTOS = array("Ù", "Ú", "Û", "Ü", "ú", "ù", "ü", "û");
$SEMACENTOS = array("U", "U", "U", "U", "U", "U", "U", "U");
$trocaracentos = str_replace($ACENTOS, $SEMACENTOS, $trocaracentos);

$ACENTOS = array("Ç", "ç", "ª", "º", "°", "'", "&", "@");
$SEMACENTOS = array("C", "C", "A.", "O.", "O.", " ", "E", "A");
$trocaracentos = str_replace($ACENTOS, $SEMACENTOS, $trocaracentos);

// Habilitar para deixar tudo maiúsculo
//$MINUSCULAS = array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","x","z","w","y");
//$MAIUSCULAS = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","X","Z","W","Y");
//$trocaracentos = str_replace($MINUSCULAS,$MAIUSCULAS, $trocaracentos);

return $trocaracentos;
}