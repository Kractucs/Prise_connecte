const client = new Paho.MQTT.Client("10.128.1.204",9001,"ClientWeb");

const myTopic = "webserver"

client.connect({ onSuccess: onConnect,
		userName : "web",
		password : "web" })
let counter = 0
function onConnect() {
  console.log("connection successful")
  client.subscribe("Prises/Prise1")   //subscribe to our topic
}
const publish = (topic, msg) => {  //takes topic and message string
  let message = new Paho.MQTT.Message(msg);
  message.destinationName = topic;
  client.send(message);
}


client.onMessageArrived = onMessageArrived;function onMessageArrived(message) {
  let el= document.createElement('div')
  el.innerHTML = message.payloadString
  document.body.appendChild(el)
  console.log("OK")
}


client.onConnectionLost = onConnectionLost;

function onConnectionLost(responseObject) {
  if (responseObject.errorCode !== 0) {
    console.log("onConnectionLost:" + responseObject.errorMessage);
  }
  client.connect({ onSuccess: onConnect });
}
