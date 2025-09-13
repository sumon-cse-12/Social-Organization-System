<script setup>
import { ref, watch, onMounted, nextTick } from 'vue'
import { useForm } from '@inertiajs/vue3'
import { loadStripe } from '@stripe/stripe-js'
import axios from 'axios'
import MemberLayout from "@/Layouts/MemberLayout.vue"

defineOptions({ layout: MemberLayout })

// --- Refs ---
const selectedPaymentMethod = ref('paypal') // default payment method
const amount = ref(1)                        // default amount
const paymentType = ref('monthly_fee')       // monthly_fee, event_fee, donation

// --- Form ---
const form = useForm({
  payment_method: selectedPaymentMethod.value,
  amount: amount.value,
  type: paymentType.value,
})

// --- Sync refs with form ---
watch([selectedPaymentMethod, amount, paymentType], () => {
  form.payment_method = selectedPaymentMethod.value
  form.amount = amount.value
  form.type = paymentType.value
})

// --- Stripe setup ---
let stripe = null
let elements = null
let cardElement = null

const initStripe = async () => {
  const key = 'pk_test_51P7ZhTB63oCofXLknylh2ox0Kc58yfZjqDIUVvjEH1vvTVe5xguD0Yd60EaNzmhfSVmQy64emIbWoUqToApvq8oH00WgmeRVv7'

  stripe = await loadStripe(key)
  if (!stripe) return console.error('Stripe failed to load!')

  elements = stripe.elements()

  // Destroy previous cardElement if exists
  if (cardElement) cardElement.unmount()

  // Clear container
  const container = document.getElementById('card-element')
  if (container) container.innerHTML = ''

  cardElement = elements.create('card', {
    style: { base: { fontSize: '16px', color: '#32325d' } }
  })
  cardElement.mount('#card-element')
}

// --- Watch payment method changes ---
watch(selectedPaymentMethod, async (val) => {
  if (val === 'stripe') {
    await nextTick()
    initStripe()
  }
})

// --- Initialize Stripe if selected on mount ---
onMounted(async () => {
  if (selectedPaymentMethod.value === 'stripe') {
    await nextTick()
    initStripe()
  }
})

// --- Submit handler ---
const submit = async () => {
  try {
    let url = `/payments/pay/now/${form.payment_method}`

    // --- Send offline payment ---
    if (selectedPaymentMethod.value === 'offline') {
      const { data } = await axios.post(url, form)
      if (data.success) alert('Offline payment request submitted successfully!')
      else alert('Offline payment failed. Please try again.')
      return
    }

    // --- Send payment request for Stripe/PayPal ---
    const { data } = await axios.post(url, form)

    // --- Stripe payment ---
    if (selectedPaymentMethod.value === 'stripe' && data.client_secret) {
      const { paymentIntent, error } = await stripe.confirmCardPayment(data.client_secret, {
        payment_method: { card: cardElement }
      })

      if (error) alert(error.message)
      else if (paymentIntent.status === 'succeeded') alert('Payment successful!')
      return
    }

    // --- PayPal or other gateways redirect ---
    if (data.approval_url) {
      window.location.href = data.approval_url
      return
    }

    // --- Fallback success ---
    alert('Payment processed successfully!')

  } catch (error) {
    console.error('Payment error:', error)
    alert('Payment failed! Please try again.')
  }
}
</script>

<template>
  <div class="checkout-container">
    <div class="checkout-card">
      <!-- Header -->
      <div class="checkout-header">
        <h2>Secure Checkout</h2>
        <p class="text-muted">Complete your payment safely</p>
      </div>

      <!-- Payment Type -->
      <div class="checkout-section">
        <label class="label">Payment Type</label>
        <select v-model="paymentType" class="input-field">
          <option value="monthly_fee">Monthly Fee</option>
          <option value="event_fee">Event Fee</option>
          <option value="donation">Donation</option>
        </select>
      </div>

      <!-- Amount -->
      <div class="checkout-section">
        <label class="label">Amount</label>
        <input type="number" v-model="amount" min="1" class="input-field"/>
      </div>

      <!-- Payment Method -->
      <div class="checkout-section">
        <h5>Select Payment Method</h5>
        <div class="payment-methods">
          <label class="payment-btn d-none" :class="{ active: selectedPaymentMethod==='stripe' }">
            <input type="radio" value="stripe" v-model="selectedPaymentMethod"/>
            <i class="fab fa-cc-stripe"></i>
            <span>Stripe</span>
          </label>

          <label class="payment-btn d-none" :class="{ active: selectedPaymentMethod==='paypal' }">
            <input type="radio" value="paypal" v-model="selectedPaymentMethod"/>
            <i class="fab fa-cc-paypal"></i>
            <span>PayPal</span>
          </label>

          <label class="payment-btn" :class="{ active: selectedPaymentMethod==='offline' }">
            <input type="radio" value="offline" v-model="selectedPaymentMethod"/>
            <i class="fas fa-money-bill-wave"></i>
            <span>Offline</span>
          </label>
        </div>
      </div>

      <!-- Stripe Card Input -->
      <div class="checkout-section" v-if="selectedPaymentMethod==='stripe'">
        <div id="card-element" class="card-element"></div>
      </div>

      <!-- Submit Button -->
      <button @click="submit" class="checkout-btn">Complete Payment</button>
    </div>
  </div>
</template>

<style scoped>
.checkout-container {
  display: flex;
  justify-content: center;
  padding: 50px 15px;
  background: #f2f4f7;
  min-height: 100vh;
  font-family: 'Inter', sans-serif;
}

.checkout-card {
  width: 100%;
  max-width: 600px;
  background: #fff;
  border-radius: 20px;
  box-shadow: 0 12px 28px rgba(0,0,0,0.08);
  padding: 40px 30px;
  transition: all 0.3s;
}

.checkout-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 16px 35px rgba(0,0,0,0.12);
}

.checkout-header h2 {
  font-weight: 700;
  margin-bottom: 5px;
}

.checkout-header p {
  font-size: 0.9rem;
  color: #6c757d;
}

.checkout-section {
  margin-top: 25px;
}

.label {
  display: block;
  margin-bottom: 8px;
  font-weight: 500;
  color: #495057;
}

.input-field {
  width: 100%;
  padding: 12px;
  border-radius: 10px;
  border: 1px solid #ccc;
  font-size: 1rem;
}

.payment-methods {
  display: flex;
  gap: 10px;
  margin-top: 10px;
}

.payment-btn {
  flex: 1;
  padding: 15px;
  background: #f1f3f5;
  border-radius: 15px;
  text-align: center;
  font-weight: 500;
  color: #495057;
  cursor: pointer;
  transition: all 0.3s;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.payment-btn i {
  font-size: 24px;
  margin-bottom: 5px;
}

.payment-btn input { display: none; }

.payment-btn.active,
.payment-btn:hover {
  background: #4e73df;
  color: #fff;
  transform: translateY(-3px);
  box-shadow: 0 6px 15px rgba(0,0,0,0.1);
}

.card-element {
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 10px;
}

.checkout-btn {
  width: 100%;
  margin-top: 30px;
  padding: 15px;
  background: #4e73df;
  color: #fff;
  font-weight: 600;
  border: none;
  border-radius: 50px;
  font-size: 1.1rem;
  transition: all 0.3s;
  cursor: pointer;
}

.checkout-btn:hover {
  background: #224abe;
  transform: translateY(-2px);
  box-shadow: 0 6px 15px rgba(0,0,0,0.15);
}
</style>
