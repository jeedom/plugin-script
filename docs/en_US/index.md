# Script plugin

Plugin allowing to execute scripts (shell, php, ruby…), http requests, to retrieve information in XML or JSON.

# Plugin configuration

The configuration is very simple, after downloading the plugin, you just need to activate it and that's it.

![configuration](../images/configuration.png)

The only option is where jeedom puts the scripts by default, it is advised not to touch them.

# Equipment configuration

The configuration of Script equipment is accessible from the plugin / Programming menu

This is what the Script plugin page looks like (here already with equipment) :

![liste des équipements](../images/liste_equipement.png)

Here is the list of your Scripts. Once you click on a piece of equipment you get :

![equipement](../images/equipement.png)

Here you find all the configuration of your equipment :

- **Name de l'équipement script** : name of your script equipment
- **Category** : equipment categories (it can belong to several categories)
- **Activate** : makes your equipment active
- **Visible** : makes it visible on the dashboard
- **Parent object** : indicates the parent object to which the equipment belongs
- **Self-actualization** : allows to specify an automatic update cron for all info type commands.
- **Delay before updating the information following an action**

![commandes](../images/commandes.png)
Here you find the list of orders :

-   **Name** : This field contains the name you want to give to your order / information.
-   **Icon** : This field allows you to associate an icon with your name (in this case Jeedom replaces the name with the icon in the dashboard).
-   **Type de script** :
    -   The type **HTTP** : allows sending a request to an external device without necessarily waiting for a return of this command. The example that will serve as support for the http type will be the configuration of a request to a Vera to turn on a light.
    -   The type **script** : mainly used to run internal Jeedom scripts. The example which will serve as support for the script type will be the configuration of the temperature monitoring script of the raspberry.
    -   The type **XML** : allows to retrieve information encoded in XML from a remote device. The example that will serve as support for the XML type will be the configuration of the script to query an Eco-Device.
    -   The type **JSON** : allows to retrieve information encoded in JSON from a remote device. The example that will serve as support for the JSON type will be the configuration of the script to query Sickbeard (or XBMC).
-   **the type** and the **Sub-type**
-   Field **Request**
    -   This field must contain the query itself, or the script path if the "type of script" field is script. The "browse" button" : allows you to select the file contained in the Jeedom internal folder.

        > This file is accessible in SSH in ``/var/www/html/plugins/script/data/``. FYI, the SSH command to assign rights ``www-data`` to a file is : ``sudo chown www-data:www-data NOMDUSCRIPT.EXTENSION``. Note that to execute a script, it must have www-data rights.

    -   The button **Edit** : allows you to edit using an internal code editor one of the files contained in the directory allowing access to the file code.
    -   The button **New** : allows to create a command file.

        > Do not forget to enter the name of the file and its full extension, otherwise your superb script will not work. Without extension Jeedom will not be able to recognize the language associated with your file. CF : Generality
    -   The button **Delete** : allows to delete a command file.
-   Field **Options** : Field with variable options depending on the choice of script type.
-   **Unit** : data unit (can be empty).
-   **min / max** : data bounds (may be empty).
-   **Historize** : allows to historize the data.
-   **Pin up** : allows to display the data on the dashboard.
-   **Event** : return in case of events. In the case of RFXcom this box must always be checked because you cannot interrogate an RFXcom module.
-   **Allow memcache** : allow Jeedom to use cache for the value (default 5 min) before re-executing the script to get the value again.
-   **Lifetime cache** : allows to modify the lifetime of the cache (by default 5 min).

> **Important**
>
> Special characters should be avoided in the script path or in its parameters as much as possible. The allowed characters being : numbers, letters (upper or lower case)

![exemple](../images/exemple.png)

Used to call a url or retrieve the return of a URL.

-   a checkbox "Do not check SSL" : if checked, allows Jeedom not to send the "User" and "Password" fields when requested. Jeedom will not seek to identify itself to the remote site / machine.
-   a checkbox "Allow blank response" : if checked, allows Jeedom to not wait for a response, or to ignore any response to the transmitted frame. In general, we check if Jeedom returns a "Curl error" : Empty reply from server".
-   a check box "Never report errors" : allows not raising an alert in case of error.
-   a timeout field" : without being entered, the timeout of the request is by default 2 seconds, otherwise it is worth the entered value.
-   a field "Maximum trials" : Maximum 4 tests by default.
-   a "User" field" : to enter a username.
-   a "Password" field" : to enter a password.

# The HTML choice

![script HTML](../images/script_html.png)

Allows you to pass a web page (HTML file) to retrieve a value above. The syntax is the same as for jquery.

The option field has a "HTML file URL" field" : this field therefore contains the link to the machine hosting the HTML file in question.

