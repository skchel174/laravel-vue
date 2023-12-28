<script setup>
defineProps({
  commentsCount: {
    type: Number,
    required: true,
  },
});
</script>

<template>
  <button class="inline-flex items-center pt-[0.175rem] cursor-pointer">
    <span class="text-sky-600 text-base font-bold">
      Show comments ({{ commentsCount }})
    </span>
  </button>
</template>
