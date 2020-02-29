Plugin que permite ejecutar scripts (shell, php, ruby ​​...),
solicitudes http, para recuperar información en XML o JSON.

Configuración del complemento 
=======================

La configuración es muy simple, después de descargar el complemento,
simplemente lo activas y eso es todo.

![script1] (../ images / script1.PNG)

La única opción es donde jeedom pone los scripts predeterminados,
se aconseja no tocarlo.

Configuración del equipo 
=============================

Se puede acceder a la configuración del equipo guión desde el menú
plugin :

![SCRIPT2] (../ images / script2.PNG)

Así es como se ve la página del complemento de guión (aquí ya con 1
equipos) :

![guión 3] (../ images / script3.PNG)

Aquí está la lista de sus guiones. Una vez que hagas clic
en el equipo que obtienes :

![script4] (../ images / script4.PNG)

> **punta**
>
> Como en muchos lugares de Jeedom, coloca el mouse en el extremo izquierdo
> abre un menú de acceso rápido (puedes
> desde tu perfil siempre déjalo visible).

Aquí encontrarás toda la configuración de tu equipo :

-   **apellidobre del equipo de script** : nombre de su equipo de script

-   **categoría** : categorías de equipos (puede pertenecer a
    categorías múltiples)

-   **Activar** : activa su equipo

-   **visible** : lo hace visible en el tablero

-   **Objeto padre** : indica el objeto padre al que pertenece
    equipo

-   **Autorrealización** : permite especificar un cron de actualización
    automático para todos los comandos de tipo de información.

A continuación encontrará la lista de pedidos. :

-   **apellido** : Este campo contiene el nombre que desea dar a
    su pedido / información.

-   **icono** : Este campo le permite asociar un icono con su nombre (en
    este caso Jeedom reemplaza el nombre con el ícono en el tablero).

-   **puntao de script** :

    -   El tipo http : permite enviar una solicitud a un dispositivo
        externo sin necesariamente esperar el regreso de este comando.
        El ejemplo que servirá de soporte para el tipo http será el
        configuración de una solicitud a un Vera para encender
        una luz.

    -   El tipo de script : utilizado principalmente para ejecutar scripts
        interno a Jeedom. El ejemplo que admitirá el tipo
        el script será la configuración del script de monitoreo de temperatura
        frambuesa disponible en el mercado.

    -   puntao XML : permite recuperar información codificada en
        XML desde equipos remotos. El ejemplo que servirá como
        El soporte de tipo XML será la configuración del script para
        interrogar un dispositivo ecológico.

    -   El tipo JSON : permite recuperar información codificada en
        JSON desde un dispositivo remoto. El ejemplo que servirá como
        la compatibilidad con el tipo JSON será la configuración del script para
        interrogar a Sickbeard (o XBMC).

-   **el tipo** y el **subtipo**

-   El campo **petición**

    -   Este campo debe contener la consulta en sí o la ruta de acceso de
        script si el campo &quot;tipo de script&quot; es script. El botón
        "recorrer" : le permite seleccionar el archivo contenido en el
        archivo interno en Jeedom.

        > **punta**
        >
        > Este archivo es accesible en SSH
        > en / usr / share / nginx / www / jeedom / plugins / script / core / recursos /.
        > FYI, el comando SSH para asignar derechos de datos www
        > a un archivo es : vestido de sudo
        > www-datos:www-datos NOMDUSCRIPT.EXTENSION. Tenga en cuenta que para
        > ejecutar un script, debe tener derechos de www-datos.

    -   El botón **editar** : le permite editar usando un editor
        código interno uno de los archivos contenidos en el directorio
        permitiendo el acceso al código del archivo.

    -   El botón **nuevo** : permite crear un archivo de comando.

        > **punta**
        >
        > No olvide ingresar el nombre del archivo, así como su
        > extensión completa bajo pena de ver su excelente script no
        > no trabajo. Sin extensión, Jeedom no sabrá
        > reconocer el idioma asociado con su archivo. CF :
        > generalidad

    -   El botón **remove** : permite eliminar un archivo
        de encargo.

    -   El botón **Compartir, repartir** : uno de los más importantes, y después
        validado los desarrolladores de CGU en su perfil en el mercado,
        le permite compartir su creación con la comunidad.

-   El campo **opciones** : Campo con opciones variables dependiendo de la elección.
    tipo de script.

-   **unidad** : unidad de datos (puede estar vacía).