# The XML choice

![script XML](../images/script_xml.png)

Allows you to recover xml and specifically look for a value in it.

The option field has a "URL of the XML file" field" : this field therefore contains the link to the machine hosting the XML file in question.

> **Important**
>
> Only values can be retrieved, attributes cannot be retrieved.

# The JSON choice

![script JSON](../images/script_json.png)

Allows to recover json and to specifically look for a value in it.

The option field has a "JSON file URL" field" : this field therefore contains the link to the machine hosting the JSON file in question.

# HTTP example : Piloting a Vera

The example is based on a Vera and consists of driving a dimmable bulb. I'm not going to dwell on how to control a Vera by http request, the TLD forum is full of answers. In addition, the example corresponds to my type of material and will have to be adapted to yours.

> **Tip**
>
> A method for those who grope for writing http requests, first validate the syntax in your browser and only then go to the configuration under Jeedom. When an Action script does not work, switching to the Info / Other script allows you to see the error returned.

Let&#39;s go :

-   We create equipment : for example LUM KITCHEN (I think we all have a kitchen on hand)
-   We associate it with a parent object : for example VERA, it allows me to centralize all orders related to VERA on a single parent.
-   Choose your category.
-   Activate your equipment, do not check visible, we will see a little later how to associate it with a virtual one (sexier, more WAF)
-   For self-updating, do not put anything, it is an impulse command linked to a press of a button or a scenario !
-   Add a script command
-   Remember to save

Explanations :

