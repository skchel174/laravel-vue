<script setup>
import ProfileTopic from "@/Pages/Cabinet/Profile/Partials/ProfileTopic.vue";

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

    <div
      class="flex flex-wrap"
      v-if="topics.length > 0"
    >
      <ProfileTopic
        v-for="topic in topics"
        :key="topic"
        :topic="topic"
      />
    </div>

    <div
      class=" text-gray-400 font-medium"
      v-else
    >
      No topic subscriptions
    </div>
  </div>
</template>
