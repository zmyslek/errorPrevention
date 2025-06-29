# Security Assignent 3

## 1. IDOR

app\Model\Use.php:26 
  - is_admin controls admin access to Users view

app\Providers\AppServiceProvider.php:32 
  - defines Gate on manage_users based on is_admin for current user

routes\web.php 
  - users route definition with Gate access control middleware('can:manage_users')
  - fallback route definition - to dashboard for logged user, otherwise to login page 



