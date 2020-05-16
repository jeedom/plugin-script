# Complemento de script

Complemento que permite ejecutar scripts (shell, php, ruby ...), solicitudes http, para recuperar información en XML o JSON.

# Configuración del plugin

La configuración es muy simple, después de descargar el complemento, solo necesita activarlo y listo.

![configuration](../images/configuration.png)

La única opción es donde jeedom pone los scripts por defecto, se recomienda no tocarlos.

# Configuración del equipo

Se puede acceder a la configuración del equipo Script desde el menú de complementos / Programación

Así es como se ve la página del complemento Script (aquí ya con el equipo) :

![liste des équipements](../images/liste_equipement.png)

Aquí está la lista de sus guiones. Una vez que haces clic en un equipo, obtienes :

![equipement](../images/equipement.png)

Aquí encontrarás toda la configuración de tu equipo :

- **Nombre de l'équipement Guión** : nombre de su equipo de script
- **Categoría** : categorías de equipos (puede pertenecer a varias categorías)
- **Activar** : activa su equipo
- **Visible** : lo hace visible en el tablero
- **Objeto padre** : indica el objeto padre al que pertenece el equipo
- **Autorrealización** : permite especificar un cron de actualización automática para todos los comandos de tipo de información.
- **Demora antes de actualizar la información después de una acción**

![commandes](../images/commandes.png)
Aquí encontrarás la lista de pedidos :

-   **Nombre** : Este campo contiene el nombre que desea dar a su pedido / información.
-   **Icono** : Este campo le permite asociar un icono con su nombre (en este caso, Jeedom reemplaza el nombre con el icono en el tablero).
-   **Tipo de Guión** :
    -   El tipo **Http** : permite enviar una solicitud a un dispositivo externo sin esperar necesariamente la devolución de este comando. El ejemplo que servirá como soporte para el tipo http será la configuración de una solicitud a un Vera para encender una luz.
    -   El tipo **Guión** : se usa principalmente para ejecutar scripts internos de Jeedom. El ejemplo que servirá como soporte para el tipo de script será la configuración del script de monitoreo de temperatura de la frambuesa.
    -   El tipo **XML** : permite recuperar información codificada en XML desde un dispositivo remoto. El ejemplo que servirá como soporte para el tipo XML será la configuración del script para consultar un Eco-Device.
    -   El tipo **JSON** : permite recuperar información codificada en JSON desde un dispositivo remoto. El ejemplo que servirá de soporte para el tipo JSON será la configuración del script para consultar Sickbeard (o XBMC).
-   **el tipo** y el **Sub-tipo**
-   El campo **Petición**
    -   Este campo debe contener la consulta o la ruta del script si el campo "tipo de script" es script. El botón "navegar"" : le permite seleccionar el archivo contenido en la carpeta interna de Jeedom.

        > Este archivo es accesible en SSH en ``/var/www/html/plugins/script/data/``. FYI, el comando SSH para asignar derechos ``www-data`` a un archivo es : ``sudo chown www-data:www-data NOMDUSCRIPT.EXTENSION``. Tenga en cuenta que para ejecutar un script, debe tener derechos de www-data.

    -   El botón **Editar** : le permite editar usando un editor de código interno uno de los archivos contenidos en el directorio que le permite acceder al código del archivo.
    -   El botón **Nuevo** : permite crear un archivo de comando.

        > No olvide ingresar el nombre del archivo y su extensión completa, de lo contrario su excelente script no funcionará. Sin extensión, Jeedom no podrá reconocer el idioma asociado con su archivo. CF : Generalidad
    -   El botón **Borrar** : permite eliminar un archivo de comando.
-   El campo **Opciones** : Campo con opciones variables según la elección del tipo de script.
-   **Unidad** : unidad de datos (puede estar vacía).
-   **min / max** : límites de datos (pueden estar vacíos).
-   **Guardar historial** : permite historizar los datos.
-   **Mostrar** : permite mostrar los datos en el tablero.
-   **Evento** : volver en caso de eventos. En el caso de RFXcom, esta casilla siempre debe estar marcada porque no puede interrogar a un módulo RFXcom.
-   **Permitir memcache** : permitir que Jeedom use caché para el valor (predeterminado 5 min) antes de volver a ejecutar el script para obtener el valor nuevamente.
-   **Caché de por vida** : permite modificar la vida útil del caché (por defecto 5 min).

