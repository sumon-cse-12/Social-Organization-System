<script setup>

import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref, reactive,watch } from 'vue';
import { Link } from '@inertiajs/vue3';
import pickBy from 'lodash/pickBy'
import debounce from 'lodash/debounce'
// import {truncate} from '../../../../utils/helpers'
import { truncate } from '../../../utils/helpers';
// import Pagination from '@/Pages/Shared/Pagination.vue';
import Pagination from '@/Pages/Shared/Pagination.vue';

defineOptions({
    layout:AdminLayout
})
const props = defineProps({
  categories: Object,
  filters: Object,
})

// Reactive search form
const form = reactive({
  search: props.filters.search || ''
})

// Submit search with debounce
const submitSearch = debounce(() => {
  const data = pickBy(form)
  window.location.href = `/admin/blog-categories/index?${new URLSearchParams(data).toString()}`
}, 2000)

watch(form, submitSearch, { deep: true })
</script>

<template>
  <div class="container-fluid mt-4">
    <div class="card main-card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title">All Category</h5>
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

          <Link href="/admin/blog-category/create" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add New Category
          </Link>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table align-middle">
          <thead>
            <tr>
              <th>Name</th>
              <th>Image</th>
              <th>Status</th>
              <th>Created At</th>
              <th class="text-end">Action</th>
            </tr>
          </thead>
          <!-- <tbody>
            <tr v-if="meetings.data.length === 0">
              <td colspan="5" class="text-center text-muted py-5">
                <i class="fas fa-search fa-2x mb-2"></i>
                <p>No meetings found.</p>
              </td>
            </tr>
            <tr v-for="meeting in meetings.data" :key="meeting.id">
              <td>{{ truncate(meeting.title,20) }}</td>
              <td>{{ meeting.type || '-' }}</td>
              <td>{{ truncate(meeting.agenda, 22)  }}</td>
              <td>{{ meeting.date_time || '-' }}</td>

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
          </tbody> -->
        </table>
      </div>
<!--
      <div v-if="meetings.data.length > 0" class="card-footer">
        <div class="row justify-content-between align-items-center">
          <div class="col-auto">
            <small class="text-muted">
              Showing <b>{{ meetings.from }}</b> to <b>{{ meetings.to }}</b> of <b>{{ meetings.total }}</b> results
            </small>
          </div>
          <div class="col-auto">

             <Pagination :links="meetings.links" />

          </div>
        </div>
      </div> -->
    </div>
  </div>
</template>

<style scoped>

</style>
