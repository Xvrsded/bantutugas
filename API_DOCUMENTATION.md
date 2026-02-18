# 🔌 API Documentation (Future Ready)

Dokumentasi API untuk integrasi mobile app dan third-party services. APIs ini siap diimplementasikan di fase development selanjutnya.

## 📋 Overview

Semua endpoint API akan menggunakan RESTful conventions dengan response format JSON.

```
Base URL: https://yourdomain.com/api/v1
```

---

## 🔐 Authentication

### Token-Based Authentication (JWT) - Planned

```
Header: Authorization: Bearer {token}
```

### Get Token
```http
POST /api/v1/auth/login
Content-Type: application/json

{
  "email": "client@example.com",
  "password": "password123"
}

Response:
{
  "token": "eyJ0eXAiOiJKV1QiLCJhbGc...",
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com"
  },
  "expires_in": 3600
}
```

### Refresh Token
```http
POST /api/v1/auth/refresh
Header: Authorization: Bearer {token}

Response:
{
  "token": "eyJ0eXAiOiJKV1QiLCJhbGc...",
  "expires_in": 3600
}
```

---

## 📚 Services API

### Get All Services
```http
GET /api/v1/services
Query Parameters:
  - category=academic-sma  (optional filter)
  - search=term            (optional search)
  - sort=price             (optional sort)

Response:
{
  "success": true,
  "data": [
    {
      "id": 1,
      "name": "Tugas SMA",
      "category": "academic-sma",
      "description": "...",
      "price_start": 50000,
      "price_end": 200000,
      "features": ["Solusi lengkap", "Revisi unlimited"],
      "is_active": true,
      "icon": "book",
      "image_url": "..."
    }
  ],
  "meta": {
    "total": 11,
    "per_page": 10,
    "current_page": 1
  }
}
```

### Get Single Service
```http
GET /api/v1/services/{id}

Response:
{
  "success": true,
  "data": {
    "id": 1,
    "name": "Tugas SMA",
    "category": "academic-sma",
    "description": "...",
    "price_start": 50000,
    "price_end": 200000,
    "features": [...],
    "reviews": [
      {
        "rating": 5,
        "comment": "Bagus!",
        "user": "John Doe",
        "date": "2025-02-18"
      }
    ]
  }
}
```

### Get Service Categories
```http
GET /api/v1/services/categories

Response:
{
  "success": true,
  "data": [
    {
      "id": "academic-sma",
      "name": "Tugas SMA",
      "count": 1
    },
    {
      "id": "academic-kuliah",
      "name": "Tugas Kuliah",
      "count": 1
    },
    ...
  ]
}
```

---

## 🛒 Orders API

### Create Order
```http
POST /api/v1/orders
Header: Authorization: Bearer {token}
Content-Type: application/json

{
  "service_id": 1,
  "project_title": "Tugas Matematika SMA",
  "description": "Tugas tentang integral...",
  "deadline": "2025-03-18",
  "budget": 150000,
  "attachment_url": "https://..." (optional)
}

Response:
{
  "success": true,
  "message": "Order created successfully",
  "data": {
    "id": 123,
    "order_number": "ORD-2025-0001",
    "client_name": "John Doe",
    "service_name": "Tugas SMA",
    "status": "pending",
    "created_at": "2025-02-18T10:30:00Z",
    "expected_completion": "2025-03-18"
  }
}
```

### Get User Orders
```http
GET /api/v1/orders
Header: Authorization: Bearer {token}
Query Parameters:
  - status=pending        (optional filter)
  - sort=-created_at      (optional sort)
  - per_page=10           (pagination)

Response:
{
  "success": true,
  "data": [
    {
      "id": 123,
      "order_number": "ORD-2025-0001",
      "service_name": "Tugas SMA",
      "status": "pending",
      "created_at": "2025-02-18",
      "deadline": "2025-03-18",
      "progress": 0
    }
  ],
  "meta": {
    "total": 5,
    "per_page": 10,
    "current_page": 1
  }
}
```

