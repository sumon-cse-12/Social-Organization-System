<template>
  <MemberLayout>
    <div class="container-fluid p-3">
      <h1>{{ title }}</h1>
      <p>Welcome to the Member Dashboard!</p>
    </div>
  </MemberLayout>
</template>

<script>
import MemberLayout from '@layouts/MemberLayout.vue';
export default {
  props: {
    title: String
  },
  components: { MemberLayout }
}
</script>
