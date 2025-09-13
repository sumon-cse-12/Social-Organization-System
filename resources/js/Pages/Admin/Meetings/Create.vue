<template>
  <div class="container py-4">
    <!-- Success Message -->
    <div
      v-if="showSuccess"
      class="alert alert-success success-message alert-dismissible fade show"
      role="alert"
    >
      <i class="bi bi-check-circle-fill me-2"></i>
      <strong>Success!</strong> Meeting created successfully.
      <button type="button" class="btn-close" @click="showSuccess = false"></button>
    </div>

    <div class="row justify-content-center">
      <div class="col-lg-10 col-xl-9">
        <div class="card shadow-lg rounded-4">
          <!-- Header -->
          <div
            class="card-header bg-gradient-primary text-white rounded-top-4 py-3 d-flex justify-content-between align-items-center"
          >
            <h4 class="mb-0 fw-bold">
              <i class="bi bi-calendar-plus me-2"></i>Create New Meeting
            </h4>
            <Link href="/admin/meetings" class="btn btn-light btn-sm">
              <i class="bi bi-arrow-left me-1"></i> Back to Meetings
            </Link>
          </div>

          <!-- Body -->
          <div class="card-body p-4 p-md-5">
            <form @submit.prevent="submitForm">
              <div class="row g-4">
                <!-- Left Column -->
                <div class="col-lg-6">
                  <!-- Title -->
                  <div>
                    <label for="title" class="form-label fw-semibold required-field">Meeting Title</label>
                    <input
                      v-model="form.title"
                      type="text"
                      class="form-control form-control-lg"
                      :class="{ 'is-invalid': form.errors.title }"
                      id="title"
                      required
                      maxlength="255"
                      placeholder="Enter meeting title"
                    />
                    <div class="error-feedback" v-if="form.errors.title">
                      <i class="bi bi-exclamation-circle me-1"></i>{{ form.errors.title }}
                    </div>
                  </div>

                  <!-- Agenda -->
                  <div class="mt-4">
                    <label for="agenda" class="form-label fw-semibold required-field">Agenda</label>
                    <textarea
                      v-model="form.agenda"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.agenda }"
                      id="agenda"
                      rows="4"
                      required
                      maxlength="1000"
                      placeholder="Describe the meeting agenda"
                    ></textarea>
                    <div class="text-muted small mt-1">{{ form.agenda.length }}/1000 characters</div>
                    <div class="error-feedback" v-if="form.errors.agenda">
                      <i class="bi bi-exclamation-circle me-1"></i>{{ form.errors.agenda }}
                    </div>
                  </div>

                  <!-- Date & Time -->
                  <div class="mt-4">
                    <label for="date_time" class="form-label fw-semibold required-field">Date & Time</label>
                    <input
                      v-model="form.date_time"
                      type="datetime-local"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.date_time }"
                      id="date_time"
                      required
                    />
                    <div class="error-feedback" v-if="form.errors.date_time">
                      <i class="bi bi-exclamation-circle me-1"></i>{{ form.errors.date_time }}
                    </div>
                  </div>

                  <!-- Type -->
                  <div class="mt-4">
                    <label class="form-label fw-semibold required-field">Meeting Type</label>
                    <select
                      v-model="form.type"
                      class="form-select"
                      :class="{ 'is-invalid': form.errors.type }"
                      id="type"
                      required
                    >
                      <option value="">-- Select Type --</option>
                      <option value="online">Online</option>
                      <option value="offline">Offline</option>
                    </select>
                    <div class="error-feedback" v-if="form.errors.type">
                      <i class="bi bi-exclamation-circle me-1"></i>{{ form.errors.type }}
                    </div>
                  </div>
                </div>

                <!-- Right Column -->
                <div class="col-lg-6">
                  <!-- Location -->
                  <div v-if="form.type === 'offline'">
                    <label for="location" class="form-label fw-semibold">Location</label>
                    <input
                      v-model="form.location"
                      type="text"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.location }"
                      id="location"
                      maxlength="255"
                      placeholder="Enter meeting location"
                    />
                    <div class="error-feedback" v-if="form.errors.location">
                      <i class="bi bi-exclamation-circle me-1"></i>{{ form.errors.location }}
                    </div>
                  </div>

                  <!-- Meeting Link -->
                  <div v-if="form.type === 'online'" class="mt-4">
                    <label for="meeting_link" class="form-label fw-semibold">Meeting Link</label>
                    <input
                      v-model="form.meeting_link"
                      type="url"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.meeting_link }"
                      id="meeting_link"
                      placeholder="https://example.com/meeting"
                      pattern="https?://.+"
                    />
                    <div class="error-feedback" v-if="form.errors.meeting_link">
                      <i class="bi bi-exclamation-circle me-1"></i>{{ form.errors.meeting_link }}
                    </div>
                  </div>

                  <!-- Minutes -->
                  <div class="mt-4">
                    <label for="minutes" class="form-label fw-semibold">Minutes</label>
                    <textarea
                      v-model="form.minutes"
                      class="form-control"
                      id="minutes"
                      rows="4"
                      maxlength="2000"
                      placeholder="Record meeting minutes (optional)"
                    ></textarea>
                    <div class="text-muted small mt-1">{{ form.minutes.length }}/2000 characters</div>
                  </div>

                  <!-- Decisions -->
                  <div class="mt-4">
                    <label for="decisions" class="form-label fw-semibold">Decisions</label>
                    <textarea
                      v-model="form.decisions"
                      class="form-control"
                      id="decisions"
                      rows="4"
                      maxlength="2000"
                      placeholder="Document decisions made (optional)"
                    ></textarea>
                    <div class="text-muted small mt-1">{{ form.decisions.length }}/2000 characters</div>
                  </div>
                </div>
              </div>

              <!-- Buttons -->
              <div class="d-flex justify-content-end pt-4 mt-3 border-top">
                <button
                  type="button"
                  @click="confirmReset"
                  class="btn btn-outline-secondary me-3 px-4"
                  :disabled="form.processing"
                >
                  <i class="bi bi-arrow-clockwise me-1"></i> Reset
                </button>
                <button
                  type="submit"
                  class="btn btn-primary px-4"
                  :disabled="form.processing"
                >
                  <span
                    v-if="form.processing"
                    class="spinner-border spinner-border-sm me-1"
                    role="status"
                  ></span>
                  <i v-else class="bi bi-check-lg me-1"></i>
                  {{ form.processing ? 'Saving...' : 'Save Meeting' }}
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>


