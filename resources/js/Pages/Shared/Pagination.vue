<template>
  <nav v-if="links.length > 1" class="d-flex justify-content-center mt-4">
    <ul class="pagination">
      <li
        v-for="link in links"
        :key="link.label"
        :class="['page-item', { disabled: !link.url, active: link.active }]"
      >
        <!-- Inertia Link for clickable pages -->
        <Link
          v-if="link.url"
          :href="link.url"
          class="page-link"
        >
          {{ decodeLabel(link.label) }}
        </Link>

        <!-- Span for disabled / placeholder links -->
        <span v-else class="page-link">
          {{ decodeLabel(link.label) }}
        </span>
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

// Decode HTML entities (like &lt;, &gt;) safely
const decodeLabel = (label) => {
  const parser = new DOMParser()
  return parser.parseFromString(label, 'text/html').body.textContent
}
</script>
