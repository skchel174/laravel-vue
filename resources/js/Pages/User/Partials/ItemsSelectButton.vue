<script setup>
defineProps({
  open: {
    type: Boolean,
    required: true,
  },

  currentItem: {
    type: String,
    required: true,
  },
});
</script>

<template>
  <button class="flex items-center text-sm text-gray-400 font-semibold capitalize cursor-pointer select-none">
    <span>
      {{ currentItem }}
    </span>

    <span
      class="material-icons transition duration-200 !text-[1.25rem]"
      :class="{'rotate-180': open}"
    >
      expand_more
    </span>
  </button>
</template>
