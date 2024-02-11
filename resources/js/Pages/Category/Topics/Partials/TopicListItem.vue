<script setup>
import {Link} from "@inertiajs/vue3";

defineProps({
  topic: {
    type: Object,
    required: true,
  },
});
</script>

<template>
  <div class="flex mt-4">
    <div class="flex-1 flex space-x-3">
      <img
        class="w-12 h-12"
        :src="topic.icon"
        :alt="topic.slug"
      >

      <div class="space-y-1.5">
        <!-- TODO: add topic link -->
        <Link
          class="text-base text-gray-700 font-medium cursor-pointer hover:text-sky-700/75 transition duration-300"
          href="#"
        >
          {{ topic.name }}
        </Link>

        <p class="text-sm text-gray-500/75">
          {{ topic.description }}
        </p>

        <div
          class="flex flex-wrap"
          v-if="topic.tags.length > 0"
        >
          <!-- TODO: add link for tag -->
          <Link
            class="mr-1 text-sm text-sky-700/75 leading-4 after:content-[','] after:last:content-['']"
            v-for="tag in topic.tags"
            :key="tag.id"
            href="#"
          >
            {{ tag.name }}
          </Link>
        </div>
      </div>
    </div>

    <div class="min-w-[8rem] flex justify-end">
      <span class="text-pink-600/75 text-base">
        {{ $formatCount(topic.articles_count) }}
      </span>
    </div>

    <div class="min-w-[8rem] flex justify-end">
      <span class="text-gray-500/75 text-base">
        {{ $formatCount(topic.subscribers_count) }}
      </span>
    </div>
  </div>
</template>
