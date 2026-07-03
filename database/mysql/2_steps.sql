CREATE TABLE steps (
    id                  INTEGER PRIMARY KEY AUTOINCREMENT,
    slug                TEXT NOT NULL UNIQUE,
    title               TEXT NOT NULL,
    description         TEXT NOT NULL,
    detail              TEXT NULL,
    official_url        TEXT NULL,
    official_url_label  TEXT NULL,
    icon                TEXT NULL,
    sort_order          INTEGER NOT NULL DEFAULT 0,
    applies_to_eu       INTEGER NOT NULL DEFAULT 1,
    applies_to_non_eu   INTEGER NOT NULL DEFAULT 1,
    requires_working    INTEGER NULL,
    requires_housing    TEXT NULL,
    requires_program    TEXT NULL,
    requires_age_max    INTEGER NULL,
    optional_suggestion TEXT NULL
);
