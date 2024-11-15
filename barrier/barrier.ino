#include <Servo.h>

const int trigPin = 9;
const int echoPin = 10;
const int servoPin = 11;
const int thresholdDistance = 20; // Mesafe eşiği (cm)
const unsigned long waitTime = 6000; // Bekleme süresi (ms)
Servo barrierServo;

void setup() {
  pinMode(trigPin, OUTPUT);
  pinMode(echoPin, INPUT);
  barrierServo.attach(servoPin);
  barrierServo.write(0); // Başlangıç pozisyonu (bariyer kapalı)
  Serial.begin(9600);
}

void loop() {
  int distance = measureDistance();

  if (distance <= thresholdDistance) {
    if (isVehicleStillThere()) {
      openBarrier();
      delay(5000); // 5 saniye açık kal
      closeBarrier();
    }
  }

  delay(100); // Sensör okuma süresi
}

// Mesafe ölçüm fonksiyonu
int measureDistance() {
  long duration;
  
  digitalWrite(trigPin, LOW);
  delayMicroseconds(2);
  digitalWrite(trigPin, HIGH);
  delayMicroseconds(10);
  digitalWrite(trigPin, LOW);
  
  duration = pulseIn(echoPin, HIGH);
  int distance = duration * 0.034 / 2;

  return distance;
}

// Aracın halen orada olup olmadığını kontrol eden fonksiyon
bool isVehicleStillThere() {
  unsigned long startTime = millis();
  
  while (millis() - startTime < waitTime) {
    int distance = measureDistance();
    
    if (distance > thresholdDistance) {
      return false;
    }
  }
  
  return true;
}

// Bariyeri açan fonksiyon
void openBarrier() {
  barrierServo.write(90); // Bariyeri aç
  Serial.println("Bariyer açıldı");
}

// Bariyeri kapatan fonksiyon
void closeBarrier() {
  barrierServo.write(0); // Bariyeri kapat
  Serial.println("Bariyer kapandı");
}

