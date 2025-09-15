<script setup>

import MemberLayout from '@/Layouts/MemberLayout.vue';
import { ref, reactive,watch } from 'vue';
import { Link } from '@inertiajs/vue3';
import pickBy from 'lodash/pickBy'
import debounce from 'lodash/debounce'
// import {truncate} from '../../../../utils/helpers'
import { truncate } from '../../../utils/helpers';
// import Pagination from '@/Pages/Shared/Pagination.vue';
import Pagination from '@/Pages/Shared/Pagination.vue';

defineOptions({
    layout:MemberLayout
})
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
  window.location.href = `/member/meetings/index?${new URLSearchParams(data).toString()}`
}, 2000)

watch(form, submitSearch, { deep: true })
</script>

<template>
  <div class="container">
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
              <th>View</th>
              <th class="text-end">Join</th>
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
              <td>{{ truncate(meeting.title,20) }}</td>
              <td>{{ meeting.type || '-' }}</td>
              <td>{{ truncate(meeting.agenda, 22)  }}</td>
              <td>{{ meeting.date_time || '-' }}</td>
              <td>
                   <Link href="/meeting/details">
                  <i class="fas fa-eye"></i>
               </Link>
              </td>
              <td class="text-end">

               <Link v-if="meeting.type === 'online'" :href="`/member/meeting/join/${meeting.id}`">
                Join
                </Link>
            <span v-else>
            offline
            </span>
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

             <Pagination :links="meetings.links" />

          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>
