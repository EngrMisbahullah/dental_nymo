# Test User Credentials

All test users have been created with the following credentials:

## Test Users

| Role | Name | Email | Password |
|------|------|-------|----------|
| **Admin** | Admin User | `admin@nymodental.com` | `password` |
| **Dentist** | Dr. John Smith | `dentist@nymodental.com` | `password` |
| **Hygienist** | Jane Doe | `hygienist@nymodental.com` | `password` |
| **Front Desk** | Sarah Johnson | `frontdesk@nymodental.com` | `password` |
| **Patient** | Michael Brown | `patient@nymodental.com` | `password` |

## API Endpoints

### Login
```bash
POST http://nymodental.test/api/login
Content-Type: application/json

{
  "email": "admin@nymodental.com",
  "password": "password"
}
```

### Get Current User (Protected)
```bash
GET http://nymodental.test/api/me
Authorization: Bearer {your_token}
```

### Logout (Protected)
```bash
POST http://nymodental.test/api/logout
Authorization: Bearer {your_token}
```

## Testing with cURL

### Login as Admin
```bash
curl -X POST http://nymodental.test/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@nymodental.com","password":"password"}'
```

### Login as Dentist
```bash
curl -X POST http://nymodental.test/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"dentist@nymodental.com","password":"password"}'
```

### Get Current User Info
```bash
curl -X GET http://nymodental.test/api/me \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

### Logout
```bash
curl -X POST http://nymodental.test/api/logout \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

## Testing from Vue Frontend

Since your Vue app runs on `http://localhost:5174/`, you can use the Vite proxy:

```javascript
// Login
const response = await fetch('/api/login', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json',
  },
  body: JSON.stringify({
    email: 'admin@nymodental.com',
    password: 'password'
  })
});

const data = await response.json();
const token = data.token;

// Store token in localStorage
localStorage.setItem('auth_token', token);

// Get current user
const userResponse = await fetch('/api/me', {
  headers: {
    'Authorization': `Bearer ${token}`
  }
});

// Logout
await fetch('/api/logout', {
  method: 'POST',
  headers: {
    'Authorization': `Bearer ${token}`
  }
});
```

## Practice Information

**Practice Name:** NymoDental Demo Practice
**Address:** 123 High Street, London, W1A 1AA, United Kingdom
**Phone:** +44 20 1234 5678
**Email:** contact@nymodental.com

## Notes

- All users belong to the same practice
- All users are active and email verified
- Password for all test users is: `password`
- Tokens are generated using Laravel Sanctum
- Remember to include the `Authorization: Bearer {token}` header for protected routes
