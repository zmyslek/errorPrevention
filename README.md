# Security Assignent 3

## 1. IDOR

app\Model\User.php:26 
  - is_admin controls admin access to Users view

app\Providers\AppServiceProvider.php:32 
  - defines Gate on manage_users based on is_admin for current user

routes\web.php 
  - users route definition with Gate access control middleware('can:manage_users')
  - fallback route definition - to dashboard for logged user, otherwise to login page 


## 2. Snooping and session hijacking prevention
app\Providers\AppServiceProvider.php:37
  - serve app on HTTPS in non-dev environement to encrypt transmission

.env.example
  - prevent session theft via JavaScript or cross-site requests (when uing .env copied from .env.example)
    - SESSION_SECURE_COOKIE=true
    - SESSION_SAME_SITE=lax
    - SESSION_HTTP_ONLY=true
  - prevent also by short session time and session encryption in database
    - SESSION_DRIVER=database
    - SESSION_LIFETIME=10
    - SESSION_ENCRYPT=true

config\session.php: 
  - prevent session theft via JavaScript or cross-site requests
    - secure=true 
    - http_only=true
    - samesame_site=lax
  - and short and encrypted session
    - driver=database
    - lifetime=10
    - expire_on_close=true
    - encrypt=true

Http\Conctrollers\RegisterController.php:
  - Regenerate the session to prevent session fixation attacks

