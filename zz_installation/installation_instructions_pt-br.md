Este arquivo contém as instruções de instalação para a última versão do ABCD.
Este texto é destinado ao gerente do sistema e ao gerente do banco de dados.

- [Introdução](#Introdução)
- [Pré-requisitos](#Pré-requisitos)
- [Preparação](#Preparação)
- [Instalar o ABCD](#Install-ABCD)

<hr>

# Introdução
O código ABCD é executado tanto em Windows quanto em Linux. O código fonte é igual para ambos os Sistemas Operacionais, exceto por algumas pequenas diferenças.

O ABCD requer vários outros componentes para suas operações. O componente CISIS (o software principal do banco de dados usado pelo ABCD) é distribuído com o ABCD.
Alguns componentes integrados também são distribuídos com o ABCD.

Outros componentes são indicados como pré-requisitos e não são distribuídos com ABCD.  
O módulo EmpWeb (módulo avançado de empréstimos) tem uma tecnologia completamente diferente, é colocado fora da pasta ABCD-www e precisa ser configurado de acordo com as instruções em seu próprio manual.
<hr>

# Pré-requisitos

### Sempre necessário
- Um webserver. O ABCD é testado com um servidor web Apache.
A fim de minimizar os problemas de segurança, recomenda-se a versão mais recente. O ABCD requer, no mínimo, uma instalação
  - Módulo `mod_cgi`: Para permitir a execução de scripts CGI
  - Módulo `mod_rewrite` : Para permitir a reescrita de regras no arquivo 
- Um processador PHP. A implementação unicode do ABCD requer PHP 7.4.x.
As extensões carregadas por padrão dependem do processador PHP real. O ABCD requer uma instalação mínima, pelo menos
  - Extensão `mbstring` : Suporte multibyte. Para ativar o unicode.
  - Extensão `gd` or `gd2` : Funções de imagem. O nome depende da implementação do PHP.

### Requisitos opcionais
- Extensões do servidore Web
  - Módulo `mod_ssl`  : Permite a emissão de certificados e o protocolo https
- Extensões PHP
  - Extensão `curl`  : Necessária se for utilizado o `DSpace bridge` (para baixar registros dos repositórios DSpace)
  - Extensão `ldap`  : Necessária se for utilizado o login com LDAP
  - Extensão `xmlrpc`: Necessário se o Site for utilizado
  - Extensão `xsl`   : Necessária se o Site for utilizado
  - Extensão `yaz`   : Obrigatório se for utilizado o cliente `Z39.50` (para baixar registros através do protocolo de comunicação Z39.50)
  - Extensão `zip`   : Obrigatório para atualizar o sistema.
- Apache Tika. Este conjunto de ferramentas de análise de conteúdo é requerido pela funcionalidade de Documento Digital no ABCD.
O ABCD utiliza o arquivo `tika-app***.jar` e `java` para executar este jar.
Baixe o arquivo `tika` em https://tika.apache.org/download.html

<hr>

# Preparação

A fase de preparação garante que um servidor web e PHP com os [Pré-requisitos](#Pré-requisitos) desejados sejam instalados. Este capítulo trata de alguns pontos de atenção especificamente para o ABCD. 
Existem múltiplas soluções para preencher estas funções (nativo, XAMPP, WAMP, EasyPHP,...). Devido às muitas soluções e opções destas soluções, é necessário ler cuidadosamente a documentação da solução. Este guia fornece apenas diretrizes mínimas.

É bom saber:
- As soluções integradas oferecem múltiplas funções. O ABCD requer apenas o servidor web e o PHP
- O firewall requer atenção para as portas ABCD

### Verifique o servidor web e o PHP
Assegure-se que o webserver e o PHP estejam instalados corretamente e que o PHP tenha as extensões necessárias

### Baixe o ABCD
O código para ABCD contém arquivos de exemplo de configuração para o webserver.

Todo o código do ABCD está localizados em  [GitHub ABCD-DEVCOM / ABCD2](https://github.com/ABCD-DEVCOM/ABCD2)  
Este repositório contém código compartilhado para Linux E Windows e dados específicos para Linux OU Windows.
Os downloads contêm todos os componentes. 

1. Selecione a opção **Releases*** no lado direito da janela
2. Vá até o lançamento desejado e selecione **Assets**
3. Selecione Código fonte (zip) ou Código fonte (tar.gz)
        
### Descompacte arquivo baixado
Use seu programa favorito (zip/7zip/tar/...) para descompactar o arquivo baixado. A estrutura da pasta ficará desta forma:
```
<Release_name> --+-- www ----------+-- bases-examples_Linux
                                   +-- bases-examples_Windows
                                   +-- cgi-bin_Linux
                                   +-- cgi-bin_Windows
                                   +-- extra
                                   +-- htdoc
                 +-- zz_installation
                 +-- zz_miscellaneous

```

### Arquivo para o Virtual Host
O servidor web permite uma instalação ABCD com uma configuração virtual. Com esta técnica são possíveis instalações múltiplas versões e completamente diferentes.

O exemplo de arquivos de configuração de host virtual para [Linux](vhost_ABCD_9090_Linux.conf) e [Windows](vhost_ABCD_9090_Windows.conf)
contêm os valores para uma instalação padrão do ABCD.
- Estes arquivos de exemplo estão localizados em ```<Release_name> --+-- zz_installation```
- Estes arquivos são exemplos de arquivos. DEVEM ser examinados e atualizados para atender suas necessidades e corresponder ao webserver real.
- O arquivo virtual host determina o protocolo, a porta e o nome do servidor para a instalação do ABCD.
  - O número da porta é coletado pela instalação do ABCD.
  - O protocolo (**http**/**https**) é captado pela instalação do ABCD
  - O protocolo **https**  é recomendado. Tenha atenção com o certificado. Para habilitar https: descomente as linhas com nomes de parâmetros **SSL\***
- O arquivo virtual host determina os locais para os componentes do ABCD. As configurações padrão são diferentes para Linux e Windows.
O servidor web aborda estas pastas com parâmetros:
  - **DocumentRoot** : pasta com PHP-scripts ABCD
  - **ScriptAlias cgi-bin** : pasta com arquivos executáveis (ex. CISIS, jar,...)
  - **Alias docs** : pasta com pastas de banco de dados
- O arquivo virtual host de exemplo especifica um local específico para os registros deste host virtual. Deve ser uma pasta existente! Crie se ela não existir.
- O arquivo virtual host de exemplo contém flags PHP comuns.


### Instalação de arquivo virtual host

- Copie o arquivo de exemplo para a configuração do webserver. O nome do arquivo pode ser escolhido arbitrariamente. 
Localizações de exemplo:  
  - WAMP &rarr; `wamp/alias`,  
  - XAMPP &rarr; `apache/conf/extra`,  
  - nativo do Ubuntu &rarr; `/etc/apache2/sites-available/`
- A existência do arquivo deve ser comunicada ao servidor. O método depende da solução do webserver instalado
  - XAMPP &rarr; edite `httpd.conf` &rarr; `include conf/extra/vhost_ABCD_9090_Windows.conf`
  - nativo do Ubuntu &rarr; `sudo a2ensite vhost_ABCD_9090_Linux.conf`
- Cheque a configuração
  - XAMPP &rarr; Iniciar serviço e verificar arquivos de log
  - nativo do Ubuntu &rarr; `sudo apachectl -S` /  `sudo apachectl -t -D DUMP_MODULES` / `sudo systemctl start  apache2`


<hr>

# Instalar o ABCD

### Pré-processar as pastas baixadas
O código ABCD é baixado na fase de preparação.
Observe as diferentes ações para as plataformas Windows e Linux. 
```
bases-examples_Linux   # Usuários Linux:   Renomeie para "bases".   Usuários Windows: Delete
bases-examples_Windows # Usuários Windows: Renomeie para "bases".   Usuários Linux:   Delete
cgi-bin_Linux          # Usuários Linux:   Renomeie para "cgi-bin". Usuários Windows: Delete
cgi-bin_Windows        # Usuários Windows: Renomeie para "cgi-bin". Usuários Linux:   Delete
extra                  # Contem código fonte C: Delete
htdocs                 # Contém ABCD
zz_installation        # Contém este arquivo, os "arquivos de exemplo de virtual HOST", e arquivos relacionados: Excluir após a instalação
zz_miscellaneous       # Utilizado somente por desenvolvedores: Delete
```
O resultado é:
```
bases                  # Pata com os bancos de dados
cgi-bin                # Pasta com os programas executáveis
htdocs                 # Contém o ABCD
```

### Copiar para o servidor
O arquivo virtual host especifica os nomes das pastas para a instalação do ABCD.
1. Copie o conteúdo de **htdocs** para a pasta especificada pelo parâmetro **DocumentRoot**.
2. Copie o conteúdo de **cgi-bin** para a pasta especificada pelo parâmetro **ScriptAlias**.
3. Copiar o conteúdo de **bases** para a pasta especificada pelo parâmetro **docs**.
4. Se o recurso Documento Digital for utilizado: Copie o arquivo tika baixado para a pasta especificada pelo parâmetro **ScriptAlias**.
5. Para instalações Linux
   - Mudar a propriedade das pastas para o proprietário/grupo do servidor web (`chown -R ...`)
   - Mudar a proteção das pastas para valores corretos (`chmod -R ...`)
6. Reiniciar o serviço do servidor web

### Run
Start your favourite web browser and run ABCD with following URL's.

- `https://localhost:9090/phpinfo   ` : Mostrar informações sobre as configurações e extensões do PHP
- `https://localhost:9090           ` : Módulo central. Login `abcd`, senha `adm`.
- `https://localhost:9090/iah       ` : Módulo iAH. Sem login
- `https://localhost:9090/site      ` : O módulo SITE. Sem login
- `https://localhost:9090/site/admin` : O módulo administrativo do SITE. Login `adm`, senha `x`.
- `https://localhost:9090/opac ` : Módulo OPAC. Sem login

### Configurar
Recomendação: Modificar as senhas dos usuários administrativos para evitar logins inesperados com demasiados privilégios

### Ajuda
Ajuda adicional pode ser obtida através da adesão e utilização da `ISIS-users discussion list`,
- registre-se em: http://lists.iccisis.org/listinfo/isis-users
- usando : e-mail para 'isis-users@iccisis.org'

