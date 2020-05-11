Plugin que permite executar scripts (shell, php, ruby…),
solicitações http, para recuperar informações em XML ou JSON.

Configuração do plugin 
=======================

A configuração é muito simples, depois de baixar o plugin, ele
você acabou de ativá-lo e é isso.

![script1](../images/script1.PNG)

A única opção é onde o jeedom coloca os scripts padrão,
é aconselhável não tocá-lo.

Configuração do equipamento 
=============================

A configuração do equipamento Script está acessível no menu
plugin :

![script2](../images/script2.PNG)

É assim que a página do plugin Script se parece (aqui com 1
equipamento) :

![script3](../images/script3.PNG)

Aqui está a lista dos seus scripts. Depois de clicar
no equipamento que você recebe :

![script4](../images/script4.PNG)

> **Dica**
>
> Como em muitos lugares em Jeedom, coloque o mouse na extremidade esquerda
> abre um menu de acesso rápido (você pode
> do seu perfil, deixe-o sempre visível).

Aqui você encontra toda a configuração do seu equipamento :

-   **Nome de o equipamento script** : nome do seu equipamento de script

-   **Categoria** : categorias de equipamentos (pode pertencer a
    várias categorias)

-   **Ativar** : torna seu equipamento ativo

-   **Visivél** : torna visível no painel

-   **Objeto pai** : indica o objeto pai ao qual pertence
    o equipamento

-   **Atualização automática** : permite especificar um cron de atualização
    automático para todos os comandos do tipo de informação.

Abaixo você encontra a lista de pedidos :

-   **Nome** : Este campo contém o nome ao qual você deseja atribuir
    seu pedido / informações.

