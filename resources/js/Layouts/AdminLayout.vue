<template>
  <div class="wrapper">
    <Header />
    <Sidebar />
    <div class="content-wrapper">
      <slot /> <!-- Page content injected here -->
    </div>
    <Footer />
  </div>
</template>

<script>
import Header from '../Components/Header.vue';
import Sidebar  from '../Components/Sidebar.vue';
import Footer from '../Components/Footer.vue';
export default {
  components: { Header, Sidebar, Footer }
}
</script>
