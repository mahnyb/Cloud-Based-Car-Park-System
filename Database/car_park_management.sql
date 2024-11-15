DROP DATABASE car_park_management;

-- Create the Database
CREATE DATABASE IF NOT EXISTS car_park_management;
USE car_park_management;

-- Create Tables
CREATE TABLE IF NOT EXISTS cars (
    car_plate VARCHAR(10) PRIMARY KEY,
    is_staff BOOLEAN DEFAULT FALSE
);

CREATE TABLE IF NOT EXISTS car_entries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    car_plate VARCHAR(10),
    entry_time DATETIME NOT NULL,
    exit_time DATETIME,
    FOREIGN KEY (car_plate) REFERENCES cars(car_plate)
);

CREATE TABLE IF NOT EXISTS charges (
    id INT AUTO_INCREMENT PRIMARY KEY,
    car_plate VARCHAR(10),
    entry_time DATETIME NOT NULL,
    exit_time DATETIME NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (car_plate) REFERENCES cars(car_plate)
);

-- Insert Sample Data for Staff Cars
INSERT INTO cars (car_plate, is_staff) VALUES
('34ABC123', TRUE),
('34XYZ789', TRUE);

DROP PROCEDURE IF EXISTS log_entry;
DROP PROCEDURE IF EXISTS log_exit;

-- Procedures for Logging Entries and Exits and Calculating Charges
DELIMITER //

CREATE PROCEDURE log_entry(NEW_car_plate VARCHAR(10))
BEGIN
    IF (SELECT COUNT(*) FROM cars WHERE car_plate = NEW_car_plate) = 0 THEN
        INSERT INTO cars (car_plate) VALUES (NEW_car_plate);
    END IF;
    INSERT INTO car_entries (car_plate, entry_time) VALUES (NEW_car_plate, NOW());
END //

CREATE PROCEDURE log_exit(NEW_car_plate VARCHAR(10))
BEGIN
    DECLARE entry_time DATETIME;
    DECLARE is_staff BOOLEAN;
    DECLARE total_hours INT;
    DECLARE charge DECIMAL(10, 2);

    SELECT entry_time INTO entry_time 
    FROM car_entries 
    WHERE car_plate = NEW_car_plate AND exit_time IS NULL 
    ORDER BY entry_time DESC LIMIT 1;

    UPDATE car_entries
    SET exit_time = NOW()
    WHERE car_plate = NEW_car_plate AND exit_time IS NULL;

    SELECT is_staff INTO is_staff
    FROM cars
    WHERE car_plate = NEW_car_plate;

    IF is_staff = FALSE THEN
        SET total_hours = TIMESTAMPDIFF(HOUR, entry_time, NOW());
        IF total_hours = 0 THEN
            SET charge = 50;
        ELSE
            SET charge = 50 + (total_hours * 20);
        END IF;
        INSERT INTO charges (car_plate, entry_time, exit_time, amount) 
        VALUES (NEW_car_plate, entry_time, NOW(), charge);
    END IF;
END //


DELIMITER ;
