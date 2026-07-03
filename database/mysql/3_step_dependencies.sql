CREATE TABLE step_dependencies (
    step_id            INTEGER NOT NULL,
    depends_on_step_id INTEGER NOT NULL,
    PRIMARY KEY (step_id, depends_on_step_id)
);
