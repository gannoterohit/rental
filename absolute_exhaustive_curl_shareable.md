# 🚀 RoomRental ABSOLUTE TOTAL API LIST (All 89 Endpoints)

This is the **exhaustive** list of every single route in the system. You can paste these directly into Postman.

---

## 📂 1. PUBLIC (16 APIs)
1. **Get Settings**: `curl --location --request GET '{{base_url}}/settings'`
2. **Send OTP**: `curl --location --request POST '{{base_url}}/auth/send-otp' --data-raw '{"email":"test@test.com"}'`
3. **Register**: `curl --location --request POST '{{base_url}}/auth/register'`
4. **Login**: `curl --location --request POST '{{base_url}}/auth/login'`
5. **List Rooms**: `curl --location --request GET '{{base_url}}/rooms'`
6. **Room Detail**: `curl --location --request GET '{{base_url}}/rooms/1'`
7. **Similar Rooms**: `curl --location --request GET '{{base_url}}/rooms/1/similar'`
8. **Detect City**: `curl --location --request POST '{{base_url}}/rooms/detect-city' --data-raw '{"lat":23,"lng":77}'`
9. **Get Cities**: `curl --location --request GET '{{base_url}}/cities'`
10. **List Blogs**: `curl --location --request GET '{{base_url}}/blogs'`
11. **Blog Detail**: `curl --location --request GET '{{base_url}}/blogs/slug'`
12. **Static Page**: `curl --location --request GET '{{base_url}}/pages/privacy-policy'`
13. **FAQ List**: `curl --location --request GET '{{base_url}}/faq'`
14. **Newsletter**: `curl --location --request POST '{{base_url}}/newsletter/subscribe'`
15. **Contact Form**: `curl --location --request POST '{{base_url}}/contact'`
16. **Public Offers**: `curl --location --request GET '{{base_url}}/offers'`

---

## 📂 2. USER (21 APIs)
17. **Get Me**: `curl --location --request GET '{{base_url}}/auth/me' --header 'Authorization: Bearer {{token}}'`
18. **Logout**: `curl --location --request POST '{{base_url}}/auth/logout' --header 'Authorization: Bearer {{token}}'`
19. **Update Profile**: `curl --location --request POST '{{base_url}}/profile/update' --header 'Authorization: Bearer {{token}}'`
20. **Delete OTP**: `curl --location --request POST '{{base_url}}/profile/delete-otp' --header 'Authorization: Bearer {{token}}'`
21. **Delete Account**: `curl --location --request DELETE '{{base_url}}/profile' --header 'Authorization: Bearer {{token}}'`
22. **User Dashboard**: `curl --location --request GET '{{base_url}}/dashboard' --header 'Authorization: Bearer {{token}}'`
23. **Referral Stats**: `curl --location --request GET '{{base_url}}/referral-stats' --header 'Authorization: Bearer {{token}}'`
24. **Create Order**: `curl --location --request POST '{{base_url}}/payments/create-order' --header 'Authorization: Bearer {{token}}'`
25. **Verify Payment**: `curl --location --request POST '{{base_url}}/payments/verify' --header 'Authorization: Bearer {{token}}'`
26. **My Bookings**: `curl --location --request GET '{{base_url}}/bookings' --header 'Authorization: Bearer {{token}}'`
27. **New Booking**: `curl --location --request POST '{{base_url}}/bookings' --header 'Authorization: Bearer {{token}}'`
28. **Unlock Contact**: `curl --location --request POST '{{base_url}}/unlock/1' --header 'Authorization: Bearer {{token}}'`
29. **Wallet Index**: `curl --location --request GET '{{base_url}}/wallet' --header 'Authorization: Bearer {{token}}'`
30. **Convert Points**: `curl --location --request POST '{{base_url}}/wallet/convert' --header 'Authorization: Bearer {{token}}'`
31. **Wishlist Index**: `curl --location --request GET '{{base_url}}/wishlist' --header 'Authorization: Bearer {{token}}'`
32. **Toggle Wishlist**: `curl --location --request POST '{{base_url}}/wishlist/toggle/1' --header 'Authorization: Bearer {{token}}'`
33. **My City Alerts**: `curl --location --request GET '{{base_url}}/city-alerts' --header 'Authorization: Bearer {{token}}'`
34. **Add City Alert**: `curl --location --request POST '{{base_url}}/city-alerts' --header 'Authorization: Bearer {{token}}'`
35. **Remove Alert**: `curl --location --request DELETE '{{base_url}}/city-alerts/1' --header 'Authorization: Bearer {{token}}'`
36. **All Plans**: `curl --location --request GET '{{base_url}}/plans' --header 'Authorization: Bearer {{token}}'`
37. **Buy Subscription**: `curl --location --request POST '{{base_url}}/subscriptions/purchase' --header 'Authorization: Bearer {{token}}'`