> **Importante**
>
> Se deben evitar los caracteres especiales en la ruta del script o en sus parámetros tanto como sea posible. Los caracteres permitidos son : números, letras (mayúsculas o minúsculas)

![exemple](../images/exemple.png)

Se usa para llamar a una URL o recuperar el retorno de una URL.

-   una casilla de verificación "No marque SSL" : si está marcada, permite que Jeedom no envíe los campos "Usuario" y "Contraseña" cuando se le solicite. Jeedom no buscará identificarse con el sitio / máquina remota.
-   una casilla de verificación "Permitir respuesta en blanco" : si está marcado, permite a Jeedom no esperar una respuesta o ignorar cualquier respuesta a la trama transmitida. En general, verificamos si Jeedom devuelve un "error de curvatura" : Respuesta vacía del servidor".
-   una casilla de verificación "Nunca informar errores" : permite no generar una alerta en caso de error.
-   un campo de tiempo de espera" : sin ser ingresado, el tiempo de espera de la solicitud es por defecto 2 segundos, de lo contrario, vale el valor ingresado.
-   un campo "Pruebas máximas" : Máximo 4 pruebas por defecto.
-   un campo "Usuario"" : para ingresar un nombre de usuario.
-   un campo "Contraseña"" : para ingresar una contraseña.

# La elección de HTML

![Guión HTML](../images/script_html.png)

Le permite pasar una página web (archivo HTML) para recuperar un valor anterior. La sintaxis es la misma que para jquery.

El campo de opción tiene un campo "URL de archivo HTML"" : Por lo tanto, este campo contiene el enlace a la máquina que aloja el archivo HTML en cuestión.

# La elección XML

![Guión XML](../images/script_xml.png)

Le permite recuperar xml y buscar específicamente un valor en él.

El campo de opción tiene un campo "URL del archivo XML"" : este campo contiene el enlace a la máquina que aloja el archivo XML en cuestión.

> **Importante**
>
> Solo se pueden recuperar los valores, no se pueden recuperar los atributos.

# La elección de JSON

![Guión JSON](../images/script_json.PNG)

Permite recuperar json y buscar específicamente un valor en él.

El campo de opción tiene un campo "URL de archivo JSON"" : este campo, por lo tanto, contiene el enlace a la máquina que aloja el archivo JSON en cuestión.

# Ejemplo HTTP : Pilotando una Vera

El ejemplo se basa en una Vera y consiste en conducir una bombilla regulable. No me detendré en cómo controlar una Vera por solicitud http, el foro de TLD está lleno de respuestas. Además, el ejemplo corresponde a mi tipo de material y tendrá que adaptarse al suyo.

> **Punta**
>
> Un método para quienes buscan a tientas escribir solicitudes http, primero valide la sintaxis en su navegador y solo luego vaya a la configuración en Jeedom. Cuando una secuencia de comandos de Acción no funciona, cambiar a la secuencia de comandos Información / Otro le permite ver el error devuelto.

Vamos a ir :

-   Creamos equipos : por ejemplo COCINA LUM (creo que todos tenemos una cocina a mano)
-   Lo asociamos con un objeto padre : por ejemplo VERA, me permite centralizar todos los pedidos relacionados con VERA en un solo padre.
-   Elige tu categoría.
-   Active su equipo, no verifique lo visible, veremos un poco más tarde cómo asociarlo con uno virtual (más sexy, más WAF)
-   Para la actualización automática, no coloque nada, es un comando de impulso vinculado a presionar un botón o un escenario !
-   Agregar un comando de script
-   Recuerda guardar

Explicaciones :

-   Nombre : 100% porque prenderemos una luz a plena potencia
-   Tipo de script : http
-   Tipo : Acción (es una orden)
-   Subtipo : Por defecto
-   Petición :

````
http://<IP_VERA>:3480/data_request?id=lu_action&output_format=json&DeviceNum=12&serviceId=urn:upnp-org:serviceId:Dimming1&action=SetLoadLevelTarget&newLoadlevelTarget=100
````

> **Punta**
>
> el "100" al final de la solicitud corresponde al porcentaje de potencia que se asignará, por lo que poner "0" al final de la solicitud corresponde a apagar la bombilla.

El botón "probar" le permite probar su pedido !

Por lo tanto, puede multiplicar pedidos en el mismo equipo, por ejemplo, haciendo un pedido al 60% para luz tenue, creando un tercero al 30% para viajes nocturnos que se combinarán en un escenario, etc

