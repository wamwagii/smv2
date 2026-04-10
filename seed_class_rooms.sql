-- Get current academic year (assuming id 1 is current)
INSERT OR IGNORE INTO class_rooms (school_id, academic_year_id, name, code, capacity, section, is_active)
SELECT 
    s.id,
    a.id,
    'Grade 1',
    UPPER(SUBSTR(s.code, 1, 3)) || '_G1A',
    30,
    'A',
    1
FROM schools s
CROSS JOIN academic_years a
WHERE a.is_current = 1
LIMIT 1;

INSERT OR IGNORE INTO class_rooms (school_id, academic_year_id, name, code, capacity, section, is_active)
SELECT 
    s.id,
    a.id,
    'Grade 2',
    UPPER(SUBSTR(s.code, 1, 3)) || '_G2B',
    32,
    'B',
    1
FROM schools s
CROSS JOIN academic_years a
WHERE a.is_current = 1
LIMIT 1;

INSERT OR IGNORE INTO class_rooms (school_id, academic_year_id, name, code, capacity, section, is_active)
SELECT 
    s.id,
    a.id,
    'Form 1',
    UPPER(SUBSTR(s.code, 1, 3)) || '_F1C',
    35,
    'C',
    1
FROM schools s
CROSS JOIN academic_years a
WHERE a.is_current = 1
LIMIT 1;

INSERT OR IGNORE INTO class_rooms (school_id, academic_year_id, name, code, capacity, section, is_active)
SELECT 
    s.id,
    a.id,
    'Form 2',
    UPPER(SUBSTR(s.code, 1, 3)) || '_F2A',
    35,
    'A',
    1
FROM schools s
CROSS JOIN academic_years a
WHERE a.is_current = 1
LIMIT 1;
