# Laragon Configuration for NymoDental

## Issue
Laragon needs to point to the `backend/public` directory instead of the root directory to serve the Laravel API properly.

## Solution

### Option 1: Update Virtual Host (Recommended)

1. Open Laragon
2. Right-click on Laragon tray icon
3. Go to `Apache` > `Sites Enabled` > `nymodental.test.conf` (or similar)
4. Or manually edit: `C:\laragon\etc\apache2\sites-enabled\auto.nymodental.test.conf`

5. Update the `DocumentRoot` to point to `backend/public`:

```apache
<VirtualHost *:80>
    DocumentRoot "C:/laragon/www/NymoDental/backend/public"
    ServerName nymodental.test
    ServerAlias *.nymodental.test
    <Directory "C:/laragon/www/NymoDental/backend/public">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

6. Restart Apache in Laragon

### Option 2: Create a Symbolic Link

Run this in Command Prompt (as Administrator):

```cmd
cd C:\laragon\www\NymoDental
mklink /D api backend\public
```

Then access the API via: `http://nymodental.test/api/`

### Option 3: Use PHP Built-in Server (Quick Test)

For quick testing, run this command in the backend directory:

```bash
cd backend
php artisan serve --host=0.0.0.0 --port=8000
```

Then update your Vue `.env` file:
```
VITE_API_URL=http://localhost:8000/api
```

And update `vite.config.js` proxy target to `http://localhost:8000`

## Testing After Setup

Once configured, test the API:

```bash
# Test API root
curl http://nymodental.test/api/

# Test login
curl -X POST http://nymodental.test/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@nymodental.com","password":"password"}'
```

## Current Architecture

```
NymoDental/
├── backend/           # Laravel API
│   ├── public/       # Laravel public directory (DocumentRoot should point here)
│   ├── app/
│   ├── routes/
│   └── ...
├── src/              # Vue frontend source
├── public/           # Vue public assets
├── index.html        # Vue entry point
├── vite.config.js
└── package.json
```

## Recommended Setup

After configuring Laragon properly:

- **Frontend (Vue)**: `http://localhost:5174/` (Vite dev server)
- **Backend (Laravel)**: `http://nymodental.test/api/` (Laragon Apache)
- **Database**: SQLite at `backend/database/database.sqlite`
