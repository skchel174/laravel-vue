<script setup>
defineProps({
  selected: {
    type: Boolean,
    default: false,
  },
});
</script>

<template>
  <li
    class="relative space-x-4 flex justify-start items-center bg-white text-gray-700 font-medium hover:bg-sky-50 active:bg-sky-100 hover:text-sky-600 transition duration-300 cursor-pointer"
    :class="{'text-sky-600 before:absolute before:top-0 before:left-0 before:content-[\'\'] before:bg-sky-600 before:h-full before:w-0.5': selected}"
  >
    <slot/>
  </li>
</template>
