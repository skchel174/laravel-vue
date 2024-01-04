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
    class="py-2 z-10 flex justify-center items-center cursor-pointer text-gray-400 text-sm font-bold uppercase select-none border-b-2 border-transparent"
    :class="{['border-b-2 !border-sky-600 text-sky-600']: selected}"
  >
    <slot/>
  </div>
</template>
