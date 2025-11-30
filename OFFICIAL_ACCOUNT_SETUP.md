# Official Account Setup Guide

## Overview
Official accounts are created by administrators/developers only. Officials login with **username and password** (not email). All actions performed by officials on maintenance requests are automatically logged for tracking and accountability.

## Database Setup

### Step 1: Run Database Schema

Run the SQL schema file to create the necessary tables:

```bash
# Option 1: Use the full schema (if your MySQL supports IF NOT EXISTS in ALTER TABLE)
mysql -u your_user -p your_database < database/schema/officials_system.sql

# Option 2: Use the simple schema (run commands one by one)
mysql -u your_user -p your_database < database/schema/officials_system_simple.sql
```

This will create:
- `officials` table - for official accounts
- Enhanced `maintenance_requests` table - adds priority and assigned_to fields
- `request_activity_log` table - tracks all official actions

## Creating Official Accounts

### Method 1: Using the Admin Function (Recommended)

#### Step 1: Set Environment Variable
In your Netlify dashboard, add:
- **Key**: `ADMIN_CREATE_KEY`
- **Value**: A strong secret key (e.g., `your-super-secret-admin-key-2024`)

#### Step 2: Create Account via API

Use curl, Postman, or any HTTP client:

```bash
curl -X POST https://your-site.netlify.app/.netlify/functions/create-official \
  -H "Content-Type: application/json" \
  -d '{
    "name": "John Doe",
    "username": "johndoe",
    "password": "securepassword123",
    "department": "Public Works",
    "position": "Maintenance Manager",
    "phone": "09123456789",
    "email": "john@city.gov",
    "admin_key": "your-super-secret-admin-key-2024"
  }'
```

**Required fields:**
- `name` - Full name of the official
- `username` - Unique username for login
- `password` - Password (min 6 characters)
- `admin_key` - Your admin key from environment variables

**Optional fields:**
- `department` - Department name
- `position` - Job position
- `phone` - Phone number
- `email` - Email address

### Method 2: Direct Database Insert

If you have direct database access:

```sql
-- First, hash the password using bcrypt
-- You can use an online bcrypt generator or Node.js:
-- const bcrypt = require('bcryptjs');
-- const hash = await bcrypt.hash('yourpassword', 10);

INSERT INTO officials (name, username, password, department, position, phone, email, is_active)
VALUES (
  'Admin Official',
  'admin',
  '$2a$10$...', -- hashed password (use bcrypt)
  'Administration',
  'System Administrator',
  '09123456789',
  'admin@city.gov',
  true
);
```

### Method 3: Using Local Development

1. Make sure your local server is running: `netlify dev`
2. Create a simple script or use curl:

```bash
curl -X POST http://localhost:8888/.netlify/functions/create-official \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Test Official",
    "username": "testofficial",
    "password": "test123",
    "admin_key": "your-secret-admin-key"
  }'
```

## Official Login

Officials login at: `/login/official`

- **Username**: The username you created
- **Password**: The password you set

After successful login, officials are redirected to `/dashboard/official`

## Activity Tracking

All actions performed by officials are automatically logged:

### Tracked Actions:
1. **Status Changes** - When an official changes request status (pending → active → completed)
2. **Priority Changes** - When an official sets/changes priority (low, medium, high, urgent)
3. **Assignments** - When an official assigns/unassigns a request
4. **Notes** - Optional descriptions added with each action

### Viewing Activity Logs

Get activity log for a specific request:

```bash
GET /.netlify/functions/api/requests/{request_id}/activity
```

Response includes:
- Action type
- Old and new values
- Official who performed the action
- Timestamp
- Optional description/notes

## API Endpoints for Officials

### Update Request Status
```bash
PATCH /.netlify/functions/api/requests/{id}/status
{
  "status": "active",
  "description": "Starting work on this request"
}
```