-   **ícone** : Este campo permite associar um ícone ao seu nome (em
    (este caso Jeedom substitui o nome pelo ícone no painel).

-   **Tipo de script** :

    -   O tipo http : permite enviar uma solicitação para um dispositivo
        externo sem necessariamente esperar pelo retorno deste comando.
        O exemplo que servirá de suporte para o tipo http será o
        configuração de uma solicitação a uma Vera para ativar
        uma luz.

    -   O tipo de script : usado principalmente para executar scripts
        interno para Jeedom. O exemplo que dará suporte ao tipo
        script será a configuração do script de monitoramento de temperatura
        framboesa disponível no mercado.

    -   Tipo XML : permite recuperar informações codificadas em
        XML de equipamento remoto. O exemplo que servirá como
        O suporte ao tipo XML será a configuração de script para
        interrogar um dispositivo ecológico.

    -   O tipo JSON : permite recuperar informações codificadas em
        JSON de um dispositivo remoto. O exemplo que servirá como
        O suporte ao tipo JSON será a configuração de script para
        interrogar Sickbeard (ou XBMC).

-   **o tipo** e o **Subtipo**

-   O campo **Pedido**

    -   Este campo deve conter a própria consulta ou o caminho do
        script se o campo "tipo de script" for script. O botão
        "parcourir" : permite selecionar o arquivo contido no
        arquivo interno na Jeedom.

        > **Dica**
        >
        > Este arquivo está acessível no SSH
        > em / usr / share / nginx / www / jeedom / plugins / script / core / resources /.
        > FYI, o comando SSH para atribuir direitos de dados www
        > para um arquivo é : sudo chown
        > www-data:www-data NOMDUSCRIPT.EXTENSION. Observe que para
        > executar um script, ele deve ter direitos de dados www.

    -   O botão **Editar** : permite editar usando um editor
        código interno um dos arquivos contidos no diretório
        permitindo acesso ao código do arquivo.

    -   O botão **Novo** : permite criar um arquivo de comando.

        > **Dica**
        >
        > Não se esqueça de inserir o nome do arquivo, bem como
        > extensão total sob pena de ver seu excelente roteiro não
        > não funciona. Sem extensão, Jeedom não saberá
        > reconhecer o idioma associado ao seu arquivo. CF :
        > Geral

    -   O botão **Remover** : permite excluir um arquivo
        de ordem.

    -   O botão **Compartilhe** : um dos mais importantes, e depois
        validou os desenvolvedores de CGU em seu perfil no mercado,
        permite que você compartilhe sua criação com a comunidade.

-   O campo **Opções** : Campo com opções variáveis, dependendo da escolha
    tipo de script.

-   **Unidade** : unidade de dados (pode estar vazia).

-   **min / max** : limites de dados (podem estar vazios).

-   **Historicizar** : permite historiar os dados.

-   **Display** : permite exibir os dados no painel.

-   **Evento** : retorno em caso de eventos. No caso da RFXcom
    esta caixa deve estar sempre marcada porque você não pode consultar
    um módulo RFXcom.

-   **Permitir memcache** : permite que o Jeedom use cache para
    valor (padrão 5 min) antes de executar novamente o script para que
    novo valor.

-   **Cache vitalício** : permite modificar a vida útil do cache
    (padrão 5 min).

> **IMPORTANTE**
>
> Evite o máximo possível no caminho do script ou no
> os parâmetros de caracteres especiais. Os personagens
> permitido ser : números, letras (maiúsculas ou minúsculas)

![script5](../images/script5.PNG)

Permite chamar um URL ou obter o retorno de um URL.

-   uma caixa de seleção "Não marque SSL" : se marcado, permite que o Jeedom
    para não enviar os campos "Usuário" e "Senha" para
    o pedido. Jeedom não procurará se identificar com
    local / máquina remota.

-   uma caixa de seleção "Permitir resposta em branco" : se marcado, permite
    Jeedom para não esperar por uma resposta ou ignorar qualquer resposta a
    o quadro transmitido. Em geral, verificamos se o Jeedom nos envia um "Curl
    Erro : Resposta vazia do servidor".

-   uma caixa de seleção "Nunca relatar erros" : não deixa
    não emitir um alerta em caso de erro.

-   um campo de tempo limite" : sem ser informado, o tempo limite da solicitação
    o padrão é 2 segundos, caso contrário, vale o valor digitado.

-   um campo "Máximo de tentativas" : Máximo de 4 testes por padrão.

-   um campo "Usuário"" : para inserir um nome de usuário.

-   um campo "Senha"" : inserir uma senha.

A escolha do HTML 
=============

![script8](../images/script8.PNG)

Analisar uma página da web (arquivo HTML) para recuperar um valor
nele. A sintaxe é a mesma que para jquery.

O campo de opção possui um campo "URL do arquivo HTML"" : este campo
portanto, contém o link para a máquina que hospeda o arquivo HTML no
question.

A escolha XML 
============

![script6](../images/script6.PNG)

Permite recuperar xml e procurar especificamente um valor
dedans.

O campo de opção possui um campo "URL do arquivo XML"" : este campo
portanto, contém o link para a máquina que hospeda o arquivo XML em
question.

> **IMPORTANTE**
>
> Só é possível recuperar valores, os atributos não
> pode ser recuperado.

A escolha JSON 
=============

![script7](../images/script7.PNG)

Permite recuperar json e buscar especificamente um
valor em.

O campo de opção possui um campo "URL do arquivo JSON"" : este campo
portanto, contém o link para a máquina que hospeda o arquivo JSON no
question.

Exemplo HTTP : Pilotar uma Vera 
==================================

O exemplo é baseado em uma Vera e consiste em dirigir uma lâmpada
regulável. Eu não vou me debruçar sobre como dirigir uma Vera
por solicitação http, o fórum do TLD é preenchido com respostas. Além disso,
o exemplo corresponde ao meu tipo de material e terá que ser adaptado para
seu.

> **Dica**
>
> Um método para quem procura escrever solicitações http,
> primeiro valide a sintaxe no seu navegador e só então
> vá para a configuração em Jeedom. Quando um script de ação não
> não funcionar, alterne para Info / Other script permite que você veja o erro
> retornou.

Vamos lá :

-   Criamos equipamentos : por exemplo, LUM COZINHA (acho que temos
    tudo uma cozinha na mão)

-   Nós o associamos a um objeto pai : por exemplo VERA, isso me permite
    centralize todos os pedidos relacionados à VERA em um
    mãe solteira.

-   Escolha sua categoria.

-   Ative seu equipamento, não verifique visível, veremos um pouco
    depois como associá-lo a um virtual (mais sexy, mais WAF)

-   Para atualização automática, não coloque nada, é um comando
    impulso ligado ao pressionar um botão ou um cenário !

-   Adicionar um comando de script

-   Lembre-se de salvar

Explicações :

-   Nome : 100% porque acenderemos uma luz com força total

-   Tipo de script : http

-   Tipo : Ação (é uma ordem)

-   Subtipo : Falha

-   Pedido :

````
http://<IP_VERA>:3480/data_request?id=lu_action&output_format=json&DeviceNum=12&serviceId=urn:upnp-org:serviceId:Dimming1&action=SetLoadLevelTarget&newLoadlevelTarget=100
````

> **Dica**
>
> o "100" no final da solicitação corresponde à porcentagem de potência
> atribuir para colocar "0" no final da solicitação corresponde a
> desligue a lâmpada.

O botão "testar" permite que você teste seu pedido !

Portanto, você pode multiplicar pedidos no mesmo equipamento
por exemplo, fazer um pedido de 60% para uma luz fraca, crie
um terço a 30% para viagens noturnas a serem combinadas
cenário,…

Também é possível criar um comando do tipo slider colocando o comando
tag \#slider\# no pedido :

````
http://<IP_VERA>:3480/data_request?id=lu_action&output_format=json&DeviceNum=12&serviceId=urn:upnp-org:serviceId:Dimming1&action=SetLoadLevelTarget&newLoadlevelTarget=#slider#
````

> **Dica**
>
> Se seu pedido for do tipo de mensagem, você poderá usar tags
> \#message\# e \#title\#, idem para uma ordem de cores com
> a tag \#color\#, ou tipo deslizante com #slider# ou liste com #select#

Exemplo HTTP : Enviar notificação para XBMC 
==============================================

Finalidade : Enviar notificação ao XBMC ao abrir uma porta
entrada.

-   Nome : PUSH XBMC

-   Tipo de script : http

-   Tipo : Ação (é uma ordem)

-   Subtipo : Falha

-   Pedido :

````
http://IP_DE_XBMC:8080/jsonrpc?request={ %22jsonrpc%22:%222.0%22,%22method%22:%22GUI.ShowNotification%22,%22params%22:{ %22title%22:%22Mouvement% 20Detecté%22,%22message%22:%22Porte% 20Entrée%22},%22id%22:1}
````

Cabe a você testar isso em um cenário, por exemplo !

API XBMC [aqui](http://wiki.xbmc.org/index.php?title=JSON-RPC_API/v6)
(apenas os campos marcados com "obrigatório" são obrigatórios)

Finalidade : Envie uma notificação para XBMC quando a temperatura cair
abaixo de um certo limite

Veja o exemplo acima :

-   substitua "Movement% 20Detected" por "Risk% 20of% 20gel"

-   substitua "Porte% 20Entrée" por
    "Temperatura% 20 fora% 20:% 20 \#\ [EXTERIOR \] \ [EXTERIOR \] \ [TEMPERATURE \]\#% 20"

Teste em um cenário *\ [EXTERIOR \] \ [EXTERIOR \] \ [TEMPERATURE \]* &lt;
15 por exemplo

Ação : Inicie o script, via equipamento virtual, vinculado ao seu script
!

Exemplo de SCRIPT 
==============

O mais legal, mas não o mais fácil de explicar.

Pré-requisitos : saber como desenvolver um script em php, python ou ruby.

>**IMPORTANTE**
>
> A extensão do seu script deve corresponder absolutamente ao seu tipo. Ex .php para um tipo de php. Na verdade, o Jeedom é baseado na extensão do script para o executável iniciar (php if .php, python se .py ....)

O script de monitoramento de temperatura de framboesa servirá como exemplo
para usar o tipo de script : Script

Depois de baixar o script do mercado, o botão "Procurar""
permite selecionar o arquivo temp\_rasp.php.

Por curiosidade, você pode ver o conteúdo do arquivo pressionando
no botão "Editar", você deve obter o seguinte código :

Este é um script php que pode ser reutilizado fora do Jeedom !

````
 <?php
    $temp = shell_exec("cat /sys/class/thermal/thermal_zone0/temp");
    $temp = $temp / 1000;
    $temp = round($temp,1);
    echo $temp
 ?>
 ````

NOTA : concretamente, é a função "echo" do php que dará ao
valor para Jeedom

Os parâmetros 
--------------

Obtenha as informações de Jeedom para usá-las em um script. O
recuperação depende do tipo de script usado :

Exemplo :

-   Na linha :
    /usr/share/nginx/www/jeedom/plugins/script/core/ressources/MON\_SCRIPT\_PHP.php
    lista, o argumento "lista" é uma cadeia de caracteres (fixa)
    recuperado do script php usando a seguinte função
    \ $ argv \ [1 \] cf : Google para mais detalhes sobre como recuperar
    parâmetros em PHP.

-   Vimos anteriormente que era possível recuperar
    valores dinâmicos de Jeedom.

-   Na linha :
    /usr/share/nginx/www/jeedom/plugins/script/core/ressources/radio.py
    VÔO *controle deslizante* , o argumento "*controle deslizante*" é recuperado deste
    argv \ [2 \]. Quando o jeedom executa o script, ele
    substituirá automaticamente *controle deslizante* por valor (numérico)
    controle deslizante. CF : Google para mais detalhes sobre como recuperar
    parâmetros em Python.

-   Mais forte : Potencialmente, todas as variáveis acessíveis por
    Jeedom pode ser usado pelo plugin de script :

    -   Você quer recuperar o valor da temperatura da cozinha
        para historizá-lo fora de Jeedom ?

    -   Pular *\ [COZINHA \] \ [COZINHA \] \ [Temperatura \]* como parâmetro
        para o script e Jeedom irá substituí-lo pelo valor lido durante
        da remessa.

Recomendação para testar os parâmetros no script php :

````
if (isset($argv)) {
 foreach ($argv as $arg) {
     $argList = explode('=', $arg);
     if (isset($argList[0]) && isset($argList[1])) {
         $_GET[$argList[0]] = $argList[1];
     }
 }
}
````

Exemplo XML Simples 
==================

Aqui está o formato do xml padrão :

````
<root>
    <led0>1</led0>
    <leds>
      <led1>toto</led1>
    </leds>
</root>
````

Se você quiser o valor de led0 na consulta, coloque led0. Se
você quer o valor de led1, que é o filho dos leds que você colocou
leds &gt; led1.

Notez que l'élément racine &lt;root&gt; n'est pas à préciser dans le
campo de solicitação.

Exemplo XML complexo 
====================

````
 <root>
   <led0>1</led0>
   <leds>
     <led1>toto</led1>
   </leds>
   <leds>
     <led1>tata</led1>
   </leds>
 </root>
 ````

a sintaxe é :

leds &gt; 1 &gt; led1 qui donne en réponse tata, 1 étant le numéro de
linha da matriz !

Exemplo XML mais complexo 
=========================

````
<AKT_Data ID="SMS-Liste" ZeitSt="01.05.2017 18:55">
 <MesPar DH="HBCHa" StrNr="2167" Typ="02" Var="02">
   <Name>Tresa - Ponte Tresa, Rocchetta</Name>
   <Datum>01.05.2017</Datum>
   <Zeit>18:50</Zeit>
   <Wert>268.56</Wert>
   <Wert dt="-24h">268.51</Wert>
   <Wert Typ="delta24">0.051</Wert>
   <Wert Typ="m24">268.52</Wert>
   <Wert Typ="max24">268.56</Wert>
   <Wert Typ="min24">268.50</Wert>
 </MesPar>
 <MesPar DH="HBCHa" StrNr="2265" Typ="03" Var="02">
  <Name>Inn - Tarasp</Name>
  <Datum>01.05.2017</Datum>
  <Zeit>18:50</Zeit>
  <Wert>4.85</Wert>
  <Wert dt="-24h">7.98</Wert>
  <Wert Typ="delta24">-3.130</Wert>
  <Wert Typ="m24">6.15</Wert>
  <Wert Typ="max24">7.98</Wert>
  <Wert Typ="min24">4.85</Wert>
 </MesPar>
 <MesPar DH="HBCHa" StrNr="2270" Typ="02" Var="32">
  <Name>Doubs - Combe des Sarrasins</Name>
  <Datum>01.05.2017</Datum>
  <Zeit>18:00</Zeit>
  <Wert>500.65</Wert>
  <Wert dt="-24h">500.65</Wert>
  <Wert Typ="delta24">0.000</Wert>
  <Wert Typ="m24">500.65</Wert>
  <Wert Typ="max24">500.65</Wert>
  <Wert Typ="min24">500.64</Wert>
 </MesPar>
</AKT_Data>
````

Para recuperar informações do campo Wert do 1º bloco:

``MesPar>0>Wert>0 qui retourne donc "268.56 "``

Para retornar o seguinte elemento na "estrutura" Wert, você deve
basta indicar o número do pedido na estrutura. O que dá
pour l'élément '&lt;Wert Typ="delta24"&gt;0.051&lt;/Wert&gt;' le code
Seguinte :

``MesPar>1>Wert>2``

Para passar para o próximo bloco "MyPar", é necessário alterar o índice para
conseqüência : o 1 por 2, por exemplo.

ATENÇÃO : Se no arquivo XML a ordem for alterada, a solicitação não será
trabalha mais. Será necessário reajustar a solicitação de acordo com a ordem
retourné.

Exemplo JSON 
============

Como o tipo XML, é possível ler informações de
um retorno JSON.

Para explicar, vou me basear em informações JSON com
o aplicativo Sickbeard (boo… cpasbien), mas aqui apenas a técnica
premium, não a ferramenta !

O acesso a este arquivo é possível usando o seguinte URL :

``http://<IP_DELAMACHINEQUIEBERGESICKBEARD>:8083/api/XXXX/?cmd=history&limit=3``

NOTA : XXXX é o número da chave da API específico para cada SICKBEARD.

Antes de tudo, antes de iniciar a configuração do plug-in de script
JSON, é uma questão de identificar corretamente as informações a serem recuperadas., car
aqui vamos integrar uma noção de matriz nos retornos.

Valide a exibição de informações do seu navegador (teste
no Chrome).

Exemplo de retorno :

````
 {
     "data": [
         {
             "date": "2014-09-10 01:37",
             "episode": 4,
             "provider": "RNT",
             "quality": "SD TV",
             "resource": "XXX",
             "resource_path": "XXXX",
             "season": 2,
             "show_name": "Totovaalaplage S2E4",
             "status": "Downloaded",
             "tvdbid": XXXXX
         },
         {
             "date": "2014-09-10 01:36",
             "episode": 3,
             "provider": "RNT",
             "quality": "SD TV",
             "resource": "XXXX",
             "resource_path": "XXX",
             "season": 2,
             "show_name": "Totovaalaplage S2E3",
             "status": "Downloaded",
             "tvdbid": XXXXX
         },
         {
             "date": "2014-09-10 01:21",
             "episode": 1,
             "provider": "Cpasbien",
             "quality": "SD TV",
             "resource": "XXXX",
             "resource_path": "XXXX",
             "season": 1,
 ICI -->     "show_name": "Totovaplusauski mas Totovaalaplage S1E1",
             "status": "Snatched",
             "tvdbid": XXXX
         }
     ],
     "message": "",
     "result": "success"
 }
 ````

No caso em que gostaríamos de retornar o show\_name of the 3rd
elemento no php (marcado AQUI), seria necessário fazer : data &gt; 2
&gt;show\_name, o índice da matriz de retorno começando em Zero.

Neste exemplo, o botão "Teste" retornará "Totovaplusauski
mas Totovaalaplage S1E1".

Detalhes :

Observe a sintaxe do comando Request, é do tipo element0 &gt;
index du tableau &gt; élément1

Desvantagens :

-   esse método permite recuperar apenas um elemento de cada vez.

-   Se quisermos retornar todos os valores de "show\_name", isso
    infelizmente não é possível, você terá que duplicar o script
    quantas vezes for necessário.

Exemplo HTML 
============

Aqui tentaremos recuperar o último FML.

Primeiro de tudo você precisa configurar o URL :

``http://www.viedemerde.fr``

Então você tem que encontrar o "caminho" do último FML. Para fazer isso,
você precisa ir ao site e clicar com o botão direito do mouse no item desejado
inspecionar o item, temos :

![script9](../images/script9.PNG)

Aqui é a parte mais complexa e que requer um pouco de análise. Aqui
meu texto está em uma tag "a" que está em um elemento do tipo p
que é uma classe div "postar artigo". Então eu tenho que selecionar
o primeiro elemento div da classe "post" e "article" e depois o primeiro
elemento pe que recebo tudo nas tags "a" que
contém. Então eu tenho : "div.post.article:primeiro p:primeiro a".

Então nós temos :

![script10](../images/script10.PNG)

Para uma atualização em tempo real, é possível colocar um cron
atualizar.

> **Dica**
>
> Ao instalar um cron de atualização, o Jeedom irá
> marque automaticamente a caixa Evento, isso é completamente normal.

Aqui você pode imaginar um cenário que o envia por SMS
o último FML.