También es posible crear un comando de tipo deslizador colocando la etiqueta \#slider\# en la solicitud :

````
http://<IP_VERA>:3480/data_request?id=lu_action&output_format=json&DeviceNum=12&serviceId=urn:upnp-org:serviceId:Dimming1&action=SetLoadLevelTarget&newLoadlevelTarget=#slider#
````

> **Punta**
>
> Si su orden es del tipo de mensaje, puede usar las etiquetas \#message\# y \#title\#, lo mismo para un orden de color con la etiqueta \#color\#, o tipo deslizante con #slider# o lista con #select#

# Ejemplo HTTP : Enviar notificación a XBMC

Objetivo : Enviar una notificación a XBMC al abrir una puerta principal.

-   Nombre : EMPUJE XBMC
-   Tipo de script : http
-   Tipo : Acción (es una orden)
-   Sub-tipo : Por defecto
-   Petición :

````
http://IP_DE_XBMC:8080/jsonrpc?request={ %22jsonrpc%22:%222.0%22,%22method%22:%22GUI.ShowNotification%22,%22params%22:{ %22title%22:%22Mouvement% 20Detecté%22,%22message%22:%22Porte% 20Entrée%22},%22id%22:1}
````

Depende de usted probar esto en un escenario, por ejemplo !

API XBMC [aquí](http://wiki.xbmc.org/index.php?title=JSON-RPC_API/v6) (solo los campos marcados como "obligatorios" son obligatorios)

Objetivo : Enviar una notificación a XBMC cuando la temperatura descienda por debajo de cierto umbral

Toma el ejemplo de arriba :

-   reemplace "Movimiento% 20Detectado" con "Riesgo% 20de% 20gel"
-   reemplace "Puerta% 20Entrada" por "Temperatura% 20exterior% 20:% 20 \#\ [FUERA \] \ [FUERA \] \ [TEMPERATURA \]\#% 20"

Prueba en un escenario *\ [FUERA \] \ [FUERA \] \ [TEMPERATURA \]* &lt; 15 par exemple

Acción : Inicie el script, a través de un equipo virtual, vinculado a su script !

# Ejemplo SCRIPT

El más bonito pero no el más fácil de explicar.

Prerrequisitos : saber desarrollar un script en php, python o ruby.

>**Importante**
>
> La extensión de su script debe coincidir absolutamente con su tipo. Ex .php para un tipo php. De hecho, Jeedom se basa en la extensión del script para que se ejecute el ejecutable (php if .php, python si .py ....)

El script de monitoreo de temperatura de Raspberry servirá como un ejemplo para usar el tipo de script : Script

Después de descargar el script, el botón "Examinar" le permite seleccionar el archivo temp\_rasp.php.

Por curiosidad, puede ir y ver el contenido del archivo presionando el botón "Editar", debe obtener el siguiente código :

Este es un script php que se puede reutilizar fuera de Jeedom !

````
 <?php
    $temp = shell_exec("cat /sys/class/thermal/thermal_zone0/temp");
    $temp = $temp / 1000;
    $temp = round($temp,1);
    echo $temp
 ?>
 ````

Nota : concretamente, es la función php "echo" la que le dará el valor a Jeedom

## Los parámetros

Obtenga la información de Jeedom para usarla en un script. La recuperación depende del tipo de script utilizado :

-   En la linea : ``/usr/share/nginx/www/jeedom/plugins/script/data/MON\_SCRIPT\_PHP.php`` list, el argumento "list" es una cadena de caracteres (fija) recuperada en el script php usando la siguiente función \ $ argv \ [1 \] cf : Google para más detalles sobre la recuperación de configuraciones en PHP.
-   Vimos anteriormente que era posible recuperar valores dinámicos de Jeedom.
-   En la linea : ``/usr/share/nginx/www/jeedom/plugins/script/data/radio.py`` VUELO *deslizador* , el argumento "*deslizador*" se recupera de esta manera argv \ [2 \]. Cuando el script es ejecutado por jeedom, reemplazará automáticamente *deslizador* por el valor (numérico) del control deslizante. CF : Google para más detalles sobre la recuperación de configuraciones en Python.

-   Más fuerte : Potencialmente, todas las variables accesibles por Jeedom pueden ser utilizadas por el complemento de script :
    -   Desea recuperar el valor de la temperatura de la cocina para almacenarla fuera de Jeedom ?
    -   Gastar *\ [COCINA \] \ [COCINA \] \ [Temperatura \]* como parámetro para el script y Jeedom lo reemplazará con el valor leído al enviar.

Recomendación para probar los parámetros en el script php :

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

# Ejemplo XML simple

Aquí está el formato del xml estándar :

````
<root>
    <led0>1</led0>
    <leds>
      <led1>toto</led1>
    </leds>
</root>
````

Si desea el valor de led0 en la consulta, coloque led0. Si vous voulez la valeur de la led1 qui est le fils de leds vous mettez leds &gt; led1.

Notez que l'élément racine &lt;root&gt; n'est pas à préciser dans le champ Petición.

# Ejemplo complejo de XML

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

La sintaxis es :

leds &gt; 1 &gt; led1 qui donne en réponse tata, 1 étant le numéro de rang du tableau !

# Ejemplo XML más complejo

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

Para recuperar información del campo Wert del primer bloque:

``MesPar>0>Wert>0 qui retourne donc "268.56 "``

Para devolver el siguiente elemento en la "estructura" de Wert, solo tiene que indicar el número de pedido en la estructura. Ce qui donne pour l'élément '&lt;Wert Typ="delta24"&gt;0.051&lt;/Wert&gt;' le code suivant :

``MesPar>1>Wert>2``

Para pasar al siguiente bloque "MyPar", debe cambiar el índice en consecuencia : el 1 por 2, por ejemplo.

Atención : Si el orden cambia en el archivo XML, la solicitud ya no funciona. Será necesario reajustar la solicitud de acuerdo con el pedido devuelto.

# Ejemplo JSON

Al igual que el tipo XML, es posible leer información de un retorno JSON.

Para explicarlo, me basaré en información JSON con la aplicación Sickbeard (bouh ... cpasbien) pero aquí solo la técnica es primordial, no la herramienta !

El acceso a este archivo es posible utilizando la siguiente URL :

``http://<IP_DELAMACHINEQUIEBERGESICKBEARD>:8083/api/XXXX/?cmd=history&limit=3``

Nota : XXXX es el número de clave API específico de cada SICKBEARD.

En primer lugar, antes de iniciar la configuración del complemento de script JSON, se trata de identificar correctamente la información para recuperar., porque aquí vamos a integrar una noción de matriz en los retornos.

Valide la visualización de información desde su navegador (prueba en Chrome).

Ejemplo de devolución :

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
 ICI -->     "show_name": "Totovaplusauski mais Totovaalaplage S1E1",
             "status": "Snatched",
             "tvdbid": XXXX
         }
     ],
     "message": "",
     "result": "success"
 }
 ````

