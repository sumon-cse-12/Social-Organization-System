<script setup>
import { useForm } from '@inertiajs/vue3'; // Correct import for new Inertia versions
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";

// useForm helper initializes the form object with its data, errors, and methods.
const form = useForm({
  name: "",
  email: "",
  password: "",
  password_confirmation: "",
  phone: "",
  address: "",
  date_of_birth: "",
  emergency_contact: "",
  membership_date: "",
  id_proof: null,
  agree_deposit: false,
});

// Function to handle the form submission.
const submit = () => {
  // Inertia automatically converts the request to multipart/form-data when a File object is present.
  form.post('/member/register', {
    onSuccess: () => {
      form.reset(); // Clear form fields on success
      toast.success("Member registered successfully!");
    },
    onError: () => {
      toast.error("Please correct the errors highlighted in the form.");
    },
  });
};
</script>

<template>
  <div class="container d-flex align-items-center justify-content-center min-vh-100">
    <div class="col-md-8">
      <div class="card shadow-lg border-0 rounded-lg">
        <div class="card-header bg-primary text-white text-center">
          <h3 class="mb-0">Member Registration</h3>
        </div>
        <div class="card-body p-4">
          <form @submit.prevent="submit">
            <div class="row mb-3">
              <div class="col-md-6">
                <label class="form-label">Name</label>
                <input v-model="form.name" type="text" class="form-control" />
                <small v-if="form.errors.name" class="text-danger">{{ form.errors.name }}</small>
              </div>
              <div class="col-md-6">
                <label class="form-label">Email</label>
                <input v-model="form.email" type="email" class="form-control" />
                <small v-if="form.errors.email" class="text-danger">{{ form.errors.email }}</small>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-6">
                <label class="form-label">Password</label>
                <input v-model="form.password" type="password" class="form-control" />
                <small v-if="form.errors.password" class="text-danger">{{ form.errors.password }}</small>
              </div>
              <div class="col-md-6">
                <label class="form-label">Confirm Password</label>
                <input v-model="form.password_confirmation" type="password" class="form-control" />
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label">Phone</label>
              <input v-model="form.phone" type="text" class="form-control" />
            </div>
            <div class="mb-3">
              <label class="form-label">Address</label>
              <textarea v-model="form.address" class="form-control"></textarea>
            </div>

            <div class="row mb-3">
              <div class="col-md-6">
                <label class="form-label">Date of Birth</label>
                <input v-model="form.date_of_birth" type="date" class="form-control" />
              </div>
              <div class="col-md-6">
                <label class="form-label">Emergency Contact</label>
                <input v-model="form.emergency_contact" type="text" class="form-control" />
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label">Membership Date</label>
              <input v-model="form.membership_date" type="date" class="form-control" />
            </div>

            <div class="mb-3">
              <label class="form-label">ID Proof</label>
              <input @input="form.id_proof = $event.target.files[0]" type="file" class="form-control" />
              <small v-if="form.errors.id_proof" class="text-danger">{{ form.errors.id_proof }}</small>
            </div>

            <div class="form-check mb-3">
              <input
                type="checkbox"
                class="form-check-input"
                id="agree_deposit"
                v-model="form.agree_deposit"
              />
              <label class="form-check-label" for="agree_deposit">
                I agree to the deposit terms
              </label>
              <small v-if="form.errors.agree_deposit" class="text-danger d-block">{{ form.errors.agree_deposit }}</small>
            </div>

            <button type="submit" :disabled="form.processing" class="btn btn-success w-100">
              <span v-if="form.processing" class="spinner-border spinner-border-sm me-2"></span>
              Register
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
/* Scoped styles will not affect other components */
.form-label {
  font-weight: 500;
}
</style>
