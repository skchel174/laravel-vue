<script setup>
defineProps({
  expand: {
    type: Boolean,
    required: true,
  }
});
</script>

<template>
  <button class="flex items-center">
    <slot/>

    <span
      class="material-icons ml-1 transition duration-200 !text-xl !leading-none"
      :class="{'rotate-180': expand}"
    >
      expand_more
    </span>
  </button>
</template>