-   **min / max** : límites de datos (pueden estar vacíos).

-   **historizar** : permite historizar los datos.

-   **visualización** : permite mostrar los datos en el tablero.

-   **evento** : volver en caso de eventos. En el caso de RFXcom
    esta casilla siempre debe estar marcada porque no puede consultar
    un módulo RFXcom.

-   **Permitir memcache** : permite a Jeedom usar caché para
    valor (predeterminado 5 min) antes de volver a ejecutar el script para tener que
    nuevo valor.

-   **Caché de por vida** : permite modificar la vida útil del caché
    (predeterminado 5 min).

> **importante**
>
> Evite tanto como sea posible en la ruta del script o en
> los parámetros de sus caracteres especiales. Los caracteres
> ser permitido : números, letras (mayúsculas o minúsculas)

![script5] (../ images / script5.PNG)

Le permite llamar a una url o recuperar el retorno de una URL.

-   una casilla de verificación &quot;No marque SSL" : si está marcado, permite Jeedom
    no enviar los campos &quot;Usuario&quot; y &quot;Contraseña&quot; a
    la solicitud. Jeedom no buscará identificarse con
    sitio remoto / máquina.

-   una casilla de verificación &quot;Permitir respuesta en blanco" : si está marcado, permite
    Jeedom no esperar una respuesta, o ignorar cualquier respuesta a
    la trama transmitida. En general, verificamos si Jeedom nos envía un &quot;Curl
    error : Respuesta vacía del servidor".

-   una casilla de verificación &quot;Nunca informar errores" : no lo hagamos
    no levantar una alerta en caso de error.

-   un campo de tiempo de espera" : sin ser informado, el tiempo de espera de la solicitud
    el valor predeterminado es 2 segundos, de lo contrario, vale el valor ingresado.

-   un campo &quot;Pruebas máximas" : Máximo 4 pruebas por defecto.

-   un campo &quot;Usuario&quot;" : para ingresar un nombre de usuario.

-   un campo &quot;Contraseña&quot;" : para ingresar una contraseña.

La elección de HTML 
=============

![script8] (../ images / script8.PNG)

Analiza una página web (archivo HTML) para recuperar un valor
anteriormente. La sintaxis es la misma que para jquery.

El campo de opción tiene un campo &quot;URL de archivo HTML&quot;" : este campo
por lo tanto contiene el enlace a la máquina que aloja el archivo HTML en
pregunta.

La elección XML 
============

![script6] (../ images / script6.PNG)

Le permite recuperar xml y buscar específicamente un valor
en.

El campo de opción tiene un campo &quot;URL del archivo XML&quot;" : este campo
por lo tanto contiene el enlace a la máquina que aloja el archivo XML en
pregunta.

> **importante**
>
> Solo es posible recuperar valores, los atributos no
> puede ser recuperado.

La elección de JSON 
=============

![script7] (../ images / script7.PNG)

Permite recuperar json y buscar específicamente un
valor en.

El campo de opción tiene un campo &quot;URL de archivo JSON&quot;" : este campo
por lo tanto contiene el enlace a la máquina que aloja el archivo JSON en
pregunta.

Ejemplo HTTP : Pilotando una Vera 
==================================

El ejemplo se basa en una Vera y consiste en conducir una bombilla.
regulable. No me detendré en cómo conducir un Vera
por solicitud http, el foro de TLD está lleno de respuestas. De más,
el ejemplo corresponde a mi tipo de material y tendrá que adaptarse a
suyo.

> **punta**
>
> Un método para quienes buscan a tientas escribir solicitudes http,
> primero valide la sintaxis en su navegador y solo entonces
> ir a la configuración bajo Jeedom. Cuando un script de acción no lo hace
> no funciona, cambiar a Info / Otro script le permite ver el error
> devuelto.

Vamos a ir :

-   Creamos equipos : por ejemplo, LUM COISINE (creo que tenemos
    toda una cocina a mano)

-   Lo asociamos con un objeto padre : por ejemplo VERA, me permite
    centralice todos los pedidos relacionados con VERA en un
    padre soltero.

-   Elige tu categoría.

-   Active su equipo, no verifique visible, veremos un poco
    más tarde cómo asociarlo con uno virtual (más sexy, más WAF)

-   Para la actualización automática, no coloque nada, es un comando
    impulso vinculado a presionar un botón o un escenario !

-   Agregar un comando de script

