<script setup>
import { ref, watch } from 'vue'
import { Link } from '@inertiajs/vue3'
import Pagination from '../../Shared/Pagination.vue'
import pickBy from 'lodash/pickBy'
import throttle from 'lodash/throttle'
import MemberLayout from "@/Layouts/MemberLayout.vue";


defineOptions({ layout: MemberLayout });
// Props from controller
const props = defineProps({
  members: Object,
  filters: Object,
})

// Reactive form
const form = ref({
  search: props.filters.search || '',
  status: props.filters.status || null,
})

// Watch form changes to auto-submit (like PingCRM)
watch(
  form,
  throttle(() => {
    const data = pickBy(form.value) // remove empty filters
    window.location.href = `/member/all?${new URLSearchParams(data).toString()}`
  }, 300),
  { deep: true }
)
</script>

<template>
  <div class="container py-5">
    <h1 class="h3 mb-4">All Members</h1>

    <!-- Filters -->
    <div class="d-flex gap-2 mb-4">
      <input
        v-model="form.search"
        type="text"
        class="form-control"
        placeholder="Search by name, email, or status..."
      />
      <select v-model="form.status" class="form-select" style="width: 200px;">
        <option value="">All Status</option>
        <option value="active">Active</option>
        <option value="inactive">Inactive</option>
      </select>
      <Link href="/member/all" class="btn btn-secondary">Reset</Link>
    </div>

    <!-- Members Table -->
    <div class="card">
      <div class="table-responsive">
        <table class="table table-hover table-striped mb-0">
          <thead class="table-light">
            <tr>
              <th>Name</th>
              <th>Email</th>
              <th>Status</th>
              <th>Member Since</th>
            </tr>
          </thead>
          <tbody>
            <tr v-if="members.data.length === 0">
              <td colspan="4" class="text-center">No members found.</td>
            </tr>
            <tr v-for="member in members.data" :key="member.id">
              <td>
                 <Link
              :href="`/member/profile/details/${member.id}`"
              class="text-decoration-none"
            >
              {{ member.name }}
            </Link>
              </td>
              <td>{{ member.email }}</td>
              <td>
                <span :class="`badge bg-${member.status === 'active' ? 'success' : 'secondary'}`">
                  {{ member.status }}
                </span>
              </td>
              <td>{{ new Date(member.created_at).toLocaleDateString() }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Pagination -->
    <Pagination :links="members.links" class="mt-4" />
  </div>
</template>
