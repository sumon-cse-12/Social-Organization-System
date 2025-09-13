<template>
  <nav v-if="links.length > 1" class="d-flex justify-content-center mt-4">
    <ul class="pagination mb-0">
      <li
        v-for="(link, index) in links"
        :key="index"
        :class="['page-item', { disabled: !link.url, active: link.active }]"
      >
        <!-- Inertia Link for clickable pages -->
        <Link
          v-if="link.url"
          :href="link.url"
          class="page-link"
          preserve-state
          preserve-scroll
          v-html="link.label"
        />

        <!-- Span for disabled / placeholder links -->
        <span v-else class="page-link" v-html="link.label"></span>
      </li>
    </ul>
  </nav>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
  links: {
    type: Array,
    required: true
  }
})
</script>