### Get Order Detail
```http
GET /api/v1/orders/{order_id}
Header: Authorization: Bearer {token}

Response:
{
  "success": true,
  "data": {
    "id": 123,
    "order_number": "ORD-2025-0001",
    "client_name": "John Doe",
    "service_name": "Tugas SMA",
    "project_title": "Tugas Matematika",
    "description": "...",
    "status": "in_progress",
    "progress_percentage": 50,
    "budget": 150000,
    "deadline": "2025-03-18",
    "created_at": "2025-02-18",
    "timeline": [
      {
        "date": "2025-02-18",
        "status": "pending",
        "message": "Order received"
      },
      {
        "date": "2025-02-19",
        "status": "accepted",
        "message": "Order accepted by admin"
      }
    ],
    "attachments": [
      {
        "id": 1,
        "filename": "tugas.pdf",
        "size": 1024000,
        "download_url": "..."
      }
    ]
  }
}
```

### Update Order Status
```http
PATCH /api/v1/orders/{order_id}
Header: Authorization: Bearer {token}
Content-Type: application/json

{
  "status": "completed",
  "notes": "Work completed",
  "attachments": [
    {
      "file": "solution.pdf"
    }
  ]
}

Response:
{
  "success": true,
  "message": "Order updated successfully",
  "data": {
    "id": 123,
    "status": "completed",
    "updated_at": "2025-02-28T15:30:00Z"
  }
}
```

### Cancel Order
```http
DELETE /api/v1/orders/{order_id}
Header: Authorization: Bearer {token}

Response:
{
  "success": true,
  "message": "Order cancelled successfully"
}
```

---

## 💬 Chat / Messaging API (Planned)

### Send Message
```http
POST /api/v1/orders/{order_id}/messages
Header: Authorization: Bearer {token}
Content-Type: application/json

{
  "message": "Apakah progress-nya sudah dimulai?",
  "file": null (optional)
}

Response:
{
  "success": true,
  "data": {
    "id": 456,
    "message": "...",
    "sender": "John Doe",
    "timestamp": "2025-02-18T10:30:00Z"
  }
}
```

### Get Messages
```http
GET /api/v1/orders/{order_id}/messages
Header: Authorization: Bearer {token}

Response:
{
  "success": true,
  "data": [
    {
      "id": 456,
      "message": "...",
      "sender": "John Doe",
      "is_admin": false,
      "timestamp": "2025-02-18T10:30:00Z"
    }
  ]
}
```

---

## 👤 User Profile API

### Get Profile
```http
GET /api/v1/profile
Header: Authorization: Bearer {token}

Response:
{
  "success": true,
  "data": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "phone": "082123456789",
    "avatar_url": "...",
    "total_orders": 5,
    "completed_orders": 3,
    "balance": 0
  }
}
```

### Update Profile
```http
PUT /api/v1/profile
Header: Authorization: Bearer {token}
Content-Type: application/json

{
  "name": "John Updated",
  "phone": "082123456789",
  "avatar": "file"
}

Response:
{
  "success": true,
  "message": "Profile updated successfully",
  "data": { ... }
}
```

### Change Password
```http
POST /api/v1/profile/change-password
Header: Authorization: Bearer {token}
Content-Type: application/json

{
  "current_password": "old_password",
  "new_password": "new_password",
  "new_password_confirmation": "new_password"
}

Response:
{
  "success": true,
  "message": "Password changed successfully"
}
```

---

## 📊 Admin API (Protected)

### Dashboard Statistics
```http
GET /api/v1/admin/dashboard
Header: Authorization: Bearer {admin_token}

Response:
{
  "success": true,
  "data": {
    "total_orders": 150,
    "pending_orders": 12,
    "in_progress_orders": 8,
    "completed_orders": 120,
    "total_revenue": 50000000,
    "total_clients": 120,
    "total_services": 11
  }
}
```

### Get All Orders (Admin)
```http
GET /api/v1/admin/orders
Header: Authorization: Bearer {admin_token}
Query Parameters:
  - status=pending
  - search=client_name
  - date_from=2025-02-01
  - date_to=2025-02-28

Response:
{
  "success": true,
  "data": [
    {
      "id": 123,
      "client_name": "John Doe",
      "service_name": "Tugas SMA",
      "status": "pending",
      "budget": 150000,
      "created_at": "2025-02-18"
    }
  ]
}
```

