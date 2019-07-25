import mysql.connector as mariadb
import paho.mqtt.client as mqtt
import datetime
import ssl
import time

#SQL connection
mariadb_connection = mariadb.connect(user='script', password='script', database='mqtt')


#Mqtt Settings
MQTT_Broker = "127.0.0.1"
MQTT_Port = 1883
Keep_Alive_Interval = 30
MQTT_Topic = "Prises/Prise"



now = datetime.datetime.now()

while True:

	while (now.second != 0):
		now = datetime.datetime.now()
		time.sleep(1)

	now = datetime.datetime.now()
	timestamp = (str(now.hour)+":"+str(now.minute))
	cursor = mariadb_connection.cursor()
        sql = ("SELECT `STATE`,`Prise_id` FROM `Progra` WHERE `TIME`= '%s'"%(timestamp))
        try:
                cursor.execute(sql)
        except mariadb.Error as error:
                print("Error: {}".format(error))

	data = cursor.fetchall()
	if (len(data) != 0):
		mqttc = mqtt.Client(client_id="SCRIPTtime")
		mqttc.username_pw_set("script","script")
		mqttc.connect(MQTT_Broker, int(MQTT_Port),int(Keep_Alive_Interval))
		mqttc.publish(MQTT_Topic+str(data[0][1]),str(data[0][0]))
		mqttc.disconnect()
	cursor.close()

