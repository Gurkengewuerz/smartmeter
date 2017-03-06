# Smartmeter for Raspberry Pi
German:
In hardware/ befindet sich der Schaltplan und eine kleine, noch nicht vollständige, Anleitung.

    apt-get install git
    cd && git clone https://github.com/Gurkengewuerz/smartmeter.git
    apt-get install python3 python3-pip
    pip3 install pymysql 
    apt-get install nginx mysql php5-fpm php5-curl php5-mysql


Simpler Autostart: 

    @reboot python3 /home/pi/pull.py
    
Standard Admin User:
- Benutzername: demo
- Passwort: demo
