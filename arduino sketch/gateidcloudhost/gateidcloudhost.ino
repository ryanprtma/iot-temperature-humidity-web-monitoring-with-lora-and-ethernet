#include <SPI.h>
#include <LoRa.h>
#include <Ethernet.h>

#define ss 10 //kaki LoRa untuk berkomunikasi dengan arduino
#define rst 9
#define dio0 2

int counter = 0;
// Enter a MAC address for your controller below.
// Newer Ethernet shields have a MAC address printed on a sticker on the shield
byte mac[] = { 0x00, 0xAA, 0xBB, 0xCC, 0xDE, 0x02 };
//char server[] = "sundeyweather.xyz"; //name address for your website (using DNS)
char server[] = "fisika-mipa-unsri.com";

// Set the static IP address to use if the DHCP fails to assign
// Menggunakan IP statis jika gagal menggunakan DHCP
IPAddress ip(10, 10, 210, 61);

// Initialize the Ethernet client library
// with the IP address and port of the server
// that you want to connect to (port 80 is default for HTTP):
EthernetClient client;

String DataSensor ;
String suhu;
String kelembaban;
 
void setup() {
  Serial.begin(9600);
  while (!Serial);
  koneksi ();

  Serial.println("LoRa Receiver");
  LoRa.setPins(ss, rst, dio0);

  if (!LoRa.begin(915E6)){
  Serial.println("Starting LoRa failed!");
  while(1);
  }
}

void loop () {
//  if (client.available()) {
  lora ();
insert ();
//  char c = client.read();
//  Serial.println(c);
//  }
}

void lora () {
  DataSensor="";
  delay(50);
  int packetSize = LoRa.parsePacket();
  if (packetSize) {
    Serial.println("Paket Diterima");
    while (LoRa.available()) {
      DataSensor+=(char)LoRa.read(); //read data incoming from LoRa transmitter
      }
//       Serial.print(DataSensor);
       Serial.print("| RSSI:");
       Serial.println(LoRa.packetRssi());
  
  if (DataSensor.substring(0,1)=="<") {
      suhu = DataSensor.substring(1, DataSensor.indexOf(","));
      kelembaban = DataSensor.substring(DataSensor.indexOf(",")+1,DataSensor.indexOf("#"));
      Serial.print("Suhu : ");
      Serial.println(suhu);
      Serial.print("Kelembaban : ");
      Serial.println(kelembaban);
      kirimData ();
//      insert ();
      }
}
}

void koneksi(){
  // start the Ethernet connection and the server:
  Ethernet.init(5);
  {
  // Open serial communications and wait for port to open:
  Serial.begin(9600);
  while (!Serial) { 
  ; // wait for serial port to connect. Needed for native USB port only
  }
  // start the Ethernet connection:
  if (Ethernet.begin(mac) == 0) {
  Serial.println("Failed to configure Ethernet using DHCP");
  // try to congifure using IP address instead of DHCP:
  Ethernet.begin(mac, ip);
  }
  // give the Ethernet shield a second to initialize:
  delay(100);
  }
}

void kirimData (){
  Serial.println("connecting...");
  // if you get a connection, report back via serial:
  if (client.connect(server, 80)){
  Serial.println("connected");
  // Make a HTTP request:
  client.println(String("GET ") + "/tambah3.php?suhu=" + suhu + "&kelembaban=" + kelembaban + " HTTP/1.1");
  //client.println(String("GET ") + "/stambah.php?status=Hujan&intensitas=70 HTTP/1.1");
//  client.println("Host: sundeyweather.xyz");
  client.println("Host: fisika-mipa-unsri.com");
  client.println("Connection: close");
  client.println();
//  // if there are incoming bytes available
//  // from the server, read them and print them:
//  if (client.available()) {
//  char c = client.read();
//  Serial.print(c);
//  }
//  
//  // if the server's disconnected, stop the client:
//  if (!client.connected()) {
//  Serial.println();
//  Serial.println("disconnecting.");
//  client.stop();
//  
//  delay(5000);
//  //sensor ();
////  insert();
//}
  } else 
  {// if you didn't get a connection to the server:
  Serial.println("connection failed");
  } 
}

void insert () {
  if (client.available()) {
  char c = client.read();
  Serial.print(c);
//  kirimData();
  }  
}
 
