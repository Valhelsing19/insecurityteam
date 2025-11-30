-- ============================================
-- Officials System Database Schema (Simple Version)
-- ============================================
-- Use this if your MySQL version doesn't support IF NOT EXISTS in ALTER TABLE
-- Run these commands one by one, checking for errors

-- ============================================
-- 1. CREATE OFFICIALS TABLE
-- ============================================
CREATE TABLE officials (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    name VARCHAR(255) NOT NULL,
    department VARCHAR(255) NULL,
    position VARCHAR(255) NULL,
    phone VARCHAR(20) NULL,
    email VARCHAR(255) NULL,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE INDEX idx_username ON officials(username);
CREATE INDEX idx_is_active ON officials(is_active);

-- ============================================
-- 2. ENHANCE MAINTENANCE_REQUESTS TABLE
-- ============================================
-- Run these one at a time. If you get "Duplicate column" error, skip that line.

-- Add priority column
ALTER TABLE maintenance_requests 
ADD COLUMN priority ENUM('low', 'medium', 'high', 'urgent') DEFAULT 'medium';

-- Add assigned_to column
ALTER TABLE maintenance_requests 
ADD COLUMN assigned_to INT NULL;

-- Add assigned_at timestamp
ALTER TABLE maintenance_requests 
ADD COLUMN assigned_at TIMESTAMP NULL;

-- Add foreign key constraint
ALTER TABLE maintenance_requests 
ADD CONSTRAINT fk_maintenance_requests_assigned_to 
FOREIGN KEY (assigned_to) REFERENCES officials(id) ON DELETE SET NULL;

-- Create indexes
CREATE INDEX idx_priority ON maintenance_requests(priority);
CREATE INDEX idx_assigned_to ON maintenance_requests(assigned_to);

-- ============================================
-- 3. CREATE REQUEST ACTIVITY LOG TABLE
-- ============================================
CREATE TABLE request_activity_log (
    id INT AUTO_INCREMENT PRIMARY KEY,
    request_id INT NOT NULL,
    official_id INT NULL,
    action_type VARCHAR(50) NOT NULL,
    old_value VARCHAR(255) NULL,
    new_value VARCHAR(255) NULL,
    description TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (request_id) REFERENCES maintenance_requests(id) ON DELETE CASCADE,
    FOREIGN KEY (official_id) REFERENCES officials(id) ON DELETE SET NULL
);

-- Create indexes
CREATE INDEX idx_request_id ON request_activity_log(request_id);
CREATE INDEX idx_official_id ON request_activity_log(official_id);
CREATE INDEX idx_action_type ON request_activity_log(action_type);
CREATE INDEX idx_created_at ON request_activity_log(created_at);

