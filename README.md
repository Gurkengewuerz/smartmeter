# Smartmeter for Raspberry Pi
German:
In hardware/ befindet sich der Schaltplan und eine kleine, noch nicht vollständige, Anleitung.

    apt-get install git
    cd && git clone https://github.com/Gurkengewuerz/smartmeter.git
    apt-get install python3 python3-pip
    pip3 install -r backend/requirements.txt 
    apt-get install nginx mysql-server php5-fpm php5-curl php5-mysql
	mysql -u root -p < smartmeter/sql.sql


Simpler Autostart: 

    @reboot python3 /home/pi/pull.py
    
Standard Admin User:
- Benutzername: demo
- Passwort: demo

### HINWEIS:
**Der GPIO MUSS auf Pull down geschaltet werden! Daher können keine I2C Schnittstellen verwendet werden! (3+5, 19+21, 8+10, ...)**