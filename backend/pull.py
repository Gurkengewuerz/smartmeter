# -*- coding: utf-8 -*-
"""
    @NAME Raspberry Pi GPIO Pin Puller
    @AUTHOR Niklas Schütrumpf
    @Review 11.09.2016
    @DESCRIPTION
"""

import time
import sys
from gpiozero import *
import datetime
import logging
from DB import DB

# CONFIG
PIN = 4  # GPIO Pin (BCM!)
INTERRUPT = 0.3  # Seconds
TRIGGER_IF = False  # Condition for Trigger
LOGLEVEL = logging.DEBUG  # logging Level
INTERVAL = 15  # Database Export Interval (Minutes)
LOGFILE = "./smartmeter.log"  # Log File for Logger
LOG_FORMAT = "[%(asctime)s %(levelname)s] %(message)s"
# END CONFIG

# WORKING VARIABLES
current_turn = 0
until_time = 0
last_insert = 0
db = DB()
# END WORKING VARIABLES


def get_next_15_min(dt=None):
    if dt.minute % INTERVAL or dt.second:
        dt = dt + datetime.timedelta(minutes=INTERVAL - dt.minute % INTERVAL, seconds=-(dt.second % 60))
    else:
        dt = dt
    return dt.timestamp()


# START METHODES
db.connect()
db.query("""CREATE TABLE IF NOT EXISTS `data` (
                `timestamp` int(11) NOT NULL,
                `value` int(11) NOT NULL,
                PRIMARY KEY (`timestamp`)
            );""")

until_time = get_next_15_min(datetime.datetime.now())
logging.basicConfig(format=LOG_FORMAT, filename=LOGFILE, datefmt="%H:%M:%S", level=LOGLEVEL)
console = logging.StreamHandler()
console.setLevel(LOGLEVEL)
formatter = logging.Formatter(LOG_FORMAT)
console.setFormatter(formatter)
logging.getLogger('').addHandler(console)

logging.debug(
    "Starting with the following values: counting till => " + datetime.datetime.fromtimestamp(until_time)
    .strftime("%Y-%m-%d %H:%M:%S") + "(" + str(until_time) + ")")
# END START METHODES


def insert_data(timestamp, value):
    sql = "INSERT INTO `data` (`timestamp`, `value`) VALUES ('%s', '%s');"
    logging.debug(sql % (int(timestamp), value))
    db.query(sql % (int(timestamp), value))


def trigger_callback():
    global current_turn
    current_turn += 1
    logging.debug(" => " + str(current_turn))

trigger = Button(PIN, pull_up=False)
trigger.when_pressed = trigger_callback

try:
    while True:
        if time.time() >= until_time:
            insert_data(until_time, current_turn)
            logging.debug("In 15 Minutes => " + str(current_turn) + "turns")
            time.sleep(1)
            until_time = get_next_15_min(datetime.datetime.now())
            logging.debug(
                "Next counting till => " + datetime.datetime.fromtimestamp(until_time)
                .strftime("%Y-%m-%d %H:%M:%S") + "(" + str(until_time) + ")")
            current_turn = 0

        time.sleep(INTERRUPT)
except:
    logging.error("Exit Program => %s" % sys.exc_info()[0])
    db.close()
