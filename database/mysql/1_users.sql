CREATE TABLE users (
    id            INTEGER PRIMARY KEY AUTOINCREMENT,
    first_name    TEXT NOT NULL,
    last_name     TEXT NOT NULL,
    email         TEXT NOT NULL UNIQUE,
    password      TEXT NOT NULL,
    date_of_birth TEXT NULL,
    is_eu         INTEGER NULL,
    is_working    INTEGER NULL,
    housing_type  TEXT NULL,
    program_type  TEXT NULL,
    has_admission INTEGER NULL,
    created_at    TEXT DEFAULT CURRENT_TIMESTAMP,
    updated_at    TEXT DEFAULT CURRENT_TIMESTAMP
);
