#include "DHT.h"
#include <WiFi.h>
#include <HTTPClient.h> 
#define DHTTYPE           DHT11     // DHT 11 
#define DHTPIN            4  
#define RETRY_LIMIT  20
DHT dht(DHTPIN, DHTTYPE);
const char *ssid = "GalaxyA51A118";  //Nama Wifi
const char *password = "nH081930"; // pass wifi

void setup()
{
    Serial.begin(9600);
    dht.begin();
    WiFi.begin(ssid,password);
    Serial.println("");
    Serial.print("Connecting");
    while (WiFi.status()!= WL_CONNECTED){
      delay(500);
      Serial.print(".");
    }
    Serial.println("");
    Serial.print("WiFi connected to: ");
    Serial.println(ssid);
    Serial.print("IP Address : ");
    Serial.println(WiFi.localIP());
    
}

void loop()
{
    int rtl = RETRY_LIMIT;
    float h =  dht.readHumidity();
    float t= dht.readTemperature();
    while (isnan(t) || isnan(h)){
      Serial.println("Check sensor again - " + rtl);
       h =  dht.readHumidity();
       t= dht.readTemperature();
      delay(500);
      if (--rtl <1){
        ESP.restart(); // At times the DHT11 just kept returning NAN. A Restart fixed this.
      }
    }
    
    //Open a connection to the server
      HTTPClient http;
      http.begin("https://fisika-mipa-unsri.com/api.php");
      http.addHeader("Content-Type", "application/x-www-form-urlencoded");
    //format your POST request.
      int httpResponseCode = http.POST("suhu=" + String(t) +"&kelembaban=" + String(h));

      if (httpResponseCode >0){
          //check for a return code - This is more for debugging.
        String response = http.getString();
//        Serial.println(httpResponseCode);
        Serial.println(response);
      }
      else{
        Serial.print("Error on sending post");
        Serial.println(httpResponseCode);
      }
    //closde the HTTP request.
      http.end();
  
    //Monitor values in console for debugging.
      Serial.println("Temp = " + String(t));
      Serial.println("humidity = " + String(h));
    
    
//   wait for next reading
    delay(2000);
    
    
}
