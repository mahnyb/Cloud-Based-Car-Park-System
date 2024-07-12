#define TRIG_PIN 7  // Define TRIG pin
#define ECHO_PIN 6 // Define ECHO pin

void setup() {
  Serial.begin(9600); // Start serial communication at 9600 baud
  pinMode(TRIG_PIN, OUTPUT); // Set TRIG pin as output
  pinMode(ECHO_PIN, INPUT);  // Set ECHO pin as input
}

bool isParked = false;
unsigned long occupationStartTime = 0;

void loop() {
  // Send a 10 microsecond HIGH pulse to the TRIG pin
  digitalWrite(TRIG_PIN, LOW);
  delayMicroseconds(2);
  digitalWrite(TRIG_PIN, HIGH);
  delayMicroseconds(10);
  digitalWrite(TRIG_PIN, LOW);

  // Measure the duration of the HIGH pulse on the ECHO pin
  long duration = pulseIn(ECHO_PIN, HIGH);

  // Calculate the distance (in centimeters)
  long distance = duration * 0.034 / 2;

  // If the spot is not parked
  if (!isParked) {
    // If the distance is between 10 cm and 100 cm
    if (distance >= 10 && distance <= 100 && isParked==false) {
      Serial.print("Distance: ");
      Serial.print(distance);
      Serial.print(" cm");

      if (distance < 50) { // If the distance is less than 50 cm
        Serial.println(" --Spot is occupied");
        if (occupationStartTime == 0) {
          occupationStartTime = millis(); // Record the start time
        } else if (millis() - occupationStartTime >= 5000) { // If 5 seconds have passed
          isParked = true;
          Serial.println("The spot is occupied. It's in parked state.");
        }
      } else {
        Serial.println(" --Spot is empty");
        occupationStartTime = 0; // Reset the timer if the spot is empty
      }
    }
  } else { // If the spot is parked
    
    
    if (distance >= 50) { // If the distance is greater than or equal to 50 cm
      isParked = false;
      occupationStartTime = 0; // Reset the timer
      Serial.println("The spot is not in parked state anymore.");
    }
  }

  delay(1000); // Wait for 1 second
}
