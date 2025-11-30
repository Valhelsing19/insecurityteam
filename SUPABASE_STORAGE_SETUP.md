# Supabase Storage Setup Guide

## Step 1: Create Storage Bucket

1. Go to your Supabase Dashboard
2. Navigate to **Storage** in the left sidebar
3. Click **"New bucket"**
4. Name it: `request-media`
5. Set it to **Public** (so images/videos can be viewed)
6. Click **"Create bucket"**

## Step 2: Set Up Storage Policies

### Public Read Access Policy

1. Go to **Storage** → **Policies** → `request-media`
2. Click **"New Policy"**
3. Select **"For full customization"**
4. Name: `Public Read Access`
5. Policy definition:
```sql
CREATE POLICY "Public Read Access"
ON storage.objects FOR SELECT
USING (bucket_id = 'request-media');
```

### Authenticated Upload Policy

1. Create another policy:
2. Name: `Authenticated Upload`
3. Policy definition:
```sql
CREATE POLICY "Authenticated Upload"
ON storage.objects FOR INSERT
WITH CHECK (
  bucket_id = 'request-media' AND
  auth.role() = 'authenticated'
);
```

### Authenticated Update/Delete Policy (Optional)

If you want users to be able to update/delete their own files:

```sql
CREATE POLICY "Users can update own files"
ON storage.objects FOR UPDATE
USING (
  bucket_id = 'request-media' AND
  (storage.foldername(name))[1] = auth.uid()::text
);

CREATE POLICY "Users can delete own files"
ON storage.objects FOR DELETE
USING (
  bucket_id = 'request-media' AND
  (storage.foldername(name))[1] = auth.uid()::text
);
```

## Step 3: Run Database Migration

Run the SQL migration script in your Supabase SQL Editor:

```sql
-- Add media_files column to maintenance_requests table
ALTER TABLE maintenance_requests 
ADD COLUMN IF NOT EXISTS media_files JSONB DEFAULT '[]';

-- Create index for better query performance
CREATE INDEX IF NOT EXISTS idx_media_files ON maintenance_requests USING GIN (media_files);
```

The migration file is located at: `database/migrations/add_media_to_requests.sql`

## Step 4: Verify Setup

1. Check that the bucket `request-media` exists and is public
2. Verify the policies are active
3. Test uploading a file through the submit request form
4. Check that files appear in Storage → `request-media` bucket

## File Structure

Files will be stored with the following structure:
```
request-media/
  {user_id}/
    {timestamp}-{random}.{ext}
```

Example:
```
request-media/
  123/
    1701234567890-abc123def456.jpg
    1701234567891-xyz789ghi012.mp4
```

## Notes

- Maximum file size: 25MB per video (enforced in frontend)
- Images: No specific limit, but recommended to keep under 10MB
- Supported formats: All image and video formats supported by browsers
- Files are organized by user ID for easier management

