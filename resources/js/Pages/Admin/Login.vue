<script setup>
import { useForm } from '@inertiajs/vue3'

const form = useForm({
  email: '',
  password: '',
})

const submit = () => {
  form.post('/admin/login')
}
</script>

<template>
  <div class="login-wrapper d-flex align-items-center justify-content-center min-vh-100">
    <div class="login-card shadow-lg">
      <h2 class="login-title text-center">Welcome Back 👋</h2>
      <p class="login-subtitle text-center">Sign in to continue</p>

      <!-- Errors -->
      <div v-if="form.errors.email || form.errors.password"
           class="alert alert-danger py-2 px-3 mb-3 rounded-3">
        {{ form.errors.email || form.errors.password }}
      </div>

      <!-- Email -->
      <div class="mb-3">
        <label for="email" class="form-label fw-semibold">Email</label>
        <input v-model="form.email"
               type="email"
               id="email"
               placeholder="Enter your email"
               class="form-control"
               :class="{ 'is-invalid': form.errors.email }" />
        <div class="invalid-feedback">{{ form.errors.email }}</div>
      </div>

      <!-- Password -->
      <div class="mb-3">
        <label for="password" class="form-label fw-semibold">Password</label>
        <input v-model="form.password"
               type="password"
               id="password"
               placeholder="Enter your password"
               class="form-control"
               :class="{ 'is-invalid': form.errors.password }" />
        <div class="invalid-feedback">{{ form.errors.password }}</div>
      </div>

      <!-- Remember + Forgot -->
      <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" id="remember" />
          <label class="form-check-label small-text" for="remember">Remember me</label>
        </div>
        <a href="#" class="small-link">Forgot password?</a>
      </div>

      <!-- Submit -->
      <button @click="submit"
              class="btn btn-login w-100"
              :disabled="form.processing">
        <span v-if="form.processing">Logging in...</span>
        <span v-else>Login</span>
      </button>

      <!-- Footer -->
      <p class="text-center mt-4 small-text">
        Don’t have an account?
        <a href="#" class="small-link">Sign up</a>
      </p>
    </div>
  </div>
</template>

<style scoped>
/* Import modern font */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');

.login-wrapper {
  font-family: 'Poppins', sans-serif;
  background: linear-gradient(135deg, #0f172a, #1e293b, #334155); /* Deep neutral premium */
}

.login-card {
  background: #fff;
  border-radius: 1rem;
  padding: 2.5rem;
  width: 100%;
  max-width: 420px;
}

.login-title {
  font-weight: 700;
  font-size: 1.6rem;
  color: #0f172a;
  margin-bottom: 0.5rem;
}

.login-subtitle {
  font-size: 0.9rem;
  color: #6b7280;
  margin-bottom: 1.5rem;
}

.form-control {
  border-radius: 0.75rem;
  padding: 0.75rem 1rem;
  font-size: 1rem;
}

.btn-login {
  border: none;
  border-radius: 0.75rem;
  padding: 0.75rem;
  font-size: 1rem;
  font-weight: 600;
  color: #fff;
  background: linear-gradient(90deg, #4f46e5, #4338ca); /* deep indigo premium */
  transition: all 0.3s ease;
}

.btn-login:hover {
  background: linear-gradient(90deg, #4338ca, #3730a3);
  transform: translateY(-2px);
  box-shadow: 0 6px 18px rgba(67, 56, 202, 0.35);
}

.small-text {
  font-size: 0.9rem;
  color: #6b7280;
}

.small-link {
  font-size: 0.9rem;
  font-weight: 500;
  color: #4f46e5;
  text-decoration: none;
}

.small-link:hover {
  color: #3730a3;
  text-decoration: underline;
}
</style>
