
.

Configuração do  
=======================


.

![script1](../images/script1.PNG)


.

 
=============================


 :

![script2](../images/script2.PNG)


 :

![script3](../images/script3.PNG)

. 
 :

![script4](../images/script4.PNG)

> ****
>
> 
> 
> .

 :

-   **** : 

-   **Categoria** : 
    

-   **Ativar** : 

-   **Visivél** : 

-   **Objeto pai** : 
    

-   **** : 
    .

 :

-   **Nome** : 
    .

-   **ícone** : 
    .

-   **** :

    -    : 
        .
        
        
        .

    -    : 
        . 
        
        .

    -    : 
        X. 
        
        .

    -    : 
        . 
        
        .

-   ****  **Subtipo**

-    ****

    -   
        . 
        "" : 
        .

        > ****
        >
        > 
        > .
        > 
        >  : 
        > :. 
        > .

    -    **Editar** : 
        
        .

    -    **Novo** : .

        > ****
        >
        > 
        > 
        > . 
        > .  :
        > 

    -    **Remover** : 
        .

    -    **** : 
        ,
        .

-    **Opções** : 
    .

-   **Unidade** : .

-   **** : .

-   **Historicizar** : .

-   **Display** : .

-   **Evento** : . 
    
    .

-   **** : 
    
    .

-   **** : 
    .

> ****
>
> 
> . 
>  : 

![script5](../images/script5.PNG)

.

-   " : 
    
    . 
    .

-   " : 
    
    . 
    Erro : ".

-   " : 
    .

-   " : 
    .

-   " : .

-   " : .

-   " : .

 
=============

![script8](../images/script8.PNG)


.

" : 

.

 
============

![script6](../images/script6.PNG)


.

" : 

.

> ****
>
> 
> .

 
=============

![script7](../images/script7.PNG)


.

" : 

.

 :  
==================================



. ,

.

> ****
>
> ,
> 
> . 
> 
> .

 :

-    : 
    

-    : 
    
    .

-   .

-   
    

-   
     !

-   

-   

 :

-   Nome : 

-    : 

-   o : 

-    : Falha

-    :

````
://<IP_VERA>:3480/data_request?id=lu_action&output_format=json&DeviceNum=12&serviceId=urn:upnp-org:serviceId:Dimming1&action=SetLoadLevelTarget&newLoadlevelTarget=100
````

> ****
>
> 
> 
> .

 !







 :

````
://<IP_VERA>:3480/data_request?id=lu_action&output_format=json&DeviceNum=12&serviceId=urn:upnp-org:serviceId:Dimming1&action=SetLoadLevelTarget&newLoadlevelTarget=#slider#
````

> ****
>
> 
> 
> #

 :  
==============================================

 : 
.

-   Nome : 

-    : 

-   o : 

-   Subtipo : Falha

-    :

````
://IP_DE_XBMC:8080/jsonrpc?request={ %22jsonrpc%22:%222.0%22,%22method%22:%22GUI.ShowNotification%22,%22params%22:{ %22title%22:%22Mouvement%20Detecté%22,%22message%22:%22Porte%20Entrée%22},%22id%22:1}
````

 !

:?


 : 


 :

-   "

-   
    ":"

Testez sur un scénario *\[EXTERIEUR\]\[EXTERIEUR\]\[TEMPERATURE\]* &lt;


Ação : 
!

 
==============

.

 : .

>****
>
> .  ..  .


 : Escrita

"
.


 :

 !

````
 <?php
    $temp = shell_exec("cat /sys/class/thermal/thermal_zone0/temp");
    $temp = $temp / 1000;
    $temp = round($temp,1);
    echo $temp
 ?>
 ````

 : 


 
--------------


 :

 :

-    :
    
    
    
     : 
    .

-   
    .

-    :
    
    
    ]. 
    
    .  : 
    .

-    : 
     :

    -   
         ?

    -   
        
        .

 :

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

 
==================

 :

````
<root>
    <led0>1</led0>
    <leds>
      <led1>toto</led1>
    </leds>
</root>
````



leds &gt; led1.

z que l'élément racine &lt;root&gt; n'est pas à préciser dans le
.

 
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

 :

leds &gt; 1 &gt; led1 qui donne en réponse tata, 1 étant le numéro de
 !

 
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

:

``MesPar>0>Wert>0 qui retourne donc "268.56 "``


. 
pour l'élément '&lt;Wert Typ="delta24"&gt;0.051&lt;/Wert&gt;' le code
 :

``MesPar>1>Wert>2``


 : .

 : 
. 
.

 
============


.



 !

 :

``://<IP_DELAMACHINEQUIEBERGESICKBEARD>:8083/api/XXXX/?cmd=history&limit=3``

 : XXXX .


., 
.


.

 :

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
 ICI -->     "show_name": "Totovaplusauski ",
             "status": "Snatched",
             "tvdbid": XXXX
         }
     ],
     "message": "",
     "result": "success"
 }
 ````


 : data &gt; 2
&gt;.


".

 :

 &gt;
index du tableau &gt; élément1

 :

-   .

-   
    
    .

 
============

.

 :

``://www.viedemerde.fr``

. ,

 :

![script9](../images/script9.PNG)



". 


 : ".::".

 :

![script10](../images/script10.PNG)


.

> ****
>
> 
> .


.
