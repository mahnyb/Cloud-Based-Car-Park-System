import serial
import requests

# Serial setup
ser = serial.Serial('COM9', 9600)  # Replace with your correct COM port

# PHP script URL
url = "http://localhost/insert_data.php"  # Change to your actual URL

while True:
    # Read data from serial port
    data = ser.readline().decode('utf-8').strip()
    print(f"Received: {data}")
    
    # Parse spot name, distance, and parking status from the Arduino serial output
    if "Spot Name" in data and "Distance" in data and "Parked" in data:
        # Extract the values from the received data
        parts = data.split(", ")
        spot_name = parts[0].split(": ")[1]  # Extract spot name
        distance = parts[1].split(": ")[1].split(" ")[0]  # Extract distance value
        is_parked = parts[2].split(": ")[1]  # Extract parked status (0 or 1)

        # Send data to PHP script
        payload = {'spot_name': spot_name, 'distance': distance, 'is_parked': is_parked}
        response = requests.get(url, params=payload)

        # Print response from PHP script
        print(response.text)