### Update Request Priority
```bash
PATCH /.netlify/functions/api/requests/{id}/priority
{
  "priority": "high",
  "description": "Urgent safety issue"
}
```

### Assign Request
```bash
PATCH /.netlify/functions/api/requests/{id}/assign
{
  "assigned_to": 1,  // official_id
  "description": "Assigned to maintenance team"
}
```

### Legacy Update (supports multiple fields)
```bash
PATCH /.netlify/functions/api/requests/{id}
{
  "status": "active",
  "priority": "high",
  "assigned_to": 1
}
```

## Example Official Accounts

Here are some example accounts you might want to create:

### 1. Main Administrator
```json
{
  "name": "City Administrator",
  "username": "admin",
  "password": "secure_admin_pass_2024",
  "department": "Administration",
  "position": "City Administrator"
}
```

### 2. Maintenance Manager
```json
{
  "name": "Maintenance Manager",
  "username": "maint_manager",
  "password": "secure_maint_pass_2024",
  "department": "Public Works",
  "position": "Maintenance Manager"
}
```

### 3. Department Head
```json
{
  "name": "Department Head",
  "username": "dept_head",
  "password": "secure_dept_pass_2024",
  "department": "Public Works",
  "position": "Department Head"
}
```

## Security Notes

1. **Never commit the `ADMIN_CREATE_KEY` to version control**
2. **Use strong passwords** for official accounts
3. **Limit access** to the admin key
4. **Consider IP whitelisting** for the create-official function in production
5. **Regularly review activity logs** for security auditing
6. **Deactivate unused accounts** by setting `is_active = false` in the database

## Troubleshooting

### "Unauthorized. Invalid admin key"
- Check that `ADMIN_CREATE_KEY` is set in Netlify environment variables
- Verify you're using the correct key in your request
- Make sure you redeployed after setting the environment variable

### "Username already exists"
- The username is already taken
- Use a different username or check existing accounts

### "Database error: Table 'officials' doesn't exist"
- Run the database schema SQL file first
- Check that you're connected to the correct database

### Login not working
- Verify the username and password are correct
- Check that `is_active = true` in the database
- Verify the official-login function is deployed

### Activity logs not appearing
- Check that the `request_activity_log` table exists
- Verify the official_id in the JWT token matches an official in the database
- Check server logs for any errors during activity logging

## Query Examples

### Find which official changed a request's status
```sql
SELECT 
    ral.action_type,
    ral.old_value,
    ral.new_value,
    ral.created_at,
    o.name as official_name,
    o.department
FROM request_activity_log ral
JOIN officials o ON ral.official_id = o.id
WHERE ral.request_id = 123
AND ral.action_type = 'status_changed'
ORDER BY ral.created_at DESC;
```

### Find which official set high priority
```sql
SELECT 
    o.name,
    o.department,
    ral.created_at,
    mr.title
FROM request_activity_log ral
JOIN officials o ON ral.official_id = o.id
JOIN maintenance_requests mr ON ral.request_id = mr.id
WHERE ral.action_type = 'priority_set'
AND ral.new_value = 'high'
ORDER BY ral.created_at DESC;
```

### Get activity summary for an official
```sql
SELECT 
    o.name,
    COUNT(*) as total_actions,
    COUNT(DISTINCT ral.request_id) as requests_handled,
    SUM(CASE WHEN ral.action_type = 'status_changed' THEN 1 ELSE 0 END) as status_changes,
    SUM(CASE WHEN ral.action_type = 'priority_set' THEN 1 ELSE 0 END) as priority_changes
FROM officials o
LEFT JOIN request_activity_log ral ON o.id = ral.official_id
WHERE o.id = 1
GROUP BY o.id, o.name;
```

## Next Steps

1. **Create your first official account** using Method 1 or 2
2. **Test the login** at `/login/official`
3. **Update a request status** and verify it's logged
4. **Check activity logs** using the API endpoint
5. **Create additional official accounts** as needed

