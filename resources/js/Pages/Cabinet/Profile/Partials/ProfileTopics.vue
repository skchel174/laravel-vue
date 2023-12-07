<script setup>
defineProps({
  topics: {
    type: Array,
    required: true,
  },
});
</script>

<template>
  <div>
    <h5 class="mb-2 text-sm text-gray-700 font-bold">
      Belongs to topics
    </h5>

    <div class="flex flex-wrap">
      <div
        class="mb-2 mr-2 px-2 py-0.5 bg-lime-500/60 rounded-sm text-sm text-gray-500 font-medium cursor-pointer hover:text-sky-600 transition duration-400"
        v-for="topic in topics"
        :key="topic"
      >
        {{ topic }}
      </div>
    </div>
  </div>
</template>
