#include <ESP8266WiFi.h>
#include <ESP8266WebServer.h>
#include <SoftwareSerial.h>
#include <TinyGPS++.h>
#include <FirebaseESP8266.h>

const char *ssid = "Ninad";
const char *password = "Ninad1234";
const char *firebaseHost = "band-o-bast-7c5f1-default-rtdb.firebaseio.com";
const char *firebaseAuth = "Z0PW1fDO6eQrbAzkXnDWRyrXMLNyR8CIdlS8dC8P";

// Server settings
ESP8266WebServer server(80);

// GPS settings
SoftwareSerial gpsSerial(4, 5); // RX, TX
TinyGPSPlus gps;

void setup() {
  Serial.begin(9600);
  WiFi.begin(ssid, password);

  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.println("Connecting to WiFi...");
  }

  Serial.println("Connected to Wi-Fi");
  Serial.print("IP Address: ");
  Serial.println(WiFi.localIP());

  // Initialize the GPS serial communication
  gpsSerial.begin(9600);

  // Set up the server routes
  server.on("/", HTTP_GET, handleRoot);
  server.on("/gps", HTTP_GET, handleGetGPSData);
  server.on("/gps", HTTP_POST, handlePostGPSData);

  // Initialize Firebase
  Firebase.begin(firebaseHost, firebaseAuth);

  server.begin();
}

void loop() {
  server.handleClient();

  // Read data from the GPS module
  while (gpsSerial.available() > 0) {
    if (gps.encode(gpsSerial.read())) {
      // If we have a complete GPS sentence, extract data
      if (gps.location.isValid()) {
        String gpsData = "latitude:" + String(gps.location.lat(), 6) + ",longitude:" + String(gps.location.lng(), 6);
        Serial.println(gpsData);

        // Send GPS data to Firebase
        sendGPSDataToFirebase(gpsData);
      }
      delay(3000);
    }
  }
}

void handleRoot() {
  server.send(200, "text/plain", "Hello from ESP8266!");
}

void handleGetGPSData() {
  String data = "Latitude:" + String(gps.location.lat(), 6) + ",Longitude:" + String(gps.location.lng(), 6);
  server.send(200, "text/plain", data);
}

void handlePostGPSData() {
  String gpsData = "latitude:" + String(gps.location.lat(), 6) + ",longitude:" + String(gps.location.lng(), 6);
  Serial.println("Received GPS data on server: " + gpsData);
  server.send(200, "text/plain", "GPS data received successfully");
}

void sendGPSDataToFirebase(String data) {
  FirebaseData fbdo;
  String deviceId = "100";
  Firebase.pushString(fbdo, "/gpsData/" + deviceId, data);

  Serial.println("Sent GPS data to Firebase: " + data);
}