### Update Order (Admin)
```http
PATCH /api/v1/admin/orders/{order_id}
Header: Authorization: Bearer {admin_token}
Content-Type: application/json

{
  "status": "accepted",
  "admin_notes": "Mulai dikerjakan",
  "assigned_to": 1 (user_id)
}

Response:
{
  "success": true,
  "message": "Order updated successfully"
}
```

---

## 🌐 Portfolio API

### Get All Portfolios
```http
GET /api/v1/portfolios
Query Parameters:
  - category=iot
  - featured=true
  - per_page=10

Response:
{
  "success": true,
  "data": [
    {
      "id": 1,
      "title": "Sistem IoT Smart Home",
      "category": "iot",
      "description": "...",
      "client_name": "PT Maju",
      "technologies": ["Arduino", "Firebase"],
      "image_url": "...",
      "created_at": "2025-02-18"
    }
  ]
}
```

---

## 🔔 Notifications API

### Get Notifications
```http
GET /api/v1/notifications
Header: Authorization: Bearer {token}

Response:
{
  "success": true,
  "data": [
    {
      "id": 1,
      "type": "order_status_update",
      "title": "Order Status Updated",
      "message": "Your order #123 status changed to in_progress",
      "read": false,
      "created_at": "2025-02-18T10:30:00Z"
    }
  ]
}
```

### Mark Notification as Read
```http
PATCH /api/v1/notifications/{notification_id}
Header: Authorization: Bearer {token}

Response:
{
  "success": true,
  "message": "Notification marked as read"
}
```

---

## 📨 Contact API

### Send Contact Message
```http
POST /api/v1/contact
Content-Type: application/json

{
  "name": "John Doe",
  "email": "john@example.com",
  "subject": "General Inquiry",
  "message": "I want to know more about..."
}

Response:
{
  "success": true,
  "message": "Message sent successfully. We'll contact you soon!"
}
```

---

## ❌ Error Handling

### Error Response Format
```json
{
  "success": false,
  "message": "Error message here",
  "errors": {
    "field_name": ["Error message 1", "Error message 2"]
  }
}
```

### HTTP Status Codes
| Code | Meaning |
|------|---------|
| 200 | ✅ Success |
| 201 | ✅ Created |
| 400 | ❌ Bad Request |
| 401 | ❌ Unauthorized |
| 403 | ❌ Forbidden |
| 404 | ❌ Not Found |
| 422 | ❌ Validation Error |
| 500 | ❌ Server Error |

---

## 🔄 Rate Limiting

```
Rate Limit: 1000 requests per hour per IP
Headers:
  X-RateLimit-Limit: 1000
  X-RateLimit-Remaining: 999
  X-RateLimit-Reset: 1645112400
```

---

## 📦 Pagination

All list endpoints support pagination:

```
Query Parameters:
  - page=1        (default: 1)
  - per_page=10   (default: 10, max: 100)
```

Response includes:
```json
{
  "meta": {
    "total": 150,
    "per_page": 10,
    "current_page": 1,
    "last_page": 15,
    "from": 1,
    "to": 10
  }
}
```

---

## 🧪 Testing

### Postman Collection
Will be provided in `/docs/api/postman_collection.json`

### cURL Examples
```bash
# Get all services
curl -X GET "https://yourdomain.com/api/v1/services"

# Create order (requires auth)
curl -X POST "https://yourdomain.com/api/v1/orders" \
  -H "Authorization: Bearer {token}" \
  -H "Content-Type: application/json" \
  -d '{"service_id": 1, "project_title": "..."}'
```

---

## 📝 Changelog (API)

### v1.0.0 (Planned - Q2 2025)
- Services endpoints
- Orders endpoints
- User authentication
- Profile management
- Portfolio endpoints

### v1.1.0 (Planned - Q3 2025)
- Messaging/Chat API
- Notifications API
- Admin endpoints
- Analytics API

### v2.0.0 (Planned - Q4 2025)
- Payment API
- Webhook support
- GraphQL endpoint

---

**Note:** This API documentation is for planned implementation. Current version (v1.0.0) has web-based interface only. API will be available in future updates.

**Expected API Launch:** Q2 2025
