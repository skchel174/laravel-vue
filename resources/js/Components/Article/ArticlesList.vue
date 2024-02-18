<script setup>
import ArticlesListItem from "@/Components/Article/ArticlesListItem.vue";
import Pagination from "@/Components/Pagination/Pagination.vue";
import nothingHere from 'img/nothing-here.svg';

const props = defineProps({
  articles: {
    type: Object,
    required: true,
  },
});
</script>

<template>
  <div>
    <div
      class="space-y-4"
      v-if="articles.items.length > 0"
    >
      <ArticlesListItem
        v-for="article in articles.items"
        :key="article.id"
        :article="article"
      />

      <Pagination :items="articles"/>
    </div>

    <div
      v-else
      class="px-4 flex flex-col items-center justify-center space-y-4"
    >
      <img
        class="mt-10 w-64"
        :src="nothingHere"
        alt="nothing-here"
      />

      <p class="text-sm text-gray-400 font-medium">
        {{ $trans('empty_articles') }}
      </p>
    </div>
  </div>
</template>
