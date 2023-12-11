<script setup>
import {ref} from "vue";
import ProfileTopic from "@/Pages/Cabinet/Profile/Partials/ProfileTopic.vue";

const props = defineProps({
  topics: {
    type: Array,
    required: true,
  },
});

const topics = ref(props.topics);

const unsubscribe = (topic) => {
  topics.value.splice(topics.value.findIndex(item => item.id === topic.id), 1);
  axios.delete(route('api.topics.subscription', {topic: topic.id}));
};
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
        @unsubscribe="unsubscribe"
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
