# Laravel Interview Task - Uzzal

This project is a role-based authentication system built using **Laravel**, **Vue 3**, and **Inertia.js**. It was developed as part of the interview process

---

## 📌 Features

- User authentication (login, logout)
- Role management (admin, user, etc.)
- Permission-based access control
- Protected routes via custom middleware
- Vue 3 frontend with Inertia.js
- Fully responsive UI based on provided Figma design
- No external RBAC packages used

---

## ⚙️ Setup Instructions

### 1. Clone the Repository



DB_DATABASE=your_db
DB_USERNAME=your_user
DB_PASSWORD=your_pass


and command the terminal : 
1 ) composer install
2 ) npm install

(cp .env.example .env
php artisan key:generate )

3 ) php artisan key:generate
4 ) php artisan migrate --seed
5 ) php artisan serve
6 )npm run dev

###🚀 Deployment Steps###

composer install --optimize-autoloader --no-dev
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
npm install && npm run build

##### Optimization Techniques ######
1) Middleware Caching
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache

2)Optimized Frontend Build
npm run build


API Documentation: https://documenter.getpostman.com/view/40819780/2sB3B8tZGi
Md Jakir Hosen Uzzal
📧 devuzzal1971@gmail.com


