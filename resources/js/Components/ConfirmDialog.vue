
<script setup>
import { ref, watch } from 'vue'

const emit = defineEmits(['confirm', 'cancel', 'update:modelValue'])



const props = defineProps({
  title: String,
  message: String,
  modelValue: Boolean,
})

const isOpen = ref(props.modelValue)

watch(() => props.modelValue, (val) => {
  isOpen.value = val
})




function cancel() {
  emit('update:modelValue', false)
  emit('cancel')
}

function confirm() {
  emit('update:modelValue', false)
  emit('confirm')
}
</script>



<template>
    <dialog ref="dialog" class="modal" :open="isOpen">
      <div class="modal-box">
        <h3 class="font-bold text-lg text-error">{{ title }}</h3>
        <p class="py-2">{{ message }}</p>
        <div class="modal-action">
          <button class="btn btn-sm btn-outline" @click="cancel">Cancel</button>
          <button class="btn btn-sm btn-error  text-white" @click="confirm">Yes, Delete</button>
        </div>
      </div>
      <div class="modal-backdrop" @click="cancel"></div>
    </dialog>
  </template>
  