---

## 📂 3. OWNER (9 APIs)
38. **Owner Dashboard**: `curl --location --request GET '{{base_url}}/owner/dashboard' --header 'Authorization: Bearer {{token}}'`
39. **Owner Payouts**: `curl --location --request GET '{{base_url}}/owner/payouts' --header 'Authorization: Bearer {{token}}'`
40. **Owner Enquiries**: `curl --location --request GET '{{base_url}}/owner/enquiries' --header 'Authorization: Bearer {{token}}'`
41. **My Rooms**: `curl --location --request GET '{{base_url}}/owner/rooms' --header 'Authorization: Bearer {{token}}'`
42. **Add Room**: `curl --location --request POST '{{base_url}}/owner/rooms' --header 'Authorization: Bearer {{token}}'`
43. **Update Room**: `curl --location --request PUT '{{base_url}}/owner/rooms/1' --header 'Authorization: Bearer {{token}}'`
44. **Delete Room**: `curl --location --request DELETE '{{base_url}}/owner/rooms/1' --header 'Authorization: Bearer {{token}}'`
45. **Toggle Status**: `curl --location --request POST '{{base_url}}/owner/rooms/1/toggle-status' --header 'Authorization: Bearer {{token}}'`
46. **Set Featured**: `curl --location --request POST '{{base_url}}/owner/rooms/1/feature' --header 'Authorization: Bearer {{token}}'`

---

