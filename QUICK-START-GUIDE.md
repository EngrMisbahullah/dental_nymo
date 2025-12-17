# NymoDental Quick Start Guide
## Get Up and Running in 10 Minutes

**Last Updated:** October 22, 2025

---

## Prerequisites

Before you begin, ensure you have:

- ✅ **Node.js 18+** installed ([Download](https://nodejs.org/))
- ✅ **MySQL 8.0+** installed and running ([Download](https://dev.mysql.com/downloads/))
- ✅ **Git** installed ([Download](https://git-scm.com/))
- ✅ **Code Editor** (VS Code recommended)

---

## Step 1: Database Setup (3 minutes)

### 1.1 Create Database

Open your MySQL client (or use command line):

```bash
mysql -u root -p
```

Create the database:

```sql
CREATE DATABASE nymodental CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
exit
```

### 1.2 Run Migrations

From the project root directory:

```bash
mysql -u root -p nymodental < database/migrations/001_create_acl_tables.sql
```

Enter your MySQL password when prompted.

**Expected output:** No errors, tables created successfully.

**Verify:**
```bash
mysql -u root -p nymodental -e "SHOW TABLES;"
```

You should see 8 tables:
- audit_log
- permissions
- practices
- role_permissions
- roles
- sessions
- user_roles
- users

---

## Step 2: Backend Setup (3 minutes)

### 2.1 Install Dependencies

```bash
cd backend
npm install
```

This will install all required packages (~50 packages, ~30MB).

### 2.2 Configure Environment

Create `.env` file:

```bash
cp .env.example .env
```

Edit `.env` with your settings:

```env
# Database Configuration
DB_HOST=localhost
DB_PORT=3306
DB_NAME=nymodental
DB_USER=root
DB_PASSWORD=your_mysql_password

# JWT Secrets (IMPORTANT: Change these!)
JWT_SECRET=change-this-to-random-secret-key-123456789
JWT_REFRESH_SECRET=change-this-to-different-random-key-987654321

# Frontend URL
FRONTEND_URL=http://localhost:5173
```

**⚠️ IMPORTANT:** Change the JWT secrets to random strings!

**Generate random secrets:**
```bash
node -e "console.log(require('crypto').randomBytes(32).toString('hex'))"
```

### 2.3 Create First Admin User

Run the interactive setup:

```bash
node src/utils/createAdmin.js
```

Follow the prompts:

```
Practice Name: My Dental Practice
Practice Email: contact@mydental.com
Practice Phone: +44 20 1234 5678

Admin First Name: John
Admin Last Name: Smith
Admin Email: admin@mydental.com
Admin Password: Admin123!@#
Confirm Password: Admin123!@#
```

**✅ Success!** You should see:
```
✅ Admin User Created Successfully!
User ID: 1
Email: admin@mydental.com
Name: John Smith
Practice ID: 1
Role: Practice Owner/Admin
```

---

## Step 3: Start Backend Server (1 minute)

### 3.1 Development Mode (with auto-reload)

```bash
npm run dev
```

**Expected output:**
```
========================================
🚀 NymoDental Backend Server
========================================
Environment: development
Server running on: http://localhost:3000
Health check: http://localhost:3000/health
API info: http://localhost:3000/api
========================================
```

### 3.2 Test the API

Open a new terminal and test:

```bash
# Health check
curl http://localhost:3000/health
```

**Expected response:**
```json
{
  "status": "OK",
  "message": "NymoDental API is running",
  "timestamp": "2025-10-22T...",
  "environment": "development"
}
```

---

## Step 4: Test Authentication (3 minutes)

### 4.1 Login

```bash
curl -X POST http://localhost:3000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "admin@mydental.com",
    "password": "Admin123!@#"
  }'
```

**Expected response:**
```json
{
  "message": "Login successful",
  "user": {
    "id": 1,
    "email": "admin@mydental.com",
    "first_name": "John",
    "last_name": "Smith",
    "roles": [...],
    "permissions": [...]
  },
  "tokens": {
    "accessToken": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...",
    "refreshToken": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...",
    "expiresIn": "15m",
    "tokenType": "Bearer"
  }
}
```

**✅ Success!** Copy the `accessToken` for the next step.

### 4.2 Access Protected Route

```bash
curl http://localhost:3000/api/auth/me \
  -H "Authorization: Bearer YOUR_ACCESS_TOKEN_HERE"
```

Replace `YOUR_ACCESS_TOKEN_HERE` with the token from step 4.1.

**Expected response:**
```json
{
  "user": {
    "id": 1,
    "email": "admin@mydental.com",
    "first_name": "John",
    "last_name": "Smith",
    "roles": [...]
  }
}
```

**✅ Authentication is working!**

---

## Step 5: Frontend Setup (Coming Next)

The frontend Vue.js application will connect to this backend.

**Current Status:**
- ✅ Backend API ready
- ✅ Database ready
- ✅ Authentication working
- 🔄 Frontend in progress

**Next Steps:**
1. Build Vue.js permission directive
2. Create login page
3. Implement JWT storage
4. Add route guards
5. Build user management interface

---

## Troubleshooting

### Issue: Database connection failed

**Error:** `❌ Database connection failed: ER_ACCESS_DENIED_ERROR`

**Solution:**
1. Check MySQL is running
2. Verify credentials in `.env`
3. Test MySQL connection:
   ```bash
   mysql -u root -p -e "SELECT 1"
   ```

### Issue: Tables not found

**Error:** `ER_NO_SUCH_TABLE: Table 'nymodental.users' doesn't exist`

**Solution:**
Run migrations again:
```bash
mysql -u root -p nymodental < database/migrations/001_create_acl_tables.sql
```

### Issue: Port 3000 already in use

**Error:** `EADDRINUSE: address already in use :::3000`

**Solution:**
1. Kill the process using port 3000:
   ```bash
   # Windows
   netstat -ano | findstr :3000
   taskkill /PID <PID> /F

   # Mac/Linux
   lsof -ti:3000 | xargs kill
   ```

2. Or change port in `.env`:
   ```env
   PORT=3001
   ```

### Issue: JWT token invalid

**Error:** `Unauthorized: Invalid access token`

**Solution:**
1. Check token is being sent: `Authorization: Bearer <token>`
2. Verify JWT secrets match in `.env`
3. Token may have expired (15min), request a new one

### Issue: Permission denied errors

**Error:** `Forbidden: You do not have permission: patients.view`

**Solution:**
1. Check user has correct role:
   ```sql
   SELECT r.name FROM roles r
   INNER JOIN user_roles ur ON r.id = ur.role_id
   WHERE ur.user_id = 1;
   ```

2. Check role has permission:
   ```sql
   SELECT p.permission_key FROM permissions p
   INNER JOIN role_permissions rp ON p.id = rp.permission_id
   WHERE rp.role_id = 'ROLE_ADMIN';
   ```

### Issue: Failed login - account locked

**Error:** `Account is locked due to too many failed login attempts`

**Solution:**
Unlock the account manually:
```sql
UPDATE users
SET is_locked = FALSE, failed_login_attempts = 0
WHERE email = 'admin@mydental.com';
```

---

## Verify Installation Checklist

Use this checklist to verify everything is working:

### Database
- [ ] MySQL is running
- [ ] Database `nymodental` exists
- [ ] 8 tables created
- [ ] 5 roles seeded
- [ ] 40+ permissions seeded
- [ ] Role-permission mappings exist

### Backend
- [ ] Node modules installed
- [ ] `.env` file configured
- [ ] Admin user created
- [ ] Server starts without errors
- [ ] Health check returns OK
- [ ] Can login with admin user
- [ ] Access token received
- [ ] Protected route accessible with token

### Test Commands

Run all these to verify:

```bash
# 1. Check database
mysql -u root -p nymodental -e "SELECT COUNT(*) as role_count FROM roles;"
# Expected: 5

mysql -u root -p nymodental -e "SELECT COUNT(*) as permission_count FROM permissions;"
# Expected: 40+

# 2. Check backend
curl http://localhost:3000/health
# Expected: {"status": "OK"}

# 3. Check authentication
curl -X POST http://localhost:3000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@mydental.com","password":"Admin123!@#"}'
# Expected: Login successful with tokens
```

---

## Next Steps

Now that your backend is running, you can:

### 1. Explore the API

Use tools like:
- **Postman** - https://www.postman.com/
- **Insomnia** - https://insomnia.rest/
- **Thunder Client** (VS Code extension)

Import the API endpoints and start testing.

### 2. Read the Documentation

- **Backend README:** `backend/README.md`
- **ACL Documentation:** `ACL-Roles-Permissions.md`
- **Implementation Summary:** `PHASE1-IMPLEMENTATION-SUMMARY.md`

### 3. Create More Users

You can create users with different roles for testing:

```sql
-- Create a dentist user
INSERT INTO users (practice_id, email, password_hash, first_name, last_name, is_active)
VALUES (1, 'dentist@mydental.com', 'HASHED_PASSWORD', 'Jane', 'Doe', TRUE);

SET @user_id = LAST_INSERT_ID();

INSERT INTO user_roles (user_id, role_id)
VALUES (@user_id, 'ROLE_DENTIST');
```

Use Node.js to hash password:
```bash
node -e "const bcrypt = require('bcryptjs'); console.log(bcrypt.hashSync('Dentist123!', 10));"
```

### 4. Start Building Frontend

The next phase is to build the Vue.js frontend with:
- Login page
- Permission system
- User management
- Dashboard

---

## Useful Commands

### Backend

```bash
# Start development server (with auto-reload)
npm run dev

# Start production server
npm start

# Install new package
npm install package-name

# Create new admin user
node src/utils/createAdmin.js
```

### Database

```bash
# Connect to MySQL
mysql -u root -p

# Show databases
SHOW DATABASES;

# Use nymodental database
USE nymodental;

# Show tables
SHOW TABLES;

# View users
SELECT id, email, first_name, last_name, is_active FROM users;

# View user roles
SELECT u.email, r.name as role
FROM users u
INNER JOIN user_roles ur ON u.id = ur.user_id
INNER JOIN roles r ON ur.role_id = r.id;

# View audit log (last 10 entries)
SELECT * FROM audit_log ORDER BY created_at DESC LIMIT 10;
```

### Testing

```bash
# Test health endpoint
curl http://localhost:3000/health

# Test login
curl -X POST http://localhost:3000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@mydental.com","password":"Admin123!@#"}'

# Test protected route (replace TOKEN)
curl http://localhost:3000/api/auth/me \
  -H "Authorization: Bearer TOKEN"
```

---

## Support & Resources

### Documentation
- Backend API: `backend/README.md`
- ACL System: `ACL-Roles-Permissions.md`
- Competitive Strategy: `NymoDental-Competitive-Strategy.md`

### Contact
- Email: support@nymodental.com
- GitHub: [project-url]

---

## What You've Accomplished

✅ **Database:** Fully configured with 8 tables and seed data
✅ **Backend API:** Running with authentication and authorization
✅ **User Roles:** 5 roles configured (Admin, Dentist, Hygienist, Front Desk, Patient)
✅ **Permissions:** 40+ module-level permissions
✅ **Security:** JWT tokens, password hashing, audit logging
✅ **Admin User:** Created and tested

**Congratulations!** Your NymoDental backend is ready for development.

---

**Next Milestone:** Build the Vue.js frontend with permission system

**Estimated Time:** 2-3 weeks for complete Phase 1
