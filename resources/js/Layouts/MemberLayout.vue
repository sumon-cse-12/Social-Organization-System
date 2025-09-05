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
import Header from '../Components/Header.vue';
import MemberSidebar  from '../Components/MemberSidebar.vue';
import Footer from '../Components/Footer.vue';
export default {
  components: { Header, MemberSidebar, Footer }
}
</script>
