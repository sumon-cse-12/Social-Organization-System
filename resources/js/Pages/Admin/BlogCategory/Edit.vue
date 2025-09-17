<script setup>
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css'

// Use Admin Layout
defineOptions({
  layout: AdminLayout
})

// Receive blog_category from Laravel controller
const props = defineProps({
  blog_category: Object
})

const form = useForm({
  _method: 'put',
  name: props.blog_category.name || '',
  slug: props.blog_category.slug || '',
  description: props.blog_category.description || '',
  image: null,
  is_active: props.blog_category.is_active ?? true
})

// Correct existing image URL
const imageUrl = ref(
  props.blog_category.image
    ? `${window.location.origin}/storage/${props.blog_category.image}`
    : null
)

// Success message
const showSuccess = ref(false)

// Handle new image upload
const handleImageUpload = (event) => {
  const file = event.target.files[0]
  if (file) {
    form.image = file
    imageUrl.value = URL.createObjectURL(file)
  }
}

// Auto-generate slug from name
const generateSlug = () => {
  form.slug = form.name
    .toLowerCase()
    .trim()
    .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
    .replace(/\s+/g, '-')
    .replace(/[^a-z0-9-]/g, '')
}

// Form validation (optional, can be kept as is)
const validateForm = () => {
  const errors = {}
  if (!form.name.trim()) errors.name = 'Name is required'
  if (!form.slug.trim()) errors.slug = 'Slug is required'
  return errors
}

// REVISED submit function
const submitCategory = () => {
    // Client-side validation is optional but good practice
    const errors = validateForm();
    if (Object.keys(errors).length) {
        form.setErrors(errors);
        return;
    }

    // Use form.post and let Inertia handle everything automatically
    form.post(`/admin/blog-category/update/${props.blog_category.id}`, {
        onSuccess: () => {
            showSuccess.value = true
            setTimeout(() => (showSuccess.value = false), 3000)
            // Optional: clear the file input after successful upload
            form.image = null;
        },
        // preserveState and preserveScroll can be useful here
        preserveScroll: true,
    });
}
</script>

<template>
  <div class="container py-4">

    <!-- Success Message -->
    <div v-if="showSuccess" class="alert alert-success alert-dismissible fade show" role="alert">
      Blog Category updated successfully!
      <button type="button" class="btn-close" @click="showSuccess=false"></button>
    </div>

    <div class="col-lg-8 mx-auto">
      <div class="card shadow-sm rounded-4">
        <div class="card-header bg-gradient-primary text-white py-3">
          <h5 class="mb-0 fw-bold">Edit Blog Category</h5>
        </div>
        <div class="card-body p-4">
          <form @submit.prevent="submitCategory">

            <!-- Category Name -->
            <div class="mb-3">
              <label class="form-label fw-semibold">Category Name</label>
              <input
                v-model="form.name"
                @input="generateSlug"
                type="text"
                class="form-control"
                :class="{ 'is-invalid': form.errors.name }"
                placeholder="Enter category name"
                required
              />
              <div class="invalid-feedback" v-if="form.errors.name">{{ form.errors.name }}</div>
            </div>

            <!-- Slug (hidden) -->
            <input type="hidden" v-model="form.slug" />
            <div class="invalid-feedback" v-if="form.errors.slug">{{ form.errors.slug }}</div>

            <!-- Description -->
            <div class="mb-3">
              <label class="form-label fw-semibold">Description</label>
              <QuillEditor
                v-model:content="form.description"
                content-type="html"
                theme="snow"
              />
            </div>

            <!-- Image -->
            <div class="mb-3">
              <label class="form-label fw-semibold">Image</label>
              <div class="d-flex align-items-center">
                <img v-if="imageUrl" :src="imageUrl" class="img-thumbnail me-2" width="80" />
                <label class="btn btn-outline-secondary mb-0">
                  Choose Image
                  <input type="file" @change="handleImageUpload" class="d-none" accept="image/*" />
                </label>
              </div>
            </div>

            <!-- Status -->
            <div class="mb-3">
              <label class="form-label fw-semibold">Status</label>
              <select v-model="form.is_active" class="form-select d-block">
                <option :value="true">Active</option>
                <option :value="false">Inactive</option>
              </select>
            </div>

            <!-- Submit -->
            <div class="d-grid mt-4">
              <button type="submit" class="btn btn-primary">Update Category</button>
            </div>

          </form>
        </div>
      </div>
    </div>

  </div>
</template>

<style scoped>
.img-thumbnail {
  object-fit: cover;
  border-radius: 8px;
  border: 1px solid #dee2e6;
}
</style>
