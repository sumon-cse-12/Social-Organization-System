<script setup>
import { defineProps, defineEmits } from 'vue'

const props = defineProps({
  title: { type: String, default: 'Confirm Delete' },
  message: { type: String, required: true },
  show: { type: Boolean, default: false },
  action: { type: Function, required: true }
})

const emit = defineEmits(['update:show'])

const close = () => emit('update:show', false)

const confirmAction = () => {
  if (typeof props.action === 'function') {
    props.action()
  } else {
    console.warn('ConfirmModal: action is not a function')
  }
  close()
}
</script>

<template>
  <div v-if="show" class="modal-backdrop">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{ title }}</h5>
          <button type="button" class="btn-close" @click="close"></button>
        </div>
        <div class="modal-body">
          <p>{{ message }}</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" @click="close">Cancel</button>
          <button type="button" class="btn btn-danger" @click="confirmAction">Confirm</button>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.modal-backdrop {
  position: fixed;
  inset: 0;
  background: rgba(0,0,0,0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1050;
}
.modal-dialog {
  background: white;
  border-radius: 8px;
  max-width: 500px;
  width: 100%;
}
.modal-content {
  padding: 1rem;
}
.modal-header, .modal-footer {
  display: flex;
  justify-content: space-between;
  align-items: center;
}
</style>