## 📂 4. ADMIN (42 APIs)
47. **Admin Dashboard**: `curl --location --request GET '{{base_url}}/admin/dashboard' --header 'Authorization: Bearer {{token}}'`
48. **Global Analytics**: `curl --location --request GET '{{base_url}}/admin/analytics' --header 'Authorization: Bearer {{token}}'`
49. **Get Settings**: `curl --location --request GET '{{base_url}}/admin/settings' --header 'Authorization: Bearer {{token}}'`
50. **Set Settings**: `curl --location --request POST '{{base_url}}/admin/settings' --header 'Authorization: Bearer {{token}}'`
51. **List Users**: `curl --location --request GET '{{base_url}}/admin/users' --header 'Authorization: Bearer {{token}}'`
52. **User Detail**: `curl --location --request GET '{{base_url}}/admin/users/1' --header 'Authorization: Bearer {{token}}'`
53. **Block User**: `curl --location --request POST '{{base_url}}/admin/users/1/toggle-block' --header 'Authorization: Bearer {{token}}'`
54. **List Owners**: `curl --location --request GET '{{base_url}}/admin/owners' --header 'Authorization: Bearer {{token}}'`
55. **Create Owner**: `curl --location --request POST '{{base_url}}/admin/owners' --header 'Authorization: Bearer {{token}}'`
56. **Owner Detail**: `curl --location --request GET '{{base_url}}/admin/owners/1' --header 'Authorization: Bearer {{token}}'`
57. **Block Owner**: `curl --location --request POST '{{base_url}}/admin/owners/1/toggle-block' --header 'Authorization: Bearer {{token}}'`
58. **List All Rooms**: `curl --location --request GET '{{base_url}}/admin/rooms' --header 'Authorization: Bearer {{token}}'`
59. **Approve Room**: `curl --location --request POST '{{base_url}}/admin/rooms/1/approve' --header 'Authorization: Bearer {{token}}'`
60. **Reject Room**: `curl --location --request POST '{{base_url}}/admin/rooms/1/reject' --header 'Authorization: Bearer {{token}}'`
61. **Delete Room**: `curl --location --request DELETE '{{base_url}}/admin/rooms/1' --header 'Authorization: Bearer {{token}}'`
62. **View Reasons**: `curl --location --request GET '{{base_url}}/admin/rejection-reasons' --header 'Authorization: Bearer {{token}}'`
63. **List Payments**: `curl --location --request GET '{{base_url}}/admin/payments' --header 'Authorization: Bearer {{token}}'`
64. **List Payouts**: `curl --location --request GET '{{base_url}}/admin/payouts' --header 'Authorization: Bearer {{token}}'`
65. **Process Payout**: `curl --location --request POST '{{base_url}}/admin/payouts/1/process' --header 'Authorization: Bearer {{token}}'`
66. **List Plans**: `curl --location --request GET '{{base_url}}/admin/plans' --header 'Authorization: Bearer {{token}}'`
67. **Add Plan**: `curl --location --request POST '{{base_url}}/admin/plans' --header 'Authorization: Bearer {{token}}'`
68. **Edit Plan**: `curl --location --request PUT '{{base_url}}/admin/plans/1' --header 'Authorization: Bearer {{token}}'`
69. **Toggle Plan**: `curl --location --request POST '{{base_url}}/admin/plans/1/toggle' --header 'Authorization: Bearer {{token}}'`
70. **Delete Plan**: `curl --location --request DELETE '{{base_url}}/admin/plans/1' --header 'Authorization: Bearer {{token}}'`
71. **All Alerts**: `curl --location --request GET '{{base_url}}/admin/city-alerts' --header 'Authorization: Bearer {{token}}'`
72. **Delete Alert**: `curl --location --request DELETE '{{base_url}}/admin/city-alerts/1' --header 'Authorization: Bearer {{token}}'`
73. **All Subs**: `curl --location --request GET '{{base_url}}/admin/subscribers' --header 'Authorization: Bearer {{token}}'`
74. **Delete Sub**: `curl --location --request DELETE '{{base_url}}/admin/subscribers/1' --header 'Authorization: Bearer {{token}}'`
75. **List Blogs**: `curl --location --request GET '{{base_url}}/admin/blogs' --header 'Authorization: Bearer {{token}}'`
76. **Add Blog**: `curl --location --request POST '{{base_url}}/admin/blogs' --header 'Authorization: Bearer {{token}}'`
77. **Edit Blog**: `curl --location --request PUT '{{base_url}}/admin/blogs/1' --header 'Authorization: Bearer {{token}}'`
78. **Delete Blog**: `curl --location --request DELETE '{{base_url}}/admin/blogs/1' --header 'Authorization: Bearer {{token}}'`
79. **List Offers**: `curl --location --request GET '{{base_url}}/admin/offers' --header 'Authorization: Bearer {{token}}'`
80. **Add Offer**: `curl --location --request POST '{{base_url}}/admin/offers' --header 'Authorization: Bearer {{token}}'`
81. **Edit Offer**: `curl --location --request PUT '{{base_url}}/admin/offers/1' --header 'Authorization: Bearer {{token}}'`
82. **Toggle Offer**: `curl --location --request POST '{{base_url}}/admin/offers/1/toggle' --header 'Authorization: Bearer {{token}}'`
83. **Delete Offer**: `curl --location --request DELETE '{{base_url}}/admin/offers/1' --header 'Authorization: Bearer {{token}}'`
84. **Add Reason**: `curl --location --request POST '{{base_url}}/admin/rejection-reasons' --header 'Authorization: Bearer {{token}}'`
85. **Edit Reason**: `curl --location --request PUT '{{base_url}}/admin/rejection-reasons/1' --header 'Authorization: Bearer {{token}}'`
86. **Delete Reason**: `curl --location --request DELETE '{{base_url}}/admin/rejection-reasons/1' --header 'Authorization: Bearer {{token}}'`
87. **Edit Page**: `curl --location --request PUT '{{base_url}}/admin/pages/faq' --header 'Authorization: Bearer {{token}}'`
88. **Search Analysis**: `curl --location --request GET '{{base_url}}/admin/search-analytics' --header 'Authorization: Bearer {{token}}'`

---

## 📂 5. WEBHOOK (1 API)
89. **Razorpay Hook**: `curl --location --request POST '{{base_url}}/webhook/razorpay'`
