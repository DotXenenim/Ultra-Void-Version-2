CREATE TABLE form_steps (
                            id INT AUTO_INCREMENT PRIMARY KEY,
                            form_id INT NOT NULL,
                            step_id INT NOT NULL,
                            completed BOOLEAN NOT NULL DEFAULT FALSE,
                            completed_at TIMESTAMP NULL,
                            CONSTRAINT fk_form_steps_form
                                FOREIGN KEY (form_id) REFERENCES form(id)
                                    ON DELETE CASCADE,
                            CONSTRAINT fk_form_steps_step
                                FOREIGN KEY (step_id) REFERENCES steps(id)
                                    ON DELETE CASCADE,
                            UNIQUE KEY unique_form_step (form_id, step_id)
);