<script setup>
import { useForm, Link } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { ref, reactive } from 'vue'

defineOptions({
  layout: AdminLayout
})

const showSuccess = ref(false)

// Define form fields with default values
const form = useForm({
  title: '',
  agenda: '',
  date_time: '',
  type: '',
  location: '',
  meeting_link: '',
  minutes: '',
  decisions: ''
})

// Function to validate URL format
const isValidUrl = (string) => {
  if (!string) return true
  try {
    new URL(string)
    return true
  } catch (_) {
    return false
  }
}

// Function to validate the form
const validateForm = () => {
  const errors = {}

  if (!form.title.trim()) errors.title = 'Title is required'
  else if (form.title.length > 255) errors.title = 'Title must be less than 255 characters'

  if (!form.agenda.trim()) errors.agenda = 'Agenda is required'

  if (!form.date_time) errors.date_time = 'Date and time is required'
  else {
    const selectedDate = new Date(form.date_time)
    if (selectedDate < new Date()) errors.date_time = 'Meeting must be scheduled for a future time'
  }

  if (!form.type) errors.type = 'Meeting type is required'

  if (form.type === 'online' && form.meeting_link && !isValidUrl(form.meeting_link)) {
    errors.meeting_link = 'Please enter a valid URL'
  }

  return errors
}

// Function to submit the form
const submitForm = () => {
  const errors = validateForm()

  if (Object.keys(errors).length > 0) {
    form.errors = errors
    return
  }

  form.post('/admin/meeting/store', {
    onSuccess: () => {
      showSuccess.value = true
      setTimeout(() => { showSuccess.value = false }, 3000)
    }
  })
}

// Function to confirm reset
const confirmReset = () => {
  if (confirm('Are you sure you want to reset the form? All entered data will be lost.')) {
    form.reset()
  }
}
</script>

<style scoped>
.bg-gradient-primary {
  background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
}
.form-control:focus, .form-select:focus {
  border-color: #4e73df;
  box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.25);
}
.card {
  transition: transform 0.2s ease-in-out, box-shadow 0.2s ease;
  border: none;
}
.card:hover {
  transform: translateY(-5px);
  box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175) !important;
}
.rounded-top-4 {
  border-top-left-radius: 1rem !important;
  border-top-right-radius: 1rem !important;
}
.rounded-4 {
  border-radius: 1rem !important;
}
.btn-light {
  background-color: #f8f9fa;
  border-color: #ddd;
}
.required-field::after {
  content: "*";
  color: #dc3545;
  margin-left: 3px;
}
.error-feedback {
  display: block;
  width: 100%;
  margin-top: 0.25rem;
  font-size: 0.875em;
  color: #dc3545;
}
.success-message {
  position: fixed;
  top: 20px;
  right: 20px;
  z-index: 1050;
  animation: fadeIn 0.5s, fadeOut 0.5s 2.5s forwards;
}
@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}
@keyframes fadeOut {
  from { opacity: 1; }
  to { opacity: 0; }
}
</style>
