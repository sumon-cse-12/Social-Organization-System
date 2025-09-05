<script setup>
import { usePage } from "@inertiajs/vue3";
import MemberLayout from "@/Layouts/MemberLayout.vue";
import { Link } from '@inertiajs/vue3'

defineOptions({ layout: MemberLayout });

defineProps({
  member: {
    type: Object,
    required: true
  }
})
</script>

<template>
  <div class="container my-5">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="card shadow-lg border-0 rounded-3">
          <div class="card-header bg-dark text-white p-4 d-flex justify-content-between align-items-center rounded-top-3">
            <h4 class="mb-0 fw-bold">My Profile</h4>
            <div>
              <Link href="/payments/index" class="btn btn-warning btn-sm fw-bold me-2">
                <i class="fas fa-credit-card me-1"></i> Pay Now
              </Link>
              <Link href="/member/profile/edit" class="btn btn-secondary btn-sm fw-bold">
                <i class="fas fa-edit me-1"></i> Edit Profile
              </Link>
            </div>
          </div>
          <div class="card-body p-5">
            <div class="row">
              <div class="col-md-6">
                <ul class="list-unstyled fw-medium">
                  <li class="mb-3"><i class="fas fa-user text-primary me-3"></i><strong class="text-secondary">Name:</strong> {{ member.name }}</li>
                  <li class="mb-3"><i class="fas fa-envelope text-primary me-3"></i><strong class="text-secondary">Email:</strong> {{ member.email }}</li>
                  <li class="mb-3"><i class="fas fa-phone text-primary me-3"></i><strong class="text-secondary">Phone:</strong> {{ member.phone || '-' }}</li>
                  <li class="mb-3"><i class="fas fa-home text-primary me-3"></i><strong class="text-secondary">Address:</strong> {{ member.address || '-' }}</li>
                  <li class="mb-3"><i class="fas fa-birthday-cake text-primary me-3"></i><strong class="text-secondary">Date of Birth:</strong> {{ member.date_of_birth || '-' }}</li>
                </ul>
              </div>
              <div class="col-md-6 border-start ps-5">
                <ul class="list-unstyled fw-medium">
                  <li class="mb-3"><i class="fas fa-heart text-primary me-3"></i><strong class="text-secondary">Emergency Contact:</strong> {{ member.emergency_contact || '-' }}</li>
                  <li class="mb-3"><i class="fas fa-money-bill text-primary me-3"></i><strong class="text-secondary">Membership Fee:</strong> ${{ member.membership_fee }}</li>
                  <li class="mb-3"><i class="fas fa-info-circle text-primary me-3"></i><strong class="text-secondary">Status:</strong> <span class="badge" :class="{'bg-success': member.status === 'active', 'bg-warning text-dark': member.status !== 'active'}">{{ member.status }}</span></li>
                  <li class="mb-3" v-if="member.membership_date"><i class="fas fa-calendar-alt text-primary me-3"></i><strong class="text-secondary">Membership Date:</strong> {{ member.membership_date }}</li>
                </ul>
                <div class="mt-4" v-if="member.id_proof">
                  <h6 class="mb-2 fw-bold text-primary"><i class="fas fa-file-alt me-2"></i>ID Proof:</h6>
                  <a :href="`/storage/${member.id_proof}`" target="_blank" class="btn btn-outline-primary btn-sm rounded-pill px-3">View File</a>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer bg-light border-top p-4 rounded-bottom-3">
            <div class="alert alert-info mb-0" role="alert" v-if="member.status !== 'active'">
              <i class="fas fa-exclamation-circle me-2"></i> <strong>N.B.:</strong> Your account must be active for more features.
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
