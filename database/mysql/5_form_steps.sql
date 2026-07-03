CREATE TABLE form_steps (
    id           INTEGER PRIMARY KEY AUTOINCREMENT,
    form_id      INTEGER NOT NULL,
    step_id      INTEGER NOT NULL,
    completed    INTEGER NOT NULL DEFAULT 0,
    completed_at TEXT NULL,
    UNIQUE (form_id, step_id)
);
