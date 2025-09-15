<script setup>

import AdminLayout from '@/Layouts/AdminLayout.vue';


defineOptions({
    layout:AdminLayout
})

const props = defineProps({
  meeting: {
    type: Object,
    required: true
  }
});
</script>
<template>
  <div class="container my-5">
    <div class="card shadow-lg mx-auto" style="max-width: 600px;">
      <div class="card-body">
        <!-- Type Badge -->
        <span
          class="badge mb-3"
          :class="meeting.type === 'online' ? 'bg-success' : 'bg-primary'">
          {{ meeting.type.toUpperCase() }}
        </span>

        <!-- Title -->
        <h3 class="card-title mb-3">{{ meeting.title }}</h3>

        <!-- Location (only if offline) -->
        <p class="card-text text-muted" v-if="meeting.type === 'offline'">
          <i class="bi bi-geo-alt-fill me-1"></i>
          {{ meeting.location }}
        </p>

        <!-- Agenda -->
        <p class="card-text">{{ meeting.agenda }}</p>

 
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>
