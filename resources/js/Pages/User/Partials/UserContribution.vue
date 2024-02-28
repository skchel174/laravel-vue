<script setup>
import {Link} from "@inertiajs/vue3";

const props = defineProps({
  contribution: {
    type: Array,
    required: true,
  },
});
</script>

<template>
  <div
    class="p-4 bg-white w-full lg:max-w-xs"
    v-if="contribution.length > 0"
  >
    <h2 class="text-sm text-gray-500 font-bold uppercase">
      {{ $trans('Topic contribution') }}
    </h2>

    <hr class="my-4 w-full bg-gray-200"/>

    <ul class="w-full">
      <li
        class="flex py-2 space-x-4"
        v-for="topic in contribution"
        :key="topic.id"
      >
        <Link :href="route('topic.articles', {topic: topic.slug})">
          <img
            class="w-8 h-8"
            :src="topic.icon"
            :alt="topic.slug"
          >
        </Link>

        <div class="flex-1 space-y-1.5">
          <div class="flex justify-between items-center text-sm font-bold">
            <Link :href="route('topic.articles', {topic: topic.slug})">
              {{ topic.name }}
            </Link>

            <span class="text-lime-600 font-normal">
              {{ topic.articles_count }}
            </span>
          </div>

          <div class="w-full h-0.5 bg-gray-200">
            <div
              class="h-full bg-lime-600"
              :style="`width: ${topic.articles_count * 100 / contribution[0].articles_count}%`"
            />
          </div>
        </div>
      </li>
    </ul>
  </div>
</template>
