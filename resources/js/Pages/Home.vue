<template>
    
  <div class="d-flex align-items-center justify-content-center min-vh-100">
    <div class="form-container bg-white p-4 rounded shadow-sm w-100">

      <!-- Logo -->
      <div class="text-center mb-4">
        <img src="/public/assets/img/image-removebg-preview (21) 1.png" alt="Logo" class="img-fluid" style="max-height: 60px;">
      </div>

      <!-- Title -->
      <h2 class="h4 text-center mb-1 text-dark">Sign in</h2>
      <p class="text-center text-muted small mb-4">Login to your designated account from here</p>

      <!-- Login Form -->
      <form>
        <!-- Email -->
        <div class="mb-3">
          <label for="email" class="form-label">E-mail</label>
          <input type="email" class="form-control" id="email" placeholder="example@gmail.com" required>
        </div>

        <!-- Password -->
        <div class="mb-3 position-relative">
          <label for="password" class="form-label">Password</label>
          
          <div class="position-relative">
            <input type="password" class="form-control" id="password" placeholder="Enter your password" required>
          <button type="button" class="btn btn-sm btn-outline-secondary position-absolute top-50 end-0 translate-middle-y me-2" @click="togglePassword()">
            👁️
          </button>
          </div>
        </div>

        <!-- Remember & Forgot -->
        <div class="d-flex justify-content-between align-items-center mb-3">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="rememberMe">
            <label class="form-check-label" for="rememberMe">Remember me</label>
          </div>
          <a href="#" class="small text-decoration-none text-primary">Forgot Password?</a>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary w-100">Sign in</button>
      </form>
    </div>
  </div>
</template>

<script setup>
const togglePassword = () => {
      const passwordField = document.getElementById("password");
      passwordField.type = passwordField.type === "password" ? "text" : "password";
    }

</script>

<style>
.form-container {
      max-width: 400px;
    }
</style>