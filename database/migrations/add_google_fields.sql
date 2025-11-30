-- Migration: Add Google OAuth fields to users table
-- Run this SQL in your MySQL database

ALTER TABLE users ADD COLUMN google_id VARCHAR(255) UNIQUE NULL;
ALTER TABLE users ADD COLUMN picture VARCHAR(500) NULL;

-- Add index for faster lookups
CREATE INDEX idx_google_id ON users(google_id);

