<script setup>
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css'

defineOptions({
  layout: AdminLayout
})


const form = useForm({
  name: '',
  slug: '',
  description: '',
  image: null,
  is_active: true
})

const imageUrl = ref(null)

const showSuccess = ref(false)

const handleImageUpload = (event) => {
  const file = event.target.files[0]
  if (file) {
    form.image = file
    imageUrl.value = URL.createObjectURL(file)
  }
}


const generateSlug = () => {
  form.slug = form.name
    .toLowerCase()
    .trim()
    .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
    .replace(/\s+/g, '-')
    .replace(/[^a-z0-9-]/g, '')
}


const validateForm = () => {
  const errors = {}
  if (!form.name.trim()) errors.name = 'Name is required'
  else if (form.name.length > 255) errors.name = 'Name must be less than 255 characters'

  if (!form.slug.trim()) errors.slug = 'Slug is required'
  else if (form.slug.length > 255) errors.slug = 'Slug must be less than 255 characters'

  return errors
}

const submitCategory = () => {
  const errors = validateForm()
  if (Object.keys(errors).length) {
    form.setErrors(errors)
    return
  }

  form.post('/admin/blog-category/store', {
    onSuccess: () => {
      showSuccess.value = true
      form.reset()
      imageUrl.value = null
      setTimeout(() => (showSuccess.value = false), 3000)
    }
  })
}
</script>

<template>
  <div class="container py-4">

    <div v-if="showSuccess" class="alert alert-success alert-dismissible fade show" role="alert">
      Blog Category created successfully!
      <button type="button" class="btn-close" @click="showSuccess=false"></button>
    </div>

    <div class="col-lg-8 mx-auto">
      <div class="card shadow-sm rounded-4">
        <div class="card-header bg-gradient-primary text-white py-3">
          <h5 class="mb-0 fw-bold">Create Blog Category</h5>
        </div>
        <div class="card-body p-4">
          <form @submit.prevent="submitCategory">

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


            <input type="hidden" v-model="form.slug" />
            <div class="invalid-feedback" v-if="form.errors.slug">{{ form.errors.slug }}</div>

            <div class="mb-3">
              <label class="form-label fw-semibold">Description</label>
              <QuillEditor v-model:content="form.description" content-type="html" theme="snow" />
            </div>
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


            <div class="mb-3">
              <label class="form-label fw-semibold dis">Status</label>
              <select v-model="form.is_active" class="form-select d-block">
                <option :value="true">Active</option>
                <option :value="false">Inactive</option>
              </select>
            </div>
            
            <div class="d-grid mt-4">
              <button type="submit" class="btn btn-primary">Create Category</button>
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
