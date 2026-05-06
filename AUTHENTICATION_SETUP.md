# Loan Maker - Authentication & User Management Setup

## Overview
This system implements a role-based authentication system with three user types:
- **Super Admin**: Can create banks and bank admins
- **Bank Admin**: Can create branches and branch admins
- **Branch Admin**: Can view their branch information

## Setup Instructions

### 1. Run Migrations
Run the database migrations to create the necessary tables:
```bash
php artisan migrate
```

### 2. Seed Super Admin
Create the default super admin account:
```bash
php artisan db:seed --class=SuperAdminSeeder
```

### 3. Access the System
Start your development server:
```bash
php artisan serve
```

Visit: `http://localhost:8000/login`

## Default Credentials

### Super Admin
- **Email**: admin@admin.com
- **Password**: 123456

## User Roles & Permissions

### Super Admin
- Create and manage banks
- Create bank administrators
- View all banks and their statistics
- Access: `/super-admin/dashboard`

### Bank Admin
- Create and manage branches for their assigned bank
- Create branch administrators
- View all branches in their bank
- Access: `/bank-admin/dashboard`

### Branch Admin
- View their branch information
- Access: `/branch-admin/dashboard`

## Features Implemented

### Authentication
- Login with email and password
- Role-based redirection after login
- Secure logout functionality

### Database Structure
1. **Users Table**: Enhanced with role, bank_id, and branch_id columns
2. **Banks Table**: Stores bank information
3. **Branches Table**: Stores branch information with bank relationships

### Routes
- `/login` - Login page
- `/super-admin/*` - Super admin routes
- `/bank-admin/*` - Bank admin routes
- `/branch-admin/*` - Branch admin routes

### Middleware
- `super.admin` - Protects super admin routes
- `bank.admin` - Protects bank admin routes
- `branch.admin` - Protects branch admin routes

## Workflow

1. **Super Admin logs in** → Creates banks → Creates bank admins for each bank
2. **Bank Admin logs in** → Creates branches for their bank → Creates branch admins for each branch
3. **Branch Admin logs in** → Views their branch information

## Files Created/Modified

### Models
- `app/Models/User.php` - Enhanced with role methods
- `app/Models/Bank.php` - Bank model
- `app/Models/Branch.php` - Branch model

### Controllers
- `app/Http/Controllers/AuthController.php` - Authentication
- `app/Http/Controllers/SuperAdminController.php` - Super admin operations
- `app/Http/Controllers/BankAdminController.php` - Bank admin operations
- `app/Http/Controllers/BranchAdminController.php` - Branch admin operations

### Middleware
- `app/Http/Middleware/SuperAdminMiddleware.php`
- `app/Http/Middleware/BankAdminMiddleware.php`
- `app/Http/Middleware/BranchAdminMiddleware.php`

### Views
- `resources/views/auth/login.blade.php`
- `resources/views/layouts/app.blade.php`
- `resources/views/layouts/admin.blade.php`
- Super admin views (dashboard, banks, bank-admins)
- Bank admin views (dashboard, branches, branch-admins)
- Branch admin views (dashboard)

### Migrations
- `database/migrations/2024_01_01_000003_add_role_to_users_table.php`
- `database/migrations/2024_01_01_000004_create_banks_table.php`
- `database/migrations/2024_01_01_000005_create_branches_table.php`

### Seeders
- `database/seeders/SuperAdminSeeder.php`

## Next Steps

You may want to add:
1. Password reset functionality
2. User profile management
3. Email verification
4. Loan offer management features
5. Branch listing for public view
6. Search and filter functionality
7. File upload for bank logos
8. Audit logs for admin actions