-   Name : 100% because we will turn on a light at full power
-   Script type : http
-   Type : Action (it&#39;s an order)
-   Sub type : Default
-   Request :

````
http://<IP_VERA>:3480/data_request?id=lu_action&output_format=json&DeviceNum=12&serviceId=urn:upnp-org:serviceId:Dimming1&action=SetLoadLevelTarget&newLoadlevelTarget=100
````

> **Tip**
>
> the "100" at the end of the request corresponds to the percentage of power to be assigned so putting "0" at the end of the request corresponds to switching off the bulb.

The "test" button allows you to test your order !

You can therefore multiply orders in the same equipment, for example by placing an order at 60% for dim light, creating a third at 30% for night trips to be combined in a scenario, etc

It is also possible to create a slider type command by putting the tag \#slider\# in the request :

````
http://<IP_VERA>:3480/data_request?id=lu_action&output_format=json&DeviceNum=12&serviceId=urn:upnp-org:serviceId:Dimming1&action=SetLoadLevelTarget&newLoadlevelTarget=#slider#
````

> **Tip**
>
> If your order is of message type you can use the tags \#message\# and \#title\#, ditto for a color order with the tag \#color\#, or slider type with #slider# or list with #select#

# HTTP example : Send notification to XBMC

Goal : Send a notification to XBMC when opening a front door.

-   Name : PUSH XBMC
-   Script type : http
-   Type : Action (it&#39;s an order)
-   Sub-type : Default
-   Request :

````
http://IP_DE_XBMC:8080/jsonrpc?request={ %22jsonrpc%22:%222.0%22,%22method%22:%22GUI.ShowNotification%22,%22params%22:{ %22title%22:%22Mouvement% 20Detecté%22,%22message%22:%22Porte% 20Entrée%22},%22id%22:1}
````

It&#39;s up to you to test this in a scenario for example !

XBMC API [here](http://wiki.xbmc.org/index.php?title=JSON-RPC_API/v6) (only the fields marked "required" are compulsory)

Goal : Send a notification to XBMC when the temperature drops below a certain threshold

Take the example above :

-   replace "Movement% 20Detected" with "Risk% 20of% 20gel"
-   replace "Door% 20Entrance" by "Temperature% 20exterior% 20:% 20 \#\ [OUTSIDE \] \ [OUTSIDE \] \ [TEMPERATURE \]\#% 20"

Test on a scenario *\ [OUTSIDE \] \ [OUTSIDE \] \ [TEMPERATURE \]* &lt; 15 par exemple

Action : Launch the script, via virtual equipment, linked to your script !

# SCRIPT example

The nicest but not the easiest to explain.

Prerequisites : know how to develop a script in php, python or ruby.

>**Important**
>
> The extension of your script must absolutely match its type. Ex .php for a php type. Indeed Jeedom is based on the extension of the script for the executable to launch (php if .php, python if .py ....)

The Raspberry temperature monitoring script will serve as an example for using the script type : Script

After downloading the script, the "Browse" button allows you to select the temp\_rasp.php file.

Out of curiosity, you can go and see the contents of the file by pressing the "Edit" button, you should get the following code :

This is a php script that can be reused outside Jeedom !

````
 <?php
    $temp = shell_exec("cat /sys/class/thermal/thermal_zone0/temp");
    $temp = $temp / 1000;
    $temp = round($temp,1);
    echo $temp
 ?>
 ````

NOTE : concretely, it is the php "echo" function which will give the value to Jeedom

## The settings

Get Jeedom's info to use it in a script. Recovery depends on the type of script used :

-   In the line : ``/usr/share/nginx/www/jeedom/plugins/script/data/MON\_SCRIPT\_PHP.php`` list, the argument "list" is a character string (fixed) retrieved in the php script using the following function \ $ argv \ [1 \] cf : Google for more details on retrieving settings in PHP.
-   We saw previously that it was possible to retrieve dynamic values from Jeedom.
-   In the line : ``/usr/share/nginx/www/jeedom/plugins/script/data/radio.py`` FLIGHT *slider* , the argument "*slider*" is retrieved this way argv \ [2 \]. When the script is run by jeedom, it will automatically replace *slider* by the value (numeric) of the slider. CF : Google for more details on retrieving settings in Python.

-   Stronger : Potentially, all the variables accessible by Jeedom can be used by the script plugin :
    -   You want to recover the value of the kitchen temperature to store it outside of Jeedom ?
    -   Pass *\ [KITCHEN \] \ [KITCHEN \] \ [Temperature \]* as a parameter to the script and Jeedom will replace it with the value read when sending.

Recommendation to test the parameters in the php script :

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

# Simple XML example

Here is the format of the standard xml :

````
<root>
    <led0>1</led0>
    <leds>
      <led1>toto</led1>
    </leds>
</root>
````

If you want the value of led0 in query you put led0. Si vous voulez la valeur de la led1 qui est le fils de leds vous mettez leds &gt; led1.

Notez que l'élément racine &lt;root&gt; n'est pas à préciser dans le champ Request.

# Complex XML example

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

The syntax is :

leds &gt; 1 &gt; led1 qui donne en réponse tata, 1 étant le numéro de rang du tableau !

# More complex XML example

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

To retrieve information from the Wert field of the 1st block:

``MesPar>0>Wert>0 qui retourne donc "268.56 "``

To return the next element in the Wert "structure", you just have to indicate the order number in the structure. Ce qui donne pour l'élément '&lt;Wert Typ="delta24"&gt;0.051&lt;/Wert&gt;' le code suivant :

``MesPar>1>Wert>2``

To move to the next "MyPar" block, you must therefore change the index accordingly : the 1 by 2, for example.

Be careful : If the order changes in the XML file, the request no longer works. It will be necessary to readjust the request according to the returned order.

# JSON example

Like the XML type, it is possible to read information from a JSON return.

To explain, I am going to base myself on JSON information with the Sickbeard application (bouh… cpasbien) but here only the technique is prime, not the tool !

Access to this file is possible using the following URL :

``http://<IP_DELAMACHINEQUIEBERGESICKBEARD>:8083/api/XXXX/?cmd=history&limit=3``

NOTE : XXXX is the API key number specific to each SICKBEARD.

First of all, before launching into the configuration of the JSON script plugin, it is a question of correctly identifying the infos to recover., because here we are going to integrate a notion of array in the returns.

Validate the display of information from your browser (test in Chrome).

Example of return :

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

In the hypothesis where we would like to return the show\_name of the 3rd element in php (marked HERE), we would have to do : data> 2> show\_name, the return array index starting at Zero.

In this example, the "Test" button will return "Totovaplusauski but Totovaalaplage S1E1".

Clarifications :

Note the syntax of the Query command, it is of type element0> array index> element1

Disadvantages :

-   this method only allows to recover one element at a time.
-   If you want to return all the values of "show\_name", this is unfortunately not possible, you will have to duplicate the script as many times as necessary.

# HTML example

Here we will try to retrieve the last FML.

First you need to configure the url :

``http://www.viedemerde.fr``

Then you have to find the "path" of the last FML. To do this, go to the site then right click on the desired item then inspect the item, you get :

![Exemple HTML 1](../images/exemple_HTML_1.png)

This is the most complex part and requires a little analysis. Here my text is in an "a" tag which is in a p type element which is a class div "post article". So I have to select the first div element of class "post" and "article" then the first element p and I get everything in the "a" tags it contains. So I have : "div.post.article:first p:first a".

So we get :

![Exemple HTML 2](../images/exemple_HTML_2.PNG)

For an update in real time, it is possible to put an update cron.

> **Tip**
>
> When installing an update cron, Jeedom will automatically check the Event box, this is completely normal.

Here then you can imagine a scenario which sends you by SMS the last FML.
