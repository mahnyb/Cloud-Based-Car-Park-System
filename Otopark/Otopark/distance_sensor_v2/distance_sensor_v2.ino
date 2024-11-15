// Configuration Constants
#define TRIG_PIN 7  // Define TRIG pin
#define ECHO_PIN 6  // Define ECHO pin
#define DISTANCE_THRESHOLD_OCCUPIED 10  // Minimum distance to detect occupancy (cm)
#define DISTANCE_THRESHOLD_MAX 100  // Maximum distance to detect occupancy (cm)
#define DISTANCE_THRESHOLD_UNOCCUPIED 50  // Distance to detect unoccupancy (cm)
#define PARKED_TIME_THRESHOLD 5000  // Time threshold to confirm parking (ms)
#define MEASUREMENT_DELAY 1000  // Delay between measurements (ms)

String spot_name = "PARK_01";  // Park yeri ismi

void setup() {
  Serial.begin(9600); // Start serial communication at 9600 baud
  pinMode(TRIG_PIN, OUTPUT); // Set TRIG pin as output
  pinMode(ECHO_PIN, INPUT);  // Set ECHO pin as input
}

bool isParked = false;
unsigned long occupationStartTime = 0;

// Function to measure distance
long measure_distance() {
  digitalWrite(TRIG_PIN, LOW);
  delayMicroseconds(2);
  digitalWrite(TRIG_PIN, HIGH);
  delayMicroseconds(10);
  digitalWrite(TRIG_PIN, LOW);

  long duration = pulseIn(ECHO_PIN, HIGH);
  long distance = duration * 0.034 / 2;
  return distance;
}

// Function to handle occupied spot
void handle_occupied(long distance) {
  if (occupationStartTime == 0) {
    occupationStartTime = millis(); // Record the start time
  } else if (millis() - occupationStartTime >= PARKED_TIME_THRESHOLD) { // If threshold time has passed
    isParked = true;
  }
}

// Function to handle unoccupied spot
void handle_unoccupied(long distance) {
  occupationStartTime = 0; // Reset the timer
  if (isParked) {
    isParked = false;
  }
}

// Main processing function
void process_spot() {
  long distance = measure_distance();
  
  if (distance >= DISTANCE_THRESHOLD_OCCUPIED && distance <= DISTANCE_THRESHOLD_MAX) {
    if (distance < DISTANCE_THRESHOLD_UNOCCUPIED) {
      handle_occupied(distance);
    } else {
      handle_unoccupied(distance);
    }
  } else {
    occupationStartTime = 0; // Reset the timer if distance is out of range
  }

  // Send spot name, distance, and parked status over serial
  Serial.print("Spot Name: ");
  Serial.print(spot_name);
  Serial.print(", Distance: ");
  Serial.print(distance);
  Serial.print(" cm, Parked: ");
  Serial.println(isParked);
}

void loop() {
  process_spot();
  delay(MEASUREMENT_DELAY); // Wait before the next measurement
}
