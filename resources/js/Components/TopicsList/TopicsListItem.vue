<script setup>
import {Link} from "@inertiajs/vue3";
import MaterialIcon from "@/Components/Icons/MaterialIcon.vue";

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
        <Link
          class="text-base text-gray-700 font-medium cursor-pointer hover:text-sky-775 transition duration-300"
          :href="route('topic.articles', {topic: topic.slug})"
        >
          {{ topic.name }}
        </Link>

        <p class="text-sm text-gray-500/75">
          {{ topic.description }}
        </p>

        <div
          class="hidden lg:flex flex-wrap"
          v-if="topic.tags.length > 0"
        >
          <!-- TODO: add link for tag -->
          <Link
            class="mr-1 text-sm text-sky-675 leading-4 after:content-[','] after:last:content-['']"
            v-for="tag in topic.tags"
            :key="tag.id"
            href="#"
          >
            {{ tag.name }}
          </Link>
        </div>

        <div class="flex lg:hidden items-center space-x-6">
          <div class="flex items-center space-x-2.5">
            <MaterialIcon class="!text-xl text-gray-475">
              article
            </MaterialIcon>

            <span class="text-pink-600/75 text-base">
              {{ $formatCount(topic.articles_count) }}
            </span>
          </div>

          <div class="flex items-center space-x-2.5">
            <MaterialIcon class="!text-xl text-gray-475">
              people
            </MaterialIcon>

            <span class="text-gray-475 text-base">
              {{ $formatCount(topic.subscribers_count) }}
            </span>
          </div>
        </div>
      </div>
    </div>

    <div class="min-w-[8rem] hidden lg:flex justify-end">
      <span class="text-pink-600/75 text-base">
        {{ $formatCount(topic.articles_count) }}
      </span>
    </div>

    <div class="min-w-[8rem] hidden lg:flex justify-end">
      <span class="text-gray-500/75 text-base">
        {{ $formatCount(topic.subscribers_count) }}
      </span>
    </div>
  </div>
</template>
