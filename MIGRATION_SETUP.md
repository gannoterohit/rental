# Migration Setup Instructions

## ✅ Migration Order Fixed

Migration files ka order fix kar diya hai:
1. `0001_01_01_000000_create_users_table.php`
2. `0001_01_01_000001_create_cache_table.php`
3. `0001_01_01_000002_create_jobs_table.php`
4. `2025_11_05_170424_create_plans_table.php`
5. `2025_11_05_170425_create_rooms_table.php`
6. `2025_11_05_170426_create_payments_table.php`
7. `2025_11_05_170428_create_bookings_table.php`
8. `2025_11_05_170429_create_subscriptions_table.php`
9. `2025_11_05_175728_create_payouts_table.php`

## 🔧 Database Setup Steps

### Step 1: Start XAMPP MySQL
1. XAMPP Control Panel open karein
2. MySQL ko **Start** karein

### Step 2: Create Database
phpMyAdmin mein jao ya MySQL command line se:
```sql
CREATE DATABASE new_roomrental;
```

### Step 3: Update .env File
`.env` file mein ye settings add/update karein:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=new_roomrental
DB_USERNAME=root
DB_PASSWORD=

# Commission & Service Charge Settings
COMMISSION_PERCENT=10
SERVICE_CHARGE=200
```

### Step 4: Run Migrations
```bash
php artisan migrate
```

Agar fresh start chahiye (purani data delete):
```bash
php artisan migrate:fresh
```

## ✅ Fixed Issues

1. ✅ Migration order fixed (payments before bookings)
2. ✅ Foreign key constraints properly set
3. ✅ All models have fillable fields
4. ✅ Commission & service charge logic implemented
5. ✅ Payment integration complete

## 🚀 Next Steps After Migration

1. Create admin user:
```php
php artisan tinker
User::create(['name'=>'Admin','email'=>'admin@test.com','password'=>bcrypt('password'),'role'=>'admin']);
```

2. Create sample plans (optional):
```php
Plan::create(['name'=>'Basic','price'=>499,'duration_days'=>30,'listing_limit'=>3,'type'=>'owner']);
Plan::create(['name'=>'Pro','price'=>999,'duration_days'=>90,'listing_limit'=>10,'type'=>'owner']);
```

