<template>
  <div class="wrapper">
    <Header />
    <MemberSidebar />
    <div class="content-wrapper">
      <slot /> <!-- Page content injected here -->
    </div>
    <Footer />
  </div>
</template>

<script>
import MemberHeader from '../Components/MemberHeader.vue';
import MemberSidebar  from '../Components/MemberSidebar.vue';
import Footer from '../Components/Footer.vue';
export default {
  components: { MemberHeader, MemberSidebar, Footer }
}
</script>
