<script setup>
import { useForm, usePage } from '@inertiajs/vue3'
import MemberLayout from "@/Layouts/MemberLayout.vue"
import { toast } from "vue3-toastify"
import "vue3-toastify/dist/index.css"

const page = usePage()
const memberData = page.props.member ?? {}

defineOptions({ layout: MemberLayout })

// Format date to YYYY-MM-DD
const formatDate = (date) => {
  if (!date) return ''
  return new Date(date).toISOString().split('T')[0]
}

// Form setup
const form = useForm({
  name: memberData.name || '',
  email: memberData.email || '',
  phone: memberData.phone || '',
  address: memberData.address || '',
  date_of_birth: formatDate(memberData.date_of_birth),
  emergency_contact: memberData.emergency_contact || '',
  membership_fee: memberData.membership_fee || 0,
  status: memberData.status || '',
  id_proof: null,
})

// Form submit
const submit = () => {
  form.put('/member/profile/update', {
    preserveScroll: true,
    onSuccess: () => {
      // show backend flash message (Laravel -> with('success', '...'))
      if (page.props.flash?.success) {
        toast.success(page.props.flash.success, { autoClose: 3000, position: "top-right" })
      }
    },
    onError: (errors) => {
      if (errors && Object.keys(errors).length) {
        const firstError = errors[Object.keys(errors)[0]][0]
        toast.error(firstError, { autoClose: 4000, position: "top-right" })
      } else if (page.props.flash?.error) {
        toast.error(page.props.flash.error, { autoClose: 4000, position: "top-right" })
      }
    },
  })
}
</script>

<template>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="card shadow-sm">
          <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Edit Profile</h4>
          </div>
          <div class="card-body">
            <form @submit.prevent="submit" enctype="multipart/form-data">
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label">Name</label>
                  <input v-model="form.name" type="text" class="form-control" />
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">Email</label>
                  <input v-model="form.email" type="email" class="form-control" />
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label">Phone</label>
                  <input v-model="form.phone" type="text" class="form-control" />
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">Date of Birth</label>
                  <input v-model="form.date_of_birth" type="date" class="form-control" />
                </div>
              </div>

              <div class="mb-3">
                <label class="form-label">Address</label>
                <input v-model="form.address" type="text" class="form-control" />
              </div>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label">Emergency Contact</label>
                  <input v-model="form.emergency_contact" type="text" class="form-control" />
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">Membership Fee</label>
                  <input v-model="form.membership_fee" type="number" class="form-control" />
                </div>
              </div>

              <div class="mb-3">
                <label class="form-label">Status</label>
                <input v-model="form.status" readonly type="text" class="form-control" />
              </div>

              <div class="mb-3">
                <label class="form-label">ID Proof</label>
                <input @change="e => form.id_proof = e.target.files[0]" type="file" class="form-control" />
              </div>

              <button type="submit" class="btn btn-primary mt-3 w-100">Update Profile</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