En la hipótesis en la que nos gustaría devolver el show\_name del tercer elemento en php (marcado AQUÍ), tendríamos que hacer : data> 2> show\_name, el índice de matriz de retorno que comienza en Cero.

En este ejemplo, el botón "Prueba" devolverá "Totovaplusauski pero Totovaalaplage S1E1".

Aclaraciones :

Tenga en cuenta la sintaxis del comando Consulta, es de tipo element0> array index> element1

Desventajas :

-   este método solo permite recuperar un elemento a la vez.
-   Si desea devolver todos los valores de "show\_name", lamentablemente esto no es posible, tendrá que duplicar el script tantas veces como sea necesario.

# Ejemplo HTML

Aquí intentaremos recuperar el último FML.

Primero necesitas configurar la url :

``http://www.viedemerde.fr``

Entonces tienes que encontrar el "camino" de la última FML. Para hacer esto, vaya al sitio, luego haga clic derecho en el elemento deseado y luego inspeccione el elemento, obtendrá :

![Exemple HTML 1](../images/exemple_HTML_1.png)

Esta es la parte más compleja y requiere un pequeño análisis. Aquí mi texto está en una etiqueta "a" que está en un elemento de tipo p que es un artículo de publicación de clase div "". Así que tengo que seleccionar el primer elemento div de la clase "post" y "article", luego el primer elemento p y obtengo todo en las etiquetas "a" que contiene. Entonces tengo : "div.post.article:primero p:primero un".

Entonces obtenemos :

![Exemple HTML 2](../images/exemple_HTML_2.png)

Para una actualización en tiempo real, es posible poner una actualización cron.

> **Punta**
>
> Al instalar un cron de actualización, Jeedom marcará automáticamente la casilla Evento, esto es completamente normal.

Aquí puedes imaginar un escenario que te envía por SMS la última FML.
