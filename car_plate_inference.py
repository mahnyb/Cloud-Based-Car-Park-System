import requests
from PIL import Image
import pytesseract
import cv2
import numpy as np
import os as os

# roboflow API details
API_KEY = "bVao5SGcDuY8aZ4OHrwe"
PROJECT_ID = "car-plate-detection-2efss"
VERSION = "1"  

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
    extract bounding box information from predictions
    """
    if not predictions:
        print("No predictions found in the response.")
        return None
    
    for prediction in predictions:
        x, y, width, height = (prediction['x'], prediction['y'], prediction['width'], prediction['height'])
        print(f"Bounding Box - x: {x}, y: {y}, width: {width}, height: {height}")

        x_min = int(x - width / 2)
        y_min = int(y - height / 2)
        x_max = int(x + width / 2)
        y_max = int(y + height / 2)

        return (x_min, y_min, x_max, y_max)
    
    return None

def crop_image(image_path, bounding_box):
    """
    crop the detected car plate area from the image
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
    apply OCR to extract the car plate number from the cropped image
    """
    try:
        cropped_image_cv = cv2.cvtColor(np.array(cropped_image), cv2.COLOR_RGB2BGR)
        plate_number = pytesseract.image_to_string(cropped_image_cv, config='--psm 8')
        plate_number = plate_number.strip()
        return plate_number
    except Exception as e:
        print(f"Error during OCR extraction: {e}")
        return None

def main(image_path):
    response_json = detect_car_plate(image_path)
    if response_json and 'predictions' in response_json:
        bounding_box = extract_plate_info(response_json['predictions'])
        if bounding_box:
            cropped_image = crop_image(image_path, bounding_box)
            if cropped_image:
                plate_number = extract_plate_number(cropped_image)
                if plate_number:
                    print(f"Extracted Plate Number: {plate_number}")
                else:
                    print("Failed to extract the plate number.")
            else:
                print("Failed to crop the image.")
        else:
            print("No bounding box found.")
    else:
        print("No predictions or invalid response.")

if __name__ == "__main__":
    IMAGE_PATH = "Plate (292).jpeg"
    main(IMAGE_PATH)
