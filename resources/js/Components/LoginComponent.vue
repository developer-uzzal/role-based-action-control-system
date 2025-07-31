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
      <form @submit.prevent="submit">
        <!-- Email -->
        <div class="mb-3">
          <label for="email" class="form-label">E-mail</label>
          <input type="email" class="form-control" id="email" placeholder="example@gmail.com" v-model="form.email">
        </div>

        <!-- Password -->
        <div class="mb-3 position-relative">
          <label for="password" class="form-label">Password</label>
          
          <div class="position-relative">
            <input type="password" class="form-control" id="password" placeholder="Enter your password" v-model="form.password">
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
        <button type="submit" class="btn btn-primary w-100" :disabled="form.processing">Sign in</button>
      </form>
    </div>
  </div>
</template>

<script setup>

import { router, useForm, usePage } from '@inertiajs/vue3';
import Notify from 'simple-notify';
const page = usePage();
const form = useForm({
  email: "",
  password: "",
});

const submit = () => {
  
    if(form.email==""){
      
        new Notify({
            title: 'Error',
            text: 'Email is required',
            status: 'error'
        })
        return
    }else if(form.password==""){
        new Notify({
            title: 'Error',
            text: 'Password is required',
            status: 'error'
        })
        return
    }else{
        form.post('/login', {
            onSuccess: () => {

                if (page.props.flash.success) {
                    new Notify({
                        status: 'success',
                        title: page.props.flash.success.message,
                        autotimeout: 2000,
                    })

                    form.reset();
                    router.get("/dashboard");

                } else if (page.props.flash.error) {
                    new Notify({
                        status: 'error',
                        title: page.props.flash.error.message,
                        autotimeout: 2000,
                    })
                }
            },
            onError: () => {
                new Notify({
                    title: 'Error',
                    text: 'Login failed',
                    status: 'error'
                })
            }
        });
    }

};





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