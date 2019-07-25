const client = new Paho.MQTT.Client("10.128.1.203",9001,"ClientWeb");

const myTopic = "webserver"

client.connect({ onSuccess: onConnect,
		userName : "web",
		password : "web",
		useSSL: true		
 })
let counter = 0
function onConnect() {
  console.log("connection successful")
  client.subscribe("Prises/Prise1")   //subscribe to our topic
  client.subscribe("Prises/Prise2")
}
const publish = (topic, msg) => {  //takes topic and message string
  let message = new Paho.MQTT.Message(msg);
  message.destinationName = topic;
  client.send(message);
}


client.onMessageArrived = onMessageArrived;function onMessageArrived(message) {
  if(message.destinationName == "Prises/Prise1"){
    var str = message.payloadString;
    if(str == "ON"){
      var str = str.fontcolor("green");
      document.getElementById("Prise1state").innerHTML = str;
    }
   else if(str == "OFF"){
      var str = str.fontcolor("red");
      document.getElementById("Prise1state").innerHTML = str;
    }

  }
  else if(message.destinationName == "Prises/Prise2"){
      var str = message.payloadString;
    if(str == "ON"){
      var str = str.fontcolor("green");
      document.getElementById("Prise2state").innerHTML = str;
    }
   else if(str == "OFF"){
      var str = str.fontcolor("red");
      document.getElementById("Prise2state").innerHTML = str;
    }

  }

}

client.onConnectionLost = onConnectionLost;

function onConnectionLost(responseObject) {
  if (responseObject.errorCode !== 0) {
    console.log("onConnectionLost:" + responseObject.errorMessage);
  }
  client.connect({ onSuccess: onConnect });
}
