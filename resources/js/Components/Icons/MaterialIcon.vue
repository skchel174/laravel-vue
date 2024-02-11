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
    class="material-icons text-slate-400 select-none"
    :class="{
      '!text-sky-600': active,
      'cursor-pointer hover:!text-sky-600/75 transition-[color] duration-300': clickable,
    }"
  >
    <slot/>
  </span>
</template>
