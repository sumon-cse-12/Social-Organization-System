<template>
  <AdminLayout>
    <div class="container-fluid p-3">
      <h1>{{ title }}</h1>
      <p>Welcome to the Admin Dashboard!</p>
    </div>
  </AdminLayout>
</template>

<script>
import AdminLayout from '@layouts/AdminLayout.vue';
export default {
  props: {
    title: String
  },
  components: { AdminLayout }
}
</script>
