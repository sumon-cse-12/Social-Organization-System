<template>
  <AdminLayout>
    <div class="container-fluid p-3">

     <h1>Create Page</h1>
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
