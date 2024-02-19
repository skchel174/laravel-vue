<script setup>
import TopicsListItem from "@/Pages/User/Profile/Partials/TopicsListItem.vue";

defineProps({
  topics: {
    type: Array,
    required: true,
  },
});
</script>

<template>
  <div class="space-y-2">
    <h5 class="text-sm text-gray-700 font-bold">
      {{ $trans('Belongs to topics') }}
    </h5>

    <div
      v-if="topics.length > 0"
      class="flex flex-wrap"
    >
      <TopicsListItem
        v-for="topic in topics"
        :key="topic.id"
        :topic="topic"
      />
    </div>

    <div v-else class="text-sm text-gray-500">
      {{ $trans('No subscriptions') }}
    </div>
  </div>
</template>