-   Recuerda guardar

explicaciones :

-   apellido : 100% porque prenderemos una luz a plena potencia

-   puntao de script : http

-   tipo : Acción (es una orden)

-   Subtipo : culpa

-   petición :

<!-- -->

    http:// <IP_VERA>:3480 / datos_request?id = y lu_action output_format json = &amp; = 12 y DeviceNum serviceId = urna:UPnP-org:serviceId:Dimming1 &amp; acción = SetLoadLevelTarget y newLoadlevelTarget = 100

> **punta**
>
> el &quot;100&quot; al final de la solicitud corresponde al porcentaje de potencia
> para asignar, así que ponga &quot;0&quot; al final de la solicitud corresponde a
> apaga la bombilla.

El botón &quot;probar&quot; le permite probar su pedido !

Por lo tanto, puede multiplicar pedidos en el mismo equipo por
por ejemplo, al hacer un pedido del 60% para una luz tenue, cree
un tercio al 30% para viajes nocturnos que se combinarán en un
escenario, ...

También es posible crear un comando de tipo deslizador colocando el
etiqueta \ #slider \ # en la solicitud :

    http:// <IP_VERA>:3480 / datos_request?id = y lu_action output_format json = &amp; = 12 y DeviceNum serviceId = urna:UPnP-org:serviceId:Dimming1&action=SetLoadLevelTarget&newLoadlevelTarget=#slider#

> **punta**
>
> Si su orden es del tipo de mensaje, puede usar etiquetas
> \ #mensaje \ # y \ #title \ #, lo mismo para un pedido de color con
> la etiqueta \ #color \ #, o de tipo deslizador con # deslizador # o lista con #seleccionar#

Ejemplo HTTP : Enviar notificación a XBMC 
==============================================

Objetivo : Enviar notificación a XBMC al abrir una puerta
entrada.

-   apellido : EMPUJE XBMC

-   puntao de script : http

-   tipo : Acción (es una orden)

-   subtipo : culpa

-   petición :

<!-- -->

    http:// IP_DE_XBMC:8080 / JSONRPC?solicitud = {% 22jsonrpc% 22:% 2220% 22% 22% 22method:22GUI%.ShowNotification% 22% 22% 22params:{ % 22title 22%:% 22Mouvement% 20Detecté% 22% 22% 22mensaje:% 22Porte 20Entrée% 22%},% 22% 22id:1}

Depende de usted probar esto en un escenario, por ejemplo !

