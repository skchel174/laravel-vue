<script setup>
defineProps({
  heading: {
    type: String,
    required: true,
  },
});
</script>

<template>
  <div class="space-y-2">
    <h3 class="text-sm text-gray-700 font-semibold">
      {{ $trans(heading) }}
    </h3>

    <slot/>
  </div>
</template>
