// Code to run on the ESP8266 with LoRa to receive GPS data
// This code receives GPS data via LoRa and processes it

#include <LoRa.h>

#define SS 15
#define RST 16
#define DIO0 2

void setup() {
  Serial.begin(9600);
  while (!Serial);
  Serial.println("Receiver Host");
  LoRa.setPins(SS, RST, DIO0);
  if (!LoRa.begin(433E6)) {
    Serial.println("LoRa Error");
    while (1);
  }
}

void loop() {
  int packetSize = LoRa.parsePacket();
  if (packetSize) {
    // Received a packet
    Serial.println("Received packet!");

    while (LoRa.available()) {
      String gpsData = LoRa.readString();
      // Process and display GPS data as needed
      Serial.println("GPS Data Received via LoRa: " + gpsData);
    }
  }
}
