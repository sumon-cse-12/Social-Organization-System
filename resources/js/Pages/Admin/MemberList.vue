<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { ref, watch } from 'vue'
import { Link } from '@inertiajs/vue3'
import pickBy from 'lodash/pickBy'
import debounce from 'lodash/debounce'
import Pagination from '../Shared/Pagination.vue'

defineOptions({ layout: AdminLayout })

// Props from controller
const props = defineProps({
  members: Object,
  filters: Object,
})

// Reactive form for search and status
const form = ref({
  search: props.filters.search || '',
  status: props.filters.status || null,
})

const submitSearch = debounce(() => {
  const data = pickBy(form.value)
  window.location.href = `/admin/member/index?${new URLSearchParams(data).toString()}`
}, 2000)

watch(form, submitSearch, { deep: true })


const statusClass = (status) => {
  return {
    approved: 'status-active',
    pending: 'status-pending',
    rejected: 'status-inactive',
  }[status] || 'bg-secondary'
}
</script>

<template>
  <div class="container-fluid mt-4">
    <div class="card main-card">


      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title">Project Members</h5>
        <div class="d-flex align-items-center gap-2">

          <div class="search-box d-flex align-items-center">
            <i class="fas fa-search me-2"></i>
            <input
              v-model="form.search"
              type="text"
              class="form-control"
              placeholder="Search members..."
            >
          </div>

          <select v-model="form.status" class="form-select" style="width: 150px;">
            <option value="">All Status</option>
            <option value="approved">Approved</option>
            <option value="pending">Pending</option>
            <option value="rejected">Rejected</option>
          </select>
          <Link href="/admin/member/create" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add Member
          </Link>
        </div>
      </div>


      <div class="table-responsive">
        <table class="table align-middle">
          <thead>
            <tr>
              <th>Member</th>
              <th>Phone</th>
              <th>Status</th>
              <th>Joining Date</th>
              <th class="text-end">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-if="members.data.length === 0">
              <td colspan="5" class="text-center text-muted py-5">
                <i class="fas fa-search fa-2x mb-2"></i>
                <p>No members found.</p>
              </td>
            </tr>
            <tr v-for="member in members.data" :key="member.id">
              <td>
                <div class="user-info d-flex align-items-center gap-2">
                  <img
                    :src="`https://ui-avatars.com/api/?name=${member.name.replace(' ', '+')}&background=random`"
                    alt="Profile"
                    class="avatar"
                  >
                  <div>
                    <span class="user-name">{{ member.name }}</span>
                    <small class="user-email">{{ member.email }}</small>
                  </div>
                </div>
              </td>
              <td>{{ member.phone || '-' }}</td>
              <td>
                <span class="status" :class="statusClass(member.status)">
                  {{ member.status }}
                </span>
              </td>
              <td>{{ member.membership_date }}</td>
              <td class="text-end">
                <Link :href="`/admin/member/${member.id}`" class="action-btn" title="View">
                  <i class="fas fa-eye"></i>
                </Link>
                <Link :href="`/admin/member/${member.id}/edit`" class="action-btn" title="Edit">
                  <i class="fas fa-pencil-alt"></i>
                </Link>
                <button class="action-btn text-danger" title="Delete">
                  <i class="fas fa-trash-alt"></i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div v-if="members.data.length > 0" class="card-footer">
        <div class="row justify-content-between align-items-center">
          <div class="col-auto">
            <small class="text-muted">
              Showing <b>{{ members.from }}</b> to <b>{{ members.to }}</b> of <b>{{ members.total }}</b> results
            </small>
          </div>
          <div class="col-auto">
            <Pagination :links="members.links" />
          </div>
        </div>
      </div>

    </div>
  </div>
</template>
