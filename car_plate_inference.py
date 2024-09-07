import requests
from PIL import Image
import pytesseract
import cv2
import numpy as np
import os
import re
from dotenv import load_dotenv
import mysql.connector
from mysql.connector import Error

load_dotenv()  # Loads variables from .env file

# Roboflow API details
API_KEY = os.getenv('API_KEY')
PROJECT_ID = os.getenv('PROJECT_ID')
VERSION = os.getenv('VERSION')

def detect_car_plate(image_path):
    """
    Detects car plate in an image using Roboflow API.
    """
    try:
        with open(image_path, 'rb') as image_file:
            response = requests.post(
                f"https://detect.roboflow.com/{PROJECT_ID}/{VERSION}",
                params={"api_key": API_KEY},
                files={"file": image_file}
            )
            response.raise_for_status()  # Raise an HTTPError if the response was unsuccessful
            response_json = response.json()
            return response_json
    except requests.exceptions.RequestException as e:
        print(f"Error during API request: {e}")
        return None

def extract_plate_info(predictions):
    """
    Extract bounding box information from predictions.
    """
    if not predictions:
        print("No predictions found in the response.")
        return None
    
    for prediction in predictions:
        x, y, width, height = (prediction['x'], prediction['y'], prediction['width'], prediction['height'])
        print(f"Bounding Box - x: {x}, y: {y}, width: {width}, height: {height}")

        # Adjust the bounding box slightly to ensure the plate is fully captured
        padding_x = 10  # Slight horizontal padding
        padding_y = 5   # Slight vertical padding

        x_min = int(x - width / 2) - padding_x
        y_min = int(y - height / 2) - padding_y
        x_max = int(x + width / 2) + padding_x
        y_max = int(y + height / 2) + padding_y

        return (x_min, y_min, x_max, y_max)
    
    return None

def preprocess_image(image):
    """
    Preprocess the image to enhance OCR accuracy.
    """
    try:
        gray_image = cv2.cvtColor(np.array(image), cv2.COLOR_RGB2GRAY)
        _, thresh_image = cv2.threshold(gray_image, 0, 255, cv2.THRESH_BINARY + cv2.THRESH_OTSU)
        return thresh_image
    except Exception as e:
        print(f"Error during image preprocessing: {e}")
        return None

def crop_image(image_path, bounding_box):
    """
    Crop the detected car plate area from the image.
    """
    try:
        image = Image.open(image_path)
        cropped_image = image.crop(bounding_box)
        cropped_image.show()
        return cropped_image
    except Exception as e:
        print(f"Error cropping image: {e}")
        return None

def extract_plate_number(cropped_image):
    """
    Apply OCR to extract the car plate number from the cropped image.
    """
    try:
        preprocessed_image = preprocess_image(cropped_image)
        plate_number = pytesseract.image_to_string(preprocessed_image, config='--psm 7')
        plate_number = plate_number.strip()

        # Remove any non-alphanumeric characters (except spaces)
        plate_number = ''.join(char if char.isalnum() or char.isspace() else '' for char in plate_number)

        # Use regex to match the extracted plate number to one of the known Turkish plate patterns
        plate_pattern = re.compile(r'''
            ^(\d{2})\s?([A-Z]{1,3})\s?(\d{2,5})$  # Matches all Turkish plate formats
        ''', re.VERBOSE)

        match = plate_pattern.search(plate_number)
        if match:
            # Format the plate number consistently
            formatted_plate = f"{match.group(1)} {match.group(2)} {match.group(3)}"
            return formatted_plate
        else:
            # Attempt to fix common OCR errors
            if len(plate_number) > 2 and not plate_number[:2].isdigit():
                plate_number = plate_number[1:]  # Remove the first character if it's incorrect
            
            match = plate_pattern.search(plate_number)
            if match:
                formatted_plate = f"{match.group(1)} {match.group(2)} {match.group(3)}"
                return formatted_plate
            else:
                print("No valid plate pattern detected. Returning the adjusted OCR output.")
                return plate_number
    except Exception as e:
        print(f"Error during OCR extraction: {e}")
        return None

def create_connection():
    """
    Establish a connection to the MySQL database.
    """
    try:
        connection = mysql.connector.connect(
            host = os.getenv('HOST'),
            database = os.getenv('DATABASE'),
            user = os.getenv('ROOT'),
            password = os.getenv('PASSWORD'),
            port = os.getenv('PORT')
        )
        if connection.is_connected():
            print("Connected to MySQL database")
        return connection
    except Error as e:
        print(f"Error connecting to MySQL: {e}")
        return None

def log_car_entry(connection, plate_number):
    """
    Log the car entry into the database.
    """
    try:
        cursor = connection.cursor()
        cursor.callproc('log_entry', [plate_number])
        connection.commit()
        print(f"Logged entry for plate number: {plate_number}")
    except Error as e:
        print(f"Error logging car entry: {e}")

def main(image_path):
    """
    Main function to process the image and log the car entry.
    """
    response_json = detect_car_plate(image_path)
    if response_json and 'predictions' in response_json:
        bounding_box = extract_plate_info(response_json['predictions'])
        if bounding_box:
            cropped_image = crop_image(image_path, bounding_box)
            if cropped_image:
                plate_number = extract_plate_number(cropped_image)
                if plate_number:
                    print(f"Extracted Plate Number: {plate_number}")
                    
                    # Establish database connection and log the car plate
                    connection = create_connection()
                    if connection:
                        log_car_entry(connection, plate_number)
                        connection.close()
                else:
                    print("OCR failed to extract a plate number. The image might be too blurry or the plate might not be clearly visible.")
            else:
                print("Failed to crop the image. The bounding box might be incorrect.")
        else:
            print("No license plate detected in the image.")
    else:
        print("No predictions or invalid response from the API.")

if __name__ == "__main__":
    IMAGE_PATH = "test3.jpg"
    main(IMAGE_PATH)
