<script setup>
import Divider from "@/Components/Divider.vue";

defineProps({
  title: {
    type: String,
    required: true,
  },
});
</script>

<template>
  <div class="p-4 bg-white w-full lg:max-w-xs">
    <h2 class="text-sm text-gray-500 font-bold uppercase">
      {{ $trans(title) }}
    </h2>

    <Divider class="my-4"/>

    <ul class="w-full">
      <slot/>
    </ul>
  </div>
</template>
