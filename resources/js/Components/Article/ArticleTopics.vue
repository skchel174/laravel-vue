<script setup>
import {Link} from "@inertiajs/vue3";

defineProps({
  topics: {
    type: Array,
    required: true,
  },
});
</script>

<template>
  <div class="flex flex-wrap">
    <Link
      class="mr-2 text-sm text-gray-500 font-medium hover:text-sky-700/75 transition after:content-[','] after:last:content-['']"
      v-for="topic in topics"
      :key="topic.id"
      :href="route('topic.articles', {topic: topic.slug})"
    >
      {{ topic.name }}
    </Link>
  </div>
</template>
