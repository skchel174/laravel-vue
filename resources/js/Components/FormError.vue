<script setup>
defineProps({
  message: {
    type: String,
  },
});
</script>

<template>
  <p
    v-show="message"
    class="block text-sm text-danger"
  >
    {{ message }}
  </p>
</template>
