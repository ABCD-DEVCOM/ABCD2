<?php

function parseMarkdown($markdownFile) {
    global $lang;
    $markdown = file_get_contents($markdownFile);
    
    // Converter Markdown para HTML
    // Implemente sua própria função de conversão Markdown para HTML aqui
    // ou use uma biblioteca externa, como Parsedown ou PHP Markdown Extra
    
    // Exemplo simples de conversão Markdown para HTML usando regex

    $html = preg_replace('/### (.+)/', '<h3>$1</h3>', $markdown);
    $html = preg_replace('/## (.+)/', '<h2>$1</h2>', $html);
    $html = preg_replace('/# (.+)/', '<h1>$1</h1>', $html);
    $html = preg_replace('/     (.+)/', '<code>$1</code>', $html);
    $html = preg_replace('/\*   (.+)/', '<li>$1', $html);
    $html = preg_replace('/\*\*(.+?)\*\*/', '<strong>$1</strong>', $html);
    $html = preg_replace('/\*(.+?)\*/', '<em>$1</em>', $html);
    $html = preg_replace('/\`(.+?)\`/', '<code>$1</code>', $html);
    $html = preg_replace('/----/', '<hr>$1', $html);
    $html = nl2br($html);

    $output=mb_detect_encoding($html);

    return  mb_convert_encoding($html,"UTF-8", $output);
}

$markdownFileLang = 'README_'.$lang.'.md';


if (file_exists($markdownFileLang)) {
    $markdownFile=$markdownFileLang;
} else {
     $markdownFile="README.md";
}
    $html = parseMarkdown($markdownFile);

   
?>

<style>
    h1 {
    font-size: 2em;
    margin: 0;
}
</style>

    <div id="preview"><?php echo $html; ?></div>
