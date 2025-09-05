<script setup>
import { useForm , usePage  } from '@inertiajs/vue3'
const { props } = usePage()
const form = useForm({
  email: '',
  password: '',
  remember: false,
})

const submit = () => {
  form.post(props.loginUrl, {
    onFinish: () => form.reset('password'),
  })
}
</script>

<template>
  <div class="container min-vh-100 d-flex justify-content-center align-items-center">
    <div class="col-md-5 col-lg-4">
      <div class="card shadow-lg border-0 rounded-lg">
        <div class="card-body p-5">
          <h3 class="card-title text-center mb-4 font-weight-bold text-primary">
            Member Login
          </h3>

          <!-- Flash Messages -->
          <div v-if="$page.props.flash?.success" class="alert alert-success">
            {{ $page.props.flash.success }}
          </div>
          <div v-if="$page.props.flash?.error" class="alert alert-danger">
            {{ $page.props.flash.error }}
          </div>

          <form @submit.prevent="submit" class="needs-validation" novalidate>
            <!-- Email -->
            <div class="form-group mb-3">
              <label for="email" class="font-weight-bold">Email</label>
              <input
                id="email"
                type="email"
                v-model="form.email"
                class="form-control"
                placeholder="Enter your email"
                required
              />
              <div v-if="form.errors.email" class="text-danger small mt-1">
                {{ form.errors.email }}
              </div>
            </div>

            <!-- Password -->
            <div class="form-group mb-3">
              <label for="password" class="font-weight-bold">Password</label>
              <input
                id="password"
                type="password"
                v-model="form.password"
                class="form-control"
                placeholder="Enter your password"
                required
              />
              <div v-if="form.errors.password" class="text-danger small mt-1">
                {{ form.errors.password }}
              </div>
            </div>

            <!-- Remember Me -->
            <div class="form-check mb-4">
              <input
                id="remember"
                type="checkbox"
                v-model="form.remember"
                class="form-check-input"
              />
              <label for="remember" class="form-check-label">
                Remember Me
              </label>
            </div>

            <!-- Submit -->
            <button
              type="submit"
              :disabled="form.processing"
              class="btn btn-primary btn-block py-2"
            >
              Login
            </button>
          </form>

          <!-- Links -->
          <div class="text-center mt-4">
            <a href="#" class="small text-primary">Forgot Password?</a>
            <span class="mx-2">|</span>
            <a href="/member/register" class="small text-primary">Register</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
body {
  background: #f5f6fa;
}
.card {
  transition: 0.3s;
}
.card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}
</style>
