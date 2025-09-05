<script setup>
import { useForm } from '@inertiajs/vue3'
import MemberLayout from "@/Layouts/MemberLayout.vue"
import { ref } from 'vue'

defineOptions({ layout: MemberLayout })

const selectedPaymentMethod = ref('stripe')
const form = useForm({})

const submit = () => {
  console.log('Selected payment method:', selectedPaymentMethod.value)
  // Call API or redirect to payment gateway
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

      <!-- Order Summary -->
      <div class="checkout-section">
        <h5>Order Summary</h5>
        <div class="summary-item">
          <span>Membership Fee</span>
          <span>$100.00</span>
        </div>
        <div class="summary-item total">
          <span>Total</span>
          <span>$100.00</span>
        </div>
        <small class="text-danger mt-2 float-right">Charged Only 1$ for Testing </small>
      </div>

      <!-- Payment Methods -->
      <div class="checkout-section">
        <h5>Select Payment Method</h5>
        <div class="payment-methods">
          <label
            class="payment-btn"
            :class="{ active: selectedPaymentMethod === 'stripe' }"
          >
            <input type="radio" name="payment" value="stripe" v-model="selectedPaymentMethod"/>
            <i class="fab fa-stripe fs-2"></i>
            <span>Stripe</span>
          </label>

          <label
            class="payment-btn"
            :class="{ active: selectedPaymentMethod === 'paypal' }"
          >
            <input type="radio" name="payment" value="paypal" v-model="selectedPaymentMethod"/>
            <i class="fab fa-paypal fs-2"></i>
            <span>PayPal</span>
          </label>

          <label
            class="payment-btn"
            :class="{ active: selectedPaymentMethod === 'offline' }"
          >
            <input type="radio" name="payment" value="offline" v-model="selectedPaymentMethod"/>
            <i class="fas fa-money-bill-wave fs-2"></i>
            <span>Offline</span>
          </label>
        </div>
      </div>

      <!-- Payment Details -->
      <div class="checkout-section">
        <div v-if="selectedPaymentMethod === 'stripe'" class="payment-info">
          <p>Stripe payment form placeholder</p>
        </div>
        <div v-else-if="selectedPaymentMethod === 'paypal'" class="payment-info">
          <p>PayPal button placeholder</p>
        </div>
        <div v-else-if="selectedPaymentMethod === 'offline'" class="payment-info">
          <p>Contact admin to complete offline payment.</p>
        </div>
      </div>

      <!-- Submit -->
      <button @click="submit" class="checkout-btn">Complete Payment</button>
    </div>
  </div>
</template>

<style scoped>
.checkout-container {
  display: flex;
  justify-content: center;
  padding: 50px 15px;
  background: #f8f9fa;
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
  margin-top: 30px;
}

.summary-item {
  display: flex;
  justify-content: space-between;
  padding: 12px 0;
  border-bottom: 1px solid #e9ecef;
  font-weight: 500;
}

.summary-item.total {
  font-size: 1.1rem;
  font-weight: 700;
}

.payment-methods {
  display: flex;
  justify-content: space-between;
  margin-top: 15px;
}

.payment-btn {
  display: flex;
  flex-direction: column;
  align-items: center;
  flex: 1;
  padding: 15px;
  margin: 0 5px;
  background: #f1f3f5;
  border-radius: 15px;
  cursor: pointer;
  transition: all 0.3s;
  text-align: center;
  font-weight: 500;
  color: #495057;
}

.payment-btn input {
  display: none;
}

.payment-btn i {
  margin-bottom: 8px;
}

.payment-btn.active,
.payment-btn:hover {
  background: #4e73df;
  color: #fff;
  transform: translateY(-3px);
  box-shadow: 0 6px 15px rgba(0,0,0,0.1);
}

.payment-info {
  margin-top: 20px;
  padding: 20px;
  border-radius: 15px;
  background: #f8f9fa;
  text-align: center;
  color: #495057;
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
