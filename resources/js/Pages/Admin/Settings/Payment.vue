<template>
  <div class="settings-container">
    <h1 class="title">Payment Settings</h1>

    <!-- Tabs -->
    <div class="tabs">
      <button :class="{ active: activeTab === 'paypal' }" @click="activeTab='paypal'">
        <i class="fab fa-paypal me-1"></i> PayPal
      </button>
      <button :class="{ active: activeTab === 'stripe' }" @click="activeTab='stripe'">
        <i class="fab fa-stripe me-1"></i> Stripe
      </button>
      <button :class="{ active: activeTab === 'razorpay' }" @click="activeTab='razorpay'">
        <i class="fas fa-credit-card me-1"></i> Razorpay
      </button>
      <button :class="{ active: activeTab === 'offline' }" @click="activeTab='offline'">
        <i class="fas fa-money-bill-wave me-1"></i> Offline
      </button>
    </div>

    <!-- Form Card -->
    <div class="form-card">
      <!-- Mode & Active Toggle (Not for Offline) -->
      <div v-if="activeTab !== 'offline'" class="form-row">
        <div>
          <label>Mode</label>
          <select v-model="form.mode">
            <option value="sandbox">Sandbox</option>
            <option value="live">Live</option>
          </select>
        </div>
        <div>
          <label>Status</label>
          <select v-model="form.isActive">
            <option :value="true">Active</option>
            <option :value="false">Inactive</option>
          </select>
        </div>
      </div>

      <!-- Gateway Fields -->
      <div class="gateway-fields">
        <!-- PayPal -->
        <div v-if="activeTab === 'paypal'">
          <div>
            <label>Client ID</label>
            <input type="text" v-model="form.apiKey" placeholder="PayPal Client ID" />
          </div>
          <div>
            <label>Secret Key</label>
            <input type="password" v-model="form.apiSecret" placeholder="PayPal Secret Key" />
          </div>
        </div>

        <!-- Stripe -->
        <div v-if="activeTab === 'stripe'">
          <div>
            <label>Publishable Key</label>
            <input type="text" v-model="form.apiKey" placeholder="Stripe Publishable Key" />
          </div>
          <div>
            <label>Secret Key</label>
            <input type="password" v-model="form.apiSecret" placeholder="Stripe Secret Key" />
          </div>
        </div>

        <!-- Razorpay -->
        <div v-if="activeTab === 'razorpay'">
          <div>
            <label>Key ID</label>
            <input type="text" v-model="form.apiKey" placeholder="Razorpay Key ID" />
          </div>
          <div>
            <label>Key Secret</label>
            <input type="password" v-model="form.apiSecret" placeholder="Razorpay Key Secret" />
          </div>
        </div>

        <!-- Offline -->
        <div v-if="activeTab === 'offline'">
          <div>
            <label>Status</label>
            <select v-model="form.isActive">
              <option :value="true">Active</option>
              <option :value="false">Inactive</option>
            </select>
          </div>
          <div>
            <label>Offline Payment Note</label>
            <textarea v-model="form.offlineNote" rows="4" placeholder="Instructions for offline payment"></textarea>
          </div>
          <p class="info-text">
            ⚡ This note will be displayed to customers choosing <b>Offline Payment</b>.
          </p>
        </div>
      </div>

      <!-- Save Button -->
      <button class="save-btn" @click="submit">Save Settings</button>
    </div>
  </div>
</template>

<script setup>
import { useForm, usePage } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { ref, watch, onMounted } from 'vue'
import { toast } from 'vue3-toastify'
import 'vue3-toastify/dist/index.css'

defineOptions({ layout: AdminLayout })

const props = defineProps({ settings: Object })
const activeTab = ref('paypal')

const form = useForm({
  gateway: 'paypal',
  mode: props.settings.paypal?.mode || 'sandbox',
  apiKey: props.settings.paypal?.apiKey || '',
  apiSecret: props.settings.paypal?.apiSecret || '',
  offlineNote: props.settings.offline?.offlineNote || '',
  isActive: props.settings.paypal?.isActive ?? true
})

watch(activeTab, (tab) => {
  form.gateway = tab
  form.mode = props.settings[tab]?.mode || 'sandbox'
  form.isActive = props.settings[tab]?.isActive ?? true
  form.apiKey = props.settings[tab]?.apiKey || ''
  form.apiSecret = props.settings[tab]?.apiSecret || ''
  form.offlineNote = props.settings[tab]?.offlineNote || ''
})

const page = usePage()
onMounted(() => {
  if (page.props.flash?.success) toast.success(page.props.flash.success, { position: 'top-right' })
})

const submit = () => {
  form.post('/admin/payment/settings/store', {
    onSuccess: () => toast.success('Payment settings saved successfully!', { position: 'top-right' }),
    onError: () => toast.error('Error saving settings!', { position: 'top-right' })
  })
}
</script>

<style scoped>
.settings-container { max-width: 700px; margin: 50px auto; font-family: 'Inter', sans-serif; }
.title { font-size: 2rem; font-weight: 700; margin-bottom: 30px; text-align: center; color: #2c3e50; }

.tabs { display: flex; gap: 10px; margin-bottom: 25px; flex-wrap: wrap; }
.tabs button { flex: 1; padding: 12px 15px; background: #f1f3f5; border: none; border-radius: 12px; font-weight: 600; cursor: pointer; transition: 0.3s; }
.tabs button.active { background: #4e73df; color: #fff; transform: translateY(-2px); }

.form-card { background: #fff; padding: 30px; border-radius: 20px; box-shadow: 0 12px 28px rgba(0,0,0,0.08); transition: 0.3s; }
.form-row { display: flex; gap: 20px; margin-bottom: 20px; flex-wrap: wrap; }
.form-row div { flex: 1; display: flex; flex-direction: column; }

label { margin-bottom: 6px; font-weight: 500; color: #555; }
input, select, textarea { padding: 10px 12px; border-radius: 12px; border: 1px solid #ddd; font-size: 0.95rem; width: 100%; box-sizing: border-box; transition: 0.2s; }
input:focus, select:focus, textarea:focus { border-color: #4e73df; box-shadow: 0 0 0 2px rgba(78,115,223,0.2); outline: none; }
textarea { resize: vertical; min-height: 80px; }

.gateway-fields { display: flex; flex-direction: column; gap: 15px; margin-bottom: 15px; }
.info-text { font-size: 0.8rem; color: #888; margin-top: 5px; }

.save-btn { width: 100%; padding: 14px 0; margin-top: 20px; background: #4e73df; color: #fff; font-weight: 600; border: none; border-radius: 50px; cursor: pointer; transition: 0.3s; }
.save-btn:hover { transform: translateY(-2px); box-shadow: 0 6px 15px rgba(0,0,0,0.15); }
</style>
