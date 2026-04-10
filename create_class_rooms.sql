CREATE TABLE IF NOT EXISTS class_rooms (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    school_id INTEGER NOT NULL,
    academic_year_id INTEGER NOT NULL,
    name TEXT NOT NULL,
    code TEXT NOT NULL UNIQUE,
    capacity INTEGER DEFAULT 30,
    section TEXT,
    description TEXT,
    is_active INTEGER DEFAULT 1,
    created_at TEXT,
    updated_at TEXT,
    FOREIGN KEY (school_id) REFERENCES schools(id) ON DELETE CASCADE,
    FOREIGN KEY (academic_year_id) REFERENCES academic_years(id) ON DELETE CASCADE
);

CREATE INDEX IF NOT EXISTS idx_class_rooms_school_id ON class_rooms(school_id);
CREATE INDEX IF NOT EXISTS idx_class_rooms_academic_year_id ON class_rooms(academic_year_id);
