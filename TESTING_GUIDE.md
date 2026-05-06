# Testing Instructions

## Test the Login System

### 1. Start the Development Server
```bash
php artisan serve
```

### 2. Access the Login Page
Open your browser and go to: `http://localhost:8000/login`

### 3. Login as Super Admin
- **Email**: admin@admin.com
- **Password**: 123456

### 4. Test Super Admin Features
After logging in, you should be redirected to `/super-admin/dashboard` where you can:
- Create new banks
- Create bank administrators
- View all banks and their statistics

### 5. Test Complete Workflow

#### Step 1: Create a Bank
1. Click "Create Bank" from the dashboard
2. Fill in:
   - Bank Name: e.g., "ABC Bank"
   - Bank Code: e.g., "ABC001"
   - Description: Optional
3. Submit the form

#### Step 2: Create a Bank Admin
1. Click "Create Bank Admin" from the dashboard
2. Fill in:
   - Name: e.g., "John Doe"
   - Email: e.g., "john@abcbank.com"
   - Bank: Select "ABC Bank"
   - Password: e.g., "password123"
   - Confirm Password: "password123"
3. Submit the form

#### Step 3: Logout and Login as Bank Admin
1. Click "Logout"
2. Login with the bank admin credentials (john@abcbank.com / password123)
3. You should be redirected to `/bank-admin/dashboard`

#### Step 4: Create a Branch
1. Click "Create Branch" from the bank admin dashboard
2. Fill in:
   - Branch Name: e.g., "ABC Bank Downtown"
   - Branch Code: e.g., "ABC-DT-001"
   - Address, City, State, Phone, Email (optional)
3. Submit the form

#### Step 5: Create a Branch Admin
1. Click "Create Branch Admin" from the bank admin dashboard
2. Fill in:
   - Name: e.g., "Jane Smith"
   - Email: e.g., "jane@abcbank.com"
   - Branch: Select "ABC Bank Downtown"
   - Password: e.g., "password123"
   - Confirm Password: "password123"
3. Submit the form

#### Step 6: Logout and Login as Branch Admin
1. Click "Logout"
2. Login with the branch admin credentials (jane@abcbank.com / password123)
3. You should be redirected to `/branch-admin/dashboard`
4. You should see your branch information displayed

## Verification Checklist

- [ ] Can login as Super Admin
- [ ] Super Admin can create banks
- [ ] Super Admin can create bank admins
- [ ] Bank Admin can login and see their dashboard
- [ ] Bank Admin can create branches
- [ ] Bank Admin can create branch admins
- [ ] Branch Admin can login and see their dashboard
- [ ] Branch Admin can see their branch information
- [ ] Logout works for all user types
- [ ] Unauthorized users cannot access protected routes

## Database Tables

You can verify the database structure:
```bash
php artisan db:show
```

Check specific tables:
```bash
php artisan db:table users
php artisan db:table banks
php artisan db:table branches
```
