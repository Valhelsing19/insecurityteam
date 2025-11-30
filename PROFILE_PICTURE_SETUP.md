# Profile Picture Storage Setup Guide

## Step 1: Create Storage Bucket

1. Go to your Supabase Dashboard
2. Navigate to **Storage** in the left sidebar
3. Click **"New bucket"**
4. Name it: `profile-pictures`
5. Set it to **Public** (so profile pictures can be viewed)
6. Click **"Create bucket"**

## Step 2: Set Up Storage Policies

### Public Read Access Policy

1. Go to **Storage** → **Policies** → `profile-pictures`
2. Click **"New Policy"**
3. Select **"For full customization"**
4. Name: `Public Read Access`
5. Policy definition:
```sql
CREATE POLICY "Public Read Access"
ON storage.objects FOR SELECT
USING (bucket_id = 'profile-pictures');
```

### Authenticated Upload Policy

1. Create another policy:
2. Name: `Authenticated Upload`
3. Policy definition:
```sql
CREATE POLICY "Authenticated Upload"
ON storage.objects FOR INSERT
WITH CHECK (
  bucket_id = 'profile-pictures' AND
  auth.role() = 'authenticated'
);
```

### Authenticated Update/Delete Policy

To allow users to update/delete their own profile pictures:

```sql
CREATE POLICY "Users can update own profile pictures"
ON storage.objects FOR UPDATE
USING (
  bucket_id = 'profile-pictures' AND
  (storage.foldername(name))[1] = auth.uid()::text
);

CREATE POLICY "Users can delete own profile pictures"
ON storage.objects FOR DELETE
USING (
  bucket_id = 'profile-pictures' AND
  (storage.foldername(name))[1] = auth.uid()::text
);
```

## Step 3: Verify Database Column

Make sure your `users` table has a `picture` column:

```sql
ALTER TABLE users ADD COLUMN IF NOT EXISTS picture VARCHAR(500) NULL;
```

If you need to add it, run:
```sql
ALTER TABLE users ADD COLUMN picture VARCHAR(500) NULL;
```

## Step 4: Verify Setup

1. Check that the bucket `profile-pictures` exists and is public
2. Verify the policies are active
3. Test uploading a profile picture through the settings page
4. Check that files appear in Storage → `profile-pictures` bucket

## File Structure

Files will be stored with the following structure:
```
profile-pictures/
  {user_id}/
    profile-{timestamp}-{random}.{ext}
```

Example:
```
profile-pictures/
  123/
    profile-1701234567890-abc123def456.jpg
```

## Notes

- Maximum file size: 5MB (enforced in frontend)
- Supported formats: All image formats supported by browsers (JPEG, PNG, GIF, WebP, etc.)
- Files are organized by user ID for easier management
- When a user uploads a new profile picture, it will overwrite their previous one (upsert: true)
- Profile pictures are automatically displayed in the settings page and can be used throughout the application

## Testing

1. Navigate to the Settings page
2. Click on the profile picture/avatar
3. Select an image file
4. The image should upload automatically and display immediately
5. Check the browser console for any errors
6. Verify the image appears in Supabase Storage
7. Check the database to confirm the `picture` column is updated with the URL

