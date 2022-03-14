# Descrição do OPAC

Caracteristicas

O ABCD Opac permite até 3 níveis de pesquisa:

* Metabusca
* Pesquisar em um banco de dados específico
* Pesquisa em um subconjunto de registros em um banco de dados (tipo de material ou outra classificação definida por um prefixo do FST)


## Metabusca

	Nota: utilize o prefixo TW_ na indexação da base de dados.

Aplica a expressão de pesquisa em todos os bancos de dados definidos no arquivo bases.dat contido na pasta opac_conf da pasta bases. A opção Home na barra de menus ativa a metabusca apresentando esta caixa:

Se uma ou mais palavras forem colocadas na caixa de pesquisa, o prefixo TW_ é adicionado para construir a expressão de pesquisa e aplicá-la a todos os bancos de dados. Isso significa que os bancos de dados devem usar esse prefixo para indexação de palavras-chave. Como resultado, é apresentado um resumo dos registros localizados:




