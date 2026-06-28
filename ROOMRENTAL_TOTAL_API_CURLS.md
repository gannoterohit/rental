# 🚀 RoomRental ABSOLUTE TOTAL API Master Reference (89 Endpoints)

This is the **Definitive Master List**. Every single API is here with its **Full Body** and **CURL Command**. Perfect for one-click Postman import and building App Forms.

---

## 📂 1. PUBLIC APIs (No Auth Required)

### 1. Get Settings
`curl --location --request GET '{{base_url}}/settings'`

### 2. Send OTP
`curl --location --request POST '{{base_url}}/auth/send-otp' --header 'Content-Type: application/json' --data-raw '{"email": "test@example.com"}'`

### 3. Register New User
`curl --location --request POST '{{base_url}}/auth/register' --header 'Content-Type: application/json' --data-raw '{"name": "John Doe", "email": "j@t.com", "phone": "123", "role": "user", "referral_code": "REF12"}'`

### 4. Login
`curl --location --request POST '{{base_url}}/auth/login' --header 'Content-Type: application/json' --data-raw '{"email": "test@test.com", "otp": "123456"}'`

### 5. List Rooms (with Filters)
`curl --location --request GET '{{base_url}}/rooms?city=Bhopal&room_type=single&furnishing_type=furnished&tenant_type=bachelors&min_rent=5000&max_rent=15000&search=nearby'`

### 6. Room Detail
`curl --location --request GET '{{base_url}}/rooms/1'`

### 7. Similar Suggestion
`curl --location --request GET '{{base_url}}/rooms/1/similar'`

### 8. Detect City (GPS)
`curl --location --request POST '{{base_url}}/rooms/detect-city' --header 'Content-Type: application/json' --data-raw '{"lat": 23.2, "lng": 77.4}'`

### 9. Get All Cities
`curl --location --request GET '{{base_url}}/cities'`

### 10. List Blogs
`curl --location --request GET '{{base_url}}/blogs'`

### 11. Blog Detail
`curl --location --request GET '{{base_url}}/blogs/test-slug'`

### 12. Static Pages
`curl --location --request GET '{{base_url}}/pages/privacy-policy'`

### 13. FAQ List
`curl --location --request GET '{{base_url}}/faq'`

### 14. Newsletter
`curl --location --request POST '{{base_url}}/newsletter/subscribe' --data-raw '{"email": "test@t.com"}'`

### 15. Contact Support
`curl --location --request POST '{{base_url}}/contact' --data-raw '{"name":"A","email":"a@t.com","message":"Hi"}'`

### 16. Dashboard Offers
`curl --location --request GET '{{base_url}}/offers'`

---

## 📂 2. USER APIs (Requires Bearer Token)

### 17. Get My Profile
`curl --location --request GET '{{base_url}}/auth/me' --header 'Authorization: Bearer {{token}}'`

### 18. Logout
`curl --location --request POST '{{base_url}}/auth/logout' --header 'Authorization: Bearer {{token}}'`

### 19. Update Profile
`curl --location --request POST '{{base_url}}/profile/update' --header 'Authorization: Bearer {{token}}' --data-raw '{"name":"New Name","phone":"9988","avatar":"BINARY"}'`

### 20. Delete Request OTP
`curl --location --request POST '{{base_url}}/profile/delete-otp' --header 'Authorization: Bearer {{token}}'`

### 21. Delete Account
`curl --location --request DELETE '{{base_url}}/profile' --header 'Authorization: Bearer {{token}}' --data-raw '{"otp":"1234"}'`

### 22. User Dashboard
`curl --location --request GET '{{base_url}}/dashboard' --header 'Authorization: Bearer {{token}}'`

### 23. Referral Stats
`curl --location --request GET '{{base_url}}/referral-stats' --header 'Authorization: Bearer {{token}}'`

### 24. Create Payment Order
`curl --location --request POST '{{base_url}}/payments/create-order' --header 'Authorization: Bearer {{token}}' --data-raw '{"amount":100,"type":"unlock","reference_id":1}'`

### 25. Verify Razorpay Sign
`curl --location --request POST '{{base_url}}/payments/verify' --header 'Authorization: Bearer {{token}}' --data-raw '{"razorpay_order_id":"X","razorpay_payment_id":"Y","razorpay_signature":"Z","payment_record_id":1}'`

### 26. My Booking List
`curl --location --request GET '{{base_url}}/bookings' --header 'Authorization: Bearer {{token}}'`

### 27. Create New Booking
`curl --location --request POST '{{base_url}}/bookings' --header 'Authorization: Bearer {{token}}' --data-raw '{"room_id":1,"from_date":"2026-01-01","to_date":"2026-02-01"}'`

### 28. Unlock Contact Info
`curl --location --request POST '{{base_url}}/unlock/1' --header 'Authorization: Bearer {{token}}'`

### 29. Wallet Balance & Transactions
`curl --location --request GET '{{base_url}}/wallet' --header 'Authorization: Bearer {{token}}'`

### 30. Redeem Points
`curl --location --request POST '{{base_url}}/wallet/convert' --header 'Authorization: Bearer {{token}}' --data-raw '{"points":100}'`

### 31. Wishlist Items
`curl --location --request GET '{{base_url}}/wishlist' --header 'Authorization: Bearer {{token}}'`

### 32. Save/Unsave Room
`curl --location --request POST '{{base_url}}/wishlist/toggle/1' --header 'Authorization: Bearer {{token}}'`

### 33. My City Alerts
`curl --location --request GET '{{base_url}}/city-alerts' --header 'Authorization: Bearer {{token}}'`

### 34. Subscribe to City
`curl --location --request POST '{{base_url}}/city-alerts' --header 'Authorization: Bearer {{token}}' --data-raw '{"city":"Bhopal"}'`

### 35. Unsubscribe alert
`curl --location --request DELETE '{{base_url}}/city-alerts/1' --header 'Authorization: Bearer {{token}}'`

### 36. Membership Plans
`curl --location --request GET '{{base_url}}/plans' --header 'Authorization: Bearer {{token}}'`

### 37. Buy Subscription
`curl --location --request POST '{{base_url}}/subscriptions/purchase' --header 'Authorization: Bearer {{token}}' --data-raw '{"plan_id":1}'`

---

## 📂 3. OWNER APIs (Room Management)

### 38. Dashboard Overview
`curl --location --request GET '{{base_url}}/owner/dashboard' --header 'Authorization: Bearer {{token}}'`

### 39. Payout History
`curl --location --request GET '{{base_url}}/owner/payouts' --header 'Authorization: Bearer {{token}}'`

### 40. Lead/Enquiry List
`curl --location --request GET '{{base_url}}/owner/enquiries' --header 'Authorization: Bearer {{token}}'`

### 41. My Listings
`curl --location --request GET '{{base_url}}/owner/rooms' --header 'Authorization: Bearer {{token}}'`

### 42. Store New Room (Exhaustive)
`curl --location --request POST '{{base_url}}/owner/rooms' --header 'Authorization: Bearer {{token}}' --data-raw '{
    "title": "Luxury Flat", "description": "Desc", "room_type": "1bhk", "furnishing_type": "furnished",
    "tenant_type": "family", "rent": 10000, "deposit": 20000, "city": "Indore", "address": "X colony",
    "latitude": 22.7, "longitude": 75.8, "availability_from": "2026-01-01", "broker_fee": 0, "listing_type": "direct",
    "amenities": ["A","B"], "landmarks": ["L1"], "photo": "Binary"
}'`

### 43. Update Listing
`curl --location --request PUT '{{base_url}}/owner/rooms/1' --header 'Authorization: Bearer {{token}}' --data-raw '{"rent":11000}'`

### 44. Remove Listing
`curl --location --request DELETE '{{base_url}}/owner/rooms/1' --header 'Authorization: Bearer {{token}}'`

### 45. Toggle Status (Active/Booked)
`curl --location --request POST '{{base_url}}/owner/rooms/1/toggle-status' --header 'Authorization: Bearer {{token}}' --data-raw '{"payment_method":"wallet"}'`

### 46. Make Featured
`curl --location --request POST '{{base_url}}/owner/rooms/1/feature' --header 'Authorization: Bearer {{token}}' --data-raw '{"payment_method":"gateway"}'`

---

## 📂 4. ADMIN APIs (Control Panel)

### 47. Global Dashboard
`curl --location --request GET '{{base_url}}/admin/dashboard' --header 'Authorization: Bearer {{token}}'`

### 48. Performance Analytics
`curl --location --request GET '{{base_url}}/admin/analytics' --header 'Authorization: Bearer {{token}}'`

### 49. Get All Business Settings
`curl --location --request GET '{{base_url}}/admin/settings' --header 'Authorization: Bearer {{token}}'`

### 50. Update Setting
`curl --location --request POST '{{base_url}}/admin/settings' --header 'Authorization: Bearer {{token}}' --data-raw '{"listing_fee":200}'`

### 51. Browse Users
`curl --location --request GET '{{base_url}}/admin/users' --header 'Authorization: Bearer {{token}}'`

### 52. User Profile (Admin View)
`curl --location --request GET '{{base_url}}/admin/users/1' --header 'Authorization: Bearer {{token}}'`

### 53. Block/Unblock User
`curl --location --request POST '{{base_url}}/admin/users/1/toggle-block' --header 'Authorization: Bearer {{token}}'`

### 54. Browse Owners
`curl --location --request GET '{{base_url}}/admin/owners' --header 'Authorization: Bearer {{token}}'`

### 55. Create New Owner Admin Side
`curl --location --request POST '{{base_url}}/admin/owners' --header 'Authorization: Bearer {{token}}' --data-raw '{"name":"A","email":"a@o.com","phone":"1"}'`

### 56. Owner Profile (Admin View)
`curl --location --request GET '{{base_url}}/admin/owners/1' --header 'Authorization: Bearer {{token}}'`

### 57. Block/Unblock Owner
`curl --location --request POST '{{base_url}}/admin/owners/1/toggle-block' --header 'Authorization: Bearer {{token}}'`

### 58. Monitor All Rooms
`curl --location --request GET '{{base_url}}/admin/rooms' --header 'Authorization: Bearer {{token}}'`

### 59. Approve Listing
`curl --location --request POST '{{base_url}}/admin/rooms/1/approve' --header 'Authorization: Bearer {{token}}'`

### 60. Reject Listing (with reasons)
`curl --location --request POST '{{base_url}}/admin/rooms/1/reject' --header 'Authorization: Bearer {{token}}' --data-raw '{"reasons":[1,2], "custom_reason":"Poor photos"}'`

### 61. Admin Delete Room
`curl --location --request DELETE '{{base_url}}/admin/rooms/1' --header 'Authorization: Bearer {{token}}'`

### 62. View Global Rejection Reasons
`curl --location --request GET '{{base_url}}/admin/rejection-reasons' --header 'Authorization: Bearer {{token}}'`

### 63. Revenue/Payment Logs
`curl --location --request GET '{{base_url}}/admin/payments' --header 'Authorization: Bearer {{token}}'`

### 64. Platform Payout List
`curl --location --request GET '{{base_url}}/admin/payouts' --header 'Authorization: Bearer {{token}}'`

### 65. Process Payout Final
`curl --location --request POST '{{base_url}}/admin/payouts/1/process' --header 'Authorization: Bearer {{token}}' --data-raw '{"payment_reference":"REF99"}'`

### 66. Subscription Plan List
`curl --location --request GET '{{base_url}}/admin/plans' --header 'Authorization: Bearer {{token}}'`

### 67. Create Plan (Exhaustive)
`curl --location --request POST '{{base_url}}/admin/plans' --header 'Authorization: Bearer {{token}}' --data-raw '{
    "name":"Gold","price":999,"duration_days":365,"listing_limit":100,"contacts_limit":-1,"type":"owner","benefits":["A","B"]
}'`

### 68. Edit Plan
`curl --location --request PUT '{{base_url}}/admin/plans/1' --header 'Authorization: Bearer {{token}}' --data-raw '{"price":1099}'`

### 69. Turn On/Off Plan
`curl --location --request POST '{{base_url}}/admin/plans/1/toggle' --header 'Authorization: Bearer {{token}}'`

### 70. Terminate Plan
`curl --location --request DELETE '{{base_url}}/admin/plans/1' --header 'Authorization: Bearer {{token}}'`

### 71. Monitor City Alerts
`curl --location --request GET '{{base_url}}/admin/city-alerts' --header 'Authorization: Bearer {{token}}'`

### 72. Remove Global Alert
`curl --location --request DELETE '{{base_url}}/admin/city-alerts/1' --header 'Authorization: Bearer {{token}}'`

### 73. Newsletter Subscriber List
`curl --location --request GET '{{base_url}}/admin/subscribers' --header 'Authorization: Bearer {{token}}'`

### 74. Remove Subscriber
`curl --location --request DELETE '{{base_url}}/admin/subscribers/1' --header 'Authorization: Bearer {{token}}'`

### 75. Manage All Blogs
`curl --location --request GET '{{base_url}}/admin/blogs' --header 'Authorization: Bearer {{token}}'`

### 76. Publish New Blog (Exhaustive)
`curl --location --request POST '{{base_url}}/admin/blogs' --header 'Authorization: Bearer {{token}}' --data-raw '{
    "title":"T","slug":"s","content":"C","excerpt":"E","meta_title":"M","is_published":1,"image":"Binary"
}'`

### 77. Update Blog Post
`curl --location --request PUT '{{base_url}}/admin/blogs/1' --header 'Authorization: Bearer {{token}}'`

### 78. Erase Blog Post
`curl --location --request DELETE '{{base_url}}/admin/blogs/1' --header 'Authorization: Bearer {{token}}'`

### 79. Platform Offers List
`curl --location --request GET '{{base_url}}/admin/offers' --header 'Authorization: Bearer {{token}}'`

### 80. Launch Offer Banner (Exhaustive)
`curl --location --request POST '{{base_url}}/admin/offers' --header 'Authorization: Bearer {{token}}' --data-raw '{
    "title":"X","description":"D","target_audience":"user","banner_color":"#000","placement":"home_hero","type":"image_only"
}'`

### 81. Edit Offer Content
`curl --location --request PUT '{{base_url}}/admin/offers/1' --header 'Authorization: Bearer {{token}}'`

### 82. Enable/Disable Offer
`curl --location --request POST '{{base_url}}/admin/offers/1/toggle' --header 'Authorization: Bearer {{token}}'`

### 83. End Offer
`curl --location --request DELETE '{{base_url}}/admin/offers/1' --header 'Authorization: Bearer {{token}}'`

### 84. Management: New Rejection Reason
`curl --location --request POST '{{base_url}}/admin/rejection-reasons' --header 'Authorization: Bearer {{token}}' --data-raw '{"reason":"Fraud detection"}'`

### 85. Update Rejection Reason
`curl --location --request PUT '{{base_url}}/admin/rejection-reasons/1' --header 'Authorization: Bearer {{token}}'`

### 86. Delete Rejection Reason
`curl --location --request DELETE '{{base_url}}/admin/rejection-reasons/1' --header 'Authorization: Bearer {{token}}'`

### 87. Page CMS: Update Content
`curl --location --request PUT '{{base_url}}/admin/pages/privacy-policy' --header 'Authorization: Bearer {{token}}' --data-raw '{"title":"T","content":"HTML"}'`

### 88. Search Analytics (Detailed Statistics)
`curl --location --request GET '{{base_url}}/admin/search-analytics' --header 'Authorization: Bearer {{token}}'`

---

## 📂 5. WEBHOOK CALLBACKS

### 89. Razorpay Webhook Update
`curl --location --request POST '{{base_url}}/webhook/razorpay' --data-raw '{"event":"payment.captured"}'`
