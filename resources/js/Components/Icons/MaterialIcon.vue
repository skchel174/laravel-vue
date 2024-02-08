<script setup>
defineProps({
  active: {
    type: Boolean,
    default: false,
  },

  clickable: {
    type: Boolean,
    default: false,
  },
});
</script>

<template>
  <span
    class="material-icons text-slate-400"
    :class="{
      '!text-sky-600': active,
      'cursor-pointer hover:!text-sky-700 transition-[color] duration-300': clickable,
    }"
  >
    <slot/>
  </span>
</template>
