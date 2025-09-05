<template>
  <div class="container d-flex align-items-center justify-content-center min-vh-100">
    <div class="col-md-8">
      <div class="card shadow-lg border-0 rounded-lg">
        <div class="card-header bg-primary text-white text-center">
          <h3 class="mb-0">Member Registration</h3>
        </div>
        <div class="card-body p-4">
          <!-- Success Message -->
          <div v-if="successMessage" class="alert alert-success">
            {{ successMessage }}
          </div>

          <form @submit.prevent="submit" enctype="multipart/form-data">
            <!-- Name & Email -->
            <div class="form-row">
              <div class="form-group col-md-6">
                <label>Name</label>
                <input v-model="form.name" type="text" class="form-control" />
                <small v-if="form.errors.name" class="text-danger">{{ form.errors.name }}</small>
              </div>
              <div class="form-group col-md-6">
                <label>Email</label>
                <input v-model="form.email" type="email" class="form-control" />
                <small v-if="form.errors.email" class="text-danger">{{ form.errors.email }}</small>
              </div>
            </div>

            <!-- Password & Confirm -->
            <div class="form-row">
              <div class="form-group col-md-6">
                <label>Password</label>
                <input v-model="form.password" type="password" class="form-control" />
                <small v-if="form.errors.password" class="text-danger">{{ form.errors.password }}</small>
              </div>
              <div class="form-group col-md-6">
                <label>Confirm Password</label>
                <input v-model="form.password_confirmation" type="password" class="form-control" />
              </div>
            </div>

            <!-- Phone & Address -->
            <div class="form-group">
              <label>Phone</label>
              <input v-model="form.phone" type="text" class="form-control" />
            </div>

            <div class="form-group">
              <label>Address</label>
              <textarea v-model="form.address" class="form-control"></textarea>
            </div>

            <!-- DOB & Emergency Contact -->
            <div class="form-row">
              <div class="form-group col-md-6">
                <label>Date of Birth</label>
                <input v-model="form.date_of_birth" type="date" class="form-control" />
              </div>
              <div class="form-group col-md-6">
                <label>Emergency Contact</label>
                <input v-model="form.emergency_contact" type="text" class="form-control" />
              </div>
            </div>

            <!-- Membership Date -->
            <div class="form-group">
              <label>Membership Date</label>
              <input v-model="form.membership_date" type="date" class="form-control" />
            </div>

            <!-- ID Proof -->
            <div class="form-group">
              <label>ID Proof</label>
              <input type="file" @change="e => form.id_proof = e.target.files[0]" class="form-control-file" />
              <small v-if="form.errors.id_proof" class="text-danger">{{ form.errors.id_proof }}</small>
            </div>

            <!-- Agree Deposit Checkbox -->
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
              <small v-if="form.errors.agree_deposit" class="text-danger">{{ form.errors.agree_deposit }}</small>
            </div>

            <!-- Submit -->
            <button type="submit" :disabled="form.processing" class="btn btn-success btn-block">
              <span v-if="form.processing" class="spinner-border spinner-border-sm"></span>
              Register
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref } from "vue";
import { useForm } from "@inertiajs/inertia-vue3";

export default {
  setup() {
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

    const successMessage = ref("");

    const submit = () => {
      // Convert boolean checkbox to '1' for Laravel accepted validation
      const payload = { ...form };
      payload.agree_deposit = form.agree_deposit ? 1 : 0;

      form.post(route("member.register"), {
        data: payload,
        forceFormData: true,
        onSuccess: () => {
          form.reset();
          successMessage.value = "Member registered successfully!";
        },
        onError: (errors) => {
          console.log("Validation errors:", errors);
        },
      });
    };

    return { form, submit, successMessage };
  },
};
</script>
