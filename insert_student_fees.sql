-- Insert student fees for all students based on their class fees
INSERT OR IGNORE INTO student_fees (student_id, class_fee_id, amount, discount, total_payable, paid_amount, balance, status, due_date)
SELECT 
    s.id,
    cf.id,
    cf.amount,
    0,
    cf.amount,
    CASE 
        WHEN RANDOM() % 3 = 0 THEN cf.amount  -- Fully paid (33%)
        WHEN RANDOM() % 3 = 1 THEN cf.amount * 0.5  -- Partial payment (33%)
        ELSE 0  -- No payment (33%)
    END,
    CASE 
        WHEN RANDOM() % 3 = 0 THEN 0  -- Fully paid
        WHEN RANDOM() % 3 = 1 THEN cf.amount * 0.5  -- Partial payment
        ELSE cf.amount  -- No payment
    END,
    CASE 
        WHEN RANDOM() % 3 = 0 THEN 'paid'
        WHEN RANDOM() % 3 = 1 THEN 'partial'
        ELSE 'pending'
    END,
    date('now', '+' || (ABS(RANDOM() % 90) + 1) || ' days')
FROM students s
JOIN class_fees cf ON cf.class_room_id = s.class_room_id
WHERE s.is_active = 1
AND NOT EXISTS (
    SELECT 1 FROM student_fees sf 
    WHERE sf.student_id = s.id 
    AND sf.class_fee_id = cf.id
);
