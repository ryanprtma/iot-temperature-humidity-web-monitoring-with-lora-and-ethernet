#include <SoftwareSerial.h> //library software serial arduino
#include <Wire.h>
#include <Adafruit_Sensor.h>
#include <Adafruit_BME280.h>

#define SEALEVELPRESSURE_HPA (1013.25)

Adafruit_BME280 bme;
SoftwareSerial sim900(7, 8); //(rx,tx)

String suhu;
String kelembaban;
int counter=0;
int ID_dari_arduino=0;
void setup()
{
  sim900.begin(9600); //baudrate pada Shield = 9600          
  Serial.begin(9600); //baudrate serial monitor;
  Serial.println("CLEARSHEET");
  Serial.println("LABEL,Status Data,ID dari arduino,Suhu,Kelembaban,Tanggal,Waktu Kirim");
  if (!bme.begin(0x76)) {
    Serial.println("Could not find a valid BME280 sensor, check wiring!");
    while (1);
  }
  delay(2000);
  status_gsm(); //prosedur memeriksa koneksi sim900 dengan arduino
  setting_kartusim(); //prosedur pengaturan GPRS sim900
//  koneksi(); //prosedur mengirim data ke database
}

void status_gsm()
{
  sim900.println(F("AT")); //AT command untuk memastikan koneksi dengan Arduino
  if(sim900.find("OK")) 
  {
    Serial.println(F("Koneksi dengan Arduino BERHASIL"));
  }
  else
  {
    Serial.println(F("Koneksi dengan Arduino GAGAL"));
    reset_gsm(); //prosedur power up sim900 (melakukan hard reset sim900)
    status_gsm();
  }
  delay(100);
}

void reset_gsm()
{
  pinMode(9, OUTPUT); 
  digitalWrite(9,LOW);
  delay(1000);
  digitalWrite(9,HIGH);
  delay(2000);
  digitalWrite(9,LOW);
  delay(3000);
}

void setting_kartusim()
{
  sim900.println(F("AT+CREG=1")); //mengaktifkan registrasi jaringan
  delay(1000);
  Serial.println(sim900.readString());
  sim900.println(F("AT+CGATT=0")); //masuk ke gprs servis
  delay(1000);
  Serial.println(sim900.readString());
  sim900.println(F("AT+CGATT=1")); //masuk ke gprs servis
  delay(1000);
  Serial.println(sim900.readString());
  sim900.println(F("AT+CIPSHUT")); //menonaktifkan gprs
  delay(1000);
  Serial.println(sim900.readString());
  sim900.println(F("AT+CIPMUX=0"));//mengaktifkan single IP koneksi
  delay(100);
  Serial.println(sim900.readString());
  sim900.println(F("AT+CSTT=\"internet""\"")); //setting APN kartu sim
  delay(500);
  sim900.println(F("AT+CSTT?")); //memastikan setting APN benar
  delay(5000);
  Serial.println(sim900.readString());
  sim900.println(F("AT+CIICR")); //memulai koneksi GPRS
  delay(1000);
  Serial.println(sim900.readString());
  sim900.println(F("AT+CIFSR")); //request IP
  delay(1000);
  Serial.println(sim900.readString());
}

void koneksi()
{   
    Serial.print("DATA,");
    Serial.print("Kirim data ke web,");//memulai koneksi dengan server
//    counter= counter +1;
//    Serial.print("ID : ");
//    Serial.print(counter);
//    Serial.print(",");
    Serial.print("Suhu: ");
    Serial.print(suhu);
    Serial.print(",");
    Serial.print("Kelembaban: ");
    Serial.print(kelembaban);
    Serial.print(",");
    Serial.print("DATE");
    Serial.print(",");
    Serial.print("TIME");
    Serial.println("");
    sim900.println(F("AT+CIPSTART=\"TCP\",\"fisika-mipa-unsri.com""\",80"));
    delay(15000);
//    Serial.println(sim900.readString());
  
  if(sim900.find("OK"))
  {
    ID_dari_arduino=ID_dari_arduino+1;
    Serial.print("DATA,");
    Serial.print("ID : ");
    Serial.print(ID_dari_arduino);
    Serial.print(",");
    Serial.print(F("Proses data"));
    Serial.print(",");
    Serial.print(",");
    Serial.print(",");
    Serial.print(",");
    Serial.print("DATE");
    Serial.print(",");
    Serial.print("TIME");
    Serial.println("");
  }
  String link = "GET /tambah.php?ID_dari_arduino="+String(ID_dari_arduino)+"&suhu="+String(suhu)+"&kelembaban="+String(kelembaban)+" HTTP/1.1\r\nHost: fisika-mipa-unsri.com\r\n\r\n"; //tautan dengan metode GET
//  String link = "GET /tambah.php?suhu=35&kelembaban=60 HTTP/1.1\r\nHost: fisika-mipa-unsri.com\r\n\r\n"; //tautan dengan metode GET
  
  sim900.print(F("AT+CIPSEND=")); //mengirim request data
  sim900.println(link.length()); //mengirim panjang tautan request data
  delay(500);
  if(sim900.find(">"))
  {
    sim900.print(link); //mengirim tautan ke server
    if(sim900.find("SEND OK"))
    {
      delay(100);
      while (sim900.available())
      {
        Serial.print(sim900.readString()); //feedback data (sesuai dengan keluaran di browser)
      }
      sim900.println(F("AT+CIPCLOSE")); //stop koneksi
    }
    else
    {
      koneksi();
    }
 
  }
  
}

void sensor ()
{
//  Serial.print("Temperature = ");
  suhu = ((int)(bme.readTemperature)());
//  Serial.print(suhu);
//  Serial.println("*C");

//  Serial.print("Pressure = ");
//  Serial.print(bme.readPressure() / 100.0F);
//  Serial.println("hPa");

//  Serial.print("Approx. Altitude = ");
//  Serial.print(bme.readAltitude(SEALEVELPRESSURE_HPA));
//  Serial.println("m");

//  Serial.print("Humidity = ");
  kelembaban = ((int)(bme.readHumidity)());
//  Serial.print(kelembaban);
//  Serial.println("%");

  Serial.println();
  delay(1000);
}

void loop() 
{
  sensor();
//  delay(600000);
//  status_gsm();
//  setting_kartusim();
  
  koneksi();
  
}
