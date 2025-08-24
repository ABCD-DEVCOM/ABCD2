# Documentação da Refatoração do Módulo OAI-PMH para ABCD

## 1. Introdução

Este documento detalha as principais melhorias e alterações realizadas no módulo OAI-PMH do software ABCD. O objetivo da refatoração foi modernizar a interface de exploração do protocolo, centralizar e simplificar as configurações, melhorar a manutenibilidade do código e preparar a ferramenta para futuras expansões, como o suporte a múltiplos idiomas.

## 2. Principais Alterações e Melhorias

As mudanças podem ser resumidas em quatro áreas principais:

### 2.1. Nova Interface de Exploração (agora `index.php`)

A interface original foi completamente substituída por uma nova, moderna e interativa.

* **Layout Limpo e Responsivo:** A nova interface utiliza um layout mais organizado, com um menu lateral para os verbos OAI e uma área de conteúdo principal.

* **Deteção Dinâmica de Parâmetros:** Ao selecionar um verbo (ex: `ListRecords`), a interface exibe dinamicamente apenas os campos de parâmetros relevantes.

* **Menus de Seleção Inteligentes:** Para os campos `set` e `metadataPrefix`, a interface agora consulta o próprio provedor OAI (`ListSets` e `ListMetadataFormats`) para preencher menus de seleção (dropdowns), evitando que o usuário precise adivinhar os valores válidos.

* **Seletores de Data:** Os campos `from` e `until` utilizam um seletor de datas nativo do navegador (`datepicker`), facilitando a inserção e prevenindo erros de formato.

* **Construção de URL em Tempo Real:** A URL completa da requisição OAI-PMH é montada e exibida em tempo real, à medida que o usuário preenche os parâmetros.

* **Visualização de Resposta Formatada:** A resposta XML do servidor é exibida com realce de sintaxe (syntax highlighting), facilitando a leitura e a depuração.

### 2.2. Unificação e Simplificação da Configuração

Os arquivos de configuração foram unificados e a lógica de detecção de ambiente foi aprimorada.

* **Eliminação de Arquivos Duplicados:** Os arquivos específicos para Windows e Linux (`oai-config-win.php`, `oai-config-lin.php`, etc.) foram eliminados.

* **Arquivos de Configuração Únicos:** Agora, existem apenas dois arquivos de configuração principais em formato PHP puro, o que os torna mais seguros e robustos:

  * `oai-config.php`: para as configurações gerais do ambiente e do repositório.

  * `oai-databases.php`: para a definição das bases de dados (sets).

* **Detecção de Ambiente em PHP:** A lógica para identificar se o servidor é Windows ou Linux foi movida para os scripts PHP (`lib/parse_config.php` e `lib/parse_databases.php`). Isso torna os arquivos de configuração mais limpos e a lógica de programação mais centralizada.

### 2.3. Sistema de Internacionalização (i18n)

A interface agora está preparada para suportar múltiplos idiomas de forma organizada.

* **Arquivos de Tradução JSON:** Todos os textos da interface estão externalizados em arquivos `.json` localizados na pasta `lang/` (ex: `en.json`, `pt-br.json`).

* **Fácil Adição de Novos Idiomas:** Para adicionar um novo idioma, basta:

  1. Adicionar a entrada do idioma no arquivo `oai-config.php`.

  2. Criar o arquivo JSON correspondente na pasta `lang/`.

* **Seletor de Idiomas:** Um menu dropdown no cabeçalho da página permite que o usuário alterne facilmente entre os idiomas disponíveis.

### 2.4. Organização de Arquivos (`assets`)

Para uma melhor estrutura de projeto, os arquivos de frontend foram reorganizados.

* As pastas `css` e `js`, que contêm as folhas de estilo e os scripts da interface, foram movidas para dentro de uma nova pasta `assets/`.

## 3. Instruções de Instalação e Atualização

Para aplicar esta nova versão do módulo OAI-PMH em uma instalação existente do ABCD:

1. **Faça um backup** do seu diretório `isis-oai-provider` original.

2. **Substitua os arquivos modificados** pelas novas versões fornecidas durante o processo de refatoração.

3. **Crie as novas pastas** `assets/` e `lang/` dentro de `isis-oai-provider/`.

4. **Mova** as pastas `css/` e `js/` para dentro de `assets/`.

5. **Crie os arquivos de tradução** (`en.json`, `pt-br.json`) dentro da pasta `lang/`.

6. **Delete os arquivos de configuração antigos** e obsoletos:

   * `oai-config-win.php`

   * `oai-config-lin.php`

   * `oai-databases-win.php`

   * `oai-databases-lin.php`

7. **Ajuste os caminhos** das bases de dados no arquivo `oai-databases.php` e, se necessário, no `oai-config.php` para que correspondam à sua estrutura de pastas local.

8. **Lembrete Importante:** Após a instalação e configuração, **é necessário reiniciar o VS Code** para garantir que todas as alterações de arquivos e configurações sejam corretamente carregadas pelo ambiente.

## 4. Conclusão

Esta refatoração moderniza o módulo OAI-PMH do ABCD, tornando-o uma ferramenta mais poderosa, flexível e fácil de usar e manter, tanto para os administradores quanto para os usuários finais que desejam explorar os recursos do repositório.
