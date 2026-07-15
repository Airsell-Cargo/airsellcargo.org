CREATE TABLE contact_form (
    id INT AUTO_INCREM ENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(50),
    service_type VARCHAR(50),
    subject VARCHAR(150),
    details TEXT,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
