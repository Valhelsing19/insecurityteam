-- ============================================
-- Officials System Database Schema
-- ============================================
-- This schema creates the officials table, enhances maintenance_requests,
-- and creates the request_activity_log for tracking official actions.

-- ============================================
-- 1. OFFICIALS TABLE
-- ============================================
-- Separate table for officials with username/password login
CREATE TABLE IF NOT EXISTS officials (
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
-- Add priority and assignment tracking to existing requests table

-- Add priority column (if not exists)
ALTER TABLE maintenance_requests 
ADD COLUMN IF NOT EXISTS priority ENUM('low', 'medium', 'high', 'urgent') DEFAULT 'medium';

-- Add assigned_to column (if not exists)
ALTER TABLE maintenance_requests 
ADD COLUMN IF NOT EXISTS assigned_to INT NULL;

-- Add assigned_at timestamp (if not exists)
ALTER TABLE maintenance_requests 
ADD COLUMN IF NOT EXISTS assigned_at TIMESTAMP NULL;

-- Add foreign key for assigned_to (if not exists)
-- Note: This will fail if the column already has a foreign key
SET @fk_exists = (
    SELECT COUNT(*) 
    FROM information_schema.TABLE_CONSTRAINTS 
    WHERE CONSTRAINT_SCHEMA = DATABASE()
    AND TABLE_NAME = 'maintenance_requests'
    AND CONSTRAINT_NAME = 'fk_maintenance_requests_assigned_to'
);

SET @sql = IF(@fk_exists = 0,
    'ALTER TABLE maintenance_requests ADD CONSTRAINT fk_maintenance_requests_assigned_to FOREIGN KEY (assigned_to) REFERENCES officials(id) ON DELETE SET NULL',
    'SELECT "Foreign key already exists" AS message'
);

PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Create indexes for performance
CREATE INDEX IF NOT EXISTS idx_priority ON maintenance_requests(priority);
CREATE INDEX IF NOT EXISTS idx_assigned_to ON maintenance_requests(assigned_to);

-- ============================================
-- 3. REQUEST ACTIVITY LOG TABLE
-- ============================================
-- Tracks all actions performed by officials on requests
CREATE TABLE IF NOT EXISTS request_activity_log (
    id INT AUTO_INCREMENT PRIMARY KEY,
    request_id INT NOT NULL,
    official_id INT NULL,
    action_type VARCHAR(50) NOT NULL, -- 'status_changed', 'priority_set', 'assigned', 'note_added', 'unassigned', etc.
    old_value VARCHAR(255) NULL, -- Previous status/priority/value
    new_value VARCHAR(255) NULL, -- New status/priority/value
    description TEXT NULL, -- Additional notes or comments
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (request_id) REFERENCES maintenance_requests(id) ON DELETE CASCADE,
    FOREIGN KEY (official_id) REFERENCES officials(id) ON DELETE SET NULL
);

-- Create indexes for performance
CREATE INDEX IF NOT EXISTS idx_request_id ON request_activity_log(request_id);
CREATE INDEX IF NOT EXISTS idx_official_id ON request_activity_log(official_id);
CREATE INDEX IF NOT EXISTS idx_action_type ON request_activity_log(action_type);
CREATE INDEX IF NOT EXISTS idx_created_at ON request_activity_log(created_at);

-- ============================================
-- NOTES
-- ============================================
-- 1. Officials login with username/password (not email)
-- 2. All official actions on requests are logged in request_activity_log
-- 3. Priority can be: low, medium, high, urgent
-- 4. Activity log tracks: status changes, priority changes, assignments, notes
-- 5. Foreign keys ensure data integrity

