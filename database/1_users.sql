CREATE TABLE users (
                       id INT AUTO_INCREMENT PRIMARY KEY,
                       first_name VARCHAR(100) NOT NULL,
                       middle_name VARCHAR(100) NULL,
                       last_name VARCHAR(100) NOT NULL,
                       date_of_birth DATE NOT NULL,
                       is_eu_citizen BOOLEAN NOT NULL,
                       is_working BOOLEAN NOT NULL DEFAULT FALSE,
                       housing_type VARCHAR(50) NOT NULL,
                       program_type VARCHAR(100) NULL,
                       created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                       updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);