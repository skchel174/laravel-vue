<script setup>
import {Link} from "@inertiajs/vue3";

const props = defineProps({
  topics: {
    type: Array,
    required: true,
  },
});

const calcProgress = (topic) => {
  return topic.articles_count * 100 / props.topics[0].articles_count;
};
</script>

<template>
  <ul class="w-full">
    <li
      class="flex py-2 space-x-4"
      v-for="topic in topics"
      :key="topic.id"
    >
      <Link href="#">
        <img
          class="w-8 h-8"
          :src="topic.icon"
          :alt="topic.slug"
        >
      </Link>

      <div class="flex-1 space-y-1.5">
        <div class="flex justify-between items-center text-sm font-bold">
          <Link href="#">
            {{ topic.name }}
          </Link>

          <span class="text-lime-600 font-normal">
            {{ topic.articles_count }}
          </span>
        </div>

        <div class="w-full h-0.5 bg-gray-200">
          <div
            class="h-full bg-lime-600"
            :style="`width: ${calcProgress(topic)}%`"
          />
        </div>
      </div>
    </li>
  </ul>
</template>
