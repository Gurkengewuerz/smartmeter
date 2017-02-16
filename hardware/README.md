# Stromzähler


Der SmartMeter ist darauf ausgelegt auf einem RaspberryPi zu laufen, der Signale per GPIO ausliest und diese Daten in eine MySQL Datenbank übergibt.  

---

#### Das Modul
Das Auslesen des Stromzähler geschieht über eine Reflexdiode (CNY-70), weitere Infos zu dem Stromlaufplan gibt es hier: 
![Stromlaufplan](https://gitlab.com/SmartMeter/hardware/raw/ddf4d86c37e23173ff1c0b72932402e1d67722d7/Schaltung.png)
**WICHTIG!** Hier ist ein TLC270**CP** verbaut, dies ist ein Different Verstärker und ein **C**om**p**artor. Hier gilt wenn Eingang A ein kleines bisschen größer ist als Eingang B gibt es einen Output!


Die Platine wurde geätzt und in ein Gehäuse eingebaut. Für die Platine hat ein 50x35x20mm ABS Gehäuse gereicht.  

#### Bestellliste:
* 1551GBK ABS Gehäuse
* TODO

---

#### Die Programmierung

Die Programmierung ist öffentlich einsehbar in dieser Gruppe in den Repositorys *frontend* und *backend* einsehbar. Deshalb gehe voerst nicht weiter hier darauf ein.

##### Libraries in Python
 * [PyMySQL](https://github.com/markdown-it/markdown-it) für die MySQL Verbindung

##### Libraries für das Frontend
 * [JQuery](https://github.com/markdown-it/markdown-it) für ein schöneres JavaScript
 * [Bootstrap](https://github.com/markdown-it/markdown-it) HTML Framework

---

#### Probleme
Hier sind ein paar Probleme aufgelistet auf die ich während der Installation, Programmierung und beim bauen des Moduls gestoßen bin:  
* :exclamation:Es gab nur eine Reflexion
* :exclamation: Der Differenz Verstärker wurde heiß
* :exclamation: Der TLC 271 CP macht nicht das was er soll
* :exclamation: Langsamer Output
