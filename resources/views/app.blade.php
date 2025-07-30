<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite('resources/js/app.js')
    @inertiaHead
  </head>
  <body>
    @inertia

    <!-- JS for mobile menu toggle -->
    <script>
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    const closeMenuBtn = document.getElementById('close-mobile-menu');

    mobileMenuBtn?.addEventListener('click', () => mobileMenu.classList.remove('hidden'));
    closeMenuBtn?.addEventListener('click', () => mobileMenu.classList.add('hidden'));
  </script>
  </body>
</html>