<script setup>
defineProps({
  name: {
    type: String,
    required: true,
  },
});
</script>

<template>
  <span class="material-icons select-none">
    {{ name }}
  </span>
</template>
