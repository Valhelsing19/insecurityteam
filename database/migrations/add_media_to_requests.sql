-- ============================================
-- Add Media Support to Maintenance Requests
-- ============================================
-- This migration adds columns to store image and video URLs
-- Run this in your Supabase SQL Editor or PostgreSQL database

-- For PostgreSQL/Supabase (using JSONB for flexibility)
ALTER TABLE maintenance_requests 
ADD COLUMN IF NOT EXISTS media_files JSONB DEFAULT '[]';

-- Create index for better query performance
CREATE INDEX IF NOT EXISTS idx_media_files ON maintenance_requests USING GIN (media_files);

-- ============================================
-- Media Files JSON Structure:
-- [
--   {
--     "type": "image" | "video",
--     "url": "https://...",
--     "filename": "original-filename.jpg",
--     "size": 1234567,
--     "uploaded_at": "2025-11-30T09:00:00Z"
--   }
-- ]
-- ============================================

-- If you prefer separate columns (alternative approach):
-- ALTER TABLE maintenance_requests 
-- ADD COLUMN IF NOT EXISTS image_urls TEXT[] DEFAULT '{}',
-- ADD COLUMN IF NOT EXISTS video_urls TEXT[] DEFAULT '{}';

