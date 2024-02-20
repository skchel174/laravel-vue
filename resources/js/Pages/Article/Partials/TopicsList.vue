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
  <div class="flex flex-wrap space-x-2 items-center">
    <span class="mr-1 text-sm sm:text-base font-semibold">
      {{ $trans('Topics') }}:
    </span>

    <Link
      class="text-sm sm:text-base font-medium text-sky-700/75 hover:text-sky-600 transition duration-200 after:content-[','] after:last:content-['']"
      v-for="topic in topics"
      :key="topic.id"
      :href="route('topic.articles', {topic: topic.slug})"
    >
      {{ topic.name }}
    </Link>
  </div>
</template>
