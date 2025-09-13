<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { ref, watch, reactive } from 'vue'
import { Link } from '@inertiajs/vue3'
import pickBy from 'lodash/pickBy'
import debounce from 'lodash/debounce'
import Pagination from '../../Shared/Pagination.vue'

defineOptions({ layout: AdminLayout })

const props = defineProps({
  meetings: Object,
  filters: Object,
})

// Reactive search form
const form = reactive({
  search: props.filters.search || ''
})

// Submit search with debounce
const submitSearch = debounce(() => {
  const data = pickBy(form)
  window.location.href = `/admin/meetings/index?${new URLSearchParams(data).toString()}`
}, 2000)

watch(form, submitSearch, { deep: true })
</script>

<template>
  <div class="container-fluid mt-4">
    <div class="card main-card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title">All Meetings</h5>
        <div class="d-flex align-items-center gap-2">
          <div class="search-box d-flex align-items-center">
            <i class="fas fa-search me-2"></i>
            <input
              v-model="form.search"
              type="text"
              class="form-control"
              placeholder="Search meeting..."
            >
          </div>

          <Link href="/admin/meeting/create" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add New Meeting
          </Link>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table align-middle">
          <thead>
            <tr>
              <th>Title</th>
              <th>Type</th>
              <th>Agenda</th>
              <th>Date</th>
              <th class="text-end">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-if="meetings.data.length === 0">
              <td colspan="5" class="text-center text-muted py-5">
                <i class="fas fa-search fa-2x mb-2"></i>
                <p>No meetings found.</p>
              </td>
            </tr>
            <tr v-for="meeting in meetings.data" :key="meeting.id">
              <td>{{ meeting.title || '-' }}</td>
              <td>{{ meeting.type || '-' }}</td>
              <td>{{ meeting.agenda || '-' }}</td>
              <td>{{ meeting.date_time || '-' }}</td>
              <td class="text-end">
                <button type="button" class="btn btn-info btn-sm">
                  Action
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div v-if="meetings.data.length > 0" class="card-footer">
        <div class="row justify-content-between align-items-center">
          <div class="col-auto">
            <small class="text-muted">
              Showing <b>{{ meetings.from }}</b> to <b>{{ meetings.to }}</b> of <b>{{ meetings.total }}</b> results
            </small>
          </div>
          <div class="col-auto">
            <!-- Uncomment when Pagination component is ready -->
             <Pagination :links="meetings.links" />

          </div>
        </div>
      </div>
    </div>
  </div>
</template>
