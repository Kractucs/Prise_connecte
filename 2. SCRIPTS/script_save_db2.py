#!/usr/bin/python -u

import mysql.connector as mariadb
import paho.mqtt.client as mqtt
import ssl

mariadb_connection = mariadb.connect(user='script', password='script', database='mqtt')
cursor = mariadb_connection.cursor()

# MQTT Settings 
MQTT_Broker = "127.0.0.1"
MQTT_Port = 1883
Keep_Alive_Interval = 60
MQTT_Topic = "Prises/Prise2"

# Subscribe
def on_connect(client, userdata, flags, rc):
  mqttc.subscribe(MQTT_Topic, 0)

def on_message(mosq, obj, msg):
  # Prepare Data, separate columns and values
  msg_clear = msg.payload.translate(None, '{}""').split(", ")
  # Prepare dynamic sql-statement
  sql = "UPDATE `Prises` SET `State` = '%s' WHERE `Prises`.`id` = 2;" %(msg_clear[0])
  # Save Data into DB Table
  try:
      cursor.execute(sql)
  except mariadb.Error as error:
      print("Error: {}".format(error))
  mariadb_connection.commit()

def on_subscribe(mosq, obj, mid, granted_qos):
  pass

mqttc = mqtt.Client(client_id="SCRIPTsavedb2")

# Assign event callbacks
mqttc.on_message = on_message
mqttc.on_connect = on_connect
mqttc.on_subscribe = on_subscribe

# Connect
mqttc.username_pw_set("script","script")
#mqttc.tls_set(ca_certs="/etc/mosquitto/ca_certificates/mosq-ca.crt", tls_version=ssl.PROTOCOL_TLSv1_2)
mqttc.connect(MQTT_Broker, int(MQTT_Port), int(Keep_Alive_Interval))

# Continue the network loop & close db-connection
mqttc.loop_forever()
mariadb_connection.close()