API XBMC [aquí] (http://wiki.xbmc.org/index.php?title = JSON-RPC_API / v6)
(solo los campos marcados como &quot;obligatorios&quot; son obligatorios)

Objetivo : Enviar una notificación a XBMC cuando la temperatura baje
debajo de cierto umbral

Toma el ejemplo de arriba :

-   reemplace &quot;Movimiento% 20Detectado&quot; con &quot;Riesgo% 20de% 20gel"

-   reemplazar &quot;Porte% 20Entrée&quot; por
    "Temperatura %% 20 20extérieur:% 20 \ # \ [EXTERIOR \] \ [EXTERIOR \] \ [TEMPERATURA \] \% # 20"

Testez sur un scénario *\[EXTERIEUR\]\[EXTERIEUR\]\[TEMPERATURE\]* &lt;
15 por ejemplo

acción : Inicie el script, a través de un equipo virtual, vinculado a su script
!

Ejemplo SCRIPT 
==============

El más bonito pero no el más fácil de explicar..

Requisitos previos : saber desarrollar un script en php, python o ruby.

>**IMPORTANTE**
>
> La extensión de su script debe coincidir absolutamente con su tipo. ex .php para un tipo php. De hecho, Jeedom se basa en la extensión del script para que se ejecute el ejecutable (php if .php, python si .py ....)

El script de monitoreo de temperatura de frambuesa servirá como ejemplo
para usar el tipo de script : guión

Después de descargar el script del mercado, el botón &quot;examinar&quot;"
le permite seleccionar el archivo temp \ _rasp.php.

Por curiosidad, puede ir y ver el contenido del archivo presionando
en el botón &quot;Editar&quot;, debería obtener el siguiente código :

Este es un script php que se puede reutilizar fuera de Jeedom !

     <?php
        $ temp = shell_exec (&quot;cat / sys / class / thermal / thermal_zone0 / temp&quot;);
        $ temp = $ temp / 1000;
        $ temp = round ($ temp, 1);
        echo $ temp
     ?>

nota : concretamente, es la función php &quot;echo&quot; la que le dará al
valor para Jeedom

Los parámetros 
--------------

Obtenga la información de Jeedom para usarla en un script. la
la recuperación depende del tipo de script utilizado :

ejemplo :

-   En la linea :
    /usr/share/nginx/www/jeedom/plugins/script/core/ressources/MON\_SCRIPT\_PHP.php
    lista, el argumento &quot;lista&quot; es una cadena de caracteres (fija)
    recuperado del script php usando la siguiente función
    \ $ argv \ [1 \] cf. : Google para más detalles sobre la recuperación
    parámetros en PHP.

-   Anteriormente hemos visto que era posible recuperar
    valores dinámicos de Jeedom.

-   En la linea :
    /usr/share/nginx/www/jeedom/plugins/script/core/ressources/radio.py
    VOL * slider *, el argumento &quot;* slider *&quot; se recupera de este
    argv \ [2 \]. Cuando jeedom ejecuta el script,
    reemplazará automáticamente * deslizador * con el valor (numérico)
    control deslizante. cf. : Google para más detalles sobre la recuperación
    parámetros en Python.

-   Más fuerte : Potencialmente, todas las variables accesibles por
    Jeedom puede ser utilizado por el complemento de script :

    -   Desea recuperar el valor de la temperatura de la cocina.
        para historizarlo fuera de Jeedom ?

    -   Pase * \ [COCINA \] \ [COCINA \] \ [Temperatura \] * como parámetro
        al script y Jeedom lo reemplazará con el valor leído durante
        del envío.

Recomendación para probar los parámetros en el script php :

     if (isset ($ argv)) {
     foreach ($ argv como $ arg) {
     $ argList = explotar (&#39;=&#39;, $ arg);
     if (isset ($ argList [0]) &amp;&amp; isset ($ argList [1])) {
     $ _GET [$ argList [0]] = $ argList [1];
             }
         }
     }

Ejemplo XML simple 
==================

Aquí está el formato del xml estándar :

    <root>
        <led0>1</led0>
        <leds>
          <led1>toto</led1>
        </leds>
    </root>

Si desea el valor de led0 en la consulta, coloque led0. si
quieres el valor de led1 que es el hijo de leds que pones
leds &gt; led1.

notaz que l'élément racine &lt;root&gt; n'est pas à préciser dans le
campo de solicitud.

Ejemplo complejo de XML 
====================

     <root>
       <led0>1</led0>
       <leds>
         <led1>toto</led1>
       </leds>
       <leds>
         <led1>tata</led1>
       </leds>
     </root>

la sintaxis es :

leds &gt; 1 &gt; led1 qui donne en réponse tata, 1 étant le numéro de
fila de matriz !

Ejemplo XML más complejo 
=========================

    <AKT_Data ID="SMS-Liste" ZeitSt="01.05.2017 18:55">
     <MesPar DH="HBCHa" StrNr="2167" Typ="02" Var="02">
       <Name>Tresa - Ponte Tresa, Rocchetta</Name>
       <Datum>01.05.2017</Datum>
       <Zeit>18:50 </Zeit>
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
      <Zeit>18:50 </Zeit>
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
      <Zeit>18:00 </Zeit>
      <Wert>500.65</Wert>
      <Wert dt="-24h">500.65</Wert>
      <Wert Typ="delta24">0.000</Wert>
      <Wert Typ="m24">500.65</Wert>
      <Wert Typ="max24">500.65</Wert>
      <Wert Typ="min24">500.64</Wert>
     </MesPar>
    </AKT_Data>

Para recuperar información del campo Wert del primer bloque:

    MesPar&gt; 0&gt; Wert&gt; 0 que por lo tanto devuelve &quot;268.56 "

Para devolver el siguiente elemento en la &quot;estructura&quot; de Wert, debe
simplemente indique el número de orden en la estructura. Que da
pour l'élément '&lt;Wert Typ="delta24"&gt;0.051&lt;/Wert&gt;' le code
Próximo :

    MesPar&gt; 1&gt; Wert&gt; 2

Para pasar al siguiente bloque &quot;MyPar&quot;, debe cambiar el índice a
resultarar : el 1 por 2 por ejemplo.

ATENCIÓN : Si en el archivo XML el orden cambia, la solicitud no cambia
trabaja más. Será necesario reajustar la solicitud según el pedido.
devuelto.

Ejemplo JSON 
============

Al igual que el tipo XML, es posible leer información de
un regreso JSON.

Para explicar, me basaré en información JSON con
la aplicación Sickbeard (boo ... cpasbien) pero aquí solo la técnica
premium, no la herramienta !

El acceso a este archivo es posible utilizando la siguiente URL :

    http:// <IP_DELAMACHINEQUIEBERGESICKBEARD>:8083 / api / XXXX /?cmd = Historia y límite = 3

NOTA : XXXX es el número de clave API específico de cada SICKBEARD.

En primer lugar, antes de iniciar la configuración del complemento de script
JSON, se trata de identificar correctamente la información para recuperar.porque
aquí integraremos una noción de matriz en los retornos.

Valide la visualización de información desde su navegador (prueba
bajo Chrome).

Ejemplo de devolución :

     {
         "datos": [
             {
                 "fecha": "2014-09-10 01:37 &quot;
                 "episodio": 4
                 "proveedor": "NTR &quot;
                 "calidad": "SD TV &quot;,
                 "recurso": "XXX",
                 "recurso_path": "XXXX",
                 "temporada": 2
                 "SHOW_NAME": "Totovaalaplage S2E4 &quot;,
                 "estatus": "descargado &quot;
                 "tvdbid": XXXXX
             },
             {
                 "fecha": "2014-09-10 01:36 &quot;
                 "episodio": 3
                 "proveedor": "NTR &quot;
                 "calidad": "SD TV &quot;,
                 "recurso": "XXXX",
                 "recurso_path": "XXX",
                 "temporada": 2
                 "SHOW_NAME": "Totovaalaplage S2E3 &quot;,
                 "estatus": "descargado &quot;
                 "tvdbid": XXXXX
             },
             {
                 "fecha": "2014-09-10 01:21 &quot;
                 "episodio": 1
                 "proveedor": "Cpasbien &quot;
                 "calidad": "SD TV &quot;,
                 "recurso": "XXXX",
                 "recurso_path": "XXXX",
                 "temporada": 1
     AQUÍ -&gt; &quot;SHOW_NAME": "Totovaplusauski pero Totovaalaplage S1E1 &quot;,
                 "estatus": "arrebatado &quot;
                 "tvdbid": XXXX
             }
         ],
         "mensaje": "",
         "resultar": "éxito"
     }

En el caso de que nos gustaría devolver el show \ _name del 3er
elemento en php (marcado AQUÍ), sería necesario hacer : datos &gt; 2
&gt;show \ _name, el índice de matriz de retorno que comienza en Cero.

En este ejemplo, el botón &quot;Prueba&quot; devolverá &quot;Totovaplusauski
pero Totovaalaplage S1E1".

aclaraciones :

Tenga en cuenta la sintaxis del comando Solicitud, es de tipo element0 &gt;
index du tableau &gt; élément1

desventajas :

-   este método solo permite recuperar un elemento a la vez.

-   Si queremos devolver todos los valores de &quot;show \ _name&quot;, esto
    desafortunadamente no es posible, tendrás que duplicar el script
    tantas veces como sea necesario.

Ejemplo HTML 
============

Aquí intentaremos recuperar el último FML.

Primero que nada tienes que configurar la url :

    http://www.viedemerde.fr

Entonces tienes que encontrar el &quot;camino&quot; de la última FML. Para hacer esto,
tienes que ir al sitio y luego hacer clic derecho en el elemento deseado y luego
inspeccionar el artículo, obtenemos :

![script9] (../ images / script9.PNG)

Aquí es la parte más compleja y que requiere un pequeño análisis. aquí
mi texto está en una etiqueta &quot;a&quot; que está en un elemento tipo p
que es una clase div &quot;publicar artículo". Entonces tengo que seleccionar
el primer elemento div de la clase &quot;post&quot; y &quot;artículo&quot; y luego el primer
elemento p y que obtengo todo en las etiquetas &quot;a&quot; que
contiene. Entonces tengo : "div.post.artículo:primero p:primero un".

Entonces obtenemos :

![script10] (../ images / script10.PNG)

Para una actualización en tiempo real, es posible poner un cron
actualizar.

> **punta**
>
> Al instalar una actualización cron, Jeedom
> marca automáticamente la casilla Evento, esto es completamente normal.

Aquí puedes imaginar un escenario que te envía por SMS
la última FML.
