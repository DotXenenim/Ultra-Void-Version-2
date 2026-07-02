CREATE TABLE step_dependencies (
                                   step_id INT NOT NULL,
                                   depends_on_step_id INT NOT NULL,
                                   PRIMARY KEY (step_id, depends_on_step_id),
                                   CONSTRAINT fk_dependency_step
                                       FOREIGN KEY (step_id) REFERENCES steps(id)
                                           ON DELETE CASCADE,
                                   CONSTRAINT fk_dependency_depends_on
                                       FOREIGN KEY (depends_on_step_id) REFERENCES steps(id)
                                           ON DELETE CASCADE
);