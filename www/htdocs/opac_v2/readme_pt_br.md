# Descrição do OPAC-ABCD

### Característica

O ABCD Opac permite até 3 níveis de busca:

* metasearch
* Pesquisa em um banco de dados específico
* Pesquisa em um subconjunto de registros em um banco de dados (tipo de material, ou outra classificação definida por um prefixo do FST)

# OPAC - Estrutura de arquivos

Os arquivos na pasta **opac\_conf*** são para uso geral do sistema Opac, alguns são obrigatórios para a operação básica do sistema:

bases/opac\_conf/lang/

**Arquivos requeridos:**

*   bases.dat
*   lang.tab
*   footer.info
*   menu.info
*   side\_bar.info
*   sitio.info

## Formulário de busca geral (**metasearch**)

Os arquivos de busca avançada e livre precisam seguir o padrão das buscas livres e avançadas das bases de dados, ou seja, se o prefixo TW\_ for definido em uma base de dados para a busca livre, o mesmo prefixo deve ser usado para a busca geral.

*   libre.tab
*   avanzada.tab

**Os arquivos que estão em processo de avaliação no desenvolvimento.**

*   camposbusqueda.tab
*   colecciones.tab
*   destacadas.tab
*   facetas.dat
*   formatos.dat
*   autoridades\_opac.pft
*   indice.ix
*   opac.pft
*   opac\_loanobjects.pft
*   select\_record.pft

## Configurando um banco de dados no Opac

Os arquivos de configuração de um banco de dados habilitado para ser exibido no Opac devem estar presentes junto com o banco de dados em uma pasta chamada Opac/lang: **/bases/dbName/opac/lang/**

*   dbName.def
*   dbName.ix
*   dbName.lang
*   dbName\_avanzada.tab
*   dbName\_facetas.dat
*   dbName\_formatos.dat
*   dbName\_libre.tab

### Busca por tipos de registro (dbName\_colecciones.tab)

*   dbName\_colecciones.tab

### Busca avançada por tipos de registro (dbName\_colecciones.tab)

Arquivos para pesquisa por tipo de coleção, onde o sufixo \_\[letra\]  está relacionado à primeira coluna do arquivo dbName\_collections.tab

*   dbName\_avanzada\_\[letter\].tab


### Modificações após julho de 2022

As variáveis abaixo tiveram seus parâmetros modificados de S para Y, com objetivo de padronizar opções do tipo Yes ou Não:

*   $multiplesBases
*   $afinarBusqueda
*	$facetas