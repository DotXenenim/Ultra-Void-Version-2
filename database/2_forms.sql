CREATE TABLE form (
                      id INT AUTO_INCREMENT PRIMARY KEY,
                      user_id INT NOT NULL UNIQUE,
                      submitted_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                      CONSTRAINT fk_form_user
                          FOREIGN KEY (user_id) REFERENCES users(id)
                              ON DELETE CASCADE
);