# Officials System - Quick Start Guide

## What's New

The system now includes a complete **Officials Tracking System** that allows you to:

✅ **Separate official accounts** - Officials login with username/password (not email)  
✅ **Track all official actions** - Every status change, priority update, and assignment is logged  
✅ **Full audit trail** - See who did what and when  
✅ **Accountability** - Know which official handled each request  

## Quick Setup

### 1. Database Setup

Run the SQL schema to create the necessary tables:

```bash
mysql -u your_user -p your_database < database/schema/officials_system_simple.sql
```

This creates:
- `officials` table
- Enhanced `maintenance_requests` (adds priority, assigned_to)
- `request_activity_log` table

### 2. Set Environment Variable

In Netlify Dashboard → Site Settings → Environment Variables:

- **Key**: `ADMIN_CREATE_KEY`
- **Value**: Your secret key (e.g., `my-secret-admin-key-2024`)

### 3. Create Your First Official Account

```bash
curl -X POST https://your-site.netlify.app/.netlify/functions/create-official \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Admin Official",
    "username": "admin",
    "password": "securepassword123",
    "department": "Administration",
    "admin_key": "my-secret-admin-key-2024"
  }'
```

### 4. Login as Official

1. Go to: `https://your-site.netlify.app/login/official`
2. Enter username and password
3. You'll be redirected to the official dashboard

## How It Works

### Official Login
- Officials use **username/password** (not email)
- Login at `/login/official`
- Separate from resident accounts

### Activity Tracking
Every action is automatically logged:

| Action | What Gets Logged |
|--------|------------------|
| Status Change | Who changed status, from what to what, when |
| Priority Set | Who set priority, what priority level, when |
| Assignment | Who assigned/unassigned, to which official, when |
| Notes | Optional descriptions with each action |

### Example Scenario

**Broken Street Light Request:**

1. Resident submits → Status: `pending`, Priority: `medium`
2. Official A assigns to self → **Logged**: "Official A assigned request"
3. Official A sets priority to `high` → **Logged**: "Official A changed priority from medium to high"
4. Official A changes status to `in_progress` → **Logged**: "Official A changed status from pending to in_progress"
5. Official B completes it → **Logged**: "Official B changed status from in_progress to completed"

**You can see:**
- Official A started the work
- Official B completed it
- Priority was raised to high
- Full timeline of all actions

## API Endpoints

### Update Status
```bash
PATCH /.netlify/functions/api/requests/{id}/status
{ "status": "active", "description": "Starting work" }
```

### Set Priority
```bash
PATCH /.netlify/functions/api/requests/{id}/priority
{ "priority": "high", "description": "Urgent safety issue" }
```

### Assign Request
```bash
PATCH /.netlify/functions/api/requests/{id}/assign
{ "assigned_to": 1, "description": "Assigned to team" }
```

### Get Activity Log
```bash
GET /.netlify/functions/api/requests/{id}/activity
```

## Files Created

- `database/schema/officials_system.sql` - Database schema
- `netlify/functions/official-login.js` - Official login handler
- `netlify/functions/create-official.js` - Admin function to create officials
- `public/js/login-official.js` - Updated login JavaScript
- `resources/views/login_official.blade.php` - Updated login page
- `OFFICIAL_ACCOUNT_SETUP.md` - Complete setup guide

## Documentation

For complete documentation, see:
- **`OFFICIAL_ACCOUNT_SETUP.md`** - Full setup and usage guide
- **`database/schema/officials_system.sql`** - Database schema with comments

## Support

If you encounter issues:
1. Check `OFFICIAL_ACCOUNT_SETUP.md` troubleshooting section
2. Verify database tables are created
3. Check environment variables are set
4. Review server logs for errors

