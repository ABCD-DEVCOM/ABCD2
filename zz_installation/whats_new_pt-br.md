Este arquivo contém os recursos novos e modificados do ABCD.
Este texto destina-se ao usuário final e aos gerenciadores de banco de dados.

Cada capítulo principal contém as informações de um lançamento em relação a uma versão mais antiga

- [Últimas informações](#Version-220)
- [Versão 2.2 beta](#Version-220-beta)

<hr>

# Versão 2.2.0
Este é um lançamento oficial.
Este capítulo contém as diferenças com a [Versão 2.2 beta](#Version-220-beta)

### Novo visual
A interface do usuário do módulo central foi modernizada.
Novos botões e novas cores farão com que o ABCD pareça melhor.
Muitos formulários também foram redesenhados para torná-los mais claros ou com melhor aparência.

O logotipo da ABCD é alterado.
Esses logotipos são acompanhados por alterações nos arquivos .css.
Os arquivos de logotipo e folha de estilo são armazenados em cache pela maioria dos navegadores e isso pode resultar em visualizações distorcidas para todos os usuários.    
Solução: &rarr; No navegador da web: Vá para o site da sua instalação do ABCD, pressione Ctrl F5 e reinicie o navegador.

A funcionalidade de navegação dos bancos de dados padrão foi alterada: a paginação e o layout da funcionalidade de navegação foram aprimorados.    
Bancos de dados afetados: ``acces, copies, providers, purchaseorder, reserve, servers, suggestions, suspml, trans, users``  
Para o funcionamento adequado deste navegador são necessários os seguintes arquivos. (Disponível nos bancos de dados de exemplo):
- `<database>/pfts/<LANG>/sort.tab`
- `<database>/pfts/<LANG>/tbacces_html.pft`

### Suporte a Unicode
Bancos de dados ABCD podem acomodar dados em **ISO-8859-1** ou **UTF-8**.
O suporte para UTF-8 foi significativamente aprimorado nesta versão.
Os termos **ANSI**, **Windows-1252**, **ASCII** não são mais usados. ABCD suporta de fato **ISO-8859-1**.

Detalhes:
- O conjunto de caracteres atual correto é sempre mostrado no canto superior direito da janela
- Os arquivos de dados ISO podem ser visualizados em ISO-8859-1 ou UTF-8.
Quando o conjunto de caracteres do arquivo e o banco de dados atual não coincidirem, o usuário verá um texto corrompido ou pontos de interrogação em diamantes pretos. 
- As opções para `Converter ABCD para Unicode` e `Converter ABCD para ANSI` foram removidas, pois levantam falsas expectativas.
Consulte o menu Utilitários para ver o novo conjunto.
- Os valores válidos para a variável UNICODE em `abcd.def`e `dr_path.def` são agora 0 e 1.
Isto é corretamente definido pelas modificações interativas destes arquivos.
Versões antigas ainda podem ter outros valores que agora são inválidos.
Note que as versões mais antigas podem mostrar outros valores de dados no arquivo `bases/abcd.def`.  
Solução: &rarr; Editar as informações pelo formulário interativo nas configurações do ABCD `abcd.def` e `dr_path.def` para todas as bases de dados

Uma página do navegador está em situações normais válidas para a codificação de 1 caractere.
O ABCD tem agora 3 combinações suportadas:
- Base de dados ISO-8859-1 com arquivos de idioma ISO-8859-1. (situação histórica)
- Banco de dados UTF-8 com arquivos de idiomas UTF-8
- Base de dados UTF-8 com arquivos de idioma ISO-8859-1 (ABCD converterá os arquivos ISO-8859-1 em tempo real para UTF-8)

Nota:
- O banco de dados ISO-8859-1 com arquivos de idioma UTF-8 não será exibido corretamente
- Os exemplos atuais e as instalações existentes utilizam a ISO-8859-1 para os bancos de dados padrão (por exemplo, ``access, copies,...``) e os arquivos de idioma ISO-8859-1.
A tradução dinâmica desses arquivos de idiomas garante a exibição correta se os bancos de dados UTF-8 forem selecionados.

### Utilities menu
Este menu foi reordenado. Novas opções no menu Utilitários:
- `Manutenção do banco de dados -> Create gizmo database` : Cria um banco de dados gizmo a partir do arquivo am ISO na pasta de dados atual com a arquitetura atual do banco de dados.
Esta opção é particularmente útil para bancos de dados com campos HTML.
- `Exportar/Importar -> Combinar arquivo ISO com FDT`: Esta opção lê um arquivo ISO existente de um outro banco de dados similar e escreve um novo arquivo ISO.
Este arquivo contém apenas campos encontrados no banco de dados atual FDT.
- `Converter ISO <-> UTF-8 -> Converter arquivos de texto do banco de dados para UTF-8`: Converte um conjunto de arquivos selecionados pelo usuário da ISO para UTF-8.
Destinado a FDT, FST e outros arquivos de configuração de banco de dados.
Esta é a substituição de `Converter o ABCD para Unicode'.
- `Converter ISO <-> UTF-8 -> Converter arquivo ISO para UTF-8`: Converter o conteúdo de um arquivo ISO selecionado de ISO-8859-1 para UTF-8
- `Converta ISO <-> UTF-8 -> Converta arquivos de idioma para UTF-8`: Converter os arquivos de idioma do idioma atual para UTF-8

### O código do documento digital é redesenhado
A funcionalidade base ainda está presente, mas o código é mais robusto e o usuário tem melhor controle.
A funcionalidade estava presente em  
`Utilitários -> Importação/Exportação -> Documentos de Importação -> submenu`  
e agora está presente em  
`Utilidades -> Documentos Digitais -> submenu alterado`

- O conteúdo dos arquivos importados não é mais armazenado permanentemente no banco de dados, mas carregado dinamicamente para a geração do arquivo invertido.
- O código para tornar os nomes dos arquivos únicos agora está ativado por padrão e usa um carimbo de data/hora (era um número aleatório)
- Agora é possível (e obrigatório) salvar o mapeamento de metadados de documentos para metadados ABCD.
Este mapeamento é preservado em  `<dbname>/docfiles_metadataconfig.tab`
  - Esquemas de mapeamento alternativos não precisam de muita digitação para cada upload
- A opção `Tagslevel` não é mais necessária
- Arquivos maiores conforme o tamanho do registro disponível são divididos em arquivos menores.
O algoritmo de divisão é controlado pelas próximas duas opções.
- Quando se utiliza o tamanho de registro completo disponível, era impossível gerar os arquivos invertidos.
O formulário `Set Import Options` tem dois campos para mitigar este problema.
   - `Tamanho do registro de trabalho`: O tamanho máximo do registro usado, padrão definido para 85% do tamanho físico.
   O algoritmo de divisão nunca excederá esse tamanho.
   A modificação pode resultar em problemas de indexação.
   - `Granularidade`: O tamanho do arquivo de destino a ser usado para importação.
   O algoritmo de divisão dividirá os dados em um ponto "bom" (por exemplo, não no meio de uma palavra) próximo ao tamanho do arquivo de destino

### Gerar arquivos invertidos/indexação
A funcionalidade e a interface deste utilitário são modificadas
- Uma opção para Indexação Incremental é mostrada, se aplicável.
- Os campos HTML são detectados para todos os bancos de dados. Se tais campos forem detectados, uma opção é mostrada para remover as tags HTML antes da indexação real.
Se a opção for selecionada, o sistema requer um gizmo para excluir as tags HTML do campo.
- A geração do arquivo invertido depende das tabelas `actab` e `uctab`. A sintaxe desses arquivos é diferente para ISO-8859-1 e UTF-8.
Usar a sintaxe errada resultará em mensagens de erro fatais em vários lugares.
O script procura os arquivos na seguinte ordem:
  - Se o arquivo `dr_path.def` estiver presente, ele usará o arquivo especificado neste arquivo por chaves
    - `actab=` ou `isisac.tab=`
    - `uctab=` ou `isisuc.tab=`
  - Se tal arquivo não for encontrado, o script procura em `<bases>/<database>/data` por arquivos com nome
    - `isisac.tab` para bancos de dados ISO-8859-1 e `isisactab_utf8.tab` para bancos de dados UTF-8
    - `isisuc.tab` para bancos de dados ISO-8859-1 e `isisuctab_utf8.tab` para bancos de dados UTF-8
  - Se tal arquivo não for encontrado, o script procura em `<bases>`.

Os nomes de arquivo para `actab` e `uctab` especificados em `dr_path.def` são livres e é recomendado que reflitam a intenção do arquivo.
Por exemplo. `isisac.tab=%path_database%mydatabase/data/mydb_utf8_isisac.tab`

### Criar um novo banco de dados a partir de um banco de dados existente
Este script foi aprimorado com os seguintes recursos
- O conjunto de caracteres selecionado é usado para os novos bancos de dados e pode ser diferente do original.
- A arquitetura de banco de dados selecionada é usada para os novos bancos de dados e pode ser diferente da original.
- A estrutura de pastas é completamente copiada (inclui uma possível "collection" vazia)
- Todos os arquivos relevantes do banco de dados original são copiados e o nome do arquivo é adaptado para o novo nome do banco de dados.
- O conteúdo de vários arquivos também é adaptado para o novo nome do banco de dados.
- Caso os conjuntos de caracteres sejam iguais, o `actab` e o `uctab` originais são usados. Se os conjuntos de caracteres forem diferentes, o padrão `actab` e `uctab` para o conjunto de caracteres será usado.

### Tradução de arquivos de mensagens
Quando o sistema exibe uma mensagem ele pega uma chave e esta chave é traduzida na mensagem correta.
Se uma chave não fosse encontrada, o sistema mostrava um erro de "índice ausente".
O código atual usa agora uma tabela de fallback distribuída com o código. E isso reduz os erros de "índice ausente" para 0.
Outras características:
- Os scripts para editar as tabelas de idiomas mostram a chave exclusiva e também "chaves fantasmas": chaves presentes no arquivo de idioma e não na tabela de fallback.
- Salvar uma tabela editada remove as entradas "fantasmas".
- O script para editar a tabela de idiomas tem a opção de mostrar o texto em ISO-8859-1 ou UTF-8.
Observe que os arquivos de idioma ISO-8859-1 serão traduzidos dinamicamente para UTF-8 caso sejam usados bancos de dados UTF-8.
- A tabela de fallback é modificada adicionando e excluindo entradas para a versão atual.
- A pasta de banco de dados "exemplo" contém arquivos atualizados para vários idiomas
- Todas as tabelas são classificadas em ordem alfabética.
  - Esta ação permite a comparação entre as tabelas de diferentes idiomas.
  - Esta ação mostra que algumas tabelas podem ter entradas duplicadas.

### Pequenas modificações
- Tela aprimorada para pesquisar usando o dicionário

### Mudanças arquitetônicas
O código possui dezenas de alterações para torná-lo mais robusto, resistente a erros, melhorar o feedback e correções para gerar HTML válido.

Principais marcos:
- O código é compatível com PHP 7.4.
- **`https`** é aceito pelo código. Este protocolo é recomendado para segurança.
- Suporte para `Secs` (Serials Control System) teve que ser encerrado devido ao término da manutenção para plug-ins essenciais.
- As arquiteturas de banco de dados Isis `16-60` e `bigisis` são suportadas para Linux e Windows para conjuntos de caracteres `ISO-8859-1` e `UTF-8`.
Este já era o caso do Linux.
Para Windows, o suporte `bigisis` foi aprimorado e o suporte para `FFI` foi encerrado.
- O pacote de terceiros `tika` não é mais fornecido com o ABCD. O código mostrará mensagens informativas se o pacote for necessário mas não estiver instalado


<hr>
# Versão 2.2.0 beta

### Suporte a Unicode
Esta versão tem algum suporte para Unicode. Este é um aprimoramento da versão anterior

### Menu de utilitários
Os links de caracteres no menu `Utilities` com o submenu `EXTRA UTILITIES` são substituídos por uma lista baseada em botões com sublistas suspensas.

### Validação de campo
A coluna de configuração `Validação de campo` para FDT e Planilha mostra uma lista suspensa com opções.
Observe a opção de verificação para `Chave única`

O banco de dados `copies` requer esta configuração para a planilha `new.fmt` ("Novas cópias") requer esta configuração para a tag 30: `Inventory Number`
Isso é corrigido nos bancos de dados de exemplo

### Mudanças arquitetônicas
Conquistas
- Um novo módulo chamado `OPAC`é introduzido. Este módulo destina-se a substituir o módulo 'iAH'
<hr>

# Versão 2.1b /2.0f
As informações para esta e versões anteriores não estão incluídas neste arquivo.
Isso implica que algumas opções "novas" em versões posteriores podem estar presentes nesta ou em versões anteriores.