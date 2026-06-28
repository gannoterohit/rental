# 🔗 RoomRental - All URLs Guide

## 🌐 Base URL
```
http://localhost/roomrental
```
or
```
http://127.0.0.1/roomrental
```

---

## 👤 USER URLs (Public & Authenticated)

### **Public URLs (No Login Required):**
- **Homepage:** `/` or `/rooms`
- **Room Detail:** `/rooms/{room_id}`
  - Example: `/rooms/1`

### **User URLs (Login Required):**
- **Dashboard:** `/dashboard`
- **Profile:** `/profile`
- **Browse Rooms:** `/rooms`
- **View Room:** `/rooms/{room_id}`
- **Unlock Contact:** `/unlock/{room_id}` (POST)
- **Plans:** `/plans`
- **Subscribe:** `/subscribe` (POST)

---

## 🏠 OWNER URLs (Login Required - role: owner)

### **Owner Dashboard:**
- **Owner Dashboard:** `/owner/dashboard`

### **Room Management:**
- **List Room:** `/rooms/create`
- **My Rooms:** `/rooms` (shows owner's rooms)
- **Room Detail:** `/rooms/{room_id}`
- **Make Featured:** `/rooms/{room_id}/featured` (POST)

### **Other:**
- **Profile:** `/profile`
- **Dashboard:** `/dashboard`

---

## 👨‍💼 ADMIN URLs (Login Required - role: admin)

### **Admin Dashboard:**
- **Admin Dashboard:** `/admin/dashboard`

### **Business Settings:**
- **Business Settings:** `/admin/settings`
- **Update Settings:** `/admin/settings` (POST)
- **Add Setting:** `/admin/settings/store` (POST)

### **Plans Management:**
- **List Plans:** `/admin/plans`
- **Create Plan:** `/admin/plans/create`
- **Edit Plan:** `/admin/plans/{plan}/edit`
- **Update Plan:** `/admin/plans/{plan}` (PUT/PATCH)
- **Delete Plan:** `/admin/plans/{plan}` (DELETE)

---

## 🔐 AUTH URLs (Public)

### **Authentication:**
- **Login:** `/login`
- **Register:** `/register`
- **Logout:** `/logout` (POST)
- **Password Reset:** `/forgot-password`
- **Password Reset Link:** `/reset-password/{token}`

---

## 💳 PAYMENT URLs

### **Razorpay Integration:**
- **Create Order:** `/payment/razorpay/order` (POST)
- **Verify Payment:** `/payment/razorpay/verify` (POST)
- **Webhook:** `/webhook/razorpay` (POST)

---

## 📋 Complete URL List

### **Public Routes:**
```
GET  /                          → Homepage (Room Listing)
GET  /rooms/{room}              → Room Detail Page
POST /unlock/{room}             → Unlock Contact (AJAX)
GET  /login                     → Login Page
GET  /register                  → Register Page
POST /logout                    → Logout
```

### **Authenticated Routes (All Users):**
```
GET  /dashboard                 → User Dashboard
GET  /profile                   → Profile Edit
PATCH /profile                  → Update Profile
DELETE /profile                 → Delete Account
GET  /rooms                     → Browse Rooms
GET  /rooms/create              → Create Room (Owner)
POST /rooms                     → Store Room (Owner)
POST /rooms/{room}/featured     → Make Featured (Owner)
GET  /plans                     → View Plans
POST /subscribe                 → Subscribe to Plan
POST /book-room                 → Book Room
```

### **Owner Routes:**
```
GET  /owner/dashboard           → Owner Dashboard
```

### **Admin Routes:**
```
GET  /admin/dashboard           → Admin Dashboard
GET  /admin/settings            → Business Settings
POST /admin/settings            → Update Settings
POST /admin/settings/store      → Add New Setting
GET  /admin/plans               → List Plans
GET  /admin/plans/create        → Create Plan
POST /admin/plans               → Store Plan
GET  /admin/plans/{plan}        → Show Plan
GET  /admin/plans/{plan}/edit   → Edit Plan
PUT  /admin/plans/{plan}        → Update Plan
DELETE /admin/plans/{plan}      → Delete Plan
```

### **Payment Routes:**
```
POST /payment/razorpay/order    → Create Razorpay Order
POST /payment/razorpay/verify   → Verify Payment
POST /webhook/razorpay          → Razorpay Webhook
```

---

## 🎯 Quick Access URLs

### **For Testing:**

#### **Admin Login:**
```
URL: http://localhost/roomrental/login
Email: admin@roomrental.com
Password: password
After Login: http://localhost/roomrental/admin/dashboard
```

#### **Owner Login:**
```
URL: http://localhost/roomrental/login
Email: owner1@test.com
Password: password
After Login: http://localhost/roomrental/owner/dashboard
```

#### **User Login:**
```
URL: http://localhost/roomrental/login
Email: user1@test.com
Password: password
After Login: http://localhost/roomrental/dashboard
```

---

## 📱 Important URLs Summary

| Role | Main Dashboard | Key URLs |
|------|---------------|----------|
| **Admin** | `/admin/dashboard` | `/admin/settings`, `/admin/plans` |
| **Owner** | `/owner/dashboard` | `/rooms/create`, `/rooms` |
| **User** | `/dashboard` | `/rooms`, `/rooms/{id}` |
| **Public** | `/` (Homepage) | `/rooms`, `/rooms/{id}` |

---

## 🔑 Access Control

- **Public:** Anyone can access (homepage, room listing, room detail)
- **Authenticated:** Login required (dashboard, profile, create room)
- **Owner Only:** Must have `role='owner'` (owner dashboard)
- **Admin Only:** Must have `role='admin'` (admin dashboard, settings)

---

## ✅ All URLs Working!

**Note:** Replace `localhost/roomrental` with your actual domain in production.

