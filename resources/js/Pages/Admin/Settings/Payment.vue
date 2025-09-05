<script setup>
import { useForm, usePage } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { ref, watch, onMounted } from 'vue'
import { toast } from 'vue3-toastify'
import 'vue3-toastify/dist/index.css'

defineOptions({ layout: AdminLayout })

// Props from controller
const props = defineProps({
  settings: Object
})

// Active tab
const activeTab = ref('paypal')

// Form
const form = useForm({
  gateway: 'paypal',
  mode: props.settings.paypal?.mode || 'sandbox',
  apiKey: props.settings.paypal?.apiKey || '',
  apiSecret: props.settings.paypal?.apiSecret || '',
  offlineNote: props.settings.offline?.offlineNote || '',
  isActive: props.settings.paypal?.isActive ?? true
})

// Update form when tab changes
watch(activeTab, (tab) => {
  form.gateway = tab
  form.mode = props.settings[tab]?.mode || 'sandbox'
  form.isActive = props.settings[tab]?.isActive ?? true
  form.apiKey = props.settings[tab]?.apiKey || ''
  form.apiSecret = props.settings[tab]?.apiSecret || ''
  form.offlineNote = props.settings[tab]?.offlineNote || ''
})

// Show success toast if flash exists
const page = usePage()
onMounted(() => {
  if (page.props.flash?.success) {
    toast.success(page.props.flash.success, { position: 'top-right' })
  }
})

// Handle form submission
const submit = () => {
  form.post('/admin/payment/settings/store', {
    onSuccess: () => {
      toast.success('Payment settings saved successfully!', { position: 'top-right' })
    },
    onError: (errors) => {
      toast.error('Error saving settings!', { position: 'top-right' })
    }
  })
}
</script>

<template>
  <div class="p-6 max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold mb-6">Payment Settings</h1>

    <!-- Tabs -->
    <div class="border-b mb-6">
      <ul class="flex space-x-4">
        <li>
          <button @click="activeTab = 'paypal'"
                  :class="activeTab === 'paypal' ? 'border-b-2 border-blue-600 text-blue-600 font-semibold' : 'text-gray-500'"
                  class="pb-2 px-3 transition-colors duration-200">
            <i class="fab fa-paypal me-1"></i> PayPal
          </button>
        </li>
        <li>
          <button @click="activeTab = 'stripe'"
                  :class="activeTab === 'stripe' ? 'border-b-2 border-purple-600 text-purple-600 font-semibold' : 'text-gray-500'"
                  class="pb-2 px-3 transition-colors duration-200">
            <i class="fab fa-stripe me-1"></i> Stripe
          </button>
        </li>
        <li>
          <button @click="activeTab = 'offline'"
                  :class="activeTab === 'offline' ? 'border-b-2 border-gray-600 text-gray-800 font-semibold' : 'text-gray-500'"
                  class="pb-2 px-3 transition-colors duration-200">
            <i class="fas fa-money-bill-wave me-1"></i> Offline
          </button>
        </li>
      </ul>
    </div>

    <!-- Form Card -->
    <div class="bg-white shadow rounded-lg p-6 space-y-6">
      <!-- Mode & Active Toggle -->
      <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="flex flex-col">
          <label class="text-sm font-medium mb-1">Mode</label>
          <select v-model="form.mode" class="w-48 rounded border-gray-300 text-sm px-3 py-2">
            <option value="sandbox">Sandbox</option>
            <option value="live">Live</option>
          </select>
        </div>
        <div class="flex items-center gap-2">
          <input type="checkbox" id="activeToggle" v-model="form.isActive" class="h-5 w-5 text-blue-600">
          <label for="activeToggle" class="text-sm font-medium">Enable Gateway</label>
        </div>
      </div>

      <!-- PayPal -->
      <div v-if="activeTab === 'paypal'" class="space-y-4">
        <div>
          <label class="block text-sm font-medium mb-1">Client ID</label>
          <input v-model="form.apiKey" type="text" class="w-full rounded border-gray-300 text-sm px-3 py-2" placeholder="PayPal Client ID" />
        </div>
        <div>
          <label class="block text-sm font-medium mb-1">Secret</label>
          <input v-model="form.apiSecret" type="password" class="w-full rounded border-gray-300 text-sm px-3 py-2" placeholder="PayPal Secret" />
        </div>
      </div>

      <!-- Stripe -->
      <div v-if="activeTab === 'stripe'" class="space-y-4">
        <div>
          <label class="block text-sm font-medium mb-1">Publishable Key</label>
          <input v-model="form.apiKey" type="text" class="w-full rounded border-gray-300 text-sm px-3 py-2" placeholder="Stripe Publishable Key" />
        </div>
        <div>
          <label class="block text-sm font-medium mb-1">Secret Key</label>
          <input v-model="form.apiSecret" type="password" class="w-full rounded border-gray-300 text-sm px-3 py-2" placeholder="Stripe Secret Key" />
        </div>
      </div>

      <!-- Offline -->
      <div v-if="activeTab === 'offline'" class="space-y-2">
        <div>
          <label class="block text-sm font-medium mb-1">Offline Payment Note</label>
          <textarea v-model="form.offlineNote" rows="4" class="w-full rounded border-gray-300 text-sm px-3 py-2" placeholder="Instructions for offline payment"></textarea>
        </div>
        <p class="text-xs text-gray-500">
          ⚡ This note will be displayed to customers choosing <b>Offline Payment</b>.
        </p>
      </div>

      <!-- Save Button -->
      <div class="mt-4">
        <button @click="submit" class="px-6 py-2 bg-blue-600 text-white font-semibold rounded hover:bg-blue-700 transition">
          Save Settings
        </button>
      </div>
    </div>
  </div>
</template>
