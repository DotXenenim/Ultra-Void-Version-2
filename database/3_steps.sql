CREATE TABLE steps (
                       id INT AUTO_INCREMENT PRIMARY KEY,
                       title VARCHAR(255) NOT NULL,
                       description TEXT NULL,
                       official_url VARCHAR(500) NULL,
                       applies_to_eu BOOLEAN NULL,
                       requires_age INT NULL,
                       requires_work BOOLEAN NULL,
                       requires_housing_type VARCHAR(50) NULL
);