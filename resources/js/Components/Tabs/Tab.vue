<script setup>
defineProps({
  selected: {
    type: Boolean,
    default: false,
  },
});
</script>

<template>
  <div
    class="py-2 z-10 flex justify-center items-center cursor-pointer text-gray-500/75 text-sm font-semibold uppercase select-none border-b-2 border-transparent"
    :class="{['border-b-2 !border-sky-700/75 text-sky-700/75']: selected}"
  >
    <slot/>
  </div>
</template>
