<template>
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">
      <!-- Notification Button -->

      <li class="nav-item dropdown">
        <button class="btn btn-primary" @click="toggleDropdown">
          Notifications ({{ unreadCount }})
        </button>

        <!-- Dropdown List -->
        <div v-if="showDropdown" class="dropdown-menu dropdown-menu-right show">
          <ul class="list-unstyled mb-0 p-2">
            <li v-for="n in notifications" :key="n.id" class="border-bottom mb-1 pb-1">
              <strong>{{ n.title }}</strong>
              <p class="mb-0">{{ n.message }}</p>
              <small>{{ formatDate(n.created_at) }}</small>
            </li>
            <li v-if="notifications.length === 0" class="text-center">No notifications</li>
          </ul>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#"><i class="fas fa-expand-arrows-alt"></i></a>
      </li>
    </ul>
  </nav>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import axios from 'axios'
import { toast } from 'vue3-toastify'
import 'vue3-toastify/dist/index.css'

const notifications = ref([])
const showDropdown = ref(false)
const shownNotifications = ref(new Set())

const toggleDropdown = () => {
  showDropdown.value = !showDropdown.value
}

const formatDate = (date) => new Date(date).toLocaleString()

const fetchNotifications = async () => {
  try {
    const { data } = await axios.get('/member/notifications')
    notifications.value = data

    data.forEach(n => {
      if (n.type === 'fee' && !shownNotifications.value.has(n.id)) {
        toast.info(`💰 ${n.message} Amount: ${n.amount}`, { position: 'top-right' })
        shownNotifications.value.add(n.id)
      }
    })
  } catch (e) {
    console.error(e)
  }
}

const unreadCount = computed(() => notifications.value.filter(n => !n.read_at).length)

onMounted(() => {
  fetchNotifications()
  setInterval(fetchNotifications, 2 * 60 * 1000)
})
</script>


<style scoped>
.dropdown-menu {
  position: absolute;
  right: 0;
  top: 100%;
  background: #fff;
  border: 1px solid #ddd;
  border-radius: 8px;
  width: 300px;
  max-height: 400px;
  overflow-y: auto;
  z-index: 9999;
}

.dropdown-menu ul {
  margin: 0;
  padding: 0;
  list-style: none;
}

.dropdown-menu li {
  padding: 8px;
}
</style>
