<script setup>
import AuthorsListItem from "@/Components/Author/AuthorsListItem.vue";
import Pagination from "@/Components/Pagination/Pagination.vue";
import nothingHere from 'img/nothing-here.svg';

defineProps({
  authors: {
    type: Object,
    required: true,
  },
});
</script>

<template>
  <div>
    <div
      v-if="authors.items.length > 0"
      class="space-y-4"
    >
      <div class="p-4 pt-1 lg:pt-2 bg-white">
        <div class="pt-2 pb-1 border-b border-gray-200 hidden lg:flex">
          <div class="flex-1 text-gray-600 text-sm capitalize">
            {{ $trans('Name') }}
          </div>

          <div class="max-w-10 text-sky-700/75 text-sm capitalize">
            {{ $trans('Contribution to topics') }}
          </div>
        </div>

        <AuthorsListItem
          class="mt-4"
          v-for="author in authors.items"
          :key="author.id"
          :author="author"
        />
      </div>

      <Pagination :items="authors"/>
    </div>

    <div v-else class="px-4 flex flex-col items-center justify-center">
      <img
        class="mt-10 w-64"
        :src="nothingHere"
        alt="nothing-here"
      />

      <p class="mt-4 text-sm text-gray-400 font-medium">
        {{ $trans('empty_request_result') }}
      </p>
    </div>
  </div>
</template>
