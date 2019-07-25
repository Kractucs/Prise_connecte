#include <FS.h>                   //this needs to be first, or it all crashes and burns...

#include <ESP8266WiFi.h>          //https://github.com/esp8266/Arduino
//needed for library
#include <DNSServer.h>
#include <ESP8266WebServer.h>
#include <WiFiManager.h>          //https://github.com/tzapu/WiFiManager
#include <ArduinoJson.h>          //https://github.com/bblanchon/ArduinoJson
#include <PubSubClient.h>

const int ledPin = 13; 
const int boutonPin = 14;
int lastDebounceTime = 0;
int lastButtonState = 0;
int debounceDelay = 2;    // Filtre : plus le délai est important moins on détectera des clic rapide sur le bouton
int ledState = 0;
int buttonState = 0;
int reading = 0;
int lastmqttState = 0;
int mqtt = 0;

//flag for saving data
bool shouldSaveConfig = false;

//define your default values here, if there are different values in config.json, they are overwritten.
//char mqtt_server[40];
#define mqtt_server       "172.20.10.8"
#define mqtt_port         "1883"
#define mqtt_user         "prises"
#define mqtt_pass         "prises"
#define prises_topic    "Prises/Prise1"

WiFiClient espClient;
PubSubClient client(espClient);

//callback notifying us of the need to save config
void saveConfigCallback () {
  Serial.println("Should save config");
  shouldSaveConfig = true;
}

void setup() {
  // put your setup code here, to run once:
  Serial.begin(115200);
  Serial.println();

  // The extra parameters to be configured (can be either global or just in the setup)
  // After connecting, parameter.getValue() will get you the configured value
  // id/name placeholder/prompt default length
  WiFiManagerParameter custom_mqtt_server("server", "mqtt server", mqtt_server, 40);
  WiFiManagerParameter custom_mqtt_port("port", "mqtt port", mqtt_port, 6);
  WiFiManagerParameter custom_mqtt_user("user", "mqtt user", mqtt_user, 20);
  WiFiManagerParameter custom_mqtt_pass("pass", "mqtt pass", mqtt_pass, 20);
  
  WiFiManager wifiManager;
  //wifiManager.autoConnect("Prise 1");
  wifiManager.setAPCallback(configModeCallback);
  wifiManager.setSaveConfigCallback(saveConfigCallback);     
  // Initialise le Pin comme une sortie | Initialize the digital pin as an output with pinMode()
  pinMode(ledPin, OUTPUT); 
  pinMode(boutonPin, INPUT);

  //add all your parameters here
  wifiManager.addParameter(&custom_mqtt_server);
  wifiManager.addParameter(&custom_mqtt_port);
  wifiManager.addParameter(&custom_mqtt_user);
  wifiManager.addParameter(&custom_mqtt_pass);

  if (!wifiManager.autoConnect("Prise1")) {
    Serial.println("failed to connect and hit timeout");
    delay(3000);
    //reset and try again, or maybe put it to deep sleep
    ESP.reset();
    delay(5000);
  }

  //if you get here you have connected to the WiFi
  Serial.println("connected...yeey :)");

  //read updated parameters
  strcpy(mqtt_server, custom_mqtt_server.getValue());
  strcpy(mqtt_port, custom_mqtt_port.getValue());
  strcpy(mqtt_user, custom_mqtt_user.getValue());
  strcpy(mqtt_pass, custom_mqtt_pass.getValue());
 // strcpy(blynk_token, custom_blynk_token.getValue());

  Serial.println("local ip");
  Serial.println(WiFi.localIP());
//  client.setServer(mqtt_server, 12025);
  const uint16_t mqtt_port_x = 1883; 
  client.setServer(mqtt_server, mqtt_port_x);
  client.setCallback(callback);

}

void callback(char* topic, byte* payload, unsigned int length){
  payload[length] = '\0';
  String s = String((char*)payload);
  if (s == "ON"){
    if (ledState == LOW){
      ledState = !ledState;
      digitalWrite(ledPin, ledState);
    }
  }
  else if (s == "OFF"){
    if (ledState == HIGH){
      ledState = !ledState;
      digitalWrite(ledPin, ledState);
    }
  }
}

void configModeCallback (WiFiManager *myWiFiManager) {
  Serial.println("Entered config mode");
  Serial.println(WiFi.softAPIP());

  Serial.println(myWiFiManager->getConfigPortalSSID());
}
//flag for saving data
//bool shouldSaveConfig = false;



void reconnect() {
  // Loop until we're reconnected
  while (!client.connected()) {
    Serial.print("Attempting MQTT connection...");
    // Attempt to connect
    // If you do not want to use a username and password, change next line to
    // if (client.connect("ESP8266Client")) {
    if (client.connect("ESP8266Client", mqtt_user, mqtt_pass)) {
      Serial.println("connected");
      client.subscribe(prises_topic); 
    } else {
      Serial.print("failed, rc=");
      Serial.print(client.state());
      Serial.println(" try again in 5 seconds");
      // Wait 5 seconds before retrying
      delay(5000);
    }
  }
}

void loop() {
  if (!client.connected()) {
    reconnect();
  }
  
  client.loop();
  
  reading = digitalRead(boutonPin);     // On lit l'état du bouton | Button state reading
  if (reading != lastButtonState) {     // L'état est différent par rapport à la boucle précédente | State is different
     lastDebounceTime = millis();       // Enregistre le temps | record time
     lastButtonState = reading;         // enregistre l'état | record the new state
  } 
  // On change l'état de la led uniquement si le temps écoulé entre deux appuis sur le bouton > debounceDelay
  // LED status is changed only if the time between two presses of the button > debounceDelay
  if ((millis() - lastDebounceTime) > debounceDelay) {
      if (buttonState != lastButtonState) {
          buttonState = lastButtonState;
          if (buttonState == HIGH) {
              ledState = !ledState;
              digitalWrite(ledPin, ledState);
          }
      }
  }

   if (ledState == HIGH){
     mqtt = 1;
   }
    
   else if (ledState == LOW){
     mqtt = 0;
   }

  if (mqtt != lastmqttState) {
    if(mqtt == 0){
      lastmqttState = mqtt;
      client.publish(prises_topic, "OFF");
      //Serial.println("mqtt OFF");
    }
    else if(mqtt == 1){
      lastmqttState = mqtt;
      client.publish(prises_topic, "ON");
      //Serial.println("mqtt ON");
    }
    else{
      lastmqttState = mqtt;
      client.publish(prises_topic, "ERROR 404");
      //Serial.println("mqtt ERROR 404");
    }
  }
}




